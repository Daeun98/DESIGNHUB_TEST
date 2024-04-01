<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('banner_m');
    $this->load->model('common_m');
    $this->load->model('admin_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text; charset=utf-8");
		}
	}

	public function index() //첫 화면 로딩시 로그인 화면 출력.
	{
		$this->group();
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

	public function group()
	{
		$data['mode'] = $this->uri->segment(4);
		$mode = $data['mode'];

		$data['idx'] = $this->uri->segment(5);
		$idx = $data['idx'];

		$data['code'] = $this->input->get("code",true);
		$code = $data['code'];
		$data['parent_idx'] = $this->input->get("parent_idx",true);
		$parent_idx = $data['parent_idx'];
		$data['s_idx'] = $this->input->get("s_idx",true);
		$s_idx = $data['s_idx'];

		if($parent_idx){
			$data['parent_info'] = $this->common_m->self_q("select * from dh_banner where idx = '".$parent_idx."'","row");
		}

		if($mode == "add"){
			if($this->input->post("code"))
			{
				$datas['name'] = $this->input->post("name",TRUE);
				$datas['code'] = $this->input->post("code",TRUE);
				$datas['pageurl'] = $this->input->post("pageurl",TRUE);
				$datas['used'] = $this->input->post("used",TRUE);
				$datas['sorting'] = $this->input->post("sorting",TRUE);

				$result = $this->banner_m->insert($datas);
				result($result,"등록","/banner/group/m/");
			}
			else
			{
				$this->load->view("/dhadm/banner/input",$data);
			}
		}
		else if($mode == "edit"){
			if($this->input->post("code"))
			{
				$datas['name'] = $this->input->post("name",TRUE);
				$datas['pageurl'] = $this->input->post("pageurl",TRUE);
				$datas['used'] = $this->input->post("used",TRUE);
				$datas['idx'] = $this->input->post("idx",TRUE);
				$datas['sorting'] = $this->input->post("sorting",TRUE);

				$result = $this->banner_m->update($datas);
				result($result,"수정","/banner/group/m/");
			}
			else
			{
				$data['row'] = $this->banner_m->getrow($idx);
				$this->load->view("/dhadm/banner/input",$data);
			}
		}
		else if($mode == "del"){
			$data['del_list'] = $this->banner_m->delist($idx);
			foreach($data['del_list'] as $dl)
			{
				$data['dlrow'] = $this->banner_m->dlrow($dl->idx);
				@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/banner/".$dl->upfile1);
				@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/banner/".$dl->upfile2);
			}

			$result = $this->banner_m->grpdel($idx);
			result($result,"배너그룹이 삭제","/banner/group/m/");
		}
		else if($mode == "s_add"){
			$data['parent_info'] = $this->common_m->self_q("select * from dh_banner where code = '".$code."'","row");
			$data['s_list'] = $this->banner_m->s_list($code);
			$this->load->view("/dhadm/banner/slist",$data);
		}
		else if($mode == "s_input"){
			if($this->input->post("code")){

				$upfile1 = "";
				$upfile2 = "";
				$upfile1_real = "";
				$upfile2_real = "";

				//첨부1
				if(isset($_FILES['upfile1']['name']) && $_FILES['upfile1']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile1')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$upfile1	= $write_data['file_name'];
						$upfile1_real =	$_FILES['upfile1']['name'];
					}
				}
				//첨부2
				if(isset($_FILES['upfile2']['name']) && $_FILES['upfile2']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile2')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$upfile2	= $write_data['file_name'];
						$upfile2_real =	$_FILES['upfile2']['name'];
					}
				}

				$datas['parent_idx'] = $this->input->post("parent_idx",true);
				$datas['parent_code'] = $this->input->post("code",true);
				$datas['upfile1'] = $upfile1;
				$datas['upfile2'] = $upfile2;
				$datas['upfile1_real'] = $upfile1_real;
				$datas['upfile2_real'] = $upfile2_real;
				$datas['pageurl'] = $this->input->post("pageurl",true);
				$datas['sort'] = $this->input->post("sort",true);
				$datas['addinfo1'] = $this->input->post("addinfo1",true);
				$datas['addinfo2'] = $this->input->post("addinfo2",true);
				$datas['addinfo3'] = $this->input->post("addinfo3",true);
				$datas['addinfo4'] = $this->input->post("addinfo4",true);
				$datas['addinfo5'] = $this->input->post("addinfo5",true);

				$result = $this->banner_m->sinsert($datas);

				result($result,"등록","/banner/group/m/s_add/?code=".$this->input->post("code",true)."&parent_idx=".$this->input->post("parent_idx",true));

			}
			else{
				$max_rank = $this->common_m->self_q("select max(sort) as maxim from dh_bannerlist where parent_code = '".$code."'","row");
				$data['max_rank'] = $max_rank->maxim+1;
				$this->load->view("/dhadm/banner/sinput",$data);
			}
		}
		else if($mode == "s_edit"){

			$data['s_row'] = $this->banner_m->s_row($s_idx);

			if($this->input->post("sidx")){

				$upfile1 = "";
				$upfile2 = "";
				$upfile1_real = "";
				$upfile2_real = "";

				//첨부1
				if(isset($_FILES['upfile1']['name']) && $_FILES['upfile1']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile1')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/'.$data['s_row']->upfile1);
						$write_data = $this->upload->data();
						$upfile1	= $write_data['file_name'];
						$upfile1_real =	$_FILES['upfile1']['name'];
					}
				}
				else{
					$upfile1	= $data['s_row']->upfile1;
					$upfile1_real =	$data['s_row']->upfile1_real;
				}

				//첨부2
				if(isset($_FILES['upfile2']['name']) && $_FILES['upfile2']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile2')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/'.$data['s_row']->upfile2);
						$write_data = $this->upload->data();
						$upfile2	= $write_data['file_name'];
						$upfile2_real =	$_FILES['upfile2']['name'];
					}
				}
				else{
					$upfile2	= $data['s_row']->upfile2;
					$upfile2_real = $data['s_row']->upfile2_real;
				}

				$datas['upfile1'] = $upfile1;
				$datas['upfile2'] = $upfile2;
				$datas['upfile1_real'] = $upfile1_real;
				$datas['upfile2_real'] = $upfile2_real;
				$datas['pageurl'] = $this->input->post("pageurl",true);
				$datas['sort'] = $this->input->post("sort",true);
				$datas['addinfo1'] = $this->input->post("addinfo1",true);
				$datas['addinfo2'] = $this->input->post("addinfo2",true);
				$datas['addinfo3'] = $this->input->post("addinfo3",true);
				$datas['addinfo4'] = $this->input->post("addinfo4",true);
				$datas['addinfo5'] = $this->input->post("addinfo5",true);
				$datas['s_idx'] = $this->input->post("sidx",true);

				$result = $this->banner_m->supdate($datas);
				result($result,"수정","/banner/group/m/s_add/?code=".$data['s_row']->parent_code."&parent_idx=".$data['s_row']->parent_idx);

			}
			else{
				$this->load->view("/dhadm/banner/sinput",$data);
			}
		}
		else if($mode == "s_del"){
			$data['s_row'] = $this->banner_m->s_row($s_idx);
			@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/'.$data['s_row']->upfile1);
			@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner/'.$data['s_row']->upfile2);
			$result = $this->banner_m->sdelete($s_idx);
			result($result,"삭제","/banner/group/m/s_add/?code=".$data['s_row']->parent_code."&parent_idx=".$data['s_row']->parent_idx);
		}
		else{

			$data['list'] = $this->banner_m->lists();
			$this->load->view("/dhadm/banner/lists",$data);

		}
	}
}
