<?php
$code = $this->uri->segment(3);
$mode = $this->uri->segment(4);
$idx = $this->uri->segment(5);
$listurl = "/html/board/bbs/".$code;
?>
<form name="frm" id="frm" method="post" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<?php
if($mode=="edit"){
	?>
	<input type="hidden" name="idx" value="<?php echo $idx; ?>">
	<?php
	}
?>
<h3 class="icon-pen"><?php echo ($mode=="edit")?"수정":"등록";?>하기</h3>
<table class="adm-table mb70">
	<caption>정보를 입력하는 폼</caption>
	<colgroup>
		<col style="width:15%;">
		<col>
	</colgroup>
	<tbody>
		<tr>
			<th>제목</th>
			<td><input type="text" class="width-xl" name="subject" <?php if($mode == "edit"){ echo "value=".$row->subject; } ?> msg="제목을"></td>
		</tr>
		<tr>
			<th>공지</th>
			<td><input type="checkbox" name="notice" id="notice" value="1" <?php if($mode == "edit" && $row->notice == "1"){ echo "checked"; }?>> <label for="notice"><small>- 이 글을 공지글로 작성합니다</small></label> </td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><input type="text" class="width-s" name="name" value="<?php echo ($mode == "add")?$this->session->userdata["ADMIN_NAME"]:$row->name; ?>" msg="작성자를"></td>
		</tr>
		<tr>
			<th>작성일</th>
			<td><input type="text" class="width-s" name="reg_date" id="start_date" readonly msg="작성일을" value="<?php echo ($mode == "add")?date("Y-m-d"):date("Y-m-d", strtotime($row->reg_date)); ?>"></td>
		</tr>

		<tr>
			<th>내용</th>
			<td><textarea name="content" id="tx_content" style="width:100%; height:412px; display:none;"><?php echo ($mode == "edit")?$row->content:""; ?></textarea></td>
		</tr>
	</tbody>
</table>
<p class="align-c mt40">
<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?php echo $listurl; ?>';">
<input type="button" class="btn-ok btn-xl" value="<?php echo ($mode=="edit")?"수정":"등록";?>하기" onclick="frmChk('frm','editor');">
</p>

</form>

<script type="text/javascript" src="/_data/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">

var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "tx_content",
	sSkinURI: "/_data/smarteditor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["tx_content"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});
</script>