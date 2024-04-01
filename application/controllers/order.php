<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('product_m');
    $this->load->model('order_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}

	public function index() //첫 화면 로딩시 로그인 화면 출력.
	{
			$this->login();
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);

		if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){
			alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
		}

		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우

				$data['admin'] = $this->common_m->getRow("dh_admin_user","where userid='".$this->session->userdata('ADMIN_USERID')."'"); //접속한 user 정보
				$data['menu']  = $this->admin_m->menu(); //메뉴 갖고오기
				$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
				if($this->input->post('skin',TRUE)){ $data['shop_info']['skin'] = $this->input->post('skin',TRUE);	} //환경 설정 시 스킨 적용

				if(isset($data['menu']['lv2']->url)){
					$data['return_url'] = cdir().$data['menu']['lv2']->url."/m";
				}else{
					$data['return_url'] = cdir().$data['menu']['lv1']->url."/m";
				}

				/* 각 페이지의 header inner 클래스 가져오기 start*/
				if(isset($data['menu']['lv2']->cls)){
					$class = $data['menu']['lv2']->cls;
					$url = $data['menu']['lv2']->url;
				}else{
					$class = $data['menu']['lv1']->cls;
					$url = $data['menu']['lv1']->url;
				}
				if($class==""){	$class="adm-wrap"; } // header 안의 inner 기본 클래스
				$data['inner_class'] = $class;
				/* 각 페이지의 header inner 클래스 가져오기 end*/


				/* 페이지 권한 start */
				if($this->session->userdata('ADMIN_LEVEL') > 1){
					$menu_row = $this->common_m->getRow2("dh_menu_data", "where sgm!=1 and url='$url'");
					$menu_url = "";
					if(isset($menu_row->emp)){
						$emp_row = explode(",",	$menu_row->emp);
						if(in_array($this->session->userdata('ADMIN_IDX'),$emp_row)){
							$menu_url = $menu_row->url;
						}
					}

					if($menu_url==""){
						back('페이지 권한이 없습니다.');
					}
				}
				/* 페이지 권한 설정 end */


				$this->load->view('/dhadm/header',$data); //헤더 삽입

				$this->{"{$method}"}($data);

				$this->load->view('/dhadm/footer'); //풋터 삽입


			}else{ //헤더 & 풋터가 적용되지 않을 메소드

				if( method_exists($this, $method))
				{
					$this->{"{$method}"}();
				}

			}

		}

	}



	public function excel_download() //엑셀 다운 - 모든 컨트롤러에 적용
	{
		$cont = $this->input->get('cont'); //컨트롤러이름
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}


	public function lists($excel='')
	{

		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3)."/m";
		$trade_stat = $this->uri->segment(3,1);
		$today = date("Y-m-d");

		$change_idx = $this->input->get("change_idx");
		$change_stat = $this->input->get("change_stat");


		if($change_idx && $change_stat){
			$result = $this->order_m->change_stat($change_idx,$change_stat);
			exit;
		}


		$data['start_date'] = $this->input->get("start_date");
		$data['end_date'] = $this->input->get("end_date");
		$data['trade_stat'] = $trade_stat; //trade_stat->all 이면 전체
		$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트

		$data['trade_method_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'trade_method%'","idx");
		$data['trade_stat_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'trade_stat%'","idx");

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='15'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

		$arr = $this->order_m->admTradeList('',$offset,$list_num,$excel);

		$totalArr = $this->order_m->admTradeList('count');
		$data['totalCnt'] = $totalArr['totalCnt'];
		$data['list'] = $arr['list'];

		$data['query_string'] = $arr['query_string'];

		$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		$formCnt = $this->input->post('formCnt');

		/* 일괄 변경 start */
		if($this->input->post('del_ok')==1 && $formCnt > 0){	 //선택삭제
			for($i=1;$i<=$formCnt;$i++){
					if($this->input->post("check".$i)){
						$result = $this->common_m->del("dh_trade","trade_code", $this->input->post("check".$i,true));
						$result = $this->common_m->del("dh_trade_goods","trade_code", $this->input->post("check".$i,true));
						$result = $this->common_m->del("dh_trade_goods_option","trade_code", $this->input->post("check".$i,true));
					}
				}
			result($result, "삭제", $url);
		}else if($this->input->post('del_ok')==2 && $formCnt > 0 && $this->input->post('change_stat')){	//선택 거래상태 변경
			for($i=1;$i<=$formCnt;$i++){
				if($this->input->post("check".$i)){
					$result = $this->order_m->change_stat($this->input->post("check".$i),$this->input->post('change_stat'),1);
				}
			}
			result($result,'','/order/lists/'.$this->input->post('change_stat').'/m');

		}else if($this->input->post('del_ok')==3){ //전체 운송장번호 저장
			for($i=1;$i<=$formCnt;$i++){
				$result = $this->order_m->delivery_ok($this->input->post("trade_idx".$i));
			}
			alert($_SERVER['PHP_SELF'].$data['query_string'].$data['param']);
		}
		/* 일괄 변경 end */

		$data['trade_stat_list'] = $this->common_m->getList2("dh_shop_info","WHERE name like 'trade_stat%' order by idx");

		$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
		$data['delivery_row'] = $this->common_m->getList("dh_shop_info","where name like 'delivery_idx%' and val!='' group by name");


		if($this->input->get("view") && $this->input->get("idx")){ //상세보기

			$trade_idx = $this->input->get("idx");

			if($this->input->post("edit")==1){
				$result = $this->db->update("dh_trade",array('send_name'=>$this->input->post("send_name",true),'zip1'=>$this->input->post("zip1",true),'addr1'=>$this->input->post("addr1",true),'addr2'=>$this->input->post("addr2",true),'send_phone'=>$this->input->post("send_phone",true),'send_tel'=>$this->input->post("send_tel",true),'send_text'=>$this->input->post("send_text",true),'memo'=>$this->input->post("memo",true)),array('idx'=>$trade_idx));
				result($result, "수정", cdir()."/order/lists/all/m/?view=1&idx=".$trade_idx);
				exit;
			}


			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."' order by idx desc limit 1");
			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$trade_code = $data['trade_stat']->trade_code;

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			$this->load->view('/dhadm/order/view',$data);
			exit;

		}else{
			if($excel=="1"){ //엑셀다운
				$data['option'] = $this->order_m->getTradeOptionList($data['list']);
				$this->load->view("/dhadm/excel/order",$data); //엑셀다운
			}else{
				$this->load->view('/dhadm/order/list',$data);
			}
		}
	}



	public function tmp($data='')
	{

		if($this->input->post("trade_code") && $this->input->post("change_trade_code")){

			$tradeCnt = $this->common_m->getcount("dh_trade","where trade_code='".$this->input->post("change_trade_code",true)."'");
			$trade_code = $this->input->post("trade_code",true);
			if($tradeCnt == 0){

				$result = $this->common_m->update2("dh_cart",array('trade_ok'=>0,'trade_day '=>'0000-00-00 00:00:00'),array('trade_code'=>$trade_code));
				$cartRow = $this->common_m->getRow("dh_cart","where trade_code='".$trade_code."'");

				$result = $this->order_m->getCart($cartRow->code);

				$data['cart_list'] = $result['list'];
				foreach($data['cart_list'] as $lt){
					$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
				}

				$data['totalCnt'] = $this->common_m->getCount("dh_cart","where code='".$trade_code."'","idx");

				if($this->input->post("change_trade_code") == $this->input->post("trade_code")){

					$result = $this->order_m->trade($trade_code,$data,"1");

				}else{

					$result = $this->order_m->trade($trade_code,$data,"1",$this->input->post("change_trade_code",true));

				}

			result($result, "주문이 등록", cdir()."/order/tmp/m");

			}else{
				back('[복구실패 안내]\\n현재 등록되어있는 주문번호입니다.\\n주문관리에서 정보를 변경하시거나, 주문번호를 변경후 다시 복구하기를 눌러주세요.');
			}
			exit;

		}else{

			$data['list'] = $this->order_m->getTmpList();
			foreach($data['list'] as $lt){
				$data['cart_list'][$lt->idx] = $this->common_m->getList2("dh_cart","where trade_code='".$lt->trade_code."' order by idx");
			}
			$this->load->view('/dhadm/order/tmp_list',$data);

		}
	}



	public function coupon($data='')
	{
		$mode = $this->uri->segment(4);
		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/m";
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$order_query = "idx desc";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$param="";

		if($this->input->get("PageNumber")){ $param .="?PageNumber=".$this->input->get("PageNumber"); }

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		$data['param']=$param;
		$data['member_level'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

		if($mode=="write"){

			if($this->input->get("ajax")==1){
				$code = date("ym").substr($this->common_m->get_random_string('AZ'),0,7).mt_rand(1, 10);
				$cnt = $this->common_m->getCount("dh_coupon","where code='$code'");
				if($cnt > 0){ 		//중복값이 있으면 다시 생성
					echo $cnt;
				}else{
					echo $code;
				}
				exit;
			}else if($this->input->post("code") && $this->input->post("name")){

				$result = $this->order_m->codeInput();
				result($result, "쿠폰이 등록", cdir()."/order/coupon/m");

			}

			$this->load->view("/dhadm/order/coupon_write",$data);

		}else if($mode=="edit"){

			$idx = $this->uri->segment(5);
			if(!$idx){
				back("잘못된 접근입니다."); exit;
			}else{
				$data['row'] = $this->common_m->getRow2("dh_coupon","where idx='".$this->db->escape_str($idx)."'");

				if($this->input->post("code") && $this->input->post("idx") && $this->input->post("name")){

					$result = $this->order_m->codeInput('edit');
					result($result, "쿠폰이 수정", cdir()."/order/coupon/m");

				}

				$this->load->view("/dhadm/order/coupon_write",$data);

			}


		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_coupon","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/order/coupon/m");

		}else{


			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$data['totalCnt'] = $this->common_m->getPageList('dh_coupon','count','','',$where_query,$order_query); //총개수
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_coupon','',$offset,$list_num,$where_query,$order_query); //리스트
			$this->load->view("/dhadm/order/coupon_list",$data);

		}
	}


	public function couponTrade($data='')
	{
		$idx = $this->uri->segment(3);
		$couponRow = $this->common_m->getRow("dh_coupon","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_coupon_use","where code='".$couponRow->code."' order by idx asc");
		$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where code='".$couponRow->code."'");
		$data['row'] = $couponRow;

		$this->load->view('/dhadm/order/couponTrade', $data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */