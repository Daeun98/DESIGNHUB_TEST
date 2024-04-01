<!doctype html>
<html lang="ko">
 <head>
  <title><?=$shop_info['shop_name']?> 관리자모드</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>

<script language="javascript">
<!--
function sendit() {
    var form=document.login_form;
	if(form.admin_userid.value=="") {
	    alert("관리자 아이디를 입력해 주십시오.");
		form.admin_userid.focus();
	} else if(form.admin_passwd.value=="") {
	    alert("관리자 비밀번호를 입력해 주십시오.");
		form.admin_passwd.focus();
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
<body onload="document.login_form.admin_userid.focus();" class="dh-mark">


<FORM name="login_form" id="login_form" method="post" onsubmit="inputSendit();event.returnValue = false;">
	<div class="adm-login">
		<p class="logo"><img src="<? echo isset($shop_info['logo_image']) ? "/_data/file/".$shop_info['logo_image'] : "/_dhadm/image/common/logo.jpg";?>" alt="@업체명"></p>
		<p class="msg mt25">이 페이지는 홈페이지의 관리자모드를 접속하기 위한 페이지입니다.<br>
		<span class="dh_red">허가 받지 않은 사용자의 로그인 시도 및 기타 부당한 방법으로 접근할 경우 관리자에게 귀하의 IP가 신고/접수됩니다.</span></p>
		<ul class="mt25">
			<li><label for="adm_id" class="hidden">아이디</label>
				<input type="text" placeholder="아이디" id="adm_id" name="admin_userid" onKeyDown="inputSendit();">
				</li>
			<li><label for="adm_pw" class="hidden">비밀번호</label>
				<input type="password" placeholder="비밀번호" id="adm_pw" name="admin_passwd" size="20" onKeyDown="inputSendit();">
			</li>
			<li class="pt5"><input type="button" value="ADMIN LOGIN" onclick="sendit();"></li>
		</ul>
	</div>

</form>

</body>
</html>
