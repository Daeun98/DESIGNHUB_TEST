
<!doctype html> 
<html lang="ko">
 <head>
  <title>쿠폰 관리</title>
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
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	
	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	h3 em { font-size:12.5px;}
	.adm-table td a { color:#09569c; }
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>쿠폰 이용 내역 <em>( 쿠폰코드 : <?=$row->code?> )</em></h3>

		<h4 class="mt40">· 쿠폰 이용 리스트 <p class="list-adding float-r">Total : <a class="on"><?=number_format($couponCnt)?></a>개</p></h4>

				<table class="adm-table line align-c">
					<caption>쿠폰 사용 내역</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:25%;"><col style="width:25%;"><col style="width:30%;">
					</colgroup>
					<thead>
						<tr>
							<th>아이디</th>
							<th>발급일자</th>
							<th>사용일자</th>
							<th>거래번호</th>
						</tr>
						<?
							foreach ($list as $lt){ 
						?>
						<tr>
							<td><?=$lt->userid?></td>
							<td><?=substr($lt->reg_date,0,10)?></td>
							<td><? if($lt->use_date=="0000-00-00 00:00:00"){?>미사용<?}else{?><font color="red"><?=substr($lt->use_date,0,10)?></font><?}?></td>
							<td><?=$lt->trade_code?></td>
						</tr>
						<?
						 }
						?>
					</thead>
					<tbody class="ft092">
					</tbody>
				</table>

		<p class="align-c mt40">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
		</p>
	</div>
 </body>
</html>