<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Board_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

		function get_list($code,$type='',$offset='',$limit='', $search_item='', $search_order='', $cate_idx='',$where_query='',$bbs='') //게시판 리스트
		{
			$result = "";
			$where = "";
			//$order_query = "sort, ref desc, re_step ASC, idx desc";
			$order_query = "reg_date desc";

			$field="*,idx as bidx,(select count(*) from dh_bbs_coment where link=bidx) as coment_cnt,(select name from dh_bbs_cate where idx=cate_idx ) as cate_name";

				if($type == "notice"){ $where.= " and notice > 0 "; }else{ $where.= " and notice = 0 "; }

				$limit_query = '';

				if($limit != '' or $offset != '')
				{
					$limit_query = 'limit '.$offset.', '.$limit;
				}

				if($search_item){
					if($search_item == "all")
					{
						$where .= " and ( subject like '%".$this->db->escape_str($search_order)."%' or content like '%".$this->db->escape_str($search_order)."%' )"; //전체검색 - 수정
					}
					else
					{
						$where .= " and ".$this->db->escape_str($search_item)." like '%".$this->db->escape_str($search_order)."%' ";
					}

				}


				if($cate_idx){
					$where .= " and cate_idx='".$this->db->escape_str($cate_idx)."' ";
				}

				if(isset($bbs->bbs_type) && $bbs->bbs_type==7){ //제품후기게시판
					$field .=",(select name from dh_goods where idx=goods_idx) as goods_name,(select list_img from dh_goods where idx=goods_idx) as goods_img ";
				}

				if(isset($bbs->bbs_coment) && $bbs->bbs_coment==1){ //코멘트 사용시
					$field .=",(select coment from dh_bbs_coment where link=dh_bbs_data.idx limit 1) as coment,(select name from dh_bbs_coment where link=dh_bbs_data.idx limit 1) as coment_name,(select reg_date from dh_bbs_coment where link=dh_bbs_data.idx limit 1) as coment_reg_date ";
				}

				if($where_query){
					$where .= $where_query;
				}

				if(isset($bbs->bbs_type) && $bbs->bbs_type==10){
					$order_query = "year, month, day, idx";
				}

				$sql = "select ".$field." from dh_bbs_data where code='".$this->db->escape_str($code)."' $where order by $order_query ".$limit_query;


				if($type == 'count')
				{
					$sql = "select count(*) as cnt from dh_bbs_data where code='".$this->db->escape_str($code)."' $where";
					$query = $this->db->query($sql);
					$row = $query->row();
					$result = $row->cnt;
				}
				else
				{
					$query = $this->db->query($sql);
					$result = $query->result();
				}

				return $result;
		}



		function get_preView($code,$idx,$cate_idx='') //이전글 보기
		{
			$mnumber = $idx - 1;
			$qry = "";
			if($cate_idx){
				$qry .= " and cate_idx='".$this->db->escape_str($cate_idx)."'";
			}
			$sql = "select idx,subject,secret,userid from dh_bbs_data where code='".$this->db->escape_str($code)."' AND re_level= 0 and idx<".$this->db->escape_str($idx)." $qry order by idx desc limit 1";
			$query = $this->db->query($sql);
			$result = $query->row();

			return $result;
		}


		function get_nextView($code,$idx,$cate_idx='') //다음글 보기
		{
			$pnumber = $idx + 1;
			$qry = "";
			if($cate_idx){
				$qry .= " and cate_idx='".$this->db->escape_str($cate_idx)."'";
			}
			$sql = "select idx,subject,secret,userid from dh_bbs_data where code='".$this->db->escape_str($code)."' AND re_level= 0 and idx>".$this->db->escape_str($idx)." $qry order by idx asc limit 1";
			$query = $this->db->query($sql);
			$result = $query->row();

			return $result;
		}

		function get_bbs_coment($idx)
		{
			$sql = "select * from dh_bbs_coment where link='".$this->db->escape_str($idx)."' order by idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}

		function insert($arrays)
		{
			if( isset($arrays['mode']) && $arrays['mode']=="file" ){

				$arrays['table'] = "dh_file";

				$insert_array = array(
					'flag' => $arrays['flag'],
					'flag_idx' => $arrays['flag_idx'],
					'file_name' => $arrays['file_name'],
					'real_name' => $arrays['real_name'],
					'reg_date' => date('Y-m-d H:i:s')
				);

			}else{

				if( $arrays['ref'] ) {
					$ref = $arrays['ref'];
					$arrays['re_step'] = $arrays['re_step']+1;
					$arrays['re_level'] = $arrays['re_level']+1;
				}else{
					$ref="";
				}
				if($this->session->userdata('ADMIN_USERID')){
					$sql = "select passwd from dh_admin_user where userid='".$this->session->userdata('ADMIN_USERID')."'";
					$query = $this->db->query($sql);
					$row = $query->row();
				}


				if($this->session->userdata('ADMIN_USERID') && $arrays['pwd'] == $row->passwd){ //관리자가 등록할 시 관리자 비번으로 저장

					$arrays['pwd'] = $row->passwd;

				}else if($this->session->userdata('USERID')){  //유저가 등록할 시 해당 멤버 비번으로 저장

					$userid = $this->session->userdata('USERID');
					$sql = "select passwd from dh_member where userid='".$this->db->escape_str($userid)."'";
					$query = $this->db->query($sql);
					$row = $query->row();

					$arrays['pwd'] = $row->passwd;

				}else{

					$arrays['pwd'] = md5($arrays['pwd']);
				}



				$insert_array = array(
					'code' => $this->db->escape_str($arrays['code']),
					'userid' => $this->db->escape_str($arrays['userid']),
					'start_date' => $this->db->escape_str($arrays['start_date']),
					'end_date' => $this->db->escape_str($arrays['end_date']),
					'name' => $this->db->escape_str($arrays['name']),
					'pwd' => $this->db->escape_str($arrays['pwd']),
					'subject' => $arrays['subject'],
					'content' => $arrays['content'],
					'ref' => $ref,
					're_step' => $this->db->escape_str($arrays['re_step']),
					're_level' => $this->db->escape_str($arrays['re_level']),
					'bbs_file' => $arrays['bbs_file'],
					'real_file' => $arrays['real_file'],
					'bbs_file2' => $arrays['bbs_file2'],
					'real_file2' => $arrays['real_file2'],
					'list_img' => $arrays['list_img'],
					'list_img_real' => $arrays['list_img_real'],
					'secret' => $this->db->escape_str($arrays['secret']),
					'cate_idx' => $this->db->escape_str($arrays['cate_idx']),
					'notice' => $this->db->escape_str($arrays['notice']),
					'dong_flag' => $this->db->escape_str($arrays['dong_flag']),
					'dong_src' => $this->db->escape_str($arrays['dong_src']),
					'dong_sorce' => $this->db->escape_str($arrays['dong_sorce']),
					'cate_no' => $this->db->escape_str($arrays['cate_no']),
					'goods_idx' => $this->db->escape_str($arrays['goods_idx']),
					'grade' => $this->db->escape_str($arrays['grade']),
					'data1' => $arrays['data1'],
					'data2' => $arrays['data2'],
					'year' => $this->db->escape_str($arrays['year']),
					'month' => $this->db->escape_str($arrays['month']),
					'day' => $this->db->escape_str($arrays['day']),
					'email' => $this->db->escape_str($arrays['email']),
					'reg_date' => $this->db->escape_str($arrays['reg_date'])
					//'reg_date' => date('Y-m-d H:i:s')
				);
			}


			$result = $this->db->insert($arrays['table'],$insert_array);

			$a_idx = mysql_insert_id();

			if($result){
				if( !$arrays['ref'] ) {
					$this->common_m->update2("dh_bbs_data",array("ref"=>$a_idx),array("idx"=>$a_idx));
				}
			}

			if(isset($arrays['review']) && $arrays['review']==1 && $this->input->get("trade_goods_idx") && $arrays['userid']){ //리뷰등록시 포인트증정 & 리뷰 등록 처리
				$a_idx = mysql_insert_id();
				$result = $this->db->update("dh_trade_goods",array("review"=>$a_idx),array("idx"=>$this->input->get("trade_goods_idx"))); //리뷰등록처리
			}

			return $result;
		}

		function update($arrays)
		{

			$sql = "select pwd from dh_bbs_data where idx='".$arrays['idx']."'";
			$query = $this->db->query($sql);
			$row = $query->row();

			if($row->pwd == $arrays['pwd']){
				$arrays['pwd'] = $row->pwd;
			}else{
				$arrays['pwd'] = md5($arrays['pwd']);
			}

			$update_array = array(
				'name' => $this->db->escape_str($arrays['name']),
				'pwd' => $this->db->escape_str($arrays['pwd']),
				'subject' => $arrays['subject'],
				'content' => $arrays['content'],
				'start_date' => $this->db->escape_str($arrays['start_date']),
				'end_date' => $this->db->escape_str($arrays['end_date']),
				'bbs_file' => $arrays['bbs_file'],
				'real_file' => $arrays['real_file'],
				'bbs_file2' => $arrays['bbs_file2'],
				'real_file2' => $arrays['real_file2'],
				'list_img' => $arrays['list_img'],
				'list_img_real' => $arrays['list_img_real'],
				'cate_idx' => $this->db->escape_str($arrays['cate_idx']),
				'notice' => $this->db->escape_str($arrays['notice']),
				'dong_flag' => $this->db->escape_str($arrays['dong_flag']),
				'dong_src' => $this->db->escape_str($arrays['dong_src']),
				'dong_sorce' => $this->db->escape_str($arrays['dong_sorce']),
				'cate_no' => $this->db->escape_str($arrays['cate_no']),
				'goods_idx' => $this->db->escape_str($arrays['goods_idx']),
				'grade' => $this->db->escape_str($arrays['grade']),
				'data1' => $arrays['data1'],
				'data2' => $arrays['data2'],
				'year' => $this->db->escape_str($arrays['year']),
				'month' => $this->db->escape_str($arrays['month']),
				'day' => $this->db->escape_str($arrays['day']),
				'email' => $this->db->escape_str($arrays['email']),
				'secret' => $this->db->escape_str($arrays['secret']),
				'reg_date' => $this->db->escape_str($arrays['reg_date'])
			);

			$where = array(
				'idx' => $arrays['idx']
			);

			$result = $this->db->update($arrays['table'],$update_array,$where);


			return $result;
		}

		function bbs_coment_insert($arrays)
		{
			if($arrays['userid'] == "admin"){ //관리자가 등록할 시 관리자 비번으로 저장

				$sql = "select passwd from dh_admin_user where userid='admin'";
				$query = $this->db->query($sql);
				$row = $query->row();

				$arrays['pwd'] = $row->passwd;

			}else if($this->session->userdata('USERID')){  //유저가 등록할 시 해당 멤버 비번으로 저장

				$userid=$this->session->userdata('USERID');
				$sql = "select passwd from dh_member where userid='".$userid."'";
				$query = $this->db->query($sql);
				$row = $query->row();

				$arrays['pwd'] = $row->passwd;


			}else{

				$arrays['pwd'] = md5($arrays['pwd']);
			}


			$insert_array = array(
				'link' => $arrays['link'],
				'coment' => $arrays['coment'],
				'userid' => $arrays['userid'],
				'name' => $arrays['name'],
				'pwd' => $arrays['pwd'],
				'ip' => $_SERVER['REMOTE_ADDR'],
				'reg_date' => date('Y-m-d H:i:s')
			);

			$result = $this->db->insert($arrays['table'],$insert_array);

			return $result;
		}

		function get_bbs($code='',$mode='',$idx='') //게시판 환경
		{
			if($code == "" && $mode == "all"){

				$sql = "select * from dh_bbs order by idx";
				$query = $this->db->query($sql);
				$result = $query->result();

			}else if($idx){

				$sql = "select * from dh_bbs where idx='".$this->db->escape_str($idx)."'";
				$query = $this->db->query($sql);
				$result = $query->row();

			}else{

				$sql = "select * from dh_bbs where code='".$this->db->escape_str($code)."'";
				$query = $this->db->query($sql);
				$result = $query->row();
			}

			return $result;
		}


		function passwd_set($table, $input_pwd, $idx, $ref="")
		{
			if($ref != ""){

				$sql = "select count(*) as cnt from ".$table." where ( idx='".$this->db->escape_str($idx)."' and pwd = '".$this->db->escape_str($input_pwd)."' ) or (ref='".$this->db->escape_str($ref)."' and pwd='".$this->db->escape_str($input_pwd)."') ";

			}else{

				$sql = "select count(*) as cnt from ".$table." where idx='".$this->db->escape_str($idx)."' and pwd = '".$this->db->escape_str($input_pwd)."'";
			}
			$query = $this->db->query($sql);
			$result = $query->row();


			return $result;
		}



		function bbs_cate_list($code,$mode='') //게시판 카테고리 리스트
		{
			if($code == "edu"){ $code = "oph"; }

			$sql = "SELECT *,idx as cidx,(select count(*) from dh_bbs_data where cate_idx=cidx) as cnt FROM dh_bbs_cate WHERE code='".$this->db->escape_str($code)."' ORDER BY idx asc";
			$query = $this->db->query($sql);

			if($mode == 'cnt'){
				$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;
		}


		function bbs_cate_name_list($code,$cate_idx,$mode='')
		{

			$sql = "select distinct(c_name) as name from dh_bbs_data where code='".$this->db->escape_str($code)."' and cate_idx='".$this->db->escape_str($cate_idx)."' and c_name!='' group by c_name order by c_name asc";
			$query = $this->db->query($sql);

			if($mode == 'cnt'){
				$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;

		}


		function get_cate_cnt()
		{
			$sql = "select cate_idx, count(*) as cnt from dh_bbs_data where cate_idx!='' group by cate_idx order by cate_idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}

		function find_id_pw($mode,$id='',$name='',$email='')
		{
			$where = "";

			if($mode=="id"){

				$where = " name = '".$this->db->escape_str($name)."' and email = '".$this->db->escape_str($email)."' and outmode=0 ";

			}else if($mode=="pw"){

				$where = " userid = '".$this->db->escape_str($id)."' and name = '".$this->db->escape_str($name)."' and email = '".$this->db->escape_str($email)."' and outmode=0 ";

			}

			$sql = "select * from dh_member where ".$where." order by idx asc limit 1";
			$query = $this->db->query($sql);
			$result = $query->row();


			return $result;
		}


		function get_view($table, $idx) //보기 -  조건 idx값
		{
			if($table == "dh_bbs_data"){
				$cntUp_sql = "update dh_bbs_data set read_cnt=read_cnt+1 where idx=".$this->db->escape_str($idx).""; //조회수 증가
				$cntUp_query = $this->db->query($cntUp_sql);
			}

			$sql = "select * from ".$table." where idx='".$this->db->escape_str($idx)."'";
			$query = $this->db->query($sql);
			$result = $query->row();

			return $result;

		}

		function file_del($num='',$idx)
		{
			$row = $this->common_m->getRow("dh_bbs_data", "where idx='".$this->db->escape_str($idx)."'"); // 제품 데이터 가져오기

			$update_data = array(
				'bbs_file'.$num => '',
				'real_file'.$num => ''
			);

			$where = array('idx' => $idx);
			$result = $this->db->update('dh_bbs_data',$update_data,$where);
			if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/bbsData/".$row->{'bbs_file'.$num} ); }

			return $result;
		}


			function file_list($flag,$idx,$mode='')
			{
				$sql = "select * from dh_file where flag='$flag' and flag_idx='$idx' order by idx";
				$query = $this->db->query($sql);

				if($mode=="count"){
					$result = $query->num_rows();
				}else{
					$result = $query->result();
				}

				return $result;
			}


		public function checkDiary($year,$month,$cate_no='')
		{
			$where_query="";

			if($cate_no){
				$where_query .= " and cate_no='$cate_no'";
			}

			for($i=1;$i<=31;$i++)
			{
				$day = $i;
				if(strlen($i)==1){
					$day = "0".$i;
				}

				$sql = "select * from dh_diary where date = '".$year."-".$month."-".$day."' $where_query group by flag order by idx";
				$query = $this->db->query($sql);

				$row[$i]['count'] = $query->num_rows();
				$row[$i] = $query->result();

				$cnt=0;
				foreach($row[$i] as $lt){
					$row[$i]['list'.$lt->idx] = $this->common_m->getList2("dh_diary","where date = '".$year."-".$month."-".$day."' $where_query and flag='".$lt->flag."' order by idx");
					$row[$i]['list'.$lt->idx.'_cnt'] = $this->common_m->getCount("dh_diary","where date = '".$year."-".$month."-".$day."' $where_query and flag='".$lt->flag."'");
					$cnt++;
				}

			}

			return $row;
		}
	}





