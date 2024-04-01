
		<form name="passwd_form" method="post" onsubmit="return false;" action="<?=$action.$query_string.$param?>">
		<input type="hidden" name="pwd_chk" value="1">
		<input type="hidden" name="mode" value="<?=$mode?>">
			<!-- Board wrap -->
			<div class="board-wrap">
				<div class="board-pw">
					<p>비밀글로 작성된 게시물입니다.<br><strong>비밀번호를 입력하세요.</strong></p>

					<div class="board-pw-field">
						<label for="board-user-pw" class="label-out">비밀번호</label>
						<input type="password" id="board-user-pw" name="pwd" onKeyDown="InputSendit();">
						<input type="button" class="btn-normal-s" value="확인" onclick="pwd_form();">
					</div>
				</div>
			</div><!-- END Board wrap -->
		</form>


	<script type="text/javascript">

	function InputSendit() {
		if(event.keyCode==13) { 
			pwd_form();
		}
	}
	

function pwd_form(){
	var form = document.passwd_form;

	if(form.pwd.value=="")	{
		alert("비밀번호를 입력해주세요.");
		form.pwd.focus();
		return;
	}else{

		form.submit();
	}
	return;

}

	</script>