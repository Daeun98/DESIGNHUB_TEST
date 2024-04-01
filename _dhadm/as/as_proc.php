<?php
header("Content-Type: text/html; charset=UTF-8");
ini_set('error_display','1');

$hostname = '211.43.14.97';
$username = 'dhsian';
$password = 'myel!0303';
$database = 'dhsian';

$dbcon = mysql_connect($hostname,$username,$password) or die(mysql_error().'<BR> DB connect fail !!');
mysql_query("set names utf8");
mysql_select_db($database,$dbcon) or die('DB selected fail !!');

$id = $_POST['wid'];
$pw = $_POST['wpwd'];

if($id and $pw){
	//로그인 검증
	$sql = "select * from dh_worker where workid = '{$id}' and workpw = '{$pw}'";
	$res = mysql_query($sql);
	$cnt = mysql_num_rows($res);

	if($cnt){
		//sso 로그기록

		$device = "";

		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"mobile")!==false){
			$device = "M";
		}

		$sql = "insert into dh_sso_log set userid = '{$id}', siteurl = '".$_SERVER['HTTP_HOST']."', ip = '".$_SERVER['REMOTE_ADDR']."', device = '{$device}', wdate = now()";
		if(mysql_query($sql)){
			?>
			<form action="/dhadm" method="post" name="myel_admin_login">
				<input type="hidden" name="admin_userid" value="myeladmin">
				<input type="hidden" name="admin_passwd" value="myel!0303">
			</form>
			<script type="text/javascript">
			document.myel_admin_login.submit();
			</script>
			<?php
		}
	}
	else{
		?>
		<script type="text/javascript">
		alert("누구세요??");
		history.go(-1);
		</script>
		<?php
	}
}
else{
	?>
	<script type="text/javascript">
	alert("아이디와 비밀번호를 정확히 입력해주세요.");
	history.go(-1);
	</script>
	<?php
}
?>