<? $nyear = date("Y"); ?>

				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col>
					</colgroup>
					<tbody>
						<tr>
							<td>
								<select name="year" id="year" style="min-width:90px;" class="mr5">
									<option value="">년도</option>
									<? for($i=$nyear;$i>=2016;$i--){?>
									<option value="<?=$i?>" <? if($year==$i){?>selected<?}?>><?=$i?>년</option>
									<?}?>
								</select>
								<select name="month" id="month" style="min-width:90px;" class="mr5">
									<option value="">월</option>
									<? for($i=1;$i<=12;$i++){?>
									<option value="<?=$i?>" <? if($month==$i){?>selected<?}?>><?=$i?>월</option>
									<?}?>
								</select>
								<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

				<div class="float-wrap mt50 ">
				<h3 class="icon-list float-l">총 결제 완료 금액은 <strong style="color:red;"><? if($this->input->get("lan")=="en"){?><?=$total_price?> $<?}else{?><?=number_format($total_price)?></strong>원<?}?> 입니다.</h3>
				<p class="float-r" style="font-size:0.9em;">
					※ 실 결제 금액에 대한 합계입니다.
				</p>
				</div>

				<style>
				.total-table th,.total-table td { border:1px solid #ddd; }
				</style>

				<table class="adm-table total-table line align-c mb30">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:6%"><col style="width:15%"><col style=""><col style="width:10%;"><!-- <col style="width:10%;"> --><col style="width:10%"><col style="width:12%;"><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th>No</th>
							<th>주문번호</th>
							<th>주문상품</th>
							<th>결제금액</th>
							<!-- <th>할인금액</th> -->
							<th>구매자명</th>
							<th>ID</th>
							<th>일자</th>
						</tr>
					</thead>
					<tbody class="ft092" style="font-weight:normal;">
						<?
						$t_cnt=0;
						$cnt=0;
						foreach($list as $lt){
							$t_cnt++;
						?>
						<tr>
							<td><?=$totalCnt?></td>
							<td><?=$lt->trade_code?></td>
							<td class="title">
								<?=$goods_arr[$cnt]['goods_name']?>
							</td>
							<td><? if($this->input->get("lan")=="en"){?><?=$lt->total_price?><?}else{?><?=number_format($lt->total_price)?><?}?></td>
							<!-- <td><? if($lt->use_point > 0){?>-<?=number_format($lt->use_point)?><?}else if($lt->coupon_cnt1 > 0 || $lt->coupon_cnt2 > 0){?><?=number_format($lt->coupon_price1+$lt->coupon_price2)?><?}?></td> -->
							<td><?=$lt->name?></td>
							<td><?=$lt->userid?></td>
							<td><?=substr($lt->trade_day,0,10)?></td>
						</tr>
						<?
						$cnt++;
						$totalCnt--;
						}?>
				</tbody>
				</table>

				<? if($t_cnt > 0){?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page2?>
				</p><!-- END Pager -->
				<?}?>