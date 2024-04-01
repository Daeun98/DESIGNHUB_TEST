<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_exhibition";
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/header.php");
?>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//하위 카테고리가 있을 경우 li 에 .parent 추가
		$(".adm-category li").each(function(){
			var $dep = $(this).children("ul");
			if ($dep.length > 0) $(this).addClass("parent");
		});
		
		//카테고리 폴더 아이콘에 이벤트 추가(열기/닫기)
		$(".adm-category .ic").each(function(){
			var $child = $(this).parent("p").siblings("ul");
			$(this).on("click", function(){
				toggleCategoryChild($child);
			});
		});

		//카테고리 선택
		$(".adm-category p").on("click", function(e){
			var $on = $(this);
			if ((e.target.className!="ic" || !$on.parent("li").hasClass("parent")) && e.target.nodeName!="INPUT")
			{
				$(".adm-category p").not($on).removeClass("on");
				$on.addClass("on");
			}
		});
	});
	//category open, close toggle
	function toggleCategoryChild($child){
		$child.stop().toggle(200,function(){
			var $parent = $child.parent("li");
			if ($child.css("display") == "none") {
				$parent.removeClass("open");
				$("ul", $child).hide();
				$("li", $child).removeClass("open");
				$("p", $child).removeClass("on"); //하위 카테고리의 선택을 해제
			} else {
				$parent.addClass("open");
			}
		});
	}
	//각 카테고리의 하위 항목추가
	function addItem(){
		alert('항목을 추가합니다.');
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
					<h2>브랜드/기획전</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 브랜드/기획전</p>
				</div>
				
				<p class="border-box mb30">※ 홈페이지와 메뉴연동이 되어 있지 않은 경우 추가개발이 필요합니다.</p>
				
				
				<!-- 카테고리 관리 및 설정 -->
				<div class="float-wrap">
					<!-- 카테고리 관리 -->
					<div class="float-l" style="width:35%;">
						<div class="float-wrap">
							<h3 class="icon-cate float-l">카테고리 관리</h3>
							<p class="float-r">
								<button type="button" class="plain mr5 mt5" title="새로고침"><img src="/_dhadm/image/icon/refresh_16.png" alt="새로고침"></button>
								<input type="button" value="대분류 추가" class="btn-ok">
							</p>
						</div>
						<!-- 클래스명 정리 :
							1. 하위 카테고리가 있을 경우에만 부모 li 태그에 'parent' 클래스 추가
							2. 카테고리 항목(p태그) 선택시 해당 p태그에 'on' 클래스 추가

							참고 : em.ic는 폴더 아이콘 표시를 위한 태그로 상위 li의 클래스에 따라 모양이 변경됨.
						-->
						<div class="adm-category-box">
							<ul class="adm-category">
								<li><p><em class="ic"></em>1차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
								<li><p><em class="ic"></em>1차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p>
									<ul class="cate-2dep">
										<li><p><em class="ic"></em>2차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
										<li><p><em class="ic"></em>2차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
										<li><p><em class="ic"></em>2차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p>
											<ul class="cate-3dep">
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p>
													<ul class="cate-4dep">
														<li><p><em class="ic"></em>4차 카테고리</p></li>
														<li><p><em class="ic"></em>4차 카테고리</p></li>
														<li><p><em class="ic"></em>4차 카테고리</p></li>
														<li><p><em class="ic"></em>4차 카테고리</p></li>
													</ul>
												</li>
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
											</ul>
										</li>
										<li><p><em class="ic"></em>2차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p>
											<ul class="cate-3dep">
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
												<li><p><em class="ic"></em>3차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
											</ul>
										</li>
									</ul>
								</li>
								<li><p><em class="ic"></em>1차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
								<li><p><em class="ic"></em>1차 카테고리<input type="button" value="항목추가" onclick="addItem();"></p></li>
							</ul>
						</div>
						<p class="align-r mt10 ft-xs">선택한 카테고리 이동<span class="ml10"></span>
							<button type="button" class="btn-icon btn-clear">▲</button>
							<button type="button" class="btn-icon btn-clear">▼</button>
						</p>
					</div><!-- END 카테고리 관리 -->

					<!-- 카테고리 설정 -->
					<div class="float-r" style="width:61%">
						<h3 class="icon-pen">카테고리 상세설정</h3>
						<!-- <p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 카테고리를 선택해주세요.</p> -->

						<table class="adm-table">
							<caption>카테고리 수정</caption>
							<colgroup>
								<col style="width:140px;">								
							</colgroup>
							<tbody>
								
								<tr>
									<th>상위 카테고리</th>
									<td>신발</td>
								</tr>
								<tr>
									<th>분류 URL</th>
									<td>test.co.kr/product/brand.php?cate_no=99</td>
								</tr>
								<tr>
									<th>카테고리 이름</th>
									<td><input type="text" class="width-xl"></td>
								</tr>
								<tr>
									<th>접근권한</th>
									<td>
										<select name="" id="">
											<option value="">비회원</option>
											<option value="">준회원</option>
											<option value="">정회원</option>
											<option value="">특별회원</option>
											<option value="">명예회원</option>
											<option value="">관리자</option>
											<option value="">슈퍼관리자</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>숨김 여부</th>
									<td>
										<input type="radio" name="cate_display" id="cate_show" checked><label for="cate_show">노출</label>
										<input type="radio" name="cate_display" id="cate_hide"><label for="cate_hide">숨김</label>
									</td>
								</tr>
								<tr>
									<th>타이틀 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 800 * 200 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" id="prod_thumb" /><label for="prod_thumb" class="btn-file">파일찾기</label>
												<span class="file-name">선택한 파일이 없습니다.</span>
											</p>
											<p class="float-l"><button type="button" class="btn-clear">삭제</button></p>
										</div>
									</td>
								</tr>
								<tr>
									<th>추가 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 800 * 200 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" id="prod_thumb" /><label for="prod_thumb" class="btn-file">파일찾기</label>
												<span class="file-name">선택한 파일이 없습니다.</span>
											</p>
											<p class="float-l"><button type="button"class="btn-clear">삭제</button></p>
										</div>
									</td>
								</tr>
								<tr>
									<th>분류설명</th>
									<td><textarea name="" cols="30" rows="3"></textarea></td>
								</tr>
								<tr>
									<th>카테고리 삭제</th>
									<td><button type="button" class="btn-alert btn-sm">삭제</button>
										<span class="ft-red ft-s ml5">삭제하신 카테고리는 복구가 불구합니다.</span>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="align-c mt20"><input type="button" value="변경사항 적용하기" class="btn-l btn-ok"></p>
					</div><!-- END 카테고리 설정 -->
				</div><!-- END 카테고리 관리 및 설정 -->

				

				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">제품목록</h3>
					<p class="float-r">
						<span class="ft-s mr10">※기획전 제품은 제품목록에서 선택하여 등록됩니다.</span>
						<button type="button" class="btn-ok" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_exhibition_select.php?d=1','prod_option',900,850);">제품추가</button>
					</p>
				</div>

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;"><col><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>가격</th>
							<th>재고</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>∞</td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td><input type="button" value="목록에서 삭제" class="btn-sm btn-alert"></td>
						</tr>
					</tbody>
				</table>
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택제품 목록에서 삭제" class="btn-alert" onclick="confirm('선택하신 제품을 목록에서 삭제합니다. \n삭제하신 제품은 [제품추가] 에서 다시 등록이 가능합니다.');">
					</div>
					<div class="float-r">
						<button type="button" class="btn-ok" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_exhibition_select.php?d=1','prod_option',900,850);">제품추가</button>
					</div>
				</div><!-- END 제품 액션 버튼 -->

				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<a href="#"><img src="/_dhadm/image/board_img/arrow_l_end.gif" alt="맨 처음으로" /></a>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_l.gif" alt="이전" /></a>
					<span>
						<a href="#" class="on">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#">5</a>
					</span>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_r.gif" alt="다음" /></a>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_r_end.gif" alt="맨 뒤로" /></a>
				</p><!-- END Pager -->
				
				<!-- END 제품리스트 -->

			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>