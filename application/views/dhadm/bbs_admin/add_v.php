<?php
if($this->uri->segment(3) == 'edit'){
	if($this->uri->segment(4) == ''){
		alert('/html/dhadm/bbs','고유값 누락 : IDX');
	}

	$idx = $this->uri->segment(4);
}
?>
<form name="frm" id="frm" method="post" enctype="multipart/form-data">
	<?php
	if($this->uri->segment(3) == 'edit'){
	?>
	<input type="hidden" name="idx" value="<?=$idx?>">
	<?php
	}
	?>

	<h3 class="icon-pen"><?if($this->uri->segment(3)=="add"){?>등록<?}else{?>수정<?}?>하기</h3>
	<table class="adm-table mb70">
		<caption>게시판생성하기</caption>
		<colgroup>
			<col style="width:15%;">
			<col style="width:35%;">
			<col style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
			<tr>
				<th>게시판명</th>
				<td><input type="text" class="width-l" name="name" msg="게시판명" <?php if(isset($bbs->name)){?>value="<?php echo $bbs->name;?>"<?}?>></td>
				<th>게시판코드<?php if($this->uri->segment(3) == 'edit'){ echo '<br><span style="color:red;">(수정불가)</span>'; }?></th>
				<td><input type="text" class="width-l" name="code" <? if($this->uri->segment(3)=="add"){?> msg="게시판코드를"<?}else{?> value="<?php echo $bbs->code;?>" readonly <?}?>></td>
			</tr>

			<tr>
				<th>게시판타입</th>
				<td>
					<select name="bbs_type" onchange="artCheck()">
						<option value="1">일반게시판</option>
						<option value="3">사진게시판</option>
						<option value="4">질문답변게시판</option>
						<option value="5">이벤트게시판</option>
					</select>
					<script type="text/javascript">
					<!--
						bbs_type = document.frm.bbs_type;
						for(i=0;i<bbs_type.length;i++){
							if(bbs_type.options[i].value == "<?=$bbs->bbs_type?>"){
								bbs_type.options[i].selected = true;
							}
						}
					//-->
					</script>
				</td>
				<th>비밀글기능</th>
				<td>
					<input type="radio" name="bbs_secret" value="1" <? if(isset($bbs->bbs_secret) && $bbs->bbs_secret == 1){ echo "checked"; }?>> 사용함
					<input type="radio" name="bbs_secret" value="0" <? if(isset($bbs->bbs_secret) && $bbs->bbs_secret == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_coment)){ echo "checked"; }?>> 사용안함
				</td>
			</tr>

			<tr>
				<th>자료실사용</th>
				<td>
					<input type="radio" name="bbs_pds" value="1" <? if(isset($bbs->bbs_pds) && $bbs->bbs_pds == 1){ echo "checked"; }?>> 사용함
					<input type="radio" name="bbs_pds" value="0" <? if(isset($bbs->bbs_pds) && $bbs->bbs_pds == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_pds)){ echo "checked"; }?>> 사용안함
				</td>
				<th>코멘트기능</th>
				<td>
					<input type="radio" name="bbs_coment" value="1" <? if(isset($bbs->bbs_coment) && $bbs->bbs_coment == 1){ echo "checked"; }?>> 사용함
					<input type="radio" name="bbs_coment" value="0" <? if(isset($bbs->bbs_coment) && $bbs->bbs_coment == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_coment)){ echo "checked"; }?>> 사용안함
				</td>
			</tr>

			<tr>
				<th>접근권한</th>
				<td>
					<input type="radio" name="bbs_access" value="0" <? if(isset($bbs->bbs_access) && $bbs->bbs_access == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_access)){ echo "checked"; }?>> 비회원
					<input type="radio" name="bbs_access" value="1" <? if(isset($bbs->bbs_access) && $bbs->bbs_access == 1){ echo "checked"; }?>> 회원
				</td>
				<th>일기권한</th>
				<td>
					<input type="radio" name="bbs_read" value="0" <? if(isset($bbs->bbs_read) && $bbs->bbs_read == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_read)){ echo "checked"; }?>> 비회원
					<input type="radio" name="bbs_read" value="1" <? if(isset($bbs->bbs_read) && $bbs->bbs_read == 1){ echo "checked"; }?>> 회원
				</td>
			</tr>

			<tr>
				<th>쓰기권한</th>
				<td>
					<input type="radio" name="bbs_write" value="1" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 1){ echo "checked"; }?>> 비회원
					<input type="radio" name="bbs_write" value="2" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 2){ echo "checked"; }?>> 회원
					<input type="radio" name="bbs_write" value="9" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 9){ echo "checked"; }?> <? if(empty($bbs->bbs_write)){ echo "checked"; }?>> 관리자
				</td>
				<th>가로목록수</th>
				<td>
					<input name="list_width" type="text" size="4" class="write_title2" style="text-align: center" value="<? echo isset($bbs->list_width) ? $bbs->list_width : '';?>"> 개 (갤러리형 경우)
					<script language="javascript">
						<? if(isset($bbs->bbs_type) && $bbs->bbs_type == 3){?>
							document.bbs_reg_form.list_width.disabled = false;
						<?}else{?>
							document.bbs_reg_form.list_width.disabled = true;
						<?}?>
					</script>
				</td>
			</tr>

			<tr>
				<th>리스트수</th>
				<td><input name="list_height" type="text" size="10" class="write_title2" value="<? echo isset($bbs->list_height) ? $bbs->list_height : '15';?>" style="text-align: center" >줄(갤러리는 개수)</td>
				<th>페이지수</th>
				<td><input name="list_page" type="text" size="10" class="write_title2" value="<? echo isset($bbs->list_page) ? $bbs->list_page : '10';?>" style="text-align: center">페이지</td>
			</tr>

			<tr>
				<th>에디터사용</th>
				<td><input type="checkbox" name="editor" value="1" <? if(isset($bbs->editor) && $bbs->editor == 1){ echo "checked"; }?> <? if(empty($bbs->editor)){ echo "checked"; }?>> 사용함</td>
				<th></th>
				<td></td>
			</tr>

		</tbody>
	</table>
	<p class="align-c mt40">
	<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='/html/dhadm/bbs';">
	<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(3)=="add"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk('frm');">
	</p>

</form>