<!doctype html> 
<html lang="ko">
 <head>
  <title>게시판 순서변경</title>
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
	<script language="JavaScript">
<!--
// 순위 변경 ( up or down )
function cateMove(index,to)
{
	var list = index;
	var total = list.length-1;
	var index = list.selectedIndex;

	if (index==-1){
		alert("글을 선택하세요.");
		return;
	}
	
	if (to == +1 && index == total) return alert('이동이 불가능합니다');
	if (to == -1 && index == 0) return alert('이동이 불가능합니다');
	
	var items = new Array;
	var values = new Array;
	
	for (i = total; i >= 0; i--) {
		items[i] = list.options[i].text;
		values[i] = list.options[i].value;
	}
		
	for (i = total; i >= 0; i--) {
		if (index == i) {
			list.options[i + to] = new Option(items[i],values[i], 0, 1);
			list.options[i] = new Option(items[i + to], values[i + to]);
			i--;
		}
		else
		{
			list.options[i] = new Option(items[i], values[i]);
		}
	}
	return;
}

// 옵션 데이타 입력
function dataInput() {
	var form=document.myform;
	var data_cnt=0;
	form.hidden_bbs_list.value="";
	for( data_cnt=0; data_cnt < form.goods_list.length; data_cnt ++) {
		form.hidden_bbs_list.value =form.hidden_bbs_list.value + form.goods_list.options[data_cnt].value;
		form.hidden_bbs_list.value= form.hidden_bbs_list.value + "&&";
	}
}

// 폼 전송
function sendit(f) {
	if(confirm("정말 저장하시겠습니까?")) {
		dataInput();
		f.submit();
	}
}

//-->
</script>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>게시판 순서 변경 <em>(<?=$row->name?>)</em></h3>

			<form action="?" method="get" name="myform">
			<input type="hidden" name="hidden_bbs_list">
			<input type="hidden" name="ajax" value="1">
			<input type="hidden" name="code" value="<?=$this->input->get("code")?>">
			<input type="hidden" name="cate_idx" value="<?=$this->input->get("cate_idx")?>">
				<table class="adm-table line align-c">
					<caption>게시판 리스트</caption>
					<colgroup>
						<col>
					</colgroup>
					<tbody class="ft092">
						<tr>
							<td>
							<select name="goods_list" size="20" style="width:100%;height:300px;" class="input">
								<?
								$no=0;
								foreach($list as $lt){
									$no++;
								?>
									<option value="<?=$lt->idx?>"><?=$no;?> : <?=$lt->subject;?></option>
								<?}?>
							</select>
							<p style="text-align:right;margin-top:10px;">
							<a href="javascript:cateMove(document.myform.goods_list,-1);;"><img src="/_dhadm/image/icon/bt_up.gif" width="19" height="19" border=0></a>&nbsp;<a href="javascript:cateMove(document.myform.goods_list,1);"><img src="/_dhadm/image/icon/bt_down.gif" width="19" height="19" border=0></a>&nbsp;&nbsp;&nbsp;<a href="javascript:sendit(document.myform);"></a>
							</p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>

		<p class="align-c mt20">
			<input type="button" class="btn-l mr5" value="저장" onclick="sendit(document.myform);">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
		</p>
	</div>
 </body>
</html>