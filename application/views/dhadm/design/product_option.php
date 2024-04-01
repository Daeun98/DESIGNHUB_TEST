<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_option";
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
					<h2>옵션관리</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 옵션관리</p>
				</div>

				<!-- 제품검색 -->
				<h3 class="icon-search">제품 검색</h3>
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
					</tbody>
				</table><!-- END 제품검색-->


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 옵션 <strong>3개</strong></h3>
					<p class="float-r">
						<input type="button" value="옵션등록" class="btn-ok" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_option_setting.php?d=1','prod_option',435,460);">
					</p>
				</div>
				
				<!-- 옵션 목록 테이블 -->
				<table class="adm-table line align-c">
					<caption>옵션 목록을 보여주는 테이블</caption>
					<colgroup>
						<col style="width:40px;"><col style="width:70px;"><col style="width:100px;"><col style="width:150px;"><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>옵션코드</th>
							<th>옵션명</th>
							<th>옵션항목</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<tr>
							<td><input type="checkbox"></td>
							<td>29</td>
							<td>option0003</td>
							<td>색상</td>
							<td class="align-l">빨강 / 파랑 / 노랑 / 흰색 / 검정</td>
							<td><input type="button" value="수정" class="btn-sm" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_option_setting.php?d=1','prod_option',435,460);">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>28</td>
							<td>option0002</td>
							<td>색상2</td>
							<td class="align-l">RED / BLUE / YELLOW / GREEN / BLACK</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>28</td>
							<td>option0001</td>
							<td>SIZE1</td>
							<td class="align-l">100 / 110 / 120 / 130 / 140 / 150</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
					</tbody>
				</table><!-- END 옵션 목록 테이블 -->
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="confirm('선택하신 옵션을 삭제합니다. \n삭제된 옵션은 복구할 수 없습니다.');">
					</div>
					<div class="float-r">
						<input type="button" value="옵션등록" class="btn-ok" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_option_setting.php?d=1','prod_option',435,460);">
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