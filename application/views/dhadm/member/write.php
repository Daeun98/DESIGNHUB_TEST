
<?
if($this->uri->segment(4)=="edit"){

	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

	if(isset($row->email)){
		$email = explode("@",$row->email);
	}

}?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
				<?if($this->uri->segment(4)=="write"){?>
				<input type="hidden" name="userid_chk" value="" msg="아이디 중복확인을 해주세요.">
				<?}else{?>
				<input type="hidden" name="userid" value="<? echo isset($row->userid) ? $row->userid : "";?>">
				<?}?>

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:20%;">
						<col style="">
					</colgroup>
					<tbody>
						<tr>
							<th> * 아이디</th>
							<td><? if(isset($row->userid)){ echo $row->userid;  }else{?><input type="text" class="width-m" name="userid" msg="아이디를" value="">
							<input type="button" class="btn-clear" value="중복확인" onclick="id_check();">
							<?}?>
							<? if(isset($row->userid) && $row->outmode==1){?><em class="dh_red ml5"> (탈퇴회원)</em><?}?>
							</td>
						</tr>
						<tr>
							<th> * 비밀번호</th>
							<td><input type="password" class="width-m" name="passwd" <? if($this->uri->segment(4)=="write"){ ?> msg="비밀번호를"<?}?>></td>
						</tr>
						<tr>
							<th> * 비밀번호 확인</th>
							<td><input type="password" class="width-m" name="passwd_check" <? if($this->uri->segment(4)=="write"){ ?> msg="비밀번호 확인을"<?}?>></td>
						</tr>
						<tr>
							<th> * 이름</th>
							<td><input type="text" class="width-m" name="name" msg="이름을" value="<? echo isset($row->name) ? $row->name : "";?>"></td>
						</tr>
						<tr>
							<th> * 이메일</th>
							<td><input type="text" class="width-m" name="email1" msg="이메일을" value="<? echo isset($email[0]) ? $email[0] : "";?>">@<input type="text" class="width-m" name="email2" id="email2" msg="이메일을" value="<? echo isset($email[1]) ? $email[1] : "";?>">
										<select name="email_sel" onchange="res(this.value);">
											<option value="">직접입력</option>
											<option value="naver.com">naver.com</option>
											<option value="hanmail.net">hanmail.net</option>
											<option value="nate.com">nate.com</option>
											<option value="paran.com">paran.com</option>
											<option value="empal.com">empal.com</option>
											<option value="hotmail.com">hotmail.com</option>
											<option value="gmail.com">gmail.com</option>
											<option value="dreamwiz.com">dreamwiz.com</option>
											<option value="lycos.co.kr">lycos.co.kr</option>
											<option value="yahoo.co.kr">yahoo.co.kr</option>
											<option value="korea.com">korea.com</option>
											<option value="hanmir.com">hanmir.com</option>
										</select>
							</td>
						</tr>
						<tr>
							<th>생년월일</th>
							<td>
							<input type="text" class="width-xs" name="birth_year" maxlength="4" value="<? echo isset($row->birth_year) ? $row->birth_year : "";?>"> 년
							<input type="text" class="width-xs" name="birth_month" maxlength="2" value="<? echo isset($row->birth_month) ? $row->birth_month : "";?>"> 월
							<input type="text" class="width-xs" name="birth_date" maxlength="2" value="<? echo isset($row->birth_date) ? $row->birth_date : "";?>"> 일
								<span class="ml15"></span>
								<input type="radio" id="birth01" value="1" name="birth_gubun"  Checked> <label for="birth01">양력</label>
								<input type="radio" id="birth02" value="2" name="birth_gubun"  > <label for="birth02">음력</label>
							</td>
						</tr>
						<tr>
							<th>주소</th>
							<td><input type="text" class="width-xs" name="zip1" id="zipcode1" value="<? echo isset($row->zip1) ? $row->zip1 : "";?>" readonly>
							<input type="button" class="btn-clear" value="우편번호찾기" onclick="javascript:sample6_execDaumPostcode();"><br>
							<p class="mt5"><input type="text" class="width-l" name="add1" id="address1" value="<? echo isset($row->add1) ? $row->add1 : "";?>" readonly value="">
							<input type="text" class="width-l" name="add2" id="address2" value="<? echo isset($row->add2) ? $row->add2 : "";?>">
							</td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><input type="text" class="width-xs" name="tel1" value="<? echo isset($row->tel1) ? $row->tel1 : "";?>" maxlength="3"> -
							<input type="text" class="width-xs" name="tel2" value="<? echo isset($row->tel2) ? $row->tel2 : "";?>" maxlength="4"> -
							<input type="text" class="width-xs" name="tel3" value="<? echo isset($row->tel3) ? $row->tel3 : "";?>" maxlength="4">
							</td>
						</tr>
						<tr>
							<th> * 휴대폰</th>
							<td><input type="text" class="width-xs" name="phone1" msg="휴대폰 번호를" value="<? echo isset($row->phone1) ? $row->phone1 : "";?>" maxlength="3"> -
							<input type="text" class="width-xs" name="phone2" msg="휴대폰 번호를" value="<? echo isset($row->phone2) ? $row->phone2 : "";?>" maxlength="4"> -
							<input type="text" class="width-xs" name="phone3" msg="휴대폰 번호를" value="<? echo isset($row->phone3) ? $row->phone3 : "";?>" maxlength="4">
							</td>
						</tr>
						<tr>
							<th>메일링 서비스</th>
							<td><input type="checkbox" id="chk_mailing" name="mailing" value="1" <? echo (isset($row->mailing) && $row->mailing=="1") ? "checked" : "";?>>
									<label for="chk_mailing">메일수신에 동의하시면 체크해주세요.</label>
							</td>
						</tr>
						<tr>
							<th>회원레벨</th>
							<td>
								<select name="level">
									<? foreach ($level_row as $lv_row){ ?>
									<option value="<?=$lv_row->level?>" <? echo (isset($row->level) && $row->level==$lv_row->level) ? "selected" : "";?>><?=$lv_row->name?></option>
									<?}?>
								</select>
							</td>
						</tr>
						<!-- <tr>
							<th>sms 서비스</th>
							<td><input type="checkbox" id="chk_sms" name="resms" value="1" <? echo (isset($row->resms) && $row->resms=="1") ? "checked" : "";?>>
									<label for="chk_sms">sms수신에 동의하시면 체크해주세요.</label>
							</td>
						</tr> -->

						<? if(isset($row->userid) && $row->outmode==1){?>

						<tr>
							<th>탈퇴사유</th>
							<td>
							<?=$row->outtype?>
							</td>
						</tr>
						<tr>
							<th>요청사항</th>
							<td>
							<?=nl2br($row->outmsg)?>
							</td>
						</tr>

						<?}?>

					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:history.back(-1);">
				<input type="button" class="btn-ok btn-xl" name="writeBtn" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChkJoin();">
				</p>

			</form>

	<iframe name="idcheck" frameBorder=0 width=0 height=0 scrolling=no marginwidth="0" marginheight="0"></iframe>

<script>

function frmChkJoin()
{
		if (checkForm("frm")) {

			<?if($this->uri->segment(4)=="write"){?>

			if(document.frm.passwd.value != document.frm.passwd_check.value){
				alert("비밀번호가 정확하지 않습니다. 정확히 입력해 주세요.");
				document.frm.passwd_check.focus();
				return;
			}

			<?}?>

			$("#frm").submit();
			document.frm.writeBtn.disabled = true;

		}
		return;
}

// 아이디 중복체크
function id_check(){

		var form=document.frm;

		if(form.userid.value=="") {
			alert("회원 아이디를 입력해 주세요.");
			form.userid.focus();
		} else {

			idcheck.location.href="?idCheck=1&userid="+form.userid.value;

		}

}


</script>