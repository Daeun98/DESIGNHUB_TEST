<?


//=======       POPUP 창 설정 ==========================================================//
$now_time=time();

$left = 80;
$ii	 =	0;


foreach($popup as $popup_row) {
	$ii++;

	if($popup_row->lefts){	 $left=	$popup_row->lefts;	}else{	$left = $left;	 }
	if($popup_row->tops){ $top=	$popup_row->tops;	}else{	$top	=	110;	}
	$COOKIE_NAME="POPUP_COOKIE_".$popup_row->idx;

	if( $this->input->cookie('POPUP_COOKIE_'.$popup_row->idx) != 'NO' ) {
			$popup_row->height=$popup_row->height+24;
?>

<!--레이어팝업--> 
<script language="JavaScript">
function setCookie<?=$ii?>( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

<? if($popup_row->live==0) {?>
function closeWin<?=$ii?>(){
	if ( document.notice_form<?=$ii?>.popup_end<?=$ii?>.checked || $("input[id='popup-chk<?=$ii?>']:checked").length > 0) {
		setCookie<?=$ii?>( '<?=$COOKIE_NAME?>', 'NO', 24 );//쿠기 저장 기간은 1일로 한다.
	}
	
	//window.close();
	document.all['divpop<?=$ii?>'].style.display = "none";
	$('#m-popup<?=$ii?>').hide();
} 
<?} else if($popup_row->live==1) {?>
function closeWin<?=$ii?>(){
	if ( document.notice_form<?=$ii?>.popup_end<?=$ii?>.checked || $("input[id='popup-chk<?=$ii?>']:checked").length > 0) {
		setCookie<?=$ii?>( '<?=$COOKIE_NAME?>', 'NO', 365 );//쿠기 저장 기간은 1일로 한다.
	}
	//window.close();
	document.all['divpop<?=$ii?>'].style.display = "none";
	$('#m-popup<?=$ii?>').hide();
} 
<?}?>

function closeGo<?=$ii?>(url){
	document.all['divpop<?=$ii?>'].action.href='http://'+url;
	//window.close();
	document.all['divpop<?=$ii?>'].style.display = "none";
	$('#m-popup<?=$ii?>').hide();
} 


</script>


	<form name="notice_form<?=$ii?>">
	<!--popup-->
	<div id="divpop<?=$ii?>" style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; z-index:1000; visibility:hidden;" class="dh-popup-pc">
	<table width=<?=$popup_row->width?> height=<?=$popup_row->height?> cellpadding=2 cellspacing=0>
	<tr>
		<td align="left" height="<?=$popup_row->height-20?>" style="line-height:20px; background:#FFFFFF;word-break:break-all;border:1px solid #DEDEDE" valign="top">
			<p style="clear: none; float: none;"><? if($popup_row->display==0) {?>
				<?=$popup_row->content;?>
			<?} else if($popup_row->display==1) {?>
				<? if($popup_row->link_url) {?><a href="http://<?=$popup_row->link_url;?>"><img src='/_data/file/designImages/<?=$popup_row->popup_images;?>' border='0' <? if($popup_row->popup_img_width){ ?>width='<?=$popup_row->popup_img_width?>'<? } ?> <? if($popup_row->popup_img_height){ ?>height='<?=$popup_row->popup_img_height?>'<? } ?>  style="display:block;margin:0 auto;"></a>
				<?} else {?><img src='/_data/file/designImages/<?=$popup_row->popup_images;?>' border='0' <? if($popup_row->popup_img_width){ ?>width=<?=$popup_row->popup_img_width?><? } ?> <? if($popup_row->popup_img_height){ ?>width=<?=$popup_row->popup_img_height?><? } ?>>
				<?}?>
			<?}?></p>
		</td>
	</tr>
	<tr> 
		<td align=right bgcolor=#555555 height="20">
			<input type=checkbox name="popup_end<?=$ii?>">
			<font color=#FFFFFF>
			<? if($popup_row->live==0) {?>
			오늘 하루 이창을 열지 않음.
			<?} else if($popup_row->live==1) {?>
			이창은 다시는 띄우지 않음.
			<?}?>
			</font>

			<a href="javascript:closeWin<?=$ii?>();"><B><font color=#FFFFFF>[닫기]</font></B></a>
		</td>
	</tr>
	</table>
 
	</div>	
	
<!--
	반응형 start
	1. ★★★★★ 반응형 팝업일 경우, PC팝업은 기존 코드에 class="dh-popup-pc" 붙여주세요.
	2. 반응형, 모바일 팝업일 경우 모바일 팝업스타일은 이미지팝업으로 한정되어야 합니다.
	3. 관리자 이미지 업로드 권장 사이즈 필수 명시 부탁드립니다! : 600 * 600px
	4. 모바일 팝업의 위치는 #Container 내부의 마지막에 위치합니다.
-->
<div id="m-popup<?=$ii?>" class="dh-popup-m">
	<div class="dh-popup-img"><a href="<? if($popup_row->link_url) {?>http://<?=$popup_row->link_url;?><?}else{?>javascript:;<?}?>"><img src="/_data/file/designImages/<?=$popup_row->popup_images;?>" alt="간단설명"></a></div>
	<div class="dh-popup-chk">
		<input type="checkbox" id="popup-chk<?=$ii?>"> <label for="popup-chk<?=$ii?>">오늘 하루 이창을 열지 않음</label>
		<button type="button" onclick="javascript:closeWin<?=$ii?>();">[닫기]</button>
	</div>
</div>

	</form>

<!-- 모바일 팝업스타일 -->
<style type="text/css">
.dh-popup-pc {
	display:block;
}
.dh-popup-m {
	position:absolute;
	left:50%; top:50%;
	margin-left:-301px;
	margin-top:-314px;
	/* left:4.6875%; top:15px;
	max-width:90.625%; */
	z-index:99999;
	display:none;
}
.dh-popup-img {
	width:600px; height:600px;
	border:1px solid #202020;
}
.dh-popup-img a,
.dh-popup-img img {
	display:block;
	width:100%;
	height:100%;
}
.dh-popup-chk {
	padding:5px 10px;
	text-align:right;
	background:#202020;
	color:#fff;
	font-size:12px;
	line-height:15px;
}
.dh-popup-chk button {
	background:none;
	border:0;
	padding:0;
	outline:0;
	cursor:pointer;
	appearance:none;
	-webkit-appearance:none;
	-moz-appearance:none;
	color:#fff;
}

@media all and (max-width:1024px) {
	.dh-popup-pc {display:none;}
	.dh-popup-m {display:block;}
}
@media all and (max-width:640px) {
	.dh-popup-m {margin-left:-151px; margin-top:-164px;}
	.dh-popup-img {width:300px; height:300px;}
}
</style>

<!-- 반응형 end -->




 
<script language="Javascript">
 cookiedata = document.cookie;  
 if ( cookiedata.indexOf("<?=$COOKIE_NAME?>=NO") < 0 ){    
     document.all['divpop<?=$ii?>'].style.visibility = "visible";
     }
     else {
         document.all['divpop<?=$ii?>'].style.visibility = "hidden";
 }
 </script>




<?

			//echo"<script> window.open('../include/popup.php?idx=$popup_row->idx','','scrollbars=no,width=$popup_row->width,height=$popup_row->height,top=10,left=$left'); </script>";	
			$left = $left + $popup_row->width+30;
	}
}
//=====================================================================================
?>
