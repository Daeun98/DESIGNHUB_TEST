<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_board extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('product_m');
    $this->load->model('board_m');
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

		$this->{"{$method}"}($data);
	}


	function lists($data)
	{
		$code = $this->uri->segment(3);
		$page = $this->uri->segment(4,1);
		$data['page'] = $page;

		$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$goods_idx = $this->input->get('goods_idx'); //카테고리 idx
		$cate_idx = $this->input->get('cate_idx'); //카테고리 idx
		$search_item = $this->input->get('search_item'); //검색조건
		$search_order = $this->input->get('search_order'); //검색어
		$data['query_string'] = "?";
		$where_query = "";

		if($cate_idx){ $data['query_string'] .= "&cate_idx=".$cate_idx; }
		if($search_item || $search_order){ $data['query_string'] .= "&search_item=".$search_item."&search_order=".$search_order; }
		if($goods_idx){
			$data['query_string'] .= "&goods_idx=".$goods_idx;
			$where_query .= " and goods_idx='$goods_idx'";
		}


		$config['total_rows'] = $this->board_m->get_list($code, 'count','','',$search_item,$search_order,$cate_idx,$where_query,$data['bbs']->bbs_type); //게시물의 전체개수

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		if($this->input->get("ajax")==1){
			$list_num=5; //페이지 목록개수
		}else{
			$list_num=$data['bbs']->list_height; //페이지 목록개수
		}
		$page_num=$data['bbs']->list_page; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/lists/".$this->uri->segment(3);
		$data['totalCnt'] = $config['total_rows']; //게시판 리스트
		$data['Page2'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		/* 페이징 end */
		if($this->input->get("ajax")==1){
			$data['PageAjax'] = PageAjax($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string'],$code);
		}

		$data['start_num'] = $offset;

		$data['notice_list'] = $this->board_m->get_list($code,'notice','','','','',$this->input->get("cate_idx"),$where_query,$data['bbs']->bbs_type); //게시판 리스트(공지사항)
		$data['list'] = $this->board_m->get_list($code,'',$offset,$list_num,$search_item,$search_order,$cate_idx,$where_query,$data['bbs']->bbs_type); //게시판 리스트


		if($data['bbs']->bbs_cate == "Y"){ //카테고리를 사용한다면 정보 불러오기

			$data['cate_row'] = $this->board_m->bbs_cate_list($code);
			$data['cate_cnt'] = $this->board_m->bbs_cate_list($code,'cnt');
		}


		$bbs_dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/bbs/";


		switch($data['bbs']->bbs_type){
			case 1:
				$view = "bbs_list"; //일반답변게시판 리스트 폼(공통)
				break;
			case 2:
				$view = "bbs_list"; //일반공지게시판 리스트 폼
				break;
			case 3:
				$view = "gallery_list"; //갤러리게시판 리스트 폼
				break;
			case 4:
				$view = "faq_list"; //문의&답변 리스트 폼
				break;
			case 6:
				$view = "emd_list"; //동영상게시판 리스트 폼
				break;
			case 5:
				$view = "event_list"; //이벤트게시판 리스트 폼
				break;
			case 7:
				$view = "review_list"; //이벤트게시판 리스트 폼
				break;
		}



		// 게시판 접근 권한 설정
		if( $data['bbs']->bbs_access == 1 ) {
			if( !$this->session->userdata('USERID') ) {
				alert(cdir()."/dh_member/login","회원 전용입니다. 로그인을 해주세요.");
			}
		}

		$data['view'] = $bbs_dir.$view;
		$data['code'] = $code;

		$url = $this->common_m->get_page($code);

		if($this->input->get("ajax")==1){
			$url = "/bbs/ajax_".$code."_list";
		}

		$this->load->view($url,$data);

	}


	function views($data='')
	{

		$idx = $this->uri->segment(3);
		$page = $this->uri->segment(4,1); //페이징값
		$data['page'] = $page;
		$data['query_string'] = "?";

		$cate_idx = $this->input->get("cate_idx");
		if($cate_idx){ $data['query_string'].="&cate_idx=".$cate_idx; }

		$data['row'] = $this->board_m->get_view('dh_bbs_data',$idx); //게시판 보기

		$data['coment_cnt'] = $this->common_m->getCount('dh_bbs_coment',"where link='$idx'"); //게시판 보기

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$pwd_ok = 0;

		if($this->input->post('name') && $this->input->post('pwd') && $this->input->post('coment')) //댓글 등록
		{
			$code = $this->input->post('code',TRUE);
			$write_data['table'] = 'dh_bbs_coment';
			$write_data['link'] = $idx;
			$write_data['userid'] = $this->input->post('userid',TRUE);
			$write_data['name'] = $this->input->post('name',TRUE);
			$write_data['pwd'] = $this->input->post('pwd',TRUE);
			$write_data['coment'] = $this->input->post('coment');

			$result = $this->board_m->bbs_coment_insert($write_data);

			result($result, "댓글이 등록", cdir()."/dh_board/views/".$idx."?coment=1&pwd=".$this->input->post('pwd'));

		}else if($this->input->post('del_idx') && $this->input->post('mode')){ //댓글 & 글삭제

			switch($this->input->post('mode'))
			{
				case "bbs":
				 $table = "dh_bbs_data";
				 $go_url = cdir()."/".$this->uri->segment(1)."/lists/".$data['row']->code;

				 if( $data['row']->bbs_file != "none" && $data['row']->bbs_file != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_ADM/data/bbsData/".$data['row']->bbs_file); }

				 break;

				case "bbs_coment":
				 $table = "dh_bbs_coment";
				 $go_url = cdir()."/".$this->uri->segment(1)."/views/".$idx;
				 break;

			}

			$result = $this->common_m->del($table,"idx",$this->input->post('del_idx',TRUE));

			result($result, "삭제", $go_url );

		}


			//글 보기
			$code = $data['row']->code;
			$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경
			$data['preRow'] = $this->board_m->get_preView($code,$idx,$cate_idx); //이전글
			$data['nextRow'] = $this->board_m->get_nextView($code,$idx,$cate_idx); //다음글
			$data['coment'] = $this->board_m->get_bbs_coment($idx); //게시판 환경

			if($data['row']->goods_idx){
				$data['goods_row'] = $this->common_m->getRow("dh_bbs_data", "where idx='".$data['row']->goods_idx."'");
			}

			$url = $this->common_m->get_page($code);
			$bbs_dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/bbs/";

			$view = "bbs_view";

			// 게시판 보기 권한 설정
			if( $data['bbs']->bbs_read == 1 ) {
				if( !$this->session->userdata('USERID') ) {
					alert(cdir()."/dh_member/login/?go_url=".cdir()."/dh_board/views/".$idx,"회원 전용입니다. 로그인을 해주세요.");
				}
			}


			if($data['row']->secret == "y"){ //비밀글 일 때 권한설정
				$pwd = md5($this->input->post('pwd'));

				if(!$this->input->post("pwd") && $this->input->get("coment")==1){
					$pwd = md5($this->input->get('pwd'));
				}

				//원래글 불러오기
				$bRow = $this->common_m->getRow("dh_bbs_data","where re_level=0 and idx='".$data['row']->ref."'");

				if($this->session->userdata('USERID') && $this->session->userdata('USERID') == $data['row']->userid){

				}else if($pwd != $data['row']->pwd && $data['row']->re_level == 0){
					alert(cdir()."/dh_board/passwd/bbs_view/".$idx,'비밀번호가 일치하지 않습니다.');
					exit;
				}else if($data['row']->re_level > 0 && $pwd != $data['row']->pwd && $pwd != $bRow->pwd ){
					alert(cdir()."/dh_board/passwd/bbs_view/".$idx,'비밀번호가 일치하지 않습니다.');
					exit;
				}
			}

			if($data['bbs']->bbs_type==7){
				$data['goods_row'] = $this->common_m->getRow('dh_goods',"where idx='".$data['row']->goods_idx."'"); //제품후기 일경우 제품데이터 가져오기
			}

			$data['view'] = $bbs_dir.$view; //일반게시판 뷰 폼(공통)

			$this->load->view($url,$data);

	}



	function write($data='')
	{
		$code = $this->uri->segment(3);
		$idx = $this->uri->segment(4,'');
		$data['code'] = $code;
		$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경

		$data['safeguard'] = $this->common_m->getRow("dh_page","where page_index='safeguard'");
		$data['agreement'] = $this->common_m->getRow("dh_page","where page_index='agreement'");

		// 게시판 쓰기 권한 설정
		if( $data['bbs']->bbs_write > 0 ) {

			if( $data['bbs']->bbs_write < 9 && !$this->session->userdata('USERID') ) {
				alert(cdir()."/dh_member/login/?go_url=".cdir()."/dh_board/write/".$code,"회원 전용입니다. 로그인을 해주세요.");
			}else if($data['bbs']->bbs_write == 9){
				back("관리자 전용입니다.");
			}
		}
		$write_url = "";

		if($this->input->get("goods_idx")){
			$userid = $this->session->userdata('USERID');
			$goods_idx = $this->input->get("goods_idx");
			$tradeCnt = $this->common_m->getCount("dh_trade t,dh_trade_goods g","where t.trade_code=g.trade_code and t.trade_stat!=9 and t.userid='$userid' and g.goods_idx='$goods_idx'");
			if($tradeCnt==0 && $data['bbs']->bbs_type==7){
				back("제품을 구매하신 회원만 작성하실 수 있습니다.");
				exit;
			}
			if($data['bbs']->bbs_type==7 && !$this->input->get("ajax")){
				$data['goods_row'] = $this->common_m->getRow3("dh_trade t,dh_trade_goods g","where t.trade_code=g.trade_code and t.trade_stat!=9 and t.userid='$userid' and g.goods_idx='$goods_idx' order by g.idx desc limit 1","g.goods_idx,g.goods_name,g.cate_no"); //제품후기 일경우 제품데이터 가져오기
			}else{
				$data['goods_row'] = $this->common_m->getRow2("dh_goods","where idx='$goods_idx'"); //제품후기 일경우 제품데이터 가져오기
				$write_url = cdir()."/dh_product/prod_view/".$goods_idx."?cate_no=".$data['goods_row']->cate_no."#".$code."_list";
			}
		}

		$cate_idx = $this->input->get('cate_idx'); //카테고리 idx
		$search_item = $this->input->get('search_item'); //검색조건
		$search_order = $this->input->get('search_order'); //검색어
		$data['query_string'] = "?";

		if($cate_idx){ $data['query_string'] .= "&cate_idx=".$cate_idx; }
		if($search_item || $search_order){ $data['query_string'] .= "&search_item=".$search_item."&search_order=".$search_order; }

		if($this->input->get("cate_idx")){
			$data['query_string'] .= "/?cate_idx=".$this->input->get("cate_idx")."&v=1";
		}

		if($data['bbs']->bbs_cate=="Y"){
			$data['cate_cnt'] = $this->board_m->get_cate_cnt();
			$data['cate_list'] = $this->board_m->bbs_cate_list($code);
		}

		$pwd = $this->input->post('pwd');
		if(!$pwd){ $pwd = "123456"; }

		if($this->input->post('name') && $pwd)
		{
			if($data['bbs']->nospam == 1 && $this->session->userdata('cnum') != $this->input->post('spam_code')){ //스팸이고 일치하지 않으면
				back("보안문자가 정확하지 않습니다."); exit;
			}

			$this->session->unset_userdata(array('cnum' => ''));


			$bbs_file = "";
			$real_file = "";
			$bbs_file2 = "";
			$real_file2 = "";

			if(isset($_FILES['bbs_file']['name']) && $_FILES['bbs_file']['size'] > 0)
			{
				$config = array(
					'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
					'allowed_types' => 'gif|jpg|png',
					'encrypt_name' => TRUE,
					'max_size' => '20000'
				);

				$this->load->library('upload',$config);


				if(!$this->upload->do_upload('bbs_file'))
				{
						back(strip_tags($this->upload->display_errors()));
				}else{
						$write_data = $this->upload->data();
						$bbs_file	= $write_data['file_name'];
						$real_file	=	$_FILES['bbs_file']['name'];
					}
				}

				if(isset($_FILES['bbs_file2']['name']) && $_FILES['bbs_file2']['size'] > 0)
				{
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
						'allowed_types' => 'gif|jpg|png',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);

					$this->load->library('upload',$config);

					if(!$this->upload->do_upload('bbs_file2'))
					{
						back(strip_tags($this->upload->display_errors()));

					}else{
						$write_data = $this->upload->data();
						$bbs_file2	= $write_data['file_name'];
						$real_file2	=	$_FILES['bbs_file2']['name'];
					}
				}

					$write_data['table'] = 'dh_bbs_data'; //테이블명
					$write_data['code'] = $code;
					$write_data['userid'] = $this->input->post('userid',TRUE);
					$write_data['start_date'] = $this->input->post('start_date',TRUE);
					$write_data['end_date'] = $this->input->post('end_date',TRUE);
					$write_data['name'] = $this->input->post('name',TRUE);
					$write_data['pwd'] = $pwd;
					$write_data['subject'] = $this->input->post('subject',TRUE);
					$write_data['content'] = $this->input->post('tx_content');
					$write_data['ref'] = $this->input->post('ref',TRUE);
					$write_data['re_step'] = $this->input->post('re_step',TRUE);
					$write_data['re_level'] = $this->input->post('re_level',TRUE);
					$write_data['bbs_file'] = $bbs_file;
					$write_data['real_file'] = $real_file;
					$write_data['bbs_file2'] = $bbs_file2;
					$write_data['real_file2'] = $real_file2;
					$write_data['secret'] = $this->input->post('secret',TRUE);
					$write_data['cate_idx'] = $this->input->post('cate_idx',TRUE);
					$write_data['notice'] = $this->input->post('notice',TRUE);
					$write_data['dong_flag'] = $this->input->post('dong_flag',TRUE);
					$write_data['dong_src'] = $this->input->post('dong_src',TRUE);
					$write_data['dong_sorce'] = $this->input->post('dong_sorce',TRUE);
					$write_data['cate_no'] = $this->input->post('cate_no',TRUE);
					$write_data['goods_idx'] = $this->input->post('goods_idx',TRUE);
					$write_data['grade'] = $this->input->post('grade',TRUE);
					$write_data['data1'] = $this->input->post('data1',TRUE);
					$write_data['data2'] = $this->input->post('data2',TRUE);
					$write_data['year'] = $this->input->post('year',TRUE);
					$write_data['month'] = $this->input->post('month',TRUE);
					$write_data['day'] = $this->input->post('day',TRUE);
					$write_data['email'] = $this->input->post('email',TRUE);

					if($data['bbs']->bbs_type==7){
						$write_data['review'] = 1;
					}

					$result = $this->board_m->insert($write_data);

					if($data['bbs']->bbs_type==8){ //온라인문의 일 경우
						$write_url = cdir()."/dh_board/write/".$code.$data['query_string'];


						//$result = $this->common_m->mailform(5,$write_data); //메일전송
					}

					if($write_url){
						result($result, "등록", $write_url);
					}else{
						result($result, "등록", cdir()."/dh_board/lists/".$code.$data['query_string']);
					}


		}else{

			if($idx != ""){


				$data['row'] = $this->common_m->getRow3('dh_bbs_data',"where idx='$idx'","code,subject,content,ref,re_step,re_level,secret"); //게시판 보기
				$code = $data['row']->code;
				$data['row']->content	= "<br><br><br><br><br>------------------ 원글 ------------------<br><br>"."제목 : ".$data['row']->subject."<br>".$data['row']->content."<br><br>";
				$data['row']->subject = "Re: ".$data['row']->subject;

			}

			if($data['bbs']->nospam == 1){ //스팸
				$spam = $this->common_m->nospam();
				$data['cnum'] = $spam['cnum'];
				$data['imgData'] = $spam['imgData'];
			}

			if($data['bbs']->bbs_cate == "Y"){ //카테고리를 사용한다면 정보 불러오기

				$data['cate_row'] = $this->board_m->bbs_cate_list($code);
				$data['cate_cnt'] = $this->board_m->bbs_cate_list($code,'cnt');
			}


			$view = "bbs_write";
			switch($data['bbs']->bbs_type){
				case 7:
					$view = "review_write"; //제품후기 게시판 쓰기폼
					break;
			}



			$bbs_dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/bbs/";
			$data['view'] = $bbs_dir.$view;
			$data['ROOT_DIR'] = "/_ADM";

			$url = $this->common_m->get_page($code);

			if($this->input->get("ajax")==1 && $this->input->get("goods_idx")){
				$url = "/bbs/ajax_".$code."_write";
			}

			$this->load->view($url,$data);

		}

	}


	function edit($data='')
	{

		$idx = $this->uri->segment(3);

		$data['query_string'] = "?";

		if($this->input->get("cate_idx")){
			$data['query_string'] .= "/?cate_idx=".$this->input->get("cate_idx")."&v=1";
		}

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		$pwd_ok = 0;
		$data['row'] = $this->common_m->getRow('dh_bbs_data',"where idx='$idx'"); //게시판 보기
		$code = $data['row']->code;

		$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경

		if($data['bbs']->bbs_cate=="Y"){
			$data['cate_cnt'] = $this->board_m->get_cate_cnt();
			$data['cate_list'] = $this->board_m->bbs_cate_list($code);
		}

		if($data['row']->goods_idx){
			$userid = $this->session->userdata('USERID');
			$goods_idx = $data['row']->goods_idx;
			$tradeCnt = $this->common_m->getCount("dh_trade t,dh_trade_goods g","where t.trade_code=g.trade_code and t.trade_stat!=9 and t.userid='$userid' and g.goods_idx='$goods_idx'");
			if($tradeCnt==0 && $data['bbs']->bbs_type==7){
				back("제품을 구매하신 회원만 작성하실 수 있습니다.");
				exit;
			}
			$data['goods_row'] = $this->common_m->getRow3("dh_trade t,dh_trade_goods g","where t.trade_code=g.trade_code and t.trade_stat!=9 and t.userid='$userid' and g.goods_idx='$goods_idx' order by g.idx desc limit 1","g.goods_idx,g.goods_name,g.cate_no"); //제품후기 일경우 제품데이터 가져오기

		}


		if($this->input->post('name') && $this->input->post('pwd'))
		{
			if($data['bbs']->nospam == 1 && $this->session->userdata('cnum') != $this->input->post('spam_code')){ //스팸이고 일치하지 않으면
				back("보안문자가 정확하지 않습니다."); exit;
			}

			$this->session->unset_userdata(array('cnum' => ''));


			$bbs_file = "";
			$real_file = "";
			$bbs_file2 = "";
			$real_file2 = "";

			if(isset($_FILES['bbs_file']['name']) && $_FILES['bbs_file']['size'] > 0)
			{

				$config = array(
					'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
					'allowed_types' => 'gif|jpg|png',
					'encrypt_name' => TRUE,
					'max_size' => '10000'
				);

				$this->load->library('upload',$config);


				if(!$this->upload->do_upload('bbs_file'))
				{
						echo "<script>alert('".strip_tags($this->upload->display_errors())."'); history.back(-1);</script>";
						exit;

				}else{

					$edit_data = $this->upload->data();
					$bbs_file	= $edit_data['file_name'];
					$real_file	=	$_FILES['bbs_file']['name'];

					if( $data['row']->bbs_file != "none" && $data['row']->bbs_file != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$data['row']->bbs_file); }

				}
			}else{
				$bbs_file = $data['row']->bbs_file;
				$real_file = $data['row']->real_file;
			}


			if(isset($_FILES['bbs_file2']['name']) && $_FILES['bbs_file2']['size'] > 0)
			{

				$config = array(
					'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
					'allowed_types' => 'gif|jpg|png',
					'encrypt_name' => TRUE,
					'max_size' => '10000'
				);

				$this->load->library('upload',$config);


				if(!$this->upload->do_upload('bbs_file2'))
				{
						echo "<script>alert('".strip_tags($this->upload->display_errors())."'); history.back(-1);</script>";
						exit;

				}else{

					$edit_data = $this->upload->data();
					$bbs_file2	= $edit_data['file_name'];
					$real_file2	=	$_FILES['bbs_file2']['name'];

					if( $data['row']->bbs_file2 != "none" && $data['row']->bbs_file2 != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_ADM/data/bbsData/".$data['row']->bbs_file2); }

				}
			}else{
				$bbs_file2 = $data['row']->bbs_file2;
				$real_file2 = $data['row']->real_file2;
			}

					$edit_data['table'] = 'dh_bbs_data'; //테이블명
					$edit_data['idx'] = $idx;
					$edit_data['start_date'] = $this->input->post('start_date',TRUE);
					$edit_data['end_date'] = $this->input->post('end_date',TRUE);
					$edit_data['name'] = $this->input->post('name',TRUE);
					$edit_data['pwd'] = $this->input->post('pwd',TRUE);
					$edit_data['subject'] = $this->input->post('subject',TRUE);
					$edit_data['content'] = $this->input->post('tx_content');
					$edit_data['bbs_file'] = $bbs_file;
					$edit_data['real_file'] = $real_file;
					$edit_data['bbs_file2'] = $bbs_file2;
					$edit_data['real_file2'] = $real_file2;
					$edit_data['secret'] = $this->input->post('secret',TRUE);
					$edit_data['cate_idx'] = $this->input->post('cate_idx',TRUE);
					$edit_data['notice'] = $this->input->post('notice',TRUE);
					$edit_data['dong_flag'] = $this->input->post('dong_flag',TRUE);
					$edit_data['dong_src'] = $this->input->post('dong_src',TRUE);
					$edit_data['dong_sorce'] = $this->input->post('dong_sorce',TRUE);
					$edit_data['cate_no'] = $this->input->post('cate_no',TRUE);
					$edit_data['goods_idx'] = $this->input->post('goods_idx',TRUE);
					$edit_data['grade'] = $this->input->post('grade',TRUE);
					$edit_data['data1'] = $this->input->post('data1',TRUE);
					$edit_data['data2'] = $this->input->post('data2',TRUE);
					$edit_data['year'] = $this->input->post('year',TRUE);
					$edit_data['month'] = $this->input->post('month',TRUE);
					$edit_data['day'] = $this->input->post('day',TRUE);
					$edit_data['email'] = $this->input->post('email',TRUE);

					$result = $this->board_m->update($edit_data);

					if($result)
					{

						alert("/".$this->uri->segment(1)."/lists/".$code.$data['query_string'].$data['param'],"수정되었습니다.");

					}
					else
					{
						alert("/".$this->uri->segment(1)."/write/".$code.$data['query_string'].$data['param'],"등록에 실패하였습니다.");
					}

		}else{

			if($data['bbs']->nospam == 1){ //스팸
				$spam = $this->common_m->nospam();
				$data['cnum'] = $spam['cnum'];
				$data['imgData'] = $spam['imgData'];
			}


			$table = "dh_bbs_data";

			if($this->input->post('pwd_chk') == 1 && $this->input->post('pwd')){ //비밀번호 입력 - 본인글 수정하기

				$passwd = md5($this->input->post('pwd',TRUE));
				$mode = $this->input->post('mode');
				$result = $this->board_m->passwd_set($table, $passwd, $idx);


				if($result->cnt > 0){

						$pwd_ok = 1;

				}else{
						alert("/".$this->uri->segment(1)."/passwd/".$mode."/".$idx,"비밀번호가 일치하지 않습니다.");
				}

			}else if($this->session->userdata('PASSWD')){	 //로그인했을때

				$result = $this->board_m->passwd_set($table, $this->session->userdata('PASSWD'), $idx);


				if($result->cnt > 0){

						$pwd_ok = 1;

				}
			}

			if($pwd_ok == 1){


				$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경
				$data['code'] = $code; //게시판 환경


			if($data['bbs']->bbs_cate == "Y"){ //카테고리를 사용한다면 정보 불러오기

				$data['cate_row'] = $this->board_m->bbs_cate_list($code);
				$data['cate_cnt'] = $this->board_m->bbs_cate_list($code,'cnt');
			}

				$view = "bbs_write";
				switch($data['bbs']->bbs_type){
					case 7:
						$view = "review_write"; //제품후기 게시판 쓰기폼
						break;
				}

				$bbs_dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/bbs/";
				$data['view'] = $bbs_dir.$view;
				$data['ROOT_DIR'] = "/_data/file/";

				$url = $this->common_m->get_page($code);

				$this->load->view($url,$data);

			}else{

					back('비밀번호가 일치하지 않습니다.');
			}

		}
	}

		function passwd($data='')
	{
			$mode = $this->uri->segment(3);
			$idx = $this->uri->segment(4);
			$coment_idx = $this->uri->segment(5,'');

			$data['query_string'] = "?";

			$data['param'] = "";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}

			if($this->input->post('mode')){ $mode = $this->input->post('mode'); }

			$bbs_dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/bbs/";
			$data['row'] = $this->common_m->getRow('dh_bbs_data',"where idx='$idx'"); //게시판 보기
			$code = $data['row']->code;
			$go_url = "/dh_board//lists/".$code;

			switch($mode)
			{
				case "bbs_view" :
					$table = "dh_bbs_data";
					$data['action'] = "/dh_board/views/".$idx;
				break;
				case "bbs_edit" :
					$table = "dh_bbs_data";
					$data['action'] = "/dh_board/edit/".$idx;
				break;
				case "bbs_del" :
					$table = "dh_bbs_data";
					$data['action'] = $_SERVER['PHP_SELF'];
					if( $data['row']->bbs_file != "none" && $data['row']->bbs_file != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_ADM/data/bbsData/".$data['row']->bbs_file); }
				break;

				case "bbs_coment_del" :
					$table = "dh_bbs_coment";
					$data['action'] = "/dh_board/passwd/".$mode."/".$idx."/".$coment_idx;
					$go_url = "/dh_board/views/".$idx."?coment=1&pwd=".$this->input->post('pwd');
				break;
			}



			if($this->input->post('pwd_chk') == 1 && $this->input->post('pwd')){  //비밀번호 입력 - 본인글 삭제

				if($coment_idx!=""){ $del_idx = $coment_idx; }else{ $del_idx = $idx; }



				$passwd = md5($this->input->post('pwd',TRUE));
				$result = $this->board_m->passwd_set($table, $passwd, $del_idx);


				if($result->cnt > 0){


						$del_result = $this->common_m->del($table,"idx",$del_idx);

						if($del_result)
						{
							alert($go_url,"삭제되었습니다.");
						}
						else
						{
							alert($go_url,"삭제에 실패하였습니다.");
						}


				}else{
						//alert("/html/".$this->uri->segment(1)."/passwd/".$mode."/".$idx,"비밀번호가 일치하지 않습니다.");
						back('비밀번호가 일치하지 않습니다.');
				}

				exit;
			}

			$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경

			if($data['bbs']->bbs_cate == "Y"){ //카테고리를 사용한다면 정보 불러오기
				$data['cate_row'] = $this->board_m->bbs_cate_list($code);
				$data['cate_cnt'] = $this->board_m->bbs_cate_list($code,'cnt');
			}

			$data['mode'] = $mode;
			$data['code'] = $code;

			$data['view'] = $bbs_dir."passwd";
			$url = $this->common_m->get_page($code);
			$this->load->view($url,$data);

	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */