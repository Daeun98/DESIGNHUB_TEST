<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function lists($where_query='')
		{
			//$sql = "SELECT idx,cate_no as p_cate_no,depth as p_depth,title,sort,display,(select count(*) from dh_category where depth > p_depth and cate_no like concat(p_cate_no,'%')) as cnt FROM dh_category $where_query ORDER BY IF( p_depth =1, cate_no, SUBSTRING_INDEX( cate_no,  '-', p_depth -1 ) ), sort";

			if($this->input->get("up_idx")){ //카테고리 등록/수정 시 해당 카테고리 on
				$up_sql = "select cate_no,depth from dh_category where idx='".$this->db->escape_str($this->input->get("up_idx"))."'";
				$up_query = $this->db->query($up_sql);
				$up_row = $up_query->row();
				$up_depth = $up_row->depth-1;
				$up_arr = explode("-",$up_row->cate_no);
			}

			$sql = "select * from dh_category where depth=1 $where_query order by sort asc";
			$query = $this->db->query($sql);
			$result1 = $query->result();

			$dep_data = '';

			foreach($result1 as $dep1){
				$cnt_row = $this->db->query("select count(*) as cnt from dh_category where depth = ".$dep1->depth."+1 and cate_no like '".$dep1->cate_no."-%'")->row();
				$cnt = $cnt_row->cnt;

				$p_class="";
				$li_class="";
				$ul_style="";
				if(isset($up_arr[0]) && $up_row->depth==1 && $up_arr[0] == $dep1->cate_no){ $p_class="class='on'"; }
				if(isset($up_arr[0]) && $up_row->depth > 1 && $up_arr[0] == $dep1->cate_no){ $li_class="parent open"; $ul_style=" style='display:block;'"; }

				$dep_data.='<li class="ls'.$dep1->idx.' '.$li_class.'"><p idx="'.$dep1->idx.'" '.$p_class.'><em class="ic"></em>'.$dep1->title.'<input type="button" value="항목추가" onclick="addItem('.$dep1->idx.',2);"></p>';
				if($cnt==0){
				$dep_data.='</li>';
				}else{
					$ul_depth = $dep1->depth + 1;
					$dep_data.='<ul class="cate-'.$ul_depth.'dep ulc'.$dep1->idx.'" '.$ul_style.'>';

						$sql2 = "select * from dh_category where depth=$ul_depth and cate_no like '".$dep1->cate_no."-%' $where_query order by sort asc";
						$query2 = $this->db->query($sql2);
						$result2 = $query2->result();

						foreach($result2 as $dep2){

							$cnt_row = $this->db->query("select count(*) as cnt from dh_category where depth = ".$dep2->depth."+1 and cate_no like '".$dep2->cate_no."-%'")->row();
							$cnt = $cnt_row->cnt;

							$p_class="";
							$li_class="";
							$ul_style="";
							if(isset($up_arr[1]) && $up_row->depth==2 && $up_arr[0]."-".$up_arr[1] == $dep2->cate_no){ $p_class="class='on'"; }
							if(isset($up_arr[1]) && $up_row->depth > 2 && $up_arr[0]."-".$up_arr[1] == $dep2->cate_no){ $li_class="parent open"; $ul_style=" style='display:block;'"; }

							$dep_data.='<li class="ls'.$dep2->idx.' '.$li_class.'"><p idx="'.$dep2->idx.'" '.$p_class.'><em class="ic"></em>'.$dep2->title.'<input type="button" value="항목추가" onclick="addItem('.$dep2->idx.',3);"></p>';

							if($cnt==0){
								$dep_data.='</li>';
							}else{

								$ul_depth = $dep2->depth + 1;
								$dep_data.='<ul class="cate-'.$ul_depth.'dep ulc'.$dep2->idx.'" '.$ul_style.'>';

									$sql3 = "select * from dh_category where depth=$ul_depth and cate_no like '".$dep2->cate_no."-%' $where_query order by sort asc";
									$query3 = $this->db->query($sql3);
									$result3 = $query3->result();

									foreach($result3 as $dep3){

										$cnt_row = $this->db->query("select count(*) as cnt from dh_category where depth = ".$dep3->depth."+1 and cate_no like '".$dep3->cate_no."-%'")->row();
										$cnt = $cnt_row->cnt;

										$p_class="";
										$li_class="";
										$ul_style="";
										if(isset($up_arr[2]) && $up_row->depth==3 && $up_arr[0]."-".$up_arr[1]."-".$up_arr[2] == $dep3->cate_no){ $p_class="class='on'"; }
										if(isset($up_arr[2]) && $up_row->depth > 3 &&  $up_arr[0]."-".$up_arr[1]."-".$up_arr[2] == $dep3->cate_no){ $li_class="parent open"; $ul_style=" style='display:block;'"; }

										$dep_data.='<li class="ls'.$dep3->idx.'" '.$li_class.'><p idx="'.$dep3->idx.'" '.$p_class.'><em class="ic"></em>'.$dep3->title.'<input type="button" value="항목추가" onclick="addItem('.$dep3->idx.',4);"></p>';

										if($cnt==0){
											$dep_data.='</li>';
										}else{

											$ul_depth = $dep3->depth + 1;
											$dep_data.='<ul class="cate-'.$ul_depth.'dep ulc'.$dep3->idx.'" '.$ul_style.'>';

												$sql4 = "select * from dh_category where depth=$ul_depth and cate_no like '".$dep3->cate_no."-%' $where_query order by sort asc";
												$query4 = $this->db->query($sql4);
												$result4 = $query4->result();

												foreach($result4 as $dep4){

													$cnt_row = $this->db->query("select count(*) as cnt from dh_category where depth = ".$dep4->depth."+1 and cate_no like '".$dep4->cate_no."-%'")->row();
													$cnt = $cnt_row->cnt;

													$p_class="";
													$li_class="";
													$ul_style="";
													if(isset($up_arr[3]) && $up_row->depth==4 && $up_arr[0]."-".$up_arr[1]."-".$up_arr[2]."-".$up_arr[3] == $dep4->cate_no){ $p_class="class='on'"; }
													if(isset($up_arr[3]) && $up_arr[0]."-".$up_arr[1]."-".$up_arr[2]."-".$up_arr[3] == $dep4->cate_no){ $li_class="parent open";}


													$dep_data.='<li class="ls'.$dep4->idx.'" '.$li_class.'><p idx="'.$dep4->idx.'" '.$p_class.'><em class="ic"></em>'.$dep4->title.'</p></li>';

												}

											$dep_data.='</ul>';

										}

									}

								$dep_data.='</ul>';

							}

						}

					$dep_data.='</ul>';
				}

			}

			return $dep_data;

		}



		function view($idx)
		{
			if($idx){

				$sql = "select * from dh_category where idx='".$this->db->escape_str($idx)."'";
				$query = $this->db->query($sql);
				$result = $query->row();

				$p_cate_no = "";
				$p_cate_no_row = explode("-",$result->cate_no);
				$depth = $result->depth-1;

				for($i=0;$i<$depth;$i++){
					$p_cate_no .= $p_cate_no_row[$i];
					if($i!=$depth-1){
						$p_cate_no .= "-";
					}
				}

				$p_sql = "select * from dh_category where cate_no = '$p_cate_no' and depth='$depth'";
				$p_query = $this->db->query($p_sql);
				$p_result = $p_query->row();

			}else{
				$result = "";
				$p_result = "";
			}

			if($this->input->get("mode")=="write"){

				$data['add_row'] = $result; //상위 카테고리 정보

			}else{

				$data['row'] = $result; //현재 카테고리 정보
				$data['p_row'] = $p_result; //상위 카테고리 정보

			}

			return $data;
		}


		function insert($arrays)
		{
			$table = "dh_".$arrays['mode'];

			if( $arrays['mode'] == "category" ){ //카테고리 등록

				$p_idx = $arrays['p_idx'];
				$no1=""; $no2=""; $no3=""; $no4="";

				if($p_idx){ //1차가 아닌 다른 카테고리면 상위카테고리를 불러옴

					$sql = "select cate_no,depth from dh_category where idx='$p_idx'";

					$query = $this->db->query($sql);
					$result = $query->row();

					$cate_no_arr = explode("-",$result->cate_no);
					$p_depth = $result->depth-1;
					$cate_no = "";

					for($i=0;$i<=$p_depth;$i++){
						$j=$i+1;
						$cate_no .= $cate_no_arr[$i]."-";
						${'no'.$j} = $cate_no_arr[$i];
					}

					$sql = "select max(substring_index(cate_no,'-',-1))+1 as mx_cate_no, max(sort)+1 as mx_sort from dh_category where cate_no like '".$cate_no."%' and depth=".$arrays['depth'];
					$query = $this->db->query($sql);
					$result2 = $query->row();

					if(!$result2->mx_cate_no){
						$result2->mx_cate_no = 1;
					}

					if(!$result2->mx_sort){
						$result2->mx_sort = 1;
					}
					//$cate_no .= $result2->mx_cate_no;
					$sort = $result2->mx_sort;


				}else{ //1차 카테고리면 cate_no max 값 불러오기
					$sql = "select max(no1)+1 as cate_no, max(sort)+1 as sort from dh_category where depth=1";
					$query = $this->db->query($sql);
					$result = $query->row();

					if(!$result->cate_no){
						$result->cate_no = 1;
					}

					if(!$result->sort){
						$result->sort = 1;
					}

					$cate_no = $result->cate_no;
					$sort = $result->sort;
					$arrays['depth'] = 1;

					$no1 = $cate_no;
				}

				$insert_array = array(
					'depth' => $arrays['depth'],
					'title' => $arrays['title'],
					'cate_no' => $cate_no,
					'sort' => $sort,
					'display' => $arrays['display'],
					'access_level' => $arrays['access_level'],
					'img1' => $arrays['img1'],
					'img2' => $arrays['img2'],
					'img_real1' => $arrays['img_real1'],
					'img_real2' => $arrays['img_real2'],
					'content' => $arrays['content'],
					'no1' => $no1,
					'no2' => $no2,
					'no3' => $no3,
					'no4' => $no4,
					'reg_date' => date('Y-m-d H:i:s')
				);

			}else if($arrays['mode'] == "goods" ){

				$sql = "SELECT min(ranking)-1 as ranking FROM dh_goods";
				$query = $this->db->query($sql);
				$min_ranking = $query->row();

				if($min_ranking->ranking < 2){

					$up_sql = "update dh_goods set ranking=ranking+1";
					$up_query = $this->db->query($up_sql);
					$ranking = 1;

				}else{
					$ranking = $min_ranking->ranking;
				}


				$insert_array = array(
					'cate_no' => $arrays['cate_no'],
					'code' => $arrays['code'],
					'display' => $arrays['display'],
					'name' => $arrays['name'],
					'detail' => $arrays['detail'],
					'list_img' => $arrays['list_img'],
					'list_img_real' => $arrays['list_img_real'],
					'mobile_img' => $arrays['mobile_img'],
					'mobile_img_real' => $arrays['mobile_img_real'],
					'content1' => $arrays['content1'],
					'display_flag' => $arrays['display_flag'],
					'icon_flag' => $arrays['icon_flag'],
					'brand_flag' => $arrays['brand_flag'],
					'shop_price' => $arrays['shop_price'],
					'old_price' => $arrays['old_price'],
					'point' => $arrays['point'],
					'unlimit' => $arrays['unlimit'],
					'number' => $arrays['number'],
					'express_no_basic' => $arrays['express_no_basic'],
					'express_check' => $arrays['express_check'],
					'express_money' => $arrays['express_money'],
					'express_free' => $arrays['express_free'],
					'option_use' => $arrays['option_use'],
					'best_prd' => $arrays['best_prd'],
					'best_prd_name' => $arrays['best_prd_name'],
					'best_prd2' => $arrays['best_prd2'],
					'best_prd_name2' => $arrays['best_prd_name2'],
					'option_check1' => $arrays['option_check1'],
					'option_check2' => $arrays['option_check2'],
					'option_check3' => $arrays['option_check3'],
					'delivery' => $arrays['delivery'],
					'return' => $arrays['return'],
					'content2' => $arrays['content2'],
					'content3' => $arrays['content3'],
					'ranking' => $ranking,
					'register' => date('Y-m-d H:i:s')
				);
			}else if($arrays['mode'] == "file" ){

				$insert_array = array(
					'flag' => $arrays['flag'],
					'flag_idx' => $arrays['flag_idx'],
					'file_name' => $arrays['file_name'],
					'real_name' => $arrays['real_name'],
					'reg_date' => date('Y-m-d H:i:s')
				);
			}else if($arrays['mode'] == "goods_option" ){

				if($arrays['level']==1){
					$insert_array = array(
						'level' => $arrays['level'],
						'goods_idx' => $arrays['goods_idx'],
						'code' => $arrays['code'],
						'title' => $arrays['title'],
						'chk_num' => $arrays['chk_num'],
						'flag' => $arrays['flag'],
						'reg_date' => date('Y-m-d H:i:s')
					);

				}else{

					$insert_array = array(
						'goods_idx' => $arrays['goods_idx'],
						'code' => $arrays['code'],
						'level' => $arrays['level'],
						'title' => $arrays['title'],
						'name' => $arrays['name'],
						'price' => $arrays['price'],
						'point' => $arrays['point'],
						'chk_num' => $arrays['chk_num'],
						'unlimit' => $arrays['unlimit'],
						'number' => $arrays['number'],
						'reg_date' => date('Y-m-d H:i:s')
					);

				}
			}

			$result = $this->db->insert($table,$insert_array);

			if($result && $arrays['mode'] == "category" && $arrays['depth'] > 1){
				$a_idx = mysql_insert_id();
				$cate_no.=$a_idx;
				$result = $this->db->update("dh_category",array('cate_no' => $cate_no, 'no'.$arrays['depth'] => $a_idx),array('idx' => $a_idx));
				$result = $a_idx;
			}

			return $result;
		}


		function update($arrays)
		{
			if($arrays['mode']=="move"){

				if($arrays['flag']=="brand"){

					$chg_idx = "";
					$chg_sort = "";
					$sel_sort = 1;
					$table = "dh_brand_cate";

					$moveIdx = $arrays['moveIdx'];
					$action = $arrays['action'];

					$sql = "select sort from $table where idx='".$moveIdx."'";
					$query = $this->db->query($sql);
					$result = $query->row();
					$sel_sort = $result->sort; // 선택된 sort

					if($action=="u"){

						if($sel_sort > 1){

							$sql = "select idx,sort from $table where sort < ".$sel_sort." order by sort desc limit 1";
							$query = $this->db->query($sql);
							$result = $query->row();
							$chg_idx = $result->idx; // 바꿀 idx
							$chg_sort = $result->sort; // 바꿀 sort
						}

					}else if($action=="d"){

						$max_sort = $this->common_m->getMax($table,"sort", "where level=1");

						if($sel_sort < $max_sort){

							$sql = "select idx,sort from $table where sort > ".$sel_sort." order by sort asc limit 1";
							$query = $this->db->query($sql);
							$result = $query->row();
							$chg_idx = $result->idx; // 바꿀 idx
							$chg_sort = $result->sort; // 바꿀 sort
						}
					}

					if($sel_sort && $chg_sort && $chg_idx){

						$result = $this->common_m->update2($table,array('sort' => $chg_sort),array('idx' => $moveIdx)); //현재값 sort 바꾸기
						$result = $this->common_m->update2($table,array('sort' => $sel_sort),array('idx' => $chg_idx)); //바꿀값 sort 바꾸기

					}


				}else{

					$moveIdx = $arrays['moveIdx'];
					$action = $arrays['action'];

					$sql = "select sort,depth,cate_no from dh_category where idx='".$moveIdx."'";
					$query = $this->db->query($sql);
					$result = $query->row();


					if($result->depth==1){ //1차카테고리 일때
						$where = " and depth=1";
					}else{
						$cate_no_arr = explode("-",$result->cate_no);
						$p_cate_no = str_replace("-".$cate_no_arr[count($cate_no_arr)-1],"",$result->cate_no);
						$where = " and depth=".$result->depth." and cate_no like '".$p_cate_no."%'";
					}

					if($action=="u"){ //순서를 앞으로

						$min_sql = "select min(sort) as sort from dh_category where 1 $where"; // 가장 작은 순서인 숫자를 찾기
						$min_query = $this->db->query($min_sql);
						$min_row = $min_query->row();
						$min_sort = $min_row->sort;

						if($result->sort == $min_sort){ // 맨 앞에순서 일때
							$result = $action;
						}else{

							$update_sort = $result->sort - 1;
							$sql = "select sort,depth,cate_no from dh_category where sort=".$update_sort." $where";

							$update_sql = "update dh_category set sort=sort+1 where sort=".$update_sort." $where";
							$result = $this->db->query($update_sql);

							$update_sql2 = "update dh_category set sort=sort-1 where idx='".$moveIdx."'";
							$result = $this->db->query($update_sql2);

						}

					}else if($action=="d"){ //순서를 뒤로

						$max_sql = "select max(sort) as sort from dh_category where 1 $where"; // 가장 큰 순서인 숫자를 찾기
						$max_query = $this->db->query($max_sql);
						$max_row = $max_query->row();
						$max_sort = $max_row->sort;

						if($result->sort == $max_sort){ // 맨 뒤에순서 일때
							$result = $action;
						}else{

							$update_sort = $result->sort + 1;
							$sql = "select sort,depth,cate_no from dh_category where sort=".$update_sort." $where";

							$update_sql = "update dh_category set sort=sort-1 where sort=".$update_sort." $where";
							$result = $this->db->query($update_sql);

							$update_sql2 = "update dh_category set sort=sort+1 where idx='".$moveIdx."'";
							$result = $this->db->query($update_sql2);
						}
					}
				}

			}else if($arrays['mode']=="category"){

				$update_array = array(
					'title' => $arrays['title'],
					'display' => $arrays['display'],
					'access_level' => $arrays['access_level'],
					'img1' => $arrays['img1'],
					'img2' => $arrays['img2'],
					'img_real1' => $arrays['img_real1'],
					'img_real2' => $arrays['img_real2'],
					'content' => $arrays['content']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

				$result = $this->db->update("dh_category",$update_array,$where);


			}else if($arrays['mode']=="goods"){

				$update_array = array(
					'display' => $arrays['display'],
					'name' => $arrays['name'],
					'detail' => $arrays['detail'],
					'list_img' => $arrays['list_img'],
					'list_img_real' => $arrays['list_img_real'],
					'mobile_img' => $arrays['mobile_img'],
					'mobile_img_real' => $arrays['mobile_img_real'],
					'content1' => $arrays['content1'],
					'display_flag' => $arrays['display_flag'],
					'icon_flag' => $arrays['icon_flag'],
					'brand_flag' => $arrays['brand_flag'],
					'shop_price' => $arrays['shop_price'],
					'old_price' => $arrays['old_price'],
					'point' => $arrays['point'],
					'unlimit' => $arrays['unlimit'],
					'number' => $arrays['number'],
					'express_no_basic' => $arrays['express_no_basic'],
					'express_check' => $arrays['express_check'],
					'express_money' => $arrays['express_money'],
					'express_free' => $arrays['express_free'],
					'option_use' => $arrays['option_use'],
					'best_prd' => $arrays['best_prd'],
					'option_check1' => $arrays['option_check1'],
					'option_check2' => $arrays['option_check2'],
					'option_check3' => $arrays['option_check3'],
					'content2' => $arrays['content2'],
					'content3' => $arrays['content3'],
					'delivery' => $arrays['delivery'],
					'best_prd' => $arrays['best_prd'],
					'best_prd_name' => $arrays['best_prd_name'],
					'best_prd2' => $arrays['best_prd2'],
					'best_prd_name2' => $arrays['best_prd_name2'],
					'return' => $arrays['return']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

				$result = $this->db->update("dh_goods",$update_array,$where);

			}else if($arrays['mode']=="goods_option"){

				$update_array = array(
					'title' => $arrays['title'],
					'flag' => $arrays['flag'],
				);


				$where = array(
					'goods_idx' => $arrays['goods_idx'],
					'code' => $arrays['code'],
					'chk_num' => $arrays['chk_num'],
					'level' => 1
				);

				$result = $this->db->update("dh_goods_option",$update_array,$where); //옵션 타이틀 업데이트

				if($result){
					$delete_array = array(
						'goods_idx'=> $arrays['goods_idx'],
						'code'=> $arrays['code'],
						'chk_num' => $arrays['chk_num'],
						'level'=> 2
					);

					$result = $this->db->delete("dh_goods_option", $delete_array); //옵션 항목 삭제
				}

			}



			return $result;

		}


		function cate_list($level,$cate_no='',$sel_no='',$d='1')
		{
			$where_query="";

			if($cate_no){
				$where_query.=" and cate_no like '".$cate_no."-%'";
			}

			$sql = "select * from dh_category where depth=$level $where_query order by sort asc";
			$query = $this->db->query($sql);
			$list = $query->result();
			$cnt = $query->num_rows();
			$next_level = $level+1;
			$data = "";

			if($cnt > 0){
				if($d==1){
					$data .= "<option value=''>".$level."차 카테고리</option>";
				}

				foreach($list as $lt)
				{
					$select = "";
					if($sel_no!="" && $sel_no == $lt->cate_no){
						if($d==1){
							$select = "selected";
						}else{
							$select = "class='on'";
						}
					}
					if($d==1){
						$data .= "<option value='".$lt->cate_no."' ".$select.">".$lt->title."</option>";
					}else{
						$depth = $level+1;
						$data .= "<li><a href=javascript:cate_chg(".$depth.",'".$lt->cate_no."'); class='".$select." cate".$lt->cate_no."' >".$lt->title."</a></li>";
					}
				}
			}

			if($level==1){
				return $list;
			}else{
				return $data;
			}
		}


		function header_cate()
		{
			$cate = $this->common_m->self_q("select * from dh_category where display = 1 order by depth asc, sort asc","result");
			$category_arr = array();
			foreach($cate as $c){
				if($c->depth == 1){
					$category_arr[$c->no1]['depth']=$c->depth;
					$category_arr[$c->no1]['cate_no']=$c->cate_no;
					$category_arr[$c->no1]['title']=$c->title;
				}

				if($c->depth==2){
					$category_arr[$c->no1]['depth2'][$c->no2]['depth']=$c->depth;
					$category_arr[$c->no1]['depth2'][$c->no2]['cate_no']=$c->cate_no;
					$category_arr[$c->no1]['depth2'][$c->no2]['title']=$c->title;
				}

				if($c->depth==3){
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['depth']=$c->depth;
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['cate_no']=$c->cate_no;
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['title']=$c->title;
				}

				if($c->depth==4){
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['depth4'][$c->no4]['depth']=$c->depth;
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['depth4'][$c->no4]['cate_no']=$c->cate_no;
					$category_arr[$c->no1]['depth2'][$c->no2]['depth3'][$c->no3]['depth4'][$c->no4]['title']=$c->title;
				}
			}

			return $category_arr;
		}


		function cate_list_user($cate_no='',$level='1',$mode='header') //사용자에서 쓰는 카테고리 리스트
		{
				$data="";

			if($mode=='header'){ //헤더에서 각 depth1에 대한 depth2의 리스트 데이타

				$sql = "select * from dh_category where display='1' and depth=2 and cate_no like '$cate_no%' order by sort";
				$query = $this->db->query($sql);
				$data = $query->result();

			}else if($mode=='left'){ //left에서 쓰는 데이터

					$cate_arr = explode("-",$cate_no);

					for($i=1;$i<=$level;$i++){
						$j=$i-1;
						${'cate_no'.$i} = $cate_arr[$j];
					}

					$sql = "select * from dh_category where display='1' and depth=2 and cate_no like '$cate_no1%' order by sort";
					$query = $this->db->query($sql);
					$cate2_list = $query->result();

					foreach($cate2_list as $lt2){ //depth1에 대한 depth2 리스트

						$class="";
						if(isset($cate_no2) && $cate_no==$lt2->cate_no){ $class="on"; }

						$data.='<li class="'.$class.'"><a href="/html/dh_product/shop_list/?cate_no='.$lt2->cate_no.'">'.$lt2->title.' <span class="ko">'.$lt2->title.'</span></a>';
						if(isset($cate_no2)){
							$cate2_cnt = $this->common_m->getCount("dh_category", "where display=1 and depth=3 and cate_no like '".$lt2->cate_no."%'");
							if($cate2_cnt){ //하위 카테고리가 존재한다면
								$data.='	<ul class="lnb_sub">';

								$sql = "select * from dh_category where display=1 and depth=3 and cate_no like '".$lt2->cate_no."%' order by sort";
								$query = $this->db->query($sql);
								$cate3_list = $query->result();

								foreach($cate3_list as $lt3){ //depth1에 대한 depth2 리스트

									$class="";
									if(isset($cate_no3) && $cate_no==$lt3->cate_no){ $class="on"; }

									$data.='<li class="'.$class.'"><a href="/html/dh_product/shop_list/?cate_no='.$lt3->cate_no.'">- '.$lt3->title.' <span class="ko">'.$lt3->title.'</span></a></li>';

								}

								$data.='	</ul>';
							}
						}
						$data.='</li>';

					}

			}

			return $data;
		}


		function data_list($flag,$idx,$mode='')
		{
			$sql = "select * from dh_data where flag='$flag' and flag_idx='".$this->db->escape_str($idx)."' order by idx";
			$query = $this->db->query($sql);
			$result = $query->result();

			if($mode=="count"){
				$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;
		}


		function file_list($flag,$idx,$mode='')
		{
			$sql = "select * from dh_file where flag='$flag' and flag_idx='".$this->db->escape_str($idx)."' order by num, idx";
			$query = $this->db->query($sql);

			if($mode=="count"){
				$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;
		}


		function file_del($idx,$mode,$num='')
		{
			if($mode=="list_img" || $mode=="mobile_img"){

				$row = $this->common_m->getRow("dh_goods", "where idx='".$this->db->escape_str($idx)."'"); // 제품 데이터 가져오기

				$update_data = array(
					$mode => '',
					$mode.'_real' => ''
				);

				$where = array('idx' => $idx);
				$result = $this->db->update('dh_goods',$update_data,$where);
				if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/goodsImages/".$row->{$mode} ); }

			}else if($mode=="brand"){

				$row = $this->common_m->getRow("dh_brand_cate", "where idx='".$this->db->escape_str($idx)."'"); // 브랜드 데이터 가져오기

				$update_data = array(
					'img'.$num => '',
					'img_real'.$num => ''
				);

				$where = array('idx' => $idx);
				$result = $this->db->update('dh_brand_cate',$update_data,$where);
				if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/brandImages/".$row->{'img'.$num} ); }

			}else if($mode=="cate"){

				$row = $this->common_m->getRow("dh_category", "where idx='".$this->db->escape_str($idx)."'"); // 브랜드 데이터 가져오기

				$update_data = array(
					'img'.$num => '',
					'img_real'.$num => ''
				);

				$where = array('idx' => $idx);
				$result = $this->db->update('dh_category',$update_data,$where);
				if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/goodsImages/".$row->{'img'.$num} ); }

			}else if($mode=="coupon_img"){

				$row = $this->common_m->getRow("dh_coupon", "where idx='".$this->db->escape_str($idx)."'"); // 브랜드 데이터 가져오기

				$update_data = array(
					'img_file' => '',
					'real_file' => ''
				);

				$where = array('idx' => $idx);
				$result = $this->db->update('dh_coupon',$update_data,$where);
				if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/goodsImages/".$row->{'img_file'} ); }
			}


			return $result;
		}


		function best_prd($prd)
		{
			$prd = explode(",",$prd);
			$best_prd_name = "";

			if(count($prd) > 0){
				for($i=0;$i<count($prd);$i++){
					if($prd[$i]){
						$best_prd_row = $this->common_m->getRow("dh_goods", "where idx='".$prd[$i]."'");
						if(isset($best_prd_row->name)){
							if($i > 0){
								$best_prd_name .= ",";
							}
							$best_prd_name .= $best_prd_row->name;

						}
					}
				}
			}

			return $best_prd_name;
		}



		function del($field, $val)
		{
			$row = $this->common_m->getRow("dh_goods", "where $field='".$this->db->escape_str($val)."'"); // 제품 데이터 가져오기

			$delete_array = array(
				$field=> $val
			);

			$result = $this->db->delete("dh_goods", $delete_array);

			if($result){

				if($row->list_img){ //제품 리스트 이미지 삭제
					@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/goodsImages/".$row->list_img );
				}

				$data_cnt = $this->common_m->getCount("dh_data", "where flag='goods' and flag_idx='$row->idx'"); // 제품 추가 데이터 지우기

				if($data_cnt > 0){
					$this->db->delete("dh_data", array('flag'=> 'goods', 'flag_idx'=>$row->idx));
				}

				$file_cnt = $this->common_m->getCount("dh_file", "where flag='goods' and flag_idx='$row->idx'"); //제품 추가 이미지 지우기


				if($file_cnt > 0){
					$file_list = $this->file_list('goods',$row->idx);
					foreach($file_list as $list){
						@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$list->file_name );
					}
					$this->db->delete("dh_file", array('flag'=> 'goods', 'flag_idx'=>$row->idx));
				}

				$result = $this->db->delete("dh_goods_option", array("goods_idx"=>$val)); // 옵션삭제

			}

			return $result;
		}


		function move($field, $val, $cate_no)
		{
			$update_array = array(
				'cate_no' => $cate_no
			);

			$where = array(
				$field => $val
			);

			$result = $this->db->update("dh_goods",$update_array,$where);

			return $result;
		}


		function goods_copy($field, $val, $cate_no, $code)
		{
			$row = $this->common_m->getRow("dh_goods", "where $field='".$this->db->escape_str($val)."'"); // 제품 데이터 가져오기
			$list_img="";
			$mobile_img="";

			if($row->list_img){
				$EXT_TMP = explode( ".", $row->list_img);
				$list_img = md5($code."list_img".time()).".".$EXT_TMP[sizeof($EXT_TMP)-1];
				@copy($_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/'.$row->list_img, $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/'.$list_img);
			}

			if($row->mobile_img){
				$EXT_TMP = explode( ".", $row->mobile_img);
				$mobile_img = md5($code."mobile_img".time()).".".$EXT_TMP[sizeof($EXT_TMP)-1];
				@copy($_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/'.$row->mobile_img, $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/'.$mobile_img);
			}

				$insert_data = array(
					'mode' => "goods",
					'cate_no' => $cate_no,
					'code' => $code,
					'display' => $row->display,
					'name' =>$row->name,
					'detail' =>$row->detail,
					'list_img' => $list_img,
					'list_img_real' => $row->list_img_real,
					'mobile_img' => $mobile_img,
					'mobile_img_real' => $row->mobile_img_real,
					'content1' =>$row->content1,
					'display_flag' => $row->display_flag,
					'icon_flag' => $row->icon_flag,
					'brand_flag' => $row->brand_flag,
					'shop_price' =>$row->shop_price,
					'old_price' =>$row->old_price,
					'point' =>$row->point,
					'unlimit' => $row->unlimit,
					'number' =>$row->number,
					'express_no_basic' =>$row->express_no_basic,
					'express_check' =>$row->express_check,
					'express_money' =>$row->express_money,
					'express_free' =>$row->express_free,
					'option_use' =>$row->option_use,
					'option_check1' => $row->option_check1,
					'option_check2' => $row->option_check2,
					'option_check3' => $row->option_check3,
					'best_prd' =>$row->best_prd,
					'best_prd2' =>$row->best_prd2,
					'best_prd_name' =>$row->best_prd_name,
					'best_prd_name2' =>$row->best_prd_name2,
					'content2' => $row->content2,
					'content3' => $row->content3,
					'delivery' =>$row->delivery,
					'return' =>$row->{'return'}
				);

			$result = $this->insert($insert_data);

			$a_idx = mysql_insert_id();

			if($result){

				$data_list = $this->common_m->getList("dh_data", "where flag='goods' and flag_idx='$row->idx'");

				foreach($data_list as $data){

					$data_name = $data->data_name;
					$data_txt = $data->data_txt;

					$add_data = array(
						'flag' => "goods",
						'flag_idx' => $a_idx,
						'data_name' => $data_name,
						'data_txt' => $data_txt
					);

					$this->common_m->insert("data",$add_data);

				}


				$file_list = $this->common_m->getList("dh_file", "where flag='goods' and flag_idx='$row->idx'");
				$file_cnt=0;
				$fname="file";

				foreach($file_list as $file){
					$file_cnt++;
					$file_name="";

						if($file->file_name){

						$EXT_TMP = explode( ".", $file->file_name);
						$file_name = md5($file->file_name.$a_idx.$file_cnt).".".$EXT_TMP[sizeof($EXT_TMP)-1];
						@copy($_SERVER['DOCUMENT_ROOT'].'/_data/file/addImages/'.$file->file_name, $_SERVER['DOCUMENT_ROOT'].'/_data/file/addImages/'.$file_name);

						}

						$insert_data = array(
							'mode' => "file",
							'flag' => "goods",
							'flag_idx' => $a_idx,
							'file_name' => $file_name,
							'real_name' => $file->real_name
						);

						$result = $this->product_m->insert($insert_data);

				}


					if($row->option_use=="1"){ //옵션등록
						$result="";

						$code_num = time();

						for($k=1;$k<=3;$k++){

							if($row->{'option_check'.$k}=="1"){

								$code = $code="option_".$code_num;
								$option_row = $this->common_m->getRow("dh_goods_option","where goods_idx='".$row->idx."' and chk_num='$k' and level=1");

								$insert_data = array(
									'mode' => "goods_option",
									'goods_idx' => $a_idx,
									'code' => $code,
									'level' => 1,
									'title' => $option_row->title,
									'flag' => $option_row->flag,
									'chk_num' => $k
								);

								$result = $this->product_m->insert($insert_data);

								if($result){

									$option_list = $this->common_m->getList2("dh_goods_option","where goods_idx='".$row->idx."' and chk_num='$k' and level=2 order by idx");

										foreach($option_list as $option){

											if($option->name){
												$insert_data = array(
													'mode' => "goods_option",
													'code' => $code,
													'goods_idx' => $a_idx,
													'level' => 2,
													'title' => $option->title,
													'name' => $option->name,
													'price' => $option->price,
													'point' => $option->point,
													'unlimit' => $option->unlimit,
													'number' => $option->number,
													'chk_num' => $k
												);

												$result = $this->product_m->insert($insert_data);
											}
										}
								}

								$code_num++;
							}
						}

					}


			}


			return $result;
		}


		function sortChange($mode, $num, $idx, $cate_no)
		{
			$row = $this->common_m->getRow("dh_goods", "where idx='".$this->db->escape_str($idx)."'"); // 제품 데이터 가져오기

			$chg_ranking = "";
			$chg_idx = "";
			$where = "";
			$query_where = " and cate_no='$cate_no'";

			if($mode == "u")
			{
				$where = "WHERE ranking < ".$row->ranking." $query_where ORDER BY ranking desc LIMIT $num";
			}
			else if($mode == "d")
			{
				$where = "WHERE ranking > ".$row->ranking." $query_where ORDER BY ranking LIMIT $num";
			}


			$sql = "select ranking,idx from dh_goods $where";
			$query = $this->db->query($sql);
			$result = $query->result();

			$totalCnt = $this->common_m->getCnt("dh_goods", $where);

			$cnt=0;
			foreach($result as $list)
			{
				$cnt++;
				if($cnt==$totalCnt){
					$chg_ranking = $list->ranking;
					$chg_idx = $list->idx;
				}
			}

			if($chg_ranking && $chg_idx){

				if($mode == "u")
				{
					$sql = "update dh_goods set ranking=ranking+1 where ranking <= ".$row->ranking." and ranking >= $chg_ranking $query_where";
				}
				else if($mode == "d")
				{
					$sql = "update dh_goods set ranking=ranking-1 where ranking >= ".$row->ranking." and ranking <= $chg_ranking $query_where";
				}
				$result = $this->db->query($sql);
				$result = $this->db->update("dh_goods",array('ranking' => $chg_ranking),array('idx' => $row->idx));

			}else{
				$result = 1;
			}


			return $mode;
		}



		function getView($idx)
		{
			$best_row="";
			$sql = "select * from dh_goods where idx='".$this->db->escape_str($idx)."'";
			$query = $this->db->query($sql);
			$row = $query->row();
			$data['row'] = $row;

			if(isset($row->idx)){

			$best_prd = explode(",",$row->best_prd);
			for($i=0;$i<count($best_prd);$i++){
				if($best_prd[$i]){
					$bRow = $this->common_m->getRow("dh_goods", "where idx='".$best_prd[$i]."'");
					if(isset($bRow->idx)){
						$best_row[$i]['idx'] = $bRow->idx;
						$best_row[$i]['cate_no'] = $bRow->cate_no;
						$best_row[$i]['list_img'] = $bRow->list_img;
						$best_row[$i]['name'] = $bRow->name;
					}
				}
			}

			$data_list = $this->common_m->getDataList('goods',$idx); //제품 연결 데이타 가져오기
			$data['data_list'] = $data_list;

			$file_list = $this->common_m->getFileList('goods',$idx); //제품 연결 데이타 가져오기
			$data['file_list'] = $file_list;

			if($row->best_prd){
				$data['best_row'] = $best_row;
			}else{
				$data['best_row'] = "";
			}

			}

			return $data;
		}



		function OptionPageList($type='',$offset='',$limit='', $where_query='')
		{
			$limit_query = '';

			if($limit != '' or $offset != ''){ $limit_query = 'limit '.$offset.', '.$limit;	}

			$sql = "select * from dh_goods_option where goods_idx < 1 $where_query group by code order by idx desc ".$limit_query;
			$query = $this->db->query($sql);

			if($type == 'count'){
				$result = $query->num_rows();
			}else{
				$result = $query->result();

				$cnt=0;
				$opNameArr="";
				foreach($result as $lt)
				{
					$cnt++;
					$sql2 = "select * from dh_goods_option where goods_idx < 1 and level=2 and code = '".$lt->code."' order by idx";
					$query2 = $this->db->query($sql2);
					$result2 = $query2->result();

					$opNameArr[$cnt] = "";

						$i=0;
						foreach($result2 as $lt2){
							$i++;
							if($i>1){
								$opNameArr[$cnt] .= " / ";
							}
								$opNameArr[$cnt] .= $lt2->name;
						}

				}

				$result['list'] = $result;
				$result['opNameArr'] = $opNameArr;

			}


			return $result;
		}


		function option_del($code)
		{
			$delete_array = array(
				'code'=> $code
			);

			$result = $this->db->delete("dh_goods_option", $delete_array); //옵션 항목 삭제
		}


		/* 브랜드 start */

		function brand_lists()
		{
			$result = $this->common_m->getList2("dh_brand_cate","where level=1 order by sort,idx");
			return $result;
		}

		function brand_view($idx='')
		{
			if($idx){
				$result['row'] = $this->common_m->getRow("dh_brand_cate", "where idx='".$this->db->escape_str($idx)."'");
			}else{
				$result['row'] = "1";
			}
			return $result;
		}




		function getbestPrd($data, $mode)
		{
			$best_row="";

			if($data && $data!=","){
				$best_prd = explode(",",$data);
				if($mode=="bbs"){

					for($i=0;$i<count($best_prd);$i++){
						if($best_prd[$i]){
							$bRow = $this->common_m->getRow("dh_bbs_data", "where idx='".$best_prd[$i]."'");
							if(isset($bRow->idx)){
								$best_row[$i]['idx'] = $bRow->idx;
								$best_row[$i]['subject'] = $bRow->subject;
								$best_row[$i]['bbs_file'] = $bRow->bbs_file;
								$best_row[$i]['dong_flag'] = $bRow->dong_flag;
								$best_row[$i]['dong_src'] = $bRow->dong_src;
							}
						}
					}

				}else{

					for($i=0;$i<count($best_prd);$i++){
						if($best_prd[$i]){
							$bRow = $this->common_m->getRow("dh_goods", "where idx='".$best_prd[$i]."'");
							if(isset($bRow->idx)){
								$best_row[$i]['idx'] = $bRow->idx;
								$best_row[$i]['cate_no'] = $bRow->cate_no;
								$best_row[$i]['list_img'] = $bRow->list_img;
								$best_row[$i]['name'] = $bRow->name;
							}
						}
					}

				}
			}

			return $best_row;
		}
}