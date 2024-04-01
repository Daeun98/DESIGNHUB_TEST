
			<!-- Member Wrap -->
			<div class="member-wrap">
				<!-- Find Account : 비밀번호 찾기 -->
				<div class="find-account">

					<!-- Tab of Find Type -->
					<ul class="find-type">
						<li><a href="<?=cdir()?>/dh_member/find_id">아이디 찾기</a></li>
						<li class="on"><a href="<?=cdir()?>/dh_member/find_pw">비밀번호 찾기</a></li>
					</ul><!-- END Tab of Find Type -->

				<? if($find_cnt==1 && isset($findRow->idx)){ ?>

			<div class="find-form-wrap">

				<table class="dh_content" style="margin-left:40px;" width="592" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="text-align:center; line-height:25px; font-size:12px; color:#888888;">
							가입하실 때 등록한 이메일로 임시 비밀번호를 전송하였습니다.<br>
							메일 확인 후 홈페이지에서 비밀번호를 수정하신 뒤, 사이트 이용 부탁드립니다.
						</td>
					</tr>
					<tr><td height="40" style="font-size:0;"></td></tr>

		<tr>
			<td style="text-align:center;">
				<a href="<?=cdir()?>/dh_member/login"><img src="http://newadm.myelhub.com/image/shop_mail/btn_login.png" alt="로그인하기" border="0"></a>
			</td>
		</tr>

				</table>

		</div>

				<?}else{?>

					<p>아래 인증수단 중 한가지로 인증을 받으시면 가입시 입력하신 이메일로 새로운 비밀번호를 보내드립니다.<br>아래의 방법으로 아이디/비밀번호찾기가 불가능하시거나, 사이트장애, 오류 발생 시 고객센터로 문의해 주시기 바랍니다.</p>
					

					<!-- Find Form -->
					<div class="find-form-wrap">
					<form method="post" name="idsearch_form1" id="idsearch_form1" onsubmit="idpwsearch(1);event.returnValue = false;">
					<input type="hidden" name="find_mode" value="1">
						<div class="find-account-l">
							<p><img src="/image/members/f_txt01.png" alt="휴대폰 번호로 찾기 : 본인 명의의 휴대폰번호로 인증받아 아이디를 찾을 수 있습니다."></p>
							<div class="find-form">
								<ul>
									<li><label for="tel_id"><img src="/image/members/f_id.png" alt="아이디"></label><input type="text" id="tel_id" name="userid"></li>
									<li><label for="tel_name"><img src="/image/members/f_name.png" alt="이름"></label><input type="text" id="tel_name" name="name"></li>
									<li><label for="tel"><img src="/image/members/f_number.png" alt="휴대폰번호"></label><input type="text" id="tel" class="mem-ip-num" name="phone1" maxlength="4"> -<input type="text" class="mem-ip-num" name="phone2" maxlength="4"> -<input type="text" class="mem-ip-num" name="phone3" onKeyDown="inputSendit(1);" maxlength="4"></li>
								</ul>
								<p class="find-btn"><a href="javascript:idpwsearch(1);"><img src="/image/members/btn_find.png"></a></p>
							</div>
						</div>
						</form>
						
						<form method="post" name="idsearch_form2" id="idsearch_form2" onsubmit="idpwsearch(2);event.returnValue = false;">
						<input type="hidden" name="find_mode" value="2">
						<div class="find-account-r">
							<p><img src="/image/members/f_txt02_2.png" alt="휴대폰 번호로 찾기 : 가입시 등록한 이메일 주소로 ."></p>
							<div class="find-form">
								<ul>
									<li><label for="email_id"><img src="/image/members/f_id.png" alt="아이디"></label><input type="text" id="email_id" name="userid"></li>
									<li><label for="email_name"><img src="/image/members/f_name.png" alt="이름"></label><input type="text" id="email_name" name="name"></li>
									<li><label for="email"><img src="/image/members/f_mail.png" alt="이메일주소"></label><input type="text" id="email" name="email" onKeyDown="inputSendit(2);"></li>
								</ul>
									<p class="find-btn"><a href="javascript:idpwsearch(2);"><img src="/image/members/btn_find.png"></a></p>
							</div>
						</div>
						</form>
					</div><!-- END Find Form -->

					<?}?>
				</div><!-- Find Account -->
			</div><!-- END Member Wrap -->


			

<script>

function inputSendit(num) {
	if(event.keyCode==13) { 
		idpwsearch(num);
	}
}


function idpwsearch(num)
{
	if(num==1){
		var form = document.idsearch_form1;

		if(form.userid.value==""){
			alert("아이디를 입력해주세요.");
			form.userid.focus();
			return;
		}else if(form.name.value==""){
			alert("이름을 입력해주세요.");
			form.name.focus();
			return;
		}else if(form.phone1.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone1.focus();
			return;
		}else if(form.phone2.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone2.focus();
			return;
		}else if(form.phone3.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone3.focus();
			return;
		}

	}else if(num==2){

		var form = document.idsearch_form2;
		if(form.userid.value==""){
			alert("아이디를 입력해주세요.");
			form.userid.focus();
			return;
		}else if(form.name.value==""){
			alert("이름을 입력해주세요.");
			form.name.focus();
			return;
		}else if(form.email.value==""){
			alert("이메일을 입력해주세요.");
			form.email.focus();
			return;
		}
	}

		form.submit();
}


</script>