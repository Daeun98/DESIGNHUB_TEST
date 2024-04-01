
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<!-- 쿠폰 내역 -->
					<div class="my-point-top">
						<h3 class="order-tit">쿠폰 내역</h3>
						
						<div class="my-point-box">
							<ul class="my-point">
								<li>사용 가능한 보유 쿠폰 : <em><?=number_format($totalCnt)?>장</em></li>
							</ul>
						</div>
					</div>

					
					<table class="shop-cart point-list">
						<caption>쿠폰 내역</caption>
						<thead>
							<tr>
								<th class="col-df">번호</th>
								<th class="col-wide">발급일자</th>
								<th>쿠폰명</th>
								<th class="col-wide2">유효기간</th>
								<th class="col-wide">할인</th>
							</tr>
						</thead>
						<tbody>
							<? if($totalCnt==0){?>
							<tr>
								<td colspan="5" class="no-ct">쿠폰 내역이 없습니다.</td>
							</tr>
							<?}else{?>
							<? 
							$list_cnt=0;
							foreach($list as $lt){
								$list_cnt++;
							?>
							<tr>
								<td><?=$list_cnt?></td>
								<td><?=substr($lt->reg_date,0,10)?></td>
								<td class="cart-prod"><?=$lt->name?></td>
								<td><?=$lt->start_date?> ~ <?=$lt->end_date?></td>
								<td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
							</tr>
							<? 
							$totalCnt--;
							}
							}
							?>
						</tbody>
					</table>
						
					<?if($list_cnt>0){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$Page?>
					</div><!-- END Pager -->
					<?}?>

					
				</div><!-- END 주문 Wrap -->
			

			</div><!-- END Shop Wrap -->