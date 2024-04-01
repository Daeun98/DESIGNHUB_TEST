<?
    /* ============================================================================== */
    /* =   PAGE : 취소 요청 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   아래의 ※ 주의 ※ 부분을 꼭 참고하시여 연동을 진행하시기 바랍니다.       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */
?>

    <script type="text/javascript">
	// 취소 버튼을 눌렀을 때 호출
		function card_cancel(trade_code,tno)
		{
			var url = "";

			<? if(isset($flag) && $flag=="admin" && $this->session->userdata('ADMIN_USERID')){ ?>
			url = "&a1a1admin";
			<?}?>

			document.cancel_info.go_url.value="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/list/<?=$query_string.$param?>"+url;

			document.cancel_info.tno.value=tno;
			jsf__go_cancel(document.cancel_info);

		}

    function  jsf__go_cancel( form )
    {

        var RetVal = false ;
        if ( form.tno.value.length < 14 )
        {
            alert( "KCP 거래 번호를 입력하세요" );
            form.tno.focus();
            form.tno.select();
        }
        else
        {
            openwin = window.open( "/pay/kcp/sample/proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );

			form.submit();
            RetVal = true ;
        }
        return RetVal ;
    }

    </script>

<?
    /* ============================================================================== */
    /* =    1. 취소 요청 정보 입력 폼(cancel_info)                                  = */
    /* = -------------------------------------------------------------------------- = */
    /* =   취소 요청에 필요한 정보를 설정합니다.                                    = */
    /* = -------------------------------------------------------------------------- = */
?>
  <form name="cancel_info" method="post" action="/pay/kcp/sample/pp_ax_hub_cancel.php">
	<input type="hidden" name="tno" value=""><!-- KCP 거래번호 -->
	<input type="hidden" name="mod_desc" value="고객의 변심"><!-- 변경 사유 -->
	<input type="hidden" name="req_tx"   value="mod"  />
	<input type="hidden" name="mod_type" value="STSC" />
	<input type="hidden" name="go_url" value="" />
	</form>
	  