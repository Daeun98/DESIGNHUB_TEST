
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
							<th>날짜</th>
							<td>
								<select name="year">
									<? for($i=date("Y"); $i>=date("Y")-2; $i--){
										if($i==$year){ $year_sel = "selected"; }else{	$year_sel = "";}
									?>
										<option value="<?=$i?>" <?=$year_sel?>><?=$i?></option>
									<?}?>
								</select> 년&nbsp;
								<select name="month">
									<?
									for($i=1; $i<=12; $i++){
										if($i==$month){ $month_sel = "selected"; }else{ $month_sel = ""; }
									?>
										<option value="<?=$i?>" <?=$month_sel?>><?=$i?></option>
									<?}?>
								</select> 월&nbsp;
								<select name="day">
									<?
									for($i=1; $i<=31; $i++){
										if($i==$day){ $day_sel = "selected"; }else{ $day_sel = ""; }
									?>
										<option value="<?=$i?>" <?=$day_sel?>><?=$i?></option>
									<?}?>
								</select> 일&nbsp;
								&nbsp;<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

