<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="setting";
	$PageName="setting_spam";
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
					<h2>스팸관리</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 환경설정 &gt; 스팸관리</p>
				</div>

				<!-- 스팸 등록 -->
				<h3 class="icon-pen">스팸 IP 등록</h3>
				<table class="adm-table mb70">
					<caption>관리자모드 환경설정</caption>
					<colgroup>
						<col style="width:120px;"><col style="width:250px;"><col style="width:200px;"><col><col>
					</colgroup>
					<tbody>
						<tr>
							<th>IP</th>
							<td>
								<input type="text" class="width-xl">
							</td>
							<th>해당 IP 게시물 삭제여부</th>
							<td><span class="ml10"></span>
								<input type="radio" id="spam_del_y" name="spam_del"><label for="spam_del_y">삭제함</label>
								<input type="radio" id="spam_del_n" name="spam_del" checked><label for="spam_del_n">삭제안함</label>
							</td>
							<td class="align-r">
								<input type="button" value="등록하기" class="btn-l btn-ok">
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 스팸 등록 -->


				<!-- 스팸 리스트 -->
				<h3 class="icon-list">스팸 IP 목록</h3>
				<table class="adm-table align-c">
					<caption>관리자모드 환경설정</caption>
					<colgroup>
						<col style="width:60px;"><col style="width:50px"><col>
						<col style="width:200px;"><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox"></th>
							<th>No</th>
							<th>IP</th>
							<th>등록일</th>
							<th>변경</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert" onclick="confirm('정말 삭제하시겠습니까?')">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>29</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>28</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>27</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>26</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>25</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>24</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>23</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>22</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>21</td>
							<td>123.123.123.123</td>
							<td>2016-01-21</td>
							<td><button type="button" class="btn-sm btn-alert">삭제</button></td>
						</tr>
					</tbody>
				</table>

				<p class="mt15">
					<input type="button" value="선택삭제" class="btn-alert" onclick="confirm('선택하신 스팸 IP를 삭제합니다. \n삭제된 스팸 IP는 복구할 수 없습니다.');">
				</p>

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
				
				<!-- END 스팸 리스트 -->

			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>