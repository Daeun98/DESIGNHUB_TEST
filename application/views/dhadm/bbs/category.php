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



	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">

<h3>카테고리 관리</h3>


		<!-- 제품 옵션 설정 테이블 -->
		<table class="adm-table v-line mt15">
			<tbody>
				<tr>
					<th>No</th>
					<th>IDX</th>
					<th>카테고리명</th>
					<th>관리</th>
				</tr>
				
				<?
					$cnt=0;
					foreach($list as $list){
						$cnt++;
				?>
				<tr align="center">
					<td height="25"><?=$cnt?></td>
					<td><?=$list->idx?></td>
					<td align="left" style="padding:0 7px 0 7px"><?=$list->name?></td>
					<td>
						<input type="button" class="btn-sm" value="수정" id="reply_img" onclick="javascript:edit('<?=$list->idx?>','<?=$list->name?>')">
						<input type="button" class="btn-sm btn-alert" value="삭제" id="reply_img" onclick="javascript:location.href='<?=cdir()?>/dhadm/category/<?=$list->code?>/<?=$list->idx?>/?del=1'">
					</td>
				</tr>
				<?}?>
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->
		<br><br>

			<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor='#dddddd' class="free_board_add" style="margin-left:3px;;">
				<form name="write_Form" method="post" >
				<input type="hidden" name="mm" value="w">
				<input type="hidden" name="idx" value="">
				<tr>
					<th align="center">
						* 카테고리 이름 : <input type="text" name="name" class="write_title4"> <input type="button" class="board_bt_style03 write" value="등록" onclick="javascript:write_chk('write')">
						<input type="button" class="board_bt_style03 edit" value="수정" onclick="javascript:write_chk('edit')" style="display:none;"> <a href="javascript:write();"><img src="/_data/image/board_img/bt_delete.gif" style="display:none;" class="edit"></a>
					</th>
				</tr>
				</form>
			</table>


</div>
  
  
<script language="javascript">
<!--
	function write_chk(mode){
		var frm	=	document.write_Form;


		if(frm.name.value==''){
			alert('카테고리 이름을 입력해 주세요.');
			frm.name.focus();
		}else{

			
			if(mode == "edit"){
				frm.mm.value="e";
			}else if(mode == "write"){
				frm.mm.value="w";
			}

			frm.submit();
		}
	}


	function edit(idx,name){
			var frm	=	document.write_Form;
		
			frm.idx.value=idx;
			frm.name.value=name;

			$(".write").hide();
			$(".edit").show();

	}

	function write()
	{
			var frm	=	document.write_Form;
		
			frm.idx.value='';
			frm.name.value='';

			$(".edit").hide();
			$(".write").show();
	}
//-->
</script>

 </body>
</html>
