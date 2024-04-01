<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_list";
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/header.php");
?>

	<!--Container-->
	<div id="container">
		<?	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/left_side.php"); ?>

		<!-- Content -->
		<div id="content">
			<!-- inner -->
			<div class="inner adm-wrap">
				<div class="adm-title">
					<h2>주문상세보기</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 주문관리 &gt; 주문상세보기</p>
				</div>

				<!-- 제품리스트 -->
				<h3 class="icon-check">주문 기본정보</h3>

				<table class="adm-table v-line align-c">
					<caption>주문 기본정보</caption>
					<tbody>
						<tr>
							<th>주문번호</th>
							<td>123456789</td>
							<th>주문접수일</th>
							<td>2016-08-22</td>
						</tr>
						<tr>
							<th>회원아이디</th>
							<td>test</td>
							<th>거래상태</th>
							<td>결제대기중</td>
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
						<tr>
							<th rowspan="3">뽀로로 젓가락</td>
							<td class="align-l">[색상] RED, [사이즈] M</td>
							<td>7,000원</td>
							<td>10</td>
							<td>70,000원</td>
						</tr>
						<tr>
							<td class="align-l">[색상] RED, [사이즈] L</td>
							<td>7,000원</td>
							<td>1</td>
							<td>7,000원</td>
						</tr>
						<tr>
							<td class="align-l">[색상] GREEN, [사이즈] L</td>
							<td>7,000원</td>
							<td>1</td>
							<td>7,000원</td>
						</tr>
						<tr>
							<th>뽀로로 젓가락 시즌2</td>
							<td class="align-l">[색상] RED, [사이즈] M</td>
							<td>7,000원</td>
							<td>1</td>
							<td>7,000원</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<th>총 구매수량</th>
							<td><strong class="dh_red">13</strong></td>
							<td></td>
						</tr>
					</tfoot>
				</table>

				<table class="adm-table v-line mt30">
					<caption>주문내역 요약</caption>
					<tbody>
						<tr>
							<th class="col-wide">총 구매금액</th>
							<td><strong>84,000원</strong></td>
							<th class="col-df">배송비</th>
							<td class="col-twice">2,500원</td>
						</tr>
						<tr>
							<th>사용포인트</th>
							<td>-1000 P</td>
							<th>적립예정포인트</th>
							<td>840 P</td>
						</tr>
						<tr>
							<th>총 결제금액</th>
							<td colspan="3"><strong class="dh_red">85,500원</strong></td>
						</tr>
					</tbody>
				</table>

				<h3 class="icon-pen mt60">주문고객 정보</h3>
				<table class="adm-table v-line">
					<caption>주문고객 정보</caption>
					<thead>
						<tr>
							<th class="col-df"><label for="oc-name">고객명</label></th>
							<td><input type="text" id="oc-name"></td>
							<th class="col-df"><label for="oc-email">이메일</label></th>
							<td><input type="text" id="oc-email" class="width-l"></td>
						</tr>
						<tr>
							<th><label for="oc-phone">휴대폰</label></th>
							<td><input type="text" id="oc-phone" class="width-xs"> - <input type="text" class="width-xs"> - <input type="text" class="width-xs"></td>
							<th><label for="oc-tel">전화번호</label></th>
							<td><input type="text" id="oc-tel" class="width-xs"> - <input type="text" class="width-xs"> - <input type="text" class="width-xs"></td>
						</tr>
					</thead>
				</table>


				<h3 class="icon-pen mt60">배송지 정보</h3>

				<table class="adm-table v-line">
					<caption>배송지 정보</caption>
					<tbody>
						<tr>
							<th class="col-df"><label for="rc-name">받으시는 분</label></th>
							<td colspan="3"><input type="text" id="rc-name"></td>
						</tr>
						<tr>
							<th><label for="rc-addr">주소</label></th>
							<td colspan="3">
								<input type="text" class="width-xs2 mr10">/
								<input type="text" class="width-l ml10">
								<input type="text" class="width-l" id="rc-addr">
							</td>
						</tr>
						<tr>
							<th><label for="rc-phone">휴대폰</label></th>
							<td><input type="text" id="rc-phone" class="width-xs"> - <input type="text" class="width-xs"> - <input type="text" class="width-xs"></td>
							<th class="col-df"><label for="rc-tel">전화번호</label></th>
							<td><input type="text" id="rc-tel" class="width-xs"> - <input type="text" class="width-xs"> - <input type="text" class="width-xs"></td>
						</tr>
						<tr>
							<th><label for="rc-cmt">배송시 요청사항</label></th>
							<td colspan="3"><textarea cols="30" rows="3" id="rc-cmt"></textarea></td>
						</tr>
						<tr>
							<th><label for="dv-num" class="dh_red">운송장번호</label></th>
							<td><input type="text" id="dv-num"></td>
							<th>상품 발송일</th>
							<td>2016-08-22</td>
						</tr>
					</tbody>
				</table>

				<h3 class="mt60">결제 정보</h3>
				<table class="adm-table v-line">
					<caption>결제 정보</caption>
					<tbody>
						<tr>
							<th class="col-df">결제 방법</th>
							<td>신용카드</td>
							<th class="col-df">결제 확인일</th>
							<td>2016-08-22</td>
						</tr>
						<tr>
							<th class="col-df">상품 발송일</th>
							<td>2016-08-22</td>
							<th class="col-df">판매 완료일</th>
							<td>2016-08-22</td>
						</tr>
					</tbody>
				</table>


				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt40">
					<div class="float-l">
						<a href="#" class="btn-clear button btn-l">목록으로</a>
					</div>
					<div class="float-r">
						<button type="button" class="btn-special btn-xl" onclick="">출력하기</button>
						<input type="button" value="저장하기" class="btn-ok btn-xl" onclick="">
					</div>
				</div><!-- END 제품 액션 버튼 -->
				<!-- END 제품리스트 -->

			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>