<?php
/*
** 리스트 일반형으로 정리 **
코드명 노출 불필요
우선순위 노출 불필요
사용여부 노출 불필요
수정 / 삭제 디자인허브 IP 로만 우선 활성화
*/
?>

<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>

<div class="float-wrap mt70">
	<h3 class="icon-list float-l">배너그룹관리</h3>
</div>

<table class="adm-table line align-c">
	<caption>유저 목록</caption>
	<thead>
		<tr>
			<th>그룹명</th>
			<!-- <th>코드명</th> -->
			<th>등록된배너수</th>
			<!-- <th>우선순위</th>
			<th>사용여부</th> -->
			<th style="width:200px;">관리</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<?php
		foreach($list as $row)
		{
		?>
		<tr>
			<td><?=$row->name?></td>
			<!-- <td><?=$row->code?></td> -->
			<td><?=$row->num?>개</td>
			<!-- <td><?=$row->sorting?></td>
			<td><?=$row->used?></td> -->
			<td>
				<input type="button" value="배너관리" class="btn-sm2" onclick="javascript:location.href='<?=self_url()?>/s_add/?code=<?=$row->code?>&parent_idx=<?=$row->idx?>';">
				<?php
				if($this->session->userdata('ADMIN_LEVEL')==1){
				?>
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url()?>/edit/<?=$row->idx?>';">
				<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')">
				<?php
				}
				?>
			</td>
		</tr>
		<?php
		}

		if(count($list) <= 0)
		{
		?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-r">
		<a href="<?=self_url()?>/add/" class="button btn-ok">배너그룹등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("삭제하시면 그룹안의 모든 배너가 삭제됩니다.\n\n정말 삭제하시겠습니까?")){
			location.href = "/html/banner/group/m/del/"+idx;
		}
	}
//-->
</script>