<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function login($auth)
		{
			$sql = "select * from dh_admin_user where userid='".$this->db->escape_str($auth['admin_userid'])."' and passwd='".$this->db->escape_str(md5($auth['admin_passwd']))."'";
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				
				$result = $query->row();				
			
				$update_array = array(
					'connect' => $result->connect+1
				);
				
				$where = array(
					'userid' => $this->db->escape_str($auth['admin_userid'])
				);

				$result2 = $this->db->update('dh_admin_user',$update_array,$where); //접속수 증가

				return $query->row();
			}
			else
			{
				return FALSE;
			}
		}


		function user_login($auth)
		{
			$passwd = md5($auth['passwd']);

			$sql = "select * from dh_member where userid='".$this->db->escape_str($auth['userid'])."' and passwd='".$this->db->escape_str($passwd)."' and outmode!=1";

			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				$cnt = $this->common_m->getCount("dh_coupon","where type='1'"); //기념일쿠폰 검사
				if($cnt > 0){ //기념일 쿠폰이 있으면
					$row = $query->row();
					$couponList = $this->common_m->getList2("dh_coupon","where type='1' and ((member_use=1 and member_level!='' and member_level='".$row->level."') or member_use=0) order by idx");
					$nowyear = date("Y");
					$nowmonth = date("m");
					$this->load->model('order_m');
					foreach($couponList as $list){
						if($row->birth_month==$nowmonth){ //로그인 한 달이 기념일 달이면
							$couponGivCnt = $this->common_m->getCount("dh_coupon_use","where code='".$list->code."' and type='1' and userid='".$this->db->escape_str($auth['userid'])."' and reg_date like '".$nowyear."-%'"); //올해 기념일 쿠폰을 지급한적 있는지 검사
							if($couponGivCnt==0){ //올해 지급내용 없으면 쿠폰 지급
								$list->userid = $auth['userid'];
								$result = $this->order_m->couponGive($list);
							}
						}
					}
				}

				$cart = $this->session->userdata('CART');
				$cartCnt = $this->common_m->getCount("dh_cart","where code='".$cart."'");

				if($cartCnt>0){
					$this->common_m->update2("dh_cart",array('userid'=>$this->db->escape_str($auth['userid'])),array('code'=>$cart));
				}

				return $query->row();
			}
			else
			{
				return FALSE;
			}
		}

		
		function insert($mode,$arrays) //등록하기
		{
			if($mode == "member"){
				
					$insert_array = array(
						'userid' => $this->db->escape_str($arrays['userid']),
						'passwd' => $this->db->escape_str($arrays['passwd']),
						'name' => $this->db->escape_str($arrays['name']),
						'birth_year' => $this->db->escape_str($arrays['birth_year']),
						'birth_month' => $this->db->escape_str($arrays['birth_month']),
						'birth_date' => $this->db->escape_str($arrays['birth_date']),
						'birth_gubun' => $this->db->escape_str($arrays['birth_gubun']),
						'email' => $this->db->escape_str($arrays['email']),
						'tel1' => $this->db->escape_str($arrays['tel1']),
						'tel2' => $this->db->escape_str($arrays['tel2']),
						'tel3' => $this->db->escape_str($arrays['tel3']),
						'phone1' => $this->db->escape_str($arrays['phone1']),
						'phone2' => $this->db->escape_str($arrays['phone2']),
						'phone3' => $this->db->escape_str($arrays['phone3']),
						'zip1' => $this->db->escape_str($arrays['zip1']),
						'zip2' => $this->db->escape_str($arrays['zip2']),
						'add1' => $this->db->escape_str($arrays['add1']),
						'add2' => $this->db->escape_str($arrays['add2']),
						'level' => $this->db->escape_str($arrays['level']),
						'mailing' => $this->db->escape_str($arrays['mailing']),
						'register' => date('Y-m-d H:i:s')
					);
			}

			$result = $this->db->insert($arrays['table'],$insert_array);
			$a_idx = mysql_insert_id();

			if($mode=="member" && $result){
				$data['idx'] = $a_idx;
				$result = $this->common_m->mailform(1,$data); //메일보내기

				$cnt = $this->common_m->getCount("dh_coupon","where type='2'");

				if($cnt > 0){ //회원가입 쿠폰이 있으면 지급
					$couponList = $this->common_m->getList2("dh_coupon","where type='2' order by idx");
					$this->load->model('order_m');
					foreach($couponList as $list){
						$list->userid = $arrays['userid'];
						$result = $this->order_m->couponGive($list);
					}
				}

				if($result){
					$result = $a_idx;
				}
			}

			return $result;
		}


		function update($mode,$arrays)
		{
			if($mode == "member"){ //멤버 수정

			
				$sql = "select * from dh_member where idx='".$arrays['idx']."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();

				if($arrays['userid']=="")				{ $arrays['userid']		= $memstat->userid; }
				if($arrays['name']=="")					{ $arrays['name']		= $memstat->name; }
				if($arrays['birth_year']=="")		{ $arrays['birth_year']		= $memstat->birth_year; }
				if($arrays['birth_month']=="")	{ $arrays['birth_month']	= $memstat->birth_month; }
				if($arrays['birth_date']=="")		{ $arrays['birth_date']		= $memstat->birth_date; }
				if($arrays['birth_gubun']=="")	{ $arrays['birth_gubun']	= $memstat->birth_gubun; }
				if($arrays['email']=="")				{ $arrays['email']				= $memstat->email; }
				if($arrays['tel1']=="")					{ $arrays['tel1']					= $memstat->tel1; }
				if($arrays['tel2']=="")					{ $arrays['tel2']					= $memstat->tel2; }
				if($arrays['tel3']=="")					{ $arrays['tel3']					= $memstat->tel3; }
				if($arrays['phone1']=="")				{ $arrays['phone1']				= $memstat->phone1; }
				if($arrays['phone2']=="")				{ $arrays['phone2']				= $memstat->phone2; }
				if($arrays['phone3']=="")				{ $arrays['phone3']				= $memstat->phone3; }
				if($arrays['zip1']=="")					{ $arrays['zip1']					= $memstat->zip1; }
				if($arrays['zip2']=="")					{ $arrays['zip2']					= $memstat->zip2; }
				if($arrays['add1']=="")					{ $arrays['add1']					= $memstat->add1; }
				if($arrays['add2']=="")					{ $arrays['add2']					= $memstat->add2; }
				if($arrays['level']=="")				{ $arrays['level']				= $memstat->level; }
				if($arrays['mailing']=="")			{ $arrays['mailing']			= $memstat->mailing; }

				if($memstat->passwd!=$arrays['passwd']){
					$edit_date = date('Y-m-d H:i:s');
				}else{
					$edit_date = $memstat->edit_date;
				}

				$update_array = array(
					'userid' => $this->db->escape_str($arrays['userid']),
					'passwd' => $this->db->escape_str($arrays['passwd']),
					'name' => $this->db->escape_str($arrays['name']),
					'birth_year' => $this->db->escape_str($arrays['birth_year']),
					'birth_month' => $this->db->escape_str($arrays['birth_month']),
					'birth_date' => $this->db->escape_str($arrays['birth_date']),
					'birth_gubun' => $this->db->escape_str($arrays['birth_gubun']),
					'email' => $this->db->escape_str($arrays['email']),
					'tel1' => $this->db->escape_str($arrays['tel1']),
					'tel2' => $this->db->escape_str($arrays['tel2']),
					'tel3' => $this->db->escape_str($arrays['tel3']),
					'phone1' => $this->db->escape_str($arrays['phone1']),
					'phone2' => $this->db->escape_str($arrays['phone2']),
					'phone3' => $this->db->escape_str($arrays['phone3']),
					'zip1' => $this->db->escape_str($arrays['zip1']),
					'zip2' => $this->db->escape_str($arrays['zip2']),
					'add1' => $this->db->escape_str($arrays['add1']),
					'add2' => $this->db->escape_str($arrays['add2']),
					'level' => $this->db->escape_str($arrays['level']),
					'mailing' => $this->db->escape_str($arrays['mailing']),
					'edit_date' => $edit_date
				);


				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "member_del"){ //멤버 탈퇴

				if(isset($arrays['outtype']) && $arrays['outtype']!=""){
				
					$update_array = array(
						'outmode' => 1,
						'outtype' => $this->db->escape_str($arrays['outtype']),
						'outmsg' => $this->db->escape_str($arrays['outmsg'])
					);	

				}else{
					$update_array = array('outmode' => 1);		
				}
				$where = array('idx' => $this->db->escape_str($arrays['idx']));

			}else if($mode == "login_member"){

				$sql = "select * from dh_member where userid='".$this->db->escape_str($arrays['userid'])."' and passwd='".$this->db->escape_str($arrays['passwd'])."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();

				
				$update_array = array(
					'connect' => $memstat->connect + 1,
					'last_login' => date('Y-m-d H:i:s')
				);


				$where = array(
					'userid' => $arrays['userid'],
					'passwd' => $arrays['passwd'],
				);

			}else if($mode == "member_pwd"){

				$update_array = array(
					'passwd' => $arrays['passwd'],
					'edit_date' => date('Y-m-d H:i:s')
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "passwd"){
				
				$update_array = array(
					'passwd' => md5($arrays['passwd'])
				);

				$where = array(
					'userid' => $this->db->escape_str($arrays['userid']),
					'name' => $this->db->escape_str($arrays['name'])
				);

			}
			
			$result = $this->db->update($arrays['table'],$update_array,$where);
			
			if($result && $mode == "member_del"){ //회원탈퇴면 게시판, 포인트, 쿠폰, 주문내역 등 삭제
				
				$sql = "select * from dh_member where idx='".$this->db->escape_str($arrays['idx'])."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();

				$result = $this->common_m->del("dh_bbs_data","userid", $memstat->userid);
				$result = $this->common_m->del("dh_point","userid", $memstat->userid);
				$result = $this->common_m->del("dh_coupon_use","userid", $memstat->userid);
				$result = $this->common_m->del("dh_trade","userid", $memstat->userid);
			}

			return $result;
		}


		
		function point_insert($arrays) //포인트 등록하기
		{
			$flag="";
			$flag_idx="";
			$trade_code="";
			$sum="";

			if(isset($arrays['sum']) && $arrays['sum']=="-"){ $sum=$arrays['sum']; }
			if(isset($arrays['flag']) && $arrays['flag']){ $flag=$arrays['flag']; }
			if(isset($arrays['flag_idx']) && $arrays['flag_idx']){ $flag_idx=$arrays['flag_idx']; }
			if(isset($arrays['trade_code']) && $arrays['trade_code']){ $trade_code=$arrays['trade_code']; }
				
			$insert_array = array(
				'userid' => $arrays['userid'],
				'point' => $sum.$arrays['point'],
				'content' => $arrays['content'],
				'flag' => $flag,
				'flag_idx' => $flag_idx,
				'trade_code' => $trade_code,
				'reg_date' => date('Y-m-d H:i:s')
			);
			
			$result = $this->db->insert("dh_point",$insert_array);
			return $result;
		}

}