<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('common_m');
    $this->load->model('board_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		$this->bbsadm();
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
				$class="";

				$data['admin'] = $this->common_m->getRow("dh_admin_user","where userid='".$this->session->userdata('ADMIN_USERID')."'"); //접속한 user 정보
				$data['menu']  = $this->admin_m->menu(); //메뉴 갖고오기
				$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
				if($this->input->post('skin',TRUE)){ $data['shop_info']['skin'] = $this->input->post('skin',TRUE);	} //환경 설정 시 스킨 적용

				if(isset($data['menu']['lv2']->url)){
					$data['return_url'] = cdir().$data['menu']['lv2']->url."/m";
				}else if(isset($data['menu']['lv1']->url)){
					$data['return_url'] = cdir().$data['menu']['lv1']->url."/m";
				}

				/* 각 페이지의 header inner 클래스 가져오기 start*/
				if(isset($data['menu']['lv2']->cls)){
					$class = $data['menu']['lv2']->cls;
					$url = $data['menu']['lv2']->url;
				}else if(isset($data['menu']['lv1']->cls)){
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



	public function bbs($data){ //게시판 게시글 리스트

			$mode = $this->uri->segment(5);

			$cate_idx = $this->input->get('cate_idx'); //카테고리 idx
			$c_name = urldecode($this->input->get('c_name')); //카테고리 분류

			$page = $this->uri->segment(5,1); //페이징 할 세그먼트 값
			$search_item = $this->input->get('search_item'); //검색조건
			$search_order = $this->input->get('search_order'); //검색어

			$config['query_string'] = "?";

			if($cate_idx){ $config['query_string'] .= "&cate_idx=".$cate_idx; }
			if($search_item){ $config['query_string'] .= "&search_item=".$search_item."&search_order=".$search_order; }
			if($c_name){ $config['query_string'] .= "&c_name=".urlencode($c_name); }

			$code = $this->uri->segment(3);

			$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경

			$data['query_string'] = $config['query_string'];

			$data['param']="";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}

			$where_query="";

			if($data['bbs']->bbs_type==7){
				$cate_no1 = $this->input->get('cate_no1');
				$cate_no2 = $this->input->get('cate_no2');
				$cate_no3 = $this->input->get('cate_no3');
				$cate_no4 = $this->input->get('cate_no4');

				if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
				if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
				if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
				if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }

				for($i=4;$i>=1;$i--){
					if(${'cate_no'.$i}){
						$where_query .= " and cate_no like '".${'cate_no'.$i}."%' ";
						break;
					}
				}


				 $this->load->model('product_m');
				$data['product_cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트

			}

    	$data1 = $this->input->get('data1'); //개인정보처리방침
			if($data1){
				$where_query .= " and data1='{$data1}'";
			}

			if($mode=="write"){


				$idx = $this->uri->segment(6);

				if($this->input->post('name') && $this->input->post('pwd'))
				{
					$bbs_file = "";
					$real_file = "";
					$bbs_file2 = "";
					$real_file2 = "";
					$list_img = "";
					$list_img_real = "";

					if(isset($_FILES['bbs_file']['name']) && $_FILES['bbs_file']['size'] > 0)
					{

						$config = array(
							'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
							'allowed_types' => '*',
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
							'allowed_types' => '*',
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
					/*

					if(isset($_FILES['list_img']['name']) && $_FILES['list_img']['size'] > 0)
					{

						$config = array(
							'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
							'allowed_types' => '*',
							'encrypt_name' => TRUE,
							'max_size' => '20000'
						);

						$this->load->library('upload',$config);


						if(!$this->upload->do_upload('list_img'))
						{
								back(strip_tags($this->upload->display_errors()));

						}else{

							$write_data = $this->upload->data();
							$list_img	= $write_data['file_name'];
							$list_img_real	=	$_FILES['list_img']['name'];

						}
					}
					*/


				if($_FILES['list_img']['size'] > 0){
				  $config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
			   	$this->load->library('upload',$config);

					if(!$this->upload->do_upload('list_img')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$list_img = $write_data['file_name'];
						$list_img_real = $_FILES['list_img']['name'];
					}
				}



							$write_data['table'] = 'dh_bbs_data'; //테이블명
							$write_data['code'] = $code;
							$write_data['userid'] = $this->input->post('userid',TRUE);
							$write_data['start_date'] = $this->input->post('start_date',TRUE);
							$write_data['end_date'] = $this->input->post('end_date',TRUE);
							$write_data['name'] = $this->input->post('name',TRUE);
							$write_data['pwd'] = $this->input->post('pwd',TRUE);
							$write_data['subject'] = $this->input->post('subject',TRUE);
							$write_data['content'] = $this->input->post('tx_content');
							$write_data['ref'] = $this->input->post('ref',TRUE);
							$write_data['re_step'] = $this->input->post('re_step',TRUE);
							$write_data['re_level'] = $this->input->post('re_level',TRUE);
							$write_data['bbs_file'] = $bbs_file;
							$write_data['real_file'] = $real_file;
							$write_data['bbs_file2'] = $bbs_file2;
							$write_data['real_file2'] = $real_file2;
							$write_data['list_img'] = $list_img;
							$write_data['list_img_real'] = $list_img_real;
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
							$write_data['reg_date'] = $this->input->post('reg_date',TRUE);

							$result = $this->board_m->insert($write_data);


							if($result){

							$a_idx = mysql_insert_id();

							$addImgCnt = $this->input->post('img_cnt');

								if(isset($addImgCnt) && $addImgCnt > 0){

								for($j=1;$j<=$addImgCnt;$j++){

									if($_FILES['add_images'.$j]['size'] > 0){

										$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

										$this->load->library('upload',$config);

										if(!$this->upload->do_upload('add_images'.$j)){
											alert($data['return_url'],strip_tags($this->upload->display_errors()));
										}else{
											$insert_data = $this->upload->data();
											${'add_images'.$j}	= $insert_data['file_name'];
											${'add_images_real'.$j} = $_FILES['add_images'.$j]['name'];
										}

										$insert_data = array(
											'table' => "dh_file",
											'mode' => "file",
											'flag' => "bbs",
											'flag_idx' => $a_idx,
											'file_name' => ${'add_images'.$j},
											'real_name' => ${'add_images_real'.$j}
										);

										$result = $this->board_m->insert($insert_data);
									}
								}
								}
							}

							result($result, "등록", $data['return_url']);

				}else{

					if($idx != ""){


						$data['row'] = $this->common_m->getRow3('dh_bbs_data',"where idx='$idx'","code,subject,content,ref,re_step,re_level,secret"); //게시판 보기
						$code = $data['row']->code;
						$data['row']->name = $data['admin']->name;
						$data['row']->content	= "<br><br><br><br><br>------------------ 원글 ------------------<br><br>제목 : ".$data['row']->subject."<br>".$data['row']->content."<br><br>";
						$data['row']->subject = "Re: ".$data['row']->subject;

					}

					$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경
					$data['cate_list'] = $this->board_m->bbs_cate_list($code);
					$data['code'] = $code;
				  $data['safeguard_list'] = $this->common_m->self_q("select * from dh_bbs_data where code='safeguard' order by reg_date desc","result"); //개인정보처리방침

					$data['ROOT_DIR'] = "/_data";

					$view="bbs_write";

					switch($data['bbs']->bbs_type){
						case 7:
							$view = "review_write"; //리뷰게시판 글쓰기
							break;
					}


					$this->load->view("/dhadm/bbs/".$view,$data);

				}



			}else if($mode=="edit"){ //수정


				$idx = $this->uri->segment(6);

				$data['row'] = $this->board_m->get_view('dh_bbs_data',$idx); //게시판 보기
				$code = $data['row']->code;
				$data['file_row'] = $this->board_m->file_list("bbs",$idx);
				$data['file_cnt'] = $this->board_m->file_list("bbs",$idx,'count');

				if($this->input->post('name') && $this->input->post('pwd'))
				{

					$bbs_file = "";
					$real_file = "";
					$bbs_file2 = "";
					$real_file2 = "";
				  $list_img = "";
					$list_img_real = "";

					if(isset($_FILES['bbs_file']['name']) && $_FILES['bbs_file']['size'] > 0)
					{

						$config = array(
							'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
							'allowed_types' => '*',
							'encrypt_name' => TRUE,
							'max_size' => '10000'
						);

						$this->load->library('upload',$config);


						if(!$this->upload->do_upload('bbs_file'))
						{
								back(strip_tags($this->upload->display_errors()));

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
							'allowed_types' => '*',
							'encrypt_name' => TRUE,
							'max_size' => '10000'
						);

						$this->load->library('upload',$config);


						if(!$this->upload->do_upload('bbs_file2'))
						{
								back(strip_tags($this->upload->display_errors()));

						}else{

							$edit_data = $this->upload->data();
							$bbs_file2	= $edit_data['file_name'];
							$real_file2	=	$_FILES['bbs_file2']['name'];

							if( $data['row']->bbs_file2 != "none" && $data['row']->bbs_file2 != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_ADM/file/bbsData/".$data['row']->bbs_file2); }

						}
					}else{
						$bbs_file2 = $data['row']->bbs_file2;
						$real_file2 = $data['row']->real_file2;
					}

/*
					if(isset($_FILES['list_img']['name']) && $_FILES['list_img']['size'] > 0)
					{

						$config = array(
							'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/',
							'allowed_types' => '*',
							'encrypt_name' => TRUE,
							'max_size' => '10000'
						);

						$this->load->library('upload',$config);


						if(!$this->upload->do_upload('list_img'))
						{
								back(strip_tags($this->upload->display_errors()));

						}else{

							$edit_data = $this->upload->data();
							$list_img	= $edit_data['file_name'];
							$list_img_real	=	$_FILES['list_img']['name'];

							if( $data['row']->list_img != "none" && $data['row']->list_img != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_ADM/file/bbsData/".$data['row']->list_img); }

						}
					}else{
						$list_img = $data['row']->list_img;
						$list_img_real = $data['row']->list_img_real;
					}
					*/

				if($_FILES['list_img']['size'] > 0){
					$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '20000');
				  $this->load->library('upload',$config);


					if(!$this->upload->do_upload('list_img')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/'.$data['row']->list_img);
						$edit_data = $this->upload->data();
						$list_img = $edit_data['file_name'];
						$list_img_real = $_FILES['list_img']['name'];
					}
				}
				else{
					if($this->input->post('list_file_del')=="Y"){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/'.$data['row']->list_img);
						$list_img = '';
						$list_img_real = '';
					}
				}

							$edit_data['table'] = 'dh_bbs_data'; //테이블명
							$edit_data['idx'] = $idx;
							$edit_data['name'] = $this->input->post('name',TRUE);
							$edit_data['pwd'] = $this->input->post('pwd',TRUE);
							$edit_data['subject'] = $this->input->post('subject',TRUE);
							$edit_data['content'] = $this->input->post('tx_content');
							$edit_data['start_date'] = $this->input->post('start_date',TRUE);
							$edit_data['end_date'] = $this->input->post('end_date',TRUE);
							$edit_data['bbs_file'] = $bbs_file;
							$edit_data['real_file'] = $real_file;
							$edit_data['bbs_file2'] = $bbs_file2;
							$edit_data['real_file2'] = $real_file2;
							$edit_data['list_img'] = $list_img;
							$edit_data['list_img_real'] = $list_img_real;
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
							$edit_data['reg_date'] = $this->input->post('reg_date',TRUE);

							$result = $this->board_m->update($edit_data);

							if($result && isset($addImgCnt)){

								for($j=1;$j<=$addImgCnt;$j++){
									$ff=$j-1;

									if($_FILES['add_images'.$j]['size'] > 0){ // 추가 이미지가 있으면

										$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/bbsData/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

										$this->load->library('upload',$config);

										if(!$this->upload->do_upload('add_images'.$j)){
											alert($data['return_url'],strip_tags($this->upload->display_errors()));
										}else{
											$insert_data = $this->upload->data();
											${'add_images'.$j}	= $insert_data['file_name'];
											${'add_images_real'.$j} = $_FILES['add_images'.$j]['name'];
										}

										if(isset($data['file_row'][$ff]->file_name) && $data['file_row'][$ff]->file_name!="" ){ //DB에 값이 있으면 update

											$update_data = array(
												'mode' => 'file',
												'idx' => $data['file_row'][$ff]->idx,
												'file_name' => ${'add_images'.$j},
												'real_name' => ${'add_images_real'.$j}
											);

											$result = $this->common_m->update("file",$update_data);

										}else{ //DB에 값이 없으면 insert

											$insert_data = array(
												'mode' => "file",
												'flag' => "bbs",
												'flag_idx' => $idx,
												'file_name' => ${'add_images'.$j},
												'real_name' => ${'add_images_real'.$j}
											);

											$result = $this->board_m->insert($insert_data);
										}

									}
								}

							}

							result($result, "수정", cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$code."/m/".$data['query_string'].$data['param']);



				}else{

					if($this->input->post('pwd_chk') == 1 && $this->input->post('pwd')){ //비밀번호 입력 - 본인글 수정하기
						$mode = $this->input->post('mode',TRUE);
						$table = "dh_bbs_data";

						$result = $this->board_m->passwd_set($table, $this->input->post('pwd',TRUE), $idx);

					}


						$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경
						$data['cate_list'] = $this->board_m->bbs_cate_list($code);
						$data['safeguard_list'] = $safeguard_list= $this->common_m->self_q("select * from dh_bbs_data where code='safeguard' order by reg_date desc","result"); //개인정보처리방침

						$data['ROOT_DIR'] = "/_data";
						$data['code'] = $code;

						$view="bbs_write";

						switch($data['bbs']->bbs_type){
							case 7:
								$view = "review_write"; //리뷰게시판 글쓰기
								break;
						}


						$this->load->view("/dhadm/bbs/".$view,$data);

				}


			}else if($mode=="view"){


				$idx = $this->uri->segment(6);

				$data['row'] = $this->board_m->get_view('dh_bbs_data',$idx); //게시판


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

					result($result, "댓글이 등록", $data['return_url']);

				}else if($this->input->post('del_idx') && $this->input->post('mode')){ //댓글 & 글삭제

					switch($this->input->post('mode'))
					{
						case "bbs":
						 $table = "dh_bbs_data";
						 $go_url = "/adm/bbs_list/".$data['row']->code;

						 break;
						case "bbs_coment":
						 $table = "dh_bbs_coment";
						 $go_url = "/adm/bbs_view/".$idx;
						 break;

					}

					$result = $this->common_m->del($table,"idx",$this->input->post('del_idx',TRUE));

					if($this->input->post('mode')=="bbs"){

						 if( $data['row']->bbs_file != "none" && $data['row']->bbs_file != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$data['row']->bbs_file); }
						 if( $data['row']->bbs_file2 != "none" && $data['row']->bbs_file2 != "" ) { @unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$data['row']->bbs_file2); }

							$fileCnt = $this->common_m->getCount("dh_file","where flag='bbs' and flag_idx='".$data['row']->idx."'");

							if($fileCnt>0){
								$list = $this->common_m->getList("dh_file","where flag='bbs' and flag_idx='".$data['row']->idx."'");
								foreach($list as $lt){
									$result2 = $this->common_m->del('dh_file',"idx",$lt->idx);
									if($result2){
										@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$lt->file_name );
									}
								}
							}
					}

					result($result, "삭제", $data['return_url']);

				}


					//글 보기
					$code = $data['row']->code;
					$data['bbs'] = $this->board_m->get_bbs($code); //게시판 환경
					$data['preRow'] = $this->board_m->get_preView($code,$idx); //이전글
					$data['nextRow'] = $this->board_m->get_nextView($code,$idx); //다음글
					$data['coment'] = $this->board_m->get_bbs_coment($idx); //게시판 환경

					$view="bbs_view";

					switch($data['bbs']->bbs_type){
						case 4:
							$view = "qna_view"; //Q&A게시판 뷰
							break;
						case 8:
							$view = "online_view"; //온라인 폼 뷰
							break;
						case 7 :
							$data['goods_row'] = $this->common_m->getRow('dh_goods',"where idx='".$data['row']->goods_idx."'"); //게시판 보기
							break;
					}



					$this->load->view('/dhadm/bbs/'.$view,$data);


			}else{

			if($this->input->post('form_cnt')){ //여러글 삭제
				for($i=1;$i<=$this->input->post('form_cnt');$i++){
					if($this->input->post('chk'.$i)){

						$row = $this->common_m->getRow("dh_bbs_data","where idx='".$this->input->post('chk'.$i,TRUE)."'");
						$fileCnt = $this->common_m->getCount("dh_file","where flag='bbs' and flag_idx='".$row->idx."'");

						$result = $this->common_m->del('dh_bbs_data',"idx",$this->input->post('chk'.$i,TRUE));

						if($result){
							if($row->bbs_file){
								@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$row->bbs_file );
							}
							if($row->bbs_file2){
								@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$row->bbs_file2 );
							}
						}

						if($fileCnt>0){
							$list = $this->common_m->getList("dh_file","where flag='bbs' and flag_idx='".$row->idx."'");
							foreach($list as $lt){
								$result2 = $this->common_m->del('dh_file',"idx",$lt->idx);
								if($result2){
									@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$lt->file_name );
								}
							}
						}

					}
				}

				result($result, "삭제", $data['return_url']);

			}

			$config['total_rows'] = $this->board_m->get_list($code, 'count','','',$search_item,$search_order,$cate_idx,$where_query,$data['bbs']); //게시물의 전체개수

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num=$data['bbs']->list_height; //페이지 목록개수
			$page_num=$data['bbs']->list_page; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = cdir()."/".$this->uri->segment(1)."/bbs/".$code."/m/";
			$data['totalCnt'] = $config['total_rows']; //게시판 리스트
			$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			/* 페이징 end */

			$data['start_num'] = $offset;

      //개인정보처리방침 시행일자
			$s_idx = $this->input->get('data1');
      $data['s_row'] = $s_row = $this->common_m->self_q("select * from dh_bbs_data where idx = '{$s_idx}'","row");

    	$data['safeguard_list'] = $this->common_m->self_q("select * from dh_bbs_data where code='safeguard' order by reg_date desc","result"); //개인정보처리방침
			$data['safeguard_cate'] = $this->common_m->self_q("select * from dh_bbs_data where code='safeguard' order by reg_date desc limit 3","result"); //개인정보처리방침

			$data['notice_list'] = $this->board_m->get_list($code,'notice','','','','',$cate_idx); //게시판 리스트(공지사항)
			$data['list'] = $this->board_m->get_list($code,'',$offset,$list_num,$search_item,$search_order,$cate_idx,$where_query,$data['bbs']); //게시판 리스트


			$data['total_cnt'] = $config['total_rows'];

			$data['cate_total_cnt'] = $this->board_m->get_list($code, 'count'); //게시물의 전체개수;
			$data['cate_cnt'] = $this->board_m->get_cate_cnt();
			$data['cate_list'] = $this->board_m->bbs_cate_list($code);





			switch($data['bbs']->bbs_type){
				case 1:
					$view = "bbs_list"; //일반답변게시판 리스트 폼(공통)
					break;
				case 2:
					$view = "bbs_list"; //일반공지게시판 리스트 폼(공통)
					break;
				case 3:
					$view = "gallery_list"; //갤러리게시판 리스트 폼(공통)
					break;
				case 4:
					$view = "qna_list"; //Q&A게시판 리스트 폼(공통)
					break;
				case 6:
					$view = "gallery_list"; //갤러리게시판 리스트 폼(공통)
					break;
				case 5:
					$view = "event_list"; //이벤트게시판 리스트 폼(공통)
					break;
				case 7:
					$view = "review_list"; //구매후기 리스트 폼(공통)
					break;
				case 8:
					$view = "online_list"; //온라인폼 리스트 폼(공통)
					break;
				case 9:
					$view = "banner_list"; //배너 리스트 폼(공통)
					break;
				case 10:
					$view = "history_list"; //배너 리스트 폼(공통)
					break;
			}


			$this->load->view('/dhadm/bbs/'.$view,$data);

			}
	}


	public function file_del() //제품 이미지 삭제
	{
		$mode = $this->input->get("mode");
		$idx = $this->input->get("idx");
		if($mode=="list_img"){
			$result = $this->board_m->file_del('',$idx);
		}else if($mode=="list_img2"){
			$result = $this->board_m->file_del('2',$idx);
		}else{
			$result = $this->common_m->file_del('bbs',$idx);
		}
	}



	public function bbs_sort()
	{

		if($this->input->get("hidden_bbs_list")) {
			$arr_goods_list = explode("&&", $this->input->get("hidden_bbs_list") );
			foreach($arr_goods_list as $key=>$val) {
				if($val){
					$this->common_m->update2("dh_bbs_data",array('sort'=>$key),array('idx'=>$val));
				}
			}
		}

		$code = $this->input->get("code");
		$cate_idx = $this->input->get("cate_idx");
		$cate_no = $this->input->get("cate_no");

		$where_query = "where code='$code'";

		if($cate_idx){
			$where_query.=" and cate_idx='$cate_idx'";
			$data['row'] = $this->common_m->getRow("dh_bbs_cate","where idx='$cate_idx'");
		}else if($cate_no){
			$where_query.=" and cate_no='$cate_no'";
			$data['row'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no'");
		}else{
			$data['row'] = $this->common_m->getRow("dh_bbs","where code='$code'");
		}

		$data['list'] = $this->common_m->getList2("dh_bbs_data","$where_query order by sort, idx desc");

		$this->load->view("/dhadm/bbs/bbs_sort",$data);
	}


	public function best_prd()
	{
		// post 로 받은 값 중 게시물 idx ^ 단위 배열 처리
		// 1^2^3^
		// 1,2,3,4 >> in_query > row data > copy > insert
		// explode > , foreach >
		// 배열처리된
		// row data 호출

    // post로 넘어온 값 있을때 (개인정보처리방침 hidden으로 값 넘김)
		if($_POST){
			$param = $this->input->post('param');
			$idx = $this->input->post('idx');

			$param = substr($param,1);

			$list = $this->common_m->self_q("select * from dh_bbs_data where code='safeguard_content' and idx in ($param)","result"); //in을 이용해서 괄호내에 일치한것 불러오기

				foreach($list as $lt){	// 로우에 대한 반복문
				foreach($lt as $k=>$v){	//컬럼에 대한 반복문
					if($k != 'idx' && $k != 'reg_date' && $k != 'data1'){ //idx,reg_date,data1(릴레이션값)은 제외하고 copy
						$insert[$k] = $v;
					}
				}

				$insert['reg_date'] = timenow();
				$insert['data1'] = $idx;

				//pr($insert);

				$result = $this->common_m->insert2('dh_bbs_data',$insert);
			}

			if($result){
				?>
				<script type="text/javascript">
					alert("게시물 복사가 완료 되었습니다.");
					opener.location.reload(); //리로드 시켜주고
					self.close();//창 close
				</script>
				<?php
			}
		}
		// post로 넘어온 값 있을때 (개인정보처리방침 hidden으로 값 넘김)

		$data['query_string'] = "?";

		$code = $this->uri->segment(3);
		$subject = $this->input->get('subject');
		$cate_no1 = $this->input->get('cate_no1');
		$cate_no2 = $this->input->get('cate_no2');
		$where_query=" where code='$code'";
		$list='';

		$num="";

		if($cate_no2){
			$where_query .= " and cate_no like '".$cate_no2."%'";
		}else if($cate_no1){
			$where_query .= " and cate_no like '".$cate_no1."-%'";
		}

		if($subject){ $data['query_string'].= "&subject=".$subject; $where_query .= " and subject like '%".$subject."%'"; }

			$this->load->model('product_m');
			$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트


			$data['totalCnt'] = $this->common_m->getPageList('dh_bbs_data','count','','',$where_query); //게시판 리스트
			$data['list'] = $this->common_m->getPageList('dh_bbs_data','','','',$where_query); //게시판 리스트
			$data['safeguard_list'] = $this->common_m->self_q("select * from dh_bbs_data where code='safeguard' order by reg_date desc limit 1","result"); //개인정보처리방침


			$data['code'] = $code;
			$this->load->view("/dhadm/bbs/best_prd_pop", $data);
	}





}