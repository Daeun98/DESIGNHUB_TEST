<?
	if(isset($go_url)){
		$go_url_arr = explode("?",$go_url);
		$cnt = count($go_url_arr);
		if($cnt > 1){ $go_url.= "&lg=1"; }else{ $go_url.= "?lg=1"; }
	}

	//저장된 아이디 쿠키가 있는경우
	if($this->input->cookie("cookie_id")){
		$checked = "checked";
	}else{
		$checked = "";
	}
?>
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				
				<!-- 쇼핑몰 로그인 -->
				<div class="shop-login-wrap">

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
									<input type="text" id="mem-id" name="userid" value="<?=$this->input->cookie("cookie_id")?>">
								</li>
								<li><label for="mem-pw" class="f-tit">비밀번호</label>
									<input type="password" id="mem-pw" name="passwd" value="" onKeyDown="mainLoginInputSendit();">
									<!-- <p><input type="checkbox" id="save_id" name="save_id" value="1" <?=$checked?>> <label for="save_id">아이디 저장</label></p> -->
								</li>
							</ul>
						</form>

							<p class="shop-login-btn"><input type="button" class="btn-emp" value="로그인" onclick="go_login();"></p>
						</div><!-- END 회원로그인 -->
						
						<!-- 비회원로그인 -->
						<div class="shop-login-guest">

							<!-- 일반 로그인시 -->
							<h3 class="shop-lg-tit"><img src="/image/shop/shop_login_tit2.png" alt="비회원 주문조회"></h3>

							<form method="post" name="nologin_order_form" onSubmit="mainOrderInputSendit();event.returnValue = false;">
							<ul class="order-noti">
								<li>구매 고객님의 <strong>이메일과 주문코드</strong>를 입력하세요.</li>
								<li>구매 상세내역 조회에서 주문변경이 가능합니다.</li>
								<!-- <li>회원이 되시면 더욱 편리하게 서비스를 이용하실 수 있습니다.</li> -->
							</ul>

							<ul class="shop-login-field">
								<li><label for="guest-email" class="f-tit">이메일</label>
									<input type="text" id="guest-email" name="email">
								</li>
								<li><label for="guest-code" class="f-tit">주문코드</label>
									<input type="text" id="guest-code" name="trade_code" onKeyDown="mainOrderInputSendit();">
								</li>
							</ul>
							<!-- END 일반 로그인시 -->
							</form>

							<p class="shop-login-btn"><input type="button" class="btn-normal" value="비회원 주문조회" onclick="go_order()"></p>
						</div><!-- END 비회원로그인 -->

					</div><!-- END shop login -->

					<ul class="shop-login-noti">
						<li>회원이 되시면 더욱 편리하게 서비스를 이용하실 수 있습니다. <a href="<?=cdir()?>/dh_member/join" class="cart-btn1 ml5">회원가입</a></li>
						<li>로그인 정보를 잊으셨나요? <a href="<?=cdir()?>/dh_member/find_id" class="cart-btn2 ml5">아이디/비밀번호 찾기</a></li>
					</ul>

				</div><!-- END 쇼핑몰 로그인 -->

			
			</div><!-- END Shop Wrap -->
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


function mainOrderInputSendit() {
	if(event.keyCode==13) { 
		go_order();
	}
}


function go_order()
{
	var form = document.nologin_order_form;

	if(form.email.value==""){
		alert("이메일을 입력해주세요.");
		form.email.focus();
		return;
	}else if(form.trade_code.value==""){
		alert("주문코드를 입력해주세요.");
		form.trade_code.focus();
		return;
	}else{
		form.action="<?=cdir()?>/dh_order/shop_order_detail/"+form.trade_code.value;
		form.submit();
	}
}


</script>