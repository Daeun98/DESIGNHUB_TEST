
 //파일 첨부 시 이름 삽입
	function file_chg(value,num){
		var txt = value.split('\\');
		if(!num){ num = ""; }
		$(".file-name"+num).html(txt[2]);
	}


function frmChk(frmName,mode)
{
		if (checkForm(frmName)) {					
			if(mode=="editor"){
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
			}else if(mode=="p_editor"){

				oEditors.getById["content1"].exec("UPDATE_CONTENTS_FIELD", []);
				oEditors2.getById["delivery"].exec("UPDATE_CONTENTS_FIELD", []);
				oEditors3.getById["return"].exec("UPDATE_CONTENTS_FIELD", []);
			}

			$("#"+frmName).submit();
			$("input[name='writeBtn'").attr("disabled",true);
		}
		return;								
}


function koreanCharCheck(inputStr) {

	for( var i = 0; inputStr.length; i++ ) {

		var checkChar = inputStr.charCodeAt(i);

		// 한글체크부분 하위 if 문에서 true 이면 한글이 포함되어 있는것이다.

		if( (0xAC00 <= checkChar && checkChar <= 0xD7A3) || (0x3131 <= checkChar && checkChar <= 0x318E) ) {

			return true;

		}else{

			return false;

		}

	}

}


//제품뷰에서 게시판 등록 ajax
function board_write(code,goods_idx)
{
		$.ajax({
			url: "/html/dh_board/write/"+code,
			data: {ajax: 1, goods_idx: goods_idx},
			async: true,
			cache: false,
			error: function(xhr){	},
			success: function(data){
				$("."+code+"_list").html(data);
			}	
	});	

	

}


function go_login(url)
{
	alert('회원 전용입니다. 로그인을 해주세요.');
	location.href="/html/dh_member/login/?go_url="+url;
}

function SearchInputSendit() {
	if(event.keyCode==13) { 
		search();
	}
}


function search(){
	if(bbs_search_form.search_order.value=="")	{
		alert("검색할 내용을 입력해 주십시오.");
		bbs_search_form.search_order.focus();
		return;
	}
	bbs_search_form.submit();
}



function rtn_engnum_mix_chk(str)
{
 var chk_num = str.search(/[0-9]/g);
 var chk_eng = str.search(/[a-z]/ig);

 if(chk_num < 0 || chk_eng < 0)
 {
  return false;
 }

 return true;
}


 function CheckPass(str){
   var reg1 = /^[a-z0-9]{6,20}$/;    // a-z 0-9 중에 6자리 부터 20자리만 허용 한다는 뜻이구요
   var reg2 = /[a-z]/g;    
   var reg3 = /[0-9]/g;
   return(reg1.test(str) &&  reg2.test(str) && reg3.test(str));
  };



		//======================================
		//	자동으로 콤마 넣기
		//======================================

		 function number_format(num,s_price) {
			 var total_num	=	parseInt(num) + parseInt(s_price);
			 var a	=	total_num;
			 
			 var num_str = total_num.toString()
			 var result = ''
			  for(var i=0; i<num_str.length; i++) {
				  
					var tmp = num_str.length-(i+1)
					if(i%3==0 && i!=0) result = ',' + result
					result = num_str.charAt(tmp) + result
			   }
				return result

		   }

/* 온라인문의 start*/

function res(value){
	$("#email2").val(value);
	if(value != ""){
		$("#email2").attr("readonly","readonly");
	}else{
		$("#email2").attr("readonly",false);
	}
}

function online_sendit(){

	var frm = document.online_form;

	if(frm.agree.checked==false){
		alert("이용약관에 동의해주세요.");
		frm.agree.focus();
	}else if(frm.company.value==""){
		alert("기업명을 입력해주세요.");
		frm.company.focus();
	}else if(frm.name.value==""){
		alert("담당자명을 입력해주세요.");
		frm.name.focus();
	}else if(frm.tel.value==""){
		alert("연락처를 입력해주세요.");;
		frm.tel.focus();
	}else if(frm.email1.value==""){
		alert("이메일을 입력해주세요.");;
		frm.email1.focus();
	}else if(frm.email2.value==""){
		alert("이메일을 입력해주세요.");;
		frm.email2.focus();
	}else if(frm.content.value==""){
		alert("내용을 입력해주세요.");;
		frm.content.focus();
	}else{
		frm.submit();
	}
}

/* 온라인문의 end*/



/* 게시판 start*/
function search(){
	if(bbs_search_form.search_order.value=="")	{
		alert("검색할 내용을 입력해 주십시오.");
		bbs_search_form.search_order.focus();
		return;
	}
	bbs_search_form.submit();
}


function bbs_coment(){
	var form = document.bbs_coment_form;
	if(form.name.value=="")	{
		alert("이름을 입력해주세요.");
		form.name.focus();
		return;
	}else if(form.pwd.value=="")	{
		alert("비밀번호를 입력해주세요.");
		form.pwd.focus();
		return;
	}else if(form.coment.value=="")	{
		alert("코멘트 내용을 입력해주세요.");
		form.coment.focus();
		return;
	}
	form.submit();
	return;
}


// 입력폼 체크 자바스크립트
function basic_setup_sendit() {
	var form=document.admin_form;

	if(form.admin_userid.value=="") {
		alert("관리자 아이디를 입력해 주세요.");
		form.admin_userid.focus();
	} else if(form.shop_domain.value=="") {
		alert("도메인을 입력해 주세요.");
		form.shop_domain.focus();
	} else {
		form.submit();
	}
}


// 입력폼 체크 자바스크립트
function basic_sendit() {
	var form=document.admin_form;

	if(form.admin_userid.value=="") {
		alert("아이디를 입력해 주세요.");
		form.admin_userid.focus();
	} else if(form.safeguard_admin.value=="") {
		alert("이름을 입력해 주세요.");
		form.safeguard_admin.focus();
	} else {
		form.submit();
	}
}

$(function(){
		$(".all_chk").change(function(){

     var checkObj = $('.chkNum');

          if(this.checked){
               checkObj.prop("checked",true);
          }else{
               checkObj.prop("checked",false);
          }
     });
});


function all_del(){


	if($('input:checkbox[id="chkNum"]:checked').length == 0){
		alert("삭제할 글을 선택해주세요.");
		return;
	}else{

		document.order_form.submit();

	}
}
/* 게시판 end*/



/* menu 관리 start */

function menu_add(){
	var frmCnt = $("#frmCnt").val();
	var menuCnt = parseInt($("#menu_cnt").val())+1;

	var text = 	'<tr class="form_cnt'+menuCnt+'">'+
					'<input type="hidden" name="level'+menuCnt+'" value="1">'+
					'<td>1차</td>'+
					'<td><input type="checkbox" name="status'+menuCnt+'" value="Y" checked ></td>'+
					'<td><input name="name'+menuCnt+'" type="text" class="write_title" size="60" ></td>'+
					'<td><input name="link'+menuCnt+'" type="text" class="write_title" size="250"></td>'+
					'<td><input name="rank'+menuCnt+'" type="text" class="write_title" size="25"  style="text-align:center;"></td>'+
					'<td><input type="button" class="board_bt_style06" value="삭제" onclick="can('+menuCnt+')"></td>'+
				'</tr>';


	$(".free_board").append(text);
	$("#frmCnt").val(parseInt(frmCnt)+1);
	$("#menu_cnt").val(parseInt($("#menu_cnt").val())+1);
}

function can(cnt){
	$(".form_cnt"+cnt).remove();
	$("#menu_cnt").val(parseInt($("#menu_cnt").val())-1);
}


function menu_del(idx){
	document.del_form.del_idx.value = idx;
	document.del_form.submit();
}

function m_add2(idx,name){
	$(".menu2_add").show();
	$(".menu2_name").html(name);
	$("#ref").val(idx);

}

function menu_add2()
{
	var form = document.menu2_form;

	if(form.name.value == ""){
		alert("등록할 2차메뉴의 이름을 입력해 주세요.");
		form.name.focus();
	}else{
		form.submit();
	}
	
}


/* menu 관리 end */



/* 게시판 설정 start */

// 폼 전송
function bbsSendit() {
	var form=document.bbs_reg_form;
	if(form.name.value=="") {
		alert("게시판 제목을 입력해 주십시오.");
		form.name.focus();
	} else if( form.code.value=="") {
		alert("게시판 코드를 입력해 주십시오.");
		form.code.focus();
	}  else {
		form.submit();			
	}
}

// 뉴 마크
function newCheck() {
	var form=document.bbs_reg_form;
	if(form.new_check.checked  == true ) {
		form.new_mark.disabled = false;
	} else {
		form.new_mark.disabled = true;			
	}
}

// 쿨 마크
function coolCheck() {
	var form=document.bbs_reg_form;
	if(form.cool_check.checked  == true ) {
		form.cool_mark.disabled = false;
	} else {
		form.cool_mark.disabled = true;			
	}
}

// 게시판 형태
function artCheck() {

	var form=document.bbs_reg_form;
	if(form.bbs_type[0].checked ) {
		form.list_width.disabled = true;
		form.list_width.value="0";
		form.list_height.value = 15;
	} else if(form.bbs_type[1].checked ) {
		form.list_width.value="0";
		form.list_width.disabled = true;
		form.bbs_coment[1].checked = true;
		form.bbs_pds[1].checked = true;
		form.list_height.value = 15;
	} else if(form.bbs_type[2].checked || form.bbs_type[5].checked  ) {
		form.bbs_pds[0].checked = true;
		form.list_width.disabled = false;
		form.list_width.value = 4;
		form.list_height.value = 16;
	}
}

/* 게시판 설정 end */


/* 배너 등록 start */


function banner_sendit() {
	var form=document.banner_form;
	if(form.title.value=="") {
		alert("배너명을 입력해 주세요.");
		form.title.focus();
	} else {
		form.submit();
	}
}
/* 배너 등록 end */


/* 이미지 뷰 start */

function imagesView( idx, w, h ,mode){
	window.open("/html/admin/popup_images/"+idx+"/"+mode+"/","","scrollbars=no,width="+w+",height="+h+",top=200,left=200");
}
/* 이미지 뷰 end */


function resendit(){
	location.href="/";
}


function nullcheck(id, val, type){

	if(!type){ type = "text"; }

	if( type == "text" ){

		if($("#"+id).val() == ""){
			alert(val+" 입력해주세요.");
			$("#"+id).focus();
			return false;
		}

	}else if( type == "agree" ){
		
		if (document.getElementById(id).checked == false){
			alert(val+"에 동의해 주세요");
			document.getElementById(id).focus();
			return false;
		}

	}
}



// 배송 관련 자바스크립트
function expressShow() {
	var form=document.admin_form;
	if( form.express_check[1].checked ) {
		document.all.express_view.style.display="";
		form.express_money.disabled = false;
	} else {
		document.all.express_view.style.display="none"; 
		form.express_money.value = "";
		form.express_money.disabled = true;
	}
}



/********************************************************************
 *
 * Form 관련 스크립트 함수 모음
 *
 *******************************************************************/
	// 폼 검증 함수
	function checkForm(f) {
		var fObj;	// 폼 요소
		var fOId;	// 폼 ID 이름
		var fTyp;	// 폼 요소 Type
		var fVal;	// 폼 요소 Value
		var fMsg;	// 경고 메시지 속성
		var fNum;	// 숫자만 입력 속성
		var fMax;	// 최대 길이 지정
		var fMin;	// 최소 길이 지정
		var fMxN;	// 최대값 지정
		var fMnN;	// 최소값 지정
		var fMal;	// 메일 FORMAT
		var fLng;	// 길이값
		var fKMax;	// 최대 길이 지정(한글)
		var fNumEng;// 영문, 숫자 체크

		var rtnV    = true;		

		$("#"+f+" input, #"+f+" select, #"+f+" textarea").each(function(){ 
			fObj	= $(this);
			fOId	= $(this).attr("id");
			fTyp	= toUpperCase(fObj.attr("type"));
			fVal	= fObj.val();
			fMsg	= fObj.attr("msg");		  // 경고 메시지
			fNum	= fObj.attr("chknum");	  // 숫자만 기입 가능하도록
			fMax	= fObj.attr("maxlen");	  // 최대 입력글자수 제한
			fKMax	= fObj.attr("maxlenK");	  // 최대 입력글자수 한글만 제한
			fMin	= fObj.attr("minlen");	  // 최소 입력글자수 제한
			fMxN	= fObj.attr("maxnum");	  // 최대 숫자 제한
			fMnN	= fObj.attr("minnum");	  // 최소 숫자 제한
			fMal	= fObj.attr("chkmail");	  // 이메일 체크
			fLng	= fObj.attr("chklen");    // 길이체크			
			fNumEng = fObj.attr("chknumeng"); // 영문, 숫자 체크

			

			// 체크해야 하는 필수 폼인지 확인
			var chkBool = false;
			if (fMsg != undefined || getLen(fVal) > 0) chkBool = true;

			// select 타입 인식 불가시 기본 select box 로 인식
			if (fTyp == "") fTyp = "SELECT-ONE";

			if (chkBool && fMsg != undefined && (fTyp == "TEXT" || fTyp == "HIDDEN" || fTyp == "TEXTAREA" || fTyp == "PASSWORD") && fVal.replace(/ /gi,"") == "") {	
				if(fTyp == "HIDDEN"){
					alert(fMsg);
				}else{
					alert(fMsg + " 입력해 주세요");
				}
				if (fTyp != "HIDDEN" && fTyp != "TEXTAREA") {fObj.focus();}
				rtnV = false;
				return false;
			}
			if (chkBool && fMsg != undefined && (fTyp == "FILE") && fVal =="") {
				alert(fMsg + " 입력해주세요");
				rtnV = false;
				return false;
			}
			if (chkBool && fMsg != undefined && (fTyp == "SELECT-ONE" || fTyp == "SELECT-MULTIPLE") && fVal =="") {
				alert(fMsg + " 선택해 주세요");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMsg != undefined && fTyp == "RADIO" && checkChecked(fOId,"radio") == false) {
				alert(fMsg);
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMsg != undefined && fTyp == "CHECKBOX" && checkChecked(fOId,"checkbox") == false) {
				alert(fMsg);
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fNum != undefined && isNaN(fVal)) {
				alert("숫자로만 입력해 주세요");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMax != undefined && fMax < getLen(fVal)) {
				alert("입력된 글자수가 "+fMax+"자보다 작아야합니다.");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fKMax != undefined && fKMax < getLen(fVal)) {
				alert("입력된 글자수가 "+fKMax+"자보다 작아야합니다.\n(영문 "+fKMax+"자, 한글 "+Math.floor(fKMax/2)+"자 까지 가능합니다.)");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMin != undefined && fMin > getLen(fVal)) {
				alert("입력된 글자수가 "+fMin+"자보다 커야합니다.");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fLng != undefined && fLng != getLen(fVal)) {
				alert(""+fLng+"자리로 입력해주세요.");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMxN != undefined && parseInt(fMxN) < parseInt(fVal)) {
				alert("입력된 숫자는 "+fMxN+"보다 작아야합니다.");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMnN != undefined && parseInt(fMnN) > parseInt(fVal)) {
				alert("입력된 숫자는 "+fMnN+"보다 커야합니다.");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fMal != undefined && checkEmail(fVal) == false && fVal != "") {
				alert("이메일 주소가 올바르지 않습니다");
				rtnV = false;
				fObj.focus(); return false;
			}
			if (chkBool && fNumEng != undefined && checkNumEng(fVal) == false && fVal != "") {
				alert(fNumEng+" 영문, 숫자를 조합해서 입력해주세요.");
				rtnV = false;
				fObj.focus(); return false;
			}
			
		});

		return rtnV;
	}

	// 폼에 해당하는 컨트롤들의 기본값 쉽게 셋팅해 주기
	function initForm(f) {
		var nLen;	// form 요소의 갯수
		var ival;	// 각 요소의 default value 값 즉! 초기화하고자 하는값(일치형)
		var ivalin;	// 각 요소의 default value 값 즉! 초기화하고자 하는값(포함형)
		var fTyp;	// form 요소의 타입(select, radio, checkbox...)

		$("#"+f+" input, #"+f+" select").each(function(){ 
			fObj	= $(this);
			fOId	= $(this).attr("id");
			fTyp	= toUpperCase(fObj.attr("type"));
			ival	= $(this).attr("ival");
			ivalin	= $(this).attr("ivalin");

			// 이상한 케이스 발견 사용자 쪽에서 select 타입 인식 불가
			if (fTyp == "") fTyp = "SELECT-ONE";

			if (ival != undefined && fTyp == "SELECT-ONE") {
				for (i=0;i<$("#"+fOId+" option").length;i++) {
					if (ival == $("#"+fOId+" option:eq("+i+")").val()) {
						fObj.val(ival);
					}					
				}
			}
			if (ival != undefined && (fTyp == "RADIO" || fTyp == "CHECKBOX")) {
				if (ival == fObj.val()) {
					fObj.attr("checked","checked");
				}
			}
			if (ivalin != undefined && (fTyp == "RADIO" || fTyp == "CHECKBOX")) {
				if (ivalin.indexOf(fObj.val()) != -1) {
					fObj.attr("checked","checked");
				}
			}			
		});

	}
	// 배열 요소일 경우 checked 된것이 있는지 확인
	function checkChecked(objid,objType) {
		var ret = false;
		if($("input:"+objType+"[id='"+objid+"']:checked").val() == undefined) {
			ret = false;
		} else {
			ret = true;
		}
		return ret;
	}
	// 이메일 유효성 체크
	function checkEmail(str){
	    var reg = /^((\w|[\-\.])+)@((\w|[\-\.])+)\.([A-Za-z]+)$/;
	    if (str.search(reg) != -1) {
			return true;
		}
		return false;
	}
	// 문자 길이 반환 (영문 1byte, 한글 2byte 계산)
	function getLen(str) {
		var len;
	    var temp;

	    len = str.length;
	    var tot_cnt = 0;

	    for(k=0;k < len;k++){
	    	temp = str.charAt(k);
	    	if(escape(temp).length > 4)
	    		tot_cnt += 2;
	    	else
	    		tot_cnt++;
	    }
	    return tot_cnt;
	}
	// 대문자 변환 ex) toUpperCase(문자)
	function toUpperCase(str) {
		var ret;
		str != null ? ret = str.toUpperCase() : ret = "";
		return ret;
	}
	// 영문하고 숫자를 조합해서 입력
	function checkNumEng(str){
		var reg1 = /^[a-zA-Z0-9]{6,16}$/;
		var reg2 = /[a-zA-Z]/g;
		var reg3 = /[0-9]/g;

		return (reg1.test(str) && reg2.test(str) && reg3.test(str));
	}



	function delOk(idx)
	{	
		var form = document.delFrm;

		if(confirm("삭제 하시겠습니까?")){
			form.del_idx.value = idx;
			form.submit();
		}
	}