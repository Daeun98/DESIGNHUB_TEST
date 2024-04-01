
				<!-- 제품리스트 -->
				<h3 class="icon-check">주문 기본정보</h3>

				<table class="adm-table v-line align-c">
					<caption>주문 기본정보</caption>
					<tbody>
						<tr>
							<th>주문번호</th>
							<td><? if($trade_stat->mobile==1){?><img src="/_data/image/m.png" style="vertical-align:middle;"> <?}?><?=$trade_stat->trade_code?></td>
							<th>주문접수일</th>
							<td><?=substr($trade_stat->trade_day,0,10)?></td>
						</tr>
						<tr>
							<th>회원아이디</th>
							<td><? echo $trade_stat->userid ? $trade_stat->userid : "비회원"; ?></td>
							<th>거래상태</th>
							<td><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></td>
						</tr>
					</tbody>
				</table>


				<h3 class="icon-list mt60">주문 내역</h3>
				<table class="adm-table v-line align-c">
					<caption>주문 상품 내역</caption>
					<thead>
						<tr>
							<th class="col-wide">제품명</th>
							<th>옵션</th>
							<th class="col-df">단가</th>
							<th class="col-df">수량</th>
							<th class="col-df">소계</th>
						</tr>
					</thead>
					<tbody>
						<? foreach($goods_list as $lt){
							$flag = 0;
							$flag1=0;

							if($lt->option_cnt>0){
								$option_cnt = count(${'option_arr'.$lt->idx});
								$price = explode("-",${'option_arr'.$lt->idx}[0]['price']);
								$plus="";
								$price = ${'option_arr'.$lt->idx}[0]['price'];
								if(count($price)<2){ $plus="+"; }
								$cnt = ${'option_arr'.$lt->idx}[0]['cnt'];
								$flag = ${'option_arr'.$lt->idx}[0]['flag'];
								$flag1 = ${'option_arr'.$lt->idx}[0]['flag'];
							}

							if(empty($price)){ $price = 0; }
							if(empty($cnt)){ $cnt = 1; }
						?>
						<tr>
							<th <?if($lt->option_cnt>0){?>rowspan="<?=$option_cnt?>"<?}?>><?=$lt->goods_name?></td>
							<td class="align-l">
							<?if($lt->option_cnt>0){?>							
								<em><?= ${'option_arr'.$lt->idx}[0]['title']?></em> : <?=${'option_arr'.$lt->idx}[0]['name']?>
								<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
								<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
							<?}?></td>
							<td <? if($flag1==1){?>rowspan="<?=$option_cnt?>"<?}?>><?=number_format($lt->goods_price)?>원</td>
							<td <? if($flag1==1){?>rowspan="<?=$option_cnt?>"<?}?>><? if($lt->goods_cnt){ echo number_format($lt->goods_cnt); }?></td>
							<td <? if($flag1==1){?>rowspan="<?=$option_cnt?>"<?}?>><?=number_format($lt->total_price)?>원</td>
						</tr>
						<?
							if($lt->option_cnt>0){
							for($i=1;$i<count(${'option_arr'.$lt->idx});$i++){					
								$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
								$plus="";
								if(count($price)<2){ $plus="+"; }
								$title = ${'option_arr'.$lt->idx}[$i]['title'];
								$name = ${'option_arr'.$lt->idx}[$i]['name'];
								$price = ${'option_arr'.$lt->idx}[$i]['price'];
								$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
								$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
						?>						
						<tr>
							<td class="align-l">
								<em><?=$title?></em> : <?=$name?>
								<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
								<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
							</td>
							<? if($flag1==0){?><td><?=number_format($lt->goods_price)?>원</td><?}?>
							<? if($flag1==0){?><td><? if($lt->goods_cnt){ echo number_format($lt->goods_cnt); }?></td><?}?>
							<? if($flag1==0){?><td><?=number_format($lt->total_price)?>원</td><?}?>
						</tr>
						<?}
						}
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<th>총 구매금액</th>
							<td></td>
							<td><strong class="dh_red"><?=number_format($trade_stat->goods_price)?>원</strong></td>
						</tr>
					</tfoot>
				</table>

				<table class="adm-table v-line mt30">
					<caption>주문내역 요약</caption>
					<tbody>
						<tr>
							<th class="col-wide">총 구매금액</th>
							<td><strong><?=number_format($trade_stat->goods_price)?>원</strong></td>
							<th class="col-df">배송비</th>
							<td class="col-twice"><?=number_format($trade_stat->delivery_price)?>원</td>
						</tr>
						<tr>
							<th>사용포인트</th>
							<td><?if($trade_stat->userid){?>-<?=number_format($trade_stat->use_point)?> P<?}else{?>비회원<?}?></td>
							<th>적립예정포인트</th>
							<td><?if($trade_stat->userid){?><?=number_format($trade_stat->save_point)?> P<?}else{?>비회원<?}?></td>
						</tr>
						<tr>
							<th>사용쿠폰</th>
							<td colspan="3"><?if($trade_stat->userid){?><? if(isset($coupon_stat->idx) && $trade_stat->use_coupon>0){?>-<?=number_format($trade_stat->use_coupon)?>원<?}?>
							<? if(isset($coupon_stat->idx)){?> [ <?=$coupon_stat->name?> ]<?}?>
							<?}else{?>비회원<?}?></td>
						</tr>
						<tr>
							<th>총 결제금액</th>
							<td colspan="3"><strong class="dh_red"><?=number_format($trade_stat->total_price)?>원</strong></td>
						</tr>
					</tbody>
				</table>

				<h3 class="icon-pen mt60">주문고객 정보</h3>
				<table class="adm-table v-line">
					<caption>주문고객 정보</caption>
					<thead>
						<tr>
							<th class="col-df"><label for="oc-name">고객명</label></th>
							<td><?=$trade_stat->name?></td>
							<th class="col-df"><label for="oc-email">이메일</label></th>
							<td><?=$trade_stat->email?></td>
						</tr>
						<tr>
							<th><label for="oc-phone">휴대폰</label></th>
							<td colspan="3"><?=$trade_stat->phone?></td>
						</tr>
					</thead>
				</table>


				<h3 class="icon-pen mt60">배송지 정보</h3>

				<form method="post" name="trade_edit">
				<input type="hidden" name="edit" value="1">

				<table class="adm-table v-line">
					<caption>배송지 정보</caption>
					<tbody>
						<tr>
							<th class="col-df"><label for="rc-name">받으시는 분</label></th>
							<td colspan="3"><input type="text" name="send_name" value="<?=$trade_stat->send_name?>"></td>
						</tr>
						<tr>
							<th><label for="rc-addr">주소</label></th>
							<td colspan="3">
								<input type="text" class="width-xs2 mr10" name="zip1" value="<?=$trade_stat->zip1?>" maxlength="6">/
								<input type="text" class="width-l ml10" name="addr1" value="<?=$trade_stat->addr1?>">
								<input type="text" class="width-l" id="rc-addr" name="addr2" value="<?=$trade_stat->addr2?>">
							</td>
						</tr>
						<tr>
							<th><label for="rc-phone">휴대폰</label></th>
							<td><input type="text" name="send_phone" value="<?=$trade_stat->send_phone?>"></td>
							<th class="col-df"><label for="rc-tel">전화번호</label></th>
							<td style="min-width:70px;"><input type="text" name="send_tel" value="<?=$trade_stat->send_tel?>"></td>
						</tr>
						<tr>
							<th><label for="rc-cmt">배송시 요청사항</label></th>
							<td colspan="3"><textarea cols="30" rows="3" id="rc-cmt" name="send_text"><?=$trade_stat->send_text?></textarea></td>
						</tr>
						<tr>
							<th><label for="dv-num" class="dh_red">운송장번호</label></th>
							<td colspan="3"><?=$trade_stat->delivery_no?> <? if($trade_stat->delivery_no){ echo "(".$shop_info['delivery_idx'.$trade_stat->delivery_idx].")";?> <button type="button" class="cart-btn3 ml10" onclick="window.open('<?=$shop_info['delivery_url'.$trade_stat->delivery_idx]?>','','')">배송조희</button><?}?>
							<!-- <input type="text" id="dv-num"> -->
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="mt60">결제 정보</h3>
				<table class="adm-table v-line">
					<caption>결제 정보</caption>
					<tbody>
						<tr>
							<th class="col-df">결제 방법</th>
							<td><?=$shop_info['trade_method'.$trade_stat->trade_method]?></td>
							<th class="col-df">결제 확인일</th>
							<td><?=substr($trade_stat->trade_day_ok,0,10)?></td>
						</tr>
						<tr>
							<th class="col-df">상품 발송일</th>
							<td colspan="3"><?=substr($trade_stat->delivery_day,0,10)?></td>
						</tr>
					</tbody>
				</table>				

					<? if($trade_stat->trade_method==2){ ?>

					<!-- 무통장 입금일 경우에만 노출 -->
					<h3 class="mt60">무통장 입금 정보</h3>
					<table class="adm-table v-line">
						<caption>무통장 입금 정보</caption>
						<tr>
							<th style="width:160px;">입금자명</th>
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
						<!-- <tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr> -->
					</table>
					<!-- END 무통장 입금일 경우에만 노출 -->

					<? }else if($trade_stat->trade_method==4){ //가상계좌?>
					<h3 class="mt60">가상계좌 정보</h3>
					<table class="adm-table v-line">
						<caption>가상계좌 입금 정보</caption>
						<tr>
							<th style="width:160px;">입금은행</th>
							<td><?=$trade_stat->enter_bank?></td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
						</tr>
						<!-- <tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>가상계좌 결제는 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>가상계좌 결제는 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr> -->
					</table>
					<?}?>
						

					<? if($trade_stat->trade_method != 1){ ?>

					<h3 class="mt60">현금영수증 정보</h3>
					<table class="adm-table v-line">
						<caption>현금영수증 정보</caption>
						<tr>
							<th style="width:160px;">종류</th>
							<td>
							<? if($trade_stat->cash_receipt==0){?>
							발급안함
							<?}else if($trade_stat->cash_receipt==1){?>
							소득 공제용
							<?}else if($trade_stat->cash_receipt==2){?>
							지출 증빙용
							<?}?>
							</td>
						</tr>
						<? if($trade_stat->cash_receipt>0){?>
						<tr>
							<th>번호</th>
							<td><?=$trade_stat->cash_number?></td>
						</tr>
						<?}?>
					</table>

					<?}?>


					<? if($trade_stat->trade_stat==5 || $trade_stat->trade_stat==6 || $trade_stat->trade_stat==7 || $trade_stat->trade_stat==8 || $trade_stat->trade_stat==10){ 					
					$trade_name = str_replace("신청","",$shop_info['trade_stat'.$trade_stat->trade_stat]);
					?>

					<h3 class="mt60"><?=$trade_name?> 신청 정보</h3>
					<table class="adm-table v-line">
						<caption><?=$trade_name?> 신청 정보</caption>
						<? if($trade_stat->return_prod){?>
						<tr>
							<th><?=$trade_name?> 요청상품 </th>
							<td><?=$trade_stat->return_prod?></td>
						</tr>
						<?}?>
						<tr>
							<th style="width:160px;"><?=$trade_name?> 요청사유</th>
							<td><?=nl2br($trade_stat->return_reason)?></td>
						</tr>
						<tr>
							<th style="width:160px;">기타 요청사항</th>
							<td><?=nl2br($trade_stat->return_etc)?></td>
						</tr>
						<tr>
							<th style="width:160px;">요청시간</th>
							<td><?=$trade_stat->trade_day_cancel_req?></td>
						</tr>
					</table>

					<?}?>

					
					<h3 class="mt60">관리자 메모</h3>
					<table class="adm-table v-line">
						<caption>관리자 메모</caption>
						<tr>
							<th style="width:160px;">관리자 메모</th>
							<td colspan="3"><textarea cols="30" rows="6" id="rc-cmt" name="memo"><?=$trade_stat->memo?></textarea></td>
						</tr>
					</table>

					</form>


				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt40">
					<div class="float-l">
						<a href="<?=cdir()?>/order/lists/<?=$trade_stat->trade_stat?>/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
						<a href="javascript:document.trade_edit.submit();" class="button btn-l">수정하기</a>
					</div>
					<div class="float-r">
						<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
						<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
						<? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?>
					</div>
				</div><!-- END 제품 액션 버튼 -->
				<!-- END 제품리스트 -->

			<script>
			function cancel()
			{
				if(confirm("주문을 취소하시겠습니까?")){
					card_cancel("<?=$trade_stat->trade_code?>","<?=$trade_stat->tno?>");
				}
			}			
			</script>

<? 
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>
