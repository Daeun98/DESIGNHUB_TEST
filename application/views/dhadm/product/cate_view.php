
						<h3 class="icon-pen"><? if($this->input->get("mode")=="write"){?>카테고리 추가<?}else{?>카테고리 상세설정<?}?></h3>
						<form name="cate_write" id="cate_write" method="post" enctype="multipart/form-data" target="action_ifrm">
						<input type="hidden" name="mode" value="<?=$this->input->get("mode")?>">
						<input type="hidden" name="p_idx" value="<?=$this->input->get("idx");?>">
						<input type="hidden" name="depth" value="<? echo isset($data['add_row']->depth) ? $data['add_row']->depth+1 : "";?>">
						<table class="adm-table">
							<caption>카테고리 수정</caption>
							<colgroup>
								<col style="width:140px;">								
							</colgroup>
							<tbody>
								<tr>
									<th>상위 카테고리</th>
									<td>
										<? if(isset($data['add_row']->title)){?><?=$data['add_row']->title?><?}else{?>
										<? if(isset($data['row']->depth) && $data['row']->depth>1){ ?><?=$data['p_row']->title?><?}else{?>없음<?}?>
										<?}?>
									</td>
								</tr>
								<!-- <tr>
									<th>분류 URL</th>
									<td>test.co.kr/product/brand.php?cate_no=99</td>
								</tr> -->
								<tr>
									<th>카테고리 이름</th>
									<td><input type="text" class="width-xl" name="title" value="<? echo isset($data['row']->title) ? $data['row']->title : "";?>" msg="카테고리 이름을"></td>
								</tr>
								<tr style="display:none;">
									<th>접근권한</th>
									<td>
										<select name="access_level" id="access_level">
										<? 
											foreach($level_row as $level){
										?>
											<option value="<?=$level->level?>" <? if(isset($data['row']->access_level) && $data['row']->access_level==$level->level){?>selected<?}?>><?=$level->name?></option>
										<?
										 }
										?>
										</select>
									</td>
								</tr>
								<tr>
									<th>숨김 여부</th>
									<td>
										<input type="radio" name="display" id="cate_show" value="1" <? if(isset($data['row']->display) && $data['row']->display==1){?>checked<?}?> <? if(empty($data['row']->idx)){?>checked<?}?>><label for="cate_show">노출</label>
										<input type="radio" name="display" id="cate_hide" value="0" <? if(isset($data['row']->display) && $data['row']->display==0){?>checked<?}?>><label for="cate_hide">숨김</label>
									</td>
								</tr>
								<tr>
									<th>타이틀 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 800 * 200 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img1" id="prod_thumb" onchange="file_chg(this.value);"/><label for="prod_thumb" class="btn-file">파일찾기</label>
												<span class="file-name file-name1"><? echo isset($data['row']->img1) ? $data['row']->img_real1 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img1) && $data['row']->img1){?><p class="float-l"><button type="button" class="cate1" onclick="file_del(1)">삭제</button></p><?}?>
										</div>
									</td>
								</tr>
								<tr>
									<th>추가 이미지</th>
									<td>
										<p class="mb5"><small>권장사이즈 : 800 * 200 px</small></p>
										<div class="float-wrap">
											<p class="file mr10" style="width:250px;">
												<input type="file" name="img2" id="prod_thumb2" onchange="file_chg(this.value,'2');"/><label for="prod_thumb2" class="btn-file">파일찾기</label>
												<span class="file-name2"><? echo isset($data['row']->img2) ? $data['row']->img_real2 : "선택한 파일이 없습니다."; ?></span>
											</p>
											<? if(isset($data['row']->img2) && $data['row']->img2){?><p class="float-l"><button type="button" class="cate2" onclick="file_del(2)">삭제</button></p><?}?>
										</div>
									</td>
								</tr>
								<tr>
									<th>분류설명</th>
									<td><textarea name="content" cols="30" rows="3"><? echo isset($data['row']->content) ? $data['row']->content : "";?></textarea></td>
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
						<p class="align-c mt20"><input type="button" value="<? if($this->input->get("mode")!="write"){?>변경사항 적용하기<?}else{?>등록하기<?}?>" class="btn-l btn-ok" onclick="frmChk('cate_write');"></p>

						<iframe name="action_ifrm" id="action_ifrm" width="0" height="0" frameborder="0" style="display:none;"></iframe>

<script>
	<? if(isset($data['row']->idx)){ ?>

	function file_del(num)
	{
		var mode = "cate";
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