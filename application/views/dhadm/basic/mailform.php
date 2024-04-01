<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>
				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>			
						<tr>
							<th>검색</th>
							<td>
								<select name="item">
									<option value="subject" <?if($this->input->get('item')=="subject"){?>selected<?}?>>타이틀</option>
								</select>
								<input type="text" name="val" class="width-l" value="<?=$this->input->get('val')?>">
								<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 페이지 <strong><?=$totalCnt?>개</strong></h3>
					<p class="list-adding float-r">
					</p>
				</div>

				
				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<col style="width:100px;"><col><col style="width:150px;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>타이틀</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){ 
						?>
						<tr>
							<td><?=$totalCnt?></td>
							<td><?=$lt->subject?></td>
							<td>
								<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url()?>/edit/<?=$lt->idx?>/<?=$query_string.$param?>';">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="7">등록된 내용이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-r">
						<!-- <a href="<?=self_url()?>/write/" class="button btn-ok">메일폼 등록</a></span> -->
					</div>
				</div><!-- END 제품 액션 버튼 -->

			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page?>
				</p><!-- END Pager -->
			<?}?>
				
				<!-- END 제품리스트 -->

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>