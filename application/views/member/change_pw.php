<?
	$Language="KO";
	$PageName="MEMBER";
	include("../include/head.php");
	include("../include/header.php");
?>

	<!--Container-->
	<div id="container">

		<div class="inner">
			
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				
				<!-- 쇼핑몰 로그인 -->
				<div class="shop-login-wrap">


				<?
					$go_url = $this->input->get("go_url");					
					if(!$go_url){ $go_url = cdir()."/"; }
				?>
				<!-- Member Wrap -->
				<div class="member-wrap">
					<!-- Find Account : 아이디 찾기-->
					<div class="change-pw">
						<div class="change-pw-header">
							<p class="mb5"><img src="/image/members/change_pw.png" alt="비밀번호 변경"></p>
							<p><small>기존의 비밀번호를 새 비밀번호로 변경합니다.</small></p>
						</div>

						<form method="post" name="chagnge_pw_form" enctype="multipart/form-data">
						<input type="hidden" name="idx" value="<?=$mem_stat->idx?>">		
						<input type="hidden" name="go_url" value="<?=$go_url?>">		
						<ul class="change-pw-form">
							<li><p class="change-pw-lb">아이디</p>
								<p class="change-pw-user"><?=$mem_stat->userid?></p></li>
							<li><p class="change-pw-lb"><label for="new_pw">현재 비밀번호</label></p>
								<p class="change-pw-user"><input type="password" id="new_pw" name="passwd_old"></p></li>
							<li><p class="change-pw-lb"><label for="new_pw">새 비밀번호</label></p>
								<p class="change-pw-user"><input type="password" id="new_pw" name="passwd"></p></li>
							<li><p class="change-pw-lb"><label for="new_pw2">새 비밀번호 확인</label></p>
								<p class="change-pw-user"><input type="password" id="new_pw2" name="passwd_check"></p></li>
						</ul>
						</form>

						<p class="change-pw-btn">
							<input type="button" class="join-btn-cancel" value="나중에 변경하기" onclick="javascript:location.href='<?=$go_url?>'">
							<input type="button" class="join-btn-ok" value="변경하기" onclick="chage_pw();">
						</p>
					</div><!-- Find Account -->
				</div><!-- END Member Wrap -->


				<script>
				function chage_pw()
				{
					var form = document.chagnge_pw_form;

					if(form.passwd_old.value==""){		
						alert("현재 비밀번호를 입력해 주세요.");
						form.passwd_old.focus();
					}else if(form.passwd.value==""){
						alert("새 비밀번호를 입력해 주세요.");
						form.passwd.focus();
						return;
					}else if(form.passwd_check.value==""){
						alert("새 비밀번호 확인을 입력해 주세요.");
						form.passwd_check.focus();
						return;
					}else if(form.passwd.value != form.passwd_check.value) {
						alert("새 비밀번호 확인이 정확하지 않습니다.");
						form.passwd_check.focus();
					}else if(form.passwd.value==form.passwd_old.value){
						alert("새 비밀번호는 현재 비밀번호와 다르게 입력하셔야 합니다. ");
						form.passwd.focus();
						return;
					}else{
						form.submit();
					}
				}

				</script>

				</div><!-- END 쇼핑몰 로그인 -->
			
			</div><!-- END Shop Wrap -->


		</div><!-- END Content -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
