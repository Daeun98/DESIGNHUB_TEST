<?
$email = explode("@",$row->email);
?>

<!-- Member Wrap -->
<div class="member-wrap">
	<!-- Join -->
	<div class="join-wrap">

	<form name="info_form" id="info_form" method="post">
	<input type="hidden" name="idx" value="<?=$row->idx?>">

		<!-- Join Form -->
		<div class="join-form-wrap">
			<h5>기본정보입력<span class="join-noti">(기본정보는 필수입력 항목입니다.)</span></h5>
			<ul class="join-form">
				<li>
					<p class="join-item">아이디</p>
					<p class="join-user"><?=$row->userid?></p>
				</li>
				<li>
					<p class="join-item"><label for="join_pw">기존 비밀번호 입력</label></p>
					<p class="join-user">
						<input type="password" class="mem-input-02" id="join_pw" name="passwd">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_pw">새 비밀번호 입력</label></p>
					<p class="join-user">
						<input type="password" class="mem-input-02" id="join_pw" name="new_passwd">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_pw2">새 비밀번호 확인</label></p>
					<p class="join-user">
						<input type="password" class="mem-input-02" id="join_pw2" name="passwd_check">
					</p>
				</li>
			</ul>

			<h5 class="mt30">개인정보입력<span class="join-noti">(*표시는 필수입력 항목입니다.)</span></h5>
			<ul class="join-form">
				<li>
					<p class="join-item">이름</p>
					<p class="join-user"><?=$row->name?></p>
				</li>
				<li>
					<p class="join-item"><label for="join_email" class="join-noti">* 이메일</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-02" id="join_email" name="email1" value="<?=$email[0]?>"> @ <input type="text" class="mem-input-02" name="email2" id="email2" value="<?=$email[1]?>">
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
						<input type="text" class="mem-input-01" id="join_birth" name="birth_year" maxlength="4" value="<?=$row->birth_year?>"> 년
						<input type="text" class="mem-input-01 ml5" name="birth_month" maxlength="2" value="<?=$row->birth_month?>"> 월
						<input type="text" class="mem-input-01 ml5" name="birth_date" maxlength="2" value="<?=$row->birth_date?>"> 일

						<span class="ml15"></span>
						<input type="radio" id="birth01" name="birth_gubun" value="1" <?if($row->birth_gubun=="1"){?>checked<?}?>> <label for="birth01">양력</label>
						<input type="radio" id="birth02" class="ml10" name="birth_gubun" value="2" <?if($row->birth_gubun=="2"){?>checked<?}?>> <label for="birth02">음력</label>
					</p>
				</li>
				<li>
					<p class="join-item"><label for="address2" class="join-noti">* 주소</label></p>
					<div class="join-user">
						<input type="text" class="mem-input-02" id="zipcode1" name="zip1" readonly value="<?=$row->zip1?>"> <!-- - <input type="text" class="mem-input-01" name="zip2" id="zipcode2" readonly value="<?=$row->zip2?>"> -->
						<!-- <input type="text" class="mem-input-02"> --><!-- 우편번호 5 자리: 폼이 하나일경우 -->
						<span class="mem-btn-join"><a href="javascript:sample6_execDaumPostcode();">우편번호찾기</a></span><br>
						<p class="mt5"><input type="text" class="mem-input-03" name="add1" id="address1" readonly value="<?=$row->add1?>">
						<input type="text" class="mem-input-03" id="address2" name="add2" value="<?=$row->add2?>"></p>	
					</div>
				</li>
				<li>
					<p class="join-item"><label for="join_tel">전화번호</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-01" id="join_tel" name="tel1" maxlength="4" value="<?=$row->tel1?>"> -
						<input type="text" class="mem-input-01" name="tel2" maxlength="4" value="<?=$row->tel2?>"> -
						<input type="text" class="mem-input-01" name="tel3" maxlength="4" value="<?=$row->tel3?>">
					</p>
				</li>
				<li>
					<p class="join-item"><label for="join_phone" class="join-noti" >* 휴대폰번호</label></p>
					<p class="join-user">
						<input type="text" class="mem-input-01" id="join_phone" name="phone1" maxlength="4" value="<?=$row->phone1?>"> -
						<input type="text" class="mem-input-01" name="phone2" maxlength="4" value="<?=$row->phone2?>"> -
						<input type="text" class="mem-input-01" name="phone3" maxlength="4" value="<?=$row->phone3?>">
					</p>
				</li>
				<li>
					<p class="join-item">메일링서비스</p>
					<p class="join-user"><input type="checkbox" id="chk_mailing" name="mailing" value="1" <?if($row->mailing=="1"){?>checked<?}?>>
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
				<li>
					<p class="join-item">회원탈퇴</p>
					<p class="join-user"><span class="mem-btn-join mem-btn-tinted-02"><a href="<?=cdir()?>/dh_member/leave">탈퇴하기</a></span></p>
				</li>
			</ul>

		</div>
		<!-- END Join Form -->

		</form>
		
		<!-- Join Button -->
		<p class="join-btn">
			<!-- <input type="button" value="취소" class="join-btn-cancel"> -->
			<input type="submit" value="수정하기" class="join-btn-ok" onclick="editform_chk();">
		</p>
		<!-- End Join Button -->	
	</div><!-- END Join -->
</div><!-- END Member Wrap -->

<script>

function editform_chk()
{
	var form = document.info_form;

	if(form.passwd.value=="") {
		alert("기존 비밀번호를 입력해 주세요.");
		form.passwd.focus();
		return;
	}else if(form.new_passwd.value && CheckPass(form.new_passwd.value) == false){

		alert("새 비밀번호는 영문+숫자 조합 6자리 이상으로 입력해 주세요.");
		form.new_passwd.focus();
		return;

	}
	else if(form.new_passwd.value && form.passwd_check.value=="") {
		alert("새 비밀번호확인을 입력해 주세요.");
		form.passwd_check.focus();
		return;
	}
	else if(form.new_passwd.value && form.new_passwd.value != form.passwd_check.value) {
		alert("새 비밀번호가 정확하지 않습니다. 정확히 입력해 주세요.");
		form.passwd_check.focus();
		return;
	}
	/*else if(form.name.value=="") {
		alert("이름을 입력해 주세요.");
		form.name.focus();
		return;
	}*/
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
	}*/ 
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
	}

}




</script>