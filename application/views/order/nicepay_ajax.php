<?
	// 클라이언트 ip 가져오기
	$ip = $_SERVER['REMOTE_ADDR'];
	
	// 전문생성일시
	$ediDate = date("YmdHis");
	
	// 상점서명키 (꼭 해당 상점키로 바꿔주세요)
	$merchantKey = $shop_info['pg_key'];
	
	$total_price = $this->input->post("total_price");

	// hash 처리  
	$MerchantID = $shop_info['pg_id'];
	$price = $total_price;
	$str_src = $ediDate.$MerchantID.$price.$merchantKey;
	$hash_String = base64_encode(md5($str_src));
	// 가상계좌 입금 예정일 설정
	$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	$vDate = date("Ymd",$tomorrow);

?>
<script src="https://web.nicepay.co.kr/flex/js/nicepay_tr_utf.js" language="javascript"></script>
<script language="javascript">
NicePayUpdate();	//Active-x Control 초기화

/**
nicepay	를 통해 결제를 시작합니다.
*/
function nicepay() {

	var payForm		= document.payForm;
	
	// 필수 사항들을 체크하는 로직을 삽입해주세요.
	goPay(payForm);
}

/**
	결제 결과를 submit 합니다.
	알맞게 form을 수정하십시요.
*/
function nicepaySubmit(){
	document.payForm.submit();
}

/**
결제를 취소 할때 호출됩니다.
*/
function nicepayClose()
{
	alert("결제가 취소 되었습니다");
}

function chkTransType(value)
{
	document.payForm.TransType.value = value;
}

function chkPayType()
{
	//document.payForm.PayMethod.value = checkedButtonValue('selectType');
	//alert(document.payForm.PayMethod.value);
}

setTimeout("nicepay()",200);

</script>

<input type="hidden" name="nicePrice" id="nicePrice">

<form name="payForm" method="post" action="/pay/nicepay/nicePayResult_utf.php">
<select name="PayMethod" id="PayMethod" style="width:160px;display:none;" >
  <option value="CARD" <? if($this->input->post("PayMethod")==1){?>selected<?}?>>신용카드</option>
  <option value="BANK" <? if($this->input->post("PayMethod")==3){?>selected<?}?>>계좌이체</option>
  <option value="VBANK" <? if($this->input->post("PayMethod")==4){?>selected<?}?>>가상계좌</option>
  <!-- <option value="CELLPHONE" <? if($this->input->post("PayMethod")==1){?>selected<?}?>>휴대폰결제</option> -->
</select>  

<input type="radio" name="TransTypeRadio" value="0" onClick="javascript:chkTransType('0')" checked style="display:none;"><!--일반-->
<input type="radio" name="TransTypeRadio" value="1" onClick="javascript:chkTransType('1')" checked style="display:none;"><!--에스크로-->

<input name="GoodsName" type="hidden" value="<? echo $totalCnt>1 ? $cart_list[0]->goods_name." 외" : $cart_list[0]->goods_name; ?>"/>
<input name="Moid" type="hidden" value="<?=$this->input->post("pay_trade_code")?>"/>
<input name="BuyerName" type="hidden" value="<?=$this->input->post("BuyerName")?>"/>
<input name="BuyerEmail" type="hidden" value="<?=$this->input->post("BuyerEmail")?>"/>
<input name="BuyerTel" type="hidden" value="<?=$this->input->post("BuyerTel")?>"/>
<input name="MID" type="hidden" value="<?=$MerchantID?>"/>

<select name="GoodsCl" style="width:160px;display:none;">
	<option value="1" selected>실물</option>
	<option value="0">컨텐츠</option>
</select>  

<!--<input type="button" value="요청하기" onClick="javascript:nicepay();">  하단에 버튼이 있는경우 버튼포함 여백 높이 30px -->

<!-- 상품 갯수 -->
<input type="hidden" name="GoodsCnt" value="<?=$totalCnt?>">
<input type="hidden" name="ParentEmail" value="<?=$shop_info['shop_email']?>">

<!-- 주소 -->
<input type="hidden" name="BuyerAddr" value="<?=$this->input->post("BuyerAddr")?>">
<input type="hidden" name="UserIP" value="<?=$ip?>">

<!-- 상품 가격(상단의 price에서 가격을 지정하십시요) -->
<input type="hidden" name="Amt" value="<?=$price?>">

<!-- 결제 타입 0:일반, 1:에스크로 -->
<input type="hidden" name="TransType" value="0">

<!-- 결제 옵션  -->
<input type="hidden" name="OptionList" value="">

<!-- 가상계좌 입금예정 만료일  -->
<input type="hidden" name="VbankExpDate" value="<?=$vDate?>"> 

<!-- 구매자 고객 ID -->
<input type="hidden" name="MallUserID" value="<? echo isset($member_stat->userid) ? $member_stat->userid : ""; ?>"> 
<!-- 암호화 항목 -->
<input name="EncodeParameters" type="hidden" value="CardNo,CardExpire,CardPwd"/>

<!-- 변경 불가 -->
<input type="hidden" name="EdiDate" value="<?=$ediDate?>">
<input type="hidden" name="EncryptData" value="<?=$hash_String?>" >
<input type="hidden" name="TrKey" value="">
</form>