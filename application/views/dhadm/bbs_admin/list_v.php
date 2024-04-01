<h3 class="icon-list">목록</h3>

				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<thead>
						<tr>
							<th>번호		</th>
							<th>이름		</th>
							<th>코드		</th>
							<th>타입		</th>
							<th>자료실	</th>
							<th>접근		</th>
							<th>쓰기		</th>
							<th>읽기		</th>
							<th>관리		</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?php
						$number = 0;
						foreach($list as $lt){
							$number++;
							?>
						<tr>
							<td><?php echo $number?></td>
							<td><?php echo $lt->name?></td>
							<td><?php echo $lt->code?></td>
							<td>
							<?php
							switch($lt->bbs_type){
								case "1": echo "일반게시판"; break;
								case "3": echo "사진게시판"; break;
								case "4": echo "질문답변게시판"; break;
								case "5": echo "이벤트게시판"; break;
							}
							?>
							</td>
							<td>
							<?php
							switch($lt->bbs_pds){
								case "0": echo "미사용"; break;
								case "1": echo "사용함"; break;
							}
							?>
							</td>
							<td>
							<?php
							switch($lt->bbs_access){
								case "0": echo "비회원"; break;
								case "1": echo "회원"; break;
							}
							?>
							</td>
							<td>
							<?php
							switch($lt->bbs_write){
								case "1": echo "비회원"; break;
								case "2": echo "회원"; break;
								case "9": echo "관리자"; break;
							}
							?>
							</td>
							<td>
							<?php
							switch($lt->bbs_read){
								case "0": echo "비회원"; break;
								case "1": echo "회원"; break;
							}
							?>
							</td>
							<td>
								<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='/html/dhadm/bbs/edit/<?=$lt->idx?>';">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="javascript:if(confirm('게시판을 삭제하시겠습니까?\n삭제하실 경우 복구할 수 없습니다.')){location.href='/html/dhadm/bbs/del/<?=$lt->idx?>'};">
							</td>
						</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-r">
						<a href="/html/dhadm/bbs/add/" class="button btn-ok">게시판 등록</a></span>
					</div>
				</div><!-- END 제품 액션 버튼 -->

				<!-- END 제품리스트 -->

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>