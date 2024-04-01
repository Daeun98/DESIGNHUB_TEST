<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

	/*
	가비아 호스팅 에러시
	$url = str_replace(cdir()."/index.php","",$_SERVER['PHP_SELF']); 부분을
	$url = str_replace("/html","",$_SERVER['REDIRECT_URL']); 로 교체시 문제없음
	에러 메세지 :

	A PHP Error was encountered
	Severity: Notice
	Message: Trying to get property of non-object
	Filename: controllers/basic.php
	Line Number: 53
	A PHP Error was encountered
	Severity: Notice
	Message: Trying to get property of non-object
	Filename: controllers/basic.php
	Line Number: 61
	A PHP Error was encountered
	Severity: Notice
	Message: Trying to get property of non-object
	Filename: controllers/basic.php
	Line Number: 62

	============================================================================

	현재 사용중인 .htaccess
	RewriteEngine On
	RewriteBase /
	RewriteCond $1 !^(index\.php|images|captcha|img|css|include)
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ /html/index.php/$1 [L]

	가비아호스팅에서 사용하는 .htaccess
	RewriteEngine on

	RewriteCond %{REQUEST_URI} !^(/index\.php|/assets/|/robots\.txt|/favicon\.ico)
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php?$1 [L]

	두개는 차이가 있다. 분석은 차후에
	대충 가비아는 $_SERVER['PHP_SELF']가 index.php 까지임
	우리 호스팅은 $_SERVER['PHP_SELF']가 /m 까지
	*/
		function menu()
		{
			$table = "";

			$url = str_replace(cdir()."/index.php","",$_SERVER['PHP_SELF']);
			$url = explode("/",$url);
			$cnt = 0;
			$g_url = "";

			for($i=0;$i<count($url);$i++){
				if($url[$i]=="m"){
					$cnt=$i;
					break;
				}
				$g_url .= "/".$url[$i];
			}

			$g_url = str_replace("//","/",$g_url);

			//현재 메뉴 정보
			$m_sql = "select d.*,m.nm from dh_menu".$table." m, dh_menu_data".$table." d where m.id=d.id and d.url='$g_url' order by d.lvl desc limit 1";
			$m_query = $this->db->query($m_sql);
			$menu_row = $m_query->row();

			$menu1 = "";
			$menu2 = "";

			if(isset($menu_row->lvl) && $menu_row->lvl==1){
				$menu1 = $menu_row;
			}else{
				if(isset($menu_row->pid)){
					$m_sql = "select d.*,m.nm from dh_menu".$table." m, dh_menu_data".$table." d where m.id=d.id and d.id = '$menu_row->pid' and d.lvl=1";
					$m_query = $this->db->query($m_sql);
					$menu1 = $m_query->row();
					$menu2 = $menu_row;
				}
			}

			$sql = "select d.*,m.nm from dh_menu".$table." m, dh_menu_data".$table." d where m.id=d.id and d.lvl=1 and d.sgm!=1 and d.status=1 order by d.pos asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			$menu_data1 = "";
			$menu_data2 = "";

			foreach($result as $mn1){
				$class="";
				if(isset($menu1->id) && $menu1->id == $mn1->id){
					$class="class='on'";
				}

				$emp = explode(",",$mn1->emp);
				if(in_array($this->session->userdata('ADMIN_IDX'),$emp) || $this->session->userdata('ADMIN_LEVEL') == 1){
					$menu_data1.="<li $class><a href='".cdir().$mn1->url."/m'>$mn1->nm</a></li>";
				}
			}

			if(isset($menu1->id)){
				$sql2 = "select d.*,m.nm from dh_menu".$table." m, dh_menu_data".$table." d where m.id=d.id and d.lvl=2 and pid='$menu1->id' and d.status=1 order by d.pos asc";
				$query2 = $this->db->query($sql2);
				$result2 = $query2->result();
				foreach($result2 as $mn2){
					$class="";
					if(isset($menu2->id) && $menu2->id == $mn2->id){
						$class="class='on'";
					}

					$emp = explode(",",$mn2->emp);
					if(in_array($this->session->userdata('ADMIN_IDX'),$emp) || $this->session->userdata('ADMIN_LEVEL') == 1){
						$m_order_name = explode("/order/lists/",$mn2->url);
						$order_cnt="";
						if(count($m_order_name) > 1 && $m_order_name[1]){
							$this->load->model("order_m");
							$order = $this->order_m->orderCnt($m_order_name[1]);
							$order_cnt = $order->cnt;
							if($order_cnt>0){
								$order_cnt = " ($order_cnt)";
							}else{
								$order_cnt = "";
							}
						}
						$menu_data2.="<li $class><a href='".cdir().$mn2->url."/m'>".$mn2->nm.$order_cnt."</a></li>";
					}
				}
			}


			$menu[1] = $menu_data1; //1차 메뉴 list
			$menu[2] = $menu_data2; //2차 메뉴 list
			$menu['lv1'] = $menu1; //현재 메뉴 정보 (1차)
			$menu['lv2'] = $menu2; //현재 메뉴 정보 (2차)

			return $menu;
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


		function shop_info_update($arrays)
		{

			$this->shop_info_func('shop_name',$arrays);
			$this->shop_info_func('shop_domain',$arrays);
			$this->shop_info_func('logo_image',$arrays);
			$this->shop_info_func('logo_image_name',$arrays);
			$this->shop_info_func('og_image',$arrays);
			$this->shop_info_func('og_image_name',$arrays);
			$this->shop_info_func('skin',$arrays);
			$this->shop_info_func('shop_ceo',$arrays);
			$this->shop_info_func('shop_num',$arrays);
			$this->shop_info_func('shop_tel1',$arrays);
			$this->shop_info_func('shop_tel2',$arrays);
			$this->shop_info_func('shop_fax',$arrays);
			$this->shop_info_func('shop_email',$arrays);
			$this->shop_info_func('shop_license',$arrays);
			$this->shop_info_func('shop_address',$arrays);
			$this->shop_info_func('shop_use',$arrays);
			$this->shop_info_func('pg_company',$arrays);
			$this->shop_info_func('pg_id',$arrays);
			$this->shop_info_func('express_check',$arrays);
			$this->shop_info_func('express_money',$arrays);
			$this->shop_info_func('express_free',$arrays);
			$this->shop_info_func('express_money2',$arrays);
			$this->shop_info_func('point_register',$arrays);
			$this->shop_info_func('point',$arrays);
			$this->shop_info_func('point_use',$arrays);
			$this->shop_info_func('point_percent',$arrays);
			$this->shop_info_func('bank_cnt',$arrays);
			$this->shop_info_func('delivery_cnt',$arrays);
			$this->shop_info_func('pg_key',$arrays);
			$this->shop_info_func('pg_pw',$arrays);

			$this->shop_info_func('description',$arrays);
			$this->shop_info_func('og_description',$arrays);
			$this->shop_info_func('og_title',$arrays);
			$this->shop_info_func('search_use',$arrays);
			$this->shop_info_func('naver_tag',$arrays);
			$this->shop_info_func('naver_channel',$arrays);
			$this->shop_info_func('naver_channel_cnt',$arrays);
			$this->shop_info_func('mobile_use',$arrays);

			if($this->session->userdata('ADMIN_LEVEL')<2){
				$this->shop_info_func('shop_review',$arrays);
				$this->shop_info_func('shop_qna',$arrays);
				$this->shop_info_func('review_code',$arrays);
				$this->shop_info_func('qna_code',$arrays);
			}

			for($i=1;$i<=$arrays['bank_cnt'];$i++){
				if(isset($arrays['bank_name'.$i])){
					$this->shop_info_func('bank_name'.$i,$arrays);
					$this->shop_info_func('bank_num'.$i,$arrays);
					$this->shop_info_func('input_name'.$i,$arrays);
				}
			}

			for($i=1;$i<=$arrays['delivery_cnt'];$i++){
				if(isset($arrays['delivery_idx'.$i])){
					$this->shop_info_func('delivery_idx'.$i,$arrays);
					$this->shop_info_func('delivery_url'.$i,$arrays);
				}
			}

			if($arrays['naver_channel']=="y"){
				for($i=1;$i<=$arrays['naver_channel_cnt'];$i++){
					if(isset($arrays['naver_channel_url'.$i]) && $arrays['naver_channel_url'.$i]){
						$this->shop_info_func('naver_channel_url'.$i,$arrays);
					}
				}
			}


			return "1";
		}



		function shop_info_func($name,$arrays)
		{
			$sql = "select * from dh_shop_info where name='$name'";
			$query = $this->db->query($sql);
			$cnt = $query->num_rows();

			if($cnt > 0){

				$update_array = array(
					'val' => $this->db->escape_str($arrays[$name])
				);

				$where = array(
					'name' => $name
				);

				$result = $this->db->update($arrays['table'],$update_array,$where);

			}else{

				$insert_array = array(
					'name' => $name,
					'val' => $this->db->escape_str($arrays[$name])
				);

				$result = $this->db->insert($arrays['table'],$insert_array);

			}


			return $result;

		}



		function insert($mode,$arrays) //등록하기
		{

			if($mode == "admin_user"){ //관리자유저 등록


				$insert_array = array(
					'userid' => $arrays['userid'],
					'name' => $arrays['name'],
					'passwd' => $arrays['passwd'],
					'name' => $arrays['name'],
					'level' => $arrays['level'],
					//'admin_user' => $arrays['admin_user'],
					'reg_date' => date('Y-m-d H:i:s')
				);

			}else if($mode == "page"){ //페이지 등록

				$insert_array = array(
					'title' => $arrays['title'],
					'page_index' => $arrays['page_index'],
					'content' => $arrays['content']
				);

			}else if($mode == "popup"){  //팝업창 등록

				$insert_array = array(
					'display' => $arrays['display'],
					'tops' => $arrays['tops'],
					'lefts' => $arrays['lefts'],
					'start_day' => $arrays['start_day'],
					'end_day' => $arrays['end_day'],
					'width' => $arrays['width'],
					'height' => $arrays['height'],
					'live' => $arrays['live'],
					'title_bar' => $arrays['title_bar'],
					'link_url' => $arrays['link_url'],
					'popup_images' => $arrays['popup_images'],
					'content' => $arrays['content']
				);

			}else if($mode=="member_level"){

				$insert_array = array(
					'level' => $arrays['level'],
					'name' => $arrays['name']
				);

			}else if($mode == "bbs_admin"){ //게시판 추가

				$sql = "select count(*) as cnt from dh_bbs where code='".$this->db->escape_str($arrays['code'])."'";
				$query = $this->db->query($sql);
				$c_result = $query->row();

				if($c_result->cnt > 0){
						echo "<script>alert('이미 사용하고 있는 코드입니다.'); history.back(-1);</script>";
						exit;
				}

				$insert_array = array(
					'code' => $arrays['code'],
					'name' => $arrays['name'],
					'bbs_type' => $arrays['bbs_type'],
					'bbs_pds' => $arrays['bbs_pds'],
					'list_pds' => $arrays['list_pds'],
					'bbs_coment' => $arrays['bbs_coment'],
					'bbs_access' => $arrays['bbs_access'],
					'bbs_cate' => $arrays['bbs_cate'],
					'bbs_read' => $arrays['bbs_read'],
					'bbs_write' => $arrays['bbs_write'],
					'write_level' => $arrays['write_level'],
					'list_width' => $arrays['list_width'],
					'list_height' => $arrays['list_height'],
					'list_page' => $arrays['list_page'],
					'new_check' => $arrays['new_check'],
					'new_mark' => $arrays['new_mark'],
					'cool_check' => $arrays['cool_check'],
					'cool_mark' => $arrays['cool_mark'],
					'nospam' => $arrays['nospam'],
					'memo' => $arrays['memo'],
					'bbs_secret' => $arrays['bbs_secret'],
					'editor' => $arrays['editor'],
					'size_text1' => $arrays['size_text1'],
					'size_text2' => $arrays['size_text2'],
					'create_date' => date('Y-m-d H:i:s')
				);

			}

			$result = $this->db->insert($arrays['table'],$insert_array);

			return $result;
		}

		function menuUpdate($mode,$arrays)
		{
			if($mode == "dh_menu"){

				$update_array = array(
					'nm' => $arrays['nm']
				);

				$where = array(
					'id' => $arrays['id']
				);

				$arrays['table'] = $mode;

			}else if($mode == "dh_menu_data"){


				$emp_txt="";
				for($i=0;$i<count($arrays['emp']);$i++){
					if(isset($arrays['emp'][$i]) && $arrays['emp'][$i]){
						$emp_txt.=$arrays['emp'][$i];
						$j=$i+1;
						if($j != count($arrays['emp'])){
							$emp_txt.=",";
						}
					}
				}

				$update_array = array(
					'url' => $arrays['url'],
					'emp' => $emp_txt,
					'cls' => $arrays['cls'],
					'status' => $arrays['status']
				);

				$where = array(
					'id' => $arrays['id']
				);

				$arrays['table'] = $mode;
			}

			$result = $this->db->update($arrays['table'],$update_array,$where);


			return $result;
		}


		function update($mode,$arrays)
		{

			if($mode == "admin_user"){ //관리자 정보 수정

				$update_array = array(
					'passwd' => $arrays['passwd'],
					'name' => $arrays['name'],
					'level' => $arrays['level'],
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "page"){ //관리자 정보 수정

				$update_array = array(
					'title' => $arrays['title'],
					'content' => $arrays['content']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "popup"){

				$update_array = array(
					'display' => $arrays['display'],
					'tops' => $arrays['tops'],
					'lefts' => $arrays['lefts'],
					'start_day' => $arrays['start_day'],
					'end_day' => $arrays['end_day'],
					'width' => $arrays['width'],
					'height' => $arrays['height'],
					'live' => $arrays['live'],
					'title_bar' => $arrays['title_bar'],
					'link_url' => $arrays['link_url'],
					'popup_images' => $arrays['popup_images'],
					'content' => $arrays['content']
				);

				$where = array(
					'idx' => $arrays['idx']
				);
			}else if($mode == "dh_menu"){

				$update_array = array(
					'nm' => $arrays['nm']
				);

				$where = array(
					'id' => $arrays['id']
				);

				$arrays['table'] = $mode;

			}else if($mode == "dh_menu_data"){

				$emp = $arrays['emp'];
				$emp_txt = "";

				for($i=0;$i<count($emp);$i++){
					$emp_txt.=$emp[$i].",";
				}


				$update_array = array(
					'url' => $arrays['url'],
					'emp' => $emp_txt,
					'cls' => $arrays['cls'],
					'status' => $arrays['status']
				);

				$where = array(
					'id' => $arrays['id']
				);

				$arrays['table'] = $mode;
			}else if($mode=="member_level"){

				$update_array = array(
					'level' => $arrays['level'],
					'name' => $arrays['name']
				);

				$where = array(
					'idx' => $arrays['idx']
				);
			}else if($mode=="admin_empower"){

				$update_array = array(
					'emp' => $arrays['emp']
				);

				$where = array(
					'id' => $arrays['id']
				);
			}else if($mode == "bbs_admin"){ //게시판 수정

				$update_array = array(
					'bbs_type' => $arrays['bbs_type'],
					'name' => $arrays['name'],
					'bbs_pds' => $arrays['bbs_pds'],
					'list_pds' => $arrays['list_pds'],
					'bbs_coment' => $arrays['bbs_coment'],
					'bbs_access' => $arrays['bbs_access'],
					'bbs_cate' => $arrays['bbs_cate'],
					'bbs_read' => $arrays['bbs_read'],
					'bbs_write' => $arrays['bbs_write'],
					'write_level' => $arrays['write_level'],
					'list_width' => $arrays['list_width'],
					'list_height' => $arrays['list_height'],
					'list_page' => $arrays['list_page'],
					'new_check' => $arrays['new_check'],
					'new_mark' => $arrays['new_mark'],
					'cool_check' => $arrays['cool_check'],
					'cool_mark' => $arrays['cool_mark'],
					'nospam' => $arrays['nospam'],
					'memo' => $arrays['memo'],
					'bbs_secret' => $arrays['bbs_secret'],
					'size_text1' => $arrays['size_text1'],
					'size_text2' => $arrays['size_text2'],
					'editor' => $arrays['editor']
				);

				$where = array(
					'code' => $arrays['code']
				);
			}else if($mode == "mailform"){ //관리자 정보 수정

				$update_array = array(
					'subject' => $arrays['subject'],
					'title' => $arrays['title'],
					'content' => $arrays['content']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}

			$result = $this->db->update($arrays['table'],$update_array,$where);


			return $result;

		}


	//최고 관리자 게시판 설정 리스트
	function bbsadmin_list($type=''){
		$sql = "select * from dh_bbs order by idx asc";
		$q = $this->db->query($sql);

		$result = $q->result();

		return $result;
	}

	//최고 관리자 게시판 설정 입력
	function bbsadmin_insert($db_data){
		$result = $this->db->insert('dh_bbs',$db_data);
		return $result;
	}

	//최고 관리자 게시판 수정시
	function bbsadmin_getrow($idx){
		$sql = "select * from dh_bbs where idx = '".$idx."'";
		$q = $this->db->query($sql);
		$result = $q->row();
		return $result;
	}

	//최고 관리자 게시판 설정 수정
	function bbsadmin_update($db_data){
		$update_data = array(
			'name' => $db_data['name'],
			'bbs_type' => $db_data['bbs_type'],
			'bbs_secret' => $db_data['bbs_secret'],
			'bbs_pds' => $db_data['bbs_pds'],
			'list_pds' => $db_data['list_pds'],
			'bbs_coment' => $db_data['bbs_coment'],
			'bbs_access' => $db_data['bbs_access'],
			'bbs_read' => $db_data['bbs_read'],
			'bbs_write' => $db_data['bbs_write'],
			'list_width' => $db_data['list_width'],
			'list_height' => $db_data['list_height'],
			'list_page' => $db_data['list_page'],
			'editor' => $db_data['editor']
		);

		$where = array('idx' => $db_data['idx']);
		$result = $this->db->update('dh_bbs',$update_data,$where);
		return $result;
	}

	//최고 관리자 게시판 설정 삭제
	function bbsadmin_delete($idx){

		$delete_data = array('idx' => $idx);
		$sql = "delete from dh_bbs_data where idx = '".$idx."'";
		$q = $this->db->query($sql);
		if($q){
			$result = $this->db->delete('dh_bbs',$delete_data);
			return $result;
		}

	}


	function getMenuEmpList(){
		//$where = " and d.url not like '/dhadm/%' and d.id != '1' and status=1";
		$where = " and d.url not like '/dhadm/%' and d.id != '1' and if( d.lvl = 1,d.status=1, (select status from dh_menu_data where lvl=1 and id=d.pid)=1 and d.status=1 ) ";
		$sql = "SELECT m.id,m.nm,d.pid,d.lvl,d.emp FROM dh_menu m, dh_menu_data d where m.id=d.id $where order by d.lft";
		$query = $this->db->query($sql);
		$result = $query->result();

		return $result;
	}

	function getMenuEmpCount(){

		//$where = " and d.url not like '/dhadm/%' and d.id != '1'";
		$where = " and d.url not like '/dhadm/%' and d.id != '1' and if( d.lvl = 1,d.status=1, (select status from dh_menu_data where lvl=1 and id=d.pid)=1 and d.status=1) ";
		$sql = "SELECT count( * ) as cnt FROM dh_menu m, dh_menu_data d WHERE m.id = d.id $where";
		$query = $this->db->query($sql);
		$result = $query->row();
		$result = $result->cnt;

		return $result;

	}


		function lists($where_query='')
		{
			$dep_data = '';

			$this->db->select("m.*");
			$this->db->from("dh_menu m");
			$this->db->join('dh_menu_data d', 'm.id = d.id');
			$this->db->where("d.lvl = 1");
			$this->db->order_by('d.pos', "asc");
			$list = $this->db->get()->result();

			foreach($list as $lt){

				$p_class="";
				$li_class="";
				$ul_style="";

				//if($lt->id==1063){ $p_class="class='on'"; }
				//if($lt->id==1063){ $li_class="parent open"; $ul_style=" style='display:block;'"; }
				if($this->input->get("up_idx")){ //카테고리 등록/수정 시 해당 카테고리 on

					$up_row = $this->common_m->getRow3("dh_menu_data","where id='".$this->input->get("up_idx")."'");
					$up_prow = $this->common_m->getRow3("dh_menu_data","where id='".$up_row->pid."'");

					if($up_row->lvl==1 && $lt->id == $up_row->id){ $p_class="class='on'"; }
					if($up_row->lvl > 1 && $lt->id == $up_prow->id){ $li_class="parent open"; $ul_style=" style='display:block;'"; }

				}


				$dep_data.='<li class="ls'.$lt->id.' '.$li_class.'"><p idx="'.$lt->id.'" '.$p_class.'><em class="ic"></em>'.$lt->nm.'<input type="button" value="항목추가" onclick="addItem('.$lt->id.',2);"></p>';
				$lv2Cnt = $this->common_m->getCount("dh_menu_data","where lvl=2 and pid='".$lt->id."'");
				if($lv2Cnt > 0){
					$dep_data.='<ul class="cate-2dep ulc'.$lt->id.'" '.$ul_style.'>';

					$this->db->select("m.*");
					$this->db->from("dh_menu m");
					$this->db->join('dh_menu_data d', 'm.id = d.id');
					$this->db->where("d.lvl = 2 and pid='".$lt->id."'");
					$this->db->order_by('d.pos', "asc");
					$list2 = $this->db->get()->result();

					foreach($list2 as $lt2){

						$p_class="";
						$li_class="";
						$ul_style="";
						if(isset($up_arr[1]) && $up_row->depth==2 && $up_arr[0]."-".$up_arr[1] == $dep2->cate_no){ $p_class="class='on'"; }
						if(isset($up_arr[1]) && $up_row->depth > 2 && $up_arr[0]."-".$up_arr[1] == $dep2->cate_no){ $li_class="parent open"; $ul_style=" style='display:block;'"; }

						$dep_data.='<li class="ls'.$lt2->id.' '.$li_class.'"><p idx="'.$lt2->id.'" '.$p_class.'><em class="ic"></em>'.$lt2->nm.'</p></li>';
					}

					$dep_data.='</ul>';

				}
				$dep_data.='</li>';
			}

			return $dep_data;

		}




		function view($id)
		{
			$data='';
			$mode = $this->input->get("mode");

			$data['super_user'] = $this->common_m->getRow3("dh_admin_user","where idx=1","name")->name;
			$data['admin_user_list'] = $this->common_m->getList2("dh_admin_user","where level > 1 order by idx");


			if($mode=="write"){ //등록
				if($id){ //depth가 2일때
					$data['p_row'] = $this->common_m->getRow3("dh_menu_data","where id='".$id."'","id,(select nm from dh_menu where id=dh_menu_data.id) as nm");
				}else{

				}

			}else{ //수정

				$data['row'] = $this->common_m->getRow3("dh_menu_data","where id='".$id."'","*,(select nm from dh_menu where id=dh_menu_data.id) as nm");
				if($data['row']->pid != 1){
					$data['p_row'] = $this->common_m->getRow3("dh_menu_data","where id='".$data['row']->pid."'","id,(select nm from dh_menu where id=dh_menu_data.id) as nm");
				}
			}


			return $data;
		}


		public function menuInsert($arrays)
		{

			$emp="";
			for($i=0;$i<count($arrays['emp']);$i++){
				if(isset($arrays['emp'][$i]) && $arrays['emp'][$i]){
					$emp.=$arrays['emp'][$i];
					$j=$i+1;
					if($j != count($arrays['emp'])){
						$emp.=",";
					}
				}
			}

			if($arrays['pid']){ //2차 카테고리면

				$prow = $this->common_m->getRow2("dh_menu_data","where id='".$arrays['pid']."'");

				$maxNum = $this->common_m->getMax("dh_menu_data","rgt","where lvl=2 and pid='".$prow->id."'");

				if($maxNum!=NULL && $maxNum){
					$startNum = $maxNum+1;
					$endNum = $maxNum+2;
					$maxPos = $this->common_m->getMax("dh_menu_data","pos","where lvl=2 and pid='".$prow->id."'");
					$maxPos = $maxPos+1;
				}else{
					$startNum = $prow->rgt;
					$endNum = $startNum+1;
					$maxPos=0;
				}


				$insert_array = array(
					'lft' => $startNum,
					'rgt' => $endNum,
					'lvl' => 2,
					'pid' => $prow->id,
					'pos' => $maxPos,
					'url' => $arrays['url'],
					'status' => $arrays['status'],
					'emp' => $emp,
					'cls' => $arrays['cls'],
					'sgm' => ''
				);

				$result = $this->db->insert("dh_menu_data",$insert_array);
				$a_idx = mysql_insert_id();

				$result = $this->menuReUpload("insert", $endNum, $a_idx, $prow); // lft,rgt 값 변경


			}else{ //1차 카테고리면

				$maxNum = $this->common_m->getMax("dh_menu_data","rgt");
				$startNum = $maxNum;
				$endNum = $maxNum+1;

				$maxPos = $this->common_m->getMax("dh_menu_data","pos","where lvl=1");
				$maxPos = $maxPos+1;

				if($maxPos==NULL || !$maxPos){
					$maxPos=0;
				}


				$insert_array = array(
					'lft' => $startNum,
					'rgt' => $endNum,
					'lvl' => 1,
					'pid' => 0,
					'pos' => $maxPos,
					'url' => $arrays['url'],
					'status' => $arrays['status'],
					'emp' => $emp,
					'cls' => $arrays['cls'],
					'sgm' => ''
				);

				$result = $this->db->insert("dh_menu_data",$insert_array);
				$a_idx = mysql_insert_id();

				$result = $this->common_m->update2("dh_menu_data",array('rgt'=>$endNum+1),array('id'=>1));
			}


			$insert_array = array( //이름입력
				'id' => $a_idx,
				'nm' => $arrays['nm']
			);

			$result = $this->db->insert("dh_menu",$insert_array);


			return $a_idx;

		}


		public function menuDelete($id)
		{
			$row = $this->common_m->getRow2("dh_menu_data","where id='$id'");

			$result = $this->common_m->del("dh_menu_data","id", $id);
			$result = $this->common_m->del("dh_menu","id", $id);

			if($row->lvl==1){ // 1차카테고리 삭제

				$lft = $row->lft;
				$rgt = $row->rgt;
				$minusNum = ($rgt-$lft)+1;

				$list = $this->common_m->getList2("dh_menu_data","where lvl=2 and pid='$id'");
				foreach($list as $lt){
					$this->common_m->del("dh_menu_data","id", $lt->id);
					$this->common_m->del("dh_menu","id", $lt->id);
				}


				$this->db->where("lft > $rgt");
				$this->db->set('lft', 'lft-'.$minusNum, FALSE);
				$this->db->set('rgt', 'rgt-'.$minusNum, FALSE);
				$result = $this->db->update('dh_menu_data');


				$maxNum = $this->common_m->getMax("dh_menu_data","rgt","where lvl=1");

				$this->db->where("lvl = 0");
				$this->db->set('rgt', $maxNum+1);
				$result = $this->db->update('dh_menu_data');


			}else{

				$prow = $this->common_m->getRow2("dh_menu_data","where id='".$row->pid."'");
				$result = $this->menuReUpload("delete", $row->rgt, $row->id, $prow); // lft,rgt 값 변경
			}

			return $result;
		}



		public function menuReUpload($mode, $rgt, $a_idx, $prow)
		{
			if($mode=="insert")
			{
				$this->db->where("lft >= $rgt and id != $a_idx");
				$this->db->set('lft', 'lft+2', FALSE);
				$this->db->set('rgt', 'rgt+2', FALSE);
				$result = $this->db->update('dh_menu_data');

				//0차, 1차 카테고리 수정 + 2
				$this->db->where("id = '".$prow->id."' or id = 1");
				$this->db->set('rgt', 'rgt+2', FALSE);
				$result = $this->db->update('dh_menu_data');


			}else if($mode=="delete"){

				$this->db->where("lft > $rgt");
				$this->db->set('lft', 'lft-2', FALSE);
				$this->db->set('rgt', 'rgt-2', FALSE);
				$result = $this->db->update('dh_menu_data');

				//0차, 1차 카테고리 수정 + 2
				$this->db->where("id = '".$prow->id."' or id = 1");
				$this->db->set('rgt', 'rgt-2', FALSE);
				$result = $this->db->update('dh_menu_data');
			}

			return $result;
		}


		public function menuMove($arrays)
		{
			$moveIdx = $arrays['moveIdx'];
			$action = $arrays['action'];

			$sql = "select pos,lvl,pid,id from dh_menu_data where id='".$moveIdx."'";
			$query = $this->db->query($sql);
			$result = $query->row();


			if($result->lvl==1){ //1차카테고리 일때
				$where = " and lvl=1";
			}else{
				$where = " and lvl=2 and pid = '".$result->pid."'";
			}

			if($action=="u"){ //순서를 앞으로

				$min_sql = "select min(pos) as pos from dh_menu_data where 1 $where"; // 가장 작은 순서인 숫자를 찾기
				$min_query = $this->db->query($min_sql);
				$min_row = $min_query->row();
				$min_sort = $min_row->{'pos'};

				if($result->{'pos'} == $min_sort){ // 맨 앞에순서 일때
					$result = $action;
				}else{

					$update_sort = $result->{'pos'} - 1;

					$update_sql = "update dh_menu_data set pos=pos+1 where pos=".$update_sort." $where";
					$result = $this->db->query($update_sql);

					$update_sql2 = "update dh_menu_data set pos=pos-1 where id='".$moveIdx."'";
					$result = $this->db->query($update_sql2);

				}

			}else if($action=="d"){ //순서를 뒤로

				$max_sql = "select max(pos) as pos from dh_menu_data where 1 $where"; // 가장 큰 순서인 숫자를 찾기
				$max_query = $this->db->query($max_sql);
				$max_row = $max_query->row();
				$max_sort = $max_row->{'pos'};

				if($result->{'pos'} == $max_sort){ // 맨 뒤에순서 일때
					$result = $action;
				}else{

					$update_sort = $result->{'pos'} + 1;

					$update_sql = "update dh_menu_data set pos=pos-1 where pos=".$update_sort." $where";
					$result = $this->db->query($update_sql);

					$update_sql2 = "update dh_menu_data set pos=pos+1 where id='".$moveIdx."'";
					$result = $this->db->query($update_sql2);
				}
			}

			return $result;
		}


		public function menuReload()
		{
			$menu_list1 = $this->common_m->getList2("dh_menu_data","where lvl=1 order by pos");
			$start_lft=1;

			foreach($menu_list1 as $menu1){

				if($start_lft==1){
					$start_lft = 2;
				}else{
					$start_lft = $end_rgt+1;
				}
				$num=$start_lft;
				$menu_list2 = $this->common_m->getList2("dh_menu_data","where lvl=2 and pid='".$menu1->id."' order by pos");

				foreach($menu_list2 as $menu2){
					$num++;
					$this->db->where("id = ".$menu2->id);
					$this->db->set('lft', $num, FALSE);
					$num++;
					$this->db->set('rgt', $num, FALSE);
					$result = $this->db->update('dh_menu_data');
				}

				$end_rgt = $num+1;

				$this->db->where("id = ".$menu1->id);
				$this->db->set('lft', $start_lft, FALSE);
				$this->db->set('rgt', $end_rgt, FALSE);
				$result = $this->db->update('dh_menu_data');

			}
		}
}