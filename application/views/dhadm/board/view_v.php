<?php
$mode = $this->uri->segment(4);
$code = $this->uri->segment(3);
$listurl = "/html/board/bbs/".$code;
?>
<form name="frm" id="frm" method="post" enctype="multipart/form-data">
<h3 class="icon-search">보기</h3>
<table class="adm-table mb70">
	<caption>정보를 입력하는 폼</caption>
	<colgroup>
		<col style="width:15%;">
		<col>
	</colgroup>
	<tbody>
		<tr>
			<th>제목</th>
			<td><?php echo $row->subject?></td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><?php echo $row->name?></td>
		</tr>
		<tr>
			<th>작성일</th>
			<td><?php echo $row->reg_date?></td>
		</tr>

		<tr>
			<th>내용</th>
			<td><?php echo $row->content?></td>
		</tr>
	</tbody>
</table>
<p class="align-c mt40">
<input type="button" class="btn-m btn-xl" value="목록" onclick="javascript:location.href='<?php echo $listurl; ?>';">
<input type="button" class="btn-ok btn-xl" value="수정" onclick="javascript:location.href='<?php echo $listurl."/edit/".$row->idx; ?>';">
<input type="button" class="btn-ok btn-xl" value="삭제" onclick="javascript:if(confirm('정말 삭제 하시겠습니까?')){location.href='<?php echo $listurl."/del/".$row->idx; ?>'};">
</p>

</form>