
<?
if($this->uri->segment(4)=="edit"){
	
	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}?>

			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
			<input type="hidden" name="idx" value="<? echo isset($row->idx) ? $row->idx : ""?>">
			<input type="hidden" name="code" value="<? echo isset($row->code) ? $row->code : ""?>">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:150px;">
						<col style="width:200px;">
						<col style="width:;">
					</colgroup>
					<tbody>
						<tr class="selected">
							<td colspan="3">
								<p style="line-height:1.7em;" class="pt10 pb10 pl20"><strong>
								ㆍ 쿠폰코드는 고유한 값이므로 등록 한 뒤에 수정이 불가능 합니다. <br>
								ㆍ 쿠폰을 사용자에게 발급한 뒤에는 쿠폰내용을 수정해도 이미 발급한 사용자 쿠폰엔 적용되지 않습니다. <br>
								ㆍ 배송비 무료쿠폰은 배송비 전액이 할인되기 때문에 할인금액을 따로 설정할 수 없습니다. <br>
								ㆍ 생일쿠폰, 회원가입쿠폰은 1회성 쿠폰이므로 (생일쿠폰 : 1년에 한번, 회원가입 쿠폰 : 회원가입시 단 1번) 여러개 등록하게 되면 중복사용이 될 수 있으니 참고 바랍니다.<br>
								ㆍ 생일쿠폰, 회원가입쿠폰은 관리자가 직접 사용자에게 지급하지 않아도 관리자에 생성되어있으면 모든 회원에게 지급됩니다.<br>
								ㆍ 생일쿠폰은 회원이 생일인 달에 로그인하였을 때 지급 됩니다.<br>
								ㆍ 회원가입쿠폰은 회원가입시 지급됩니다. <br>
								</strong>
								</p>
							</td>
						</tr>
						<tr>
							<th>쿠폰코드</th>
							<td colspan="2"><? if(isset($row->code)){ echo $row->code." &nbsp;<font color='red'>(수정불가)</font>"; }else{?><input type="text" class="width-m" id="code" name="code" msg="쿠폰코드를" value="" maxlength="12">
							<input type="button" value="자동생성" class="btn-m" onclick="codeMake();">
							<?}?>
							</td>
						</tr>
						<tr>
							<th>쿠폰명</th>
							<td colspan="2"><input type="text" class="width-ls" name="name" msg="쿠폰명을" value="<? echo isset($row->name) ? $row->name : ""?>"></td>
						</tr>
						<tr>
							<th>쿠폰타입</th>
							<td colspan="2">
								<select name="type" id="type" onchange="disOn(this.value);">
									<option value="0" <? if(isset($row->type) && $row->type=="0"){ echo "selected"; } ?>>할인쿠폰</option>
									<option value="1" <? if(isset($row->type) && $row->type=="1"){ echo "selected"; } ?>>생일쿠폰</option>
									<option value="2" <? if(isset($row->type) && $row->type=="2"){ echo "selected"; } ?>>회원가입쿠폰</option>
									<option value="3" <? if(isset($row->type) && $row->type=="3"){ echo "selected"; } ?>>배송비무료쿠폰</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>이용기한종류</th>
							<td colspan="2">
							<input type="radio" name="date_flag" id="date_flag0" value="0" <? if(isset($row->date_flag) && $row->date_flag=="0"){ echo "checked"; }else if(empty($row->idx)){ echo "checked"; } ?>> <label for="date_flag0">기한직접입력</label>
								<input type="radio" name="date_flag" id="date_flag1" value="1" <? if(isset($row->date_flag) && $row->date_flag=="1"){ echo "checked"; } ?>> <label for="date_flag1">발급시점선택</label>
							</td>
						</tr>
						<tr class="date_flag date_flag0" <? if(isset($row->date_flag) && $row->date_flag==1){?>style="display:none;"<?}?>>
							<th>이용기한</th>
							<td colspan="2">
							<input type="text" class="width-s" name="start_date" id="start_date" value="<? echo isset($row->start_date) ? $row->start_date : ""?>" readonly>
							~ <input type="text" class="width-s" name="end_date" id="end_date" value="<? echo isset($row->end_date) ? $row->end_date : ""?>" readonly>
							</td>
						</tr>
						<tr class="date_flag date_flag1" <? if(empty($row->date_flag) || (isset($row->date_flag) && $row->date_flag==0)){?>style="display:none;"<?}?>>
							<th>이용기한</th>
							<td colspan="2">
								<select name="max_day" id="max_day">
									<option value="+1 day" <? if(isset($row->max_day) && $row->max_day=="+1 day"){ echo "selected"; } ?>>발급시점으로부터 1일</option>
									<option value="+3 day" <? if(isset($row->max_day) && $row->max_day=="+3 day"){ echo "selected"; } ?>>발급시점으로부터 3일</option>
									<option value="+10 day" <? if(isset($row->max_day) && $row->max_day=="+10 day"){ echo "selected"; } ?>>발급시점으로부터 10일</option>
									<option value="+1 month" <? if(isset($row->max_day) && $row->max_day=="+1 month"){ echo "selected"; } ?>>발급시점으로부터 1개월</option>
									<option value="+2 month" <? if(isset($row->max_day) && $row->max_day=="+2 month"){ echo "selected"; } ?>>발급시점으로부터 2개월</option>
									<option value="+3 month" <? if(isset($row->max_day) && $row->max_day=="+3 month"){ echo "selected"; } ?>>발급시점으로부터 3개월</option>
									<option value="+6 month" <? if(isset($row->max_day) && $row->max_day=="+6 month"){ echo "selected"; } ?>>발급시점으로부터 6개월</option>
									<option value="+12 month" <? if(isset($row->max_day) && $row->max_day=="+12 month"){ echo "selected"; } ?>>발급시점으로부터 12개월</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>할인가/할인율</th>
							<td colspan="2">
								<div class="discount" <? if(isset($row->type) && $row->type==3){?>style="display:none;"<?}?>>
									<input type="text" class="width-s" name="price" id="price" value="<? echo isset($row->price) ? $row->price : ""?>"> 
									<select name="discount_flag" onchange="javascript:if(this.value==0){ $('.max_price').hide(); }else{ $('.max_price').show(); };">
										<option value="0" <? if(isset($row->discount_flag) && $row->discount_flag=="0"){ echo "selected"; } ?>>원</option>
										<option value="1" <? if(isset($row->discount_flag) && $row->discount_flag=="1"){ echo "selected"; } ?>>%</option>
									</select>
								</div>
								<div class="discount_delivery" <? if(empty($row->type) || (isset($row->type) && $row->type!=3)){?>style="display:none;"<?}?>>배송비 전액 무료</div>
							</td>
						</tr>
						<tr>
							<th>최소결제금액</th>
							<td colspan="2">
								<input type="text" class="width-s" name="min_price" id="min_price" value="<? echo isset($row->min_price) ? $row->min_price : "0"?>" msg="최소결제금액을" > 원  
								<small class="ml10">이상부터 사용 가능. (미입력시 결제금액 0원부터 사용 가능)</small>
							</td>
						</tr>
						<tr class="max_price" <? if(isset($row->max_price) && $row->discount_flag==1){?><?}else{?>style="display:none;"<?}?>>
							<th>최대할인금액</th>
							<td colspan="2">
								<input type="text" class="width-s" name="max_price" id="max_price" value="<? echo isset($row->max_price) ? $row->max_price : "0"?>" msg="최대할인금액을" > 원
								<small class="ml10">까지만 사용 가능. (미입력시 모든금액 사용 가능)</small>
							</td>
						</tr>
						<tr>
							<th>회원등급적용</th>
							<td colspan="2">
								<input type="checkbox" name="member_use" id="member_use" value="1" <? if(isset($row->member_use) && $row->member_use=="1"){ echo "checked"; } ?> >
								<select name="member_level" id="member_level" class="ml5" <? if(empty($row->member_use) || ( isset($row->member_use) && $row->member_use=="" )){?>style="display:none;"<?}?>>
									<option value="">등급선택</option>
									<? foreach($member_level as $lv){ ?>
									<option value="<?=$lv->level?>" <? if(isset($row->member_level) && $row->member_level==$lv->level){ echo "selected"; } ?>><?=$lv->name?></option>
									<?}?>
								</select>
							</td>
						</tr>
						<tr>
							<th>쿠폰이미지</th>
							<td colspan="2">
							
								<ul class="file w40">
									<li>
										<input type="file" id="file01" name="img_file"/><label for="file01" class="btn-file">파일찾기</label>
										<span class="file-name"><? echo isset($row->real_file) ? $row->real_file : "선택한 파일이 없습니다.";?></span>
									</li>
								</ul>
								<p class="float-l">
								<? if(isset($row->img_file) && $row->img_file!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="coupon_img" style="vertical-align:middle;" onclick="file_del('coupon_img',<?=$row->idx?>)"><?}?>

							</td>
						</tr>
						<? if(isset($row->code)){?>
						<tr>
							<th>쿠폰발급 url</th>
							<td colspan="2"> 
								<input type="text" class="width-ls" id="copy-text" value="http://<?=$shop_info['shop_domain'].cdir()?>/dh_order/couponGive/<?=$row->code?>" readonly>
								<input type="button" class="btn-clear" value="url 복사하기" onclick="copy_to_clipboard()" data-clipboard-text="http://<?=$shop_info['shop_domain'].cdir()?>/dh_order/couponGive/<?=$row->code?>" title="복사하기">
							</td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/order/coupon/m/<?=$query_string.$param?>';">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChkCoupon('frm');">
				</p>

<script>
function copy_to_clipboard() {
  var copyText = document.getElementById("copy-text");
  copyText.select();
  document.execCommand("Copy");
}
</script>

			</form>

<script type="text/javascript" src="http://zeroclipboard.org/javascripts/zc/v2.1.6/ZeroClipboard.js"></script>
<script>

	function file_del(mode, idx, num)
	{
		if(confirm("이미지를 삭제하시겠습니까?")){
			$.ajax({
				url: "<?=cdir()?>/product/file_del",
				data: {ajax : "1", mode : mode, idx: idx},
				async: true,
				cache: false,
				error: function(xhr){
				},
				success: function(data){
					if(mode=="coupon_img"){
						$(".file-name").html("선택한 파일이 없습니다.");
						$("."+mode).hide();			
					}
				}	
			});
		}
	}


	$(function(){
		$("#file01").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name").html(file_txt[2]);

		});
	});

$(function(){
	$("input[name='date_flag']").change(function(){
		if(this.checked){
			$(".date_flag").hide();
			$(".date_flag"+$(this).val()).show();
		}
	});

	$("#member_use").change(function(){
		if(this.checked){
			$("#member_level").show();
		}else{
			$("#member_level").hide();
		}
	});

});

function disOn(value){

	if(value==3){
		$(".discount").hide();
		$(".discount_delivery").show();
	}else{
		$(".discount").show();
		$(".discount_delivery").hide();
	}
	
	if(value==1){
		$("#date_flag1").prop("checked",true);
		$(".date_flag").hide();
		$(".date_flag"+$("input[name='date_flag']:checked").val()).show();
		$("#max_day").val("+1 month").attr("selected", "selected");
	}else{
		$("#date_flag0").prop("checked",true);
		$(".date_flag").hide();
		$(".date_flag"+$("input[name='date_flag']:checked").val()).show();
		$("#max_day option:eq(0)").attr("selected", "selected");
	}
}


function codeMake()
{
	$.get("<?=$_SERVER['PHP_SELF']?>?ajax=1",
		function(data){ 
			if(data > 0){ //중복값이 있으면 다시 생성
					codeMake(); 
			}else{
				$("#code").val(data);
			}
		}
	);
}


function frmChkCoupon(frmName)
{
		if (checkForm(frmName)) {				

			var date_flag = $("input[name='date_flag']:checked").val();
			if(date_flag==0){
				if($("#start_date").val()==""){
					alert("이용기한을 입력해주세요.");
					$("#start_date").focus();
					return;
				}else if($("#end_date").val()==""){
					alert("이용기한을 입력해주세요.");
					$("#end_date").focus();
					return;
				}else if($("#start_date").val() > $("#end_date").val()){
					alert("이용기한 시작날짜는 종료날짜보다 높을수 없습니다.");
					return;
				}
			}

			if($("#type").val()!=3 && $("#price").val()==""){
					alert("할인금액 or 할인율을 입력해주세요.");
					$("#price").focus();
					return;
			}

			$("#"+frmName).submit();
		}
}

/*
$(document).ready(function() {

var client = new ZeroClipboard($("#copy-button"));

client.on( "ready", function( readyEvent ) {

  client.on( "aftercopy", function( event ) {

    alert("주소가 복사되었습니다." );
  });
 });
});
*/

</script>