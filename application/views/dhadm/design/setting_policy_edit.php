<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="setting";
	$PageName="setting_policy";
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
					<h2>약관/정책 설정</h2>
					<p class="page-path opensans"><a href="main.php">HOME</a> &gt; 환경설정 &gt; 약관/정책 설정 &gt; 수정하기</p>
				</div>

				<!-- 이용약관 -->
				<h3>이용약관</h3>
				<div class="border-box pd0">
					에디터가 들어가는 자리입니다.
				</div>
				<!-- END 이용약관 -->

				<!-- 개인정보취급방침 -->
				<h3 class="mt40">개인정보취급방침</h3>
				<div class="border-box pd0">
					에디터가 들어가는 자리입니다.
				</div>
				<!-- END 개인정보취급방침 -->

				<p class="align-c mt40">
					<input type="button" class="btn-l btn-ok" value="적용하기">
				</p>

			</div><!-- END inner -->
		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>