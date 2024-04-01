<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>

			<form name="bbs_reg_form" method="post">
			<input type="hidden" name="bbs_admin_reg" value="true">

			<table class="adm-table mb70">
			<colgroup>
				<col width="10%">
				<col width="40%">
				<col width="10%">
				<col width="40%">
			</colgroup>
							<tr>
								<th>게시판명</th>
								<td> <input name="name" type="text" maxlength="50" size="30" class="width-l" value="<? echo isset($bbs->name) ? $bbs->name : '';?>"></td>
								<th>게시판코드</th>
								<td> <input name="code" type="text" maxlength="20" size="30" class="width-l" <? if(isset($bbs->code)){ ?> value="<?=$bbs->code?>" readonly <?}?>></td>
							</tr>
							<tr>
								<th>게시판타입</th>
								<td>
									<input type="radio" name="bbs_type" value="1" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 1){ echo "checked"; }?>> 답변형
									<input type="radio" name="bbs_type" value="2" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 2){ echo "checked"; }?> <? if(empty($bbs->bbs_type)){ echo "checked"; }?>> 공지사항형
									<input type="radio" name="bbs_type" value="3" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 3){ echo "checked"; }?>> 갤러리형
									<input type="radio" name="bbs_type" value="4" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 4){ echo "checked"; }?>> FAQ형<br>
									<input type="radio" name="bbs_type" value="5" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 5){ echo "checked"; }?>> 이벤트형
									<input type="radio" name="bbs_type" value="6" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 6){ echo "checked"; }?>> 동영상형
									<input type="radio" name="bbs_type" value="7" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 7){ echo "checked"; }?>> 상품후기
									<input type="radio" name="bbs_type" value="8" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 8){ echo "checked"; }?>> 온라인폼<br>
									<input type="radio" name="bbs_type" value="9" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 9){ echo "checked"; }?>> 배너형
									<input type="radio" name="bbs_type" value="10" onClick="artCheck()" <? if(isset($bbs->bbs_type) && $bbs->bbs_type == 10){ echo "checked"; }?>> 히스토리형
									</td>
								<th>비밀글기능</th>
								<td><input type="radio" name="bbs_secret" value="1" <? if(isset($bbs->bbs_secret) && $bbs->bbs_secret == 1){ echo "checked"; }?>> 사용함 <input type="radio" name="bbs_secret" value="0" <? if(isset($bbs->bbs_secret) && $bbs->bbs_secret == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_coment)){ echo "checked"; }?>> 사용안함</td>
							</tr>
							<tr>
								<th>자료실사용</th>
								<td> <input type="radio" name="bbs_pds" value="1" <? if(isset($bbs->bbs_pds) && $bbs->bbs_pds == 1){ echo "checked"; }?>> 사용함 <input type="radio" name="bbs_pds" value="0" <? if(isset($bbs->bbs_pds) && $bbs->bbs_pds == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_pds)){ echo "checked"; }?>> 사용안함</td>
								<th>썸네일이미지 사용</th>
								<td> <input type="radio" name="list_pds" value="1" <? if(isset($bbs->list_pds) && $bbs->list_pds == 1){ echo "checked"; }?>> 사용함 <input type="radio" name="list_pds" value="0" <? if(isset($bbs->list_pds) && $bbs->list_pds == 0){ echo "checked"; }?> <? if(empty($bbs->list_pds)){ echo "checked"; }?>> 사용안함</td>
							</tr>
							<tr>
								<th>접근권한</th>
								<td> <input type="radio" name="bbs_access" value="0" <? if(isset($bbs->bbs_access) && $bbs->bbs_access == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_access)){ echo "checked"; }?>> 비회원 <input type="radio" name="bbs_access" value="1" <? if(isset($bbs->bbs_access) && $bbs->bbs_access == 1){ echo "checked"; }?>> 회원 </td>
								<th>읽기권한</th>
								<td> <input type="radio" name="bbs_read" value="0" <? if(isset($bbs->bbs_read) && $bbs->bbs_read == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_read)){ echo "checked"; }?>> 비회원 <input type="radio" name="bbs_read" value="1" <? if(isset($bbs->bbs_read) && $bbs->bbs_read == 1){ echo "checked"; }?>> 회원</td>
							</tr>
								<th>쓰기권한</th>
								<td> <input type="radio" name="bbs_write" value="0" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 0){ echo "checked"; }?> onclick="javascript:$('.write_level').hide();"> 비회원 <input type="radio" name="bbs_write" value="1" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 1){ echo "checked"; }?> onclick="javascript:$('.write_level').show();"> 회원 <input type="radio" name="bbs_write" value="9" <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 9){ echo "checked"; }?> <? if(empty($bbs->idx)){ echo "checked"; }?> onclick="javascript:$('.write_level').hide();"> 관리자 </td>
								<th>가로목록수</th>
								<td> <input name="list_width" type="text" size="4" class="write_title2" style="text-align: center" value="<? echo isset($bbs->list_width) ? $bbs->list_width : '';?>"> 개 (갤러리형 경우) <script language="javascript">	<? if(isset($bbs->bbs_type) && $bbs->bbs_type == 3){?>document.bbs_reg_form.list_width.disabled = false;<?}else{?>document.bbs_reg_form.list_width.disabled = true;<?}?>	</script></td>
							</tr>
							<tr <? if(isset($bbs->bbs_write) && $bbs->bbs_write == 1){?><?}else{?>style="display:none;"<?}?> class="write_level">
								<th>쓰기권한 상세</th>
								<td colspan="3">
									<select name="write_level" id="write_level">
									<option value="">전체회원</option>
									<? foreach ($level_row as $lv_row){ ?>
									<option value="<?=$lv_row->level?>" <? echo (isset($bbs->write_level) && $bbs->write_level==$lv_row->level) ? "selected" : "";?>><?=$lv_row->name?></option>
									<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<th>리스트수</th>
								<td> <input name="list_height" type="text" size="10" class="write_title2" value="<? echo isset($bbs->list_height) ? $bbs->list_height : '15';?>" style="text-align: center" >줄(갤러리는 개수)</td>
								<th>페이지수</th>
								<td> <input name="list_page" type="text" size="10" class="write_title2" value="<? echo isset($bbs->list_page) ? $bbs->list_page : '10';?>" style="text-align: center">페이지</td>
							</tr>
							<tr>
								<th>New 마크</th>
								<td colspan="3"> <input type="checkbox" name="new_check" value="1" <? if(isset($bbs->new_check) && $bbs->new_check == 1){ echo "checked"; }?> <?if(empty($bbs->idx)){?>checked<?}?> onClick="newCheck()"> 사용 <input name="new_mark" type="text" size="5" class="write_title2" style="text-align: center" value="<? echo isset($bbs->new_mark) ? $bbs->new_mark : '24';?>"> 시간 이내</td>
								<th style="display:none;">Cool 마크</th>
								<td style="display:none;"> <input type="checkbox" name="cool_check" value="1" <? if(isset($bbs->cool_check) && $bbs->cool_check == 1){ echo "checked"; }?> onClick="coolCheck()"> 사용 <input name="cool_mark" type="text" size="5" class="write_title2"  style="text-align: center" value="<? echo isset($bbs->cool_mark) ? $bbs->cool_mark : '100';?>" disabled> 번 이상</td>
							</tr>
							<tr>
							<tr>
								<th>카테고리 사용</th>
								<td>
									<input type="radio" value="N" name="bbs_cate" class="input" style="border:0px" <? if(isset($bbs->bbs_cate) && $bbs->bbs_cate == 'N'){ echo "checked"; }?> <? if(empty($bbs->bbs_cate)){ echo "checked"; }?>> 사용안함 &nbsp;
									<input type="radio" value="Y" name="bbs_cate" class="input" style="border:0px" <? if(isset($bbs->bbs_cate) && $bbs->bbs_cate == 'Y'){ echo "checked"; }?>> 사용함
								</td>
								<th>코멘트기능</th>
								<td> <input type="radio" name="bbs_coment" value="1" <? if(isset($bbs->bbs_coment) && $bbs->bbs_coment == 1){ echo "checked"; }?>> 사용함 <input type="radio" name="bbs_coment" value="0" <? if(isset($bbs->bbs_coment) && $bbs->bbs_coment == 0){ echo "checked"; }?> <? if(empty($bbs->bbs_coment)){ echo "checked"; }?>> 사용안함	</td>

							</tr>
							<tr>
								<th>스팸처리</th>
								<td> <input type="checkbox" name="nospam" value="1" <? if(isset($bbs->nospam) && $bbs->nospam == 1){ echo "checked"; }?>> 스팸차단사용</td>
								<th>편집게시판사용</th>
								<td colspan="1">
								<input type="checkbox" name="editor" value="1" <? if(isset($bbs->editor) && $bbs->editor == 1){ echo "checked"; }?> <? if(empty($bbs->idx)){ echo "checked"; }?>> 사용함
								</td>
							</tr>
							<tr>
								<th>권장사이즈1</th>
								<td><input name="size_text1" type="text" size="30" class="width-l" value="<? echo isset($bbs->size_text1) ? $bbs->size_text1 : '';?>"></td>
								<th>권장사이즈2</th>
								<td><input name="size_text2" type="text" size="30" class="width-l" value="<? echo isset($bbs->size_text2) ? $bbs->size_text2 : '';?>"></td>
							</tr>
							<tr>
								<th>설명글</th>
								<td colspan="3"> <textarea name="memo" cols="100" rows="8" class="write_title" style="height:80px;"><? echo isset($bbs->memo) ? $bbs->memo : '';?></textarea></td>
							</tr>
						</table><br>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:history.back(-1);">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="javascript:bbsSendit();">
				</p>

				</form>