<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_Member extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('member_m');
    $this->load->model('product_m');
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
		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		$this->{"{$method}"}($data);
	}


	public function main()
	{
		$this->count_m->count_add();
		$this->load->view('/html/main');
		$data['popup'] = $this->common_m->popup_list('where'); //팝업 불러오기
		$this->load->view('/common/popup',$data);
	}


	public function login($data='')
	{
		if($this->session->userdata('USERID')){
			result(1,'','/dh_member/mypage');
		}else{

			if($this->input->post('userid') && $this->input->post('passwd')){ //로그인

				$auth_data = array(
				'userid' => $this->input->post('userid',TRUE),
				'passwd' => $this->input->post('passwd',TRUE)
				);
				$result = $this->member_m->user_login($auth_data);

				if($result)
				{
					$newdata = array(
					'USERID' => $result->userid,
					'PASSWD' => $result->passwd,
					'NAME' => $result->name,
					'LEVEL' => $result->level

					);

					$this->session->set_userdata($newdata);


						$update_data = array(
							'table' => 'dh_member',
							'userid' => $result->userid,
							'passwd' => $result->passwd
						);

					$this->member_m->update('login_member',$update_data);

					$result = $this->common_m->getRow("dh_member","where userid='".$result->userid."'");
					$go_url="";


					if($this->input->post("save_id")){
						$cookie_id = $this->input->post("userid");
						setcookie('cookie_id',$cookie_id,time()+864000,'/');
					}else{
						setcookie('cookie_id','',0,'/');
					}


					if($this->input->post('go_url')){
						$view_page = $this->input->post('go_url');
						$go_url = "?go_url=".$this->input->post('go_url');
					}else{
						$view_page = "/";
					}

						$date = date("Y-m-d",strtotime("-6 month",strtotime(date("Y-m-d"))));

						$edit_date = substr($result->edit_date,0,10);
						$register = substr($result->register,0,10);

						if($edit_date == "0000-00-00" && $register < $date){ //회원 가입 후 6개월 간 비밀번호 변경 내역이 있는지검사
							$view_page = "/dh_member/change_pw".$go_url;
						}else if($edit_date != "0000-00-00" && $edit_date < $date){ //비밀번호 변경 후 6개월 간 내역이 있는지 검사
							$view_page = "/dh_member/change_pw".$go_url;
						}

						alert($view_page);


				}else{
					back('아이디와 패스워드가 올바르지 않습니다.');
				}

			}else{
				$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
				$view="login";
				$data['view'] = $dir.$view;

				if($this->input->get("go_url")){
					$data['go_url'] = $this->input->get("go_url");
				}else if($this->input->post("go_url")){
					$data['go_url'] = $this->input->post("go_url");
				}

				$this->load->view('/html/'.$view, $data);
			}

		}
	}


	public function logout() //유저 로그아웃
	{
		$array_items = array('USERID' => '', 'PASSWD' => '', 'NAME' => '', 'LEVEL' => '', 'CART' => '');
		$this->session->unset_userdata($array_items);

		alert(cdir());

	}



	public function join($data='')
	{
		$userChk = $this->uri->segment(3);
		if($userChk && $this->input->get("userChkid")){

			$userChkid = $this->input->get("userChkid",true);
			$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userChkid)."' and outmode!=1");
			echo $cnt;

		}else{

			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";


				if($this->input->get("agree")==1){
					if($this->input->get("ok")==1){

						if($this->input->post('userid') && $this->input->post('name')){

							$userid = $this->input->get("userid",TRUE);
							$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userid)."'");
							if($cnt){
								back('이미 사용중인 아이디 입니다.');
							}else{

								$passwd = md5($this->input->post('passwd',TRUE));

								$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

								$write_data = array(
									'table' => 'dh_member',
									'userid' => $this->input->post('userid',TRUE),
									'passwd' => $passwd,
									'name' => $this->input->post('name',TRUE),
									'birth_year' => $this->input->post('birth_year',TRUE),
									'birth_month' => $this->input->post('birth_month',TRUE),
									'birth_date' => $this->input->post('birth_date',TRUE),
									'birth_gubun' => $this->input->post('birth_gubun',TRUE),
									'email' => $email,
									'tel1' => $this->input->post('tel1',TRUE),
									'tel2' => $this->input->post('tel2',TRUE),
									'tel3' => $this->input->post('tel3',TRUE),
									'phone1' => $this->input->post('phone1',TRUE),
									'phone2' => $this->input->post('phone2',TRUE),
									'phone3' => $this->input->post('phone3',TRUE),
									'zip1' => $this->input->post('zip1',TRUE),
									'zip2' => $this->input->post('zip2',TRUE),
									'add1' => $this->input->post('add1',TRUE),
									'add2' => $this->input->post('add2',TRUE),
									'level' => 1,
									'mailing' => $this->input->post('mailing',TRUE)
								);

								$result = $this->member_m->insert('member',$write_data); //회원 추가

								if($result){
									$idx = $result;

									if($data['shop_info']['shop_use']=='y'){ //쇼핑몰사용이면 포인트지급
										$insert_array = array(
											'userid' => $this->input->post('userid',TRUE),
											'point' => $data['shop_info']['point_register'],
											'content' => '신규가입 축하포인트 지급',
											'flag' => 'join'
										);

										$result = $this->member_m->point_insert($insert_array);
									}

									result($result, "", cdir()."/dh_member/join?agree=1&ok=1&idx=".$idx);

								}else{
									back('회원가입에 실패하였습니다. 다시 시도하여 주세요.');
									exit;
								}
							}

						}else{
							$idx = $this->input->get("idx",TRUE);
							$data['row'] = $this->common_m->getRow("dh_member","where idx='".$this->db->escape_str($idx)."'");
							$view = "join_ok";
						}

					}else if($this->input->post('agree01')==1 && $this->input->post('agree02')==1){
						$view = "join02";
					}else{
						back();
					}

				}else{
					$data['agreement'] = $this->common_m->getRow("dh_page", "where page_index='agreement'");
					$data['safeguard'] = $this->common_m->getRow("dh_page", "where page_index='safeguard'");
					$view = "join01";
				}

				$data['view'] = $dir.$view;

				$this->load->view('/html/'.$view, $data);

				}

	}


	public function mypage($data='')
	{
		if(!$this->session->userdata('USERID')){
			alert('/dh_member/login/?go_url=/html/dh_member/mypage/');
			exit;
		}

		$userid = $this->session->userdata('USERID');
		$data['row'] = $this->common_m->getRow("dh_member","where userid='".$this->db->escape_str($userid)."' and outmode!=1");



			if($this->input->post('idx')){

				$passwd = md5($this->input->post('passwd',TRUE));

				$pwd_cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userid)."' and passwd='".$this->db->escape_str($passwd)."'");
				if($pwd_cnt==0){ back('비밀번호가 일치하지 않습니다.'); exit; }

				if($this->input->post('new_passwd',TRUE)){
					$passwd = md5($this->input->post('new_passwd',TRUE));
				}else{
					$passwd = $data['row']->passwd;
				}

				$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

				$update_data = array(
					'table' => 'dh_member',
					'userid' => $this->input->post('userid',TRUE),
					'idx' => $this->input->post('idx'),
					'passwd' => $passwd,
					'name' => $this->input->post('name',TRUE),
					'birth_year' => $this->input->post('birth_year',TRUE),
					'birth_month' => $this->input->post('birth_month',TRUE),
					'birth_date' => $this->input->post('birth_date',TRUE),
					'birth_gubun' => $this->input->post('birth_gubun',TRUE),
					'email' => $email,
					'tel1' => $this->input->post('tel1',TRUE),
					'tel2' => $this->input->post('tel2',TRUE),
					'tel3' => $this->input->post('tel3',TRUE),
					'phone1' => $this->input->post('phone1',TRUE),
					'phone2' => $this->input->post('phone2',TRUE),
					'phone3' => $this->input->post('phone3',TRUE),
					'zip1' => $this->input->post('zip1',TRUE),
					'zip2' => $this->input->post('zip2',TRUE),
					'add1' => $this->input->post('add1',TRUE),
					'add2' => $this->input->post('add2',TRUE),
					'level' => "1",
					'mailing' => $this->input->post('mailing',TRUE)
				);

				$result = $this->member_m->update('member',$update_data);


				if($result)
				{
					$userid = $this->input->post('userid',TRUE);
					if($this->input->post('userid',TRUE)==""){
						$userid = $this->session->userdata('USERID');
					}

					$newdata = array(
					'USERID' => $userid,
					'PASSWD' => $passwd,
					'NAME' => $this->input->post('name',TRUE)
					);

					$this->session->set_userdata($newdata);

					alert('/','수정되었습니다');
				}
				else
				{
					back('수정에 실패하였습니다.');
				}

		}else{

			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
			$view = "mypage";
			$data['view'] = $dir.$view;
			$this->load->view('/html/'.$view, $data);

		}
	}


	public function change_pw($data='') //회원가입 후 6개월간 비밀번호 변경안햇을 시 나오는 페이지
	{
		if(!$this->session->userdata('USERID')){
			alert(cdir().'/dh_member/login/?go_url='.cdir().'/dh_member/change_pw/');
			exit;
		}

		$data['mem_stat'] = $this->common_m->getRow2("dh_member","where userid='".$this->session->userdata('USERID')."'"); // 유저 정보


				if($this->input->post('idx') && $this->input->post('passwd_old') && $this->input->post('passwd')){

				$go_url = $this->input->post('go_url');

				if(!$go_url){ $go_url = "/"; }


					$passwd_old = md5($this->input->post('passwd_old'));

					if($passwd_old != $data['mem_stat']->passwd){
						alert(cdir().'/dh_member/change_pw/?go_url='.$go_url,'현재 비밀번호가 정확하지 않습니다.');
					}else{

						$passwd = md5($this->input->post('passwd',TRUE));

						$update_data = array(
							'table' => 'dh_member',
							'userid' => $this->input->post('userid',TRUE),
							'idx' => $this->input->post('idx'),
							'passwd' => $passwd
						);

						$result = $this->member_m->update('member_pwd',$update_data);


						if($result)
						{

							$newdata = array(
							'USERID' => $data['mem_stat']->userid,
							'PASSWD' => $passwd,
							'NAME' => $data['mem_stat']->name
							);

							$this->session->set_userdata($newdata);

							alert($go_url,'비밀번호가 변경되었습니다.');
						}

					}

				}

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
		$view = "change_pw";
		$data['view'] = $dir.$view;
		$this->load->view('/member/'.$view, $data);
	}


	public function leave($data='')
	{
		if(!$this->session->userdata('USERID')){
			alert(cdir().'/dh_member/login/?go_url='.cdir().'/dh_member/leave/');
			exit;
		}

		$userid = $this->session->userdata('USERID');
		$data['row'] = $this->common_m->getRow("dh_member","where userid='$userid' and outmode!=1");


		if($this->input->post('del_idx')){
			$passwd = md5($this->input->post('passwd',TRUE));
			$cnt = $this->common_m->getCount("dh_member","where userid='$userid' and outmode!=1 and passwd='".$passwd."'");
			if($cnt){

			$del_data = array(
				'table' => 'dh_member',
				'idx' => $this->input->post('del_idx', TRUE),
				'outtype' => $this->input->post('outtype', TRUE),
				'outmsg' => $this->input->post('outmsg'),
			);

			$result = $this->member_m->update('member_del',$del_data);

			result($result, "탈퇴처리", cdir()."/dh_member/logout");

			}else{
				back('비밀번호가 일치하지 않습니다.');
				exit;
			}

		}else{

			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
			$view = "leave";
			$data['view'] = $dir.$view;
			$this->load->view('/html/'.$view, $data);

		}
	}


	public function find_id($data='')
	{
		if($this->session->userdata('USERID')){
			result(1,'','/dh_member/mypage');
			exit;
		}

		$name = $this->db->escape_str($this->input->post('name',true));
		$phone1 = $this->db->escape_str($this->input->post('phone1',true));
		$phone2 = $this->db->escape_str($this->input->post('phone2',true));
		$phone3 = $this->db->escape_str($this->input->post('phone3',true));
		$email = $this->db->escape_str($this->input->post('email',true));
		$data['find_cnt'] = 0;

		if($this->input->post('find_mode') && $name){

			if($this->input->post('find_mode')==1 && $phone1 && $phone2 && $phone3){

				$find_cnt = $this->common_m->getCount("dh_member","where name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");
				$findRow = $this->common_m->getRow("dh_member","where name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");


			}else if($this->input->post('find_mode')==2 && $email){

				$find_cnt = $this->common_m->getCount("dh_member","where name='$name' and email='$email'");
				$findRow = $this->common_m->getRow("dh_member","where name='$name' and email='$email'");


			}

			if($find_cnt > 0){

				$data['findRow'] = $findRow;
				$data['find_cnt'] = 1;

			}else{
				back("일치하는 정보가 없습니다.");
				exit;
			}

		}

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
		$view = "find_id";
		$data['view'] = $dir.$view;
		$this->load->view('/html/'.$view, $data);


	}

	public function find_pw($data='')
	{
		if($this->session->userdata('USERID')){
			result(1,'','/dh_member/mypage');
			exit;
		}

		$userid = $this->db->escape_str($this->input->post('userid',true));
		$name = $this->db->escape_str($this->input->post('name',true));
		$phone1 = $this->db->escape_str($this->input->post('phone1',true));
		$phone2 = $this->db->escape_str($this->input->post('phone2',true));
		$phone3 = $this->db->escape_str($this->input->post('phone3',true));
		$email = $this->db->escape_str($this->input->post('email',true));
		$data['find_cnt'] = 0;


		if($this->input->post('find_mode') && $userid && $name){

			if($this->input->post('find_mode')==1 && $phone1 && $phone2 && $phone3){

				$find_cnt = $this->common_m->getCount("dh_member","where userid = '{$userid}' and name='{$name}' and phone1='{$phone1}' and phone2='{$phone2}' and phone3='{$phone3}'");
				$findRow = $this->common_m->getRow("dh_member","where userid = '{$userid}' and name='{$name}' and phone1='{$phone1}' and phone2='{$phone2}' and phone3='{$phone3}'");


			}else if($this->input->post('find_mode')==2 && $email){

				$find_cnt = $this->common_m->getCount("dh_member","where userid = '{$userid}' and name='{$name}' and email='{$email}'");
				$findRow = $this->common_m->getRow("dh_member","where userid = '{$userid}' and name='{$name}' and email='{$email}'");


			}

			if($find_cnt > 0){

				$data['findRow'] = $findRow;
				$result = $this->common_m->mailform("2",$data);
				if($result){
					$data['find_cnt'] = 1;
				}

			}else{
				back("일치하는 정보가 없습니다.");
				exit;
			}

		}



		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
		$view = "find_pw";
		$data['view'] = $dir.$view;
		$this->load->view('/html/'.$view, $data);

	}

	public function post_search($data='')
	{
		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
		$view = "post_search";
		$data['view'] = $dir.$view;
		$this->load->view('/member/'.$view, $data);

	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */