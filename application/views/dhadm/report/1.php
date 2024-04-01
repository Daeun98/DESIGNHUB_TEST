<? $nyear = date("Y"); ?>

				<?/*
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
				*/?>

				<div class="float-wrap mt50 mb5">
				<h3 class="icon-list float-l">판매 현황 리스트</h3>
				<p class="float-r">
					※ 결제완료, 배송중, 배송완료 된 주문에 대한 제품 판매 갯수 누적 통계 입니다.
				</p>
				</div>

				<style>
				.total-table th,.total-table td { border:1px solid #ddd; }
				</style>

				<table class="adm-table total-table line align-c mb30" style="bo">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:8%"><col style="width:15%"><col style="width:15%"><col style=""><col style="width:10%;"><? if($this->input->get("lan")!="en"){?><col style="width:12%;"><col style="width:12%;"><?}?>
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th>No</th>
							<th>구분</th>
							<th>카테고리</th>
							<th>제품명</th>
							<th>판매건</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
						foreach($list as $lt){
						?>
						<tr>
							<td><?=$totalCnt?></td>
							<td><? echo $lt->cate_name1 ? $lt->cate_name1 : "-";?></td>
							<td><? echo $lt->cate_name2 ? $lt->cate_name2 : "-";?></td>
							<td class="title"><?=$lt->name?></td>
							<td><?=number_format($lt->sell_cnt)?></td>
						</tr>
						<?
						$totalCnt--;
						}?>
				</tbody>
				</table>


				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page?>
				</p><!-- END Pager -->