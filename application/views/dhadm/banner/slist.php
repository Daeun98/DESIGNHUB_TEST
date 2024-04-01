<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>

<div class="float-wrap mt70">
	<h3 class="icon-list float-l"><?=$parent_info->name?></h3>
	<p class="float-r">배너등록/수정/삭제</p>
</div>


<table class="adm-table line align-c">
	<caption>유저 목록</caption>
	<thead>
		<tr>
			<th>코드</th>
			<th>이미지</th>
			<!-- <th>이미지2</th> -->
			<th>우선순위</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<?php
		foreach($s_list as $row)
		{
		?>
		<tr>
			<td><?=$row->parent_code?></td>
			<td><img src="/_data/file/banner/<?=$row->upfile1?>" width="100" onclick="window.open('/_data/file/banner/<?=$row->upfile1?>','','width=560,height=315,scrollbars=yes,resizeable=yes')"></td>
			<!-- <td><img src="/_data/file/banner/<?=$row->upfile2?>" width="150" onclick="window.open('/_data/file/banner/<?=$row->upfile2?>','','width=560,height=315,scrollbars=yes,resizeable=yes')"></td> -->
			<td><?=$row->sort?></td>
			<td>
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='/banner/group/m/s_edit/?code=<?=$code?>&s_idx=<?=$row->idx?>';">
				<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')">
			</td>
		</tr>
		<?php
		}

		if(count($s_list) <= 0)
		{
		?>
		<tr>
			<td colspan="10">등록된 내용이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-l">
		<a href="/banner/group/m/" class="button">배너그룹 목록</a></span>
	</div>
	<div class="float-r">
		<a href="/banner/group/m/s_input/?code=<?=$code?>&parent_idx=<?=$parent_idx?>" class="button btn-ok">배너등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href = "/banner/group/m/s_del/?s_idx="+idx;
		}
	}
//-->
</script>