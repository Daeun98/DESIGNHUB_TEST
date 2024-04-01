<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dhadm extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('board_m');
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


		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우

				if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){
					alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
				}

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


	public function login() //어드민 로그인
	{
		$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보

		if($this->input->post('admin_userid') && $this->input->post('admin_passwd')){

			if($this->input->post('admin_userid') == "myeladmin"){	//DH SSO
				$auth_data = array(
					'admin_userid' => "dhadmin",
					'admin_passwd' => "akdldpf!!2012"
				);

				$result = $this->member_m->login($auth_data); //유저 확인
			}
			else{
				$auth_data = array(
					'admin_userid' => $this->input->post('admin_userid',TRUE),
					'admin_passwd' => $this->input->post('admin_passwd',TRUE)
				);

				$result = $this->member_m->login($auth_data); //유저 확인
			}

			if($result)
			{
				$newdata = array(
				'ADMIN_IDX' => $result->idx,
				'ADMIN_USERID' => $result->userid,
				'ADMIN_PASSWD' => $result->passwd,
				'ADMIN_NAME' => $result->name,
				'ADMIN_LEVEL' => $result->level,
				);

				$this->session->set_userdata($newdata);

				$menu_row = $this->common_m->getList2("dh_menu_data", "where sgm!=1 order by lft");
				$menu_url = "";
				foreach($menu_row as $menu){
					$emp_row = explode(",",	$menu->emp);
					if(in_array($result->idx,$emp_row)){
						$menu_url = $menu->url;
						break;
					}
				}

				if($result->level==1){
					$menu_row = $this->common_m->getRow2("dh_menu_data", "where sgm!=1 order by lft limit 1");
					$menu_url = $menu_row->url;
				}
				alert(cdir().$menu_url."/m");


			}else{
				back("관리자의 아이디와 패스워드가 올바르지 않습니다.");
			}


		}else{

			$this->load->view('/dhadm/admin_login',$data);
		}

	}


	public function logout() //어드민 로그아웃
	{
	//	$this->session->sess_destroy();
		$array_items = array('ADMIN_USERID' => '', 'ADMIN_PASSWD' => '', 'ADMIN_NAME' => '', 'ADMIN_NAME' => '', 'ADMIN_LEVEL' => '');
		$this->session->unset_userdata($array_items);

		alert(cdir()."/dhadm","로그아웃 되었습니다.");

	}


	public function category(){ //게시판 카테고리
		$code = $this->uri->segment(3);

		if($this->input->post('mm') == "w" && $this->input->post('name')){

					$insert_data = array(
						'table' => 'dh_bbs_cate',
						'name' => $this->input->post('name',TRUE),
						'code' => $code
					);

					$result = $this->common_m->insert('bbs_cate',$insert_data);


					result($result, "등록", cdir()."/dhadm/category/".$code);

		}else if($this->input->post('mm') == "e" && $this->input->post('name')){


					$update_data = array(
						'table' => 'dh_bbs_cate',
						'idx' => $this->input->post('idx',TRUE),
						'name' => $this->input->post('name',TRUE)
					);

					$result = $this->common_m->update('bbs_cate',$update_data);


					result($result, "수정", cdir()."/dhadm/category/".$code);

		}else if($this->input->get('del') == "1"){

				$del_idx = $this->uri->segment(4);

				$result = $this->common_m->del('dh_bbs_cate',"idx",$del_idx);


				result($result, "삭제", cdir()."/dhadm/category/".$code);

		}

		$data['list'] = $this->board_m->bbs_cate_list($code);

		$this->load->view('/dhadm/bbs/category',$data);
	}



	/*--------------------------------오픈시 삭제 필수 start (게시판관리는 미사용시에만) --------------------------------*/

	public function menu() //메뉴관리
	{
		if($this->input->get("ajax")==1){

			$mode = $this->input->get("mode");
			if($mode=="write"){
				$mode = "view";

			}
			$data['mode'] = $mode;
			$data['data'] = $this->admin_m->{$mode}($this->input->get("idx"));

			$this->load->view('/dhadm/menu/cate_'.$mode,$data);

		}else{


			if($this->input->post('nm') && $this->input->post('url') && $this->input->post("mode")){

				if($this->input->post("mode")=="write"){

					$write_data['id']		 = $this->input->post('id',TRUE);
					$write_data['pid']	 = $this->input->post('pid',TRUE);
					$write_data['nm']	 = $this->input->post('nm',TRUE);
					$write_data['url']  = $this->input->post('url',TRUE);
					$write_data['cls']  = $this->input->post('cls',TRUE);
					$write_data['emp']  = $this->input->post('emp',TRUE);
					$write_data['status']  = $this->input->post('status',TRUE);

					$result = $this->admin_m->menuInsert($write_data);
					$a_idx = $result;

					$script = "parent.list('".$a_idx."');";
					parent_result('등록',$script);

				}else if($this->input->post("mode")=="view"){

					$edit_data['id']		 = $this->input->post('id',TRUE);
					$edit_data['nm']	 = $this->input->post('nm',TRUE);
					$edit_data['url']  = $this->input->post('url',TRUE);
					$edit_data['cls']  = $this->input->post('cls',TRUE);
					$edit_data['emp']  = $this->input->post('emp',TRUE);
					$edit_data['status']  = $this->input->post('status',TRUE);

					$result = $this->admin_m->menuUpdate('dh_menu',$edit_data);
					$result = $this->admin_m->menuUpdate('dh_menu_data',$edit_data);

					$script = "parent.list('".$edit_data['id']."');";
					parent_result('수정',$script);

				}

				if($this->input->post("mode")=="del"){ //카테고리 삭제
					//해당 메뉴 가장 근접 메뉴 선택
					$sql = "select id from dh_menu_data where pid = '".$this->input->post('pid')."' order by lft desc, lvl desc";
					$row = $this->common_m->self_q($sql,"row");

					$result = $this->admin_m->menuDelete($this->input->post('del_idx'));

					$script = "parent.list('".$row->id."');";
					parent_result('삭제',$script);
				}

			}else{
				$this->load->view('/dhadm/menu/admin_menu');
			}

		}

		/* 새 카테고리 메뉴 end */

	}



	public function admin_user($data) //관리자 유저 관리
	{
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$mode = $this->uri->segment(4);
		$level = $this->input->get('level');
		$item = $this->input->get('item');
		$val = $this->input->get('val');

		if($level){	$data['query_string'].="&level=$level"; $where_query .= " and level = '$level'";	}
		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		$data['emp_row'] = $this->admin_m->getMenuEmpList(); //메뉴 데이타 가져오기
		$emp_cnt = $this->admin_m->getMenuEmpCount(); //메뉴 데이타 카운트 수

		if($mode=="write"){


			if($this->input->post('userid') && $this->input->post('passwd')){

					$emp = $this->input->post('emp');
					$passwd = md5($this->input->post('passwd',TRUE));

					$write_data['table'] = 'dh_admin_user'; //테이블명
					$write_data['userid'] = $this->input->post('userid',TRUE);
					$write_data['passwd'] = $passwd;
					$write_data['name'] = $this->input->post('name',TRUE);
					$write_data['level'] = $this->input->post('level',TRUE);
					//$write_data['main_url'] = $this->input->post('main_url',TRUE);


					$cnt = $this->common_m->getCnt($write_data['table'], "where userid='".$this->db->escape_str($write_data['userid'])."'");

					if($cnt==0){

						$result = $this->admin_m->insert('admin_user',$write_data); //업체 관리자 추가

						if($result && count($emp) > 0){ //메뉴 권한 주기
							 $a_idx = mysql_insert_id();
							 $update_data['table'] = 'dh_menu_data';

							 for($i=0;$i<count($emp);$i++){
								$emp_txt = "";
								$emp_row = $this->common_m->getRow2($update_data['table'],"where id='".$emp[$i]."'");
								$emp_arr = explode(",",$emp_row->emp);

								if(in_array($a_idx,$emp_arr)){
									$emp_txt = $emp_row->emp;
								}else{
									$emp_txt = $emp_row->emp.",".$a_idx;
								}
								$update_data['id'] = $emp[$i];
								$update_data['emp'] = $emp_txt;
								$result = $this->admin_m->update('admin_empower',$update_data);
							 }
						}

						result($result, "등록", $data['return_url']);

					}else{

						back("이미 존재하는 아이디 입니다.");
					}


			}else{

				$this->load->view('/dhadm/setup/user_write',$data);

			}

		}else if($mode=="edit"){

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_admin_user", "where idx='".$this->db->escape_str($idx)."'");
			$emp = $this->input->post('emp');

			if($this->input->post('name')){

					if($this->input->post('passwd')!=""){
						$passwd = md5($this->input->post('passwd',TRUE));

					}else{
						$passwd = $data['row']->passwd;
					}

					$edit_data['table']	 = 'dh_admin_user'; //테이블명
					$edit_data['idx']		 = $data['row']->idx;
					$edit_data['passwd'] = $passwd;
					$edit_data['name']	 = $this->input->post('name',TRUE);
					$edit_data['level']  = $this->input->post('level',TRUE);

					$result = $this->admin_m->update('admin_user',$edit_data);

					if($result && $this->input->post('emp')){ //메뉴 권한 주기
						 $update_data['table'] = 'dh_menu_data';

							foreach($data['emp_row'] as $eRow){
								$update_data['id'] = $eRow->id;
								$emp_txt = str_replace(",".$idx,"",$eRow->emp);
								$update_data['emp'] = $emp_txt;

								$result = $this->admin_m->update('admin_empower',$update_data);
							}

						 for($i=0;$i<count($emp);$i++){
							$emp_txt = "";
							$emp_row = $this->common_m->getRow2($update_data['table'],"where id='".$emp[$i]."'");
							$emp_arr = explode(",",$emp_row->emp);
							$emp_txt = $emp_row->emp.",".$idx;

							$update_data['id'] = $emp[$i];
							$update_data['emp'] = $emp_txt;
							$result = $this->admin_m->update('admin_empower',$update_data);
						 }
					}

					result($result, "수정", $data['return_url']);
			}


			$this->load->view('/dhadm/setup/user_write',$data);

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){


			$result = $this->common_m->del("dh_admin_user","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $data['return_url']);


		}else{

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $data['return_url'];
			$data['totalCnt'] = $this->common_m->getPageList('dh_admin_user','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_admin_user','',$offset,$list_num,$where_query,"level asc,idx desc"); //게시판 리스트


			$this->load->view('/dhadm/setup/user',$data);

		}

	}



	public function bbs($data){ // 게시판관리 - 게시판 설정

		$mode = $this->uri->segment(4);
		$data['level_row'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

		if($mode == "write"){


				if($this->input->post('bbs_admin_reg') == "true"){

					if( $this->input->post('bbs_write') == "1"){
						$write_level = $this->input->post('write_level',TRUE);
					}else{
						$write_level = "";
					}

					$insert_data = array(
						'table' => 'dh_bbs',
						'name' => $this->input->post('name',TRUE),
						'code' => $this->input->post('code',TRUE),
						'bbs_type' => $this->input->post('bbs_type',TRUE),
						'bbs_pds' => $this->input->post('bbs_pds',TRUE),
						'list_pds' => $this->input->post('list_pds',TRUE),
						'bbs_coment' => $this->input->post('bbs_coment',TRUE),
						'bbs_access' => $this->input->post('bbs_access',TRUE),
						'bbs_cate' => $this->input->post('bbs_cate',TRUE),
						'bbs_read' => $this->input->post('bbs_read',TRUE),
						'bbs_write' => $this->input->post('bbs_write',TRUE),
						'write_level' => $write_level,
						'list_width' => $this->input->post('list_width',TRUE),
						'list_height' => $this->input->post('list_height',TRUE),
						'list_page' => $this->input->post('list_page',TRUE),
						'new_check' => $this->input->post('new_check',TRUE),
						'new_mark' => $this->input->post('new_mark',TRUE),
						'cool_check' => $this->input->post('cool_check',TRUE),
						'cool_mark' => $this->input->post('cool_mark',TRUE),
						'view' => $this->input->post('view',TRUE),
						'nospam' => $this->input->post('nospam',TRUE),
						'memo' => $this->input->post('memo'),
						'bbs_secret' => $this->input->post('bbs_secret',TRUE),
						'size_text1' => $this->input->post('size_text1',TRUE),
						'size_text2' => $this->input->post('size_text2',TRUE),
						'editor' => $this->input->post('editor',TRUE)
					);

					$result = $this->admin_m->insert('bbs_admin',$insert_data);

					result($result, "등록", $data['return_url']);
				}else{

					$this->load->view('/dhadm/bbs/bbs_admin_add',$data);

				}

		}else if($mode=="edit"){

			$code = $this->uri->segment(5);

			if($this->uri->segment(6)){
				alert(cdir()."/dhadm/bbs/m/".$mode."/".$code);
			}


				if($this->input->post('bbs_admin_reg') == "true" && $code){

					if( $this->input->post('bbs_write') == "1"){
						$write_level = $this->input->post('write_level',TRUE);
					}else{
						$write_level = "";
					}

					$update_data = array(
						'table' => 'dh_bbs',
						'code' => $code,
						'name' => $this->input->post('name',TRUE),
						'bbs_type' => $this->input->post('bbs_type',TRUE),
						'bbs_pds' => $this->input->post('bbs_pds',TRUE),
						'list_pds' => $this->input->post('list_pds',TRUE),
						'bbs_coment' => $this->input->post('bbs_coment',TRUE),
						'bbs_access' => $this->input->post('bbs_access',TRUE),
						'bbs_cate' => $this->input->post('bbs_cate',TRUE),
						'bbs_read' => $this->input->post('bbs_read',TRUE),
						'bbs_write' => $this->input->post('bbs_write',TRUE),
						'write_level' => $write_level,
						'list_width' => $this->input->post('list_width',TRUE),
						'list_height' => $this->input->post('list_height',TRUE),
						'list_page' => $this->input->post('list_page',TRUE),
						'new_check' => $this->input->post('new_check',TRUE),
						'new_mark' => $this->input->post('new_mark',TRUE),
						'cool_check' => $this->input->post('cool_check',TRUE),
						'cool_mark' => $this->input->post('cool_mark',TRUE),
						'view' => $this->input->post('view',TRUE),
						'nospam' => $this->input->post('nospam',TRUE),
						'memo' => $this->input->post('memo'),
						'bbs_secret' => $this->input->post('bbs_secret',TRUE),
						'size_text1' => $this->input->post('size_text1',TRUE),
						'size_text2' => $this->input->post('size_text2',TRUE),
						'editor' => $this->input->post('editor',TRUE)
					);

					$result = $this->admin_m->update('bbs_admin',$update_data);

					result($result, "수정", $data['return_url']);

				}

				$data['bbs'] = $this->board_m->get_bbs($code);

				$this->load->view('/dhadm/bbs/bbs_admin_add',$data);

		}else if($mode=="del"){

			$del_idx = $this->uri->segment(5);

				if($this->uri->segment(6)){
					alert(cdir()."/dhadm/bbs/m/".$mode."/".$del_idx);
				}

				$board_row = $this->board_m->get_bbs('','',$del_idx); //게시판 코드값 갖고오기

				$code = $board_row->code;

				$result = $this->common_m->del('dh_bbs',"idx",$del_idx);

				result($result, "삭제", $data['return_url']);

		}else{

				$data['bbs_row'] = $this->board_m->get_bbs('','all');

				$this->load->view('/dhadm/bbs/bbs_admin',$data);
		}

	}

	/*--------------------------------오픈시 삭제 필수 end (게시판관리는 미사용시에만) --------------------------------*/


	public function menu_move($data='')
	{

		$update_data = array(
			'mode' => 'menu_move',
			'moveIdx' => $this->input->get('moveIdx',TRUE),
			'action' => $this->input->get('action',TRUE)
		);

		$result = $this->admin_m->menuMove($update_data);

		$this->admin_m->menuReload();

		echo $result;

	}
}
