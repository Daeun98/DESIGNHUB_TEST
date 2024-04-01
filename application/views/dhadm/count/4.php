
				<div class="float-wrap mt50">
					<p class="list-adding float-r">
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$month?>월 방문자수 : <a href="#" class="on"><? echo isset($total_month_counter[0]) ? number_format($total_month_counter[0]) : 0;?></a><br>
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$month?>월 접속횟수 : <a href="#" class="on"><? echo isset($total_month_counter[1]) ? number_format($total_month_counter[1]) : 0;?></a>
					</p>
				</div>


				<table class="adm-table v-line align-l" style="border-top:0px;">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:9%;"><col style=""><col style="width:13%;">
					</colgroup>
					<thead>
					<tbody class="ft092">
						<? 
						foreach ($list as $lt){ 
						 $per1=$lt->unique_counter/$max[0]*100;
						 $per2=$lt->pageview/$max[1]*100;
						?>
						<tr>
							<th><?=date("d 일",$lt->date)?></th>
							<td>
							<img src="/_dhadm/image/icon/count_body.gif" border=0 width=<?=$per1?>% height=20 alt='방문자수 : <?=$lt->unique_counter?>'><br>
							<img src="/_dhadm/image/icon/count_body2.gif" border=0 width=<?=$per2?>% height=20 alt='접속횟수 : <?=$lt->pageview?>'>
							</td>
							<td>방문자수 : <?=$lt->unique_counter?><br><font color=#A92B05>접속횟수 : <?=$lt->pageview?></font></td>
						</tr>
						<?}?>
					</thead>
				</tbody>
			</table>