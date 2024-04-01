<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_add";
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/header.php");
?>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		//option add event
		$(".ev-add-option-item").on("click", function(){
			var $list = $(this).next("ul");
			var item = $("li", $list).html();
			var idx = $("li",$list).length + 1;

			var newItem = "<li>"+item.replace(/옵션항목.+?:/, "옵션항목 "+idx+" :")+"</li>";
			$list.append(newItem);
		});
	});
	function optionToggle(select){
		//option select
		switch (select)
		{
			case 'op_not': $(".op-same-price, .op-each-price").hide();
				break;
			case 'op_same_price': 
				$(".op-each-price").hide();
				$(".op-same-price").show();
				break;
			case 'op_each_price':
				$(".op-same-price").hide();
				$(".op-each-price").show();
				break;		
		}
	}
	</script>
	<!--Container-->
	<div id="container">
		<?	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/left_side.php"); ?>

		<!-- Content -->
		<div id="content">
			<!-- inner -->
			<div class="inner adm-wrap">
				<div class="adm-title">
					<h2>제품등록</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 제품등록</p>
				</div>

				<!-- 기본정보 -->
				<h3>기본 정보</h3>
				<table class="adm-table mt10 mb70">
					<caption>제품 등록 - 기본정보</caption>
					<colgroup>
						<col style="width:15%;"><col><col style="width:150px;">
					</colgroup>
					<tbody>						
						<tr>
							<th>제품분류</th>
							<td colspan="2">
								<select name="">
									<option value="">1차 카테고리</option>
								</select>
								<!-- <select name="">
									<option value="">2차 카테고리</option>
								</select>
								<select name="">
									<option value="">3차 카테고리</option>
								</select>
								<select name="">
									<option value="">4차 카테고리</option>
								</select> -->
							</td>
						</tr>					
						<tr>
							<th>상품진열</th>
							<td colspan="2">
								<input type="checkbox" id="display_new"><label for="display_new">NEW 신상품</label>
								<input type="checkbox" id="display_prim"><label for="display_prim">추천상품</label>
								<input type="checkbox" id="display_main"><label for="display_main">메인페이지 노출</label>
								<input type="checkbox" id="display_top"><label for="display_top">카테고리 상단노출</label>							
							</td>
						</tr>		
						<tr>
							<th>아이콘 선택</th>
							<td>
								<input type="checkbox" id="icon1"><label for="icon1"><img src="/_dhadm/image/icon/new.gif" alt="신상품"></label>
								<input type="checkbox" id="icon2"><label for="icon2"><img src="/_dhadm/image/icon/sale.gif" alt="세일중"></label>
								<input type="checkbox" id="icon3"><label for="icon3"><img src="/_dhadm/image/icon/hot.gif" alt="주문폭주"></label>
								<input type="checkbox" id="icon4"><label for="icon4"><img src="/_dhadm/image/icon/soldout_soon.gif" alt="품절임박"></label>
							</td>
							<td>
								<p class="align-r btn-inline"><button type="button">아이콘 관리</button></p>
							</td>
						</tr>
					</tbody>
				</table><!-- END 기본정보 -->

				<!-- 제품정보 -->
				<h3 class="icon-pen">제품 정보<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70">
					<caption>제품정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>제품명</th>
							<td><input type="text" class="width-xl"></td>
							<th>제품코드</th>
							<td><input type="text" class="width-m"></td>
						</tr>
						<tr>
							<th>제조사</th>
							<td><input type="text" class="width-xl"></td>
							<th>원산지</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>추가항목1</th>
							<td><input type="text" class="width-xl"></td>
							<th>추가항목2</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>추가항목3</th>
							<td><input type="text" class="width-xl"></td>
							<th>추가항목4</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>제품요약설명<br>(줄바꿈 자동 적용)</th>
							<td colspan="3"><textarea name="" cols="30" rows="3"></textarea></td>
						</tr>
						<tr>
							<th>제품목록 썸네일</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="prod_thumb" /><label for="prod_thumb" class="btn-file">파일찾기</label>
										<span class="file-name">선택한 파일이 없습니다.</span>
									</p>
									<p class="float-l">권장사이즈 : 240 * 240 px</p>
								</div>
							</td>
						</tr>
						<tr>
							<th>상세보기1</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="photo1" /><label for="photo1" class="btn-file">파일찾기</label>
										<span class="file-name">filename.jpg</span>
									</p>
									<p class="float-l">권장사이즈 : 800 * 680 px</p>
								</div>
							</td>
						</tr>
						<tr>
							<th>상세보기2</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="photo2" /><label for="photo2" class="btn-file">파일찾기</label>
										<span class="file-name">선택한 파일이 없습니다.</span>
									</p>
								</div>
							</td>
						</tr>
						<tr>
							<th>상세보기3</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="photo3" /><label for="photo3" class="btn-file">파일찾기</label>
										<span class="file-name">선택한 파일이 없습니다.</span>
									</p>
									<p class="float-l">
										<button type="button" style="vertical-align:top;" class="btn-clear">이미지 추가</button>
									</p>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="4" class="plain">
								<div>
									에디터가 들어갑니다.
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 제품정보 -->

				<!-- 제품 가격 정보 -->
				<h3 class="icon-pen">제품 가격정보<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70">
					<caption>제품 가격 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>판매가격</th>
							<td><input type="text" class="width-m"> 원 <small class="ml10">실제 판매금액</small></td>
							<th>표시가격</th>
							<td><input type="text" class="width-m float-l"><span class="float-l ml5"> 원</span>
							<p class="float-l ml15" style="line-height:1.1em;"><small><span style="text-decoration:line-through;">4,000원</span> 으로 표시<br>미입력시 표기 안됨</small></p></td>
						</tr>
						<tr>
							<th>적립금</th>
							<td colspan="3"><input type="text" class="width-m"> P<small class="ml10">(기본 정책 : 판매가의 5%, 적립금 별도로 책정 가능)</small></td>
						</tr>
						<tr>
							<th>재고/진열관리</th>
							<td colspan="3">
								<input type="radio" name="stock" id="stock_soldout"><label for="stock_soldout"><em class="dh_red">품절상품</em></label>
								<input type="radio" name="stock" id="stock_unlimited" checked><label for="stock_unlimited">무제한</label>
								<input type="radio" name="stock" id="stock_limited"><label for="stock_limited">재고수량</label><input type="text" class="width-xs"> 개
							</td>
						</tr>
						<tr>
							<th>배송비</th>
							<td colspan="3">
								<input type="radio" name="delivery_fee" id="dlv_free_op" checked><label for="dlv_free_op">50,000원 이상 무료</label>
								<input type="radio" name="delivery_fee" id="dlv_free"><label for="dlv_free">무조건 무료배송</label>
								<input type="radio" name="delivery_fee" id="dlv_each"><label for="dlv_each">배송비 별도부과</label><input type="text" class="width-xs" title="별도 배송비"> 원<span class="mr20"></span>
								<input type="radio" name="delivery_fee" id="dlv_after"><label for="dlv_after">수신자부담(착불)</label>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 제품 가격 정보 -->

				<!-- 제품 옵션 -->
				<h3 class="icon-pen">제품 옵션<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70">
					<caption>제품 옵션 설정을 위한 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>옵션설정</th>
							<td>
								<input type="radio" name="option_use" id="op_not" onchange="optionToggle('op_not');" checked><label for="op_not">옵션 사용 안함</label>
								<!-- <input type="radio" name="option_use" id="op_same_price" onchange="optionToggle('op_same_price');"><label for="op_same_price">가격 동일 옵션</label> -->
								<input type="radio" name="option_use" id="op_each_price" onchange="optionToggle('op_each_price');"><label for="op_each_price">옵션별 별도 가격</label>
							</td>
						</tr>
						<tr class="op-same-price op-each-price selected" style="display:none;">
							<td colspan="2">
								<p style="line-height:1.7em;" class="pt10 pb10 pl20"><strong>
								ㆍ 옵션은 최대 3가지 유형으로 사용가능하며, 해당 옵션을 선택하여 제품을 구매하는 방식입니다.<br>
								ㆍ 옵션은 필수로 1개이상 선택되어야 주문이 가능합니다. (예) 색상 : 빨강, 파랑, 노랑
								</strong></p>
							</td>
						</tr>
						<!-- <tr class="op-same-price" style="display:none;">
							<th><input type="checkbox" id="op_same1"><label for="op_same1">옵션1</label></th>
							<td>
								옵션명 : <input type="text" class="width-m mr30">
								옵션항목 : <input type="text" class="width-l">
								<button type="button">불러오기</button>
							</td>
						</tr>
						<tr class="op-same-price" style="display:none;">
							<th><input type="checkbox" id="op_same2"><label for="op_same2">옵션2</label></th>
							<td>
								옵션명 : <input type="text" class="width-m mr30">
								옵션항목 : <input type="text" class="width-l">
								<button type="button">불러오기</button>
							</td>
						</tr>
						<tr class="op-same-price" style="display:none;">
							<th><input type="checkbox" id="op_same3"><label for="op_same3">옵션3</label></th>
							<td>
								옵션명 : <input type="text" class="width-m mr30">
								옵션항목 : <input type="text" class="width-l">
								<button type="button">불러오기</button>
							</td>
						</tr> -->
						<tr class="op-each-price" style="display:none;">
							<th><input type="checkbox" id="op_each1"><label for="op_each1">옵션1</label>	</th>
							<td>
								옵션명 : <input type="text" class="width-m"> <button type="button" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_option_load.php?d=1','prod_option',435,460);">불러오기</button>
								<button type="button" class="ev-add-option-item btn-clear ml5">항목추가</button>

								<ul class="op-each-list">
									<li>옵션항목 1 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 2 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 3 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="op-each-price" style="display:none;">
							<th><input type="checkbox" id="op_each2"><label for="op_each2">옵션2</label>	</th>
							<td>
								옵션명 : <input type="text" class="width-m"> <button type="button">불러오기</button>
								<button type="button" class="btn-clear ml5">항목추가</button>

								<ul class="op-each-list">
									<li>옵션항목 1 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 2 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 3 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="op-each-price" style="display:none;">
							<th><input type="checkbox" id="op_each3"><label for="op_each3">옵션3</label>	</th>
							<td>
								옵션명 : <input type="text" class="width-m"> <button type="button">불러오기</button>
								<button type="button" class="btn-clear ml5">항목추가</button>

								<ul class="op-each-list">
									<li>옵션항목 1 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 2 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
									<li>옵션항목 3 : <input type="text" class="width-m mr25"> 판매가격 : <input type="text" class="width-s"> 원<span class="mr40"></span>적립금 : <input type="text" class="width-s"> P
										<button type="button" class="btn-alert btn-sm ml25">삭제</button>
									</li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 제품 옵션 -->

				<!-- 기타 -->
				<h3 class="icon-pen">기타<span class="toggle-btn on"></span></h3>
				<table class="adm-table">
					<caption>기타 설정을 위한 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>배송안내</th>
							<td class="plain">
								<div>
									에디터가 들어갑니다.<br>
									기본설정에서 작성된 내용이 보여지고 수정모드에서 개별적으로 편집이 가능합니다.
								</div>
							</td>
						</tr>
						<tr>
							<th>교환/반품안내</th>
							<td class="plain">
								<div>
									에디터가 들어갑니다.<br>
									기본설정에서 작성된 내용이 보여지고 수정모드에서 개별적으로 편집이 가능합니다.
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 기타 -->

				<p class="align-c mt40"><input type="button" class="btn-ok btn-xl" value="등록하기"></p>

			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>