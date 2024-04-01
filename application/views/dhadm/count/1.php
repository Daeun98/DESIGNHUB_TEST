				<div class="float-wrap mt70"><h3 class="icon-list float-l">총 접속통계 </h3></div>
				<div class="float-wrap">
				<div id="product_count">
					
					<table class="dash-count mt10">
						<colgroup>
							<col style="width:33.33%;"><col><col style="width:33.33%;">
						</colgroup>
						<tbody>
							<tr>
								<td><em class="opensans"><? echo isset($count['total_hit']) ? number_format($count['total_hit']) : "";?></em>전체 방문자수</td>
								<td><em class="opensans"><? echo isset($count['total_view']) ? number_format($count['total_view']) : "";?></em>전체 접속횟수</td>
								<td><em class="opensans"><? echo isset($count['today_hit']) ? number_format($count['today_hit']) : "";?></em>오늘 방문자수</td>
							</tr>
							<tr>
								<td><em class="opensans"><? echo isset($count['today_view']) ? number_format($count['today_view']) : "";?></em>오늘 접속횟수</td>
								<td><em class="opensans"><? echo isset($count['yesterday_hit']) ? number_format($count['yesterday_hit']) : "";?></em>어제 방문자수</td>
								<td><em class="opensans"><? echo isset($count['yesterday_view']) ? number_format($count['yesterday_view']) : "";?></em>어제 접속횟수</td>
							</tr>
						</tbody>
					</table>
				</div>
				</div>