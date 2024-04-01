<!-- 모바일 팝업스타일 -->
<style type="text/css">
.dh-popup {
	position:absolute;
	left:4.6875%; top:15px;
	max-width:90.625%;
	z-index:99999999;
	display:none;
}
.dh-popup-img {
	padding:5px;
	background:#fff;
	border:1px solid #202020;
}
.dh-popup-img a,
.dh-popup-img img {
	display:block;
	max-width:100%;
}
.dh-popup-chk {
	padding:5px 10px;
	text-align:right;
	background:#202020;
	color:#fff;
	font-size:12px;
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

@media all and (max-width:767px) {
	.dh-popup {display:block;}
	.dh-pc-popup {display:none;}
}
</style>


<?
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
			if ( $(".popup_end<?=$ii?>").is(':checked') == true ) {
				setCookie<?=$ii?>( '<?=$COOKIE_NAME?>', 'NO', 1 );//쿠기 저장 기간은 1일로 한다.
			}

			//window.close();
			$(".pc_pop<?=$ii?>").hide();
			$(".m_pop<?=$ii?>").hide();
		}
		<?} else if($popup_row->live==1) {?>
		function closeWin<?=$ii?>(){
			if ( $(".popup_end<?=$ii?>").is(':checked') == true ) {
				setCookie<?=$ii?>( '<?=$COOKIE_NAME?>', 'NO', 365 );//쿠기 저장 기간은 365일로 한다.
			}
			//window.close();
			$(".pc_pop<?=$ii?>").hide();
			$(".m_pop<?=$ii?>").hide();
		}
		<?}?>
	</script>

	<!--popup-->
	<div style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; z-index:1000;" class="dh-pc-popup pc_pop<?=$ii?>">
		<table width=<?=$popup_row->width?> height=<?=$popup_row->height?> cellpadding=2 cellspacing=0>
			<tr>
				<td align="left" height="<?=$popup_row->height-20?>" style="line-height:20px; background:#FFFFFF;word-break:break-all;border:1px solid #DEDEDE" valign="top">
					<p style="clear: none; float: none;"><? if($popup_row->display==0) {?>
						<?=$popup_row->content;?>
					<?} else if($popup_row->display==1) {?>
						<? if($popup_row->link_url) {?><a href="<?=$popup_row->link_url;?>" <?if(strpos($popup_row->link_url,"http")!==false){?>target="_blank"<?}?>><img src='/_data/file/designImages/<?=$popup_row->popup_images;?>' border='0' <? if($popup_row->popup_img_width){ ?>width='<?=$popup_row->popup_img_width?>'<? } ?> <? if($popup_row->popup_img_height){ ?>height='<?=$popup_row->popup_img_height?>'<? } ?>  style="display:block;margin:0 auto;"></a>
						<?} else {?><img src='/_data/file/designImages/<?=$popup_row->popup_images;?>' border='0' <? if($popup_row->popup_img_width){ ?>width=<?=$popup_row->popup_img_width?><? } ?> <? if($popup_row->popup_img_height){ ?>width=<?=$popup_row->popup_img_height?><? } ?>>
						<?}?>
					<?}?></p>
				</td>
			</tr>
			<tr>
				<td align=right bgcolor=#555555 height="20">
					<input type=checkbox class="popup_end<?=$ii?>">
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

	<!-- 모바일 팝업의 위치는 Container 내부의 마지막에 위치합니다. -->
	<div class="dh-popup m_pop<?=$ii?>">
		<div class="dh-popup-img">
			<?php
			if($popup_row->display == 0){
			?>
				<?=$popup_row->content;?>
			<?php
			}
			else{
			?>

				<? if($popup_row->link_url) {?>
					<a href="<?=$popup_row->link_url?>" <?if(strpos($popup_row->link_url,"http")!==false){?>target="_blank"<?}?>>
						<img src='/_data/file/designImages/<?=$popup_row->popup_images;?>'>
					</a>
				<?} else {?>
					<img src='/_data/file/designImages/<?=$popup_row->popup_images;?>'>
				<?}?>

			<?php
			}
			?>
		</div>
		<div class="dh-popup-chk">
			<input type="checkbox" class="popup_end<?=$ii?>" id="popup-chk<?=$ii?>" value="Y"> <label for="popup-chk<?=$ii?>"><? if($popup_row->live==0) {?>오늘 하루 이창을 열지 않음<?} else if($popup_row->live==1) {?>이창은 다시는 띄우지 않음<?}?></label>
			<button type="button" onclick="closeWin<?=$ii?>()">[닫기]</button>
		</div>
	</div>
	<?
		$left = $left + $popup_row->width+30;
	}
}
?>