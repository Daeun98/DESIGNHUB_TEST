<?
		if(empty($row->cate_idx)){
			$row->cate_idx = $this->input->get('cate_idx');
		}
?>


		<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="userid" value="<? echo isset($row->userid) ? $row->userid : @$this->session->userdata('ADMIN_USERID');?>" />
			<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
			<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
			<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(5)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<tbody>
				<tr <?if($bbs->bbs_type==4 || $bbs->bbs_type==9  || $bbs->bbs_type==10 || $bbs->memo=="notice"){?>style="display:none;"<?}?>>
					<th>작성자</th>
					<td><input type="text" class="width-m" value="<? echo isset($row->name) ? $row->name : "관리자";?>" name="name"/></td>
					<? if(@$this->session->userdata('ADMIN_PASSWD')){ ?><td><?}else{?><th><?}?><p <? if(@$this->session->userdata('ADMIN_PASSWD')){ ?>style="display:none;"<?}?>>비밀번호</th>
					<td><p <? if(@$this->session->userdata('ADMIN_PASSWD')){ ?>style="display:none;"<?}?>><input type="password" id="pw"  value="<? echo (@$this->session->userdata('ADMIN_PASSWD')) ? @$this->session->userdata('ADMIN_PASSWD') : "";?>" name="pwd"/></td>
					<td></td>
				</tr>
				<tr>
					<th>작성일</th>
					<td colspan="3">
						<input type="text" class="width-m" name="reg_date" value="<? echo isset($row->reg_date) ? $row->reg_date : date("Y-m-d  H:i:s");?>" msg="작성일을">
						<p> ※ 24시 형식으로 입력해주세요.</p>
						<p class="dh_red"> ※ 최신 날짜 기준으로 게시글이 정렬됩니다.</p>
					 </td>
				</tr>
			 <? if($bbs->code=="safeguard_content"){ ?>
				<tr>
					<th>시행일자</th>
					<td colspan="4">
						<select name="data1" class="input">
							<? foreach($safeguard_list as $s_list){ ?>
							<option value="<?=$s_list->idx?>" <? if(isset($row->data1) && $row->data1 == $s_list->idx){?>selected<?}?>><?=$s_list->subject?></option>
							<?}?>
						</select>
					</td>
				</tr>
				<?}?>
				<tr>
					<th style="width:200px;"><?if($bbs->bbs_type==4 && $bbs->code!="safeguard_content" ){?>질문<?}else if($bbs->bbs_type==10){?>내용<?}else if($bbs->code=="safeguard"){?>시행일자<?}else{?>제목<?}?></th>
					<td colspan="4"><input type="text" name="subject" class="width-xl" value="<? echo isset($row->subject) ? $row->subject : "";?>"/></td>
				</tr>
				<? if($bbs->bbs_type < 3 && $bbs->memo!="notice"){ ?>
				<tr>
					<th>공지기능</th>
					<td colspan="4">
						<input type="radio" name="notice" value="1" <? if(isset($row->notice) && $row->notice==1){ ?>checked<?}?>>&nbsp;yes&nbsp;
						<input type="radio" name="notice" value="0" <? if(isset($row->notice) && $row->notice==0){ ?>checked<?}?> <? if(empty($row->notice)){?>checked<?}?>>&nbsp;no
					</td>
				</tr>
				<?}?>

				<? if($bbs->bbs_cate=='Y'){ ?>
				<tr>
					<th>카테고리</th>
					<td colspan="4">
						<select name="cate_idx" class="input">
							<? foreach($cate_list as $c_list){ ?>
							<option value="<?=$c_list->idx?>" <? if(isset($row->cate_idx) && $row->cate_idx == $c_list->idx){?>selected<?}?>><?=$c_list->name?></option>
							<?}?>
						</select>
					</td>
				</tr>
				<?}?>

				<? if($bbs->bbs_type==9 && $bbs->code=="main"){?>
				<!-- <tr>
					<th>간단설명</th>
					<td colspan="4"><textarea name="data1" cols="30" rows="3"><? echo isset($row->data1) ? $row->data1 : "";?></textarea></td>
				</tr>
				<tr>
					<th>강조문구</th>
					<td colspan="4"><input type="text" name="data2" class="width-xl" value="<? echo isset($row->data2) ? $row->data2 : "";?>"/></td>
				</tr> -->
				<?}?>

				<? if($bbs->bbs_secret=="1"){ ?>
				<tr>
					<th>비밀글</th>
					<td colspan="4"><input type="checkbox" name="secret" value="y" <? if(isset($row->secret) && $row->secret=='y'){?>checked<?}?>> (비밀글 기능 사용시 체크 해 주세요) </td>
				</tr>
				<?}?>

				<tr style="display:<? if( $bbs->list_pds ) { //자료실 사용 ?><?}else{?>none<?}?>;">
					<th>썸네일 이미지</th>
<!-- 					<td colspan="4">
						<ul class="w40">
							<li>
								<input type="file" id="file03" name="list_img"/>
								<span class="file-name3"><? echo isset($row->list_img_real) ? $row->list_img_real : "";?></span>
							</li>
						</ul>
						<p class="float-l">
						<? if(isset($row->list_img) && $row->list_img!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="list_img" style="vertical-align:middle;" onclick="file_del('list_img3',<?=$row->idx?>)"><?}?>

						<? if($bbs->size_text1){ echo "&nbsp; ".$bbs->size_text1; } ?>
						</p>
					</td> -->
				<td>
				<input type="file" name="list_img" style="border:1px solid #eee;">
				<?php
				if($row->list_img){
					?>
					<input type="button" value="보기" onclick="window.open('/_data/file/bbsData/<?=$row->list_img?>','','')">
					<input type="checkbox" name="list_file_del" value="Y" id="list_file_del"><label for="list_file_del">삭제</label>
					<?php
				}
				?>
				<p>
					권장사이즈 230 x 160 px
				</p>
			</td>
				</tr>

				<? if($bbs->bbs_type=='5'){ ?>
				<tr>
					<th>시작일자</th>
					<td colspan="4">
						<input type="text" class="width-m" value="<? echo isset($row->start_date) ? $row->start_date : "";?>" name="start_date" id="start_date" readonly/>
					</td>
				</tr>
				<tr>
					<th>종료일자</th>
					<td colspan="4">
						<input type="text" class="width-m" value="<? echo isset($row->end_date) ? $row->end_date : "";?>" name="end_date" id="end_date" readonly/>
					</td>
				</tr>
				<?}else if($bbs->bbs_type=='10'){?>
				<tr>
					<th>날짜</th>
					<td colspan="4">
						<select name="year">
						<?
						$y = date("Y");
						for($i=$y;$i>=1910;$i--){ ?>
							<option value="<?=$i?>" <?if(isset($row->year) && $row->year==$i){?>selected<?}?>><?=$i?></option>
						<? } ?>
						</select>
						년	&nbsp;
						<select name="month">
							<? for($i=01;$i<=12;$i++){ ?>
							<option value="<?=$i?>" <?if(isset($row->month) && $row->month==$i){?>selected<?}?>><?=$i?></option>
							<? } ?>
						</select>
						월	&nbsp;
						<select name="day">
							<? for($i=01;$i<=31;$i++){ ?>
							<option value="<?=$i?>" <?if(isset($row->day) && $row->day==$i){?>selected<?}?>><?=$i?></option>
							<? } ?>
						</select>
						일
					</td>
				</tr>
				<?}?>

				<? if($bbs->bbs_type=='6'){ ?>
				<tr>
					<th>동영상 입력 선택</th>
					<td colspan="4">
						<input type="radio" name="dong_flag" id="dong_src" value="dong_src" <? if( (isset($row->dong_flag) && $row->dong_flag=='dong_src') || empty($row->idx) ){?>checked<?}?> > <label for="dong_src">Yutube 코드</label><input type="radio" name="dong_flag" id="dong_sorce" value="dong_sorce" <? if(isset($row->dong_flag) && $row->dong_flag=='dong_sorce'){?>checked<?}?> > <label for="dong_sorce">소스삽입</label>
					</td>
				</tr>
				<tr class="dong_src" <? if(isset($row->dong_flag) && $row->dong_flag=='dong_sorce'){?>style="display:none;"<?}?>>
					<th>Yutube 코드</th>
					<td colspan="4">
						<input type="text" name="dong_src" id="dong_src" class="input" size="70" value="<? echo isset($row->dong_src) ? $row->dong_src : "";?>"> (예) MZoO8QVMxkk
					</td>
				</tr>
				<tr class="dong_sorce" <? if( (isset($row->dong_flag) && $row->dong_flag=='dong_src') || empty($row->idx) ){?>style="display:none;"<?}?>>
					<th>소스삽입</th>
					<td colspan="4">
						<textarea name="dong_sorce" id="dong_sorce" style="width:600px;height:100px" class="input"><? echo isset($row->dong_sorce) ? $row->dong_sorce : "";?></textarea>
					</td>
				</tr>
				<?}?>


				<? if($bbs->editor!=1){ //네이버 에디터 미사용?>
				<tr <?if($bbs->bbs_type==10){?>style="display:none;"<?}?>>
					<th><?if($bbs->bbs_type==9){?>링크 url<?}else{?>내용<?}?></th>
					<td colspan="4"><textarea name="tx_content" id="tx_content" cols="30" rows="<?if($bbs->bbs_type==9){?>2<?}else{?>10<?}?>"><? echo isset($row->content) ? $row->content : "";?></textarea></td>
				</tr>

				<? }else{ //네이버 에디터 사용??>
				<tr>
					<td colspan="5"><textarea name="tx_content" id="tx_content" rows="10" cols="100" style="width:100%; height:412px; display:none;"><? echo isset($row->content) ? $row->content : "";?></textarea></td>
				</tr>
				<?	 }	?>



				<tr style="display:<? if( $bbs->bbs_pds ) { //자료실 사용 ?><?}else{?>none<?}?>;">
					<th><? if( $bbs->bbs_pds && $bbs->bbs_type==9 ) { ?>이미지<?}else{?>첨부파일<?}?></th>
					<td colspan="4">
						<ul class="file w40">
							<li>
								<input type="file" id="file01" name="bbs_file"/><label for="file01" class="btn-file">파일찾기</label>
								<span class="file-name"><? echo isset($row->real_file) ? $row->real_file : "";?></span>
							</li>
						</ul>
						<p class="float-l">
						<? if(isset($row->bbs_file) && $row->bbs_file!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="list_img" style="vertical-align:middle;" onclick="file_del('list_img',<?=$row->idx?>)"><?}?>

						<? if($bbs->size_text1){ echo "&nbsp; ".$bbs->size_text1; } ?>
						</p>
					</td>
				</tr>


				<? if( $bbs->bbs_pds && $bbs->bbs_type==9 && $bbs->memo=="mobile" ) { ?>
				<tr>
					<th>모바일 이미지</th>
					<td colspan="4">
						<ul class="file w40">
							<li>
								<input type="file" id="file02" name="bbs_file2"/><label for="file02" class="btn-file">파일찾기</label>
								<span class="file-name2"><? echo isset($row->real_file2) ? $row->real_file2 : "";?></span>
							</li>
						</ul>
						<p class="float-l">
						<? if(isset($row->bbs_file2) && $row->bbs_file2!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="list_img" style="vertical-align:middle;" onclick="file_del('list_img2',<?=$row->idx?>)"><?}?>

						<? if($bbs->size_text2){ echo "&nbsp; ".$bbs->size_text2; } ?>
						</p>
					</td>
				</tr>
				<? } ?>


				<? if( $bbs->bbs_type==3 && $bbs->memo=="addimg") {?>

						<input type="hidden" name="img_cnt" id="img_cnt" value="<? echo isset($file_cnt) && $file_cnt>0 ? $file_cnt : "1"; ?>">
							<tr>
								<th class="add_image_th">추가이미지</th>
								<td colspan="4">
									<div class="float-wrap add_image">
										<?
										if(isset($file_cnt) && $file_cnt > 0){
											$f_cnt=0;
											foreach($file_row as $file){
												$f_cnt++;
										?>
										<p class="file mb5">
											<input type="file" id="photo<?=$f_cnt?>" name="add_images<?=$f_cnt?>" onchange="file_chg(this.value,<?=$f_cnt?>)" /><label for="photo<?=$f_cnt?>" class="btn-file">파일찾기</label>
											<span class="filename file-name<?=$f_cnt?>" <? if(isset($file->real_name) && $file->file_name!=""){?>onclick="javascript:window.open('/_data/file/bbsData/<?=$file->file_name?>','','');" style="cursor:pointer;"<?}?>><? echo isset($file->real_name) && $file->file_name!="" ? $file->real_name : "선택한 파일이 없습니다."; ?></span>
										</p>

											<p class="float-l">
												<!-- 권장사이즈 : 240 * 240 px --><? if(isset($file->file_name) && $file->file_name!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="add_img<?=$f_cnt?>" style="vertical-align:middle;" onclick="file_del('add_img<?=$f_cnt?>',<?=$file->idx?>,'<?=$f_cnt?>')"><?}?>
												<? if($f_cnt==1){?><button type="button" style="vertical-align:top;" class="btn-clear ml10" onclick="img_add();">이미지 추가</button><?}?>
											</p>

										<?
											}
										}else{?>
										<p class="file mb5">
											<input type="file" id="photo1" name="add_images1" onchange="file_chg(this.value,1)" /><label for="photo1" class="btn-file">파일찾기</label>
											<span class="filename file-name1">선택한 파일이 없습니다.</span>
										</p>
										<p class="float-l">
											<button type="button" style="vertical-align:top;" class="btn-clear" onclick="img_add();">이미지 추가</button>
										</p>
										<?}?>
									</div>
								</td>
							</tr>
				<?}?>



			</tbody>
		</table><!-- END Board Write -->


		<!-- Button -->
		<p class="align-c mt20">
			<input type="button" value="취소" class="btn-cancel btn-l" onclick="javascript:history.back(-1);">
			<input type="button" value="<? echo isset($row->idx) ? "수정" : "등록";?>" name="writeBtn" class="btn-ok btn-l" onclick="javascript:validForm();">
		</p><!-- END Button -->
		</form>
	</div><!-- END Board Wrap -->




<script type="text/javascript">

	$(function(){
		$("#file01").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name").html(file_txt[2]);

		});
		$("#file02").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name2").html(file_txt[2]);

		});

	});


		function validForm() {

			<? if($bbs->editor==1){ //네이버 에디터 사용시??>
				CKEDITOR.instances.tx_content.updateElement();
			<?}?>

			if (document.tx_editor_form.name.value == '') {
				alert("이름을 입력해 주십시오.");
				document.tx_editor_form.name.focus();
				return;
			}
			if (document.tx_editor_form.pwd.value == '') {
				alert("비밀번호를 입력해 주세요.");
				document.tx_editor_form.pwd.focus();
				return;
			}
			if (document.tx_editor_form.subject.value == '') {
				alert("제목을 입력해 주십시오.");
				document.tx_editor_form.subject.focus();
				return;
			}

			document.tx_editor_form.submit();
			document.tx_editor_form.writeBtn.disabled = true;
			return;
		}


$(function(){
	$("input[name='dong_flag']").click(function(){
		$(".dong_src").hide();
		$(".dong_sorce").hide();
		$("."+$(this).val()).show();
	});
});


	function img_add()
	{
		var cnt = parseInt($("#img_cnt").val())+1;

		if(cnt < 6){

		var txt = '<p class="file mb5">'+
								'<input type="file" id="photo'+cnt+'" name="add_images'+cnt+'" onchange="file_chg(this.value,'+cnt+')" /><label for="photo'+cnt+'" class="btn-file">파일찾기</label>'+
								'<span class="filename file-name'+cnt+'">선택한 파일이 없습니다.</span>'+
							'</p>';

		$("#img_cnt").val( cnt );
		$(".add_image").append(txt);

		var height = $(".add_image_th").css("height");

		$(".add_image_th").css("height",height);
		$(".add_image_th").css("vertical-align","middle");

		}else{
			alert("이미지는 최대 5개까지 등록할 수 있습니다.");
			return;
		}
	}


	function file_del(mode, idx, num)
	{
		if(confirm("이미지를 삭제하시겠습니까?")){
			$.ajax({
				url: "<?=cdir()?>/board/file_del",
				data: {ajax : "1", mode : mode, idx: idx},
				async: true,
				cache: false,
				error: function(xhr){
				},
				success: function(data){
					if(mode=="list_img"){
						$(".file-name").html("선택한 파일이 없습니다.");
						$("."+mode).hide();
					}else if(mode=="list_img2"){
						$(".file-name2").html("선택한 파일이 없습니다.");
						$("."+mode).hide();
					}else{
						$(".file-name"+num).html("선택한 파일이 없습니다.");
						$("#photo"+num).attr("msg","썸네일 이미지를");
						$("."+mode).hide();
					}
				}
			});
		}
	}


</script>





<? if($bbs->editor == "1"){ ?>

<script type="text/javascript" src="/_data/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('tx_content');
</script>

<? } ?>