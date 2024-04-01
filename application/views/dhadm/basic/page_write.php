
<?
if($this->uri->segment(4)=="edit"){

	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>Page Index</th>
							<td><? if(isset($row->page_index)){ echo $row->page_index; }else{?><input type="text" class="width-l" name="page_index" msg="page index를" value=""><?}?></td>
							<th>타이틀</th>
							<td><input type="text" class="width-l" name="title" msg="타이틀을" value="<? echo isset($row->title) ? $row->title : "";?>"></td>
						</tr>
						<tr>
							<td colspan="4">
							<textarea name="tx_content" id="tx_content" style="width:100%; height:412px; display:none;"><? echo isset($row->content) ? $row->content : "";?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/basic/page/m/<?=$query_string?>';">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk('frm','editor');">
				</p>

			</form>

<script type="text/javascript" src="/_data/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('tx_content');
</script>