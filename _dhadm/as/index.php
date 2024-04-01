
<!doctype html>
<html lang="ko">
 <head>
  <title>DesignHub Single Sign On Page</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="@default.css" />
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>

<script language="javascript">
<!--
function sendit() {
    var form=document.login_form;
	if(form.wid.value=="") {
	    alert("아이디를 입력해 주십시오.");
		form.wid.focus();
	} else if(form.wpwd.value=="") {
	    alert("비밀번호를 입력해 주십시오.");
		form.wpwd.focus();
	} else {
	    form.submit();
	}
}

function inputSendit() {
	if(event.keyCode==13) {
		sendit();
	}
}
//-->
</script>

</head>
<body onload="document.login_form.wid.focus();" class="dh-mark">


<FORM name="login_form" id="login_form" method="post" onsubmit="inputSendit();event.returnValue = false;" action="as_proc.php">
	<div class="adm-login">
		<p class="logo"><img src="dhlogo.png"></p>
		<ul class="mt25">
			<li><label for="adm_id" class="hidden">아이디</label>
				<input type="text" placeholder="아이디" id="adm_id" name="wid">
				</li>
			<li><label for="adm_pw" class="hidden">비밀번호</label>
				<input type="password" placeholder="비밀번호" id="adm_pw" name="wpwd" size="20" onKeyDown="inputSendit();">
			</li>
			<li class="pt5"><input type="button" value="로그인" onclick="sendit();"></li>
		</ul>
	</div>

</form>

</body>
</html>
