
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<ul class="order-noti mb30">
						<li>고객님의 주문 교환/반품/취소 처리 내역을 확인하실 수 있습니다.</li>
						<li><em class="em">주문 취소/반품 처리완료 이후 복구는 불가능</em>하며, 다시 상품을 구매하고 싶으시면 재주문 해 주셔야 합니다.</li>
					</ul>

					<h3 class="order-tit">교환/반품/취소 내역 조회</h3>
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
							<a href="<?=cdir()?>/dh_order/orderList/" class="cart-btn2">정상 주문 조회</a>
						</div>
					</div>


					<!--
						신청완료 - 고객이 주문 변경 신청을 완료한 상태
						접수완료 - 업체와 고객이 Contact 후 상품 배송/교환/반품/환불을 대기하고 있는 상태
						처리완료 - 교환/반품/환불 처리가 완료된 상태
					-->

					<table class="shop-cart mb20">
						<caption>주문변경 리스트</caption>
						<thead>
							<tr>
								<th class="col-wide">주문코드</th>
								<th>주문상품</th>
								<th class="col-date">주문일자</th>
								<!-- <th class="col-date">처리일자</th> -->
								<th class="col-df">처리유형</th>
								<th class="col-df">처리상태</th>
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
								$trade_name = $shop_info['trade_stat'.$lt->trade_stat];
								$trade_name = mb_substr($trade_name,0,2,'utf-8');
								$trade_result = "<em class='em'>처리완료</em>";
								switch($lt->trade_stat){
									case 5 : $trade_result = "접수완료"; break;
									case 6 : $trade_result = "<em class='em'>처리완료</em>"; break;
									case 7 : $trade_result = "접수완료"; break;
									case 8 : $trade_result = "<em class='em'>처리완료</em>"; break;
									case 9 : $trade_name = "취소"; break;
									case 10 : $trade_result = "접수완료"; break;
								}
							?>
							<tr>
								<td><a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?>"><?=$lt->trade_code?></a></td>
								<td class="cart-prod"><a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?>"><?=$lt->goods_name?> <?if($lt->cnt>1){?>외 <?=$lt->cnt-1?>건<?}?></a></td>
								<td><?=substr($lt->trade_day,0,10)?></td>
								<!-- <td>2016-08-19</td> -->
								<td><?=$trade_name?></td>
								<td><?=$trade_result?></td>
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
					<h3 class="order-tit mt50">주문 변경 상태 안내</h3>
					<div class="order-status-box">
						<ul class="order-status type2">
							<li><span class="img"><img src="/image/shop/process_cc1.png" alt=""></span>
								<p class="tit">신청완료</p>
								<p class="txt">고객님께서<br>주문 취소/교환/반품을<br>신청하신 상태입니다.</p>
							</li>
							<li><span class="img"><img src="/image/shop/process_cc2.png" alt=""></span>
								<p class="tit">접수완료</p>
								<p class="txt">상담원이 고객님과 연결 후<br>취소/교환/반품 신청이<br>접수 된 상태입니다.</p>
							</li>
							<li><span class="img"><img src="/image/shop/process_cc3.png" alt=""></span>
								<p class="tit">처리완료</p>
								<p class="txt">주문이 취소되거나,<br>상품이 업체에 도착하여<br>교환/반품처리가<br>완료된 상태입니다.</p>
							</li>
						</ul>
					</div>
					<!-- END 주문상태 안내 -->

				</div><!-- END 주문 Wrap -->


	<? $self_url = str_replace("/index.php","",$_SERVER['PHP_SELF']); ?>
			
			<script>
			function search_day(num)
			{
				location.href="<?=$self_url?>?search_day="+num;
			}
			</script>
			