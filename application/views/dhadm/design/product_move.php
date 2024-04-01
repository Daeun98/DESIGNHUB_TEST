<!doctype html> 
<html lang="ko">
 <head>
  <title>제품관리 - 제품 이동하기</title>
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
	<div class="skin-indigo adm-wrap pd20" style="min-width:600px;">
		<h3>제품 이동하기</h3>

		<p class="border-box">총 <strong>10</strong>개의 제품이 선택되었습니다.</p>
		
		<!-- 카테고리 선택 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품이 이동할 카테고리를 선택하기 위한 테이블</caption>
			<colgroup>
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
			</colgroup>
			<thead>
				<tr>
					<th scope="col">1차 카테고리</th>
					<th scope="col">2차 카테고리</th>
					<th scope="col">3차 카테고리</th>
					<th scope="col">4차 카테고리</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul>
								<li><a href="#">의류</a></li>
								<li><a href="#" class="on">신발</a></li>
								<li><a href="#">악세사리</a></li>
								<li><a href="#">가방</a></li>
								<li><a href="#">기타</a></li>
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul>
								<li><a href="#" class="on">펌프스</a></li>
								<li><a href="#">플랫슈즈</a></li>
								<li><a href="#">부츠</a></li>
								<li><a href="#">운동화</a></li>
								<li><a href="#">실내화</a></li>
								<li><a href="#">아동화</a></li>
								<li><a href="#">남성화</a></li>
								<li><a href="#">기타</a></li>
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul>
								<li><a href="#">로우힐(1~3cm)</a></li>
								<li><a href="#" class="on">미들힐(3~7cm)</a></li>
								<li><a href="#">하이힐(7cm~)</a></li>
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul>
								<li><a href="#" class="on">천연가죽</a></li>
								<li><a href="#">인조가죽</a></li>
								<li><a href="#">에나멜</a></li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table><!-- END 카테고리 선택 테이블 -->

		<p class="tint-box pt20 pb20">
			<strong>HOME &gt; 신발 &gt; 펌프스 &gt; 미들힐(3~7cm) &gt; 천연가죽</strong>
		</p>

		<p class="align-c ft092 mt25">선택한 제품을 위 카테고리로 이동합니다.</p>
		<p class="align-c mt20">
			<input type="button" class="btn-xl btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-xl btn-ok" value="확인">
		</p>
	</div>
 </body>
</html>