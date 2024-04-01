
				<div class="float-wrap mt50">
					<p class="list-adding float-r">
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$month?>월 <?=$day?>일 방문자수 : <a href="#" class="on"><? echo isset($count['today_hit']) ? number_format($count['today_hit']) : "";?></a><br>
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$month?>월 <?=$day?>일 접속횟수 : <a href="#" class="on"><? echo isset($count['today_view']) ? number_format($count['today_view']) : "";?></a>
					</p>
				</div>


				<table class="adm-table v-line align-l" style="border-top:0px;">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:10%;"><col style=""><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
					<?
						$per1=0;
						for($i=0;$i<24;$i++)
						{
						 $per1=(int)($time_count[$i]/$max*100);
						 if($per1>100)$per1=99;
					?>
						<tr>
							<th><?=$i?>시</th>
							<td><img src="/_dhadm/image/icon/count_body.gif" border=0 width=<?=$per1?>% height=20 alt='<?=$i?>시 방문자수 : <?=$time_count[$i]?>'></td>
							<td>&nbsp;<?=$time_count[$i]?></td>
						</tr>
					<?
					 }
					?>
					</thead>
					<tbody class="ft092">
			</tbody>
			</table>