<?
		if(empty($row->cate_idx)){
			$row->cate_idx = $this->input->get('cate_idx');
		}

		if(isset($row->cate_no)){
			$cate_no = explode("-",$row->cate_no);
			for($i=0;$i<count($cate_no);$i++){
				$j=$i+1;
				if($i==0){
					${'cate_no'.$j} = $cate_no[$i];
				}else{
					${'cate_no'.$j} = ${'cate_no'.$i}."-".$cate_no[$i];
				}
			}
		}

?>

	
		<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="userid" value="<? echo isset($row->userid) ? $row->userid : @$this->session->userdata('ADMIN_USERID');?>" />
			<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
			<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
			<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">
			<input type="hidden" name="cate_no" id="cate_no" value="<? echo isset($row->cate_no) ? $row->cate_no : "";?>">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(5)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<tbody>

						<tr>
							<th>제품분류</th>
							<td colspan="4">
								<select name="cate_no1" onchange="cate_chg(2,this.value)">
									<option value="">1차 카테고리</option>
									<? foreach($product_cate_list as $cate1){ ?>
									<option value="<?=$cate1->cate_no?>" <?if(isset($cate_no1) && $cate_no1==$cate1->cate_no){?>selected<?}?>><?=$cate1->title?></option>
									<?}?>
								</select>
								<select name="cate_no2" id="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;">
									<option value="">2차 카테고리</option>
								</select>
								<select name="cate_no3" id="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;">
									<option value="">3차 카테고리</option>
								</select>
								<select name="cate_no4" id="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;">
									<option value="">4차 카테고리</option>
								</select>
							</td>
						</tr>		
						<tr class="product_list" <?if(empty($row->goods_idx)){?>style="display:none;"<?}?>>
							<th>제품선택</th>
							<td colspan="4">
								<select name="goods_idx" id="goods_idx">
									<option value="">제품을 선택해주세요</option>
								</select>
							</td>
						</tr>		
						<tr>
							<th>별점</th>
							<td colspan="4">
								<select name="grade" id="grade">
									<option value="5" <?if(isset($row->grade) && $row->grade==5){?>selected<?}?>>5</option>
									<option value="4" <?if(isset($row->grade) && $row->grade==4){?>selected<?}?>>4</option>
									<option value="3" <?if(isset($row->grade) && $row->grade==3){?>selected<?}?>>3</option>
									<option value="2" <?if(isset($row->grade) && $row->grade==2){?>selected<?}?>>2</option>
									<option value="1" <?if(isset($row->grade) && $row->grade==1){?>selected<?}?>>1</option>
								</select>
							</td>
						</tr>		


				<tr <?if($bbs->bbs_type==4 || $bbs->memo=="notice"){?>style="display:none;"<?}?>>
					<th>작성자</th>
					<td><input type="text" class="width-m" value="<? echo isset($row->name) ? $row->name : "관리자";?>" name="name"/></td>
					<? if(@$this->session->userdata('ADMIN_PASSWD')){ ?><td><?}else{?><th><?}?><p <? if(@$this->session->userdata('ADMIN_PASSWD')){ ?>style="display:none;"<?}?>>비밀번호</th>
					<td><p <? if(@$this->session->userdata('ADMIN_PASSWD')){ ?>style="display:none;"<?}?>><input type="password" id="pw"  value="<? echo (@$this->session->userdata('ADMIN_PASSWD')) ? @$this->session->userdata('ADMIN_PASSWD') : "";?>" name="pwd"/></td>
					<td></td>
				</tr>
				<tr>
					<th style="width:200px;"><?if($bbs->bbs_type==4){?>질문<?}else{?>제목<?}?></th>
					<td colspan="4"><input type="text" name="subject" class="width-xl" value="<? echo isset($row->subject) ? $row->subject : "";?>"/></td>
				</tr>
				<tr>
					<th>베스트 후기</th>
					<td colspan="4">
						<input type="radio" name="notice" value="1" <? if(isset($row->notice) && $row->notice==1){ ?>checked<?}?>>&nbsp;yes&nbsp;
						<input type="radio" name="notice" value="0" <? if(isset($row->notice) && $row->notice==0){ ?>checked<?}?> <? if(empty($row->notice)){?>checked<?}?>>&nbsp;no
					</td>
				</tr>

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

				<? if($bbs->bbs_secret=="1"){ ?>
				<tr>
					<th>비밀글</th>
					<td colspan="4"><input type="checkbox" name="secret" value="y" <? if(isset($row->secret) && $row->secret=='y'){?>checked<?}?>> (비밀글 기능 사용시 체크 해 주세요) </td>
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
				<tr>
					<th><?if($bbs->bbs_type==9){?>링크 url<?}else{?>내용<?}?></th>
					<td colspan="4"><textarea name="tx_content" id="tx_content" cols="30" rows="<?if($bbs->bbs_type==9){?>3<?}else{?>10<?}?>"><? echo isset($row->content) ? $row->content : "";?></textarea></td>
				</tr>

				<? }else{ //네이버 에디터 사용??>			
				<tr>
					<td colspan="5"><textarea name="tx_content" id="tx_content" rows="10" cols="100" style="width:100%; height:412px; display:none;"><? echo isset($row->content) ? $row->content : "";?></textarea></td>
				</tr>							
				<?	 }	?>
				
				<tr style="display:<? if( $bbs->bbs_pds ) { //자료실 사용 ?><?}else{?>none<?}?>;">
					<th>첨부파일</th>
					<td colspan="4">
						<ul class="file w40">
							<li>
								<input type="file" id="file01" name="bbs_file"/><label for="file01" class="btn-file">파일찾기</label>
								<span class="file-name"><? echo isset($row->real_file) ? $row->real_file : "";?></span>
							</li>

							
							<!-- <li>
								<input type="file" id="file02" /><label for="file02" class="btn-file">파일찾기</label>
								<span class="file-name">filename.jpg</span>
							</li>
							<li>
								<input type="file" id="file03" /><label for="file03" class="btn-file">파일찾기</label>
								<span class="file-name">첨부파일이 없습니다.</span>
							</li> -->
						</ul>
						<!-- <span class="add-file-btn">파일추가</span> -->
								<p class="float-l">
								<? if(isset($row->bbs_file) && $row->bbs_file!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="list_img" style="vertical-align:middle;" onclick="file_del('list_img',<?=$row->idx?>)"><?}?>
								</p>
					</td>
				</tr>



				<? if( $bbs->bbs_type==3 && isset($add_img)) {?>

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

	});


		function validForm() { 

			<? if($bbs->editor==1){ //네이버 에디터 사용시??>
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
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
						$("#prod_thumb").attr("msg","썸네일 이미지를");
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


	
	<? if(isset($cate_no2)){ ?>
		cate_chg(2, "<?=$cate_no1?>","<?=$cate_no2?>");
	<?}?>

	<? if(isset($cate_no3)){ ?>
		setTimeout('cate_chg(3, "<?=$cate_no2?>","<?=$cate_no3?>")',50);
	<?}?>
	
	<? if(isset($cate_no4)){ ?>
		setTimeout('cate_chg(4, "<?=$cate_no3?>","<?=$cate_no4?>")',100);
	<?}?>

	<?if(isset($row->goods_idx)){?>
	getProduct("<?=$row->cate_no?>","<?=$row->goods_idx?>");
	<?}?>

	function cate_chg(depth, cate_no, sel_no)
	{
			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write",
					data: {ajax : "1", depth : depth, cate_no: cate_no, sel_no: sel_no},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).hide();
							$("#cate_no"+i).val("");
						}
						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no"+depth).show();							
						}else{
							getProduct(cate_no);
						}
					}	
				});
			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
					$("#cate_no"+i).val("");
				}
				
				$("#cate_depth").val(depth);
			}

	}


	function getProduct(cate_no,goods_idx)
	{
		$("#cate_no").val(cate_no);
		
				$.ajax({
					url: "<?=cdir()?>/dh_product/getProduct/"+cate_no,
					data: {ajax : "1", goods_idx : goods_idx},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						$(".product_list").show();
						$("#goods_idx").html(data);						
					}	
				});
	}
	

</script>





<? if($bbs->editor == "1"){ ?>

<script type="text/javascript" src="/_data/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">

var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "tx_content",
	sSkinURI: "/_data/smarteditor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["tx_content"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});



</script>



<? } ?>		