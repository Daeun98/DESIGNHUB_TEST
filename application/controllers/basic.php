<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basic extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}



	public function index() //첫 화면 로딩시 로그인 화면 출력.
	{
			$this->setup();
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


	public function setup($data) //관리자정보
	{
			$data['admin2'] = $this->common_m->getRow("dh_admin_user","where idx='2'");	// 업체 관리자 정보

			if($this->input->post('admin_userid')){

					if($this->input->post('admin_passwd')!=""){
						$admin_passwd = md5($this->input->post('admin_passwd',TRUE));

					}else{
						$admin_passwd = $data['admin2']->passwd;
					}

					$write_data['table'] = 'dh_admin_user'; //테이블명
					$write_data['idx'] = '2';
					$write_data['userid'] = $this->input->post('admin_userid',TRUE);
					$write_data['passwd'] = $admin_passwd;

					$logo_image	= "";
					$logo_image_name = "";
					$og_image	= "";
					$og_image_name = "";

					/***********	logo_image	***********/
					if($_FILES['logo_image']['size'] > 0)
					{

						$config = array(
							'upload_path' =>  $_SERVER['DOCUMENT_ROOT'].'/_data/file/',
							'allowed_types' => 'gif|jpg|png',
							'encrypt_name' => TRUE,
							'max_size' => '20000'
						);

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('logo_image'))
						{
								back(strip_tags($this->upload->display_errors()));

						}else{
							$upload_data = $this->upload->data();
							$logo_image	= $upload_data['file_name'];
							$logo_image_name = $_FILES['logo_image']['name'];
							//@unlink( $_SERVER['DOCUMENT_ROOT'].'/_data/file/'.$data['shop_info']['logo_image'] );
						}

					}else if($data['shop_info']['logo_image']){
						$logo_image = $data['shop_info']['logo_image'];
						$logo_image_name = $data['shop_info']['logo_image_name'];
					}
					/***********	logo_image	***********/

					/*	og_image	*/
					if($_FILES['og_image']['size'] > 0)
					{

						$config = array(
							'upload_path' =>  $_SERVER['DOCUMENT_ROOT'].'/_data/file/',
							'allowed_types' => 'gif|jpg|png',
							'encrypt_name' => TRUE,
							'max_size' => '20000'
						);

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('og_image'))
						{
								back(strip_tags($this->upload->display_errors()));

						}else{
							$upload_data = $this->upload->data();
							$og_image	= $upload_data['file_name'];
							$og_image_name = $_FILES['og_image']['name'];
							//@unlink( $_SERVER['DOCUMENT_ROOT'].'/_data/file/'.$data['shop_info']['og_image'] );
						}

					}else if($data['shop_info']['og_image']){
						$og_image = $data['shop_info']['og_image'];
						$og_image_name = $data['shop_info']['og_image_name'];
					}
					/*	og_image	*/


					$bank_cnt = $this->input->post('bank_cnt',TRUE);
					$delivery_cnt = $this->input->post('delivery_cnt',TRUE);

					$write_data2['table'] = 'dh_shop_info'; //테이블명
					$write_data2['logo_image'] = $logo_image;
					$write_data2['logo_image_name'] = $logo_image_name;
					$write_data2['og_image'] = $og_image;
					$write_data2['og_image_name'] = $og_image_name;
					$write_data2['skin'] = $this->input->post('skin',TRUE);
					$write_data2['shop_name'] = $this->input->post('shop_name',TRUE);
					$write_data2['shop_domain'] = $this->input->post('shop_domain',TRUE);
					$write_data2['shop_ceo'] = $this->input->post('shop_ceo',TRUE);
					$write_data2['shop_num'] = $this->input->post('shop_num',TRUE);
					$write_data2['shop_tel1'] = $this->input->post('shop_tel1',TRUE);
					$write_data2['shop_tel2'] = $this->input->post('shop_tel2',TRUE);
					$write_data2['shop_fax'] = $this->input->post('shop_fax',TRUE);
					$write_data2['shop_email'] = $this->input->post('shop_email',TRUE);
					$write_data2['shop_license'] = $this->input->post('shop_license',TRUE);
					$write_data2['shop_address'] = $this->input->post('shop_address',TRUE);
					$write_data2['shop_use'] = $this->input->post('shop_use',TRUE);
					$write_data2['pg_company'] = $this->input->post('pg_company',TRUE);
					$write_data2['pg_id'] = $this->input->post('pg_id',TRUE);
					$write_data2['pg_key'] = $this->input->post('pg_key',TRUE);
					$write_data2['pg_pw'] = $this->input->post('pg_pw',TRUE);
					$write_data2['express_check'] = $this->input->post('express_check',TRUE);
					$write_data2['express_money'] = $this->input->post('express_money',TRUE);
					$write_data2['express_free'] = $this->input->post('express_free',TRUE);
					$write_data2['express_money2'] = $this->input->post('express_money2',TRUE);
					$write_data2['point_register'] = $this->input->post('point_register',TRUE);
					$write_data2['point'] = $this->input->post('point',TRUE);
					$write_data2['point_use'] = $this->input->post('point_use',TRUE);
					$write_data2['point_percent'] = $this->input->post('point_percent',TRUE);
					$write_data2['shop_review'] = $this->input->post('shop_review',TRUE);
					$write_data2['shop_qna'] = $this->input->post('shop_qna',TRUE);
					$write_data2['review_code'] = $this->input->post('review_code',TRUE);
					$write_data2['qna_code'] = $this->input->post('qna_code',TRUE);
					$write_data2['bank_cnt'] = $bank_cnt;
					$write_data2['delivery_cnt'] = $delivery_cnt;
					$write_data2['description'] = $this->input->post('description',TRUE);
					$write_data2['og_description'] = $this->input->post('og_description',TRUE);
					$write_data2['og_title'] = $this->input->post('og_title',TRUE);
					$write_data2['search_use'] = $this->input->post('search_use',TRUE);
					$write_data2['naver_tag'] = $this->input->post('naver_tag',TRUE);
					$write_data2['naver_channel'] = $this->input->post('naver_channel',TRUE);
					$write_data2['mobile_use'] = $this->input->post('mobile_use',TRUE);

					$write_data2['naver_channel'] = $this->input->post("naver_channel");
					$channel_cnt=0;

					if($this->input->post("naver_channel") == "y"){ //연관채널 추가
						$cnt = $this->input->post("naver_channel_cnt");

						if($cnt < $data['shop_info']['naver_channel_cnt']){ $cnt = $data['shop_info']['naver_channel_cnt']; }

						for($i=1;$i<=$cnt;$i++)
						{
							if($this->input->post("naver_channel_url".$i)){
								$channel_cnt++;

								$write_data2['naver_channel_url'.$i] = $this->input->post("naver_channel_url".$i,TRUE);
							}else{
								$this->common_m->del2($write_data2['table'],"where name = 'naver_channel_url".$i."'");
							}
						}

					}else{
						$this->common_m->del2($write_data2['table'],"where name like 'naver_channel_url%'");
					}

					$write_data2['naver_channel_cnt'] = $channel_cnt;

					$this->common_m->del2($write_data2['table'],"where name like 'bank_name%' or name like 'bank_num%' or name like 'input_name%'");

					for($i=1;$i<=$bank_cnt;$i++){
						if($this->input->post('bank_name'.$i)!=""){
							$write_data2['bank_name'.$i] = $this->input->post('bank_name'.$i,TRUE);
							$write_data2['bank_num'.$i] = $this->input->post('bank_num'.$i,TRUE);
							$write_data2['input_name'.$i] = $this->input->post('input_name'.$i,TRUE);
						}
					}

					for($i=1;$i<=$delivery_cnt;$i++){
						if($this->input->post('delivery_idx'.$i)!=""){
							$write_data2['delivery_idx'.$i] = $this->input->post('delivery_idx'.$i,TRUE);
							$write_data2['delivery_url'.$i] = $this->input->post('delivery_url'.$i,TRUE);
						}
					}


					$result = $this->common_m->update('basic_userinfo',$write_data); //업체 관리자 아이디/비번 수정
					$result2 = $this->admin_m->shop_info_update($write_data2); // shop 정보 수정

					if($result && $result2){ $ret = 1; }

					result($ret, "수정", cdir()."/basic/setup/m");

			}else{

				$this->load->view('/dhadm/basic/basic_setup',$data);

			}
	}



	public function page($data) //페이지 관리
	{
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$mode = $this->uri->segment(4);
		$param="";

		if($this->input->get("PageNumber")){ $param .="?PageNumber=".$this->input->get("PageNumber"); }

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		$return_url = $data['return_url'].$param;

		$data['param']=$param;


		if($mode=="write"){


			if($this->input->post("title") && $this->input->post("page_index")){

				$write_data['table'] = 'dh_page'; //테이블명
				$write_data['title'] = $this->input->post('title',TRUE);
				$write_data['page_index'] = $this->input->post('page_index',TRUE);
				$write_data['content'] = $this->input->post('tx_content');

				$cnt = $this->common_m->getCnt($write_data['table'], "where page_index='".$this->db->escape_str($write_data['page_index'])."'");

				if($cnt==0){
					$result = $this->admin_m->insert('page',$write_data); //페이지 추가
					result($result, "등록", $return_url);
				}else{
					back("중복되는 Page Index 값이 있습니다.");
				}

			}else{
				$this->load->view('/dhadm/basic/page_write',$data);
			}


		}else if($mode=="edit" || $mode=="view"){

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_page", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post("title")){

				$edit_data['table']	 = 'dh_page'; //테이블명
				$edit_data['idx']		 = $data['row']->idx;
				$edit_data['title']	 = $this->input->post('title',TRUE);
				$edit_data['content']  = $this->input->post('tx_content');

				$result = $this->admin_m->update('page',$edit_data);
				result($result, "수정", $return_url);

			}else if($mode=="view"){
				$this->load->view('/dhadm/basic/page_view',$data);

			}else if($mode=="edit"){
				$this->load->view('/dhadm/basic/page_write',$data);
			}


		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_page","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $return_url);

		}else{

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }

			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_page','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_page','',$offset,$list_num,$where_query); //게시판 리스트

			$this->load->view('/dhadm/basic/page',$data);

		}
	}


	public function mailform($data) //페이지 관리
	{
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$mode = $this->uri->segment(4);
		$param="";

		if($this->input->get("PageNumber")){ $param .="?PageNumber=".$this->input->get("PageNumber"); }

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		$return_url = $data['return_url'].$param;

		$data['param']=$param;
if($mode=="write"){


			if($this->input->post("title") && $this->input->post("page_index")){

				$write_data['table'] = 'dh_page'; //테이블명
				$write_data['title'] = $this->input->post('title',TRUE);
				$write_data['page_index'] = $this->input->post('page_index',TRUE);
				$write_data['content'] = $this->input->post('tx_content');

				$cnt = $this->common_m->getCnt($write_data['table'], "where page_index='".$this->db->escape_str($write_data['page_index'])."'");

				if($cnt==0){
					$result = $this->admin_m->insert('page',$write_data); //페이지 추가
					result($result, "등록", $return_url);
				}else{
					back("중복되는 Page Index 값이 있습니다.");
				}

			}else{
				$this->load->view('/dhadm/basic/page_write',$data);
			}


		}else if($mode=="edit" || $mode=="view"){

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_mailform", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post("title") && $this->input->post("subject")){

				$edit_data['table']	 = 'dh_mailform'; //테이블명
				$edit_data['idx']		 = $data['row']->idx;
				$edit_data['title']	 = $this->input->post('title',TRUE);
				$edit_data['subject']	 = $this->input->post('subject',TRUE);
				$edit_data['content']  = $this->input->post('tx_content');

				$result = $this->admin_m->update('mailform',$edit_data);
				result($result, "수정", $return_url);

			}else if($mode=="view"){
				$this->load->view('/dhadm/basic/mailform_view',$data);

			}else if($mode=="edit"){
				$this->load->view('/dhadm/basic/mailform_write',$data);
			}


		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_mailform","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $return_url);

		}else{

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }

			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_mailform','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_mailform','',$offset,$list_num,$where_query); //게시판 리스트

			$this->load->view('/dhadm/basic/mailform',$data);

		}


	}





}
