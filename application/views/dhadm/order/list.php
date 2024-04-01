<?
	$cate_no1 = $this->input->get('cate_no1');
	$cate_no2 = $this->input->get('cate_no2');
	$cate_no3 = $this->input->get('cate_no3');
	$cate_no4 = $this->input->get('cate_no4');

?>
<style>
.adm-table tr{min-height:47px;}
</style>
	
	<h3 class="icon-search">제품 검색</h3>

				<form name="search_form">
				<input type="hidden" name="cate_no" value="">
				<!-- 제품검색 -->
				<table class="adm-table">
					<caption>제품 검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>						
						<tr>
							<th>제품분류</th>
							<td>
									<select id="cate_no1" name="cate_no1" onchange="cate_chg(2,this.value)">
										<option value="">1차 카테고리</option>
										<? foreach($cate_list as $cate1){ ?>
										<option value="<?=$cate1->cate_no?>" <? if(isset($cate_no1) && $cate_no1==$cate1->cate_no){?>selected<?}?>><?=$cate1->title?></option>
										<?}?>
									</select>
									<select id="cate_no2" name="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;">
										<option value="">2차 카테고리</option>
									</select>
									<select id="cate_no3" name="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;">
										<option value="">3차 카테고리</option>
									</select>
									<select id="cate_no4" name="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;">
										<option value="">4차 카테고리</option>
									</select>
									<input type="text" name="goods_name" class="width-m" value="<?=$this->input->get("goods_name")?>" placeholder="제품명으로 검색">
							</td>
						</tr>					
						<tr>
							<th>기간검색</th>
							<td>
								<!-- <button type="button" class="btn-clear">전체기간</button>
								<button type="button" class="btn-clear">1주일</button>
								<button type="button" class="btn-clear">1개월</button>
								<button type="button" class="btn-clear">3개월</button>
								<button type="button" class="btn-clear">오늘</button> -->
								<input type="text" name="start_date" id="start_date" class="width-s" value="<?=$start_date?>" readonly> ~
								<input type="text" name="end_date" id="end_date" class="width-s" value="<?=$end_date?>" readonly>								
							</td>
						</tr>					
						<tr>
							<th>검색조건</th>
							<td>
								<input type="radio" id="flag1" name="search_flag" <?if($this->input->get("search_flag")=="1"){?>checked<?}?> value="1"><label for="flag1">회원정보</label>
								<input type="radio" id="flag2" name="search_flag" <?if($this->input->get("search_flag")=="2"){?>checked<?}?> value="2"><label for="flag2">결제방법</label>								
								<select name="trade_info" id="s_flag1" <?if($this->input->get("search_flag")=="2" || !$this->input->get("search_flag")){?>style="display:none;"<?}?>>
									<option value="trade_code" <?if($this->input->get("trade_info")=="trade_code"){?>selected<?}?>>주문번호</option>
									<option value="userid" <?if($this->input->get("trade_info")=="userid"){?>selected<?}?>>주문자 아이디</option>
									<option value="name" <?if($this->input->get("trade_info")=="name"){?>selected<?}?>>주문자 이름</option>
									<option value="phone" <?if($this->input->get("trade_info")=="phone"){?>selected<?}?>>주문자 핸드폰번호</option>
									<option value="email" <?if($this->input->get("trade_info")=="email"){?>selected<?}?>>주문자 이메일</option>
									<option value="addr" <?if($this->input->get("trade_info")=="addr"){?>selected<?}?>>수령인 주소</option>
								</select>							
								<select name="trade_method" id="s_flag2" <?if($this->input->get("search_flag")=="1" || !$this->input->get("search_flag")){?>style="display:none;"<?}?>>
									<option value="">결제방법</option>
									<? for($i=1;$i<=$trade_method_cnt;$i++){ 
										if(isset($shop_info['trade_method'.$i])){
									?>
									<option value="<?=$i?>" <?if($this->input->get("trade_method")==$i){?>selected<?}?>><?=$shop_info['trade_method'.$i]?></option>
									<?}
									}
									?>
								</select>
								<input type="text" name="search_order" id="search_order" placeholder="검색어 입력" class="width-l" value="<?=$this->input->get("search_order")?>" <?if($this->input->get("search_flag")=="2" || !$this->input->get("search_flag")){?>style="display:none;"<?}?> onKeyDown="searchSend(document.search_form);">								
							</td>
						</tr>					
					</tbody>
				</table><!-- END 제품검색 -->
				<p class="align-c mt15"><input type="button" value="검색하기" class="btn-ok" onclick="javascript:document.search_form.submit();"></p>
				</form>
				
				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">주문리스트 <strong><?=number_format($totalCnt)?>건</strong></h3>
					<p class="list-adding float-r">
						<a href="<?=$_SERVER['PHP_SELF'].$query_string?>" <?if(!$this->input->get("order")){?>class="on"<?}?>>등록순<em>▼</em></a>
						<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=1" <?if($this->input->get("order")=="1"){?>class="on"<?}?>>등록순<em>▲</em></a>
						<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=2" <?if($this->input->get("order")=="2"){?>class="on"<?}?>>결제금액순<em>▼</em></a>
						<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=3" <?if($this->input->get("order")=="3"){?>class="on"<?}?>>결제금액순<em>▲</em></a>
					</p>
				</div>

				<form method="post" name="select_form">
				<input type="hidden" name="del_ok">
				<input type="hidden" name="change_stat">
				<table class="adm-table line align-c">
					<caption>주문 목록</caption>
					<colgroup>
						<col style="width:1px;"><col style="width:142px;"><col style="width:190px;"><col style="width:113px;"><col style="width:110px;"><col style="width:80px;"><col style="width:90px;"><col style="width:85px;"><col style="width:30px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>주문번호</th>
							<th>운송장번호</th>
							<th>주문자<br>(아이디)</th>
							<th>결제금액</th>
							<th>결제방법</th>
							<th>주문일</th>
							<th>거래상태</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
					<?
					$list_result = 0;
					$cnt=0;
					if($totalCnt>0){
						$list_result=1;
						foreach($list as $lt){
							$cnt++;
					?>
						<input type="hidden" name="trade_idx<?=$cnt?>" value="<?=$lt->idx?>">
						<tr class="sel<?=$lt->idx?>">
							<td><input type="checkbox" name="check<?=$cnt?>" value="<?=$lt->trade_code?>" class="sel"></td>
							<td><?=$lt->trade_code?></td>
							<td class="pr0">
								<select name="delivery_idx<?=$lt->idx?>" id="delivery_idx<?=$lt->idx?>" style="max-width:90px;">
									<? for($i=1;$i<=$shop_info['delivery_cnt'];$i++){  ?>
									<option value="<?=$i?>" <? if($lt->delivery_idx == $i){?>selected<?}?> ><?=$shop_info['delivery_idx'.$i]?></option>
									<?}?>
								</select>							
								<input type="text" name="delivery_no<?=$lt->idx?>" class="width-xs2" value="<?=$lt->delivery_no?>">
							</td>
							<td><? if($lt->mobile==1){?><img src="/_data/image/m.png" style="vertical-align:middle;"><?}?><?=$lt->name?><br><?if($lt->userid){?>(<a href="<?=cdir()?>/member/user/m?item=userid&val=<?=$lt->userid?>"><?=$lt->userid?></a>)<?}else{?><font color="gray">비회원</font><?}?></td>
							<td><?=number_format($lt->total_price)?>원</td>
							<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
							<td><?=substr($lt->trade_day,0,10)?></td>
							<td>
								<select name="" id="" onchange="cancel('<?=$lt->trade_method?>',this.value,'<?=$lt->idx?>','<?=$lt->trade_code?>','<?=$lt->tno?>')">
									<option value="">선택</option>
									<? foreach($trade_stat_list as $t_list){
										$i = explode("trade_stat",$t_list->name);
										$i = $i[1];
									?>
									<option value="<?=$i?>" <?if($lt->trade_stat==$i){?>selected<?}?>><?=str_replace("중","",$t_list->val)?></option>
									<?
									}
									?>
								</select>
							</td>
							<td><input type="button" value="상세" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/order/lists/<?=$trade_stat?>/m/?view=1&idx=<?=$lt->idx?>';"></td>
						</tr>
						<?
						}
					}else{
					?>
						<tr>
							<td colspan="10">등록된 내용이 없습니다.</td>
						</tr>
					<?}?>
					</tbody>
				</table>
				<input type="hidden" name="formCnt" value="<?=$cnt?>">
				</form>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="del();">
						<!-- <input type="button" value="선택엑셀저장" class="btn-etc" onclick=""> -->
						<input type="button" value="전체엑셀저장" class="btn-etc" onclick="<?if($totalCnt>0){?>location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/excel_download/<?=$trade_stat?>/<?=$query_string?>&cont=lists&flag=1'<?}else{?>javascript:alert('저장할 주문건이 없습니다.');<?}?>">					
						<input type="button" value="운송장번호 일괄저장" class="btn-special" onclick="delivery_ok();">
					</div>
					<div class="float-r">
						※ 선택한 데이터를 
						<select name="sel_chagne" id="sel_chagne">
							<option value="">선택</option>
							<? for($i=1;$i<=$trade_stat_cnt;$i++){ 
								if(isset($shop_info['trade_stat'.$i]) && $i!=9){
							?>
								<option value="<?=$i?>"><?=str_replace("중","",$shop_info['trade_stat'.$i])?></option>
							<?}
							}
							?>
						</select>
						<input type="button" value="변경" class="btn-ok" onclick="sel_change();">
					</div>
				</div><!-- END 제품 액션 버튼 -->

				<!-- END 제품리스트 -->
			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page2?>
				</p><!-- END Pager -->
			<?}?>
				
		<form name="delFrm" method="post">
		<input type="hidden" name="del_ok" value="1">
		<input type="hidden" name="del_idx">
		</form>


<script>
				$(function(){
					$("input[name='search_flag']").on("change",function(){
						$("#s_flag1").hide();
						$("#s_flag2").hide();
						$("#s_flag"+$(this).val()).show();	
						if($(this).val()==1){
							$("#search_order").show();
						}else{
							$("#search_order").hide();
						}
					});
				});
		
		function searchSend(form) {
			if(event.keyCode==13) { 
				form.submit();
			}
		}


	<? if(isset($cate_no2)){ ?>
		cate_chg(2, "<?=$cate_no1?>","<?=$cate_no2?>");
	<?}?>

	<? if(isset($cate_no3)){ ?>
		setTimeout('cate_chg(3, "<?=$cate_no2?>","<?=$cate_no3?>")',50);
	<?}?>
	
	<? if(isset($cate_no4)){ ?>
		setTimeout('cate_chg(4, "<?=$cate_no3?>","<?=$cate_no4?>")',100);
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
			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
					$("#cate_no"+i).val("");
				}
				
				$("#cate_depth").val(depth);
			}

	}
	

	function sel(depth, cate_no)
	{
		$("#cate_no"+depth).val(cate_no).attr("selected", "selected");
	}

	function del()
	{
		if($(".sel:checked").length > 0){
			if(confirm('거래가 완료되지 않은 주문을 삭제 하게되면 시스템상 오류가 발생할수도 있습니다.\n데이터가 유지되는걸 원하시면 거래상태를 주문취소로 변경하여 주십시오.\n정말로 삭제하시겠습니까?')){
				document.select_form.del_ok.value=1;
				document.select_form.submit();
			}
		}else{
			alert('삭제할 주문을 선택해주세요.');
		}
	}

	function sel_change()
	{
		if($("#sel_chagne").val()==""){
			alert('변경할 거래상태를 선택해주세요.');
			$("#sel_chagne").focus();
		}else if($(".sel:checked").length > 0){
			if(confirm("선택한 주문 상태를 변경하시겠습니까?")){
				document.select_form.del_ok.value=2;
				document.select_form.change_stat.value=$("#sel_chagne").val();
				document.select_form.submit();				
			}
		}else{
			alert('변경할 주문을 선택해주세요.');
		}
	}

	function delivery_ok()
	{
		document.select_form.del_ok.value=3;
		document.select_form.submit();		
	}
	
	$(function(){
		$(".sel").on("click",function(){
			var checkObj = $(this);
			
       if(checkObj.is(":checked") == true){
				$(".sel"+checkObj.val()).addClass("selected");
       }else{
				$(".sel"+checkObj.val()).removeClass("selected");
       }

		});

     $("#allcheck1").change(function(){

     var checkObj = $('.sel');

          if(this.checked){
             checkObj.prop("checked",true);
						$(".ft092 tr").addClass("selected");
          }else{
             checkObj.prop("checked",false);
						$(".ft092 tr").removeClass("selected");
          }
     });
	});


			function cancel(trade_method,change_stat,idx,trade_code,tno)
			{
				if(trade_method==1 && change_stat==9){
				
				if(confirm("카드주문을 취소하시겠습니까?")){
					card_cancel(trade_code,tno);
				}
				}else{
					if(confirm('거래상태를 변경하시겠습니까?')){ 
						location.href="<?=$_SERVER['PHP_SELF'].$query_string.$param?>&change_idx="+idx+"&change_stat="+change_stat;
					}
				}
			}			
			</script>

<? 
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>
