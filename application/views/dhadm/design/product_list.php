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
					<h2>제품목록</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 제품목록</p>
				</div>

				<h3 class="icon-search">제품 검색</h3>
				<!-- 제품검색 -->
				<table class="adm-table">
					<caption>제품 검색</caption>
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
								<input type="text" placeholder="제품명으로 검색" class="width-m">
								<input type="text" placeholder="코드명으로 검색" class="width-m">
								<input type="button" value="검색" class="btn-ok">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 제품 <strong>99개</strong></h3>
					<p class="list-adding float-r">
						<a href="#" class="on">등록일순</a>
						<a href="#">높은가격순<em>▲</em></a>
						<a href="#">낮은가격순<em>▼</em></a>
						<a href="#">이름순<em>▲</em></a>
						<a href="#">이름순<em>▼</em></a>
					</p>
				</div>

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;"><col><col><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>가격</th>
							<th>재고</th>
							<th>등록일</th>
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
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
					</tbody>
				</table>
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택이동" class="btn-ok" onclick="openMoveProduct();">
						<input type="button" value="선택복사" class="btn-ok">
						<input type="button" value="선택삭제" class="btn-alert" onclick="confirm('선택하신 제품을 삭제합니다. \n삭제하신 제품은 복구할 수 없습니다.');">
					</div>
					<div class="float-r">
						<a href="product_add.php" class="button btn-ok">제품등록</a></span>
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