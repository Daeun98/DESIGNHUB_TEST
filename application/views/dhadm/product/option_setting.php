<? 
if(empty($row->code)){
	$code="option_".time();
	$cnt="0";
}else{
	$code=$row->code;
}
?>
<!doctype html> 
<html lang="ko">
 <head>
  <title>옵션설정</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	
	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">
		<h3 class="icon-pen">옵션<? if(empty($row->code)){ ?>추가<?}else{?>수정<?}?></h3>
		
		<form method="post" name="option_form">
		<input type="hidden" name="cnt" id="cnt" value="0">
		<input type="hidden" name="Totalcnt" id="Totalcnt" value="0">
		<input type="hidden" name="option_code" id="option_code" value="<?=$code?>">
		<!-- 제품 옵션 설정 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 등록/수정/삭제를 위한 테이블</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>옵션명</th>
					<td><input type="text" name="title" value="<? echo isset($row->title) ? $row->title : "";?>"></td>
				</tr>
				<tr>
					<th>옵션코드</th>
					<td><?=$code?> <? if(empty($row->code)){ ?>(자동생성) <?}?></td>
				</tr>
				<tr>
					<th>옵션항목</th>
					<td>
						<div class="opt-setting-box">
							<? if($cnt==0){?><p class="align-c ft-s pt60">옵션 항목을 등록해주세요.</p><?}?>
							<ul class="opt-setting">
							</ul>
						</div>
					</td>
				</tr>
				<tr class="add_form">
					<th>항목추가</th>
					<td>
						<div class="align-l float-l mt10 ml10" style="width:75px;">항목명 : </div><p class="mt5"><input type="text" name="option_name"></p>
						<? if($shop_info['shop_use']=="y"){?><div class="align-l float-l mt10 ml10" style="width:75px;">판매가격 : </div><p class="mt5"><input type="text" name="option_price"> 원</p><?}?>
						<div class="align-l float-l mt10 mb20 ml10" style="width:75px;">재고수량 : </div><p class="mt5"><input type="text" name="option_number" id="option_number" class="width-xs" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" id="unlimit" name="unlimit" value="1" checked><label for="unlimit">무제한</label></p>
						<!-- <div class="align-l float-l mt10 mb20 ml10" style="width:75px;">적립금 : </div><p class="mt5"><input type="text" name="option_point"> P</p> -->
						<p class="mt15 mb5 align-c" style="width:95%;"><button type="button" class="btn-clear" onclick="option_add();">추가하기</button></p>					
					</td>
				</tr>
				<tr class="edit_form" style="display:none;">
					<th>항목수정</th>
					<td>
						<input type="hidden" id="edit_cnt">
						<div class="align-l float-l mt10 ml10" style="width:75px;">항목명 : </div><p class="mt5"><input type="text" id="option_edit_name"></p>
						<? if($shop_info['shop_use']=="y"){?><div class="align-l float-l mt10 ml10" style="width:75px;">판매가격 : </div><p class="mt5"><input type="text" id="option_edit_price"> 원</p><?}?>
						<div class="align-l float-l mt10 mb20 ml10" style="width:75px;">재고수량 : </div><p class="mt5"><input type="text" id="option_edit_number" class="width-xs" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" name="edit_unlimit" id="edit_unlimit" value="1" checked><label for="edit_unlimit">무제한</label></p>
						<!-- <div class="align-l float-l mt10 mb20 ml10" style="width:75px;">적립금 : </div><p class="mt5"><input type="text" id="option_edit_point"> P</p> -->
						<p class="mt15 mb5 align-c" style="width:95%;"><button type="button" class="btn-clear cancel_ok">취소하기</button> <button type="button" class="btn-clear edit_ok">수정하기</button></p>					
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->
		</form>

		<p class="align-c mt30">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-l btn-ok" value="확인" onclick="option_ok();">
		</p>

	<script>


	var frm = $('<form></form>');
	frm.attr('method', 'post');
	frm.appendTo('body');

	<? 
	if(isset($row->code) && $cnt > 0){ 
		foreach($option_list as $lt){	
	?>
		option_add('<?=$lt->name?>','<?=$lt->price?>','<?=$lt->number?>','<?=$lt->unlimit?>');
	<?
		}
	}
	?>



	function option_add(name,price,number,unlimit)
	{
		var form = document.option_form;

		if(!name){
			name = form.option_name.value;
			price = form.option_price.value;
			number = form.option_number.value;
			
			if($("input[name='unlimit']:checked").length > 0){
				unlimit = 1;
			}else{
				unlimit = 0;
			}


			if(form.option_name.value==""){
				alert('항목명을 입력해주세요.');
				form.option_name.focus();
				return;
			}

		}

		
		if(unlimit==1){	number = ""; }


		if(name){

			$(".ft-s").hide();

			var cnt = $("#cnt").val();
			cnt = parseInt(cnt)+1;
			var Totalcnt = $("#Totalcnt").val();
			Totalcnt = parseInt(Totalcnt)+1;


			var add_data = '<li class="option'+cnt+'">'+
											'<button type="button" class="plain" onclick="option_del('+cnt+')"><img src="/_dhadm/image/icon/prod_delete.jpg" alt="삭제"></button>'+
											'<span class="option_name'+cnt+'"> '+name+' <a href="javascript:option_edit('+cnt+')" style="font-size:9px;">[수정]</a></span>'+
											'<span class="move">'+
												'<button type="button" class="plain" title="위로" onclick="sortChg(\'u\','+cnt+')">▲</button>'+
												'<button type="button" class="plain" title="아래로" onclick="sortChg(\'d\','+cnt+')">▼</button>'+
											'</span>'+							
										'</li>';

			$(".opt-setting").append(add_data);
			
			<? if(isset($row->idx)){ ?>
			var	mode = $("<input type='hidden' value='edit' name='mode'>");
			<?}else{?>
			var	mode = $("<input type='hidden' value='add' name='mode'>");
			<?}?>

			if(cnt < Totalcnt){

				$("#option_name"+cnt).val(name);
				$("#option_price"+cnt).val(price);
				$("#option_number"+cnt).val(number);
				$("#option_unlimit"+cnt).val(unlimit);

			}else{
			
				var	option_name = $("<input type='hidden' value='"+name+"' name='option_name"+cnt+"' id='option_name"+cnt+"'>");
				var	option_price = $("<input type='hidden' value='"+price+"' name='option_price"+cnt+"' id='option_price"+cnt+"'>");
				var	option_number = $("<input type='hidden' value='"+number+"' name='option_number"+cnt+"' id='option_number"+cnt+"'>");
				var	option_unlimit = $("<input type='hidden' value='"+unlimit+"' name='option_unlimit"+cnt+"' id='option_unlimit"+cnt+"'>");

				frm.append(option_name);
				frm.append(option_price);
				frm.append(option_number);
				frm.append(option_unlimit);
				frm.append(mode);
				
				$("#Totalcnt").val(Totalcnt);

			}

			$("#cnt").val(cnt);

			form.option_name.value='';
			form.option_price.value='';
			form.option_number.value='';

			$("#option_number").attr("readonly",true);
			$("#option_number").attr("style","background-color:#F0F5F9;");
			$('#unlimit').prop("checked",true);

		}
	}

	function option_del(cnt)
	{	
		cancel_ok();

		/* 현재 선택된 폼값 비우기 */
		$("#option_name"+cnt).val("");
		$("#option_price"+cnt).val("");
		$("#option_number"+cnt).val("");
		$("#option_unlimit"+cnt).val(1);

		var addCnt = $("#cnt").val();

		for(i=cnt;i<=addCnt;i++){ //삭제된 다음 값부터 데이터를 다시 채운다.

			var j = i+1;

			$("#option_name"+i).val("");
			$("#option_price"+i).val("");
			$("#option_number"+i).val("");
			$("#option_unlimit"+i).val(1);
			$('.option'+i).remove();

			if(i < addCnt){		
				

				var NameTxt = $("#option_name"+j).val();
				var PriceTxt = $("#option_price"+j).val();
				var NumberTxt = $("#option_number"+j).val();
				var UnlimitTxt = $("#option_unlimit"+j).val();
				
				
				var reSetTxt = '<li class="option'+i+'">'+
										'<button type="button" class="plain" onclick="option_del('+i+')"><img src="/_dhadm/image/icon/prod_delete.jpg" alt="삭제"></button>'+
										'<span class="option_name'+i+'"> '+NameTxt+' <a href="javascript:option_edit('+i+')" style="font-size:9px;">[수정]</a></span>'+
										'<span class="move">'+
											'<button type="button" class="plain" title="위로" onclick="sortChg(\'u\','+i+')">▲</button>'+
											'<button type="button" class="plain" title="아래로" onclick="sortChg(\'d\','+i+')">▼</button>'+
										'</span>'+							
									'</li>';
				
				$(".opt-setting").append(reSetTxt);


				$("#option_name"+i).val(NameTxt);
				$("#option_price"+i).val(PriceTxt);
				$("#option_number"+i).val(NumberTxt);
				$("#option_unlimit"+i).val(UnlimitTxt);
			}
		}
		
		/* 카운트 마이너스 */
		addCnt = parseInt(addCnt)-1;
		$("#cnt").val(addCnt);

	}
	
	function sortChg(mode,cnt)
	{
		cancel_ok();

		var addCnt = $("#cnt").val();
		var ok = "";

		if(mode=="u"){
			if(cnt > 1){

				var chgCnt = parseInt(cnt)-1;
				ok = 1;


			}else{
				ok = "";
			}

		}else if(mode=="d"){

			if(cnt < addCnt ){
				
				var chgCnt = parseInt(cnt)+1;
				ok = 1;

			}else{
				ok = "";
			}
		}

		if(ok == 1){
			
				var chgNameTxt = $("#option_name"+chgCnt).val();
				var chgPriceTxt = $("#option_price"+chgCnt).val();
				var chgNumberTxt = $("#option_number"+chgCnt).val();
				var chgUnlimitTxt = $("#option_unlimit"+chgCnt).val();

				var NameTxt = $("#option_name"+cnt).val();
				var PriceTxt = $("#option_price"+cnt).val();
				var NumberTxt = $("#option_number"+cnt).val();
				var UnlimitTxt = $("#option_unlimit"+cnt).val();

				var reSetTxt = "";

				for(i=1;i<=addCnt;i++){			
					
					if(i==cnt){

						reSetTxt += '<li class="option'+i+'">'+
												'<button type="button" class="plain" onclick="option_del('+i+')"><img src="/_dhadm/image/icon/prod_delete.jpg" alt="삭제"></button>'+
												'<span class="option_name'+i+'"> '+chgNameTxt+' <a href="javascript:option_edit('+i+')" style="font-size:9px;">[수정]</a></span>'+
												'<span class="move">'+
													'<button type="button" class="plain" title="위로" onclick="sortChg(\'u\','+i+')">▲</button>'+
													'<button type="button" class="plain" title="아래로" onclick="sortChg(\'d\','+i+')">▼</button>'+
												'</span>'+							
											'</li>';

						$("#option_name"+i).val(chgNameTxt);
						$("#option_price"+i).val(chgPriceTxt);
						$("#option_number"+i).val(chgNumberTxt);
						$("#option_unlimit"+i).val(chgUnlimitTxt);
						

					}else if(i==chgCnt){
						

						reSetTxt += '<li class="option'+i+'">'+
												'<button type="button" class="plain" onclick="option_del('+i+')"><img src="/_dhadm/image/icon/prod_delete.jpg" alt="삭제"></button>'+
												'<span class="option_name'+i+'"> '+NameTxt+' <a href="javascript:option_edit('+i+')" style="font-size:9px;">[수정]</a></span>'+
												'<span class="move">'+
													'<button type="button" class="plain" title="위로" onclick="sortChg(\'u\','+i+')">▲</button>'+
													'<button type="button" class="plain" title="아래로" onclick="sortChg(\'d\','+i+')">▼</button>'+
												'</span>'+							
											'</li>';
						
						$("#option_name"+i).val(NameTxt);
						$("#option_price"+i).val(PriceTxt);
						$("#option_number"+i).val(NumberTxt);
						$("#option_unlimit"+i).val(UnlimitTxt);

					}else{

						reSetTxt += '<li class="option'+i+'">'+
												'<button type="button" class="plain" onclick="option_del('+i+')"><img src="/_dhadm/image/icon/prod_delete.jpg" alt="삭제"></button>'+
												'<span class="option_name'+i+'"> '+$("#option_name"+i).val()+' <a href="javascript:option_edit('+i+')" style="font-size:9px;">[수정]</a></span>'+
												'<span class="move">'+
													'<button type="button" class="plain" title="위로" onclick="sortChg(\'u\','+i+')">▲</button>'+
													'<button type="button" class="plain" title="아래로" onclick="sortChg(\'d\','+i+')">▼</button>'+
												'</span>'+							
											'</li>';
					}
				}

				$(".opt-setting").html(reSetTxt);
		}
	}

	
	function option_ok()
	{
		var form = document.option_form;

		if(form.title.value==""){
			alert('옵션명을 입력해주세요.');
			form.title.focus();
			return;
		}else if(form.cnt.value < 1){
			alert('옵션 항목을 등록해주세요.');
			return;
		}else{


			var mode = $("<input type='hidden' value='"+form.title.value+"' name='title'>");
			var title = $("<input type='hidden' value='"+form.title.value+"' name='title'>");
			var cnt = $("<input type='hidden' value='"+form.cnt.value+"' name='cnt'>");
			var option_code = $("<input type='hidden' value='"+form.option_code.value+"' name='option_code'>");

			frm.append(title);
			frm.append(cnt);
			frm.append(option_code);

			frm.submit();
		}

	}
	

	function option_edit(cnt)
	{
		$(".add_form").hide();
		$(".edit_form").show();

		$("#edit_cnt").val(cnt);

		var NameTxt = $("#option_name"+cnt).val();
		var PriceTxt = $("#option_price"+cnt).val();
		var NumberTxt = $("#option_number"+cnt).val();
		var UnlimitTxt = $("#option_unlimit"+cnt).val();

		$("#option_edit_name").val(NameTxt);
		$("#option_edit_price").val(PriceTxt);
		$("#option_edit_number").val(NumberTxt);
		
		if(UnlimitTxt==1){
			$("#edit_unlimit").prop("checked",true);
			$("#option_edit_number").attr("readonly",true);
			$("#option_edit_number").attr("style","background-color:#F0F5F9;");
		}else{
			$("#edit_unlimit").prop("checked",false);
			$("#option_edit_number").attr("readonly",false);
			$("#option_edit_number").attr("style","background-color:;");
		}

	}

	$(function(){
		$(".edit_ok").click(function(){

			var cnt = $("#edit_cnt").val();
			
			var EditNameTxt = $("#option_edit_name").val();
			var EditPriceTxt = $("#option_edit_price").val();
			var EditNumberTxt = $("#option_edit_number").val();
			var EditUnlimit = "";
			

			if($("input[name='edit_unlimit']:checked").length > 0){
				EditUnlimit = 1;
			}else{
				EditUnlimit = 0;
			}
		
			$(".option_name"+cnt).html(' '+EditNameTxt+' <a href="javascript:option_edit('+cnt+')" style="font-size:9px;">[수정]</a>')
							
			$("#option_name"+cnt).val(EditNameTxt);
			$("#option_price"+cnt).val(EditPriceTxt);
			$("#option_number"+cnt).val(EditNumberTxt);
			$("#option_unlimit"+cnt).val(EditUnlimit);

			cancel_ok();
		
		});


		$(".cancel_ok").click(function(){
			cancel_ok();
		});


		$("#unlimit").change(function(){
			if(this.checked==true){
				$("#option_number").val("");
				$("#option_number").attr("readonly",true);
				$("#option_number").attr("style","background-color:#F0F5F9;");
			}else{
				$("#option_number").attr("readonly",false);
				$("#option_number").attr("style","background-color:;");
			}
		});

		
		$("#edit_unlimit").change(function(){
			if(this.checked==true){
				$("#option_edit_number").val("");
				$("#option_edit_number").attr("readonly",true);
				$("#option_edit_number").attr("style","background-color:#F0F5F9;");
			}else{
				$("#option_edit_number").attr("readonly",false);
				$("#option_edit_number").attr("style","background-color:;");
			}
		});

		
	});


	function cancel_ok(){

			$("#edit_cnt").val("");
			$("#option_edit_name").val("");
			$("#option_edit_price").val("");
			$("#option_edit_number").val("");
			
			$(".add_form").show();
			$(".edit_form").hide();
			
	}
	
	</script>


	</div>
 </body>
</html>