<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_order extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('product_m');
    $this->load->model('order_m');
    $this->load->model('member_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		alert("/");
  }


	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보
		
		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트

		/* 카테고리 데이터 start */
		$cate_no = $this->input->get("cate_no");
		if($cate_no){
			$cate_no1 = explode("-",$cate_no);
			$cate_no1 = $cate_no1[0]; //1차카테고리

			$data['cate_list'] = $this->common_m->getList2("dh_category","where display=1 and depth=2 and cate_no like '".$cate_no1."-%'");
			$data['cate_stat1'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no1' and depth=1"); //1차 카테고리 정보
			$data['cate_stat'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no'"); //현재 카테고리 정보
		}
		/* 카테고리 데이터 end */


		/* 브랜드 카테고리 데이터 start */
		$brand_no = $this->input->get("brand_no");
		$data['brand_no'] = $brand_no;
		if($brand_no){
			$data['cate_stat'] = $this->common_m->getRow("dh_brand_cate","where idx='$brand_no'"); //현재 카테고리 정보
			$data['brand_list'] = $this->common_m->getList2("dh_brand_cate","where display=1 and level=1 order by sort");
		}
		/* 브랜드 카테고리 데이터 end */

		$this->{"{$method}"}($data);

		if(!$this->session->userdata('CART')){ //장바구니 카트 no 생성
			$this->common_m->cart_init();
		}
	}


	public function shop_order($data='')
	{

		$a_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);
		$goods_idx = $this->input->post("goods_idx");
		$code = $this->session->userdata('CART');
		$data['cart_code'] = $code;

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$where_query = " and c.trade_ok=0 ";
		$USERID = $this->session->userdata('USERID');


		$view = "order";
		if($goods_idx){ //바로구매
			$result = $this->order_m->cart($goods_idx,$code,1);
			$a_idx = $result['a_idx'];

			if(!$this->session->userdata('USERID')){ //비로그인시 로그인/비로그인 선택화면으로
				alert(cdir()."/dh_order/order_login/shop/".$a_idx);
				exit;
			}else{
				alert(cdir()."/dh_order/shop_order/".$a_idx);
			}
		}else if($a_idx){

			$a_idx_arr = explode("a",$a_idx);
			if(count($a_idx_arr)==1){
				$where_query .= " and c.idx='".$this->db->escape_str($a_idx)."'";
			}else if(count($a_idx_arr) > 1){

				$where_query .= " and (";
				for($i=0;$i<count($a_idx_arr);$i++){
					if($i>0){
						$where_query .= " or ";
					}

					$where_query .= " c.idx='".$a_idx_arr[$i]."' ";
				}
				$where_query .= " )";
			}
		}

		if($this->input->get("nologin",true)=="" && !$this->session->userdata('USERID')){//비로그인시 로그인/비로그인 선택화면으로
			alert(cdir()."/dh_order/order_login/shop/".$a_idx);
			exit;
		}

		$data['query_string']="?";
		if($this->input->get("nologin")){ $data['query_string'].="&nologin=".$this->input->get("nologin"); }

		mt_srand((double)microtime()*1000000);
		$TRADE_CODE=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=time();
		$data['TRADE_CODE'] = $TRADE_CODE;


		$query = str_replace("c.","",$where_query);

		$tmp="";

		if($this->input->post("trade_code") && $this->input->post("name") && $this->input->post("tmp")==1 && !$this->input->post("tno") && $this->input->post("cart_code")){
			$tmp = 1;
			$code =  $this->input->post("cart_code",true);
		}

		$result = $this->order_m->getCart($code,$query);

		$data['cart_list'] = $result['list'];
		foreach($data['cart_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}

		if($USERID){
			$where_query .= " and c.userid='$USERID'";
		}else{
			$where_query .= " and c.code='".$this->db->escape_str($code)."'";
		}

		$data['totalPrice'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.total_price","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
		$data['totalPoint'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.goods_point","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
		$data['totalCnt'] = $this->common_m->getCount("dh_cart c, dh_goods g","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");

		$data['shop_info'] = $this->common_m->shop_info();

		if($data['totalCnt']==0){
			back('선택된 상품이 존재하지 않습니다.\n처음부터 다시 주문해주세요.');
			exit;
		}

		//배송비 구하기
		$basic=0;
		if($data['totalCnt']==1){ //단일상품일때 상품정책
			if($a_idx){
				$where =" and c.idx='".$this->db->escape_str($a_idx)."'";
			}else{

				if($USERID){
					$where = " and c.userid='$USERID'";
				}else{
					$where = " and c.code='".$this->db->escape_str($code)."'";
				}
			}
			$cart_stat = $this->common_m->getRow3("dh_cart c, dh_goods g","where c.goods_idx=g.idx $where","g.express_no_basic,g.express_check,g.express_money,g.express_free");

			if($cart_stat->express_no_basic==1){ //배송 기본정책 미사용
				if($cart_stat->express_check==1){ //일반배송 일때
					if($data['totalPrice'] >= $cart_stat->express_free){ //총 구매액이 지정한도 이상이면 무료배송
						$data['delivery_price'] = 0;
					}else{
						$data['delivery_price'] = $cart_stat->express_money;
					}
				}else{ //무료배송 일때
					$data['delivery_price'] = 0;
				}
			}else{
				$basic=1;
			}

		}
		if($data['totalCnt']>1 || $basic==1){//한개 이상일때 기본정책
			if($data['shop_info']['express_check']==1){ //일반배송 일때
				if($data['totalPrice'] >= $data['shop_info']['express_free']){ //총 구매액이 지정한도 이상이면 무료배송
					$data['delivery_price'] = 0;
				}else{
					$data['delivery_price'] = $data['shop_info']['express_money'];
				}
			}else{ //무료배송 일때
				$data['delivery_price'] = 0;
			}
		}


		if($this->session->userdata('USERID')){
			$data['userid'] = $this->session->userdata('USERID');
			$data['member_stat'] = $this->common_m->getRow("dh_member","where userid='".$this->db->escape_str($data['userid'])."'");
			$data['member_total_point'] = $this->common_m->getSum("dh_point","point","where userid='".$this->db->escape_str($data['userid'])."'");
			$nowdate = date("Y-m-d");
			$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where userid='".$data['userid']."' and start_date <= '$nowdate' and end_date >= '$nowdate' and trade_code = ''");
			$data['couponList'] = $this->common_m->getList2("dh_coupon_use","where userid='".$data['userid']."' and start_date <= '$nowdate' and end_date >= '$nowdate' and trade_code = '' order by idx desc");
		}

		$data['bank_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'bank_name%'","idx"); //입금은행 총갯수
		$data['a_idx'] = $a_idx;

		$trade_code = $this->input->post("trade_code",true);


		if($tmp==1){ //tmp 넣기
			$result = $this->order_m->trade_tmp_add($trade_code,$data); //tmp에 넣기
			exit;
		}


		if($this->input->post("ordr_idxx") || $this->input->post("trade_code")){ //결제완료 검증 모델 로드 & 데이터 넣기

			$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx"); //거래 완료 디비에 값이 없는경우에만 새로 등록

			if($trade_cnt==0){
				$result = $this->order_m->trade($trade_code,$data); //실제데이터넣기
				result($result, "", cdir()."/dh_order/shop_order_ok/".$trade_code);
			}else{
				alert(cdir()."/dh_order/shop_order_ok/".$trade_code);
			}

		}else{

		$data['payView']=$data['shop_info']['pg_company'];

		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);


		if($this->input->post("pay_ajax")==1){
			$url = "/order/".$data['payView']."_ajax";
		}

		$this->load->view($url,$data);

		}

	}


	public function shop_cart($data='')
	{

		$cart_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";

		$view = "cart";

		$mode = $this->input->post("mode");
		$goods_idx = $this->input->post("goods_idx");
		$code = $this->session->userdata('CART');
		$USERID = $this->session->userdata('USERID');
		$query_where = "";

		if($USERID){
			$query_where = " and userid='$USERID'";
		}else{
			$query_where = " and code='".$this->db->escape_str($code)."'";
		}


		if($mode=="del"){
			$result = $this->common_m->del("dh_cart","idx", $this->input->post("cart_idx",true));
			$result = $this->common_m->del("dh_cart_option","cart_idx", $this->input->post("cart_idx",true));
			alert(cdir().'/dh_order/shop_cart');
		}else if($mode=="allDel"){
			$frmCnt = $this->input->post("frmCnt");
			for($i=1;$i<=$frmCnt;$i++){
				if($this->input->post("idx".$i) && $this->input->post("chk".$i)==1){
					$result = $this->common_m->del("dh_cart","idx", $this->input->post("idx".$i,true));
					$result = $this->common_m->del("dh_cart_option","cart_idx", $this->input->post("idx".$i,true));
				}
			}
			alert(cdir().'/dh_order/shop_cart');

		}else if($cart_idx){
			$result = $this->order_m->cartMove($cart_idx,'wish','cart');
			alert(cdir().'/dh_order/shop_cart');
			exit;
		}else	if($goods_idx){
			$result = $this->order_m->cart($goods_idx,$code);
			alert(cdir().'/dh_order/shop_cart');
		}

		$result = $this->order_m->getCart($code);

		$data['list'] = $result['list'];
		foreach($data['list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}

		if($USERID){
			$where_query = " and c.userid='$USERID'";
		}else{
			$where_query = " and c.code='".$this->db->escape_str($code)."'";
		}


		$data['totalPrice'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.total_price","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
		$data['totalPoint'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.goods_point","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
		$data['totalCnt'] = $this->common_m->getCount("dh_cart c, dh_goods g","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
		$data['shop_info'] = $this->common_m->shop_info();


		//배송비 구하기
		$basic=0;
		if($data['totalCnt']==1){ //단일상품일때 상품정책

			if($USERID){
				$query_where = " and c.userid='$USERID'";
			}else{
				$query_where = " and c.code='".$this->db->escape_str($code)."'";
			}

			$cart_stat = $this->common_m->getRow3("dh_cart c, dh_goods g","where c.goods_idx=g.idx $query_where","g.express_no_basic,g.express_check,g.express_money,g.express_free");

			if($cart_stat->express_no_basic==1){ //배송 기본정책 미사용
				if($cart_stat->express_check==1){ //일반배송 일때
					if($data['totalPrice'] >= $cart_stat->express_free){ //총 구매액이 지정한도 이상이면 무료배송
						$data['delivery_price'] = 0;
					}else{
						$data['delivery_price'] = $cart_stat->express_money;
					}
				}else{ //무료배송 일때
					$data['delivery_price'] = 0;
				}
			}else{
				$basic=1;
			}
		}

		if($data['totalCnt']>1 || $basic==1){ //한개 이상일때 or 제품 기본정책 사용일때
			if($data['shop_info']['express_check']==1){ //일반배송 일때
				if($data['totalPrice'] >= $data['shop_info']['express_free']){ //총 구매액이 지정한도 이상이면 무료배송
					$data['delivery_price'] = 0;
				}else{
					if(!$data['shop_info']['express_money']){ $data['shop_info']['express_money'] = 0; }
					$data['delivery_price'] = $data['shop_info']['express_money'];
				}
			}else{ //무료배송 일때
				$data['delivery_price'] = 0;
			}
		}


		if($data['totalCnt']==0){ $data['delivery_price'] = 0;}


		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}


	public function wishlist($data='')
	{
		$cart_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);


		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";

		$view = "cart";

		$mode = $this->input->post("mode");
		$goods_idx = $this->input->post("goods_idx");


		$userid = $this->session->userdata('USERID');
		if(!$userid){
			alert(cdir().'/dh_order/order_login/wishlist/'.$goods_idx,'로그인이 필요합니다.');
			exit;
		}


		if($mode=="del"){
			$result = $this->common_m->del("dh_wishlist","idx", $this->input->post("wishlist_idx",true));
			$result = $this->common_m->del("dh_wishlist_option","wishlist_idx", $this->input->post("wishlist_idx",true));
			alert(cdir().'/dh_order/wishlist');
		}else if($mode=="allDel"){
			$frmCnt = $this->input->post("frmCnt");
			for($i=1;$i<=$frmCnt;$i++){
				if($this->input->post("idx".$i) && $this->input->post("chk".$i)==1){
					$result = $this->common_m->del("dh_wishlist","idx", $this->input->post("idx".$i,true));
					$result = $this->common_m->del("dh_wishlist_option","wishlist_idx", $this->input->post("idx".$i,true));
				}
			}
			alert(cdir().'/dh_order/wishlist');

		}else	if($goods_idx){
			$result = $this->order_m->cart($goods_idx,'','','wish');
			alert(cdir().'/dh_order/wishlist');
		}else if($cart_idx){
			$result = $this->order_m->cartMove($cart_idx,'cart','wish');
			alert(cdir().'/dh_order/wishlist');
			exit;
		}

		$result = $this->order_m->getCart('','','wish',$userid);

		$data['list'] = $result['list'];
		foreach($data['list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}


		$view = "wishlist";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}



	public function order_login($data='')
	{
		$mode=$this->uri->segment(3,'');
		$idx=$this->uri->segment(4,'');
		$idx_arr = explode("a",$idx);

		if($mode=="shop"){
			$data['go_url'] = cdir()."/dh_order/shop_order/".$idx;
			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
			$view = "order_login";
		}else if($mode=="wishlist"){
			$data['go_url'] = cdir()."/dh_order/wishlist/".$idx;
			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
			$view = "login";
		}

		$data['view'] = $dir.$view;
		$this->load->view('/html/login', $data);

	}


	public function shop_order_ok($data='')
	{
		$page=$this->uri->segment(2,'');
		$trade_code=$this->uri->segment(3,'');
		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx");
		if($trade_cnt > 0){

		$data['trade_code'] = $trade_code;
		$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."' order by idx desc limit 1");

		$result = $this->order_m->getTradeOption($trade_code);
		$data['goods_list'] = $result['goods_list'];
		foreach($data['goods_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}

		if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
			$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
		}

		$view="order_ok";

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

		}else{
			back("잘못된 접근입니다.");
		}

	}


	public function pay_error($data='')
	{
		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir."order_error";
		$this->load->view("/html/shop_order_error",$data);
	}


	public function orderList($data='')
	{
		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			exit;
		}

		$page=$this->uri->segment(2,'');
		$return=$this->uri->segment(3,'order');
		$search_day = $this->input->get("search_day");

		$userid = $this->session->userdata('USERID');
		$where_query=" where userid='$userid'";

		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		if($return=="return"){
			$where_query .= " and trade_stat > 4";
		}else{
			$where_query .= " and trade_stat < 5";
		}

		switch($search_day)
		{
			case 1 : $date = date("Y-m-d",strtotime("-15 day",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 2 : $date = date("Y-m-d",strtotime("-1 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 3 : $date = date("Y-m-d",strtotime("-3 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 4 : $date = date("Y-m-d",strtotime("-3 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day < '".$date."'"; break;
			default : $date=""; break;
		}

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page."/".$return;
		$data['totalCnt'] = $this->common_m->getPageList('dh_trade','count','','',$where_query,$order_query); //게시판 리스트
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_trade','',$offset,$list_num,$where_query,$order_query,"*,(select count(idx) from dh_trade_goods where trade_code=dh_trade.trade_code) as cnt,(select goods_name from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as goods_name,(select goods_idx from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as goods_idx,(select idx from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as trade_goods_idx,(select review from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as review"); //게시판 리스트

		/* 제품 데이터 end */


		$view=$return."_list";

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}


	public function shop_order_detail($data='')
	{
		$page=$this->uri->segment(2,'');
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$trade_code=$this->uri->segment(3,'');
		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx");
		if($trade_cnt > 0){

		if(!$this->session->userdata('USERID')){
			if(!$this->input->post('trade_code') && !$this->input->post('email')){
				back("잘못된 접근입니다.");
				exit;
			}

			$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($this->input->post('trade_code',true))."' and email='".$this->db->escape_str($this->input->post('email',true))."'","idx");
			if($trade_cnt==0){
				back("존재하지 않는 주문코드 또는 이메일 입니다.\\n 다시한번 확인해주세요.");
				exit;
			}
		}

		$data['trade_code'] = $trade_code;
		$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."' order by idx desc limit 1");

		if($data['trade_stat']->delivery_idx){
			$data['delivery_row'] = $this->common_m->getRow("dh_shop_info","where name = 'delivery_idx".$data['trade_stat']->delivery_idx."' and val!=''");
			$delivery_name_no = str_replace("delivery_idx","",$data['delivery_row']->name);
			$data['delivery_url_row'] = $this->common_m->getRow("dh_shop_info","where name='delivery_url".$delivery_name_no."'");
		}

		$result = $this->order_m->getTradeOption($trade_code);
		$data['goods_list'] = $result['goods_list'];
		foreach($data['goods_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}

		if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
			$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
		}

		$data['day7'] = date("Y-m-d",strtotime("+7 day",strtotime($data['trade_stat']->delivery_day)));

		$view="order_view";

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}


	}


	public function shop_order_cancel($data='')
	{
		$trade_code=$this->uri->segment(3,'');
		$mode=$this->uri->segment(4,'list');
		$query_string="?";
		$result="";

		$param = "";
		if($this->input->get("PageNumber")){
			$param = "&PageNumber=".$this->input->get("PageNumber");
		}



		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
		if($trade_cnt > 0){
			$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'");

			$flag = explode("a1a1",$this->input->post("go_url"));

			if(isset($flag[1]) && $flag[1]){
			$flag = $flag[1];
			$adminPage = explode("&PageNumber=",$this->input->post("go_url"));
			if(isset($adminPage[1]) && $adminPage[1]){
				$adminPage = $adminPage[1];
			}else{
				$adminPage = 1;
			}
			}else{
				$flag = "";
			}

			if($trade_stat->userid && ($trade_stat->userid != $this->session->userdata('USERID')) && $flag!="admin"){
				alert('/','잘못된 접근입니다.');
				exit;
			}


			if( ($trade_stat->trade_method==1 && $trade_stat->trade_stat==2) || ( $trade_stat->trade_method==4  && $trade_stat->trade_stat==1 ) || ($trade_stat->trade_method==1 && $flag=="admin")){ //카드 결제 or 가상계좌 일때

				$result = $this->order_m->{$data['shop_info']['pg_company']."_cancel"}($trade_code);

				if($flag=="admin" && $result){
					alert(cdir()."/order/lists/".$trade_stat->trade_stat."/m/?PageNumber=".$adminPage."&change_idx=".$trade_stat->idx."&change_stat=9&admin=1");
					exit;
				}

			}else if($trade_stat->trade_method==2 && $trade_stat->trade_stat==1){
				$result = 1;
			}

			if($result){


				$result2 = $this->common_m->update2("dh_trade",array('trade_stat'=>9),array("trade_code"=>$trade_code));

				if($result2){
					if($trade_stat->userid && $trade_stat->use_point > 0){ //포인트 사용했다면 다시 되돌리기
						$content = "상품구매사용 주문취소";
						$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->use_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
						$this->member_m->point_insert($arrays);
					}

					if($trade_stat->trade_stat==4 && $trade_stat->userid && $trade_stat->save_point > 0){ //포인트 적립되었다면 포인트 차감	-
						$content = "상품구매적립 주문취소";
						$arrays = array('userid'=>$trade_stat->userid,'point'=>'-'.$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
						$this->member_m->point_insert($arrays);
					}


					if($trade_stat->userid && $trade_stat->coupon_idx > 0){ //쿠폰 되돌리기
						$this->common_m->update2("dh_coupon_use",array('trade_code' => '','use_date' => ''),array('idx' => $trade_stat->coupon_idx));
					}

					/* 상품재고 돌리기 start */
					$trade_goods_result = $this->common_m->getList2("dh_trade_goods","where trade_code='".$trade_code."'");

					foreach($trade_goods_result as $goods){
						$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$goods->goods_idx."'");
						$this->common_m->update2("dh_goods",array('number'=>$goods_stat->number+1),array('idx'=>$goods->goods_idx,'unlimit'=>0));

						$trade_goods_option_result = $this->common_m->getList2("dh_trade_goods_option","where goods_idx='".$goods->goods_idx."' and trade_code='".$trade_code."' and level=2");
						foreach($trade_goods_option_result as $option){

							$goods_option_row = $this->common_m->getRow2("dh_goods_option","where idx='".$option->option_idx."'");
							$this->common_m->update2("dh_goods_option",array('number'=>$goods_option_row->number+1),array('idx'=>$option->option_idx));
						}
					}
					/* 상품재고 돌리기 end */

				}


				if($mode=="list"){
					result($result2, "주문이 취소", cdir()."/dh_order/orderList/".$query_string.$param);
				}else if($mode=="detail"){
					result($result2, "주문이 취소", cdir()."/dh_order/shop_order_detail/".$trade_code."/".$query_string.$param);
				}else if($flag=="admin"){
					result($result2, "주문이 취소", cdir()."/dh_order/orderList/".$query_string.$param);
				}

			}else{
				if($mode=="list"){
					alert(cdir()."/dh_order/orderList/".$query_string.$param,"잘못된 접근입니다.");
				}else if($mode=="detail"){
					alert(cdir()."/dh_order/shop_order_detail/".$trade_code."/".$query_string.$param,"잘못된 접근입니다.");
				}
				exit;
			}

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}
	}


	public function shop_order_return($data=''){

		$page=$this->uri->segment(2,'');

		$trade_code=$this->uri->segment(3,'');
		$change_trade_stat=$this->uri->segment(4,5);
		$data['change_trade_stat'] = $change_trade_stat;

		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
		if($trade_cnt > 0){

		$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'");

		if($trade_stat->userid && $trade_stat->userid != $this->session->userdata('USERID')){
			alert('/','잘못된 접근입니다.');
			exit;
		}

		$data['trade_code'] = $trade_code;
		$data['trade_stat'] = $trade_stat;

		$result = $this->order_m->getTradeOption($trade_code);
		$data['goods_list'] = $result['goods_list'];
		foreach($data['goods_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}


		$trade_name = str_replace("신청","",$data['shop_info']['trade_stat'.$change_trade_stat]);
		$data['trade_name'] = $trade_name;
		$day7 = date("Y-m-d",strtotime("+7 day",strtotime($trade_stat->delivery_day)));
		if( ( $change_trade_stat!=10 && $trade_stat->trade_stat==4 && $trade_stat->delivery_day!="0000-00-00 00:00:00" && $day7 >= date("Y-m-d")) || ($change_trade_stat == 10 && $trade_stat->trade_stat < 3 )){

			if($this->input->post("trade_stat") && $this->input->post("return_reason")){

				$result = $this->db->update("dh_trade",array('trade_stat'=>$this->input->post("trade_stat",true),'return_prod'=>$this->input->post("return_prod",true),'return_reason'=>$this->input->post("return_reason",true),'return_etc'=>$this->input->post("return_etc",true),'trade_day_cancel_req'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx));

				result($result, $trade_name."신청이 완료", cdir()."/dh_order/orderList/return/");
				exit;

			}else{

				if($change_trade_stat=="10"){

					$view="cancel_write";

				}else{

					$view="return_write";

				}

				$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
				$data['view'] = $dir.$view;
				$url = $this->common_m->get_page($page);
				$this->load->view($url,$data);

			}


		}else{
			back("교환/반품/취소 신청을 할수 있는 주문이 아닙니다.");
			exit;
		}

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}

	}


	public function point($data=''){

		$page=$this->uri->segment(2,'');
		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			exit;
		}
		$userid = $this->session->userdata('USERID');

		$where_query = "where userid='".$this->db->escape_str($userid)."'";

		$data['mem_row']=$this->common_m->getRow("dh_member",$where_query);
		$data['total_point'] = $this->common_m->getSum("dh_point","point", $where_query);
		$data['use_point'] = $this->common_m->getSum("dh_point","point", $where_query." and point < 0");
		$data['sum_point'] = $this->common_m->getSum("dh_point","point", $where_query." and point > 0");

		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page;
		$data['totalCnt'] = $this->common_m->getPageList('dh_point','count','','',$where_query,$order_query); //총개수
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_point','',$offset,$list_num,$where_query,$order_query); //리스트


		$view="point";

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

	}

	public function coupon($data=''){

		$page=$this->uri->segment(2,'');

		if($this->input->get("ajax")==1 && $this->input->get("coupon_idx")){
			$couponRow = $this->common_m->getRow("dh_coupon_use","where idx='".$this->input->get("coupon_idx",true)."'");
			echo $couponRow->type."/".$couponRow->discount_flag."/".$couponRow->price;
			exit;
		}


		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			exit;
		}
		$userid = $this->session->userdata('USERID');

		$nowdate = date("Y-m-d");

		$where_query = "where userid='".$this->db->escape_str($userid)."'";
		$where_query.= " and start_date <= '$nowdate' and end_date >= '$nowdate'";
		$where_query.= " and trade_code = ''";
		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page;
		$data['totalCnt'] = $this->common_m->getPageList('dh_coupon_use','count','','',$where_query,$order_query); //총개수
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_coupon_use','',$offset,$list_num,$where_query,$order_query); //리스트


		$view="coupon";

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

	}


	public function couponGive($data='')
	{
		$code = $this->uri->segment(3);
		$admin = $this->uri->segment(5,'');
		$row = $this->common_m->getRow("dh_coupon","where code='".$this->db->escape_str($code)."'");

		if($admin==1 && $this->session->userdata('ADMIN_USERID')){
			$row->userid = $this->uri->segment(4);
			$memrow = $this->common_m->getRow("dh_member","where userid='".$row->userid."'");

		}else{
			if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
				//alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
				back('로그인이 필요합니다.');
				exit;
			}
		}

		if($code && $row->code){

			$result = $this->order_m->couponGive($row,$admin);

			if($result){
				if($admin==1 && $this->session->userdata('ADMIN_USERID')){
					alert(cdir()."/member/coupon/".$memrow->idx."/?ajax=1","쿠폰이 발급되었습니다.");
				}else{
					back("쿠폰이 발급되었습니다.");
				}
			}else{
				back("쿠폰발급에 실패했습니다.\\n다시 시도하여 주세요.");
			}

		}else{
			back('잘못된 쿠폰번호입니다.');
			exit;
		}

	}


	public function inicis_post($data='')
	{
		$mode = $this->input->post("mode",true);
		$data['mode'] = $mode;

		$return_data = $this->order_m->inicis_post($data);
		echo $return_data;
	}



	public function vacctinput($data='') //이니시스 공통통보 페이지
	{
		$result = $this->order_m->vacctinput();

		echo $result;
	}

	
	
	public function vacctinput_m($data='') //이니시스 공통통보 페이지 (모바일 noti)
	{
		$result = $this->order_m->vacctinput_m();

		echo $result;
	}


	public function common_return($data='') //kcp 공통통보 페이지
	{
		$result = $this->order_m->kcp_result();
		echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
	}
}
