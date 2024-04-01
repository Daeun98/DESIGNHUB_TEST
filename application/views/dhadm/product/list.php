<?
			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
			$cate_no3 = $this->input->get('cate_no3');
			$cate_no4 = $this->input->get('cate_no4');
			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$order = $this->input->get('order');
?>
	<script>
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

	</script>
				<h3 class="icon-search">제품 검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<input type="hidden" name="cate_no" value="">
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
							</td>
						</tr>
						<tr>
							<th>제품검색</th>
							<td>
								<input type="text" name="name" placeholder="제품명으로 검색" class="width-m" value="<?=$name?>">
								<input type="text" name="code" placeholder="코드명으로 검색" class="width-m" value="<?=$code?>">
								<input type="button" value="검색" class="btn-ok"  onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 제품 <strong><?=$totalCnt?>개</strong></h3>
					<p class="list-adding float-r">
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=" <?if(!$order){?>class="on"<?}?>>정렬순</a>
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=1" <?if($order==1){?>class="on"<?}?>>등록일순</a>
						<? if($shop_info['shop_use']=="y"){?>
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=2" <?if($order==2){?>class="on"<?}?>>높은가격순<em>▲</em></a>
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=3" <?if($order==3){?>class="on"<?}?>>낮은가격순<em>▼</em></a>
						<?}?>
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=4" <?if($order==4){?>class="on"<?}?>>이름순<em>▲</em></a>
						<a href="<?=cdir()?>/product/lists/m/<?=$query_string?>&order=5" <?if($order==5){?>class="on"<?}?>>이름순<em>▼</em></a>
					</p>
				</div>

				<form method="post" name="select_form">
				<input type="hidden" name="mode">
				<input type="hidden" name="sel_cate_no">
				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;"><? if($shop_info['shop_use']=="y"){?><col><col><?}?><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<? if($shop_info['shop_use']=="y"){?>
							<th>가격</th>
							<th>재고</th>
							<?}?>
							<th>등록일</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
						$list_result = 0;
						$cnt=0;
						if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){
								$cnt++;
								?>
								<tr class="sel<?=$lt->idx?>">
									<td><input type="checkbox" name="check<?=$cnt?>" value="<?=$lt->idx?>" class="sel"></td>
									<td><?=$listNo?></td>
									<td><?=$lt->code?></td>
									<td class="pr0"><img src="<? if($lt->list_img){?>/_data/file/goodsImages/<?=$lt->list_img?><?}else{?>/_dhadm/image/common/thumb.jpg<?}?>" alt="" width="70" height="60" class="block"></td>
									<td class="align-l"><?=$lt->name?></td>
									<? if($shop_info['shop_use']=="y"){?>
									<td><?=number_format($lt->shop_price)?>원</td>
									<td><? if($lt->unlimit==1){?>∞<?}else if($lt->unlimit==0 && $lt->number==0){?><span class="dh_red">품절</span><?}else{ echo $lt->number; }?></td>
									<?}?>
									<td><?=substr($lt->register,0,10)?></td>
									<td><input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/product/lists/m<?=$query_string.$param?>&edit=1&idx=<?=$lt->idx?>';">
										<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
									</td>
								</tr>
								<?
								$listNo--;
							}
						}else{
						?>
						<tr>
							<td colspan="9">등록된 내용이 없습니다.</td>
						</tr>
						<?
						}
						?>


					</tbody>
				</table>
				<input type="hidden" name="formCnt" value="<?=$cnt?>">
				</form>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택이동" class="btn-ok" onclick="goods_select('move');" >
						<input type="button" value="선택복사" class="btn-ok" onclick="goods_select('copy');" >
						<input type="button" value="선택삭제" class="btn-alert" onclick="goods_select('del')" >
					</div>
					<div class="float-r">
						<a href="<?=cdir()?>/product/write/m" class="button btn-ok">제품등록</a></span>
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


	function goods_select(mode)
	{
		if($(".sel:checked").length > 0){

			document.select_form.mode.value=mode;

			if(mode=="move"){
				openWinPopup("/product/product_move/move/?ajax=1&sel_cnt="+$(".sel:checked").length,mode,760,500);
			}else if(mode=="copy"){
				openWinPopup("/product/product_move/copy/?ajax=1&sel_cnt="+$(".sel:checked").length,mode,760,500);
			}else if(mode=="del"){
				if(confirm('선택하신 제품을 삭제합니다. \n삭제하신 제품은 복구할 수 없습니다.')){
					document.select_form.submit();
				}
			}

		}else{
			if(mode=="move"){
				alert('이동할 제품을 선택해주세요.');
			}else if(mode=="copy"){
				alert('복사할 제품을 선택해주세요.');
			}else if(mode=="del"){
				alert('삭제할 제품을 선택해주세요.');
			}
			return;
		}
	}


	</script>

