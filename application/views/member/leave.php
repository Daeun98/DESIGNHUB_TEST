
<!-- Member Wrap -->
<div class="member-wrap">
	<!-- 회원탈퇴 -->
	<div class="leave-wrap">

		<form name="leave_form" id="leave_form" method="post">
		<input type="hidden" name="del_idx" value="<?=$row->idx?>">

		<!-- <h5>회원탈퇴</h5> -->
		<p class="mt10 mb30">그 동안 저희 서비스를 이용해주셔서 감사합니다. 탈퇴신청을 하시면 <span class="join-noti">기존의 모든 서비스가 중단</span>됩니다.<br>
		탈퇴하시는 이유를 남겨주시면 소중한 자료로 삼겠습니다.</p>
		<ul class="join-form">
			<li>
				<p class="join-item"><label for="leave_id">아이디</label></p>
				<p class="join-user">
					<input type="text" class="mem-input-02" id="leave_id" value="<?=$row->userid?>" disabled>
				</p>
			</li>
			<li>
				<p class="join-item"><label for="leave_pw">비밀번호 입력</label></p>
				<p class="join-user">
					<input type="password" class="mem-input-02" id="leave_pw" name="passwd">
				</p>
			</li>
			<li>
				<p class="join-item">탈퇴사유</p>
				<p class="join-user">
					<select name="outtype">
						<option value="">카테고리 선택</option>
						<option value="사이트 이용불편">사이트 이용불편</option>
						<option value="서비스 개선필요">서비스 개선필요</option>
						<option value="기타">기타</option>
					</select>
				</p>
			</li>
			<li>
				<p class="join-item">요청사항</p>
				<p class="join-user">
					<textarea name="outmsg" cols="30" rows="5" content=""></textarea>
				</p>
			</li>
		</ul>
	
		</form>

		
		<!-- Button -->
		<p class="mt30" style="text-align:center;">
			<input type="button" value="메인으로" class="join-btn-cancel" onclick="javascript:location.href='/html';">
			<input type="button" value="탈퇴하기" class="join-btn-ok" onclick="leave()">
		</p>
		<!-- End Button -->	

	</div><!-- END 회원탈퇴 -->
</div><!-- Member Wrap -->

<script>

function leave()
{
	
	var form = document.leave_form;

	if(form.passwd.value=="") {
		alert("비밀번호를 입력해 주세요.");
		form.passwd.focus();
		return;
	}
	else if(form.outtype.value=="") {
		alert("탈퇴사유를 선택해 주세요.");
		form.outtype.focus();
		return;
	}
	else if(form.outmsg.value=="") {
		alert("요청사항을 입력해 주세요.");
		form.outmsg.focus();
		return;
	}
	else{
		form.submit();
	}

}


</script>