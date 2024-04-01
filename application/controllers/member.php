<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

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
		$this->main();
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
		$id = $this->input->get('id');
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}

	public function main()
	{
		$today = date("Y-m-d");
		$data['total_member'] = $this->common_m->getCnt("dh_member","where outmode=0");
		$data['today_member'] = $this->common_m->getCnt("dh_member","where outmode=0 and register like '$today%'");
		$data['out_member'] = $this->common_m->getCnt("dh_member","where outmode=1");
		$data['list'] = $this->common_m->getList("dh_member","where outmode=0 and register like '$today%'");		
		$this->load->view('/dhadm/member/main', $data);
	}


	public function user($flag='',$excel='') //회원관리 - 리스트
	{

		if(count($flag) > 1){ $flag=""; }

		$data['query_string'] = "?";
		$data['flag'] = $flag;
		$return_url = cdir()."/".$this->uri->segment(1)."/user/m";

		if($flag=="ago"){ //휴먼계정 일 경우		
			$ago = date("Y-m-d",strtotime("last year"));
			$where_query = " where last_login < '$ago' and connect < 1 ";
		}else{
			$where_query = " where 1 ";
		}
		$order_query = " idx desc";
		
		$search_flag = $this->input->get('search_flag');
		$search_level = $this->input->get('search_level');
		$search_mailing = $this->input->get('search_mailing');
		$search_local = $this->input->get('search_local');
		$outmode = $this->input->get('outmode');
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$order = $this->input->get('order');

		if($flag=="outmode"){ $outmode="1"; }

		if(!$outmode){ $outmode = 0; }

		$mode = $this->uri->segment(4);
		$data['order'] = $order;

		$where_query .= " and outmode=$outmode";
		$data['query_string'].= "outmode=$outmode";
		$data['query_string'].="&order=$order";

		if($search_flag){
			if($search_flag != "local"){
				$where_query .= " and $search_flag = '".${'search_'.$search_flag}."'";
			}else{
				$where_query .= " and add1 like '".${'search_'.$search_flag}."%'";
			}
			$data['query_string'].="&search_flag=$search_flag&search_level=$search_level&search_mailing=$search_mailing&search_local=$search_local";
		}
			
		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		
		$data['param']="";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		switch($order)
		{
			case 2 :
				$order_query = " name asc";
			break;
			case 3 :
				$order_query = " userid asc";
			break;
			case 4 :
				$order_query = " register asc";
			break;
		}


		$data['city_row'] = $this->common_m->getGroup("dh_zip","city"); //지역 data
		$data['level_row'] = $this->common_m->getList("dh_member_level"); //회원 등급 data


		if($this->uri->segment(4) == "write"){

			if($this->input->get("idCheck")==1 && $this->input->get("userid")){ //중복확인 iframe
				$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->input->get("userid",TRUE)."'");
				if($cnt){
					script_exe('alert("입력하신 아이디는 현재 사용중입니다.\n다른 아이디를 입력하여주세요."); parent.document.frm.userid_chk.value=""; parent.document.frm.userid.value=""; parent.document.frm.userid.focus();');
				}else{
					script_exe('alert("입력하신 아이디는 사용 가능합니다."); parent.document.frm.userid_chk.value="1"; parent.document.frm.passwd.focus();');
				}
			}else if($this->input->post('userid') && $this->input->post('name')){
			
				$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->input->get("userid",TRUE)."'");
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
							'level' => $this->input->post('level'),
							'mailing' => $this->input->post('mailing',TRUE)
						);		
						
						$result = $this->member_m->insert('member',$write_data); //회원 추가
						
						
						$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
						if($result && $data['shop_info']['shop_use']=='y' && $data['shop_info']['point_register'] > 0){ //쇼핑몰사용이면 포인트지급										
							$insert_array = array(
								'userid' => $this->input->post('userid',TRUE),
								'point' => $data['shop_info']['point_register'],
								'content' => '신규가입 축하포인트 지급',
								'flag' => 'join'
							);

							$result = $this->member_m->point_insert($insert_array);
						}
						
						
						result($result, "등록", $return_url);
					}
			
			}else{
				$this->load->view('/dhadm/member/write', $data);
			}

		}else if($mode=="edit"){
		
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post('userid') && $this->input->post('name')){

					if($this->input->post('passwd',TRUE)){
						$passwd = md5($this->input->post('passwd',TRUE));
					}else{
						$passwd = $data['row']->passwd;						
					}					
					
					$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);
				
					$edit_data = array(
						'table' => 'dh_member',
						'idx' => $idx,
						'passwd' => $passwd,
						'userid' => $this->input->post('userid',TRUE),
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
						'level' => $this->input->post('level'),
						'mailing' => $this->input->post('mailing',TRUE)
					);
						
				$result = $this->member_m->update('member',$edit_data);

				result($result, "수정", $return_url.$data['query_string'].$data['param']);
				
			}else{
				$this->load->view('/dhadm/member/write',$data);
			}

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){
			
			if($this->input->post('out') == 1){ //완전삭제
				
				$row = $this->common_m->getRow("dh_member","where idx='".$this->input->post('del_idx')."'");
				$result = $this->common_m->del("dh_point","userid", $row->userid); //포인트삭제
				$result = $this->common_m->del("dh_trade","userid", $row->userid); //거래내역삭제
				$result = $this->common_m->del("dh_bbs_data","userid", $row->userid); //게시판내역삭제
				$result = $this->common_m->del("dh_bbs_coment","userid", $row->userid); //게시판댓글내역삭제 
				$result = $this->common_m->del("dh_member","userid", $row->userid); //멤버 완전 삭제
				//쿠폰,wishlist 는 추후에 삭제

				$return_url = cdir()."/".$this->uri->segment(1)."/out/m";
				result($result, "삭제", $return_url);

			}else{

				$del_data = array(
					'table' => 'dh_member',
					'idx' => $this->input->post('del_idx')
				);

				$result = $this->member_m->update('member_del',$del_data);
				
				result($result, "탈퇴처리", $return_url);

			}
		
		}else{
			
			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_member','count','','',$where_query,$order_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			if($excel=="1"){ //엑셀다운
			
				$data['list'] = $this->common_m->getPageList('dh_member m','','','',$where_query,$order_query,"m.*,(select name from dh_member_level where level=m.level) as level_name"); //게시판 리스트	
				$this->load->view("/dhadm/excel/".$this->input->get('id'),$data); //엑셀다운

			}else{

				$data['list'] = $this->common_m->getPageList('dh_member m','',$offset,$list_num,$where_query,$order_query,"m.*,(select name from dh_member_level where level=m.level) as level_name"); //게시판 리스트
				$this->load->view('/dhadm/member/list', $data);
			}

		}
	}
	
	public function out() //회원관리 - 휴먼계정 리스트
	{		
		$this->user('outmode');
	}

	
	public function ago() //회원관리 - 휴먼계정 리스트
	{		
		$this->user('ago');
	}


	public function level($data) //회원관리 - 회원등급 관리
	{		
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$mode = $this->uri->segment(4);
		$data['level_row'] = $this->common_m->getList("dh_member_level");
		$return_url = $data['return_url'];

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}

		
		if($this->uri->segment(4) == "write"){
			
			if($this->input->post("level") && $this->input->post("name")){
				
				$level_cnt = $this->common_m->getCount("dh_member_level","where level='".$this->input->post("level")."'");
				if($level_cnt==0){
			
						$write_data = array(
							'table' => 'dh_member_level',
							'level' => $this->input->post('level',TRUE),
							'name' => $this->input->post('name',TRUE)
						);
						
						$result = $this->admin_m->insert('member_level',$write_data); //회원 등급 추가
						
						result($result, "등록", $return_url);
				}else{
					back("입력하신 level은 현재 사용중 입니다.");
				}

			}else{
				$this->load->view('/dhadm/member/level_write', $data);
			}

		}else if($this->uri->segment(4) == "edit"){
		
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member_level", "where idx='".$this->db->escape_str($idx)."'");
			
			if($this->input->post("level") && $this->input->post("name")){

				$level_cnt = $this->common_m->getCount("dh_member_level","where level='".$this->input->post("level")."' and level!='".$data['row']->level."'");
				
				if($level_cnt==0){

						$edit_data = array(
							'table' => 'dh_member_level',
							'idx' => $idx,
							'level' => $this->input->post('level',TRUE),
							'name' => $this->input->post('name',TRUE)
						);
						
						$result = $this->admin_m->update('member_level',$edit_data);
						
						result($result, "수정", $return_url);

				}else{
					back("입력하신 level은 현재 사용중 입니다.");
				}
			}else{
				$this->load->view('/dhadm/member/level_write', $data);
			}

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){
			
			$result = $this->common_m->del("dh_member_level","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $return_url);
		
		}else{

			/* 페이징 start */
			$PageNumber = $this->uri->segment(4,1); //현재 페이지
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_member_level','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_member_level','',$offset,$list_num,$where_query); //게시판 리스트


			$this->load->view('/dhadm/member/level', $data);
		}
	}


	public function point()
	{
		$idx = $this->uri->segment(3);
		$data['mem_row']=$this->common_m->getRow("dh_member","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_point","where userid='".$data['mem_row']->userid."' order by idx desc");
		$data['total_point'] = $this->common_m->getSum("dh_point","point", "where userid='".$data['mem_row']->userid."'");
		
		if($this->input->post("content") && $this->input->post("sum") && $this->input->post("point")){

			$insert_array = array(
				'userid' => $data['mem_row']->userid,
				'point' => $this->input->post("sum").$this->input->post("point",TRUE),
				'content' => $this->input->post("content",TRUE),
				'flag' => 'admin'
			);

			$result = $this->member_m->point_insert($insert_array);
			result($result, "등록", cdir()."/".$this->uri->segment(1)."/point/".$idx."/?ajax=1");
		
		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){
			
			$result = $this->common_m->del("dh_point","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/".$this->uri->segment(1)."/point/".$idx."/?ajax=1");
		
		}else{

			$this->load->view('/dhadm/member/point', $data);
		}
	}


	public function coupon()
	{
		$idx = $this->uri->segment(3);
		$data['mem_row']=$this->common_m->getRow("dh_member","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_coupon_use","where userid='".$data['mem_row']->userid."' order by idx desc");
		$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where userid='".$data['mem_row']->userid."'");

		if($this->input->post("code") && $this->input->post("search")==1){
			$code = $this->input->post("code",true);
			$where_query = "where code like '%".$code."%'";
			$codeCnt = $this->common_m->getCount("dh_coupon",$where_query);
			$data['codeCnt'] = $codeCnt;
			if($codeCnt){
				$data['couponList'] = $this->common_m->getList2("dh_coupon","$where_query order by name","*,(select name from dh_member_level where level=member_level) as level_name");;
			}
		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){
			
			$result = $this->common_m->del("dh_coupon_use","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/".$this->uri->segment(1)."/coupon/".$idx."/?ajax=1");
		
		}


		$this->load->view('/dhadm/member/coupon', $data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */