
				<!-- 제품등록 현황 -->
				<div id="product_count">
					<div class="float-wrap">
						<h2 class="float-l">회원 가입 현황</h2>
						<span class="float-r"><a href="<?=cdir();?>/<?=$this->uri->segment(1)?>/user/m" class="button btn-ok">회원리스트 바로가기</a></span>
					</div>
					
					<table class="dash-count mt10">
						<colgroup>
							<col style="width:33.33%;"><col><col style="width:33.33%;">
						</colgroup>
						<tbody>
							<tr>
								<td><em class="opensans"><?=number_format($total_member)?></em>전체 가입 현황</td>
								<td><em class="opensans"><?=number_format($today_member)?></em>오늘 가입 현황</td>
								<td><em class="opensans"><?=number_format($out_member)?></em>탈퇴 현황</td>
							</tr>
						</tbody>
					</table>
				</div><!-- END 제품등록 현황 -->

				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">오늘 가입한 회원 <strong><?=number_format($today_member)?>명</strong></h3>
				</div>

				<table class="adm-table line align-c ">
					<caption>제품 목록</caption>
					<colgroup>
						<col style="width:10%"><col style="width:15%;"><col style="width:13%;"><col style="width:15%;"><col style="width:22%;"><col style="width:10%;"><col style="width:15%;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>아이디</th>
							<th>이름</th>
							<th>연락처</th>
							<th>이메일</th>
							<th>접속회수</th>
							<th>가입일자</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$list_result = 0;
							if($today_member>0){
							$list_result = 1;
							foreach ($list as $lt){ 
						?>
						<tr class="selected">
							<td><?=$today_member?></td>
							<td><?=$lt->userid?></td>
							<td><?=$lt->name?></td>
							<td><?=$lt->phone1?>-<?=$lt->phone2?>-<?=$lt->phone3?></td>
							<td><?=$lt->email?></td>
							<td><?=$lt->connect?></td>
							<td><?=reDate($lt->register,"-")?></td>
						</tr>
						<?
							$today_member--;
							}
							}else{
						?>
						<tr>
							<td colspan="7">오늘 가입한 회원이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>