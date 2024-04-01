<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }



		function cart($goods_idx,$code='',$buy='',$flag='') //장바구니 입력
		{
			$data="";

			if(!$code && $flag!="wish"){ //장바구니 카트 no 생성
				$code = $this->common_m->cart_init();
			}

			$table = "dh_cart";
			$option_table = "dh_cart_option";
			$basic_query = "code='$code'";
			$basic_f = 'code';
			$basic_f2 = 'cart_idx';
			$userid = $this->session->userdata('USERID');

			if($flag=="wish"){
				$table = "dh_wishlist";
				$option_table = "dh_wishlist_option";
				$basic_query = "userid='$userid'";
				$basic_f = 'userid';
				$basic_f2 = 'wishlist_idx';
				$code = $userid;
			}

			$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$this->db->escape_str($goods_idx)."'");

			if($this->input->post("goods_cnt_chagne")==1){ //옵션 수량만 변경

				$goods_point = $goods_stat->point;
				$total_price = $this->input->post("total_price");
				$cart_idx = $this->input->post("cart_idx");
				$data['a_idx'] = $cart_idx;

				if($goods_point==0){
					$shop_info = $this->common_m->shop_info(); //shop 정보
					$goods_point = $total_price*$shop_info['point']*0.01;
				}

				$this->db->update($table,array('goods_cnt'=>$this->input->post("goods_cnt"),'total_price'=>$total_price,'goods_point'=>$goods_point),array('idx'=>$cart_idx));

			}else{


				$where_query = "";
				$cnt=0;

				if($this->input->post("option_cnt") == 0){ //옵션이 없는경우
					$cnt = $this->common_m->getCount($table,"where $basic_query and cate_no='$goods_stat->cate_no' and goods_idx='$goods_stat->idx' and goods_code = '$goods_stat->code' and option_cnt=0 and trade_ok=0");
					$getRow = $this->common_m->getRow($table,"where $basic_query and cate_no='$goods_stat->cate_no' and goods_idx='$goods_stat->idx' and goods_code = '$goods_stat->code' and option_cnt=0 and trade_ok=0");
				}

				if($cnt==0){

				$goods_point = $goods_stat->point;

				if($goods_point==0){
					$shop_info = $this->common_m->shop_info(); //shop 정보
					$goods_point = $this->input->post("total_price")*$shop_info['point']*0.01;
				}

				$option_cnt = $this->input->post("option_cnt",true);

				if($this->input->post("optionCnt") > 0){
					$option_cnt = $option_cnt+$this->input->post("optionCnt");
				}

				$insert_array[$basic_f] = $code;
				$insert_array['cate_no'] = $goods_stat->cate_no;
				$insert_array['goods_idx'] = $goods_stat->idx;
				$insert_array['goods_code'] = $goods_stat->code;
				$insert_array['goods_name'] = $goods_stat->name;
				$insert_array['goods_price'] = $goods_stat->shop_price;
				$insert_array['goods_cnt'] = $this->input->post("goods_cnt",true);
				$insert_array['goods_point'] = $goods_point;
				$insert_array['goods_real_point'] = $goods_stat->point;
				$insert_array['total_price'] = $this->input->post("total_price",true);
				$insert_array['option_cnt'] = $option_cnt;
				$insert_array['userid'] = $userid;
				$insert_array['reg_date'] = date("Y-m-d H:i:s");

				$result = $this->db->insert($table,$insert_array);
				$a_idx = mysql_insert_id();
				$data['a_idx'] = $a_idx;


					if($insert_array['option_cnt'] > 0){ //옵션이 있는경우 옵션등록 (제품옵션)
						$option_sel = $this->input->post("option_sel",true);
						$option_sel = explode("/",$option_sel);
						$option_sel_cnt = $this->input->post("option_sel_cnt",true);
						$option_sel_cnt = explode("/",$option_sel_cnt);


						if($option_sel[1]){ //제품옵션

							for($i=1;$i<count($option_sel);$i++){
								if($option_sel[$i]){
									$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$option_sel[$i]."'");

									if($i==1){

										$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");

										$insert_cart_array1 = array(
											$basic_f => $code,
											$basic_f2 => $a_idx,
											'goods_idx' => $goods_stat->idx,
											'option_idx' => $option_level1_row->idx,
											'option_code' => $option_level1_row->code,
											'level' => 1,
											'title' => $option_level1_row->title,
											'chk_num' => $option_level1_row->chk_num,
											'flag' => $option_level1_row->flag,
											'trade_day' => date('Y-m-d H:i:s')
										);
										$result = $this->db->insert($option_table,$insert_cart_array1);
									}

									$insert_cart_array2 = array(
										$basic_f => $code,
										$basic_f2 => $a_idx,
										'goods_idx' => $goods_stat->idx,
										'option_idx' => $option_row->idx,
										'option_code' => $option_row->code,
										'level' => 2,
										'title' => $option_row->title,
										'name' => $option_row->name,
										'price' => $option_row->price,
										'point' => $option_row->point,
										'cnt' => $option_sel_cnt[$i],
										'chk_num' => $option_row->chk_num,
										'flag' => $option_level1_row->flag,
										'trade_day' => date('Y-m-d H:i:s')
									);

									$result = $this->db->insert($option_table,$insert_cart_array2);

								}
							}


							if($this->input->post("optionCnt") > 0){
								for($i=1;$i<=$this->input->post("optionCnt");$i++){
									if($this->input->post("option".$i)){

										$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$this->input->post("option".$i)."'");
										$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");

											$insert_cart_array2 = array(
												$basic_f => $code,
												$basic_f2 => $a_idx,
												'goods_idx' => $goods_stat->idx,
												'option_idx' => $option_row->idx,
												'option_code' => $option_row->code,
												'level' => 2,
												'title' => $option_row->title,
												'name' => $option_row->name,
												'price' => $option_row->price,
												'point' => $option_row->point,
												'cnt' => 1,
												'chk_num' => $option_row->chk_num,
												'flag' => $option_level1_row->flag,
												'trade_day' => date('Y-m-d H:i:s')
											);

											$result = $this->db->insert($option_table,$insert_cart_array2);
									}
								}
							}

						}else if($this->input->post("optionCnt") > 0){ //가격동일옵션

							for($i=1;$i<=$this->input->post("optionCnt");$i++){
								if($this->input->post("option".$i)){
									$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$this->input->post("option".$i)."'");

									if($i==1){
										$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");

										$insert_cart_array1 = array(
											$basic_f => $code,
											$basic_f2 => $a_idx,
											'goods_idx' => $goods_stat->idx,
											'option_idx' => $option_level1_row->idx,
											'option_code' => $option_level1_row->code,
											'level' => 1,
											'title' => $option_level1_row->title,
											'chk_num' => $option_level1_row->chk_num,
											'flag' => $option_level1_row->flag,
											'trade_day' => date('Y-m-d H:i:s')
										);
										$result = $this->db->insert($option_table,$insert_cart_array1);

									}


									$insert_cart_array2 = array(
										$basic_f => $code,
										$basic_f2 => $a_idx,
										'goods_idx' => $goods_stat->idx,
										'option_idx' => $option_row->idx,
										'option_code' => $option_row->code,
										'level' => 2,
										'title' => $option_row->title,
										'name' => $option_row->name,
										'price' => $option_row->price,
										'point' => $option_row->point,
										'cnt' => 1,
										'chk_num' => $option_row->chk_num,
										'flag' => $option_level1_row->flag,
										'trade_day' => date('Y-m-d H:i:s')
									);

									$result = $this->db->insert($option_table,$insert_cart_array2);

								}
							}

						}
					}

				}else{

					$total_price = $getRow->total_price;
					$goods_cnt = $getRow->goods_cnt+$this->input->post("goods_cnt");
					$goods_price = $getRow->goods_price;


					if($buy==1){
						$goods_cnt = $this->input->post("goods_cnt");
						$total_price = $getRow->goods_price * $this->input->post("goods_cnt");
					}

					$goods_point = $goods_stat->point;

					if($goods_point==0){
						$shop_info = $this->common_m->shop_info(); //shop 정보
						$goods_point = $total_price*$shop_info['point']*0.01;
					}
					$data['a_idx'] = $getRow->idx;

					if($goods_stat->unlimit==0 && $goods_cnt > $goods_stat->number){
						$goods_cnt = $goods_stat->number;
					}
					$total_price = $goods_price*$goods_cnt;

					$this->db->update($table,array('goods_cnt'=>$goods_cnt,'total_price'=>$total_price,'goods_point'=>$goods_point,'trade_ok'=>0),array('idx'=>$getRow->idx));

				}

			}

			return $data;

		}

		public function cartMove($idx,$to,$from)
		{
			$where_query = "and idx='$idx'";
			$userid = $this->session->userdata('USERID');
			$code = $this->session->userdata('CART');

			if($to=="cart") //cart -> wish
			{
				$data = $this->getCart($code,$where_query);
				$insert_table = "wishlist";
				$basic_f = "userid";
				$basic_f2 = "wishlist_idx";
				$code = $this->session->userdata('USERID');
			}else
			{
				$data = $this->getCart('',$where_query,'wish',$userid);
				$insert_table = "cart";
				$basic_f = "code";
				$basic_f2 = "cart_idx";
				$code = $this->session->userdata('CART');
			}

			$list = $data['list'];

			foreach($list as $lt){

				if($to=="cart"){

					$cart_cnt = $this->common_m->getCount("dh_".$insert_table,"where ".$basic_f."='".$code."' and cate_no='".$lt->cate_no."' and goods_idx='".$lt->goods_idx."' and goods_price='".$lt->goods_price."' and total_price='".$lt->total_price."' and option_cnt='".$lt->option_cnt."'","idx");

				}else{

					$cart_cnt = $this->common_m->getCount("dh_".$insert_table,"where ".$basic_f."='".$code."' and cate_no='".$lt->cate_no."' and goods_idx='".$lt->goods_idx."' and goods_price='".$lt->goods_price."' and total_price='".$lt->total_price."' and option_cnt='".$lt->option_cnt."' and trade_ok=''","idx");

				}

				if($cart_cnt==0){

					if($to=="cart") //cart -> wish
					{
						$insert_array = array($basic_f=>$code,'cate_no'=>$lt->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$lt->goods_code,'goods_name'=>$lt->goods_name,'goods_price'=>$lt->goods_price,'total_price'=>$lt->total_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'cate_no'=>$lt->cate_no,'goods_real_point'=>$lt->goods_real_point,'option_cnt'=>$lt->option_cnt,'cate_no'=>$lt->cate_no,'reg_date'=>date("Y-m-d H:i:s"));
					}else{
						$insert_array = array($basic_f=>$code,'userid'=>$userid,'cate_no'=>$lt->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$lt->goods_code,'goods_name'=>$lt->goods_name,'goods_price'=>$lt->goods_price,'total_price'=>$lt->total_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'cate_no'=>$lt->cate_no,'goods_real_point'=>$lt->goods_real_point,'option_cnt'=>$lt->option_cnt,'cate_no'=>$lt->cate_no,'reg_date'=>date("Y-m-d H:i:s"));
					}

					$result = $this->db->insert("dh_".$insert_table,$insert_array);
					$a_idx = mysql_insert_id();

					${'option_arr'.$lt->idx} = $data['option_arr'.$lt->idx];

					if($lt->option_cnt > 0){

						if($to=="cart") //cart -> wish
						{
							$option_first_row = $this->common_m->getRow("dh_cart_option","where cart_idx='".$lt->idx."' and option_code='".${'option_arr'.$lt->idx}[0]['option_code']."' and level=1");
						}else{
							$option_first_row = $this->common_m->getRow("dh_wishlist_option","where userid='".$this->session->userdata('USERID')."' and option_code='".${'option_arr'.$lt->idx}[0]['option_code']."' and level=1");
						}

						$option_insert_array = array($basic_f=>$code,$basic_f2=>$a_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>$option_first_row->option_idx,'option_code'=>$option_first_row->option_code,'level'=>1,'title'=>$option_first_row->title,'name'=>$option_first_row->name,'price'=>$option_first_row->price,'point'=>$option_first_row->point,'cnt'=>$option_first_row->cnt,'chk_num'=>$option_first_row->chk_num,'flag'=>$option_first_row->flag);

						$result = $this->db->insert("dh_".$insert_table."_option",$option_insert_array);

						for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){

							$option_insert_array2 = array($basic_f=>$code,$basic_f2=>$a_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>${'option_arr'.$lt->idx}[$i]['option_idx'],'option_code'=>${'option_arr'.$lt->idx}[$i]['option_code'],'level'=>${'option_arr'.$lt->idx}[$i]['level'],'title'=>${'option_arr'.$lt->idx}[$i]['title'],'name'=>${'option_arr'.$lt->idx}[$i]['name'],'price'=>${'option_arr'.$lt->idx}[$i]['price'],'point'=>${'option_arr'.$lt->idx}[$i]['point'],'cnt'=>${'option_arr'.$lt->idx}[$i]['cnt'],'chk_num'=>${'option_arr'.$lt->idx}[$i]['chk_num'],'flag'=>${'option_arr'.$lt->idx}[$i]['flag']);

							$result = $this->db->insert("dh_".$insert_table."_option",$option_insert_array2);

						}
					}
				}else{
					$result = 1;

				}

			}


			return $result;
		}


		public function getCart($code='',$where_query='',$flagMode='',$userid='')
		{
			if(!$code && !$flagMode){ //장바구니 카트 no 생성
				$code = $this->common_m->cart_init();
			}
			$table = "dh_cart";
			$basic_f = "code";
			$basic_f2 = "cart_idx";

			if($flagMode=="wish" && $userid){
				$table = "dh_wishlist";
				$basic_f = "userid";
				$basic_f2 = "wishlist_idx";
				$code = $userid;
			}

			if($where_query){
				$where_query = str_ireplace("idx","c.idx",$where_query);
			}

			$where_query.=" and c.trade_ok != 1";


			$USERID = $this->session->userdata('USERID');

			if($USERID){
				$where_query .= " and c.userid='$USERID'";
			}else{
				$where_query .= " and c.".$basic_f."='$code'";
			}


			$sql = "select c.*,g.list_img,g.old_price,g.unlimit,g.number,g.express_check,g.express_money,g.express_free,g.express_no_basic from $table c,dh_goods g where g.idx=c.goods_idx $where_query order by c.idx desc";
			$query = $this->db->query($sql);
			$result = $query->result();


			foreach($result as $lt){
				$idx = $lt->idx;
				$sql = "select * from ".$table."_option where ".$basic_f2."='$idx' and level=2 order by idx";
				$query = $this->db->query($sql);
				$option_list = $query->result();
				${'option_arr'.$idx}="";

				if( $lt->unlimit==0 && $lt->number==0 ){
					$ret = $this->common_m->del($table,'idx', $lt->idx);
					if($ret){
						alert(cdir().'/dh_order/shop_cart','품절상품이 존재하여 해당상품은 장바구니에서 삭제됩니다.'); exit;
					}
				}

				//$getRow = $this->common_m->getRow("$table_option","where ".$basic_f."='$code' and ".$basic_f2."='$idx' and level=1");

				$cnt=0;
				foreach($option_list as $option){
					${'option_arr'.$idx}[$cnt]['idx'] = $option->idx;
					${'option_arr'.$idx}[$cnt]['option_idx'] = $option->option_idx;
					${'option_arr'.$idx}[$cnt]['option_code'] = $option->option_code;
					${'option_arr'.$idx}[$cnt]['title'] = $option->title;
					${'option_arr'.$idx}[$cnt]['name'] = $option->name;
					${'option_arr'.$idx}[$cnt]['price'] = $option->price;
					${'option_arr'.$idx}[$cnt]['cnt'] = $option->cnt;
					${'option_arr'.$idx}[$cnt]['flag'] = $option->flag;
					${'option_arr'.$idx}[$cnt]['level'] = $option->level;
					${'option_arr'.$idx}[$cnt]['point'] = $option->point;
					${'option_arr'.$idx}[$cnt]['chk_num'] = $option->chk_num;

					$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$option->option_idx."'");
					if(isset($option_row->idx) && $option_row->code == $option->option_code && $option_row->unlimit==0 && $option_row->number==0 ){
						$ret = $this->common_m->del($table."_option",'idx', $option->idx);
						if($ret){
							alert(cdir().'/dh_order/shop_cart','품절되거나 삭제된 제품옵션이 존재하여 장바구니에서 삭제됩니다.'); exit;
						}
					}

					$cnt++;
				}

				$data['option_arr'.$idx] = ${'option_arr'.$idx};
			}

			$data['list'] = $result;

			return $data;

		}


		public function trade_tmp_add($trade_code,$data='')
		{
			$tmp_cnt = $this->common_m->getCount("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
			if($tmp_cnt){ $this->common_m->del("dh_trade_tmp","trade_code", $trade_code); }

			$trade_method = $this->input->post("trade_method",true);
			$trade_day = date("Y-m-d H:i:s");
			$userid = $this->input->post("userid",true);
			$name = $this->input->post("name",true);
			$phone = $this->input->post("phone1",true)."-".$this->input->post("phone2",true)."-".$this->input->post("phone3",true);
			$email = "";
			if($this->input->post("email1",true) && $this->input->post("email2",true)){
				$email = $this->input->post("email1",true)."@".$this->input->post("email2",true);
			}
			$send_name = $this->input->post("send_name",true);
			$send_phone = $this->input->post("send_phone1",true)."-".$this->input->post("send_phone2",true)."-".$this->input->post("send_phone3",true);
			$send_tel = $this->input->post("send_tel1",true)."-".$this->input->post("send_tel2",true)."-".$this->input->post("send_tel3",true);
			$send_text = $this->input->post("send_text",true);
			$zip1 = $this->input->post("zip1",true);
			$addr1 = $this->input->post("addr1",true);
			$addr2 = $this->input->post("addr2",true);
			$save_point = $this->input->post("save_point",true);
			$use_point = $this->input->post("point",true);
			$use_coupon = $this->input->post("use_coupon",true);
			$coupon_idx = $this->input->post("coupon_idx",true);
			$total_price = $this->input->post("total_price",true);
			$price = $this->input->post("price",true);
			$goods_price = $this->input->post("goods_price",true);
			$delivery_price = $this->input->post("delivery_price",true);
			$enter_name = $this->input->post("enter_name",true);
			$enter_bank = $this->input->post("enter_bank",true);
			$enter_account = $this->input->post("enter_account",true);
			$enter_info = $this->input->post("enter_info",true);
			$mobile = $this->input->post("mobile",true);
			$local_far = $this->input->post("local_far",true);
			$point_pay = $this->input->post("point_pay",true);
			$cash_receipt="";
			$cash_number="";

			if($point_pay==1){
				if($use_point){
					$trade_method=5;
				}else if($use_coupon){
					$trade_method=6;
				}
			}

			if($trade_method==2){ //현금영수증을 발급받아야 할때
				$cash_receipt = $this->input->post("cash_receipt".$trade_method, true); //현금영수증 종류
				if($cash_receipt > 0){
					$cash_number = $this->input->post("cash_number".$trade_method, true); //현금영수증 등록 번호
				}
			}
			$a_idx=$this->uri->segment(3,'');


			$txt = "trade_stat=1@@trade_method=".$trade_method."@@trade_day=".$trade_day."@@userid=".$userid."@@name=".$name."@@phone=".$phone."@@email=".$email."@@send_name=".$send_name."@@send_phone=".$send_phone;
			$txt .= "@@send_tel=".$send_tel."@@zip1=".$zip1."@@addr1=".$addr1."@@addr2=".$addr2."@@send_text=".$send_text."@@save_point=".$save_point."@@use_point=".$use_point."@@use_coupon=".$use_coupon."@@coupon_idx=".$coupon_idx;
			$txt .= "@@total_price=".$total_price."@@mobile=".$mobile."@@price=".$price."@@enter_name=".$enter_name."@@enter_bank=".$enter_bank."@@enter_account=".$enter_account."@@enter_info=".$enter_info."@@point_pay=".$point_pay;
			$txt .= "@@cash_receipt=".$cash_receipt."@@cash_number=".$cash_number."@@delivery_price=".$delivery_price."@@local_far=".$local_far."@@cate_idx=".$a_idx."@@cart_cnt=".$data['totalCnt']."@@goods_price=".$goods_price;
			$trade_data = encode($txt);

			$result = $this->db->insert("dh_trade_tmp",array("trade_code"=>$trade_code,"data"=>$trade_data,"trade_day"=>date("Y-m-d H:i:s")));

			if($data['totalCnt'] > 0){
				foreach($data['cart_list'] as $lt){
					$result = $this->common_m->update2("dh_cart",array("trade_code"=>$trade_code,"trade_day"=>date("Y-m-d H:i:s")),array("idx"=>$lt->idx));
				}
			}

			//$trade_data = decode($trade_data);

			if($result && ( $trade_method==2 || $trade_method==5 || $trade_method==6) ){ //무통장입금 or 포인트결제 or 쿠폰결제 일경우
				script_exe('parent.form_submit();');
			}

			return $result;
		}


		public function trade($trade_code,$data='',$tmpOk='',$change_trade_code='')
		{
			$tmp_cnt = $this->common_m->getCount("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
			$data['shop_info'] = $this->common_m->shop_info();
			$result="";
			$trade_stat = 1;

			if($tmp_cnt){
				$tmpRow = $this->common_m->getRow2("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."' order by idx limit 1");
				$trade_data = decode($tmpRow->data);

				$trade_day_ok="";

				if($trade_data['trade_method']!=2 && $trade_data['trade_method']!=5 && $trade_data['trade_method']!=6 && $tmpOk!=1){  //무통장입금
					$data['trade_data'] = $trade_data;
					$this->{$data['shop_info']['pg_company']}($data); //관리자에서 선택한 결제모듈로 연동

					if($trade_data['trade_method']==1 || $trade_data['trade_method']==3){
						$trade_stat = 2;
						$trade_day_ok = date("Y-m-d H:i:s");
					}
				}


				//trade 등록 start

					$tno = $this->input->post("tno");
					$cash_yn = $this->input->post("cash_yn");

					if($tno && $trade_data['trade_method'] > 2  && $tmpOk!=1){
						if($cash_yn=="Y"){
							$cash_tr_code = $this->input->post("cash_tr_code"); //소득공제용 : 0, 지출증빙용 : 1
							$trade_data['cash_receipt'] = $cash_tr_code+1;
							$trade_data['cash_number'] = $this->input->post("cash_id_info");
						}else if($cash_yn=="N"){
							$trade_data['cash_receipt'] = 0;
						}
						$bank_name = $this->input->post("bank_name");
						$bankname = $this->input->post("bankname");

						if($bank_name){ //계좌이체
							$trade_data['enter_bank'] = $bank_name;
						}
						if($bankname){ //가상계좌
							$trade_data['enter_bank'] = $bankname;
							$trade_data['enter_account'] = $this->input->post("account");
							$trade_data['enter_info'] = $this->input->post("depositor");
						}

						if($data['shop_info']['pg_company']=="inicis"){
							if($trade_data['trade_method']==3){ //계좌이체
								$trade_data['enter_bank'] = inicis_bank_array($this->input->post("ACCT_BankCode"));
							}
							if($trade_data['trade_method']==4){ //가상계좌
								$trade_data['enter_bank'] = inicis_bank_array($this->input->post("VACT_BankCode"));
								$trade_data['enter_account'] = $this->input->post("VACT_Num");
								$trade_data['enter_info'] = $this->input->post("VACT_Name");
							}
						}
					}

					if($tmpOk==1 && $change_trade_code){
						$basic_trade_code = $trade_code;
						$trade_code = $change_trade_code;
					}

					if($tmpOk==1){
						$trade_stat=1;
					}

					if($trade_data['trade_method']==5 || $trade_data['trade_method']==6){
						$trade_stat=2;
					}


					$insert_array = array('trade_code'=>$trade_code,'trade_stat'=>$trade_stat ,'trade_method'=>$trade_data['trade_method'],'trade_day'=>date("Y-m-d H:i:s"),'trade_day_ok'=>$trade_day_ok,'userid'=>$trade_data['userid'],'name'=>$trade_data['name'],'phone'=>$trade_data['phone'],'email'=>$trade_data['email'],'send_name'=>$trade_data['send_name'],'send_phone'=>$trade_data['send_phone'],'send_tel'=>$trade_data['send_tel'],'zip1'=>$trade_data['zip1'],'addr1'=>$trade_data['addr1'],'addr2'=>$trade_data['addr2'],'send_text'=>$trade_data['send_text'],'save_point'=>$trade_data['save_point'],'use_point'=>$trade_data['use_point'],'coupon_idx'=>$trade_data['coupon_idx'],'use_coupon'=>$trade_data['use_coupon'],'total_price'=>$trade_data['total_price'],'mobile'=>$trade_data['mobile'],'price'=>$trade_data['price'],'enter_name'=>$trade_data['enter_name'],'enter_bank'=>$trade_data['enter_bank'],'enter_account'=>$trade_data['enter_account'],'enter_info'=>$trade_data['enter_info'],'cash_receipt'=>$trade_data['cash_receipt'],'cash_number'=>$trade_data['cash_number'],'goods_price'=>$trade_data['goods_price'],'delivery_price'=>$trade_data['delivery_price'],'local_far'=>$trade_data['local_far'],'tno'=>$tno,'cash_authno'=>$this->input->post("cash_authno"),'point_pay'=>$trade_data['point_pay'] );

					$result = $this->common_m->insert2("dh_trade",$insert_array);
					$trade_idx = mysql_insert_id();

					if($result){ //제품 데이타 넣기
						foreach($data['cart_list'] as $lt){

						$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$lt->goods_idx."'");

						$insert_array = array('trade_code'=>$trade_code,'cate_no'=>$lt->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$lt->goods_code,'goods_name'=>$lt->goods_name,'total_price'=>$lt->total_price,'goods_price'=>$lt->goods_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'option_cnt'=>$lt->option_cnt,'trade_day'=>date("Y-m-d H:i:s"));
						$goods_result = $this->common_m->insert2("dh_trade_goods",$insert_array);
						$trade_goods_idx = mysql_insert_id();

							if($goods_result){

							if($lt->option_cnt > 0){

								$option_level1_row = $this->common_m->getRow2("dh_cart_option","where code='".$lt->code."' and cart_idx='".$lt->idx."' and option_code='".$data['option_arr'.$lt->idx][0]['option_code']."' and level=1 ");
								$insert_array_option1 = array('trade_code'=>$trade_code,'trade_goods_idx'=>$trade_goods_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>$option_level1_row->option_idx,'option_code'=>$option_level1_row->option_code,'level'=>1,'title'=>$option_level1_row->title,'name'=>$option_level1_row->name,'price'=>$option_level1_row->price,'point'=>$option_level1_row->point,'cnt'=>$option_level1_row->cnt,'chk_num'=>$option_level1_row->chk_num,'flag'=>$option_level1_row->flag,'trade_day'=>date("Y-m-d H:i:s"));
								$result = $this->common_m->insert2("dh_trade_goods_option",$insert_array_option1); //레벨1옵션 등록

								for($i=0;$i<count($data['option_arr'.$lt->idx]);$i++){

									$option_stat = $this->common_m->getRow("dh_goods_option","where idx='".$data['option_arr'.$lt->idx][$i]['option_idx']."'");

									$insert_array_option2 = array('trade_code'=>$trade_code,'trade_goods_idx'=>$trade_goods_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>$data['option_arr'.$lt->idx][$i]['option_idx'],'option_code'=>$data['option_arr'.$lt->idx][$i]['option_code'],'level'=>2,'title'=>$data['option_arr'.$lt->idx][$i]['title'],'name'=>$data['option_arr'.$lt->idx][$i]['name'],'price'=>$data['option_arr'.$lt->idx][$i]['price'],'point'=>$data['option_arr'.$lt->idx][$i]['point'],'cnt'=>$data['option_arr'.$lt->idx][$i]['cnt'],'chk_num'=>$data['option_arr'.$lt->idx][$i]['chk_num'],'flag'=>$data['option_arr'.$lt->idx][$i]['flag'],'trade_day'=>date("Y-m-d H:i:s"));
									$result = $this->common_m->insert2("dh_trade_goods_option",$insert_array_option2); //레벨2옵션 등록

									//옵션 수량 변경
									$unlimit = $option_stat->unlimit;
									$number = $option_stat->number;

									if($unlimit!=1 && $number > 0){
										$number = $number - $data['option_arr'.$lt->idx][$i]['cnt'];
										$result = $this->common_m->update2("dh_goods_option",array("number"=>$number),array("idx"=>$data['option_arr'.$lt->idx][$i]['option_idx']));
									}
								}
							}

								if($tmpOk==1 && $change_trade_code){
									$trade_code = $basic_trade_code;
								}

								//결제가 완료되면 장바구니 지우기
								$result = $this->common_m->update2("dh_cart",array("trade_code"=>$trade_code,"trade_ok"=>1,"trade_day"=>date("Y-m-d H:i:s")),array("idx"=>$lt->idx));

								// 주문한 상품에서 수량을 삭제
								if($goods_stat->unlimit!=1 && $goods_stat->number>0 ){ //무제한이 아닐때에만
									$number = $goods_stat->number - $lt->goods_cnt;
									$result = $this->common_m->update2("dh_goods",array("number"=>$number),array("idx"=>$lt->goods_idx)); //수량 변경
								}

							}

						}

						if($tmpOk==1 && $change_trade_code){
							$trade_code = $change_trade_code;
						}

						//포인트 사용했을 때 포인트 차감
						if($trade_data['userid'] && $trade_data['use_point'] > 0){
							$content = "상품구매사용";
							$arrays = array('userid'=>$trade_data['userid'],'point'=>$trade_data['use_point'],'sum'=>'-','content'=>$content,'flag'=>'trade','flag_idx'=>$trade_idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
							$this->member_m->point_insert($arrays);
						}

						//쿠폰 사용했을 때 쿠폰 사용처리
						if($trade_data['userid'] && $trade_data['coupon_idx'] && $trade_data['use_coupon'] > 0){
							$this->common_m->update2("dh_coupon_use",array('trade_code'=>$trade_code,'use_date'=>date("Y-m-d H:i:s")),array('idx'=>$trade_data['coupon_idx']));
						}

						if($tmpOk!=1){
							//메일보내기
							$data['trade_idx'] = $trade_idx;
							$result = $this->common_m->mailform(3,$data);
						}

					}


			}else{
				alert($this->input->post("go_url"),"잘못된 접근입니다.");
			}

			return $result;
		}


		public function kcp($data='')
		{
			$trade_data = $data['trade_data'];

			$res_cd = $this->input->post("res_cd");
			$res_msg = $this->input->post("res_msg");
			$trade_code = $this->input->post("trade_code",true);

			if($res_cd=="0000"){
				$tno = $this->input->post("tno");
				$good_name = $this->input->post("good_name");
				$buyr_name = $this->input->post("buyr_name");

				$insert_array = array('site_cd'=>$this->input->post("site_cd"),'req_tx'=>$this->input->post("req_tx"),'use_pay_method'=>$this->input->post("use_pay_method"),'res_cd'=>$this->input->post("res_cd"),'res_msg'=>$res_msg,'amount'=>$this->input->post("amount"),'ordr_idxx'=>$this->input->post("ordr_idxx"),'tno'=>$tno,'good_mny'=>$this->input->post("good_mny"),'good_name'=>$good_name,'buyr_name'=>$buyr_name,'buyr_tel1'=>$this->input->post("buyr_tel1"),'buyr_tel2'=>$this->input->post("buyr_tel2"),'buyr_mail'=>$this->input->post("buyr_mail"),'app_time'=>$this->input->post("app_time"),'card_cd'=>$this->input->post("card_cd"),'card_name'=>$this->input->post("card_name"),'noinf'=>$this->input->post("noinf"),'quota'=>$this->input->post("quota"),'app_no'=>$this->input->post("app_no"),'bank_name'=>$this->input->post("bank_name"),'bank_code'=>$this->input->post("bank_code"),'bankname'=>$this->input->post("bankname"),'depositor'=>$this->input->post("depositor"),'account'=>$this->input->post("account"),'va_date'=>$this->input->post("va_date"),'cash_yn'=>$this->input->post("cash_yn"),'cash_authno'=>$this->input->post("cash_authno"),'cash_tr_code'=>$this->input->post("cash_tr_code"),'cash_id_info'=>$this->input->post("cash_id_info"));

				$result = $this->common_m->insert2("dh_kcp_pay",$insert_array);

			}else{
				alert(cdir()."/dh_order/pay_error/".$res_cd."/?go_url=".$this->input->post("go_url"));
				exit;
			}

			return $result;
		}


		public function inicis($data='')
		{
			$trade_data = $data['trade_data'];

			$ResultCode = $this->input->post("ResultCode",true);
			$PayMethod = $this->input->post("PayMethod",true);
			$ResultMsg = $this->input->post("ResultMsg",true);
			$MOID = $this->input->post("trade_code",true);
			$TotPrice = $trade_data['total_price'];
			$ApplNum = $this->input->post("ApplNum",true);
			$CARD_Quota = $this->input->post("CARD_Quota",true);
			$CARD_Interest = $this->input->post("CARD_Interest",true);
			$CARD_Code = $this->input->post("CARD_Code",true);
			$ACCT_BankCode = $this->input->post("ACCT_BankCode",true);
			$CSHR_ResultCode = $this->input->post("CSHR_ResultCode",true);
			$CSHR_Type = $this->input->post("CSHR_Type",true);
			$VACT_Num = $this->input->post("VACT_Num",true);
			$VACT_BankCode = $this->input->post("VACT_BankCode",true);
			$VACT_Date = $this->input->post("VACT_Date",true);
			$VACT_InputName = $this->input->post("VACT_InputName",true);
			$VACT_Name = $this->input->post("VACT_Name",true);
			$regDate = date("Y-m-d H:i:s");

			if($ResultCode=="0000"){
				$TID = $this->input->post("tno");

				$insert_array = array('TID'=>$TID,'ResultCode'=>$ResultCode,'ResultMsg'=>$ResultMsg,'PayMethod'=>$PayMethod,'MOID'=>$MOID,'TotPrice'=>$TotPrice,'ApplNum'=>$ApplNum,'CARD_Quota'=>$CARD_Quota,'CARD_Interest'=>$CARD_Interest,'CARD_Code'=>$CARD_Code,'ACCT_BankCode'=>$ACCT_BankCode,'CSHR_ResultCode'=>$CSHR_ResultCode,'CSHR_Type'=>$CSHR_Type,'VACT_Num'=>$VACT_Num,'VACT_BankCode'=>$VACT_BankCode,'VACT_Date'=>$VACT_Date,'VACT_InputName'=>$VACT_InputName,'VACT_Name'=>$VACT_Name,'regDate'=>$regDate);

				$result = $this->common_m->insert2("dh_inicis_pay",$insert_array);

			}else{
				alert(cdir()."/dh_order/pay_error/".$ResultCode."/?go_url=".$this->input->post("go_url"));
				exit;
			}

			return $result;
		}


		public function getTradeOption($trade_code)
		{
			$sql = "select t.*,g.list_img,g.old_price from dh_trade_goods t,dh_goods g where g.idx=t.goods_idx and t.trade_code='".$this->db->escape_str($trade_code)."' order by t.idx desc";
			$query = $this->db->query($sql);
			$goods_list = $query->result();

			foreach($goods_list as $lt){
				$idx = $lt->idx;
				$sql = "select * from dh_trade_goods_option where trade_goods_idx='".$this->db->escape_str($lt->idx)."' and level=2 order by idx";
				$query = $this->db->query($sql);
				$option_list = $query->result();
				${'option_arr'.$idx}="";

				$cnt=0;
				foreach($option_list as $option){
					${'option_arr'.$idx}[$cnt]['idx'] = $option->idx;
					${'option_arr'.$idx}[$cnt]['option_idx'] = $option->option_idx;
					${'option_arr'.$idx}[$cnt]['option_code'] = $option->option_code;
					${'option_arr'.$idx}[$cnt]['title'] = $option->title;
					${'option_arr'.$idx}[$cnt]['name'] = $option->name;
					${'option_arr'.$idx}[$cnt]['price'] = $option->price;
					${'option_arr'.$idx}[$cnt]['cnt'] = $option->cnt;
					${'option_arr'.$idx}[$cnt]['flag'] = $option->flag;
					${'option_arr'.$idx}[$cnt]['level'] = $option->level;
					${'option_arr'.$idx}[$cnt]['point'] = $option->point;
					${'option_arr'.$idx}[$cnt]['chk_num'] = $option->chk_num;
					$cnt++;
				}

				$data['option_arr'.$idx] = ${'option_arr'.$idx};
			}

			$data['goods_list'] = $goods_list;

			return $data;
		}


		public function getTradeOptionList($goods_list)
		{
			$data="";
			foreach($goods_list as $lt){
				$idx = $lt->g_idx;
				$sql = "select * from dh_trade_goods_option where trade_goods_idx='".$this->db->escape_str($idx)."' and level=2 order by idx";
				$query = $this->db->query($sql);
				$option_list = $query->result();

				$cnt=0;
				foreach($option_list as $option){
					$data['option_arr'.$idx][$cnt]['idx'] = $option->idx;
					$data['option_arr'.$idx][$cnt]['option_idx'] = $option->option_idx;
					$data['option_arr'.$idx][$cnt]['option_code'] = $option->option_code;
					$data['option_arr'.$idx][$cnt]['title'] = $option->title;
					$data['option_arr'.$idx][$cnt]['name'] = $option->name;
					$data['option_arr'.$idx][$cnt]['price'] = $option->price;
					$data['option_arr'.$idx][$cnt]['cnt'] = $option->cnt;
					$data['option_arr'.$idx][$cnt]['flag'] = $option->flag;
					$data['option_arr'.$idx][$cnt]['level'] = $option->level;
					$data['option_arr'.$idx][$cnt]['point'] = $option->point;
					$data['option_arr'.$idx][$cnt]['chk_num'] = $option->chk_num;

					$cnt++;
				}
			}

			return $data;
		}


		public function kcp_cancel($trade_code)
		{
			$ordr_idxx = $this->input->post("ordr_idxx");
			$req_tx = $this->input->post("req_tx");
			$bSucc = $this->input->post("bSucc");
			$res_cd = $this->input->post("res_cd");
			$res_msg = $this->input->post("res_msg");
			$ordr_idxx = $this->input->post("ordr_idxx");
			$go_url = $this->input->post("go_url");
			$res_msg_bsucc = "";
			$result = "";
			$mode = $this->uri->segment(4,'list');

			if(!$go_url){
				$go_url = cdir()."/dh_order/shop_order_".$mode."/".$trade_code;
			}
			if($trade_code){

				if($req_tx == "pay")
				{
					//업체 DB 처리 실패
					if($bSucc == "false")
					{
						if ($res_cd == "0000")
						{
							$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 업체로 문의하여 확인하시기 바랍니다.";
						}
						else
						{
							$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 업체로 문의하여 확인하시기 바랍니다.";
						}
					}

				}else if($req_tx=="mod"){
					if($res_cd=="0000"){ //성공처리
						$result=1;

					}else{
						$res_msg_bsucc = "주문 취소 실패";
					}
				}

			}

			if($res_msg_bsucc){
				alert($go_url,$res_msg_bsucc);
				exit;
			}

			return $result;
		}


		public function inicis_cancel($trade_code)
		{
			$ResultCode = $this->input->post("ResultCode");
			$ResultMsg = $this->input->post("ResultMsg");
			$go_url = $this->input->post("go_url");
			$res_msg_bsucc = "";
			$result = "";
			$mode = $this->uri->segment(4,'list');

			if(!$go_url){
				$go_url = cdir()."/dh_order/shop_order_".$mode."/".$trade_code;
			}

			if($ResultCode=="00"){
				$result=1;
			}else{
				$res_msg_bsucc = $ResultMsg;
			}

			if($res_msg_bsucc){
				alert($go_url,$res_msg_bsucc);
				exit;
			}

			return $result;
		}


		public function change_stat($change_idx,$change_stat,$all='')
		{
			if($all==1){
				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($change_idx)."'");
				$change_idx = $trade_stat->idx;
			}else{
				$trade_stat = $this->common_m->getRow("dh_trade","where idx='".$this->db->escape_str($change_idx)."'");
			}

			$shop_info = $this->common_m->shop_info();
			$trade_code = $trade_stat->trade_code;

			if($trade_stat->trade_stat!=$change_stat){ //변경할 거래상태가 다를때에만 실행

				if($trade_stat->trade_stat == 9){
					back('주문취소건은 다시 복구할 수 없습니다.');
					exit;
				}else if($trade_stat->trade_stat == 4 && $change_stat < 4){
					back('판매완료건은 교환/반품/주문취소만 변경 가능합니다.');
					exit;
				}else{
					$result = $this->common_m->update2("dh_trade",array('trade_stat'=>$change_stat),array('idx'=>$change_idx));
					if($result){

						if($change_stat==2){ //결제완료

							$result = $this->common_m->update2("dh_trade",array('trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx));

						}if($change_stat==4){ //판매완료

							if($trade_stat->userid && $trade_stat->save_point > 0){ //포인트적립 +
									$content = "상품구매적립";
									$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
									$this->member_m->point_insert($arrays);
							}

							$result = $this->common_m->update2("dh_trade",array('trade_day_end'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx)); //판매완료일 등록

						}else if($change_stat==9){ //주문취소

							$result = $this->common_m->update2("dh_trade",array('trade_day_cancel'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx));

							if($trade_stat->userid && $trade_stat->use_point > 0){ //포인트 사용했다면 다시 되돌리기 +
								$result="";
								$content = "상품구매사용 주문취소";
								$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->use_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
								$result = $this->member_m->point_insert($arrays);
							}

							if($trade_stat->trade_stat==4 && $trade_stat->userid && $trade_stat->save_point > 0){ //포인트 적립되었다면 포인트 차감	-
								$result="";
								$content = "상품구매적립 주문취소";
								$arrays = array('userid'=>$trade_stat->userid,'point'=>'-'.$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
								$result = $this->member_m->point_insert($arrays);
							}

							/* 상품재고 돌리기 start */

							$trade_stat = $this->common_m->getRow("dh_trade","where idx='$change_idx'");

							$trade_goods_result = $this->common_m->getList2("dh_trade_goods","where trade_code='".$trade_stat->trade_code."'");

							foreach($trade_goods_result as $goods){
								$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$goods->goods_idx."'");
								$this->common_m->update2("dh_goods",array('number'=>$goods_stat->number+1),array('idx'=>$goods->goods_idx,'unlimit'=>0));

								$trade_goods_option_result = $this->common_m->getList2("dh_trade_goods_option","where goods_idx='".$goods->goods_idx."' and trade_code='".$trade_stat->trade_code."' and level=2");
								foreach($trade_goods_option_result as $option){

									$goods_option_row = $this->common_m->getRow2("dh_goods_option","where idx='".$option->option_idx."'");
									$this->common_m->update2("dh_goods_option",array('number'=>$goods_option_row->number+1),array('idx'=>$option->option_idx));
								}
							}
							/* 상품재고 돌리기 end */

							if($trade_stat->userid && $trade_stat->coupon_idx > 0){ //쿠폰 되돌리기
								$this->common_m->update2("dh_coupon_use",array('trade_code' => '','use_date' => ''),array('idx' => $trade_stat->coupon_idx));
							}


							if($all==''){
								result($result,'주문이 취소','/html/order/lists/'.$change_stat.'/m');
								exit;
							}

						}

						if($all==''){
							alert('/html/order/lists/'.$change_stat.'/m');
						}

					}

				}

			}else{
				if($all==''){
					alert('/html/order/lists/'.$change_stat.'/m');
				}
			}

			return $result;

		}


		public function delivery_ok($trade_idx)
		{
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='".$this->db->escape_str($trade_idx)."'");
			$delivery_idx = $this->input->post("delivery_idx".$trade_idx,true);
			$delivery_no = $this->input->post("delivery_no".$trade_idx,true);

			$result = $this->common_m->update2("dh_trade",array('delivery_idx'=>$delivery_idx,'delivery_no'=>$delivery_no),array('idx'=>$trade_idx));

			if($result && $delivery_idx && $delivery_no){

				if( $trade_stat->delivery_idx == $delivery_idx && $trade_stat->delivery_no == $delivery_no){

				}else if( $trade_stat->delivery_idx != $delivery_idx || $trade_stat->delivery_no != $delivery_no){
					//메일보내기
					$data['trade_idx'] = $trade_idx;
					$data['delivery_idx'] = $delivery_idx;
					$data['delivery_no'] = $delivery_no;
					$result = $this->common_m->mailform(4,$data);
				}

			}

		return $result;

		}


		public function getTmpList()
		{
			$sql = "select *,(select goods_name from dh_cart where trade_code=dh_trade_tmp.trade_code order by idx limit 1) as goods_name, (select count(idx) from dh_cart where trade_code=dh_trade_tmp.trade_code) as cnt from dh_trade_tmp order by idx desc limit 50";
			$query = $this->db->query($sql);
			$result = $query->result();
			return $result;

		}


		public function codeInput($mode='input')
		{
			$code = $this->db->escape_str($this->input->post("code",true));
			$name = $this->db->escape_str($this->input->post("name",true));
			$type = $this->db->escape_str($this->input->post("type",true));
			$date_flag = $this->db->escape_str($this->input->post("date_flag",true));
			$discount_flag = $this->db->escape_str($this->input->post("discount_flag",true));
			$price = $this->db->escape_str($this->input->post("price",true));
			$min_price = $this->db->escape_str($this->input->post("min_price",true));
			$max_price = $this->db->escape_str($this->input->post("max_price",true));
			$member_use = $this->db->escape_str($this->input->post("member_use",true));
			$member_level = $this->db->escape_str($this->input->post("member_level",true));

			$img_file = "";
			$real_file = "";

			if(isset($_FILES['img_file']['name']) && $_FILES['img_file']['size'] > 0)
			{

				$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/upload/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');

				$this->load->library('upload',$config);

				if(!$this->upload->do_upload('img_file')){ back(strip_tags($this->upload->display_errors())); }
				else{
					$write_data = $this->upload->data();
					$img_file	= $write_data['file_name'];
					$real_file	=	$_FILES['img_file']['name'];
				}
			}else if($mode=="edit"){
				$idx = $this->db->escape_str($this->input->post("idx",true));
				$editRow = $this->common_m->getRow("dh_coupon","where idx='$idx'");
				$img_file = $editRow->img_file;
				$real_file = $editRow->real_file;
			}

			$insert_array['name'] = $name;
			$insert_array['type'] = $type;
			$insert_array['date_flag'] = $date_flag;
			$insert_array['discount_flag'] = $discount_flag;
			$insert_array['price'] = $price;
			$insert_array['min_price'] = $min_price;
			$insert_array['max_price'] = $max_price;
			$insert_array['member_use'] = $member_use;
			$insert_array['member_level'] = $member_level;
			$insert_array['status'] = "1";
			$insert_array['img_file'] = $img_file;
			$insert_array['real_file'] = $real_file;

			if($date_flag==0){
				$start_date = $this->db->escape_str($this->input->post("start_date",true));
				$end_date = $this->db->escape_str($this->input->post("end_date",true));
				$insert_array['start_date'] = $start_date;
				$insert_array['end_date'] = $end_date;
			}else if($date_flag==1){
				$max_day = $this->db->escape_str($this->input->post("max_day",true));
				$insert_array['max_day'] = $max_day;
			}

			if($mode=="input"){
				$insert_array['code'] = $code;
				$insert_array['reg_date'] = date("Y-m-d H:i:s");
				$result = $this->common_m->insert2("dh_coupon",$insert_array);
			}else if($mode=="edit"){
				$result = $this->common_m->update2("dh_coupon",$insert_array,array('idx'=>$idx));
			}

			return $result;

		}


		public function couponGive($row,$admin='')
		{
			$userid = $this->session->userdata('USERID');
			if( ($admin==1 && $this->session->userdata('ADMIN_USERID')) || $userid==""){
				$userid = $row->userid;
			}

			$member_row = $this->common_m->getRow("dh_member","where outmode!=1 and userid='$userid'");
			$where_query = "";
			$nowdate = date("Y-m-d");
			$nowyear = date("Y");

			if($row->type=="1"){ //기념일 쿠폰이면 이번년도에 발급한적이 있는지 검사
				$where_query.= " and reg_date >= '".$nowyear."-01-01 00:00:00' and reg_date <= '".$nowyear."-12-31 23:59:59'";
			}


			$cnt = $this->common_m->getCount("dh_coupon_use","where code='".$row->code."' and userid='$userid' $where_query");

			if($cnt){ back("이미 발급받은 쿠폰입니다."); exit; }
			if($row->member_use==1 && $row->member_level && $row->member_level != $member_row->level){
				if($admin=="" || !$this->session->userdata('ADMIN_USERID')){ //관리자가 아니면
					back("쿠폰 발급 대상이 아닙니다.\\n관리자에게 문의하여 주세요."); exit;
				}else{
					back("쿠폰 발급 가능한 등급과 회원등급이 일치하지 않습니다."); exit;
				}
			}

			$insert_array['userid'] = $this->db->escape_str($userid);
			$insert_array['code'] = $this->db->escape_str($row->code);
			$insert_array['name'] = $this->db->escape_str($row->name);
			$insert_array['type'] = $this->db->escape_str($row->type);
			$insert_array['discount_flag'] = $this->db->escape_str($row->discount_flag);
			$insert_array['price'] = $this->db->escape_str($row->price);
			$insert_array['min_price'] = $this->db->escape_str($row->min_price);
			$insert_array['max_price'] = $this->db->escape_str($row->max_price);


			if($row->date_flag==1){ //기념일쿠폰이거나 이용기한 종류가 발금시점이거나
				$start_date = $nowdate;
				$end_date = date("Y-m-d",strtotime($row->max_day,strtotime($start_date)));
			}else{
				$start_date = $row->start_date;
				$end_date = $row->end_date;
			}

			$insert_array['start_date'] = $this->db->escape_str($start_date);
			$insert_array['end_date'] = $this->db->escape_str($end_date);
			$insert_array['reg_date'] = date("Y-m-d H:i:s");

			$result = $this->common_m->insert2("dh_coupon_use",$insert_array);

		 return 1;
		}

		public function inicis_post($data='')
		{

			require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/INIStdPayUtil.php');

			if($data['mode'] == "request"){

				$SignatureUtil = new INIStdPayUtil();
				/*
					//*** 위변조 방지체크를 signature 생성 ***

					oid, price, timestamp 3개의 키와 값을

					key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값

					ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004


				 * key기준 알파벳 정렬

				 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그대로 사용하여야함
				 */

				//############################################
				// 1.전문 필드 값 설정(***가맹점 개발수정***)
				//############################################
				// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
				$mid = $data['shop_info']['pg_id'];  // 가맹점 ID(가맹점 수정후 고정)
				//인증

				if($mid=="INIpayTest"){
					$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}else{
					$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}

				$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

				$orderNumber = $_REQUEST['TRADE_CODE']; // 가맹점 주문번호(가맹점에서 직접 설정)
				$price = $_REQUEST['total_price'];        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

				$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
				$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
				//###################################
				// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
				//###################################
				$mKey = $SignatureUtil->makeHash($signKey, "sha256");

				$params = array(
						"oid" => $orderNumber,
						"price" => $price,
						"timestamp" => $timestamp
				);
				$sign = $SignatureUtil->makeSignature($params, "sha256");

				/* 기타 */
				$siteDomain = "http://".$_SERVER['HTTP_HOST']."/pay/stdpay/INIStdPaySample"; //가맹점 도메인 입력
				// 페이지 URL에서 고정된 부분을 적는다.
				// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
				//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.

				$data=$mid."@@".$price."@@".$sign."@@".$mKey."@@".$timestamp."@@".$cardNoInterestQuota."@@".$cardQuotaBase;
				return $data;

			}else{

        require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/HttpClient.php');


        $util = new INIStdPayUtil();

        try {

            //#############################
            // 인증결과 파라미터 일괄 수신
            //#############################
            //		$var = $_REQUEST["data"];

            //#####################
            // 인증이 성공일 경우만
            //#####################
            if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

                //############################################
                // 1.전문 필드 값 설정(***가맹점 개발수정***)
                //############################################;

                $mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정

								if($mid=="INIpayTest"){
									$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}else{
									$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}

                $timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
                $charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
                $format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

                $authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
                $authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
                $netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

                $mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

                //#####################
                // 2.signature 생성
                //#####################
                $signParam["authToken"] 	= $authToken;  	// 필수
                $signParam["timestamp"] 	= $timestamp;  	// 필수
                // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.API 요청 전문 생성
                //#####################
                $authMap["mid"] 			= $mid;   		// 필수
                $authMap["authToken"] 		= $authToken; 	// 필수
                $authMap["signature"] 		= $signature; 	// 필수
                $authMap["timestamp"] 		= $timestamp; 	// 필수
                $authMap["charset"] 		= $charset;  	// default=UTF-8
                $authMap["format"] 			= $format;  	// default=XML


                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.API 통신 시작
                    //#####################

                    $authResultString = "";

                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;
                       // echo "<p><b>RESULT DATA :</b> $authResultString</p>";			//PRINT DATA
                    } else {
                        //echo "Http Connect Error\n";
                       // echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.API 통신결과 처리(***가맹점 개발수정***)
                    //############################################################
                    //echo "## 승인 API 결과 ##";

                    $resultMap = json_decode($authResultString, true);


                    /*************************  결제보안 추가 2016-05-18 START ****************************/
                    $secureMap["mid"]		= $mid;							//mid
                    $secureMap["tstamp"]	= $timestamp;					//timestemp
                    $secureMap["MOID"]		= $resultMap["MOID"];			//MOID
                    $secureMap["TotPrice"]	= $resultMap["TotPrice"];		//TotPrice

                    // signature 데이터 생성
                    $secureSignature = $util->makeSignatureAuth($secureMap);
                    /*************************  결제보안 추가 2016-05-18 END ****************************/

										?>
										<div style="display:none;"><?=$secureSignature."/".$resultMap["authSignature"]?></div>
										<?

									if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0) ){	//결제보안 추가 2016-05-18
										 /*****************************************************************************
											 * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.

										 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
												처리중 에러 발생시 망취소를 한다.
											 ******************************************************************************/
											 
										$no_login="";

										if(!$this->session->userdata('USERID')){
											$no_login="?nologin=1";
										}
									?>
									<form name="order_form" id="order_form" method="post" action="<?=cdir()?>/dh_order/shop_order/<?=$this->uri->segment(3,'').$no_login?>">
									<input type="hidden" name="trade_code" value="<?=$resultMap["MOID"]?>">
									<input type="hidden" name="tno" value="<?=$resultMap["tid"]?>">
									<input type="hidden" name="cash_yn" value="<? if(isset($resultMap["CSHRResultCode"]) && $resultMap["CSHRResultCode"]){?>Y<?}else{?>N<?}?>">
									<input type="hidden" name="cash_tr_code" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
									<input type="hidden" name="cash_id_info" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
									<input type="hidden" name="ACCT_BankCode" value="<? echo isset($resultMap["ACCT_BankCode"]) ? $resultMap["ACCT_BankCode"] : "";?>">
									<input type="hidden" name="VACT_BankCode" value="<? echo isset($resultMap["VACT_BankCode"]) ? $resultMap["VACT_BankCode"] : "";?>">
									<input type="hidden" name="VACT_Num" value="<? echo isset($resultMap["VACT_Num"]) ? $resultMap["VACT_Num"] : "";?>">
									<input type="hidden" name="VACT_Name" value=""<? echo isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "";?>>

									<input type="hidden" name="ResultCode" value="0000">
									<input type="hidden" name="ResultMsg" value="<? echo isset($resultMap["resultMsg"]) ? $resultMap["resultMsg"] : "";?>">
									<input type="hidden" name="PayMethod" value="<? echo isset($resultMap["payMethod"]) ? $resultMap["payMethod"] : "";?>">
									<input type="hidden" name="ApplNum" value="<? echo isset($resultMap["applNum"]) ? $resultMap["applNum"] : "";?>">
									<input type="hidden" name="CARD_Quota" value="<? echo isset($resultMap["CARD_Quota"]) ? $resultMap["CARD_Quota"] : "";?>">
									<input type="hidden" name="CARD_Interest" value="<? echo isset($resultMap["CARD_Interest"]) ? $resultMap["CARD_Interest"] : "";?>">
									<input type="hidden" name="CARD_Code" value="<? echo isset($resultMap["CARD_Code"]) ? $resultMap["CARD_Code"] : "";?>">
									<input type="hidden" name="CSHR_ResultCode" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
									<input type="hidden" name="CSHR_Type" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
									<input type="hidden" name="VACT_Date" value="<? echo isset($resultMap["VACT_Date"]) ? $resultMap["VACT_Date"] : "";?>">
									<input type="hidden" name="VACT_InputName" value="<? echo isset($resultMap["VACT_InputName"]) ? $resultMap["VACT_InputName"] : "";?>">
									</form>
									<?
									script_exe("document.order_form.submit();");

									} else {
											echo "거래 성공 여부<br>";
											echo "실패<br>";
											echo "결과 코드 " . @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null" ) . "<br>";

											//결제보안키가 다른 경우.
											if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
												echo "결과 내용 <p>" . "* 데이터 위변조 체크 실패" . "<br>";

												//망취소
												if(strcmp("0000", $resultMap["resultCode"]) == 0) {
													throw new Exception("데이터 위변조 체크 실패");
												}
											} else {
												echo "결과 내용 <p>" . @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null" ) . "<br>";
											}

                    }


									}catch (Exception $e) {
                    // $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // 실패시 처리(***가맹점 개발수정***)
                    //####################################
                    //---- db 저장 실패시 등 예외처리----//
                    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // 망취소 API
                    //#####################

                    $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)

                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }
									}



            } else {

                //#############
                // 인증 실패시
                //#############
                echo "<br/>";
                echo "####인증실패####";

                echo "<pre>" . var_dump($_REQUEST) . "</pre>";
            }

        } catch (Exception $e) {
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            echo $s;
        }

			}
		}




	public function orderCnt($name)
	{
		$this->db->select("count(distinct g.trade_code) as cnt");
		$this->db->from("dh_trade t");
		$this->db->join('dh_trade_goods g', 't.trade_code = g.trade_code');
		$this->db->where("t.trade_stat = '".$name."'");

		return $this->db->get()->row();
	}




	public function admTradeList($type='',$offset='',$limit='',$excel='')
	{
		if($type=="count"){
			$this->db->select("count(distinct g.trade_code) as cnt");
		}else{
			$this->db->select("t.idx,t.trade_code,t.delivery_idx,t.delivery_no,t.name,t.mobile,t.userid,t.trade_day,t.trade_method,t.tno,t.trade_stat,t.email,t.phone,t.send_name,t.send_phone,t.send_tel,t.zip1,t.addr1,t.addr2,t.send_text,t.price,t.total_price,t.use_point,g.goods_name,g.goods_cnt,g.goods_price,g.total_price as goods_total_price,g.option_cnt,g.idx as g_idx");
		}
		$this->db->from("dh_trade t");

		$data['query_string'] = "?";
		$trade_stat = $this->uri->segment(3,1);
		$order = $this->input->get('order');
		$start_date = $this->input->get("start_date");
		$end_date = $this->input->get("end_date");
		$trade_info = $this->input->get("trade_info");
		$trade_method = $this->input->get("trade_method");
		$search_order = $this->input->get("search_order");
		$cate_no1 = $this->input->get('cate_no1');
		$cate_no2 = $this->input->get('cate_no2');
		$cate_no3 = $this->input->get('cate_no3');
		$cate_no4 = $this->input->get('cate_no4');
		$goods_name = $this->input->get('goods_name');


		if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
		if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
		if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
		if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }

		$this->db->join('dh_trade_goods g', 't.trade_code = g.trade_code');
		//$this->db->where("t.trade_code = g.trade_code");

		if($trade_stat && $trade_stat!="all"){
			$this->db->where("t.trade_stat = '$trade_stat'");
		}

		for($i=4;$i>=1;$i--){
			if(${'cate_no'.$i}){
				$this->db->like('g.cate_no', ${'cate_no'.$i}, 'after');
				break;
			}
		}

		if($goods_name){
			$data['query_string'].= "&goods_name=".$goods_name;
			$this->db->like('g.goods_name', $goods_name);
		}

		if($start_date){
			$data['query_string'].= "&start_date=".$start_date;
			$this->db->where("t.trade_day >= '".$start_date." 00:00:00'");
		}

		if($end_date){
			$data['query_string'].= "&end_date=".$end_date;
			$this->db->where("t.trade_day <= '".$end_date." 23:59:59'");
		}

		if($trade_info && $search_order){
			$data['query_string'].= "&trade_info=".$trade_info;
			if($trade_info=="addr"){
				$this->db->like('t.addr1', $search_order);
				$this->db->or_like('t.addr2', $search_order);
			}else{
				$this->db->like('t.'.$trade_info, $search_order);
			}
		}

		if($trade_method){
			$this->db->where("t.trade_method = '$trade_method'");
		}


		switch($order){
			case 1 : $order_query = " t.idx asc "; break;
			case 2 : $order_query = " t.price desc "; break;
			case 3 : $order_query = " t.price asc "; break;
			default : $order_query = " t.idx desc "; break;
		}


		if($type=="count"){
			$totalCnt = $this->db->get()->row();
			if(isset($totalCnt->cnt)){ 
				$data['totalCnt'] = $totalCnt->cnt; 
			}else{ 
				$data['totalCnt'] = 0;
			}
		}else{

			if($excel!="1"){
				$this->db->group_by("t.trade_code");
			}

			$this->db->order_by('t.idx', "desc");

			if($excel!="1"){
				$this->db->limit($limit, $offset);
			}
			$data['list'] = $this->db->get()->result();
		}

		return $data;
	}





	public function vacctinput()
	{

		@extract($_GET);
		@extract($_POST);
		@extract($_SERVER);

		//**********************************************************************************
		//  이부분에 로그파일 경로를 수정해주세요.	

		$INIpayHome = $_SERVER['DOCUMENT_ROOT'].'/pay/stdpay';      // 이니페이 홈디렉터리
		//**********************************************************************************


		$TEMP_IP = getenv("REMOTE_ADDR");
		$PG_IP = substr($TEMP_IP, 0, 10);
		$ym=date("Ym");

		if ($PG_IP == "203.238.37" || $PG_IP == "39.115.212") {  //PG에서 보냈는지 IP로 체크
				$msg_id = $msg_id;             //메세지 타입
				$no_tid = $no_tid;             //거래번호
				$no_oid = $no_oid;             //상점 주문번호
				$id_merchant = $id_merchant;   //상점 아이디
				$cd_bank = $cd_bank;           //거래 발생 기관 코드
				$cd_deal = $cd_deal;           //취급 기관 코드
				$dt_trans = $dt_trans;         //거래 일자
				$tm_trans = $tm_trans;         //거래 시간
				$no_msgseq = $no_msgseq;       //전문 일련 번호
				$cd_joinorg = $cd_joinorg;     //제휴 기관 코드

				$dt_transbase = $dt_transbase; //거래 기준 일자
				$no_transeq = $no_transeq;     //거래 일련 번호
				$type_msg = $type_msg;         //거래 구분 코드
				$cl_close = $cl_close;         //마감 구분코드
				$cl_kor = $cl_kor;             //한글 구분 코드
				$no_msgmanage = $no_msgmanage; //전문 관리 번호
				$no_vacct = $no_vacct;         //가상계좌번호
				$amt_input = $amt_input;       //입금금액
				$amt_check = $amt_check;       //미결제 타점권 금액
				$nm_inputbank = $nm_inputbank; //입금 금융기관명
				$nm_input = $nm_input;         //입금 의뢰인
				$dt_inputstd = $dt_inputstd;   //입금 기준 일자
				$dt_calculstd = $dt_calculstd; //정산 기준 일자
				$flg_close = $flg_close;       //마감 전화
				//가상계좌채번시 현금영수증 자동발급신청시에만 전달
				$dt_cshr = $dt_cshr;       //현금영수증 발급일자
				$tm_cshr = $tm_cshr;       //현금영수증 발급시간
				$no_cshr_appl = $no_cshr_appl;  //현금영수증 발급번호
				$no_cshr_tid = $no_cshr_tid;   //현금영수증 발급TID

				$logfile = fopen($INIpayHome . "/log/result_".$ym.".log", "a+");

				fwrite($logfile, "************************************************");
				fwrite($logfile, "ID_MERCHANT : " . $id_merchant . "\r\n");
				fwrite($logfile, "MSG_ID : " . $msg_id . "\r\n");
				fwrite($logfile, "NO_TID : " . $no_tid . "\r\n");
				fwrite($logfile, "NO_OID : " . $no_oid . "\r\n");
				fwrite($logfile, "NO_VACCT : " . $no_vacct . "\r\n");
				fwrite($logfile, "AMT_INPUT : " . $amt_input . "\r\n");
				fwrite($logfile, "NM_INPUTBANK : " . $nm_inputbank . "\r\n");
				fwrite($logfile, "NM_INPUT : " . $nm_input . "\r\n");
				fwrite($logfile, "************************************************");

				/*
					fwrite( $logfile,"전체 결과값"."\r\n");
					fwrite( $logfile, $msg_id."\r\n");
					fwrite( $logfile, $no_tid."\r\n");
					fwrite( $logfile, $no_oid."\r\n");
					fwrite( $logfile, $id_merchant."\r\n");
					fwrite( $logfile, $cd_bank."\r\n");
					fwrite( $logfile, $dt_trans."\r\n");
					fwrite( $logfile, $tm_trans."\r\n");
					fwrite( $logfile, $no_msgseq."\r\n");
					fwrite( $logfile, $type_msg."\r\n");
					fwrite( $logfile, $cl_close."\r\n");
					fwrite( $logfile, $cl_kor."\r\n");
					fwrite( $logfile, $no_msgmanage."\r\n");
					fwrite( $logfile, $no_vacct."\r\n");
					fwrite( $logfile, $amt_input."\r\n");
					fwrite( $logfile, $amt_check."\r\n");
					fwrite( $logfile, $nm_inputbank."\r\n");
					fwrite( $logfile, $nm_input."\r\n");
					fwrite( $logfile, $dt_inputstd."\r\n");
					fwrite( $logfile, $dt_calculstd."\r\n");
					fwrite( $logfile, $flg_close."\r\n");
					fwrite( $logfile, "\r\n");
				 */

				fclose($logfile);


				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='$no_oid'");

				if($trade_stat->trade_stat==1 && $trade_stat->trade_method==4){ //입금대기 && 가상계좌일경우
					$dbOk = $this->common_m->update2("dh_trade",array('trade_stat'=>2,'trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx)); //결제완료로 변경
				}

		//************************************************************************************
				//위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로
				//리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
				//(주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
				//기타 다른 형태의 PRINT( echo )는 하지 않으시기 바랍니다
		  if($dbOk){
				$result="OK";                        // 절대로 지우지마세요
		  }else{
				$result="FAIL : db input error";
			}
		//*************************************************************************************
		}else{
			$result="FAIL : connect ip error";
		}

		return $result;
	}


	public function kcp_result()
	{
    /* ============================================================================== */
    /* =   PAGE : 공통 통보 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do			        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */

		if($_SERVER['REMOTE_ADDR']=="210.122.73.58" || $_SERVER['REMOTE_ADDR']=="203.238.36.173" || $_SERVER['REMOTE_ADDR']=="203.238.36.178"){
    /* ============================================================================== */
    /* =   01. 공통 통보 페이지 설명(필독!!)                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   공통 통보 페이지에서는,                                                  = */
    /* =   가상계좌 입금 통보 데이터를 KCP를 통해 실시간으로 통보 받을 수 있습니다. = */
    /* =                                                                            = */
    /* =   common_return 페이지는 이러한 통보 데이터를 받기 위한 샘플 페이지        = */
    /* =   입니다. 현재의 페이지를 업체에 맞게 수정하신 후, 아래 사항을 참고하셔서  = */
    /* =   KCP 관리자 페이지에 등록해 주시기 바랍니다.                              = */
    /* =                                                                            = */
    /* =   등록 방법은 다음과 같습니다.                                             = */
    /* =  - KCP 관리자페이지(admin.kcp.co.kr)에 로그인 합니다.                      = */
    /* =  - [쇼핑몰 관리] -> [정보변경] -> [공통 URL 정보] -> [공통 URL 변경 후]에  = */
    /* =    결과값은 전송받을 가맹점 URL을 입력합니다.                              = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 공통 통보 데이터 받기                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd      = $this->input->post("site_cd");                 // 사이트 코드
    $tno          = $this->input->post("tno");                 // KCP 거래번호
    $order_no     = $this->input->post("order_no");                 // 주문번호
    $tx_cd        = $this->input->post("tx_cd");                 // 업무처리 구분 코드
    $tx_tm        = $this->input->post("tx_tm");                 // 업무처리 완료 시간
    /* = -------------------------------------------------------------------------- = */
    $ipgm_name    = "";                                    // 주문자명
    $remitter     = "";                                    // 입금자명
    $ipgm_mnyx    = "";                                    // 입금 금액
    $bank_code    = "";                                    // 은행코드
    $account      = "";                                    // 가상계좌 입금계좌번호
    $op_cd        = "";                                    // 처리구분 코드
    $noti_id      = "";                                    // 통보 아이디
	$cash_a_no    = "";                                    // 현금영수증 승인번호
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   02-1. 가상계좌 입금 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
        $ipgm_name = $this->input->post("ipgm_name");                // 주문자명
        $remitter  = $this->input->post("remitter");                // 입금자명
        $ipgm_mnyx = $this->input->post("ipgm_mnyx");                // 입금 금액
        $bank_code = $this->input->post("bank_code");                // 은행코드
        $account   = $this->input->post("account");                // 가상계좌 입금계좌번호
        $op_cd     = $this->input->post("op_cd");                // 처리구분 코드
        $noti_id   = $this->input->post("noti_id");                // 통보 아이디
        $cash_a_no = $this->input->post("cash_a_no");                // 현금영수증 승인번호
    }


    /* ============================================================================== */
    /* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.      = */
    /* = -------------------------------------------------------------------------- = */
    /* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업에  = */
    /* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는     = */
    /* =   프로세스가 구성되어 있습니다.                                            = */
    /* =                                                                            = */
    /* =   * DB update가 정상적으로 완료된 경우                                     = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000으로     = */
    /* =   설정해 주시기 바랍니다.                                                  = */
    /* =                                                                            = */
    /* =   * DB update가 실패한 경우                                                = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000이외의   = */
    /* =   값으로 설정해 주시기 바랍니다.                                           = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='$order_no'");

				if(isset($trade_stat->idx) && $trade_stat->trade_stat==1 && $trade_stat->trade_method==4){ //입금대기 && 가상계좌일경우
					$result = $this->common_m->update2("dh_trade",array('trade_stat'=>2,'trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx)); //결제완료로 변경

					if($result){ $result = "0000"; }else{ $result = "1111"; }

				}else{
					$result="0001";
				}

    }else{
			$result=$tx_cd;
		}
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. result 값 세팅 하기                                                  = */
    /* ============================================================================== */
		}else{
			$result="1100";
		}

		return $result;
	}



	
		
	public function vacctinput_m()
	{
//*******************************************************************************
// FILE NAME : mx_rnoti.php
// FILE DESCRIPTION :
// 이니시스 smart phone 결제 결과 수신 페이지 샘플
// 기술문의 : ts@inicis.com
// HISTORY 
// 2010. 02. 25 최초작성 
// 2010  06. 23 WEB 방식의 가상계좌 사용시 가상계좌 채번 결과 무시 처리 추가(APP 방식은 해당 없음!!)
// 2017. 09. 18 가산 IP 추가
// WEB 방식일 경우 이미 P_NEXT_URL 에서 채번 결과를 전달 하였으므로, 
// 이니시스에서 전달하는 가상계좌 채번 결과 내용을 무시 하시기 바랍니다.
//*******************************************************************************

		$dbOk = "";

		@extract($_GET);
		@extract($_POST);
		@extract($_SERVER);

  $PGIP = $_SERVER['REMOTE_ADDR'];
  
  if($PGIP == "211.219.96.165" || $PGIP == "118.129.210.25" || $PGIP == "183.109.71.153" || $PGIP == "39.115.212.9")	//PG에서 보냈는지 IP로 체크
  {


		$P_TID = $P_TID;
		$P_MID = $P_MID;
		$P_AUTH_DT = $P_AUTH_DT;
		$P_STATUS = $P_STATUS; 
		$P_TYPE = $P_TYPE;
		$P_OID = $P_OID;
		$P_FN_CD1 = $P_FN_CD1;
		$P_FN_CD2 = $P_FN_CD2;
		$P_FN_NM = $P_FN_NM;
		$P_AMT = $P_AMT;
		$P_UNAME = $P_UNAME;
		$P_RMESG1 = $P_RMESG1;
		$P_RMESG2 = $P_RMESG2;
		$P_NOTI = $P_NOTI;
		$P_AUTH_NO = $P_AUTH_NO;
		$P_CARD_ISSER_CODE = $P_CARD_ISSER_CODE;
		$P_CARD_NUM = $P_CARD_NUM;
		$P_PRTC_CODE = $P_PRTC_CODE;
		$P_SRC_CODE = $P_SRC_CODE;


		//WEB 방식의 경우 가상계좌 채번 결과 무시 처리
		//(APP 방식의 경우 해당 내용을 삭제 또는 주석 처리 하시기 바랍니다.)
		 if($P_TYPE == "VBANK")	//결제수단이 가상계좌이며
        	{
           	   if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
           	   {
	               $dbOk = "OK";
           	   }else if($P_STATUS == "02"){

									$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='$P_OID'");

									if($trade_stat->trade_stat==1 && $trade_stat->trade_method==4 && $trade_stat->tno == $P_TID){ //입금대기 && 가상계좌일경우
										$dbOk = $this->common_m->update2("dh_trade",array('trade_stat'=>2,'trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx)); //결제완료로 변경

										if($dbOk){ $dbOk = "OK"; }

									}else{
										$dbOk = "FAIL";
									}

							 }
        	}else{
						
						$dbOk = "OK";

					}



  		$PageCall_time = date("H:i:s");

		$value = array(
				"PageCall time" => $PageCall_time,
				"P_TID"			=> $P_TID,  
				"P_MID"     => $P_MID,  
				"P_AUTH_DT" => $P_AUTH_DT,      
				"P_STATUS"  => $P_STATUS,
				"P_TYPE"    => $P_TYPE,     
				"P_OID"     => $P_OID,  
				"P_FN_CD1"  => $P_FN_CD1,
				"P_FN_CD2"  => $P_FN_CD2,
				"P_FN_NM"   => $P_FN_NM,  
				"P_AMT"     => $P_AMT,  
				"P_UNAME"   => $P_UNAME,  
				"P_RMESG1"  => $P_RMESG1,  
				"P_RMESG2"  => $P_RMESG2,
				"P_NOTI"    => $P_NOTI,  
				"P_AUTH_NO" => $P_AUTH_NO
				);

					
			 $INIpayHome = $_SERVER['DOCUMENT_ROOT'].'/pay/INIpay50/m';

 			// 결제처리에 관한 로그 기록
			$file = $INIpayHome."/log/noti_input_".date("Ymd").".log";
 			writeLog($value,$file);
 
 
		/***********************************************************************************
		 ' 위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로 실패시는 "FAIL" 을
		 ' 리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
		 ' (주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
		 ' 기타 다른 형태의 echo "" 는 하지 않으시기 바랍니다
		'***********************************************************************************/
	
		 if($dbOk=="OK")
		    echo "OK"; //절대로 지우지 마세요
		 else
			 echo "FAIL";

  }

	}

}