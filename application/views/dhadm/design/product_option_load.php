<!doctype html> 
<html lang="ko">
 <head>
  <title>옵션 불러오기</title>
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
	
	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>옵션 불러오기</h3>
		
		<!-- 제품 옵션 설정 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 선택을 위한 테이블</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>옵션명</th>
					<td>
						<select name="" id="">
							<option value="">옵션을 선택하세요.</option>
							<option value="">색상옵션1</option>
							<option value="">색상옵션2</option>
							<option value="">등록한 옵션명</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>옵션코드</th>
					<td><span class="ft-s">옵션을 선택하세요.</span>
						<!-- option0001 -->
					</td>
				</tr>
				<tr>
					<th>옵션항목</th>
					<td>
						<div class="opt-setting-box">
							<!-- <p class="align-c ft-s pt60">옵션을 선택하세요.</p> -->
							<ul class="opt-setting">
								<li>RED</li>
								<li>BLUE</li>
								<li>GREEN</li>
								<li>NAVY</li>
								<li>VIOLET</li>
								<li>PINK</li>
								<li>ORANGE</li>
								<li>GREY</li>
								<li>DARK BLUE</li>
								<li>YELLOW</li>
							</ul>
						</div>
						<p class="mt10 ft-s mb5">* 항목변경은 <a href="http://dhadm.myelhub.com/html/dhadm/product_option.php?d=1" target="_blank" class="ft-blue underline">옵션관리</a>에서 가능합니다.</p>
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->

		<p class="align-c mt30">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-l btn-ok" value="확인">
		</p>
	</div>
 </body>
</html>