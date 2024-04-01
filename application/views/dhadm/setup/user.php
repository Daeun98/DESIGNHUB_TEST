
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
							<th>분류</th>
							<td>
								<select name="level">
									<option value="">전체</option>
									<option value="1" <?if($this->input->get('level')=="1"){?>selected<?}?>>슈퍼관리자</option>
									<option value="2" <?if($this->input->get('level')=="2"){?>selected<?}?>>업체관리자</option>
									<option value="3" <?if($this->input->get('level')=="3"){?>selected<?}?>>기타관리자</option>
								</select>
							</td>
						</tr>					
						<tr>
							<th>유저검색</th>
							<td>
								<select name="item">
									<option value="userid" <?if($this->input->get('item')=="userid"){?>selected<?}?>>아이디</option>
									<option value="name" <?if($this->input->get('item')=="name"){?>selected<?}?>>이름</option>
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
					<h3 class="icon-list float-l">총 <strong><?=number_format($totalCnt)?>명</strong></h3>
					<p class="list-adding float-r">
					</p>
				</div>

				
				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<col><col style="width:150px;"><col style="width:150px;"><col><col><col style="width:120px;"><col style="width:160px;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>아이디</th>
							<th>이름</th>
							<th>level</th>
							<th>접속수</th>
							<th>등록일</th>
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
							<td><?=$lt->userid?></td>
							<td class="pr0"><?=$lt->name?></td>
							<td><?
								if($lt->level==1){
									echo "슈퍼관리자";
								}else if($lt->level==2){
									echo "업체관리자";
								}else if($lt->level==3){
									echo "기타관리자";
								}
								?></td>
							<td><?=$lt->connect?></td>
							<td><?=reDate($lt->reg_date,'-')?></td>
							<td>
								<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url()?>/edit/<?=$lt->idx?>/<?=$query_string?>';">
								<? if($lt->level==3){ ?>
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
								<?}?>
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
						<a href="<?=self_url()?>/write/" class="button btn-ok">관리자 등록</a></span>
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