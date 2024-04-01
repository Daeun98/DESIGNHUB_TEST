
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<ul class="order-noti mb30">
						<li>[주문번호] 혹은 [주문상품]을 클릭하시면 주문상세 내역 및 상품별 배송상황을 조회하실 수 있습니다.</li>
					</ul>

					<h3 class="order-tit">주문내역 조회</h3>
					<div class="order-list-filter">
						<div class="float-l">
							<strong class="bl-noti">조회기간</strong>
							<button type="button" class="cart-btn<?if($this->input->get("search_day")==""){?>1<?}else{?>2<?}?>" onclick="search_day('');">전체</button>
							<button type="button" class="cart-btn<?if($this->input->get("search_day")==1){?>1<?}else{?>2<?}?>" onclick="search_day(1);">15일</button>
							<button type="button" class="cart-btn<?if($this->input->get("search_day")==2){?>1<?}else{?>2<?}?>" onclick="search_day(2);">1개월</button>
							<button type="button" class="cart-btn<?if($this->input->get("search_day")==3){?>1<?}else{?>2<?}?>" onclick="search_day(3);">3개월</button>
							<button type="button" class="cart-btn<?if($this->input->get("search_day")==4){?>1<?}else{?>2<?}?>" onclick="search_day(4);">3개월 이전</button> 
						</div>
						<div class="float-r">
							<a href="<?=cdir()?>/dh_order/orderList/return/" class="cart-btn2">교환/반품/취소 내역</a>
						</div>					
					</div>
					<table class="shop-cart mb20">
						<caption>주문내역 리스트</caption>
						<thead>
							<tr>
								<th class="col-wide">주문코드</th>
								<th>주문상품</th>
								<th class="col-date">주문일자</th>
								<th class="col-df">결제금액</th>
								<th class="col-df">주문상태</th>
								<th class="col-df">주문변경</th>
							</tr>
						</thead>
						<tbody>
							<? if($totalCnt==0){?>
							<tr>
								<td colspan="6"><p class="no-ct">주문내역이 없습니다.</p></td>
							</tr>
							<?}else{?>
							<? 
							$list_cnt=0;
							foreach($list as $lt){
								$list_cnt++;
								$go_cancel="";
		
								if( ($lt->trade_method==1 && $lt->trade_stat==2) || ($lt->trade_method==4 && $lt->trade_stat==1) ){
									$go_cancel = "cancel('".$lt->trade_code."',1,'".$lt->tno."')";
								}else if($lt->trade_method==2 && $lt->trade_stat==1){
									$go_cancel = "cancel('".$lt->trade_code."',2)";
								}

								$nowdate = date("Y-m-d");
								$trade_day_end = substr($lt->trade_day_end,0,10);
								$day30 = date("Y-m-d",strtotime("+30 day",strtotime($trade_day_end)));
							?>
							<tr>
								<td><a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?>"><?=$lt->trade_code?></a></td>
								<td class="cart-prod"><a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?>"><?=$lt->goods_name?> <?if($lt->cnt>1){?>외 <?=$lt->cnt-1?>건<?}?></a></td>
								<td><?=substr($lt->trade_day,0,10)?></td>
								<td><?=number_format($lt->price)?></td>
								<td><?=$shop_info['trade_stat'.$lt->trade_stat]?></td>
								<td>
								<?if($go_cancel){?>
									<button type="button" class="cart-btn3" onclick="<?=$go_cancel?>">주문취소</button>
								<?}else if($lt->trade_stat==3 && $lt->delivery_no){ ?>
									<button type="button" class="cart-btn3" onclick="window.open('<?=$shop_info['delivery_url'.$lt->delivery_idx]?>','','')">배송조희</button>
								<?}else if($this->session->userdata('USERID') && $lt->trade_stat==4 && $nowdate <= $day30 && $lt->review==0){?>
									<button type="button" class="cart-btn1" onclick="javascript:location.href='<?if($lt->cnt==1){?><?=cdir()?>/dh_board/write/<?=$shop_info['review_code']?>?goods_idx=<?=$lt->goods_idx?>&trade_goods_idx=<?=$lt->trade_goods_idx?><?}else{?><?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?><?}?>'">리뷰등록</button></td>
								<?}else if($lt->trade_stat < 3){?>
									<button type="button" class="cart-btn3" onclick="javascript:location.href='<?=cdir()?>/dh_order/shop_order_return/<?=$lt->trade_code?>/10';">주문취소</button>
								<?}?></td>
							</tr>
							<? } 
							}?>
						</tbody>
					</table>

					<?if($totalCnt>0){?>
					<!-- Pager -->
					<p class="board-pager align-c" title="페이지 이동하기">
						<?=$Page?>
					</p><!-- END Pager -->
					<?}?>


					
					<!-- 주문상태 안내 -->
					<h3 class="order-tit mt50">주문상태 안내</h3>
					<div class="order-status-box">
						<ul class="order-status">
							<li><span class="img"><img src="/image/shop/process1.png" alt=""></span>
								<p class="tit">주문완료</p>
								<p class="txt">주문이 성공적으로<br>접수 된 상태입니다.<br>(이메일 및 SMS 발송)</p>
							</li>
							<li><span class="img"><img src="/image/shop/process2.png" alt=""></span>
								<p class="tit">입금대기중</p>
								<p class="txt">입금 전 상태입니다.<br>7일 내 미입금시<br>주문이 취소됩니다.</p>
							</li>
							<li><span class="img"><img src="/image/shop/process3.png" alt=""></span>
								<p class="tit">상품준비중</p>
								<p class="txt">입금이 완료되어<br>상품을 준비중입니다.</p>
							</li>
							<li><span class="img"><img src="/image/shop/process4.png" alt=""></span>
								<p class="tit">배송중</p>
								<p class="txt">출고가 완료된 상태입니다.<br>출고후 1~2일 내에<br>배송이 완료됩니다.</p>
							</li>
							<li><span class="img"><img src="/image/shop/process5.png" alt=""></span>
								<p class="tit">배송완료</p>
								<p class="txt">상품이 고객님께<br>도착한 상태입니다.</p>
							</li>
						</ul>
					</div>
					<!-- END 주문상태 안내 -->

				</div><!-- END 주문 Wrap -->

	<? $self_url = str_replace("/index.php","",$_SERVER['PHP_SELF']); ?>
			
			<script>
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

			function search_day(num)
			{
				location.href="<?=$self_url?>?search_day="+num;
			}
			</script>
			
<? include $shop_info['pg_company']."_cancel.php"; ?>
