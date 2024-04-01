
						<h3 class="icon-pen"><? if($this->input->get("mode")=="write"){?>분류 추가<?}else{?>분류 상세설정<?}?></h3>
						<form name="cate_write" id="cate_write" method="post" enctype="multipart/form-data" target="action_ifrm">
						<input type="hidden" name="mode" value="<?=$this->input->get("mode")?>">
						<input type="hidden" name="p_idx" value="<?=$this->input->get("idx");?>">
						<input type="hidden" name="level" value="1">

						<table class="adm-table">
							<caption>분류 수정</caption>
							<colgroup>
								<col style="width:140px;">								
							</colgroup>
							<tbody>								
								<tr>
									<th>분류 이름</th>
									<td><input type="text" class="width-xl" name="title" value="<? echo isset($data['row']->title) ? $data['row']->title : "";?>" msg="분류 이름을"></td>
								</tr>
								<tr>
									<th>URL (필요할경우)</th>
									<td><input type="text" class="width-xl" name="txt2" value="<? echo isset($data['row']->txt2) ? $data['row']->txt2 : "";?>"></td>
								</tr>
								<tr>
									<th>숨김 여부</th>
									<td>
										<input type="radio" name="display" id="cate_show" value="1" <? if(isset($data['row']->display) && $data['row']->display==1){?>checked<?}?> <? if(empty($data['row']->idx)){?>checked<?}?>><label for="cate_show">노출</label>
										<input type="radio" name="display" id="cate_hide" value="0" <? if(isset($data['row']->display) && $data['row']->display==0){?>checked<?}?>><label for="cate_hide">숨김</label>
									</td>
								</tr>
								<tr>
									<th>로고 이미지</th>
									<td>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img1" id="prod_thumb" onchange="file_chg(this.value);"/><label for="prod_thumb" class="btn-file">파일찾기</label>
												<span class="file-name file-name1"><? echo isset($data['row']->img1) && $data['row']->img1 ? $data['row']->img_real1 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img1) && $data['row']->img1){?><p class="float-l"><img src="/_dhadm/image/icon/prod_delete.jpg" class="brand1" style="vertical-align:middle;" onclick="file_del(1)"></p><?}?>
										</div>
									</td>
								</tr>
								<tr>
									<th>메인 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 540 * 439 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img2" id="prod_thumb2" onchange="file_chg(this.value,'2');"/><label for="prod_thumb2" class="btn-file">파일찾기</label>
												<span class="file-name2"><? echo isset($data['row']->img2) && $data['row']->img2 ? $data['row']->img_real2 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img2) && $data['row']->img2){?><p class="float-l"><img src="/_dhadm/image/icon/prod_delete.jpg" class="brand2" style="vertical-align:middle;" onclick="file_del(2)"></p><?}?>
										</div>
									</td>
								</tr>
								<tr>
									<th>메인 이미지 (모바일)</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 580 * 210 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img3" id="prod_thumb3" onchange="file_chg(this.value,'3');"/><label for="prod_thumb3" class="btn-file">파일찾기</label>
												<span class="file-name3"><? echo isset($data['row']->img3) && $data['row']->img3 ? $data['row']->img_real3 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img3) && $data['row']->img3){?><p class="float-l"><img src="/_dhadm/image/icon/prod_delete.jpg" class="brand3" style="vertical-align:middle;" onclick="file_del(3)"></p><?}?>
										</div>
									</td>
								</tr>
								<tr style="display:none;">
									<th>타이틀 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 800 * 200 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img4" id="prod_thumb4" onchange="file_chg(this.value,'4');"/><label for="prod_thumb4" class="btn-file">파일찾기</label>
												<span class="file-name4"><? echo isset($data['row']->img4) && $data['row']->img4 ? $data['row']->img_real4 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img4) && $data['row']->img4){?><p class="float-l"><img src="/_dhadm/image/icon/prod_delete.jpg" class="brand4" style="vertical-align:middle;" onclick="file_del(4)"></p><?}?>
										</div>
									</td>
								</tr>
								<tr>
									<th>분류설명</th>
									<td><textarea name="txt1" cols="30" rows="3"><? echo isset($data['row']->txt1) ? $data['row']->txt1 : "";?></textarea></td>
								</tr>
								<? if($this->input->get("mode")!="write"){?>
								<tr>
									<th>카테고리 삭제</th>
									<td><button type="button" class="btn-alert btn-sm" onclick="del()">삭제</button>
										<span class="ft-red ft-s ml5">삭제하신 카테고리는 복구가 불구합니다.</span>
									</td>
								</tr>
								<input type="hidden" name="del_idx" id="del_idx" value="<? echo isset($data['row']->idx) ? $data['row']->idx : "";?>">
								<?}?>
							</tbody>
						</table>
						</form>
						<p class="align-c mt20"><input type="button" value="변경사항 적용하기" class="btn-l btn-ok" onclick="frmChk('cate_write');"></p>
						<iframe name="action_ifrm" id="action_ifrm" width="0" height="0" frameborder="0" style="display:none;"></iframe>

<script>
	<? if(isset($data['row']->idx)){ ?>

	function file_del(num)
	{
		var mode = "brand";
		var idx = "<?=$data['row']->idx?>";


		if(confirm("이미지를 삭제하시겠습니까?")){
			$.ajax({
				url: "<?=cdir()?>/product/file_del",
				data: {ajax : "1", mode : mode, idx: idx, num: num},
				async: true,
				cache: false,
				error: function(xhr){
				},
				success: function(data){
					$(".file-name"+num).html("선택한 파일이 없습니다.");
					$("."+mode+num).hide();				
				}
			});
		}
	}

	<?}?>


</script>