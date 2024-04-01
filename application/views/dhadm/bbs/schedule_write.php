<!doctype html> 
<html lang="ko">
 <head>
  <title>스케줄 관리</title>
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
		<h3>스케줄 <? if(isset($row->idx)){?>수정<?}else{?>등록<?}?></h3>
		<form method="post" name="schedule_write" id="schedule_write" onsubmit="return false;">
		<input type="hidden" name="year" value="<?=$year?>">
		<input type="hidden" name="month" value="<?=$month?>">
		<input type="hidden" name="day" value="<?=$day?>">
		<input type="hidden" name="cate_no" value="<?=$cate_no?>">
		<input type="hidden" name="idx" value="<? echo isset($row->idx) && $row->idx ? $row->idx : "";?>">
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 선택을 위한 테이블</caption>
			<colgroup>
				<col style="width:95px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>일자</th>
					<td>
						<?=$year?>-<?=$month?>-<?=$day?>
					</td>
				</tr>
				<? if(isset($cate_stat->idx)){?>
				<tr>
					<th>언어</th>
					<td>
					<?=$cate_stat->title?>
					</td>
				</tr>
				<?}?>
				<tr>
					<th>분류</th>
					<td>
						<input type="radio" name="flag" id="flag1" value="radio" <? if(isset($row->flag) && $row->flag=="radio"){?>checked<?}?>><label for="flag1">라디오</label>
						<input type="radio" name="flag" id="flag2" value="tv" <? if(isset($row->flag) && $row->flag=="tv"){?>checked<?}?>><label for="flag2">TV방송</label>
						<input type="radio" name="flag" id="flag3" value="show" <? if(isset($row->flag) && $row->flag=="show"){?>checked<?}?>><label for="flag3">공연</label>
						<input type="radio" name="flag" id="flag4" value="event" <? if(isset($row->flag) && $row->flag=="event"){?>checked<?}?>><label for="flag4">이벤트</label>
						<input type="radio" name="flag" id="flag5" value="etc" <? if(isset($row->flag) && $row->flag=="etc"){?>checked<?}?>><label for="flag5">기타</label>
					</td>
				</tr>
				<tr>
					<th>제목</th>
					<td>
						<input type="text" class="width-xl" name="subject" value="<? echo isset($row->subject) && $row->subject ? $row->subject : "";?>">
					</td>
				</tr>
				<tr>
					<th>내용</th>
					<td>
						<textarea name="content" id="tx_content" cols="30" rows="3"><? echo isset($row->content) && $row->content ? $row->content : "";?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="align-c mt20">
		<input type="button" class="btn-l btn-ok" value="<? if(isset($row->idx)){?>수정<?}else{?>등록<?}?>" name="writeBtn" onclick="s_write();">
		<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
		</p>
		</form>

	<script>
	function s_write()
	{
		var form = document.schedule_write;

		if($("input[name='flag']:checked").length==0){
			alert("분류를 선택해주세요.");
			return;
		}else if(form.subject.value==""){
			alert("제목을 입력해주세요.");
			form.subject.focus();
			return;
		}else if(form.content.value==""){
			alert("내용을 입력해주세요.");
			form.content.focus();
			return;
		}else{
			form.submit();
			$("input[name='writeBtn'").attr("disabled",true);
		}

	}
	
	</script>

 </body>
</html>