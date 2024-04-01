<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "member";
	
	if(isset($flag) && $flag=="ago"){
		$ago="1";
	}else{
		$ago="";
	}

	Header("Content-type: application/vnd.ms-excel"); 
	Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls"); 
	Header("Content-Description: PHP5 Generated Data"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">"); 

?>
<style>
.xTxt{mso-number-format:"\@";}
td{font-size:11px;}
.xTxtF{color:red;}
</style>
<table width=1000 cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
<Tr align=center height=30 bgcolor="#EFEFEF">
	<td width=100>No</td>
	<td width=100>아이디</td>
	<td width=100>이름</td>
	<td width=80>등급</td>
	<td width=100>전화번호</td>
	<td width=150>메일주소</td>
	<td>우편번호</td>
	<td width=300>주소</td>
	<td width=150>가입일</td>
	<? if($ago==1){ ?>
		<td width=150>최종접속일</td>
	<?}?>
	<!--td>추천인</td-->
	<td width=80>접속수</td>
	
<? 
	$intN = 1;
		foreach ($list as $row){ 
		$tmpN = str_pad( $intN, 5, "0", STR_PAD_LEFT );
?>

<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
	<td class='xTxt'><?=$tmpN?></td>
	<td><?=$row->userid?></td>
	<td><?=$row->name?></td>
	<td><?=$row->level_name?></td>
	<td><?=$row->phone1?>-<?=$row->phone2?>-<?=$row->phone3?></td>
	<td><?=$row->email?></td>
	<td><?=$row->zip1?>-<?=$row->zip2?></td>
	<td><?=$row->add1?> <?=$row->add2?></td>
	<td class='xTxt'><?=$row->register?></td>
	<? if($ago==1){ ?>
		<td><?=$row->last_login?></td>
	<?}?>
	<td><?=$row->connect?></td>
<?		$intN++;
	}
	?>
</table>