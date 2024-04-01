
	<?
		$send= "";
		if(isset($query_string) && isset($param)){
			$send.=$query_string.$param;
		}
	?>

	
		<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data" action="<?=$send?>">
			<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('USERID')) ? @$this->session->userdata('USERID') : "";?>" />
			<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
			<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
			<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">
			<input type="hidden" name="cate_idx" value="<? echo isset($row->cate_idx) ? $row->cate_idx : $this->input->get("cate_idx");?>">
			<input type="hidden" name="goods_idx" value="<?=$goods_row->goods_idx?>">
			<input type="hidden" name="cate_no" value="<?=$goods_row->cate_no?>">

			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board write -->
				<div class="board-write">
					<ul class="board-write-form">
						<li>
							<div class="field-label">구매상품</div>
							<div class="field-form">[<?=$goods_row->goods_name?>]</div>
						</li>
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
						<li><div class="field-label">평점</div>
							<div class="field-form review-board">
								<input type="radio" name="grade" id="grade5" value="5" <? if(isset($row->grade) && $row->grade==5){?>checked<?}?> <? if(empty($row->grade)){?>checked<?}?>> <label for="grade5"><span class="review-star" data-grade="5">5점</span></label><span class="mr20"></span>
								<input type="radio" name="grade" id="grade4" value="4" <? if(isset($row->grade) && $row->grade==4){?>checked<?}?>> <label for="grade4"><span class="review-star" data-grade="4">4점</span></label><span class="mr20"></span>
								<input type="radio" name="grade" id="grade3" value="3" <? if(isset($row->grade) && $row->grade==3){?>checked<?}?>> <label for="grade3"><span class="review-star" data-grade="3">3점</span></label><span class="mr20"></span>
								<input type="radio" name="grade" id="grade2" value="2" <? if(isset($row->grade) && $row->grade==2){?>checked<?}?>> <label for="grade2"><span class="review-star" data-grade="2">2점</span></label><span class="mr20"></span>
								<input type="radio" name="grade" id="grade1" value="1" <? if(isset($row->grade) && $row->grade==1){?>checked<?}?>> <label for="grade1"><span class="review-star" data-grade="1">1점</span></label>
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
					</ul>

					<p class="mt10"><small>※ 구매평의 내용이 적합하지 않은 경우, 통보 없이 삭제 될 수 있습니다.</small></p>

					<!-- Buttons -->
					<div class="board-view-btns">
						<input type="button" class="btn-normal" value="<? if($this->uri->segment(2)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="javascript:validForm();">
					</div><!-- END Buttons -->

				</div><!-- END board write -->
			</div><!-- END Board wrap -->


			



<script type="text/javascript">

	$(function(){
		$("#w-file1").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name").html(file_txt[2]);
			$(".file-attach-box").addClass("off");

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


			<? if($bbs->nospam==1){ ?>
			if (document.tx_editor_form.num.value == '') {
				alert("스팸방지 숫자를 입력해 주세요.");
				document.tx_editor_form.num.focus();
				return;
			}
			if (document.tx_editor_form.num.value != document.tx_editor_form.pnum.value) {
				alert("스팸방지 숫자가 일치하지 않습니다.");
				document.tx_editor_form.num.focus();
				return;
			}
			
			<?	 }	?>

			document.tx_editor_form.submit();
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