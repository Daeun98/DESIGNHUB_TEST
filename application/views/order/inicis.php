
<script>

		function checkPay()
		{
			var total_price = $("#total_price").val();
			var buyername = document.order_form.name.value;
			var buyeremail = document.order_form.email1.value+"@"+document.order_form.email2.value;
			var buyertel =document.order_form.phone1.value+"-"+document.order_form.phone2.value+"-"+document.order_form.phone3.value;
			
			var trade_method = $("input[name='trade_method']:checked").val();						
										

			document.SendPayForm.buyername.value = buyername;
			document.SendPayForm.buyeremail.value = buyeremail;
			document.SendPayForm.buyertel.value = buyertel;

			if(trade_method==1){ //카드
				var gopaymethod = "Card";
			}else if(trade_method==3){ //계좌이체
				var gopaymethod = "DirectBank";
			}else if(trade_method==4){ //가상계좌
				var gopaymethod = "Vbank";
			}

			$.ajax({
					url: "<?=cdir()?>/dh_order/inicis_post",
					type: "POST",
					data: {mode:"request",total_price: total_price, TRADE_CODE: "<?=$TRADE_CODE?>"},
					async: true,
					cache: false,
					error: function(xhr){	},
					success: function(data){										
						if(data){

											
							var text = data.split("@@");
							var mid = text[0];
							var price = text[1];
							var signature = text[2];
							var mKey = text[3];
							var timestamp = text[4];
							var nointerest = text[5];
							var quotabase = text[6];

							$("#mid").val(mid);
							$("#send_price").val(price);
							$("#signature").val(signature);
							$("#mKey").val(mKey);
							$("#timestamp").val(timestamp);
							$("#nointerest").val(nointerest);
							$("#quotabase").val(quotabase);	
							$("#gopaymethod").val(gopaymethod);	

							setTimeout("pay()",50);

						}
					}	
			});


		}
 
</script>


<?
	$siteDomain = "http://".$_SERVER['HTTP_HOST']."/pay/stdpay/INIStdPaySample"; //가맹점 도메인 입력
?>
        <!-- 이니시스 표준결제 js -->				
				<? if($shop_info['pg_id'] == "INIpayTest"){?>
        <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
				<?}else{?>
        <script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script> 
				<?}?>


        <script type="text/javascript">
            function pay() {
                INIStdPay.pay('SendPayForm_id');
            }

        </script>


       <form id="SendPayForm_id" name="SendPayForm" method="POST">
				<input type="hidden" name="version" value="1.0" >
				<input type="hidden" id="mid" name="mid" value="" >
				<input type="hidden" id="goodname" name="goodname" value="<? echo $totalCnt>1 ? $cart_list[0]->goods_name." 외" : $cart_list[0]->goods_name; ?>" >
				<input type="hidden" id="oid" name="oid" value="<?php echo $TRADE_CODE ?>" >
				<input type="hidden" id="send_price" name="price" value="" >
				<input type="hidden" id="currency" name="currency" value="WON" >
				<input type="hidden" id="buyername" name="buyername" value="" >
				<input type="hidden" id="buyertel" name="buyertel" value="" >
				<input type="hidden" id="buyeremail" name="buyeremail" value="" >
				<input type="hidden" id="timestamp" name="timestamp" value="" >
				<input type="hidden" id="signature" name="signature" value="" >
				<input type="hidden" id="returnUrl" name="returnUrl" value="http://<?php echo $_SERVER['HTTP_HOST'] ?><?=cdir()?>/dh_order/inicis_post/<?=$this->uri->segment(3)?>" >
				<input type="hidden" id="mKey" name="mKey" value="" >

				<input type="hidden" id="gopaymethod" name="gopaymethod" value="" >
				<input type="hidden" name="offerPeriod" value="2015010120150331" >
				<input type="hidden" name="acceptmethod" value="HPP(1):no_receipt:va_receipt:vbanknoreg(0):below1000" >
				<input type="hidden" name="languageView" value="" >
				<input type="hidden" name="charset" value="" >
				<input type="hidden" name="payViewType" value="" >
				<input type="hidden" name="closeUrl" value="<?php echo $siteDomain ?>/close.php" >
				<input type="hidden" name="popupUrl" value="<?php echo $siteDomain ?>/popup.php" >
				<input type="hidden" name="nointerest" id="nointerest" value="" >
				<input type="hidden" name="quotabase" id="quotabase" value="" >	
				<input type="hidden" name="vbankRegNo" value="" >
				<input type="hidden" name="merchantData" value="" >
       </form>

			 
<iframe name="tmp_frame" border=0 frameborder=0 width=0 height=0 style="display:none;"></iframe>