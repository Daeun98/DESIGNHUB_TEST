
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
									<option value="title_bar" <?if($this->input->get('item')=="title_bar"){?>selected<?}?>>타이틀</option>
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
					<h3 class="icon-list float-l">등록 팝업 <strong><?=$totalCnt?>개</strong></h3>
					<p class="list-adding float-r">
					</p>
				</div>


				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<col style="width:50px;"><col style="width:90px;"><col><col style="width:100px;"><col style="width:100px;"><col style="width:80px;"><col style="width:150px;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>출력형태</th>
							<th>브라우저 타이틀바</th>
							<th>시작일</th>
							<th>종료일</th>
							<th>상태</th>
							<th>관리</th>
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
							<td><? if( $lt->display==0 ) { echo('HTML');} else if( $lt->display==1 ) { echo('IMAGES');} else if( $lt->display==2 ) { echo('모바일');}?></td>
							<td><a href="<?=cdir()?>/popup/set/m/edit/<?=$lt->idx?><?=$query_string.$param?>"><?=stripSlashes($lt->title_bar);?></a></td>
							<td><?=$lt->start_day;?></td>
							<td><?=$lt->end_day;?></td>
							<td><? if($lt->end_day < date("Y-m-d")) { echo "종료"; } else if(($lt->start_day <= date("Y-m-d")) && ($lt->end_day >= date("Y-m-d"))) { echo "사용중";} else if($lt->start_day > date("Y-m-d")) { echo "미사용";}?></td>
							<td>
								<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/popup/set/m/edit/<?=$lt->idx?><?=$query_string.$param?>';">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="7">등록된 팝업이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-r">
						<a href="<?=cdir()?>/popup/set/m/write" class="button btn-ok">등록</a></span>
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