	<?
			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
	?>
	<style>
	.list_view {
		border:2px solid #4d4d4d;
		position:absolute;
		z-index:999;
		background:#fff;
		color:#4d4d4d;
		padding:15px;
	}

	.list_view dd { font-size:0.75em; }
	.sched_wrap .schedule span.icon { display:inline-block; cursor:pointer; }
	</style>
	
	<!-- 제품검색 -->
	<? if(isset($cate_list)){?><small>* 아티스트와 언어를 선택하시면 스케줄 달력이 표시됩니다.</small>
				<form action="" name="bbs_search_form" method="get">
				<table class="adm-table mt5">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>						
						<tr>
							<th>아티스트 & 언어</th>
							<td>
									<select id="cate_no1" name="cate_no1" onchange="cate_chg(2,this.value)">
										<option value="">아티스트 선택</option>
										<? foreach($cate_list as $cate1){ ?>
										<option value="<?=$cate1->cate_no?>" <? if(isset($cate_no1) && $cate_no1==$cate1->cate_no){?>selected<?}?>><?=$cate1->title?></option>
										<?}?>
									</select>
									<select id="cate_no2" name="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;">
										<option value="">언어선택</option>
									</select>
									<select id="cate_no3" name="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;">
										<option value="">3차 카테고리</option>
									</select>
									<select id="cate_no4" name="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;">
										<option value="">4차 카테고리</option>
									</select>

									<input type="button" value="검색" class="btn-ok lan" onclick="javascript:document.bbs_search_form.submit();"<? if(!$cate_no2){?> style="display:none;"<?}?>>
									<!-- <input type="button" value="초기화" class="btn-clear" onclick="javascript:location.href='?cate_no1=&cate_no2=';"> -->
							</td>
						</tr>	
					</tbody>
				</table><!-- END 제품검색 -->
				</form>
		<?}?>
		

				<div class="float-wrap mt30 mb10">

<?
	$th_data = "";

	for ($i=0; $i<count($strDay); $i++){
		$th_data.='<th scope="col">'.$strDay[$i].'</th>';
	}

?>

<p class="align-c pb50">	
	<a href="<?=$query_string?>&year=<?=$prevYear?>&month=<?=$prevMonth?>"><img src="/_dhadm/image/icon/left.png" ></a>
	<span class="schedule_date"><?=$year?>.<?=$month?></span>	
	<a href="<?=$query_string?>&year=<?=$nextYear?>&month=<?=$nextMonth?>"><img src="/_dhadm/image/icon/right.png" ></a>
</p>

<link type="text/css" rel="stylesheet" href="/artist/css/sub.css" />
<div class="sched_wrap">

<table class="adm-table schedule">
<colgroup>
	<col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px">
</colgroup>
<thead>
	<tr>
		<?=$th_data?>
	</tr>
<?

	$line = 5;
	if (($FirstDayPosition > 5) && (ceil($TotalDay/5) == 7)) $line = 6;
	if (($FirstDayPosition == 1) && ($TotalDay == 28)) $line =4;

	$k = 0;

	for ($i=1; $i<=$line; $i++) {
?>
	<tr>
	<?
		for ($j=1; $j<=7; $j++) {
		if ((!$day) && ($j == $FirstDayPosition)) $day = 1;		
				
		$daylen = strlen($day);
		if($daylen==1){ $day_text="0".$day; }else{ $day_text = $day; }		

			if ($day > 0){
	?>
			<td class="dataOn">
			<p class="align-l float-l"><?=$day?></p>
			<p class="align-r">
				<input type="button" class="btn-sm" value="등록" onclick="cal_write('<?=$day_text?>')">
				<? if(isset($row[$day][0]->idx)){?>
					<div class="mt20 float-r">
					<? foreach($row[$day] as $lt){			
						if(isset($lt->flag)){
					?>
					<span class="icon <?=$lt->flag?>" onclick="javascript:$('.list<?=$lt->idx?>').toggle();"></span>
					<div class="list_view list<?=$lt->idx?>" style="display:none;">
						<dl>
							<? 
							$ddCnt=0;
							foreach($row[$day]['list'.$lt->idx] as $it){ $ddCnt++; ?>
							<div<?if($ddCnt > 1){?> class="mt10"<?}?>>
							<strong><?=$it->subject?></strong>
							&nbsp;<img src="/_dhadm/image/icon/icon_modify.png" alt="" width="15" height="15" style="vertical-align:middle;cursor:pointer;" onclick="javascript:cal_edit('<?=$it->idx?>')"> <img src="/_dhadm/image/icon/icon_del.png" style="vertical-align:middle;cursor:pointer;" width="15" height="14" onclick="delOk(<?=$it->idx?>)">
							<dd><?=nl2br($it->content)?></dd>
							<? } ?>
							</div>
						</dl>
					</div>
					<?
						}
					}
					?>					
					</div>
				<?}?>
			</p>			
			</td>
		<?}else{?>
			<td></td>		
	<?
			}
			
			if ($day != $TotalDay) {
				if (($day > 0) && ($day < $TotalDay)) $day++;
			} else {
				$day = "&nbsp;";
			}
		}
	?>
	</tr>
<?
	}
?>
</thead>
</table>

</div>

	<script>	

	<? if(isset($cate_no2)){ ?>
		cate_chg(2, "<?=$cate_no1?>","<?=$cate_no2?>");
	<?}?>


	function cate_chg(depth, cate_no, sel_no)
	{
			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write",
					data: {ajax : "1", depth : depth, cate_no: cate_no, sel_no: sel_no},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).hide();
							$("#cate_no"+i).val("");
						}
						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no"+depth).show();

						}
					}	
				});

				if(depth > 2 || sel_no){
					$(".lan").show();
				}else{
					$(".lan").hide();
				}

			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
					$("#cate_no"+i).val("");

					if(depth==2){ $(".lan").hide(); }
				}
				
				$("#cate_depth").val(depth);
			}

	}
	

function cal_write(day)
{
	var year = "<?=$year?>";
	var month = "<?=$month?>";
	var cate_no = "<?=$cate_no2?>";

	window.open("/html/board/schedule_write?ajax=1&year="+year+"&month="+month+"&day="+day+"&cate_no="+cate_no,'schedule_write','width=495,height=430,scrollbars=no');

}

function cal_edit(idx)
{
	window.open("/html/board/schedule_write?ajax=1&idx="+idx,'schedule_edit','width=495,height=430,scrollbars=no');

}
</script>


		<form name="delFrm" method="post">
		<input type="hidden" name="del_ok" value="1">
		<input type="hidden" name="del_idx">
		</form>

			
