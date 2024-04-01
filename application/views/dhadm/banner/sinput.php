<?php
/*

** 추가항목 (addinfo) 추가 **

이미지 2개중 1개는 숨겨놓음

배너관리에 필요한 추가 항목을 자유자재로 추가할수 있도록 C와 M에 addinfo1 부터 addinfo5 까지 5개의 컬럼을 추가함
테이블에서 컬럼 데이터 유형이나 길이값 조절하여 사용가능

*/

$size_info = "파일을 선택해 주세요.";
?>
<form name="frm" id="frm" method="post" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?=$code?>">
<input type="hidden" name="parent_idx" value="<?=$parent_idx?>">
<input type="hidden" name="sidx" value="<?=$s_idx?>">

	<!-- 제품정보 -->
	<h3 class="icon-pen"><?if($mode=="s_input"){?>등록<?}else{?>수정<?}?>하기</h3>
	<table class="adm-table mb70">
		<caption>정보를 입력하는 폼</caption>
		<colgroup>
			<col style="width:15%;">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>등록그룹코드</th>
				<td><?=($mode == "s_input")?$code:$s_row->parent_code; ?></td>
			</tr>
			<tr>
				<th>이미지</th>
				<td>
					<ul class="file w40">
						<li>
							<input type="file" id="file01" name="upfile1"/><label for="file01" class="btn-file">파일찾기</label>
							<span class="file-name01"><? echo (isset($s_row) and $s_row->upfile1_real != "") ? $s_row->upfile1_real : $size_info;?></span>
						</li>
					</ul>
				</td>
			</tr>
			<tr style="display:none;">
				<th>내용사진</th>
				<td>
					<ul class="file w40">
						<li>
							<input type="file" id="file02" name="upfile2"/><label for="file02" class="btn-file">파일찾기</label>
							<span class="file-name02"><? echo (isset($s_row) and $s_row->upfile2_real != "") ? $s_row->upfile2_real : "1개: 1903 X 410 (px) / 2개이상: 952 X 410 (px)";?></span>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>링크</th>
				<td><input type="text" class="width-xl" name="pageurl" value="<?=(isset($s_row) and $s_row->pageurl != "")?$s_row->pageurl:"";?>"></td>
			</tr>
			<tr>
				<th>우선순위</th>
				<td>
					<select name="sort" id="">
						<?php
						for($ii=1;$ii<=10;$ii++){
						?>
						<option value="<?=$ii?>" <?if(@$s_row->sort == $ii || @$max_rank == $ii) echo "selected";?>><?=$ii?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="align-c mt40">
		<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/banner/group/m/s_add/?code=<?=$code?>&parent_idx=<?=$parent_idx?>';">
		<input type="button" class="btn-ok btn-xl" value="<?if($mode=="s_input"){?>등록<?}else{?>수정<?}?>하기" onclick="frm_send()">
	</p>

</form>

<script type="text/javascript">
<!--
	function frm_send(){
		frm = document.frm;
		<?php
		if ($mode == "s_input"){
		?>
		if (frm.upfile1.value == "")
		{
			alert("이미지를 입력해주세요.");
			return;
		}
		/*
		if (frm.upfile2.value == "")
		{
			alert("내용사진을 입력해주세요.");
			return;
		}
		*/
		<?php
		}
		?>
		frm.submit();
	}

	$(function(){
		$("#file01").change(function(){
			$(".file-name01").text($(this).val());
		});
		$("#file02").change(function(){
			$(".file-name02").text($(this).val());
		});
	});
//-->
</script>