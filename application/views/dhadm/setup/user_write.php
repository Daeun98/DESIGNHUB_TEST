
<?
if($this->uri->segment(4)=="edit"){
	
	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
				<!-- 제품정보 -->
				<h3 class="icon-pen">정보 <?if($this->uri->segment(4)=="write"){?>입력<?}else{?>수정<?}?></h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>아이디</th>
							<td><? if(isset($row->userid)){ echo $row->userid; }else{?><input type="text" class="width-l" name="userid" msg="아이디를" value=""><?}?></td>
							<th>비밀번호</th>
							<td><input type="password" class="width-l" name="passwd" <? if($this->uri->segment(4)=="write"){ ?> msg="비밀번호를"<?}?>></td>
						</tr>
						<tr>
							<th>이름</th>
							<td><input type="text" class="width-l" name="name" msg="이름을" value="<? echo isset($row->name) ? $row->name : "";?>"></td>
							<th>level</th>
							<td>
								<select name="level">
									<? if(isset($row->level) && $row->level=="1"){ ?>
									<option value="1" <? echo (isset($row->level) && $row->level=="1") ? "selected" : ""; ?>>슈퍼관리자</option>
									<? }else if(isset($row->level) && $row->level=="2"){ ?>
									<option value="2" <? echo (isset($row->level) && $row->level=="2") ? "selected" : ""; ?>>슈퍼관리자</option>
									<? }else{ ?>
									<option value="3" <? echo (isset($row->level) && $row->level=="3") ? "selected" : ""; ?>>관리자</option>
									<? } ?>
								</select>
							</td>
						</tr>
						<!-- <tr>
							<th>Start Url</th>
							<td><input type="text" class="width-l" name="main_url" msg="Start Url을" value="<? echo isset($row->main_url) ? $row->main_url : "";?>"></td>
							<th></th>
							<td></td>
						</tr> -->
					</tbody>
				</table>

				
				<h3 class="icon-pen">메뉴 권한 설정<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:7%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>권한 설정</th>
							<td colspan="3">							
							<? 
							if(isset($row->level) && $row->level=="1"){
								
								echo "모든 권한";

							}else{
							?>
							- <input type="checkbox" name="allChk" id="allChk"><label for="allChk"><strong>전체선텍</strong></label>
							<ul style="margin-top:6px;">	

							<?

								$cnt=0;
								foreach($emp_row as $emp){ 
									$cnt++;
									$emp_arr = explode(",",$emp->emp);
							?>
									<li style="line-height:25px;"><? if($emp->lvl > 1){?>&nbsp;&nbsp;&nbsp;<?}?> - <input type="checkbox" name="emp[]" id="emp<?=$emp->id?>" value="<?=$emp->id?>" <? if(isset($row->level) && in_array($row->idx,$emp_arr)){?>checked<?}?> class="<?if($emp->lvl==1){?>lv1<?}else{?> pid<?=$emp->pid?><?}?>"><label for="emp<?=$emp->id?>"><?=$emp->nm?></label></li>
							<?
								}	
							}
							?>
							
							</ul>
						</td>
					</tbody>
				</table>


				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='/html/dhadm/admin_user/<?=$query_string?>';">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk2('frm');">
				</p>

			</form>


<script>

function frmChk2(frmName,mode)
{
		if (checkForm(frmName)) {					
			if(mode=="editor"){
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
			}

			<? if(isset($row->level) && $row->level=="1"){ ?>

				$("#"+frmName).submit();

			<?}else{?>

			if($('input[name^="emp"]:checked').length==0){
				alert('메뉴 권한은 한가지 이상 선택하셔야 합니다.');
			}else{
				$("#"+frmName).submit();
			}

			<?}?>
		}
		return;								
}

$(".lv1").change(function(){
	var id = this.value;
  if(this.checked){
		$(".pid"+id).prop("checked",true);
	}else{
		$(".pid"+id).prop("checked",false);
	}
});

$("#allChk").change(function(){

	var checkObj = $('input[name^="emp"]');

  if(this.checked){
    checkObj.prop("checked",true);
  }else{
    checkObj.prop("checked",false);
  }

});

<? if(isset($row->level) && $row->level!="1"){ ?>


$('input[name^="emp"]').change(function(){
	if(this.checked==false){
		$("#allChk").prop("checked",false);
	}

	allChkfun();

});


function allChkfun(){

	if($('input[name^="emp"]:checked').length == <?=$cnt?>){
			$("#allChk").prop("checked",true);
	}
}

allChkfun();
<?}?>

</script>