<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "order";
	
	Header("Content-type: application/vnd.ms-excel"); 
	Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls"); 
	Header("Content-Description: PHP5 Generated Data"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">"); 

?>
<style>
.xTxt{mso-number-format:"\@";}
td{font-size:11px;}
.xTxtF{color:red;}
</style>
<table cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
<Tr align=center height=30 bgcolor="#EFEFEF">
	<td width=50>No</td>
	<td width=120>주문번호</td>
	<td width=100>주문일자</td>
	<td>주문상품</td>
	<td width=50>수량</td>
	<td width=110>상품금액</td>
	<td width=110>총결제금액</td>
	<td width=110>할인금액</td>
	<td width=110>실결제금액</td>
	<td width=100>결제방법</td>
	<td width=120>주문자 아이디</td>
	<td width=120>주문자 이름</td>
	<td width=150>주문자 이메일</td>
	<td width=120>주문자 핸드폰</td>
	<td width=120>배송 받는 이름</td>
	<td width=120>배송 휴대폰</td>
	<td width=120>배송 전화번호</td>
	<td width=300>배송주소</td>
	<td width=200>배송시 요청사항</td>
	<td width=100>운송장번호</td>
	<td width=100>거래상태</td>
<?
$cnt=0;
foreach($list as $lt){
	$cnt++;
?>
<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
	<td class='xTxt'><?=$cnt?></td>
	<td><?=$lt->trade_code?></td>
	<td><?=substr($lt->trade_day,0,10)?></td>
	<td align=left class='xTxt' style="min-width:350px;"><?=$lt->goods_name?>
	<? if($lt->option_cnt > 0){
		for($i=0;$i<$lt->option_cnt;$i++){
		if(isset($option['option_arr'.$lt->g_idx][$i]['title'])){
		?>
		<br>- [<?=$option['option_arr'.$lt->g_idx][$i]['title']?> : <?=$option['option_arr'.$lt->g_idx][$i]['name']?> <? if($option['option_arr'.$lt->g_idx][$i]['flag']!=1){ echo " (".$option['option_arr'.$lt->g_idx][$i]['price']."원) * ".$option['option_arr'.$lt->g_idx][$i]['cnt']; }?>]
		<?
		}
		}
	}?>
	</td>
	<td><? if($lt->goods_cnt){ echo $lt->goods_cnt; }?></td>
	<td><?=number_format($lt->goods_total_price)?></td>
	<td><?=number_format($lt->price)?></td>
	<td><?=number_format($lt->use_point)?></td>
	<td><?=number_format($lt->total_price)?></td>
	<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
	<td><? echo $lt->userid ? $lt->userid : "비회원";?></td>
	<td><?=$lt->name?></td>
	<td><?=$lt->email?></td>
	<td><?=$lt->phone?></td>
	<td><?=$lt->send_name?></td>
	<td><?=$lt->send_phone?></td>
	<td><?=str_replace("--","",$lt->send_tel)?></td>
	<td>(<?=$lt->zip1?>) <?=$lt->addr1?> <?=$lt->addr2?></td>
	<td><?=$lt->send_text?></td>
	<td class='xTxt'><?=$lt->delivery_no?></td>
	<td><?=$shop_info['trade_stat'.$lt->trade_stat]?></td>
<?
}?>
</table>