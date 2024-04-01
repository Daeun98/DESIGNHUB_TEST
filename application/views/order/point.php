
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<!-- 포인트 내역 -->
					<div class="my-point-top">
						<h3 class="order-tit">포인트 내역</h3>
						
						<div class="my-point-box">
							<ul class="my-point">
								<li>현재 포인트 : <em><?=number_format($total_point)?> P</em></li>
								<li>사용 포인트 : <?=str_replace("-","",number_format($use_point))?> P</li>
								<li>누적 포인트 : <?=number_format($sum_point)?> P</li>
							</ul>
						</div>
					</div>

					
					<table class="shop-cart point-list">
						<caption>포인트 내역</caption>
						<thead>
							<tr>
								<th class="col-df">번호</th>
								<th>내역상세</th>
								<th class="col-wide">적용 포인트</th>
								<th class="col-wide">거래일자</th>
							</tr>
						</thead>
						<tbody>
							<? if($totalCnt==0){?>
							<tr>
								<td colspan="4" class="no-ct">포인트 내역이 없습니다.</td>
							</tr>
							<?}else{?>
							<? 
							$list_cnt=0;
							foreach($list as $lt){
								$list_cnt++;
							?>
							<tr>
								<td><?=$listNo?></td>
								<td class="cart-prod"><?=$lt->content?><?if($lt->flag=="trade" && $lt->flag_idx){?> 거래번호 : <a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code?>"><?=$lt->trade_code?></a><?}?></td>
								<td><span class="point-used"><?=number_format($lt->point)?> P</span></td>
								<td><?=strDateCut($lt->reg_date,3)?></td>
							</tr>
							<? 
							$listNo--;
							}
							}
							?>
						</tbody>
					</table>
						
					<?if($list_cnt>0){?>
					<!-- Pager -->
					<p class="board-pager align-c" title="페이지 이동하기">
						<?=$Page?>
					</p><!-- END Pager -->
					<?}?>
					
				</div><!-- END 주문 Wrap -->
			