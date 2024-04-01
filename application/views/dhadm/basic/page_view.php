
<?
if($this->uri->segment(3)=="edit"){
	
	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}?>

				<!-- 제품정보 -->
				<h3 class="icon-pen">상세보기</h3>
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
							<td><? if(isset($row->page_index)){ echo $row->page_index; }?></td>
							<th>타이틀</th>
							<td><? echo isset($row->title) ? $row->title : "";?></td>
						</tr>
						<tr>
							<td colspan="4">
							<br>
							<? echo isset($row->content) ? $row->content : "";?>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/basic/page/m/<?=$query_string.$param?>';">
				<input type="button" class="btn-ok btn-xl" value="수정하기" onclick="javascript:location.href='<?=cdir()?>/basic/page/m/edit/<?=$row->idx?>/<?=$query_string.$param?>'">
				<input type="button" class="btn-ok btn-xl" value="삭제하기" onclick="delOk(<?=$row->idx?>)">
				</p>


				<form name="delFrm" method="post" action="<?=cdir()?>/basic/page/m/<?=$query_string?>">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>