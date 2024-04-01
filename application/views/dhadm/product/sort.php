<?
			$cate_no = $this->input->get('cate_no');

			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$order = $this->input->get('order');
?>
				<!-- 제품검색 -->
				<h3 class="icon-search">카테고리 선택</h3>

		<form method="get" name="admin_form" id="admin_form" enctype="multipart/form-data">
		<input type="hidden" name="cate_depth" id="cate_depth" value="1">
		<input type="hidden" name="cate_no" id="cate_no" value="">
		<input type="hidden" name="cate_no1" value="">
		<input type="hidden" name="cate_no2" value="">
		<input type="hidden" name="cate_no3" value="">
		<input type="hidden" name="cate_no4" value="">


		<!-- 카테고리 선택 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>카테고리를 선택하기 위한 테이블</caption>
			<colgroup>
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
			</colgroup>
			<thead>
				<tr>
					<th scope="col">1차 카테고리</th>
					<th scope="col">2차 카테고리</th>
					<th scope="col">3차 카테고리</th>
					<th scope="col">4차 카테고리</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no1">
								<? foreach($cate_list as $cate1){ ?>
								<li><a href="javascript:cate_chg(2,<?=$cate1->cate_no?>);" class="cate<?=$cate1->cate_no?>"><?=$cate1->title?></a></li>
								<?}?>
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no2">
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no3">
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no4">
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table><!-- END 카테고리 선택 테이블 -->

		</form>

		<p class="tint-box pt20 pb20">
			<strong><span class="level1">카테고리를 선택해 주세요</span><span class="level2"></span><span class="level3"></span><span class="level4"></span></strong>
		</p>

		<p class="align-c mt20">
			<input type="button" class="btn-xl btn-ok" value="확인" onclick="cate_sel()">
		</p>


<? if($cate_no){ ?>


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l"><? if($cate_no){?> '<strong><?=$cate_row->title?></strong>' 에 등록된 제품<?}?> <strong><?=$totalCnt?>개</strong></h3>
					<p class="list-adding float-r">
						<span><img src="/_dhadm/image/icon/btn_up1.png" alt="화살표(위)1개"> 위로 1칸 이동</span>
						<span class="ml10"><img src="/_dhadm/image/icon/btn_up10.png" alt="화살표(위)2개"> 위로 10칸 이동</span>
						<span class="ml10"><img src="/_dhadm/image/icon/btn_down1.png" alt="화살표(아래)1개"> 아래로 1칸 이동</span>
						<span class="ml10"><img src="/_dhadm/image/icon/btn_down10.png" alt="화살표(아래)2개"> 아래로 10칸 이동</span>
					</p>
				</div>

				<form method="post" name="select_form" action="/product/lists/m/?url=sort">
				<input type="hidden" name="mode">
				<input type="hidden" name="sel_cate_no">
				<!-- 제품 목록 테이블 -->
				<table class="adm-table line align-c">
					<caption>제품 정렬을 위한 제품 목록 테이블</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;">
						<? if($shop_info['shop_use']=="y"){?><col><col><?}?><col style="width:90px;"><col style="width:120px;">
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
							<th>진열순서</th>
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
							<td><?=$totalCnt?></td>
							<td><?=$lt->code?></td>
							<td class="pr0"><img src="<? if($lt->list_img){?>/_data/file/goodsImages/<?=$lt->list_img?><?}else{?>/_dhadm/image/common/thumb.jpg<?}?>" alt="" width="70" height="60" class="block"></td>
							<td class="align-l"><?=$lt->name?></td>
							<? if($shop_info['shop_use']=="y"){?>
							<td><?=number_format($lt->shop_price)?>원</td>
							<td><? if($lt->unlimit==1){?>∞<?}else if($lt->unlimit==0 && $lt->number==0){?><span class="dh_red">품절</span><?}else{ echo $lt->number; }?></td>
							<?}?>
							<td>
								<p class="mb5">
									<img src="/_dhadm/image/icon/btn_up1.png" alt="위로 1칸 이동" title="위로 1칸 이동" style="cursor:pointer;" onclick="sortChange('u','1','<?=$lt->idx?>')">
									<img src="/_dhadm/image/icon/btn_up10.png" alt="위로 10칸 이동" title="위로 10칸 이동" style="cursor:pointer;" onclick="sortChange('u','10','<?=$lt->idx?>')">
								</p>
								<p>
									<img src="/_dhadm/image/icon/btn_down1.png" alt="아래로 1칸 이동" title="아래로 1칸 이동" style="cursor:pointer;" onclick="sortChange('d','1','<?=$lt->idx?>')">
									<img src="/_dhadm/image/icon/btn_down10.png" alt="아래로 10칸 이동" title="아래로 10칸 이동" style="cursor:pointer;" onclick="sortChange('d','10','<?=$lt->idx?>')">
								</p>
							</td>
							<td><input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/product/lists/m/?edit=1&idx=<?=$lt->idx?>&url=sort';">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="9">등록된 내용이 없습니다.</td>
						</tr>
						<?}?>


					</tbody>
				</table><!-- END 제품 목록 테이블 -->
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
					<?=$Page?>
				</p><!-- END Pager -->
			<?}?>
	<?}?>

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

	function cate_chg(depth, cate_no)
	{
		var level = depth-1;

		$("#cate_no"+level+" li a").removeClass("on");
		$(".cate"+cate_no).addClass("on");

		if(depth==5){
			$("#cate_no").val(cate_no);
		}else{

			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write/",
					data: {ajax : "1", depth : depth, cate_no: cate_no, de: "2"},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){

						for(i=depth;i<=4;i++){
							$("#cate_no"+i).html("");
						}

						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no").val("");
						}else{
							$("#cate_no").val(cate_no);
						}
					}
				});
			}else{

				for(i=depth;i<=4;i++){
					$("#cate_no"+i).html("");
				}

				$("#cate_depth").val(depth);
				$("#cate_no").val(cate_no);
			}

		}

			$(".level"+level).html($(".cate"+cate_no).html());
			if(level > 1){ $(".level"+level).prepend(" &gt; "); }

			for(j=4;j>level;j--){
				$(".level"+j).html("");
			}

			eval("document.admin_form.cate_no"+level+".value = '"+cate_no+"'");
	}


	function cate_sel()
	{
		var cate_no = $("#cate_no").val();
		if(cate_no){
			document.admin_form.cate_no.value=cate_no;
			document.admin_form.submit();

		}else{
			alert("카테고리를 선택해주세요.");
			return;
		}
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


	function sortChange(mode,number,idx)
	{
		document.sortFrm.mode.value = mode;
		document.sortFrm.num.value = number;
		document.sortFrm.idx.value = idx;
		document.sortFrm.submit();
	}

	</script>

		<form name="delFrm" method="post" action="/product/lists/m/?url=sort">
		<input type="hidden" name="del_ok" value="1">
		<input type="hidden" name="del_idx">
		</form>


		<form name="sortFrm" method="post" action="<?=self_url()?><?=$query_string?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="num" value="">
		<input type="hidden" name="idx" value="">
		</form>

