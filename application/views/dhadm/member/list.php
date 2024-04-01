<?
	$outmode = $this->input->get('outmode');
	if($flag=="outmode"){ $outmode="1"; }
?>
				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<? /*if($flag!="ago"){?>
						<tr>
							<th>분류</th>
							<td>
								<input type="radio" name="outmode" id="outmode1" value="0" <? if($outmode=="0"){ echo "checked"; }?>> <label for="outmode1">회원</label>
								<input type="radio" name="outmode" id="outmode2" value="1" <? if($outmode=="1"){ echo "checked"; }?>> <label for="outmode2">탈퇴회원</label>
							</td>
						</tr>
						<?}*/?>
						<tr>
							<th>통합검색</th>
							<td>
								<select name="search_flag" onchange="flag_sel(this.value);">
									<option value="">선택</option>
									<option value="level" <? if($this->input->get('search_flag')=="level"){ echo "selected"; }?>>회원등급</option>
									<option value="mailing" <? if($this->input->get('search_flag')=="mailing"){ echo "selected"; }?>>메일링</option>
									<option value="local" <? if($this->input->get('search_flag')=="local"){ echo "selected"; }?>>지역검색</option>
								</select>
								<select name="search_level" id="search_level" class="search_flag" style="display:none;">
									<? foreach ($level_row as $lv_row){ ?>
									<option value="<?=$lv_row->level?>" <? if($this->input->get('search_flag')=="level" && $this->input->get('search_level')==$lv_row->level){ echo "selected"; }?>><?=$lv_row->name?></option>
									<?}?>
								</select>
								<select name="search_mailing" id="search_mailing" class="search_flag" style="display:none;">
									<option value="0" <? if($this->input->get('search_flag')=="mailing" && $this->input->get('search_mailing')=="0"){ echo "selected"; }?>>메일거부</option>
									<option value="1" <? if($this->input->get('search_flag')=="mailing" && $this->input->get('search_mailing')=="1"){ echo "selected"; }?>>메일수신</option>
								</select>
								<select name="search_local" id="search_local" class="search_flag" style="display:none;">
								<? foreach ($city_row as $city){  ?>
								<option value="<?=$city->item?>" <? if($this->input->get('search_flag')=="local" && $this->input->get('search_local')==$city->item){ echo "selected"; }?>><?=$city->item?></option>
								<? } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>회원검색</th>
							<td>
								<select name="item">
									<option value="userid" <?if($this->input->get('item')=="userid"){?>selected<?}?>>아이디</option>
									<option value="name" <?if($this->input->get('item')=="name"){?>selected<?}?>>이름</option>
									<option value="email" <?if($this->input->get('item')=="email"){?>selected<?}?>>이메일</option>
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
					<h3 class="icon-list float-l">총 <strong><?=number_format($totalCnt)?>명</strong>
					&nbsp;<input type="button" value="엑셀저장" class="btn-etc" onclick="<?if($totalCnt>0){?>location.href='/<?=$this->uri->segment(1)?>/excel_download/<?=$query_string?>&id=member&cont=user&flag=<?=$flag?>'<?}else{?>javascript:alert('저장할 회원이 없습니다.');<?}?>">
					</h3>
					<p class="list-adding float-r">
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=1"<? if($this->input->get('order')==1 || !$this->input->get('order')){?> class="on"<?}?>>등록일순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=2"<? if($this->input->get('order')==2){?> class="on"<?}?>>이름순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=3"<? if($this->input->get('order')==3){?> class="on"<?}?>>아이디순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=4"<? if($this->input->get('order')==4){?> class="on"<?}?>>가입일순</a>
					</p>
				</div>

				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<col style="width:4%"><col style="width:10%;"><col style="width:10%;"><col style="width:10%;"><? if($outmode!="1"){ ?><col style="width:12%;"><col style="width:10%;"><?}?><col style="width:10%;"><? if($flag=="ago"){?><col style="width:10%;"><?}?><col style="width:8%;"><col style="width:13%;">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>아이디</th>
							<th>이름</th>
							<th>등급</th>
							<? if($outmode!="1" && $shop_info['shop_use']=="y"){ ?>
							<th>포인트</th>
							<th>쿠폰</th>
							<?}?>
							<th>가입일자</th>
							<? if($flag=="ago"){?><th>최종접속일</th><?}?>
							<th>접속수</th>
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
								<td><?=$lt->userid?><? if($outmode=="1"){ ?> <font color="red">(탈퇴회원)</font><?}?></td>
								<td><?=$lt->name?></td>
								<td><?=$lt->level_name?></td>
								<? if($outmode!="1" && $shop_info['shop_use']=="y"){ ?>
								<td><input type="button" class="btn-clear btn-sm" value="포인트관리" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/point/<?=$lt->idx?>/?ajax=1','point_set',565,595);"></td>
								<td><input type="button" class="btn-clear btn-sm" value="쿠폰관리" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/coupon/<?=$lt->idx?>/?ajax=1','coupon_set',715,615);"></td>
								<?}?>
								<td><?=reDate($lt->register,"-")?></td>
								<? if($flag=="ago"){?><td><?=reDate($lt->last_login,"-")?></td><?}?>
								<td><?=$lt->connect?></td>
								<td>
									<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url();?>/edit/<?=$lt->idx?>/<?=$query_string.$param?>';">
									<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk2(<?=$lt->idx?>)">
								</td>
							</tr>
						<?
								$totalCnt--;
								}
							}else{
						?>
						<tr>
							<td colspan="10">등록된 회원이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-r">
					<? if($flag!="ago" && $flag!="outmode"){?><a href="/member/user/m/write/" class="button btn-ok">회원 등록</a></span><?}else{?><br><?}?>
					</div>
				</div><!-- END 제품 액션 버튼 -->


			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page?>
				</p><!-- END Pager -->
			<?}?>

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				<input type="hidden" name="out" value="<?=$outmode?>">
				</form>

					<script>

					<? if($this->input->get('search_flag')){ ?>
					flag_sel("<?=$this->input->get('search_flag')?>");
					<?}?>

					function flag_sel(value)
					{
						$(".search_flag").hide();
						$("#search_"+value).show();
					}


					function delOk2(idx)
					{
						document.delFrm.del_idx.value=idx;

						if(document.delFrm.out.value==1){
							if(!confirm("삭제하시겠습니까?\n삭제된 회원은 다시 복구되지 않습니다.")){
								return;
							}
						}else{
							if(!confirm("탈퇴처리 하시겠습니까?")){
								return;
							}
						}

						document.delFrm.submit();

					}


					</script>