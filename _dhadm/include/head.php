<!doctype html> 
<html lang="ko">
 <head>
  <title>eShop 관리자모드</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>

 </head>

 <body>
<?
	//기본 변수 선언
	$Cagetory="";	//for 글로벌메뉴(gnb)
	$PageName="";	//for 서브메뉴(snb)
	$GlobalSkin="skin-indipink"; //스킨 클래스명(setting_global.php 의 radio id와 동일)
?>
 <!--Wrap-->
 <div id="wrap" class="<?=$GlobalSkin?>">