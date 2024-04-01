				<!-- 제품등록 현황 -->
					
				<table class="tmp_list mt10">
					<tbody>
						<tr>
							<td>
							고객들이 결제하기 전에 정보가 임시로 저장된 주문 내역들 입니다. (최근 50건)<br>
							이 정보는 실제로 거래가 진행된 사항도 있고, 그렇지 않은 정보도 있음을 숙지하시기 바랍니다.<br>
							<button type="button" class="btn-clear btn-sm">복구</button> 버튼을 누르면 [결제대기] 상태로 주문내역 데이타에 등록됩니다.<br>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="adm-table line align-c mt40">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col><col style="width:160px;"><col><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th>주문번호</th>
							<th>주문자이름</th>
							<th>주문제품</th>
							<th>주문일시</th>
							<th>금액</th>
							<th>상세보기</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<? 
						foreach($list as $lt){
							$row = decode($lt->data);
							$trade_method_name = $shop_info['trade_method'.$row['trade_method']];
							if($lt->cnt > 0){
						?>
						<tr>
							<td><?=$lt->trade_code?></td>
							<td><?=$row['name']?></td>
							<td class="pr0"><?=$lt->goods_name?><? if($lt->cnt > 1){?> 외 <?=$lt->cnt-1?>건<?}?></td>
							<td><?=substr($row['trade_day'],0,10)?></td>
							<td><?=number_format($row['price'])?></td>
							<td>
								<input type="button" value="상세보기" class="btn-sm" onclick="view(<?=$lt->idx?>)">
							</td>
						</tr>
						<tr class="viewOn" id="view<?=$lt->idx?>" style="display:none;">
							<td colspan="6" class="align-l" >
							 <em>주문/배송정보</em>
								<table class="tmp_view">
								<colgroup>
									<col style="width:100px;"><col style="width:160px;"><col style="width:100px;"><col style="width:160px;"><col style="width:100px;"><col style="width:160px;">
								</colgroup>
									<tbody>
										<tr>
											<th>주문번호</th>
											<td><?=$lt->trade_code?></td>
											<th>주문접수일</th>
											<td><?=$row['trade_day']?></td>
											<th>주문자 이름</th>
											<td><?=$row['name']?></td>
										</tr>
										<tr>
											<th>주문자 아이디</th>
											<td><? echo $row['userid'] ? $row['userid'] : "비회원";?></td>
											<th>주문자 핸드폰</th>
											<td><?=$row['phone']?></td>
											<th>주문자 이메일</th>
											<td><?=$row['email']?></td>
										</tr>
										<tr>
											<th>수령인</th>
											<td><?=$row['send_name']?></td>
											<th>수령인 핸드폰</th>
											<td><?=$row['send_phone']?></td>
											<th>수령인 전호번호</th>
											<td><?=$row['send_tel']?></td>
										</tr>
										<tr>
											<th>수령인 주소</th>
											<td>(<?=$row['zip1']?>) <?=$row['addr1']?></td>
											<th>주소상세</th>
											<td><?=$row['addr2']?></td>
											<th>요청사항</th>
											<td><?=$row['send_text']?></td>
										</tr>
									</tbody>
								</table>
								<br>
							 <em>상품/결재정보</em>
								<table class="tmp_view mb20">
								<colgroup>
									<col style="width:100px;"><col style="width:160px;"><col style="width:100px;"><col style="width:160px;"><col style="width:100px;"><col style="width:160px;">
								</colgroup>
									<tbody>
										<tr>
											<th>상품</th>
											<td>
											<? 
											$i=0;
											foreach($cart_list[$lt->idx] as $cart){
												$i++;
											?>
												<?if($i>1){?>/ <?}?><?=$cart->goods_name?>
											<?}?>
											</td>
											<th>결제수단</th>
											<td><?=$trade_method_name?></td>
											<th>결제정보</th>
											<td>
											<?
												switch($row['trade_method'])
												{
													case 2 : echo $row['enter_bank']." ".$row['enter_account']." (".$row['enter_info'].") 입금자명 : ".$row['enter_name']; break;
													case 4 : echo $row['enter_bank']." ".$row['enter_account']." (".$row['enter_info'].")"; break;
													default : echo "미등록"; break;
												}
											?>
											</td>
										</tr>
										<tr>
											<th>총 결제금액</th>
											<td><?=number_format($row['price'])?>원</td>
											<th>할인정보</th>
											<td>
											<?if($row['userid']){?>
												<?if($row['use_point']>0){?>포인트 : -<?=number_format($row['use_point'])?>P<?}?>
												<?if(isset($row['coupon_idx']) && $row['use_coupon']>0){?><br>쿠폰 : -<?=number_format($row['use_coupon'])?>원<?}?>
											<?}else{?>비회원<?}?>
											</td>
											<th>적립포인트</th>
											<td><?if($row['userid']){?><?if($row['save_point']>0){?><?=number_format($row['save_point'])?>P<?}else{ echo "0P";} }else{?>비회원<?}?></td>
										</tr>
										<tr>
											<th>상품금액</th>
											<td><?=number_format($row['goods_price'])?>원</td>
											<th>배송비</th>
											<td><?=number_format($row['delivery_price'])?>원</td>
											<th>실결제금액</th>
											<td><?=number_format($row['total_price'])?></td>
										</tr>
									</tbody>
								</table>
								<p class="align-c mb15">주문번호 : <input type="text" name="trade_code<?=$lt->idx?>" id="trade_code<?=$lt->idx?>" class="width-m" value="<?=$lt->trade_code?>" maxlength="15"> <button type="button" class="btn-clear" onclick="trade_ok(<?=$lt->idx?>,'<?=$lt->trade_code?>')">복구하기</button></p>			
							</td>
						</tr>
						<?
							}
						}?>
					</tbody>
				</table>


				<script>
				function view(num)
				{
					$("#view"+num).toggle();
				}

				function trade_ok(idx,trade_code)
				{

					var code = $("#trade_code"+idx).val();
					if(confirm("주문번호 : "+code+"\n복구하시겠습니까?\n데이터는 무조건 [입금대기] 상태로만 등록됩니다.")){
						document.tradeFrm.change_trade_code.value = code;
						document.tradeFrm.trade_code.value = trade_code;
						document.tradeFrm.submit();
					}
				}
				
				</script>

				<form name="tradeFrm" method="post">
				<input type="hidden" name="change_trade_code">
				<input type="hidden" name="trade_code">
				</form>