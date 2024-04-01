
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
									<option value="name" <?if($this->input->get('item')=="name"){?>selected<?}?>>쿠폰명</option>
									<option value="code" <?if($this->input->get('item')=="code"){?>selected<?}?>>쿠폰코드</option>
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
					<h3 class="icon-list float-l">등록된 쿠폰 <strong><?=$totalCnt?>개</strong></h3>
				</div>

				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<!-- <col style="width:40px;"> --><col style="width:135px;"><col><col style="width:105px;"><col><col style="width:210px;">
					</colgroup>
					<thead>
						<tr>
							<!-- <th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th> -->
							<th>쿠폰코드</th>
							<th>쿠폰명</th>
							<th>할인</th>
							<th>유효기간</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){ 
								if($lt->date_flag==1){
									$max_day = explode(" ",$lt->max_day);	
									$max_day_text = explode("+",$max_day[0]);	
								}
						?>
						<tr>
							<!-- <td><input type="checkbox" name="check" value="" class="sel"></td> -->
							<td><?=$lt->code?></td>
							<td><?=$lt->name?></td>
							<td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
							<td>
							<? if($lt->date_flag==0){?>
								<?=$lt->start_date?>~<?=$lt->end_date?>
							<?}else if($lt->date_flag==1){?>
								발급일자로부터 <?=$max_day_text[1]?><?if($max_day[1]=="day"){?>일<?}else if($max_day[1]=="month"){?>개월<?}?>
							<?}?>
							</td>
							<td>
								<input type="button" value="쿠폰이용내역" class="btn-sm2" onclick="openWinPopup('<?=cdir()?>/order/couponTrade/<?=$lt->idx?>/?ajax=1','point_set',565,595);">
								<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/order/coupon/m/edit/<?=$lt->idx?>/<?=$query_string.$param?>';">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 쿠폰이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<!-- <div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="goods_select('del')" >
					</div> -->
					<div class="float-r">
						<a href="<?=self_url()?>/write/" class="button btn-ok">새 쿠폰 등록</a></span>
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