
	<?
		$send= "";
		if(isset($query_string) && isset($param)){
			$send.=$query_string.$param;
		}
	?>

	<style>
	.spam_div { border:0px solid #ddd; padding:0px 5px; float:left; margin-right:15px; }
	.spam_div > img { margin-top:2px; margin-bottom:-7px; }
	</style>
	
		<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data" action="<?=$send?>">
			<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('USERID')) ? @$this->session->userdata('USERID') : "";?>" />
			<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
			<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
			<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">
			<!-- <input type="hidden" name="cate_idx" value="<? echo isset($row->cate_idx) ? $row->cate_idx : $this->input->get("cate_idx");?>"> -->
			<input type="hidden" name="goods_idx" value="<? echo isset($goods_row->idx) ? $goods_row->idx : "0";?>">
			<input type="hidden" name="cate_no" value="<? echo isset($goods_row->cate_no) ? $goods_row->cate_no : "0";?>">

			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board write -->
				<div class="board-write">
					<ul class="board-write-form">
						<? if($bbs->bbs_cate=="Y"){?>
						<li><div class="field-label"><label for="qna-type"><?if($bbs->bbs_type==2){?>문의유형<?}else{?>카테고리<?}?></label></div>
							<div class="field-form">
								<select id="qna-type" name="cate_idx">
									<option value=""><?if($bbs->bbs_type==2){?>문의유형<?}else{?>카테고리<?}?>을 선택하세요.</option>
									<? foreach($cate_list as $c_list){ ?>
									<option value="<?=$c_list->idx?>" <? if(isset($row->cate_idx) && $row->cate_idx == $c_list->idx){?>selected<?}?>><?=$c_list->name?></option>
									<?}?>
								</select>
							</div>
						</li>
						<?}?>
						<li><div class="field-label"><label for="write-name">작성자</label></div>
							<div class="field-form">
								<input type="text" id="write-name" value="<? echo isset($row->name) ? $row->name : $this->session->userdata('NAME');?>" name="name">
							</div>
						</li>
						<? if($bbs->bbs_secret=="1"){ ?>
						<li><div class="field-label"><label for="write-name">비밀글</label></div>
							<div class="field-form">
								<input type="checkbox" id="chk-secret" class="ml10" name="secret" value="y" <? if(isset($row->secret) && $row->secret=='y'){?>checked<?}?>>
								<label for="chk-secret">비밀글로 작성합니다.</label>
							</div>
						</li>
						<?}?>
						<li <? if(@$this->session->userdata('USERID')){ ?>style="display:none;"<?}?>><div class="field-label"><label for="write-pw">비밀번호</label></div>
							<div class="field-form">
								<input type="password" id="write-pw" value="<? echo (@$this->session->userdata('PASSWD')) ? @$this->session->userdata('PASSWD') : "";?>" name="pwd">								
							</div>
						</li>
						<li><div class="field-label"><label for="write-title">제목</label></div>
							<div class="field-form">
								<input type="text" id="write-title" class="field-full" name="subject" value="<? echo isset($row->subject) ? $row->subject : "";?>">
							</div>
						</li>
						<li>
							<div class="write-editor">
								<? if($bbs->editor!=1){ //네이버 에디터 미사용?>
								<label for="write-content1" class="label-out">내용</label>
								<textarea name="tx_content" id="write-content1" cols="30" rows="15"><? echo isset($row->content) ? $row->content : "";?></textarea>
								
								<? }else{ //네이버 에디터 사용??>		
								<textarea name="tx_content" id="tx_content" rows="10" cols="100" style="width:100%; height:412px; display:none;"><? echo isset($row->content) ? $row->content : "";?></textarea>
								<?	 }	?>
							</div>
						</li>
						<li class="pb5" style="display:<? if( $bbs->bbs_pds ) { //자료실 사용 ?>block<?}else{?>none<?}?>;"><div class="field-label">파일첨부</div>
							<div class="field-form">
								<ul class="write-files">
									<li>
										<div class="file-attach-box "><!-- 파일선택후 : off 클래스 추가 -->
											<div class="file-attach">
												<span class="file-name"><? echo isset($row->real_file) ? $row->real_file : "파일을 선택해주세요.";?></span>
												<input type="file" id="w-file1" name="bbs_file">
												<label for="w-file1">파일찾기</label>
											</div>
											<? if(isset($row->bbs_file) && $row->bbs_file){?>
											<button type="button" class="plain btn-file-del"><img src="/image/board_img/btn_del.gif" alt="삭제"></button>
											<?}?>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<? if($bbs->nospam==1){?>
						<li><div class="field-label"><label for="write-title">보안문자</label></div>
							<div class="field-form">
								<div class="spam_div">
									<?=$imgData?>
								</div> 
								<input type="text" id="write-name" value="" name="spam_code" maxlength="5" style="width:70px;">
								<small class="ml5">왼쪽의 보안문자를 입력해주세요.</small>
							</div>
						</li>
						<?}?>
					</ul>
					<!-- Buttons -->
					<div class="board-view-btns">
						<input type="button" class="btn-normal" name="writeBtn" value="<? if($this->uri->segment(2)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="javascript:validForm();">
					</div><!-- END Buttons -->


				</div><!-- END board write -->
			</div><!-- END Board wrap -->

</form>




<script type="text/javascript">

	$(function(){
		$("#w-file1").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name").html(file_txt[2]);
			$(".file-attach-box").addClass("off");

		});

	});


		function validForm() { 

			<? if($bbs->editor==1){ ?>
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
			<?}?>

			<? if($bbs->bbs_cate=="Y"){ ?>

			if (document.tx_editor_form.cate_idx.value == '') {
				alert("<?if($bbs->bbs_type==2){?>문의유형<?}else{?>카테고리<?}?>을 선택해 주십시오.");
				document.tx_editor_form.cate_idx.focus();
				return;
			}

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


			<? if($bbs->nospam==1){ ?>
			if (document.tx_editor_form.spam_code.value == '') {
				alert("스팸방지 숫자를 입력해 주세요.");
				document.tx_editor_form.spam_code.focus();
				return;
			}
			if (document.tx_editor_form.spam_code.value != "<?=$cnum?>") {
				alert("스팸방지 숫자가 일치하지 않습니다.");
				document.tx_editor_form.spam_code.focus();
				return;
			}
			
			<?	 }	?>

			document.tx_editor_form.submit();
			document.tx_editor_form.writeBtn.disabled = true;
			return;
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