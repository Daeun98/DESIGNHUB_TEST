<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Popup extends CI_Controller {

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
	
	
	public function index()
	{
		$this->set();
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


	public function excel_download() //엑셀 다운 - 모든 컨트롤러에 적용
	{
		$cont = $this->input->get('cont'); //컨트롤러이름
		$id = $this->input->get('id');
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}

	public function set($data)  //팝업관리
	{
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$mode = $this->uri->segment(4);
		$return_url = $data['return_url'];
		
		
		$data['param']="";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		if($mode=="write"){

				if($this->input->post('popup_add_reg') == "true" && $this->input->post('title_bar')){
							
					$popup_images = "";
					
					if($_FILES['popup_images']['size'] > 0)
					{

						$config = array(
							'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/designImages/',
							'allowed_types' => 'gif|jpg|png',
							'encrypt_name' => TRUE,
							'max_size' => '10000'
						);

						$this->load->library('upload',$config);


						if(!$this->upload->do_upload('popup_images'))
						{
								alert($return_url."/write",strip_tags($this->upload->display_errors()));

						}else{
							
							$insert_data = $this->upload->data();
							$popup_images	= $insert_data['file_name'];

						}
					}

					$insert_data = array(
						'table' => 'dh_popup',
						'display' => $this->input->post('display',TRUE),
						'tops' => $this->input->post('tops',TRUE),
						'lefts' => $this->input->post('lefts',TRUE),
						'start_day' => $this->input->post('start_day',TRUE),
						'end_day' => $this->input->post('end_day',TRUE),
						'width' => $this->input->post('width',TRUE),
						'height' => $this->input->post('height',TRUE),
						'live' => $this->input->post('live',TRUE),
						'title_bar' => $this->input->post('title_bar'),
						'link_url' => $this->input->post('link_url',TRUE),
						'popup_images' => $popup_images,
						'content' => $this->input->post('tx_content')
					);
						
					$result = $this->admin_m->insert('popup',$insert_data);							
					
					result($result, "등록", $return_url);

			}else{
				$this->load->view('/dhadm/popup/write',$data);
			}
					

		}else if($mode=="edit"){
		
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_popup", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post('popup_add_reg') == "true" && $this->input->post('title_bar'))
			{

				$bbs_file = "";
				$real_file = "";
				$popup_images = "";						
				
				if($_FILES['popup_images']['size'] > 0)
				{

					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/designImages/',
						'allowed_types' => 'gif|jpg|png',
						'encrypt_name' => TRUE,
						'max_size' => '10000'
					);

					$this->load->library('upload',$config);


					if(!$this->upload->do_upload('popup_images'))
					{						
						alert($return_url."/edit".$idx,strip_tags($this->upload->display_errors()));

					}else{
						
						$edit_data = $this->upload->data();
						$popup_images	= $edit_data['file_name'];

						if( $data['row']->popup_images != "none" && $data['row']->popup_images != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/designImages/".$data['row']->popup_images); }

					}
				}else{
					$popup_images = $data['row']->popup_images;
				}
						
						$edit_data = array(
							'table' => 'dh_popup',
							'idx' => $idx,
							'display' => $this->input->post('display',TRUE),
							'tops' => $this->input->post('tops',TRUE),
							'lefts' => $this->input->post('lefts',TRUE),
							'start_day' => $this->input->post('start_day',TRUE),
							'end_day' =>  $this->input->post('end_day',TRUE),
							'width' => $this->input->post('width',TRUE),
							'height' => $this->input->post('height',TRUE),
							'live' => $this->input->post('live',TRUE),
							'title_bar' => $this->input->post('title_bar',TRUE),
							'link_url' => $this->input->post('link_url'),
							'popup_images' => $popup_images,
							'popup_img_width' => $this->input->post('popup_img_width',TRUE),
							'popup_img_height' => $this->input->post('popup_img_height',TRUE),
							'content' => $this->input->post('tx_content')
						);

						$result = $this->admin_m->update('popup',$edit_data);

						result($result, "수정", $return_url.$data['query_string'].$data['param']);
				
			}else{
				$this->load->view('/dhadm/popup/write',$data);
			}

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){
			
			$result = $this->common_m->del("dh_popup","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $return_url);
		
		}else{

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_popup','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_popup','',$offset,$list_num,$where_query); //게시판 리스트
		
			$this->load->view('/dhadm/popup/list',$data);

		}
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */