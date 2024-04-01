<? if(empty($member_total_point) || !$member_total_point){ $member_total_point = 0; } ?>
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 상단 step -->
				<div class="shop-order-step">
					<span class="so-step so-step1">장바구니</span>
					<span class="so-arr"></span>
					<h2><span class="so-step so-step2 on">주문결제</span></h2>
					<span class="so-arr"></span>
					<span class="so-step so-step3">주문완료</span>
				</div><!-- END 상단 step -->


				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<h3 class="order-tit">주문리스트 확인</h3>

					<table class="shop-cart">
						<caption>주문 상품 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<?if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?>
							</tr>
						</thead>
						<tbody>
							<?
								$frmCnt=0;
								$real_price=0;
								$real_save_point=0;
								$real_cnt=0;
								foreach($cart_list as $lt){
								$frmCnt++;
									if($lt->goods_real_point > 0){
										$real_cnt++;
										$real_price += $lt->total_price;
										$real_save_point += $lt->goods_point;
									}
							?>
							<tr>
								<td><?=$lt->goods_code?></td>
								<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><?=$lt->goods_name?></p>
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
										?>
											<p class="prod-op">
											<em><?=$title?></em> : <?=$name?>
											<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
											<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
											</p>
										<?
											}
										}?>
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
								<td><? echo $lt->goods_cnt>0 ? $lt->goods_cnt : ""; ?></td>
								<td><?=number_format($lt->total_price)?>원</td>
								<?if($this->session->userdata('USERID')){?><td><!-- 회원구매시<br> --><?=number_format($lt->goods_point)?></td><?}?>
							</tr>
						<?}?>
						</tbody>
					</table>

					<!-- 총 주문금액 -->
					<div class="order-total-box">
						<div class="each-price-box">
							<p class="total-tit"><img src="/image/shop/total_tit.png" alt="총 주문 금액"></p>
							<ul class="each-price">
								<li><span>상품 총 금액</span>
									<em><?=number_format($totalPrice)?>원</em>
								</li>
								<li><span>배송비</span>
									<em><?=number_format($delivery_price)?>원</em>
								</li>
							</ul>
						</div>
						<div class="total-price">
							<? if(isset($member_stat->userid)){?>	<span class="acc-p">( 적립예정 포인트 : <?=number_format($totalPoint)?>P )</span><?}?>
							총 주문 금액 <span class="tt-price"><em><?=number_format($totalPrice+$delivery_price)?></em> 원</span>
						</div>
					</div><!-- END 총 주문금액 -->


					<!-- 주문고객 정보 -->
					<h3 class="order-tit">주문고객 정보</h3>
					<form name="order_form" id="order_form" method="post" >
					<input type="hidden" name="userid" value="<? echo isset($member_stat->userid) ? $member_stat->userid : ""; ?>">
					<input type="hidden" name="price" id="price" value="<?=$totalPrice+$delivery_price?>">
					<input type="hidden" name="total_price" id="total_price" value="<?=$totalPrice+$delivery_price?>">
					<input type="hidden" name="goods_price" id="goods_price" value="<?=$totalPrice?>">
					<input type="hidden" name="delivery_price" id="delivery_price" value="<?=$delivery_price?>">
					<input type="hidden" name="point" id="point" value="0">
					<input type="hidden" name="use_coupon" id="use_coupon" value="0">
					<input type="hidden" name="save_point" id="save_point" value="<? echo isset($member_stat->userid) ? $totalPoint : "0"; ?>">
					<input type="hidden" name="trade_code" id="trade_code" value="<?=$TRADE_CODE?>">
					<input type="hidden" name="tmp" id="tmp" value="1">
					<input type="hidden" name="cart_code" value="<?=$cart_code?>">


					<table class="order-field">
						<caption>주문고객 정보</caption>
						<tbody>
							<tr>
								<th><label for="ou-name">주문고객명</label></th>
								<td><input type="text" id="ou-name" name="name" value="<? echo isset($member_stat->name) ? $member_stat->name : ""; ?>" msg="주문고객명을"></td>
							</tr>
							<?
								if(isset($member_stat->email)){
									$email = explode("@",$member_stat->email);
								}
							?>
							<tr>
								<th><label for="ou-email">이메일</label></th>
								<td><input type="text" id="ou-email" name="email1" value="<? echo isset($email[0]) ? $email[0] : ""; ?>" msg="이메일을"> @
									<input type="text" name="email2" id="email2" value="<? echo isset($email[1]) ? $email[1] : ""; ?>" msg="이메일을">
									<select onchange="res(this.value);">
										<option value="">직접입력</option>
										<option value="naver.com">naver.com</option>
										<option value="gmail.com">gmail.com</option>
										<option value="daum.net">daum.net</option>
										<option value="hanmail.net">hanmail.net</option>
										<option value="nate.com">nate.com</option>
										<option value="empal.com">empal.com</option>
									</select>
									<small class="ml10">주문정보를 이메일로 발송해드립니다.</small>
								</td>
							</tr>
							<tr>
								<th><label for="ou-phone">휴대폰</label></th>
								<td><input type="text" class="field-xs" id="ou-phone" name="phone1" value="<? echo isset($member_stat->phone1) ? $member_stat->phone1 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4"> - <input type="text" class="field-xs" name="phone2" value="<? echo isset($member_stat->phone2) ? $member_stat->phone2 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4"> - <input type="text" class="field-xs" name="phone3" value="<? echo isset($member_stat->phone3) ? $member_stat->phone3 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4">
									<!-- <small class="ml10">주문정보를 SMS로 발송해드립니다.</small> -->
								</td>
							</tr>
						</tbody>
					</table>
					<!-- END 주문고객 정보 -->

					<!-- 배송지 정보 -->
					<h3 class="order-tit">배송지 정보</h3>
					<table class="order-field">
						<caption>배송지 정보</caption>
						<tbody>
							<tr>
								<th>배송지 선택</th>
								<td>
									<input type="radio" id="info-same" name="info-same" onclick="infoComp(1)"><label for="info-same">주문고객 정보와 동일</label>
									<input type="radio" id="info-new" name="info-same" onclick="infoComp(2)"><label for="info-new">새로운 주소</label>
								</td>
							</tr>
							<tr>
								<th>도서산간지역 설정</th>
								<td><input type="checkbox" name="local_far" id="local_far" value="1">
									<small class="ml5"><label for="local_far">섬지방 또는 제주도 배송시에 체크해 주십시오. </label></small>
								</td>
							</tr>
							<tr>
								<th><label for="du-name">받으시는 분</label></th>
								<td><input type="text" id="du-name" name="send_name" msg="받으시는분을"></td>
							</tr>
							<tr>
								<th>주소</th>
								<td>
									<p><label for="zipcode1" class="label-out">우편번호</label><input type="text" class="field-s mr5" name="zip1" id="zipcode1" readonly msg="우편번호를"><button type="button" class="btn-border-s" onclick="javascript:sample6_execDaumPostcode();">우편번호찾기</button></p>
									<p class="mt5">
										<input type="text" class="field-l" id="address1" name="addr1" readonly msg="주소를">
										<label for="address2" class="label-out">상세주소</label>
										<input type="text" class="field-l" id="address2" name="addr2" msg="상세주소를">
									</p>
								</td>
							</tr>
							<tr>
								<th><label for="du-phone">휴대폰</label></th>
								<td><input type="text" class="field-xs" id="du-phone" name="send_phone1" maxlength="4" msg="받으시는분의 휴대폰번호를"> - <input type="text" class="field-xs" name="send_phone2" maxlength="4" msg="받으시는분의 휴대폰번호를"> - <input type="text" class="field-xs" name="send_phone3" maxlength="4" msg="받으시는분의 휴대폰번호를"></td>
							</tr>
							<tr>
								<th><label for="du-tel">전화번호</label></th>
								<td><input type="text" class="field-xs" id="du-tel" name="send_tel1" maxlength="4"> - <input type="text" class="field-xs" name="send_tel2" maxlength="4"> - <input type="text" class="field-xs" name="send_tel3" maxlength="4"></td>
							</tr>
							<tr>
								<th><label for="du-msg">배송시 요청사항</label></th>
								<td><div class="deliv-msg">
										<input type="text" class="field-xl" id="du-msg" name="send_text">
										<ul class="deliv-msg-ex">
											<li>부재시 경비실에 맡겨주세요.</li>
											<li>배송 전 연락바랍니다.</li>
											<li>파손 위험이 있는 상품이니 조심히 다뤄주세요.</li>
											<li>경비실에 맡겨주세요.</li>
											<li>택배함에 넣어주세요.</li>
											<li>부재시 핸드폰으로 연락바랍니다.</li>
										</ul>
									</div>
									<small class="ml5">사전에 협의되지 않은 지정일 배송은 불가능합니다.</small>
								</td>
							</tr>
							</tbody>
						</table>

						<script type="text/javascript">
						jQuery(document).ready(function($){
							//배송시 요청사항
							$("#du-msg").on("click focusin", function(){
								$(".deliv-msg-ex").height("auto");
							}).keyup(function(){
								if ($(this).val()=="") $(".deliv-msg-ex").height("auto");
							}).on("focusout", function(){
								setTimeout(function(){$(".deliv-msg-ex").height(0);},200);
							});

							$(".deliv-msg-ex li").on("click", function(e){
								$("#du-msg").val($(this).text()).focus();
								$(".deliv-msg-ex").height(0);
								return false;
							});
						});
						</script>

					<!-- END 배송지 정보 -->


					<? if(isset($member_stat->userid)){?>
					<!-- 할인/결제 -->
					<div class="order-price-wrap">
						<!-- 좌 -->
						<div class="order-price-left">
							<!-- 할인/결제금액 정보 -->
							<h3 class="order-tit">할인 정보</h3>
							<table class="order-field discount-tbl mb15"><!-- 할인/결제 유의사항이 없을 경우 mb15 삭제 -->
								<caption>할인 정보</caption>
								<tbody>
									<tr>
										<th>할인종류 선택</th>
										<td><input type="radio" name="discount_type" id="coupon-no" checked value="">
											<label for="coupon-no">사용 안함</label>
											<input type="radio" name="discount_type" id="coupon-type1" value="coupon">
											<label for="coupon-type1">쿠폰</label>
											<input type="radio" name="discount_type" id="coupon-type2" value="point">
											<label for="coupon-type2">포인트</label>
										</td>
									</tr>
									<tr class="coupon_block" style="display:none;">
										<th>쿠폰 선택</th>
										<td>
											<select name="coupon_idx" id="coupon_idx" onchange="coupon_select(this.value);">
												<option value="">쿠폰을 선택해주세요.</option>
												<? foreach($couponList as $coupon){?>
												<option value="<?=$coupon->idx?>">
													<?=$coupon->name?>(-
													<? if($coupon->type==3){
														echo number_format($delivery_price)."원";
													}else{
														if($coupon->discount_flag==1){
															echo $coupon->price."%";
														}else{
															echo number_format($coupon->price)."원";
														}
													}?>) [~ <?=$coupon->end_date?>]
												</option>
												<?}?>
											</select>
											<small class="ml15 bl-noti">사용 가능 쿠폰 : <strong class="em"><?=number_format($couponCnt)?>장</strong></small>
										</td>
									</tr>
									<tr class="point_block" style="display:none;">
										<th><label for="use_point">포인트 사용</label></th>
										<td><input type="text" value="" id="use_point" class="field-s" maxlength="9" > P
											<small class="ml10"><button type="button" class="btn-border-s" onclick="pointChange()">적용</button></small>
											<small class="ml15 bl-noti">보유포인트 : <strong class="em"><?=number_format($member_total_point)?> P</strong></small>
										</td>
									</tr>
								</tbody>
							</table>

							<ul class="order-noti mb50">
								<li>고객님께서 적립될 예정 포인트는 <?=number_format($totalPoint)?> P 입니다. </li>
								<li>단, 포인트 사용시에는 적립 포인트의 변동이 있을 수 있습니다.</li>
								<li>포인트 사용 한도는 총 구매액의 <?=$shop_info['point_percent']?> % 까지 입니다.</li>
								<li>포인트는 <?=number_format($shop_info['point_use'])?> P 이상 보유하셔야만 사용 가능합니다.</li>
								<li>기타 궁금하신 사항은 고객센터에 문의하여 주십시오.</li>
							</ul>
							<!-- END 할인/결제금액 정보 -->
						</div><!-- END 좌 -->

						<!-- 우 -->
						<div class="order-price-right">
							<!-- 결제금액 -->
							<h3 class="order-tit em">결제 금액</h3>
							<div class="pay-total-box">
								<ul class="each-price">
									<li><span>상품 총 금액</span>
										<em><?=number_format($totalPrice)?>원</em>
									</li>
									<li><span>배송비</span>
										<em class="delivery_price_txt"><?=number_format($delivery_price)?>원</em>
									</li>
									<li style="display:none;" class="use_coupon"><span>쿠폰할인</span>
										<em class="em">0원</em>
									</li>
									<li style="display:none;"class="use_point"><span>적립금 사용</span>
										<em class="em point_use">0P</em>
									</li>
								</ul>
								<div class="total-price">
									총 결제 금액 <span class="tt-price"><em class="total_price"><?=number_format($totalPrice+$delivery_price)?></em> 원</span>
								</div>
							</div>
							<!-- END 결제금액 -->

						</div><!-- END 우 -->
					</div><!-- END 할인/결제 -->
					<?}else{?>


					<!-- 총 주문금액 -->
					<div class="order-total-box">
						<div class="each-price-box">
							<p class="total-tit"><img src="/image/shop/pay_tit.png" alt="총 주문 금액"></p>
							<ul class="each-price">
								<li><span>상품 총 금액</span>
									<em><?=number_format($totalPrice)?>원</em>
								</li>
								<li><span>배송비</span>
									<em class="delivery_price_txt"><?=number_format($delivery_price)?>원</em>
								</li>
							</ul>
						</div>
						<div class="total-price">
							총 주문 금액 <span class="tt-price"><em><?=number_format($totalPrice+$delivery_price)?></em> 원</span>
						</div>
					</div><!-- END 총 주문금액 -->

					<?}?>



					<h3 class="order-tit pay_info">결제 수단</h3>
					<table class="order-field mb0 pay_info">
						<caption>결제 수단 선택</caption>
						<tr>
							<th>결제 수단 선택</th>
							<td>
								<input type="radio" name="trade_method" id="pay-way-card" checked value="1"><label for="pay-way-card">신용카드</label>
								<input type="radio" name="trade_method" id="pay-way-deposit" value="2"><label for="pay-way-deposit">무통장 입금</label>
								<input type="radio" name="trade_method" id="pay-way-transf" value="3"><label for="pay-way-transf">실시간 계좌이체</label>
								<input type="radio" name="trade_method" id="pay-way-ig" value="4"><label for="pay-way-ig">가상계좌</label>
								<input type="checkbox" name="point_pay" id="pay-way-point" value="1" style="display:none;"><label for="pay-way-point" style="display:none;">포인트 결제</label>
							</td>
						</tr>
					</table>

					<!-- 카드결제 안내사항 -->
					<table class="order-field pay-info pay-way-card pay_info" id="pay-noti-card">
						<caption>카드결제 안내사항</caption>
						<tr>
							<td>
								<p class="mt5">신용카드 결제 시 화면 아래 [결제하기] 버튼을 클릭하시면 신용카드 결제 창이 나타납니다.</p>
								<p class="mt10">신용카드 결제 창을 통해 입력되는 고객님의 카드 정보는 안전하게 암호화되어 전송되며, 승인 처리 후 카드 정보는 승인 성공·실패 여부에 상관없이 자동으로 폐기되므로, 안전합니다.</p>
								<p class="mt10">신용카드 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</p>

								<p class="pay-info-tit mt15">유의사항</p>
								<ul class="order-noti">
									<li>신용카드/실시간 이체는 결제 후, 무통장입금은 입금확인 후 배송이 이루어집니다.</li>
									<!-- <li>국내 모든 카드 사용이 가능하며 해외에서 발행된 카드는 해외카드 3D 인증을 통해 사용 가능합니다.</li> -->
								</ul>
							</td>
							<td class="col-pay-noti card_noti">
							</td>
						</tr>
					</table>
					<!-- END 카드결제 안내사항 -->

					<!-- 무통장입금 안내사항 -->
					<table class="order-field pay-info pay-way-deposit pay_info" id="pay-noti-deposit" style="display:none;">
						<caption>무통장입금 안내사항</caption>
						<tr>
							<th>입금하실 은행</th>
							<td>
								<p>
									<input type="hidden" name="enter_info" id="enter_info">
									<input type="hidden" name="enter_account" id="enter_account">
									<select name="enter_bank" id="enter_bank">
										<option value="">입금하실 은행을 선택하세요</option>
										<? for($i=1;$i<=$bank_cnt;$i++){?>
										<option value="<?=$shop_info['bank_name'.$i]?>" account="<?=$shop_info['bank_num'.$i]?>" info="<?=$shop_info['input_name'.$i]?>"><?=$shop_info['bank_name'.$i]?></option>
										<?}?>
									</select>
									<span class="ml10 enter_info"></span>
								</p>
								<p class="mt5">계좌번호는 다음단계인 [주문완료] 페이지에서 확인하실 수 있으며 이메일로도 안내해 드립니다. 입금하실 때 송금수수료가 부과될 수 있습니다.</p>
							</td>
							<td class="col-pay-noti" rowspan="4">
								<p class="pay-info-tit">무통장입금 안내</p>
								<ul class="order-noti">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
									<li>계좌번호는 주문완료 페이지에서 확인 가능하며, 이메일로도 안내 드립니다.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th><label for="enter_name">입금자명</label></th>
							<td><input type="text" name="enter_name" id="enter_name" class="field-m"></td>
						</tr>
						<tr>
							<th rowspan="2">현금영수증</th>
							<td>
								<input type="radio" name="cash_receipt2" id="deposit-receipt-no" value="0" checked>
								<label for="deposit-receipt-no">발급안함</label>
								<input type="radio" name="cash_receipt2" id="deposit-receipt-p" value="1" >
								<label for="deposit-receipt-p">소득 공제용</label>
								<input type="radio" name="cash_receipt2" id="deposit-receipt-c" value="2" >
								<label for="deposit-receipt-c">지출 증빙용</label>
							</td>
						</tr>
						<tr style="display:none;" class="cash_receipt2">
							<td>
								<p class="pay-info-tit">휴대폰번호 / 현금영수증카드 / 사업자번호</p>
								<p><input type="text" name="cash_number2" id="cash_number2" class="field-m"> <span class="ml10">'-' 를 빼고 입력하세요.</span></p>
								<ul class="order-noti mt10">
									<li>사업자, 현금영수증카드, 휴대폰번호가 유효하지 않으면 발급되지 않습니다.</li>
									<li>2016년 7월부터 10만원 이상 무통장 거래건에 대해, 출고후 2일내에 발급하지 않으시면 출고 3일후 자진 발급 합니다. 국세청 홈텍스 사이트에서 현금영수증 자진발급분 소비자 등록 메뉴로 수정 가능합니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 무통장입금 안내사항 -->

					<!-- 실시간 계좌이체 안내사항 -->
					<table class="order-field pay-info pay-way-transf pay_info" id="pay-noti-transf" style="display:none;">
						<caption>실시간 계좌이체 안내사항</caption>
						<tr>
							<td colspan="2">
								<p class="mt5">실시간 이체 결제 시 화면 아래 '결제하기'버튼을 클릭하시면 실시간 이체 결제 창이 나타납니다.</p>
								<p class="mt10">실시간 이체 결제 창을 통해 입력되는 고객님의 정보는 안전하게 암호화되어 전송되며 승인 처리 후 정보는 승인 성공/실패 여부에 상관없이 자동으로 폐기됩니다.</p>
								<p class="mt10">실시간 이체 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</p>
							</td>
							<td class="col-pay-noti" rowspan="3">
								<p class="pay-info-tit">실시간 계좌이체 안내</p>
								<ul class="order-noti">
									<li>실시간 계좌 이체 서비스는 은행계좌만 있으면 누구나 이용하실 수 있는 서비스로, 별도의 신청 없이 그 대금을 자신의 거래은행의 계좌로부터 바로 지불하는 서비스입니다.</li>
									<li>결제 시 공인인증서가 반드시 필요합니다.</li>
									<li>결제 후 1시간 이내에 확인되며, 입금 확인 후 배송이 이루어 집니다.</li>
									<li>은행 이용가능 서비스 시간은 은행사정에 따라 다소 변동될 수 있습니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 실시간 계좌이체 안내사항 -->

					<!-- 가상계좌 안내사항 -->
					<table class="order-field pay-info pay-way-ig pay_info" id="pay-noti-ig" style="display:none;">
						<caption>가상계좌 안내사항</caption>
						<tr>
							<td colspan="2">
								<p class="mt5">가상계좌 결제 시 화면 아래 '결제하기'버튼을 클릭하시면 가상계좌 결제 창이 나타납니다.</p>
								<p class="mt10">가상계좌 결제 창을 통해 입력되는 고객님의 정보는 안전하게 암호화되어 전송되며 승인 처리 후 정보는 승인 성공/실패 여부에 상관없이 자동으로 폐기됩니다.</p>
								<p class="mt10">가상계좌 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</p>
							</td>
							<td class="col-pay-noti" rowspan="3">
								<p class="pay-info-tit">가상계좌 안내</p>
								<ul class="order-noti">
									<li>가상계좌 결제는 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>가상계좌 결제는 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
									<li>계좌번호는 주문완료 페이지에서 확인 가능하며, 이메일로도 안내 드립니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 가상계좌 안내사항 -->

				</div><!-- END 주문 Wrap -->


				<!-- 하단 버튼 -->
				<div class="align-c mt15">
					<button type="button" class="btn-emp-border" >이전 페이지로</button>
					<button type="button" class="btn-emp send_order" name="writeBtn">결제하기</button>

					</form>
				</div><!-- END 하단 버튼 -->

                    <!-- Payplus Plug-in 설치 안내 -->
                    <div id="display_setup_message" style="display:none" class="align-c mt30">
                       <p class="txt">
                       결제를 계속 하시려면 상단의 노란색 표시줄을 클릭 하시거나 <a href="http://pay.kcp.co.kr/plugin_new/file/KCPUXWizard.exe"><span>[수동설치]</span></a>를 눌러
                       Payplus Plug-in을 설치하시기 바랍니다.
                       [수동설치]를 눌러 설치하신 경우 새로고침(F5)키를 눌러 진행하시기 바랍니다.
                       </p>
                     </div>

			</div><!-- END Shop Wrap -->


<script>

	$(function(){
		$("input[name='cash_receipt2']").change(function(){
			if(this.checked){
				if(this.value == 0){
					$(".cash_receipt2").hide();
				}else{
					$(".cash_receipt2").show();
				}
			}
		});
	});


	function infoComp(num)
	{
		var form = document.order_form;
		if(num==1){
			form.send_name.value = form.name.value;
			form.send_phone1.value = form.phone1.value;
			form.send_phone2.value = form.phone2.value;
			form.send_phone3.value = form.phone3.value;

			<? if(isset($member_stat->zip1)){?>
			form.zip1.value = "<?=$member_stat->zip1?>";
			form.addr1.value = "<?=$member_stat->add1?>";
			form.addr2.value = "<?=$member_stat->add2?>";
			form.send_tel1.value = "<?=$member_stat->tel1?>";
			form.send_tel2.value = "<?=$member_stat->tel2?>";
			form.send_tel3.value = "<?=$member_stat->tel3?>";
			<?}?>
		}else{
			form.send_name.value = "";
			form.send_phone1.value = "";
			form.send_phone2.value = "";
			form.send_phone3.value = "";
			form.send_tel1.value = "";
			form.send_tel2.value = "";
			form.send_tel3.value = "";
			form.zip1.value = "";
			form.addr1.value = "";
			form.addr2.value = "";
		}
	}

	<? if(isset($member_stat->idx)){ ?>

	function pointChange() //포인트 정책 적용
	{
		if($("#use_point").val()==""){
			alert("포인트를 입력해주세요.");
			$("#use_point").focus();
			return;
		}else if(isNaN($("#use_point").val())){
			alert("포인트는 숫자로만 입력해주세요.");
			$("#use_point").val("");
			$("#use_point").focus();
			return;
		}

		var total_price = $("#total_price").val();
		total_price = parseInt(total_price) + parseInt($("#point").val());

		var point_limit = parseInt((<?=$shop_info['point_percent']?>* total_price)/100); //포인트사용한도
		var point = <?=$member_total_point?>; //보유포인트
		var basic_point_limit = <?=$shop_info['point_use']?>; //포인트 기본 사용한도

		var use_point = $("#use_point").val();
		$("#use_point").val(use_point.replace(/[^0-9]/gi,''));

		if(use_point){

			if(use_point > point) {
				alert('적립된 포인트 보다 많이 입력 하셨습니다.');
				//$("#use_point").val('');
				$("#use_point").focus();
			}else if(use_point > point_limit) {
				alert("포인트 사용한도를 초과하였습니다.\n포인트는 총 구매액의 <?=$shop_info['point_percent']?>% 까지만 사용 가능합니다.");
				//$("#use_point").val('');
				$("#use_point").focus();
			}else if(use_point > 0 && use_point < basic_point_limit){
				alert("포인트는 "+number_format(basic_point_limit,0)+"P 부터 사용 가능합니다.");
				//$("#use_point").val('');
				$("#use_point").focus();
			}else{
				if(use_point > 0){
					total_price = parseInt(total_price) - parseInt(use_point);
					$(".use_point").show();
				}else{
					$(".use_point").hide();
				}
				$(".total_price").html(number_format(total_price,0));
				$("#total_price").val(total_price);
				$(".point_use").html("-"+number_format(use_point,0)+"P");
				$("#point").val(use_point);

				if($("#coupon_idx").val()){
					//coupon_select($("#coupon_idx").val());
				}
			}

			if(total_price==0){

				$("input[name='point_pay']").prop("checked",true);
				$(".pay_info").hide();

			}else{

				$("input[name='point_pay']").prop("checked",false);
				$(".pay_info").show();
				$(".pay-info").hide();
				$("."+$("input[name='trade_method']:checked").attr("id")).show();
			}
		}
	}

	<?}?>


	$(function(){
		$("input[name='trade_method']").on("change",function(){
			if(this.checked){
				var id = $(this).attr("id");
				$(".pay-info").hide();
				$("."+id).show();
			}
		});

		$("input[name='discount_type']").on("change",function(){
			if(this.checked){
				$("#use_point").val(0);
				coupon_select();
				setTimeout("pointChange()",150);

				if($(this).val()){
					$(".coupon_block").hide();
					$(".point_block").hide();
					$("."+$(this).val()+"_block").show();
				}else{
					$(".coupon_block").hide();
					$(".point_block").hide();
				}
			}
		});

		$(".send_order").on("click",function(){

			var point_pay = $("input[name='point_pay']:checked").length;
			var tmp = $("#tmp").val();

			if (checkForm("order_form")) {
				var trade_method = $("input[name='trade_method']:checked").val();

				if( point_pay==0 && ( trade_method==2 || trade_method==3 || trade_method==4 )){
					if(trade_method==2 && $("#enter_bank").val()==""){ // 무통장입금 && 은행선택
						alert("입금하실 은행을 선택해주세요.");
						$("#enter_bank").focus();
						return;
					}else if(trade_method==2 && $("#enter_name").val()==""){ // 무통장입금 && 입금자명
						alert("입금자명을 입력해주세요.");
						$("#enter_name").focus();
						return;
					}

					var cash_receipt = $("input[name='cash_receipt"+trade_method+"']:checked").val();
					var cash_number = $("#cash_number"+trade_method).val();
					if(cash_receipt!=0 && cash_number==""){
						alert("현금영수증 번호를 입력해주세요.");
						$("#cash_number"+trade_method).focus();
						return;

					}
				}

				if($("#point").val()!="" && $("#point").val()>0 && <?=$frmCnt?> > <?=$real_cnt?>){
					var total_price = $("#total_price").val();
					var save_point = $("#save_point").val();
					var price = parseInt(total_price)-<?=$real_price?>;

					save_point = parseInt(price)*parseInt(<?=$shop_info['point']?>)*0.01;
					save_point = save_point + <?=$real_save_point?>;
					$("#save_point").val(save_point);
				}


				$("#order_form").attr("target","tmp_frame"); //tmp에 넣기
				$("#order_form").submit();

				$("#order_form").attr("target","");
				$("#tmp").val(0);


				if(trade_method!=2 && point_pay==0){//무통장이 아닐때
					checkPay();
					$("#tmp").val(1);
				}else{
					document.order_form.writeBtn.disabled = true;
				}
			}
		});

		$("#enter_bank").on("change",function(){
				var id = "#enter_bank";
				if($(this).val()){
					var index = $(id+" option").index($("#enter_bank option:selected"));
					var account = $(id+" option:eq("+index+")").attr("account");
					var info = $(id+" option:eq("+index+")").attr("info");

					$("#enter_info").val(info);
					$("#enter_account").val(account);
				}
		});

		$("#local_far").on("change",function(){ //도서산간지역 배송비 추가
			var total_price = parseInt($("#total_price").val());
			var price = parseInt($("#price").val());
			var limit_price = parseInt("<?=$shop_info['express_free']?>");
			var express_money = "<?=$shop_info['express_money']?>";
			var express_money2 = "<?=$shop_info['express_money2']?>";
			var delivery_price = 0;

			if(!limit_price){ limit_price = 0; }
			if(!express_money){ express_money = 0; } //일반배송비
			if(!express_money2){ express_money2 = 0; } //도서산간지역배송비

			if(price < limit_price){
				if(this.checked){
					total_price = parseInt(total_price) - parseInt(express_money);
					total_price = parseInt(total_price) + parseInt(express_money2);
					delivery_price = express_money2;
				}else{
					total_price = parseInt(total_price) - parseInt(express_money2);
					total_price = parseInt(total_price) + parseInt(express_money);
					delivery_price = express_money;
				}

				$(".total_price").html(number_format(total_price,0));
				$("#total_price").val(total_price);
				$(".delivery_price_txt").html(number_format(delivery_price,0)+"원");
				$("#delivery_price").val(delivery_price);
			}


		});
	});


	function form_submit(){
		$("#order_form").submit();
	}


	function coupon_select(idx)
	{
		var total_price = $("#total_price").val();
		var delivery_price = $("#delivery_price").val();
		var use_coupon = $("#use_coupon").val();

		total_price = parseInt(total_price)+parseInt(use_coupon);

		if(idx){

			$.ajax({
					url: "<?=cdir()?>/dh_order/coupon/",
					data: {ajax: 1, coupon_idx: idx},
					async: true,
					cache: false,
					error: function(xhr){	},
					success: function(data){

						data = data.split("/");
						var type = data[0];
						var discount_flag = data[1];
						var price = data[2];

						if(price > total_price){
							price = total_price;
						}

						if(type == 3){ //무료배송쿠폰이면

							total_price = parseInt(total_price)-parseInt(delivery_price);
							use_coupon = delivery_price;

						}else{

							if(discount_flag==1){ //할인율이면
								price = total_price * 0.01 * price;
							}

							total_price = parseInt(total_price)-parseInt(price);
							use_coupon = price;
						}

						$(".total_price").html(number_format(total_price,0));
						$("#total_price").val(total_price);
						$("#use_coupon").val(use_coupon);
						$(".use_coupon em").html("-"+number_format(use_coupon,0)+"원");
						$(".use_coupon").show();



						if(total_price==0){

							$("input[name='point_pay']").prop("checked",true);
							$(".pay_info").hide();

						}else{

							$("input[name='point_pay']").prop("checked",false);
							$(".pay_info").show();
							$(".pay-info").hide();
							$("."+$("input[name='trade_method']:checked").attr("id")).show();
						}

					}
			});

		}else{

			$(".use_coupon").hide();
			$("#use_coupon").val(0);
			$(".total_price").html(number_format(total_price,0));
			$("#total_price").val(total_price);
			$("#coupon_idx option:eq(0)").attr("selected", "selected");

		}
	}

</script>
<iframe name="tmp_frame" border=0 frameborder=0 width=0 height=0 style="display:none;"></iframe>

<? include $payView.".php"; ?>
