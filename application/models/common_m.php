<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function devel_array() //개발 메소드
		{
			$array = array("lists","views","write","edit","passwd","file_down","online","mypage","leave","idcheck","login","logout","email","find_id","find_pw","main","join","join_ok","member_out","upload_receive_from_ck","change_pw","facebook_ret");

			return $array;
		}

		function adm_devel_array()
		{

			$array = array("index","logout","category","popup_images","point","excel_download");

			return $array;
		}


    function get_page($page,$mode='')
    {
			if($mode=="admin"){
				if($page=="menu"){ $page = "menu/".$this->uri->segment(3); }
				$url = '/dhadm/design/'.$page;
			}else{
				$url = '/html/'.$page;
			}


    	return $url;
    }

		function getRow($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query order by idx asc limit 1";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}

		function getRow2($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}


		function getRow3($table, $where_query='',$f='*')
		{

			$sql = "select $f from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}


		function getList($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query order by idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getList2($table, $where_query='',$f='*')
		{

			$sql = "select ".$f." from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getPageList($table, $type='',$offset='',$limit='', $where_query='', $order_query='idx desc', $field='*')
		{

			$limit_query = '';

			if($limit != '' or $offset != ''){ $limit_query = 'limit '.$offset.', '.$limit;	}

			$sql = "select $field from ".$table." $where_query order by $order_query ".$limit_query;
			$query = $this->db->query($sql);

			if($type == 'count'){

				$sql = "select count(*) as cnt from ".$table." ".$where_query;
				$query = $this->db->query($sql);
				$row = $query->row();

				if(isset($row->cnt)){
					$result = $row->cnt;
				}else{
					$result = 0;
				}

				//$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;
		}


		function getCnt($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->num_rows();

			return $result;
		}


		function getCount($table, $where_query='',$f='*')
		{

			$sql = "select count(".$f.") as cnt from ".$table." $where_query";
			$query = $this->db->query($sql);
			$row = $query->row();
			$result = $row->cnt;

			return $result;
		}



		function getSum($table,$sum, $where_query='')
		{

			$sql = "select sum(".$sum.") as sum from ".$table." $where_query";
			$query = $this->db->query($sql);
			$row = $query->row();
			$result = $row->sum;

			return $result;
		}


		function getMax($table,$max, $where_query='')
		{
			$sql = "select max(".$max.") as ".$max." from $table $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();
			$data = $result->{$max};

			return $data;
		}


		function getMin($table,$min, $where_query='')
		{
			$sql = "select min(".$min.") as ".$min." from $table $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();
			$data = $result->{$min};

			return $data;
		}


		function getGroup($table,$item,$where_query='')
		{
			$sql = "SELECT distinct($item) as item FROM $table $where_query group by $item";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function insert($mode,$arrays) //등록하기
		{
			if($mode == "bbs_cate"){ //게시판 카테고리 등록

				$insert_array = array(
					'code' => $arrays['code'],
					'name' => $arrays['name'],
					'register' => date('Y-m-d H:i:s')
				);

			}else if($mode=="data"){

				$arrays['table'] = "dh_data";

				$insert_array = array(
					'flag' => $arrays['flag'],
					'flag_idx' => $arrays['flag_idx'],
					'data_name' => $arrays['data_name'],
					'data_txt' => $arrays['data_txt'],
					'reg_date' => date('Y-m-d H:i:s')
				);
			}

			$result = $this->db->insert($arrays['table'],$insert_array);
			return $result;
		}

		function insert2($table,$insert_array) //등록하기
		{
			$result = $this->db->insert($table,$insert_array);
			return $result;
		}

		function update($mode,$arrays)
		{

			if($mode == "basic_userinfo"){ //관리자 정보 수정

				$update_array = array(
					'userid' => $arrays['userid'],
					'passwd' => $arrays['passwd'],
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "member"){ //멤버 수정

				$update_array = array(
					'passwd' => $arrays['passwd'],
					'name' => $arrays['name'],
					'birth_year' => $arrays['birth_year'],
					'birth_month' => $arrays['birth_month'],
					'birth_date' => $arrays['birth_date'],
					'birth_gubun' => $arrays['birth_gubun'],
					'email' => $arrays['email'],
					'tel1' => $arrays['tel1'],
					'tel2' => $arrays['tel2'],
					'tel3' => $arrays['tel3'],
					'phone1' => $arrays['phone1'],
					'phone2' => $arrays['phone2'],
					'phone3' => $arrays['phone3'],
					'zip1' => $arrays['zip1'],
					'zip2' => $arrays['zip2'],
					'add1' => $arrays['add1'],
					'add2' => $arrays['add2'],
					'level' => $arrays['level'],
					'mailing' => $arrays['mailing']
				);


				$where = array(
					'idx' => $arrays['idx']
				);
			}else if($mode == "bbs_cate"){

				$update_array = array(
					'name' => $arrays['name']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode=="data"){

				$arrays['table'] = "dh_data";

				$update_array = array(
					'data_name' => $arrays['data_name'],
					'data_txt' => $arrays['data_txt']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode=="file"){

				$arrays['table'] = "dh_file";

				$update_array = array(
					'file_name' => $arrays['file_name'],
					'real_name' => $arrays['real_name']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}

			$result = $this->db->update($arrays['table'],$update_array,$where);

			return $result;
		}


		function update2($table,$update_array,$where)
		{
			$result = $this->db->update($table,$update_array,$where);

			return $result;
		}



		function del($table,$field, $val)
		{
			$delete_array = array(
				$field=> $val
			);

			$result = $this->db->delete($table, $delete_array);

			return $result;
		}


		function del2($table,$where_query)
		{
			$sql = "delete from $table $where_query";
			$result = $this->db->query($sql);

			return $result;
		}


		function del3($table,$delete_array)
		{
			$result = $this->db->delete($table, $delete_array);

			return $result;
		}


		function popup_list($type='')
		{
				if($type=="where"){
					$now_time= date("Y-m-d");
					$sql = "select * from dh_popup where start_day <='$now_time' AND end_day >= '$now_time' and display=1";
				}else{
					$sql = "select * from dh_popup order by idx desc";
				}

				$query = $this->db->query($sql);

				if($type == 'count')
				{
					$result = $query->num_rows();
				}
				else
				{
					$result = $query->result();
				}

				return $result;
		}


		function file_del($mode, $idx)
		{
			$row = $this->common_m->getRow("dh_file", "where flag='$mode' and idx='".$this->db->escape_str($idx)."'"); // 파일 데이터 가져오기

			$delete_array = array(
				'idx'=> $idx
			);

			$result = $this->db->delete("dh_file", $delete_array);

			if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$row->file_name ); }

			return $result;
		}


		function getDataList($mode,$idx) //dh_data 리스트 가져오기
		{
			$sql = "select * from dh_data where flag='$mode' and flag_idx='".$this->db->escape_str($idx)."' order by idx";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getFileList($mode,$idx) //dh_data 리스트 가져오기
		{
			$sql = "select * from dh_file where flag='$mode' and flag_idx='".$this->db->escape_str($idx)."' order by idx";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function file_down_m($mode, $idx, $file_num='') //파일다운로드
		{
			switch($mode)
			{
				case "bbs" :
					$sql = "select bbs_file,real_file,bbs_file2,real_file2 from dh_bbs_data where idx='".$this->db->escape_str($idx)."'";
					//20180404 update by BurningFri
					//모바일 파일 다운로드시 경로상의 문제로 인하여 파일 다운이 되어도 정상파일이 아니라고 표기되는 문제
					//다운로드 경로를 절대값으로 변경
					//$dir = "../_data/file/bbsData/";
					$dir = $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/";

					$query = $this->db->query($sql);
					$result = $query->row();

					if($file_num == 1){
						$data['file'] = $dir.$result->bbs_file;
						$data['file2'] = urlencode($result->real_file);
					}else{
						$data['file'] = $dir.$result->bbs_file2;
						$data['file2'] = urlencode($result->real_file2);
					}

				break;
			}

			return $data;
		}

		function shop_info()
		{
			$sql = "select * from dh_shop_info order by idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			foreach($result as $row){
				$shop_row[$row->name] = $row->val;
			}

			return $shop_row;

		}

	public function mailform($item, $data='')
	{
		$shop_info = $this->shop_info();
		$mailform_stat = $this->common_m->getRow("dh_mailform", "where item=".$item); //메일폼정보

		/* 공통적용 */
		$to_content = str_replace("[shop_url]", $shop_info['shop_domain'], $mailform_stat->content);
		$to_content = str_replace("[shop_name]",$shop_info['shop_name'], $to_content);
		$to_content = str_replace("[shop_addr]",$shop_info['shop_address'], $to_content);
		$to_content = str_replace("[shop_tel]",$shop_info['shop_tel1'], $to_content);
		$to_content = str_replace("[shop_fax]",$shop_info['shop_fax'], $to_content);
		/* 공통적용 */

		if($item=="1"){ //회원가입

			$idx = $data['idx'];
			$member_stat = $this->common_m->getRow("dh_member","where idx='".$this->db->escape_str($idx)."'");

			$to_content = str_replace("[user_name]", $member_stat->name, $to_content);
			$to_content = str_replace("[userid]", $member_stat->userid, $to_content);

			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $member_stat->name;
			$email			= $member_stat->email;		//받는사람 주소

		}else if($item=="2"){ //비밀번호 찾기

			$findRow = $data['findRow'];

			$passwd = $this->common_m->get_random_string('azAZ$');

			$to_content = str_replace("[user_name]", $findRow->userid, $to_content);
			$to_content = str_replace("[password]", $passwd, $to_content);
			$to_content = str_replace("[login_url]", "html/dh_member/login", $to_content);
			$to_content = str_replace("[mypage_url]", "/html/dh_member/mypage", $to_content);

			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $findRow->name;
			$email			= $findRow->email;		//받는사람 주소


		}else if($item=="3"){ //주문시

			$trade_idx = $data['trade_idx'];
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='$trade_idx'");
			$trade_code = $trade_stat->trade_code;

			$to_content = str_replace("[user_name]", $trade_stat->name, $to_content);
			$to_content = str_replace("[trade_code]",$trade_code, $to_content);
			$to_content = str_replace("[trade_day]",$trade_stat->trade_day, $to_content);

			$goods_list = $this->common_m->getList("dh_trade_goods","where trade_code='$trade_code'");

			$trade_goods_list="";

			foreach($goods_list as $lt){

				$trade_goods_list .= '<tr>';
				$trade_goods_list .= '<td style="font-size:12px; padding:15px; border-color:#dddddd; border-width:1px; border-style:solid;">';
				$trade_goods_list .= '<p style="text-align:left; padding:0; margin:0;">';
				$trade_goods_list .= '<strong>'.$lt->goods_name.'</strong><br>';
				if($lt->option_cnt > 0){
					$option_list = $this->common_m->getList("dh_trade_goods_option","where trade_code='$trade_code' and level=2 and trade_goods_idx='".$lt->idx."'");
					foreach($option_list as $ot){

						$price = explode("-",$ot->price);
						$plus="";
						if(count($price)<2){ $plus="+"; }
						$price = $ot->price;

						$trade_goods_list .= '['.$ot->title.' : '.$ot->name;
						if($ot->flag!=1){
							if($price != 0){
								$trade_goods_list .= '('.$plus.number_format($price).')';
							}
							$trade_goods_list .= ' x '.$ot->cnt.' = '.number_format( ($lt->goods_price+$price)*$ot->cnt ).'원';
						}
						$trade_goods_list .= ']<br>';
					}
				}
				$trade_goods_list .= '</p>';
				$trade_goods_list .= '</td>';
				if($lt->goods_cnt == 0){ $lt->goods_cnt = ""; }
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$lt->goods_cnt.'</td>';
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.number_format($lt->goods_price).'원</td>';
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.number_format($lt->total_price).'원</td>';
				$trade_goods_list .= '</tr>';

			}


			$to_content = str_replace("[trade_goods_list]",$trade_goods_list, $to_content);
			$to_content = str_replace("[goods_price]",number_format($trade_stat->goods_price), $to_content);
			$to_content = str_replace("[delivery_price]",number_format($trade_stat->delivery_price), $to_content);
			if(!$trade_stat->use_point){ $trade_stat->use_point = "0"; }
			$to_content = str_replace("[use_point]",number_format($trade_stat->use_point), $to_content);
			$to_content = str_replace("[total_price]",number_format($trade_stat->total_price), $to_content);
			$to_content = str_replace("[price]",number_format($trade_stat->price), $to_content);

			$to_content = str_replace("[trade_method]",$shop_info['trade_method'.$trade_stat->trade_method], $to_content);

			if($trade_stat->trade_method==1 || $trade_stat->trade_method==3){
				$trade_method_txt = "결제상태";
				$trade_method_info = '<span style="color:#0000ff;">결제가 정상적으로 완료되었습니다.</span>';
				$trade_method_detail="";
			}else if($trade_stat->trade_method==2 || $trade_stat->trade_method==4){
				$trade_method_txt = "입금 계좌 안내";
				$trade_method_info = $trade_stat->enter_bank." : ".$trade_stat->enter_account." (예금주 : ".$trade_stat->enter_info.")";
				$trade_method_detail='<p style="font-size:12px; margin:0; padding:0; margin-top:10px; line-height:20px; color:#888888;">입금이 확인된 이후에 주문상품의 배송이 시작됩니다.<br>주문 후 7일안에 입금하지 않으면 주문 자동 취소됩니다.</p>';
			}else if($trade_stat->trade_method==5 || $trade_stat->trade_method==6){
				$trade_method_txt = "결제상태";
				$trade_method_info = '<span style="color:#0000ff;">결제가 정상적으로 완료되었습니다.</span>';
				$trade_method_detail="";
			}
			$to_content = str_replace("[trade_method_txt]",$trade_method_txt, $to_content);
			$to_content = str_replace("[trade_method_info]",$trade_method_info, $to_content);
			$to_content = str_replace("[trade_method_detail]",$trade_method_detail, $to_content);

			$to_content = str_replace("[goods_price]",number_format($trade_stat->goods_price), $to_content);

			$to_content = str_replace("[send_name]",$trade_stat->send_name, $to_content);
			$to_content = str_replace("[zip1]",$trade_stat->zip1, $to_content);
			$to_content = str_replace("[addr1]",$trade_stat->addr1, $to_content);
			$to_content = str_replace("[addr2]",$trade_stat->addr2, $to_content);
			$to_content = str_replace("[send_phone]",$trade_stat->send_phone, $to_content);
			$to_content = str_replace("[send_text]",$trade_stat->send_text, $to_content);


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $trade_stat->name;
			$email			= $trade_stat->email;		//받는사람 주소


		}else if($item=="4"){ //상품배송시 (운송장번호 등록시)

			$trade_idx = $data['trade_idx'];
			$delivery_idx = $data['delivery_idx'];
			$delivery_no = $data['delivery_no'];
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='$trade_idx'");
			$trade_code = $trade_stat->trade_code;
			$delivery_day = date("Y-m-d H:i:s");
			$delivery_name = $shop_info['delivery_idx'.$delivery_idx];

			$to_content = str_replace("[user_name]", $trade_stat->name, $to_content);
			$to_content = str_replace("[trade_code]",$trade_code, $to_content);
			$to_content = str_replace("[delivery_day]",$delivery_day, $to_content);
			$to_content = str_replace("[delivery_name]",$delivery_name, $to_content);
			$to_content = str_replace("[delivery_no]",$delivery_no, $to_content);


			$this->common_m->update2("dh_trade",array('delivery_day'=>$delivery_day),array('idx'=>$trade_idx));


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $trade_stat->name;
			$email			= $trade_stat->email;		//받는사람 주소

		}else if($item=="5"){ //온라인폼

			$data_text = '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">기업명</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['data1'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">담당자명</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['name'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">연락처</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['data2'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">이메일</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['email'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">제목</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['subject'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">내용</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.nl2br($data['content']).'</td></tr>';

			if(@$data['bbs_file']!=""){
				$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">첨부파일</th>';
				$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">관리자 사이트에서 다운 가능합니다.</td>';
			}

			$to_content = str_replace("[name]", $data['name'], $to_content);
			$to_content = str_replace("[data_text]", $data_text, $to_content);


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);


			//문의한사용자
			$from_email	=	$data['email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$data['name'];

			//관리자
			$email			= $shop_info['shop_email'];		//받는사람 주소
			$name       = $shop_info['shop_name'];

		}

		if($email){

			$result = $this->sendEmail($name,$email,$from_name,$from_email,$title,$to_content);

		}else{ $result = 1; }


		if($item=="2" && $result){

			$result = $this->common_m->update2("dh_member",array('passwd'=>md5($passwd)),array('idx'=>$findRow->idx));
		}

		return $result;
	}

	public function sendEmail($toname,$tomail,$fromname,$frommail, $subject, $message) {

		$from_name = "=?UTF-8?B?".base64_encode($fromname)."?=";
		$to_name = "=?UTF-8?B?".base64_encode($toname)."?=";
		$title = "=?UTF-8?B?".base64_encode($subject)."?=";

		$mailHeader = "Content-Type: text/html; charset=utf-8\r\n";
		$mailHeader .= "MIME-Version: 1.0\r\n";

		$mailHeader .= "Return-Path:".$frommail."\r\n";
		$mailHeader .= "from:".$from_name."<".$frommail.">\r\n";
		$mailHeader .= "Reply-To:".$frommail."\r\n";

		$flag = mail($tomail, $title, $message, $mailHeader);
		return $flag;

	}


		public function cart_init()
		{
			$CART=md5(uniqid(rand()));
			$this->session->set_userdata(array('CART'=>$CART));

			return $CART;
		}


		function get_random_string($type = '', $len = 10) {  //문자 랜덤 제조

				$lowercase = 'abcdefghijklmnopqrstuvwxyz';

				$uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

				$numeric = '0123456789';

				$special = '`~!@#$%^&*()-_=+|[{]};:,<.>/?';

				$key = '';

				$token = '';

				if ($type == '') {

						$key = $lowercase.$uppercase.$numeric;

				} else {

						if (strpos($type,'09') > -1) $key .= $numeric;

						if (strpos($type,'az') > -1) $key .= $lowercase;

						if (strpos($type,'AZ') > -1) $key .= $uppercase;

						if (strpos($type,'$') > -1) $key .= $special;

				}

				for ($i = 0; $i < $len; $i++) {

						$token .= $key[mt_rand(0, strlen($key) - 1)];

				}

				return $token;

		}

		function self_q($sql,$type){
			$q = $this->db->query($sql);
			switch($type){
				case "row": $result = $q->row(); break;
				case "result": $result = $q->result(); break;
				case "cnt": $result = $q->num_rows(); break;
				case "delete":
				case "update":
					$result = "1";
				break;
			}
			return $result;
		}


		public function getPageView($page_index)
		{
			$this->db->select("content");
			$this->db->from("dh_page");
			$this->db->where("page_index = '".$page_index."'");

			return $this->db->get()->row()->content;
		}

		public function nospam()
		{
			$data='';
			$end=99999;
			$num=rand(10000,$end);
			$dir = "/_data/image/spam/";

			$num1 = substr($num,0,1);
			$num2 = substr($num,1,1);
			$num3 = substr($num,2,1);
			$num4 = substr($num,3,1);
			$num5 = substr($num,4,1);

			$img1Name = spam_img($num1);
			$img2Name = spam_img($num2);
			$img3Name = spam_img($num3);
			$img4Name = spam_img($num4);
			$img5Name = spam_img($num5);

			$cnum = $num1.$num2.$num3.$num4.$num5;

			$imgData='';

			for($i=1;$i<=strlen($cnum);$i++){

				$imgData.='<img src="'.$dir.${'img'.$i.'Name'}.'.png" alt="">';

			}

			$this->session->unset_userdata(array('cnum' => ''));
			$this->session->set_userdata(array("cnum" => $cnum));

			$data['cnum'] = $cnum;
			$data['imgData'] = $imgData;


			return $data;

		}


		public function smsform($item, $data='')
		{
			$shop_info = $this->shop_info();
			$result = 1;

			if($shop_info['sms']==1){ //sms사용하면
				$result='';

				if($shop_info['sms'.$item]==1){

					$to_content = $shop_info['sms_text'.$item];
					$to_content = str_replace("{shop_name}", "MYEL LOVE", $to_content);

					if($item==1){//회원가입
						$mem_stat = $this->getRow("dh_member","where userid='".$data['userid']."'");
						$to_content = str_replace("{name}", $mem_stat->name, $to_content);

						$data['sendTel'] = $mem_stat->tel1.$mem_stat->tel2.$mem_stat->tel3;

					}else if($item==2){//상품주문
						$trade_stat = $this->getRow("dh_trade","where trade_code='".$data['trade_code']."'");
						$to_content = str_replace("{주문번호}", $trade_stat->trade_code, $to_content);

						$data['sendTel'] = str_replace("-","",$trade_stat->phone);
					}else if($item==3){ //1:1 글 등록시
						$to_content = str_replace("{user_name}", $data['name'], $to_content);
						$data['sendTel'] = str_replace("-","",$shop_info['shop_tel2']);
					}else if($item==4){ //주문제작
						$data['sendTel'] = str_replace("-","",$shop_info['shop_tel2']);
					}else if($item==5){ //무통장입금
						$trade_stat = $this->getRow("dh_trade","where trade_code='".$data['trade_code']."'");
						$data['sendTel'] = str_replace("-","",$trade_stat->phone);
					}

					$sendTel = $data['sendTel'];
					$retTel = "0260134111";

					if($sendTel && $retTel){


						if($shop_info['sms_company']=="pongdang"){

							 $url = "http://www.pongdang.net/client/sendsms.aspx";
							 $postData = 'returnURL=http://'.$shop_info['shop_domain'].cdir().'/dh/smslog&FaildURL=http://'.$shop_info['shop_domain'].cdir().'/dh/smslog&P_ID=myellove&P_CODE=00d27cd4680a6b2cb4a22b56f5ccbbf1&P_SENDTEL='.$sendTel.'&P_RETURNTEL='.$retTel.'&P_MSG='.$to_content.'&P_TYPE=N&P_TIME=';
							 $postData = rtrim($postData, '&');


								$ch = curl_init();

								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
								curl_setopt($ch,CURLOPT_HEADER, false);
								curl_setopt($ch, CURLOPT_POST, count($postData));
								curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

								$output=curl_exec($ch);

								curl_close($ch);

								$result = 1;
						}

					}

				}else{
					$result = 1;
				}
			}

			return $result;
		}


		function getPageList2($table, $type='',$offset='',$limit='', $where_query='', $order_query='idx desc', $field='*')
		{

			$data="";

			$limit_query = '';

			if($limit != '' or $offset != ''){ $limit_query = 'limit '.$offset.', '.$limit;	}

			$sql = "select $field from ".$table." $where_query order by $order_query ".$limit_query;
			$query = $this->db->query($sql);

			if($type == 'count'){
				$result = $query->num_rows();
			}else{
				$result['list'] = $query->result();

				$i=0;
				$goods_arr="";
				foreach($result['list'] as $lt){
					$goods_arr[$i]['cnt'] = $this->common_m->getCount("dh_trade_goods","where trade_code='".$lt->trade_code."'");
					$goods_arr[$i]['goods_name']="";
					$goods_list = $this->common_m->getList2("dh_trade_goods","where trade_code='".$lt->trade_code."' order by idx");
					$cnt=0;
					foreach($goods_list as $goods){
						$cnt++;
						if($cnt!=1){
							$goods_arr[$i]['goods_name'].="<br>";
						}
						$goods_arr[$i]['goods_name'].=$goods->goods_name;
					}
					$i++;
				}

				$result['goods_arr'] = $goods_arr;
			}

			return $result;
		}


		public function defaultChk() //pc or 모바일 체크
		{
			if ( (!!(FALSE !== strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile')) != 1) || $this->session->userdata('MCHK') == "Y") { //관리자에서 모바일 체크 or 'MCHK' 세션이 있는지 여부 조사(모바일에서 pc버전 이동)


			}else{
				$url = $_SERVER['REQUEST_URI'];
				alert('/m'.$url);
				exit;

			}

		}



		public function icode_send($trade_code) //주문시 전송이니 필요할땐 수정해야함
		{
			$shop_info = $this->shop_info();
			$result = 1;

			$trade_stat = $this->getRow("dh_trade","where trade_code='".$trade_code."'");
			$trade_stat_goods = $this->getRow("dh_trade_goods","where trade_code='".$trade_code."'");

			$to_content = "{name}님이 {goods_name}을 {trade_method}로 주문하였습니다";
			$to_content = str_replace("{name}", $trade_stat->name, $to_content);
			$to_content = str_replace("{goods_name}", $trade_stat_goods->goods_name, $to_content);
			$to_content = str_replace("{trade_method}", $shop_info['trade_method'.$trade_stat->trade_method], $to_content);


			$socket_host	= "211.172.232.124";
			$socket_port	= 9201;
			/* 토큰키는 아이코드 사이트인 'http://www.icodekorea.com/'의
			 기업고객페이지의 모듈다운로드의 '토큰키 관리' 화면에서 생성가능합니다. */
			$icode_key	= "";

			$this->load->library('sms');

			$this->sms->SMS_con($socket_host,$socket_port,$icode_key);		/* 아이코드 서버 접속 */

			/**
			 * 문자발송 Form을 사용하지 않고 자동 발송의 경우 수신번호가 1개일 경우 번호 마지막에 ";"를 붙인다
			 * ex) $strTelList = "0100000001;";
			*/
			$strTelList     = "01040215969;";		/* 수신번호 : 01000000001;0100000002; */
			$strCallBack    = "01040215969";	/* 발신번호 : 0317281281 */
			$strSubject     = "";		/* LMS제목  : LMS발송에 이용되는 제목( component.php 60라인을 참고 바랍니다. */
			$strData        = $to_content;        /* 메세지 : 발송하실 문자 메세지 */

			$chkSendFlag    = 0;	/* 예약 구분자 : 0 즉시전송, 1 예약발송 */
			$R_YEAR         = "";         /* 예약 : 년(4자리) 2016 */
			$R_MONTH        = "";        /* 예약 : 월(2자리) 01 */
			$R_DAY          = "";          /* 예약 : 일(2자리) 31 */
			$R_HOUR         = "";         /* 예약 : 시(2자리) 02 */
			$R_MIN          = "";          /* 예약 : 분(2자리) 59 */

			$strURL = "";
			$strCaller = "";

			$strDest	= explode(";",$strTelList);
			$nCount		= count($strDest)-1;		// 문자 수신번호 갯수

			// 예약설정을 합니다.
			if ($chkSendFlag) $strDate = $R_YEAR.$R_MONTH.$R_DAY.$R_HOUR.$R_MIN;
			else $strDate = "";

			// 문자 발송에 필요한 항목을 배열에 추가
			$result = $this->sms->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

			// 패킷 정의의 결과에 따라 발송여부를 결정합니다.
			if ($result) {
			//	echo "일반메시지 입력 성공<BR>";
			//	echo "<HR>";

				// 패킷이 정상적이라면 발송에 시도합니다.
				$result = $this->sms->Send();

				if ($result) {
					//echo "서버에 접속했습니다.<br>";
					$success = $fail = 0;
							$isStop = 0;
					foreach($this->sms->Result as $result) {

						list($phone,$code)=explode(":",$result);

						if (substr($code,0,5)=="Error") {
							echo $phone.' 발송에러('.substr($code,6,2).'): ';
							switch (substr($code,6,2)) {
								case '17':	 // "07: 발송대기 처리. 지연해소시 발송됨."
									//echo "일시적인 지연으로 인해 발송대기 처리되었습니다.<br>";
									break;
								case '23':	 // "23:데이터오류, 전송날짜오류, 발신번호미등록"
									//echo "데이터를 다시 확인해 주시기바랍니다.<br>";
									break;

								// 아래의 사유들은 발송진행이 중단됨.
								case '85':	 // "85:발송번호 미등록"
								//	echo "등록되지 않는 발송번호 입니다.<br>";
									break;
								case '87':	 // "87:인증실패"
									//echo "(정액제-계약확인)인증 받지 못하였습니다.<br>";
									break;
								case '88':	 // "88:연동모듈 발송불가"
									//echo "연동모듈 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;

								case '96':	 // "96:토큰 검사 실패"
									//echo "사용할 수 없는 토큰키입니다.<br>";
									break;
								case '97':	 // "97:잔여코인부족"
									//echo "잔여코인이 부족합니다.<br>";
									break;
								case '98':	 // "98:사용기간만료"
									//echo "사용기간이 만료되었습니다.<br>";
									break;
								case '99':	 // "99:인증실패"
									//echo "서비스 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;
								default:	 // "미 확인 오류"
									//echo "알 수 없는 오류로 전송이 실패하었습니다.<br>";
									break;
							}
							$fail++;
						} else {
							//echo $phone."로 전송했습니다. (msg seq : ".$code.")<br>";
							$success++;
						}
					}
					//echo '<br>'.$success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
					$this->sms->Init(); // 보관하고 있던 결과값을 지웁니다.
				}
				else{
					//echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
				}
			}



			return $result;
		}
}
