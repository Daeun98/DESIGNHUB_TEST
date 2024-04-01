<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	$PageName="product_align";
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
					<h2>제품 진열순서 변경</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 제품관리 &gt; 제품 진열순서 변경</p>
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
					<h3 class="icon-list float-l">등록 제품 <strong>99개</strong></h3>
					<p class="list-adding float-r">
						<span><img src="/_dhadm/image/icon/btn_up1.png" alt="화살표(위)1개"> 위로 1칸 이동</span>
						<span class="ml10"><img src="/_dhadm/image/icon/btn_up10.png" alt="화살표(위)2개"> 위로 10칸 이동</span>	
						<span class="ml10"><img src="/_dhadm/image/icon/btn_down1.png" alt="화살표(아래)1개"> 아래로 1칸 이동</span>	
						<span class="ml10"><img src="/_dhadm/image/icon/btn_down10.png" alt="화살표(아래)2개"> 아래로 10칸 이동</span>	
					</p>
				</div>
				
				<!-- 제품 목록 테이블 -->
				<table class="adm-table line align-c">
					<caption>제품 정렬을 위한 제품 목록 테이블</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;">
						<col><col><col style="width:90px;"><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>가격</th>
							<th>재고</th>
							<th>진열순서</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>29</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>∞</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>28</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>27</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>26</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>25</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>24</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>23</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>22</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>21</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>20</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>
								<p class="mb5">
									<input type="image" src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동">
								</p>
								<p>
									<input type="image" src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동">
									<input type="image" src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품 목록 테이블 -->
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택이동" class="btn-ok" onclick="openWinPopup('http://dhadm.myelhub.com/html/dhadm/product_move.php?d=1','product_move',760,500);">
						<input type="button" value="선택복사" class="btn-ok">
						<input type="button" value="선택삭제" class="btn-alert" onclick="confirm('선택하신 제품을 삭제합니다. \n삭제된 제품은 복구할 수 없습니다.');">
					</div>
					<div class="float-r">
						<a href="product_add.php" class="button btn-ok">제품등록</a>
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