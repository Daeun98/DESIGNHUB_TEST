<!doctype html> 
<html lang="ko">
 <head>
  <title>포인트 관리</title>
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
		<h3>포인트 관리 <em>(<?=$mem_row->userid?>)</em></h3>

		<h4 class="mt25">· 포인트 설정</h4>
		
		<form method="post" name="point_write" id="point_write">
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 선택을 위한 테이블</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>내용</th>
					<td>
						<input type="text" name="content" class="width-l" msg="내용을">
					</td>
				</tr>
				<tr>
					<th>포인트</th>
					<td>
						<select name="sum" id="sum">
							<option value="+">+</option>
							<option value="-">-</option>
						</select>
						<input type="text" name="point" msg="포인트를"> P 
						&nbsp;<input type="button" class="btn-ok" value="추가" onclick="frmChk('point_write');">
					</td>
				</tr>
			</tbody>
		</table>
		</form>


		<h4 class="mt40">· 포인트 사용 내역 <p class="list-adding float-r">Total :<a class="on"><?=number_format($total_point)?></a>P</p></h4>

				<table class="adm-table line align-c">
					<caption>포인트 사용 내역</caption>
					<colgroup>
						<col><col style="width:65px;"><col style="width:90px;"><col style="width:50px;">
					</colgroup>
					<thead>
						<tr>
							<th>사용내역정보</th>
							<th>포인트</th>
							<th>거래일자</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<? foreach($list as $lt){ ?>
						<tr>
							<td><?=$lt->content?><?if($lt->flag=="trade" && $lt->flag_idx){?> 거래번호 : <a href="<?=cdir()?>/order/lists/all/m/?view=1&idx=<?=$lt->flag_idx?>" target="_blank"><?=$lt->trade_code?></a><?}?></td>
							<td><?=number_format($lt->point)?> P</td>
							<td><?=strDateCut($lt->reg_date,3)?></td>
							<td><input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>);"></td>
						</tr>
						<?}?>
					</tbody>
				</table>

		<p class="align-c mt40">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
		</p>
	</div>

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>

 </body>
</html>