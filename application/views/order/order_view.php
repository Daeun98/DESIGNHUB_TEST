<?
	if($trade_stat->userid){
		if($trade_stat->userid != $this->session->userdata('USERID')){
			alert('/','잘못된 접근입니다.');
			exit;
		}
	}
?>
			
			<!-- Shop Wrap -->
			<div class="shop-wrap">

				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<!-- 주문리스트 -->
					<h3 class="order-tit">주문 상품 리스트</h3>
					
					<!-- 주문상태 : 입금대기중/상품준비중/배송중/배송완료 -->

					<table class="shop-cart mb50">
						<caption>주문 상품 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-df">수량</th>
								<th class="col-df">소계금액</th>
								<th class="col-df">주문상태</th>
								<? if($this->session->userdata('USERID') && $trade_stat->trade_stat!=9){?><th class="col-df">리뷰</th><?}?>
							</tr>
						</thead>
						<tbody>
							<? foreach($goods_list as $lt){?>
							<tr>
								<td><?=$lt->goods_code?></td>
								<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=$lt->cate_no?>"><?=$lt->goods_name?></a></p>
										<p class="prod-op">
										<? if($lt->option_cnt > 0){
											for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){						
												$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
												$plus="";
												if(count($price)<2){ $plus="+"; }
												$title = ${'option_arr'.$lt->idx}[$i]['title'];
												$name = ${'option_arr'.$lt->idx}[$i]['name'];
												$price = ${'option_arr'.$lt->idx}[$i]['price'];
												$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
												$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
												if($flag==1){ $ltFlag=$flag; }
										?>
											<p class="prod-op">
											<em><?=$title?></em> : <?=$name?>
											<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
											<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
											</p>
										<?
											}
										}?>			
										</p>
									</div>
								</td>
								<td>
									<p class="cart-price">
										<? if($lt->old_price){?>
										<del><?=number_format($lt->old_price)?>원</del>
										<ins><?=number_format($lt->goods_price)?>원</ins>
										<?}else{?>
										<?=number_format($lt->goods_price)?>원
										<?}?>
									</p>
								</td>
								<td><? if($lt->goods_cnt>0){ echo $lt->goods_cnt; }?></td>
								<td><?=number_format($lt->total_price)?>원</td>
								<td><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></td>
								
								<td>
								<?
									$nowdate = date("Y-m-d");
									$trade_day_end = substr($trade_stat->trade_day_end,0,10);
									$day30 = date("Y-m-d",strtotime("+30 day",strtotime($trade_day_end)));
								?>
								<? if($this->session->userdata('USERID') && $trade_stat->trade_stat==4 && $nowdate <= $day30 && $lt->review==0){?><button type="button" class="cart-btn1" onclick="javascript:location.href='<?=cdir()?>/dh_board/write/<?=$shop_info['review_code']?>?goods_idx=<?=$lt->goods_idx?>&trade_goods_idx=<?=$lt->idx?>'">리뷰등록</button><?}else if($lt->review!=0){?>
								<button type="button" class="cart-btn1" onclick="javascript:location.href='<?=cdir()?>/dh_board/views/<?=$lt->review?>'">작성완료</button>
								<?}?>
								</td>
							</tr>
							<?}?>
						</tbody>
					</table>
					<!-- END 주문리스트 -->

					<!-- 주문 정보 -->
					<h3 class="order-tit">주문 정보</h3>
					<table class="order-field">
						<caption>주문 정보</caption>
						<tr>
							<th>주문코드</th>
							<td><?=$trade_stat->trade_code?></td>
						</tr>
						<tr>
							<th>주문일자</th>
							<td><?=substr($trade_stat->trade_day,0,10)?></td>
						</tr>
						<? $go_cancel=""; ?>
						<tr>
							<th>주문변경</th>
							<td>
								<!-- 입금대기,상품준비중(결제완료) : [주문취소] 노출 / 배송완료 : [교환신청],[반품신청] 노출
									변경신청 후에는 버튼과 안내문구를 감추고 하단 주석대로 컨텐츠 표시 -->
								<p>
									<? 
									if($trade_stat->trade_stat==4 && $trade_stat->delivery_day!="0000-00-00 00:00:00" && $day7 >= date("Y-m-d")){
									?>
									<button type="button" class="cart-btn2" onclick="location.href='<?=cdir()?>/dh_order/shop_order_return/<?=$trade_code?>/5';">교환신청</button>
									<button type="button" class="cart-btn3" onclick="location.href='<?=cdir()?>/dh_order/shop_order_return/<?=$trade_code?>/7';">반품신청</button>
									<?}else{				
										if( ($trade_stat->trade_method==1 && $trade_stat->trade_stat==2) || ($trade_stat->trade_method==4 && $trade_stat->trade_stat==1) ){
											$go_cancel = "cancel('".$trade_stat->trade_code."',1,'".$trade_stat->tno."')";
										}else if($trade_stat->trade_method==2 && $trade_stat->trade_stat==1){
											$go_cancel = "cancel('".$trade_stat->trade_code."',2)";
										}else if($trade_stat->trade_stat < 3){
											$go_cancel = "javascript:location.href='".cdir()."/dh_order/shop_order_return/".$trade_stat->trade_code."/10';";
										}

										if($go_cancel){											
									?>										
										<button type="button" class="cart-btn3" onclick="<?=$go_cancel?>">주문취소</button>
									<?}
									}
									?>

								</p>
								<? if($go_cancel){ ?>
								<p class="mt5" style="line-height:1.5em;">
									<small class="bl-noti">주문 취소/반품 처리 완료 이후 복구는 불가능하며, 다시 상품을 구매하고 싶으시면 재주문 해 주셔야 합니다.</small>
								</p>
								<?}?>

								<!-- 취소/교환/반품 신청중·처리완료일 경우 변경유형 + 처리상태 표시 ex) [교환] 신청완료, [반품] 접수완료, [취소] 처리완료 -->
								<!-- <p>[교환] <em class="em">처리완료</em> <small>2016-08-22</small> : 상담 후 환불 취소처리 되었습니다.(관리자코멘트가 있는경우)</p> -->
							</td>
						</tr>
					</table>
					<!-- END 주문 정보 -->
					
					
					<!-- 구매자 정보 -->
					<h3 class="order-tit">구매자 정보</h3>
					<table class="order-field">
						<caption>구매자 정보 확인</caption>
						<tr>
							<th>구매고객명</th>
							<td style="width:30%;"><?=$trade_stat->name?></td>
							<th>이메일</th>
							<td><?=$trade_stat->email?></td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td colspan="3"><?=$trade_stat->phone?></td>
						</tr>
					</table>
					<!-- END 구매자 정보 -->

					
					<!-- 배송지 정보 -->
					<h3 class="order-tit">배송지 정보</h3>
					<table class="order-field">
						<caption>배송지 정보 확인</caption>
						<tr>
							<th>받으시는 분</th>
							<td colspan="3"><?=$trade_stat->send_name?></td>
						</tr>
						<tr>
							<th>주소</th>
							<td colspan="3">(<?=$trade_stat->zip1?>) <?=$trade_stat->addr1?> <?=$trade_stat->addr2?></td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td style="width:30%;"><?=$trade_stat->send_phone?></td>
							<th>전화번호</th>
							<td><?=$trade_stat->send_tel?></td>
						</tr>
						<tr>
							<th>배송시 요청사항</th>
							<td colspan="3"><?=$trade_stat->send_text?></td>
						</tr>
						<tr>
							<th><label for="dv-num" class="dh_red">운송장번호</label></th>
							<td colspan="3"><?=$trade_stat->delivery_no?> <? if($trade_stat->delivery_no){ echo "(".$delivery_row->val.")";?> <button type="button" class="cart-btn3 ml10" onclick="window.open('<?=$delivery_url_row->val?><?=$trade_stat->delivery_no?>','','')">배송조희</button><?}?></td>
						</tr>
					</table>
					<!-- END 배송지 정보 -->

					
					<!-- 결제정보 -->
					<h3 class="order-tit">결제 정보</h3>
					<table class="order-field">
						<caption>결제 정보 확인</caption>
						<tr>
							<th>결제 수단</th>
							<td style="width:30%;"><?=$shop_info['trade_method'.$trade_stat->trade_method]?>
							<? if($trade_stat->trade_method==1){ ?>
							<button type="button" class="cart-btn2 ml10" onclick="javascript:window.open('https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=<?=$trade_stat->tno?>&order_no=<?=$trade_stat->trade_code?>&trade_mony=<?=$trade_stat->total_price?>','','width=470,height=815');">영수증보기</button>
							<?}?>
							</td>
							<th>결제 상태</th>
							<td><em class="em"><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></em></td>
						</tr>
						<tr>
							<th>상품 금액</th>
							<td><?=number_format($trade_stat->goods_price)?>원</td>
							<th>배송비</th>
							<td><?=number_format($trade_stat->delivery_price)?>원</td>
						</tr>
						<? if($trade_stat->userid){ ?>
						<tr>
							<th>포인트할인</th>
							<td><? if($trade_stat->use_point){?>- <?=number_format($trade_stat->use_point)?>원<?}else{?>0원<?}?></td>
							<th>쿠폰할인</th>
							<td><? if($trade_stat->coupon_idx ){?>-<?=number_format($trade_stat->use_coupon)?>원 [ <?=$coupon_stat->name?> ]<?}?></td>
						</tr>
						<?}?>
						<tr>
							<th>총 결제금액</th>
							<td><?=number_format($trade_stat->total_price)?>원</td>
							<th>결제 일시</th>
							<td><?=$trade_stat->trade_day?></td>
						</tr>
					</table>
					<!-- END 결제정보 -->

					<? if($trade_stat->trade_method==2){ ?>

					<!-- 무통장 입금일 경우에만 노출 -->
					<h3 class="order-tit">무통장 입금 정보</h3>
					<table class="order-field">
						<caption>무통장 입금 정보</caption>
						<tr>
							<th>입금자명</th>
							<td><?=$trade_stat->enter_name?></td>
						</tr>
						<tr>
							<th>입금은행</th>
							<td><?=$trade_stat->enter_bank?></td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 무통장 입금일 경우에만 노출 -->

					<? }else if($trade_stat->trade_method==4){ //가상계좌?>
					<h3 class="order-tit">가상계좌 정보</h3>
					<table class="order-field">
						<caption>가상계좌 입금 정보</caption>
						<tr>
							<th>입금은행</th>
							<td><?=$trade_stat->enter_bank?></td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>가상계좌 결제는 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>가상계좌 결제는 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<?}?>
						
					<!-- 하단 버튼 -->
					<div class="align-c">
						<button type="button" class="btn-emp-border" onclick="javascript:location.href='<?=cdir()?>/dh_order/orderList/<?=$query_string.$param?>';">이전으로</button>
					</div><!-- END 하단 버튼 -->
					
				</div><!-- END 주문 Wrap -->
			
			</div><!-- END Shop Wrap -->

			<script>
			
			
			function show_receipt(tid) // 이니시스 영수증 출력
			{
				var receiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid=" + tid + "&noMethod=1";
				window.open(receiptUrl,"receipt","width=430,height=700");
			
			}
				


			function cancel(trade_code,trade_method,tno)
			{
				if(confirm("주문을 취소하시겠습니까?")){

					if(trade_method==1){
						card_cancel(trade_code,tno);
					}else{
						location.href="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/list/<?=$query_string.$param?>";
					}
				}
			}			
			</script>
			
<? include $shop_info['pg_company']."_cancel.php"; ?>