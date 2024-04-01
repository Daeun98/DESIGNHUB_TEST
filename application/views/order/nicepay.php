<script>

		function checkPay()
		{
			var total_price = $("#total_price").val();
			var BuyerName = document.order_form.name.value;
			var BuyerEmail = document.order_form.email1.value+"@"+document.order_form.email2.value;
			var BuyerTel =document.order_form.phone1.value+"-"+document.order_form.phone2.value+"-"+document.order_form.phone3.value;
			var BuyerAddr =document.order_form.addr1.value+" "+document.order_form.addr2.value;
			
			var trade_method = $("input[name='trade_method']:checked").val();						
			
			document.checkForm.total_price.value = total_price;
			document.checkForm.BuyerName.value = BuyerName;
			document.checkForm.BuyerEmail.value = BuyerEmail;
			document.checkForm.BuyerTel.value = BuyerTel;
			document.checkForm.BuyerAddr.value = BuyerAddr;
			document.checkForm.PayMethod.value = trade_method;
			document.checkForm.submit();
		}
 
</script>

<form method="post" name="checkForm" target="chkFrm">
	<input type="hidden" name="pay_ajax" value="1">
	<input type="hidden" name="total_price">
	<input type="hidden" name="pay_trade_code" value="<?=$TRADE_CODE?>">
	<input type="hidden" name="BuyerName">
	<input type="hidden" name="BuyerEmail">
	<input type="hidden" name="BuyerTel">
	<input type="hidden" name="BuyerAddr">
	<input type="hidden" name="PayMethod">
</form>

<iframe name="chkFrm" frameborder="0" style="display:none;"></iframe>