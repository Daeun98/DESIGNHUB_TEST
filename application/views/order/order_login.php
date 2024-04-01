
			<!-- Member Wrap -->
			<div class="member-wrap">
					<h2 class="shop-login-tit"><img src="/image/shop/shop_login.png" alt="LOGIN"></h2>
					<div class="shop-login">
						<!-- 회원로그인 -->
						
						<form method="post" name="login_form" onSubmit="mainLoginInputSendit();event.returnValue = false;" action="<?=cdir()?>/dh_member/login">
						<input type="hidden" name="go_url" value="<? echo isset($go_url) ? $go_url : ""; ?>">
						<div class="shop-login-member">
							<h3 class="shop-lg-tit"><img src="/image/shop/shop_login_tit1.png" alt="로그인"></h3>
							
							<ul class="order-noti">
								<li>아이디와 비밀번호를 입력하세요.</li>
								<li>비밀번호는 대소문자를 구별합니다.</li>
							</ul>
							<ul class="shop-login-field">
								<li><label for="mem-id" class="f-tit">아이디</label>
									<input type="text" id="mem-id" name="userid">
								</li>
								<li><label for="mem-pw" class="f-tit">비밀번호</label>
									<input type="password" id="mem-pw" name="passwd" value="" onKeyDown="mainLoginInputSendit();">
									<!-- <p><input type="checkbox" id="rem_id"> <label for="rem_id">아이디 저장</label></p> -->
								</li>
							</ul>
						</form>

							<p class="shop-login-btn"><input type="button" class="btn-emp" value="로그인" onclick="go_login();"></p>
						</div><!-- END 회원로그인 -->
						
						<!-- 비회원로그인 -->
						<div class="shop-login-guest">
							<!-- 비회원 주문시 -->
						 <h3 class="shop-lg-tit"><img src="/image/shop/shop_login_tit3.png" alt="비회원 주문하기"></h3>
							
							<div class="guest-order-noti">
								<ul class="order-noti">
									<li>비회원 주문시 이메일과 주문코드로 주문내역 확인이 가능합니다.</li>
									<li>비회원 주문시 <!-- 쿠폰 사용 및  -->포인트 적립 등의 혜택은 받으실 수 없습니다.</li>
								</ul>
							</div>
							
							<p class="shop-login-btn"><input type="button" class="btn-normal" value="비회원 주문하기" onclick="location.href='<?=$go_url?>?nologin=1';"></p>
							<!-- END 비회원 주문시 -->
						</div><!-- END 비회원로그인 -->

					</div><!-- END shop login -->

					<ul class="shop-login-noti">
						<li>회원이 되시면 더욱 편리하게 서비스를 이용하실 수 있습니다. <a href="<?=cdir()?>/dh_member/join" class="cart-btn1 ml5">회원가입</a></li>
						<li>로그인 정보를 잊으셨나요? <a href="<?=cdir()?>/dh_member/find_id" class="cart-btn2 ml5">아이디/비밀번호 찾기</a></li>
					</ul>

			</div><!-- END Member Wrap -->
<script>

function mainLoginInputSendit() {
	if(event.keyCode==13) { 
		go_login();
	}
}

function go_login()
{
	var form = document.login_form;

	if(form.userid.value==""){
		alert("아이디를 입력해주세요.");
		form.userid.focus();
		return;
	}else if(form.passwd.value==""){
		alert("비밀번호를 입력해주세요.");
		form.passwd.focus();
		return;
	}else{
//		alert(form.action);
		form.submit();
	}
}
</script>