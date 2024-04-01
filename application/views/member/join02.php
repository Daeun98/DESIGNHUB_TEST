
<!-- Member Wrap -->
<div class="member-wrap">
	<!-- Join -->
	<div class="join-wrap">
		<!-- Join Top -->
		<div class="join-top">
			<p class="join-title"><img src="/image/members/join.png" alt="JOIN"></p>
			<p class="join-step">
				<img src="/image/members/join_tap01.png" alt="STEP01. 약관동의">
				<img src="/image/members/join_tap02_on.png" alt="STEP02. 정보입력">
				<img src="/image/members/join_tap03.png" alt="STEP03. 가입완료">
			</p>
		</div><!-- END Join Top -->
		
		<form name="join_form" id="join_form" action="?agree=1&ok=1" method="post">
		<input type="hidden" name="userid_chk">

		<!-- Join Form -->
		<div class="join-form-wrap">
			<h5>기본정보입력<span class="join-noti">(기본정보는 필수입력 항목입니다.)</span></h5>
			<ul class="join-form">
				<li>
					<p class="join-item"><label for="join_id">아이디</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-02" id="join_id" name="userid" onkeyup="javascript:document.join_form.userid_chk.value='';">
						<span class="mem-btn-join"><a href="javascript:userChk();">중복확인</a></span>
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_pw">비밀번호 입력</label></p>
					<p class="join-user">
						<input type="password" class="mem-input-02" id="join_pw" name="passwd">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_pw2">비밀번호 확인</label></p>
					<p class="join-user">
						<input type="password" class="mem-input-02" id="join_pw2" name="passwd_check">
					</p>
				</li>
			</ul>

			<h5 class="mt30">개인정보입력<span class="join-noti">(*표시는 필수입력 항목입니다.)</span></h5>
			<ul class="join-form">
				<li>
					<p class="join-item"><label for="join_name" class="join-noti">* 이름</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-02" id="join_name" name="name">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_email" class="join-noti">* 이메일</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-02" id="join_email" name="email1"> @ <input type="text" class="mem-input-02" name="email2" id="email2">
						<select name="email_sel" onchange="res(this.value)">
							<option value="">직접입력</option>
							<option value="naver.com">naver.com</option>
							<option value="hanmail.net">hanmail.net</option>
							<option value="nate.com">nate.com</option>
							<option value="paran.com">paran.com</option>
							<option value="empal.com">empal.com</option>
							<option value="hotmail.com">hotmail.com</option>
							<option value="gmail.com">gmail.com</option>
							<option value="dreamwiz.com">dreamwiz.com</option>
							<option value="lycos.co.kr">lycos.co.kr</option>
							<option value="yahoo.co.kr">yahoo.co.kr</option>
							<option value="korea.com">korea.com</option>
							<option value="hanmir.com">hanmir.com</option>
						</select>
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_birth" class="join-noti">* 생년월일</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-01" id="join_birth" name="birth_year" maxlength="4"> 년
						<input type="text" class="mem-input-01 ml5" name="birth_month" maxlength="2"> 월
						<input type="text" class="mem-input-01 ml5" name="birth_date" maxlength="2"> 일

						<span class="ml15"></span>
						<input type="radio" id="birth01" name="birth_type" name="birth_gubun" Checked value="1"> <label for="birth01">양력</label>
						<input type="radio" id="birth02" name="birth_type" class="ml10" name="birth_gubun" value="2"> <label for="birth02">음력</label>
					</p>
				</li>
				<li>
					<p class="join-item"><label for="address2" class="join-noti">* 주소</label></p>
					<div class="join-user">
						<input type="text" class="mem-input-02" id="zipcode1" name="zip1" readonly>
						<!-- <input type="text" class="mem-input-02"> --><!-- 우편번호 5 자리: 폼이 하나일경우 -->
						<span class="mem-btn-join"><a href="javascript:sample6_execDaumPostcode();">우편번호찾기</a></span><br>
						<p class="mt5"><input type="text" class="mem-input-03" name="add1" id="address1" readonly>
						<input type="text" class="mem-input-03" id="address2" name="add2" ></p>	
					</div>
				</li>
				<li>
					<p class="join-item"><label for="join_tel">전화번호</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-01" id="join_tel" name="tel1" maxlength="4"> -
						<input type="text" class="mem-input-01" name="tel2" maxlength="4"> -
						<input type="text" class="mem-input-01" name="tel3" maxlength="4">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_phone" class="join-noti" >* 휴대폰번호</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-01" id="join_phone" name="phone1" maxlength="4"> -
						<input type="text" class="mem-input-01" name="phone2" maxlength="4"> -
						<input type="text" class="mem-input-01" name="phone3" maxlength="4">
					</p>
				</li>
				<li>
					<p class="join-item">메일링서비스</p>
					<p class="join-user"><input type="checkbox" id="chk_mailing" name="mailing" value="1">
						<label for="chk_mailing">메일수신에 동의하시면 체크해주세요.</label>
					</p>
				</li>
				<!-- <li>
					<p class="join-item">SMS 수신여부</p>
					<p class="join-user"><input type="checkbox" id="chk_sms">
						<label for="chk_sms">SMS 수신에 동의하시면 체크해주세요.</label>
					</p>
				</li>
				<li>
					<p class="join-item">정보공개</p>
					<p class="join-user"><input type="checkbox" id="chk_opinfo">
						<label for="chk_opinfo">홈페이지 관리자가 나의 정보를 볼 수 있도록 합니다.</label>
					</p>
				</li> -->
			</ul>
		</div>
		<!-- END Join Form -->
		
		<!-- Join Button -->
		<p class="join-btn">
			<input type="button" value="취소" class="join-btn-cancel" onclick="javascript:history.back(-1);">
			<input type="button" name="writeBtn" value="다음단계로" class="join-btn-ok" onclick="joinform_chk();">
		</p>
		</form>
		<!-- End Join Button -->	
	</div><!-- END Join -->
</div><!-- END Member Wrap -->

<script>


function joinform_chk()
{
	var form = document.join_form;


	if(form.userid.value==""){
		alert('아이디를 입력해주세요.');
		form.userid.focus();
		return;
	}
	else if(form.userid.value.length < 4 || form.userid.value.length > 21) {
		alert("아이디는 4~20자로 입력 주세요.");
		form.userid.focus();
		return;
	}
	else if(form.userid_chk.value==''){
		alert("아이디 중복체크하여 주세요.");
		return;
	}
	else if(form.passwd.value=="") {
		alert("비밀번호를 입력해 주세요.");
		form.passwd.focus();
		return;
	}else if(form.passwd.value.length < 6 || rtn_engnum_mix_chk(form.passwd.value) == false){

		alert("비밀번호는 영문+숫자 조합 6자리 이상으로 입력해 주세요.");
		form.passwd.focus();
		return;

	}else if(form.passwd_check.value=="") {
		alert("비밀번호확인를 입력해 주세요.");
		form.passwd_check.focus();
		return;
	}
	else if(form.passwd.value != form.passwd_check.value) {
		alert("비밀번호가 정확하지 않습니다. 정확히 입력해 주세요.");
		form.passwd_check.focus();
		return;
	}
	else if(form.name.value=="") {
		alert("이름을 입력해 주세요.");
		form.name.focus();
		return;
	}
	else if(form.email1.value=="") {
		alert("이메일을 입력해 주세요.");
		form.email1.focus();
		return;
	}
	else if(form.email2.value=="") {
		alert("이메일을 입력해 주세요.");
		form.email2.focus();
		return;
	}
	else if(form.birth_year.value=="") {
		alert("생년월일을 입력해 주세요.");
		form.birth_year.focus();
		return;
	}
	else if(form.birth_year.value.length < 4) {
		alert("연도 값은 4자리로 입력해 주세요.");
		form.birth_year.focus();
		return;
	}
	else if(form.birth_month.value=="") {
		alert("생년월일을 입력해 주세요.");
		form.birth_month.focus();
		return;
	}		
	else if(form.birth_date.value=="") {
		alert("생년월일을 입력해 주세요.");
		form.birth_date.focus();
		return;
	}
	else if(form.zip1.value=="") {
		alert("우편번호를 입력해 주세요.");
		form.zip1.focus();
		return;
	}
	/*else if(form.zip1.value.length != 3) {
		alert("우편번호 앞 3자리를 입력해 주세요.");
		form.zip1.focus();
		return;
	} 
	else if(form.zip2.value=="") {
		alert("우편번호를 입력해 주세요.");
		form.zip2.focus();
		return;
	} 
	else if(form.zip2.value.length != 3) {
		alert("우편번호 뒤 3자리를 입력해 주세요.");
		form.zip2.focus();
		return;
	} */
	else if(form.add1.value=="") {
		alert("주소를 입력해 주세요.");
		form.add1.focus();
		return;
	}
	else if(form.add2.value=="") {
		alert("상세주소를 입력해 주세요.");
		form.add2.focus();
		return;
	}
	else if(form.phone1.value=="") {
		alert("회원님의 휴대폰 번호를 입력해 주세요.");
		form.phone1.focus();
		return;
	}
	else if(form.phone2.value=="") {
		alert("회원님의 휴대폰 번호를 입력해 주세요.");
		form.phone2.focus();
		return;
	}
	else if(form.phone3.value=="") {
		alert("회원님의 휴대폰 번호를 입력해 주세요.");
		form.phone3.focus();
		return;		
	}else{
		form.submit();		
		form.writeBtn.disabled = true;
	}

}

function userChk()
{

	var form = document.join_form;

	if(form.userid.value==""){
		alert('아이디를 입력해주세요.');
		form.userid.focus();
		return;
	}else if(form.userid.value.length < 4 || form.userid.value.length > 21) {
		alert("아이디는 4~20자로 입력 주세요.");
		form.userid.focus();
		return;
	}else{
		$.get("<?=cdir()?>/dh_member/join/userChk/?userChkid="+form.userid.value,function(data){
			if(data==0){
				alert("사용가능한 아이디 입니다.");
				form.userid_chk.value=form.userid.value;
				form.passwd.focus();
			}else{
				alert("현재 사용중인 아이디 입니다.");
				form.userid_chk.value="";
				form.userid.focus();
			}
		});
	}

	return;
}

</script>