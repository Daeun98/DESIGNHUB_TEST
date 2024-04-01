<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="setting";
	$PageName="setting_global";
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/header.php");
?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		checkCurrentSkin();
	});
	function checkCurrentSkin(){
		//현재 스킨 선택
		var nowSkin=$("#wrap").attr("class");
		$("#"+nowSkin).attr("checked","checked");
	}
	//스킨 미리보기
	function skinPreview(skinCode){ $("#wrap").attr("class",skinCode); }
	</script>
	<!--Container-->
	<div id="container">
		<?	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/left_side.php"); ?>

		<!-- Content -->
		<div id="content">
			<!-- inner -->
			<div class="inner adm-wrap">
				<div class="adm-title">
					<h2>기본설정</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 환경설정 &gt; 기본설정</p>
				</div>

				<!-- 관리자 정보 -->
				<h3 class="icon-pen">관리자 설정</h3>
				<table class="adm-table">
					<caption>관리자 설정</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>관리자 아이디</th>
							<td><input type="text" class="width-m"></td>
							<th>관리자 비밀번호</th>
							<td><input type="password" class="width-m"></td>
						</tr>
						<tr>
							<th>로고 설정</th>
							<td colspan="3">
								<p class="pb5"><img src="/_dhadm/image/common/profile.png" alt="@업체명" width="160"></p>
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="photo2"><label for="photo2" class="btn-file">파일찾기</label>
										<span class="file-name">선택한 파일이 없습니다.</span>
									</p>
									<p class="float-l">권장 가로사이즈 : 159 px</p>
								</div>
							</td>
						</tr>
						<tr>
							<th>스킨 설정</th>
							<td colspan="3">
								<ul class="skin-list">
									<li><input type="radio" name="adm-skin" id="skin-indigo" onchange="skinPreview(this.id);"><label for="skin-indigo">Indigo(기본)<em class="skin-thumb indigo"></em></label></li>
									<li><input type="radio" name="adm-skin" id="skin-mint" onchange="skinPreview(this.id);"><label for="skin-mint">Mint<em class="skin-thumb mint"></em></label></li>
									<li><input type="radio" name="adm-skin" id="skin-green" onchange="skinPreview(this.id);"><label for="skin-green">Green<em class="skin-thumb green"></em></label></li>
									<li><input type="radio" name="adm-skin" id="skin-orange" onchange="skinPreview(this.id);"><label for="skin-orange">Orange<em class="skin-thumb orange"></em></label></li>
									<li><input type="radio" name="adm-skin" id="skin-indipink" onchange="skinPreview(this.id);"><label for="skin-indipink">Indigo Pink<em class="skin-thumb indipink"></em></label></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt30 mb30"><input type="button" class="btn-l btn-ok" value="적용"></p>
				<!-- END 관리자 정보 -->

				<!-- 업체 정보 -->
				<h3 class="icon-pen">업체 정보</h3>
				<table class="adm-table">
					<caption>업체 정보</caption>
					<colgroup>
						<col style="width:18%;"><col style="width:32%;">
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>업체명</th>
							<td colspan="3"><input type="text" class="width-m"></td>
						</tr>
						<tr>
							<th>도메인</th>
							<td colspan="3">http:// <input type="text" class="width-l"></td>
						</tr>
						<tr>
							<th>대표명</th>
							<td><input type="text" class="width-xl"></td>
							<th>사업자번호</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>전화번호1</th>
							<td><input type="text" class="width-xl"></td>
							<th>전화번호2</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>팩스</th>
							<td><input type="text" class="width-xl"></td>
							<th>이메일</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>개인정보관리책임자</th>
							<td><input type="text" class="width-xl"></td>
							<th>휴대폰</th>
							<td><input type="text" class="width-xl"></td>
						</tr>
						<tr>
							<th>통신판매업허가번호</th>
							<td><input type="text" class="width-xl"></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th>사업장 주소</th>
							<td colspan="3"><input type="text" class="width-xl"></td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt30 mb30"><input type="button" class="btn-l btn-ok" value="적용"></p>
				<!-- END 업체 정보 -->
			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>