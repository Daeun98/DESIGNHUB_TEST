<!doctype html> 
<html lang="ko">
 <head>
  <title>제품 재고 수정</title>
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
	<div class="skin-indigo adm-wrap pd20" style="min-width:300px;">
		<h3 class="icon-pen">재고 수정하기</h3>

		<div class="border-box ft-s">
			- 재고수량에 제한이 없으면 '무제한'에 체크해주세요.<br>
			- 0개로 입력하시면 <img src="/_dhadm/image/icon/soldout.gif" alt="품절" class="mid"> 표시 됩니다.
		</div>
		
		<!-- 제품 옵션 설정 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 선택을 위한 테이블</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<thead>
				<tr>
					<th scope="col">옵션</th>
					<th scope="col">재고 수량</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>단일상품</th>
					<td class="align-c">
						<input type="text" class="width-xs"> 개
						<span class="mr10"></span>
						<input type="checkbox" id="unlimited"><label for="unlimited" class="mr0">무제한</label>
					</td>
				</tr>
				<!-- <tr>
					<th>RED</th>
					<td class="align-c">
						<input type="text" class="width-xs"> 개
						<span class="mr10"></span>
						<input type="checkbox" id="unlimited1"><label for="unlimited1" class="mr0">무제한</label>
					</td>
				</tr>
				<tr>
					<th>BLUE</th>
					<td class="align-c">
						<input type="text" class="width-xs"> 개
						<span class="mr10"></span>
						<input type="checkbox" id="unlimited2"><label for="unlimited2" class="mr0">무제한</label>
					</td>
				</tr>
				<tr>
					<th>GREEN</th>
					<td class="align-c">
						<input type="text" class="width-xs"> 개
						<span class="mr10"></span>
						<input type="checkbox" id="unlimited3"><label for="unlimited3" class="mr0">무제한</label>
					</td>
				</tr> -->
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->

		<p class="align-c mt30">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-l btn-ok" value="확인">
		</p>
	</div>
 </body>
</html>