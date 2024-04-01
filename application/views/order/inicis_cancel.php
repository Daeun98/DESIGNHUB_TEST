 <script type="text/javascript">
	// 취소 버튼을 눌렀을 때 호출
		function card_cancel(trade_code,tno)
		{
			var url = "";

			<? if(isset($flag) && $flag=="admin" && $this->session->userdata('ADMIN_USERID')){ ?>
			url = "&a1a1admin";
			<?}?>

			document.ini.go_url.value="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/list/<?=$query_string.$param?>"+url;
			document.ini.tid.value=tno;
			document.ini.submit();

		}
</script>
<form name=ini method=post action="/pay/INIpay50/sample/INIcancel.php"> 
<input type=hidden name=mid size=10 value="<?=$shop_info['pg_id']?>">
<input type=hidden name=tid size=40 value="">
<input type=hidden name=msg size=40 value="고객변심">
<input type=hidden name="go_url" size=40 value="">
</form>