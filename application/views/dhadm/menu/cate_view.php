
						<h3 class="icon-pen">메뉴 <?if($this->input->get("mode")=="write"){?>추가<?}else{?>수정<?}?></h3>

						<form method="post" name="menu_edit_form" id="menu_edit_form" action="<?=cdir()?>/dhadm/menu/m" target="action_ifrm">
						<input type="hidden" name="id" id="id" value="<? echo isset($data['row']->id) ? $data['row']->id : $this->input->get("id");?>">
						<input type="hidden" name="pid" id="pid" value="<? echo isset($data['p_row']->id) ? $data['p_row']->id : "";?>">
						<input type="hidden" name="mode" value="<?=$this->input->get("mode")?>">
						<table class="adm-table">
							<caption>메뉴 추가</caption>
							<colgroup>
								<col style="width:140px;">								
							</colgroup>
							<tbody>
								
								<tr>
									<th>상단메뉴</th>
									<td>
										<?if($this->input->get("mode")=="write" && isset($data['p_row']->nm)){?>
											<?=$data['p_row']->nm?>
										<?}else if($this->input->get("mode")=="view" && isset($data['p_row']->nm)){?>
											<?=$data['p_row']->nm?>
										<?}else{?>
										없음
										<?}?>
									</td>
								</tr>
								<tr>
									<th>메뉴명</th>
									<td><input type="text" class="width-xl" name="nm" value="<? echo isset($data['row']->nm) ? $data['row']->nm : "";?>"></td>
								</tr>
								<tr>
									<th>URL</th>
									<td><input type="text" class="width-xl" name="url" value="<? echo isset($data['row']->url) ? $data['row']->url : "";?>"></td>
								</tr>
								<tr>
									<th>사용 여부</th>
									<td>
										<input type="checkbox" name="status" value="1" <? echo isset($data['row']->status) && $data['row']->status==1 ? "checked" : ""; ?> <?if($this->input->get("mode")=="write"){?>checked<?}?>>
									</td>
								</tr>
								<tr>
									<th>접근권한</th>
									<td>
										<input type="checkbox" checked disabled><label for="emp"><?=$data['super_user']?></label>
										<? 
										foreach($data['admin_user_list'] as $user_list){
											$emp="";

											if(isset($data['row']->emp)){
												$emp = explode(",",$data['row']->emp);
												if(in_array($user_list->idx,$emp)){
													$emp = "checked";
												}
											}

										?>
										<input type="checkbox" name="emp[]" id="emp<?=$user_list->idx?>" value="<?=$user_list->idx?>" <?=$emp?> <?if($this->input->get("mode")=="write"){?>checked<?}?>><label for="emp<?=$user_list->idx?>"><?=$user_list->name?></label>
										<? } ?>
									</td>
								</tr>
								<tr>
									<th>페이지타입</th>
									<td>
										<input type="radio"  name="cls" id="cls1" value="" <? echo isset($data['row']->cls) && $data['row']->cls=="" ? "checked" : ""; ?> <?if($this->input->get("mode")=="write"){?>checked<?}?>><label for="cls1">일반</label>
										<input type="radio" name="cls" id="cls2" value="dashboard" <? echo isset($data['row']->cls) && $data['row']->cls=="dashboard" ? "checked" : ""; ?>><label for="cls2">Dashboard</label>
									</td>
								</tr>
								<? if($this->input->get("mode")=="view"){?>
								<tr>
									<th>카테고리 삭제</th>
									<td><button type="button" class="btn-alert btn-sm" onclick="del()">삭제</button>
										<span class="ft-red ft-s ml5">삭제하신 카테고리는 복구가 불구합니다.</span>
									</td>
								</tr>
								<input type="hidden" name="del_idx" id="del_idx" value="<? echo isset($data['row']->id) ? $data['row']->id : "";?>">
								<?}?>
							</tbody>
						</table>
						<p class="align-c mt20"><input type="button" value="<?if($this->input->get("mode")=="write"){?>추가<?}else{?>수정<?}?>하기" class="btn-l btn-ok" onclick="menu_add()"></p>
						</form>

						<iframe name="action_ifrm" id="action_ifrm" width="0" height="0" frameborder="0" style="display:none;"></iframe>


	<script>
								
		function menu_add(id)
		{
			var form = document.menu_edit_form;

			if(form.nm.value==""){
				alert("메뉴 이름을 입력해주세요.");
				form.nm.focus();
			}else if(form.url.value==""){
				alert("url을 입력해주세요.");
				form.url.focus();
			}else{
				$("#menu_edit_form").submit();
			}
			return;
		}

	</script>