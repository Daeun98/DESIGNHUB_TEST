<?php
/*
** 필요시 활성화 목록 **
우선순위
사용여부
링크주소
*/
?>

<form name="frm" id="frm" method="post">
<input type="hidden" name="idx" value="<?=$idx?>">

	<!-- 제품정보 -->
	<h3 class="icon-pen"><?if($mode=="add"){?>등록<?}else{?>수정<?}?>하기</h3>
	<table class="adm-table mb70">
		<caption>정보를 입력하는 폼</caption>
		<colgroup>
			<col style="width:15%;">
			<col style="width:35%;">
			<col style="width:15%;">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>배너그룹명</th>
				<td><input type="text" class="width-l" name="name" value="<?=(isset($row) and $row->name != "")?$row->name:"";?>"></td>
				<th>코드명(영문)</th>
				<td><input type="text" class="width-l" name="code" value="<?=(isset($row) and $row->code != "")?$row->code:"";?>" <?=($mode == "edit")?"readonly":"";?>></td>
			</tr>
			<!-- <tr>
				<th>우선순위</th>
				<td>
					<select name="sorting" id="">
						<?php
						for($ii=1;$ii<=10;$ii++){
						?>
						<option value="<?=$ii?>" <?if(isset($row) and $row->sorting == $ii) echo "selected";?>><?=$ii?></option>
						<?php
						}
						?>
					</select>
				</td>
				<th>사용여부</th>
				<td>
					<input type="radio" name="used" value="Y" id="used1" <?=($mode == "edit" and $row->used == "Y")?"checked":"checked";?>> <label for="used1">사용</label>
					<input type="radio" name="used" value="N" id="used2" <?=($mode == "edit" and $row->used == "N")?"checked":"";?>> <label for="used2">미사용</label>
				</td>
			</tr>
			<tr>
				<th>Link Url</th>
				<td colspan="3"><input type="text" class="width-l" name="pageurl" value="<?=(isset($row) and $row->pageurl != "")?$row->pageurl:"";?>"></td>
			</tr> -->
		</tbody>
	</table>
	<p class="align-c mt40">
		<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/banner/group/m/';">
		<input type="button" class="btn-ok btn-xl" value="<?if($mode=="add"){?>등록<?}else{?>수정<?}?>하기" onclick="frm_send()">
	</p>

</form>

<script type="text/javascript">
<!--
	function frm_send(){
		frm = document.frm;
		if (frm.name.value == "")
		{
			alert("배너그룹명을 입력해주세요.");
			return;
		}
		if (frm.code.value == "")
		{
			alert("배너그룹명을 입력해주세요.");
			return;
		}
		frm.submit();
	}
//-->
</script>