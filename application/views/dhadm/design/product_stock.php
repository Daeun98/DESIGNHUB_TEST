<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_stock";
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
					<h2>재고관리</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 재고관리</p>
				</div>

				<!-- 제품검색 -->
				<h3 class="icon-search">제품 검색</h3>
				<table class="adm-table mt10 mb70">
					<caption>제품 등록 - 기본정보</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>						
						<tr>
							<th>제품분류</th>
							<td>
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
							<th>제품검색</th>
							<td>
								<input type="text" placeholder="제품명으로 검색" id="search_type1"><label for="search_type1" class="hide">제품명으로 검색</label>
								<input type="text" placeholder="코드명으로 검색" id="search_type2"><label for="search_type2" class="hide">코드명으로 검색</label>
								<input type="button" class="btn-ok" value="검색">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색-->


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 제품 <strong>99개</strong></h3>
					<p class="float-r ft-s ft-red">※ 재고가 0이면 <img src="/_dhadm/image/icon/soldout.gif" alt="품절" class="mid"> 로 표시됩니다.</p>
				</div>
				
				<!-- 제품 목록 테이블 -->
				<table class="adm-table line align-c">
					<caption>제품 정렬을 위한 제품 목록 테이블</caption>
					<colgroup>
						<col style="width:80px;"><col style="width:160px;"><col style="width:70px;"><col style="width:250px;">
						<col><col><col style="width:90px;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>누적판매수량</th>
							<th>현재재고수량</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<tr>
							<td>29</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>100</td>
							<td>∞</td>
							<td><input type="button" value="수정" class="btn-sm" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_stock_edit.php?d=1','prod_option',400,320);"></td>
						</tr>
						<tr>
							<td>28</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>100</td>
							<td>99</td>
							<td><input type="button" value="수정" class="btn-sm"></td>
						</tr>
						<!-- 옵션이 있는 경우. 유의!!! rowspan의 갯수 = 옵션의 갯수, colspan은 고정값 -->
						<tr class="option">
							<td rowspan="3" colspan="2"></td>
							<td rowspan="3"><strong>옵션</strong></td>
							<td class="align-l">RED</td>
							<td>23</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td rowspan="3"><input type="button" value="수정" class="btn-sm" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_stock_edit.php?d=1','prod_option',400,400);"></td>
						</tr>
						<tr class="option">
							<td class="align-l">BLUE</td>
							<td>1,000</td>
							<td>1,000</td>
						</tr>
						<tr class="option">
							<td class="align-l">GREEN</td>
							<td>1,000</td>
							<td>1,000</td>
						</tr>
						<!-- END 옵션이 있는경우 -->
						<tr>
							<td>27</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>100</td>
							<td>99</td>
							<td><input type="button" value="수정" class="btn-sm"></td>
						</tr>
						<tr>
							<td>26</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>100</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td><input type="button" value="수정" class="btn-sm"></td>
						</tr>
						<tr>
							<td>25</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>100</td>
							<td>99</td>
							<td><input type="button" value="수정" class="btn-sm"></td>
						</tr>
					</tbody>
				</table><!-- END 제품 목록 테이블 -->
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-r">
						<button type="button" class="btn-clear">엑셀 파일로 저장</button>
					</div>
					<!-- <div class="float-r">
						<a href="product_add.php" class="button btn-ok">제품등록</a>
					</div> -->
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