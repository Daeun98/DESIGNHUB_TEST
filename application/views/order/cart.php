
<input type="hidden" id="totalPrice" value="<?=$totalPrice?>">
<input type="hidden" id="delivery_price" value="<?=$delivery_price?>">
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 상단 step -->
				<div class="shop-order-step">
					<h2><span class="so-step so-step1 on">장바구니</span></h2>
					<span class="so-arr"></span>
					<span class="so-step so-step2">주문결제</span>
					<span class="so-arr"></span>
					<span class="so-step so-step3">주문완료</span>
				</div><!-- END 상단 step -->


				<!-- 장바구니 Wrap -->
				<div class="shop-cart-wrap">
					<p class="order-tit">장바구니에 담긴 상품</p>

					<form name="cartFrm" id="cartFrm" method="post" onsubmit="return false;">
					<input type="hidden" name="mode">
					<table class="shop-cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-chk"><input type="checkbox" class="all_chk" checked></th>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?>
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-df">선택</th>
							</tr>
						</thead>
						<tbody>
							<?
								$frmCnt=0;
								foreach($list as $lt){
								$ltFlag=0;
								$frmCnt++;
							?>
							<input type="hidden" name="idx<?=$frmCnt?>" id="idx<?=$frmCnt?>" value="<?=$lt->idx?>">
							<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=$lt->express_check?>">
							<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=$lt->express_money?>">
							<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=$lt->express_free?>">
							<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=$lt->express_no_basic?>">
							<tr>
								<td><input type="checkbox" name="chk<?=$frmCnt?>" value="1" class="chkNum" checked idx="<?=$lt->idx?>" price="<?=$lt->total_price?>"></td>
								<td><?=$lt->goods_code?></td>
								<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=$lt->cate_no?>"><?=$lt->goods_name?></a></p>
										<? if($lt->option_cnt > 0){
											for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
												$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
												$plus="";
												if(count($price)<2){ $plus="+"; }
												$title = ${'option_arr'.$lt->idx}[$i]['title'];
												$name = ${'option_arr'.$lt->idx}[$i]['name'];
												$price = ${'option_arr'.$lt->idx}[$i]['price'];
												$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
												$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
												if($flag==1){ $ltFlag=$flag; }
										?>
											<p class="prod-op">
											<em><?=$title?></em> : <?=$name?>
											<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
											<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
											</p>
										<?
											}
										}?>
									</div>
								</td>
								<td>
									<p class="cart-price">
										<? if($lt->old_price){?>
										<del><?=number_format($lt->old_price)?>원</del>
										<ins><?=number_format($lt->goods_price)?>원</ins>
										<?}else{?>
										<?=number_format($lt->goods_price)?>원
										<?}?>
									</p>
								</td>
								<td>
									<div class="cart-vol-wrap">
									<? if($lt->option_cnt == 0){?>
										<div class="cart-vol">
											<input type="text" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>
											<button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u',<?=$lt->goods_price?>,<?=$lt->unlimit?>,<?=$lt->number?>)">추가</button>
											<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d',<?=$lt->goods_price?>,<?=$lt->unlimit?>,<?=$lt->number?>)">감소</button>
										</div>
										<button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>',<?=$lt->goods_price?>)">적용</button>
										<?}else{?>
										<? if($lt->goods_cnt>0){ echo $lt->goods_cnt; }?>
										<?}?>
									</div>
								</td>
								<td><?=number_format($lt->total_price)?>원</td>
								<? if($this->session->userdata('USERID')){?><td><!-- 회원구매시<br> --><?=number_format($lt->goods_point)?>원</td><?}?>
								<!-- <td></td> -->
								<td class="cart-edit">
									<button type="button" class="cart-btn1" onclick="javascript:location.href='<?=cdir()?>/dh_order/shop_order/<?=$lt->idx?>';">바로주문</button><br>
									<button type="button" class="cart-btn2" onclick="javascript:location.href='<?=cdir()?>/dh_order/wishlist/<?=$lt->idx?>';">위시담기</button><br>
									<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
								</td>
							</tr>
						<?}?>
						</tbody>
						<!-- <tfoot>
							<tr>
								<td colspan="10">
									<div class="cart-total">
										상품 합계금액 : <em>30,000</em>원 + 배송비 <em>2,500</em>원 = 총 합계 <em>32,500</em>원
									</div>
								</td>
							</tr>
						</tfoot> -->
					</table>
					<input type="hidden" name="frmCnt" value="<?=$frmCnt?>">
					</form>

					<!-- 옵션버튼 -->
					<p class="cart-op-btns">
						<button type="button" class="cart-btn2" onclick="allChk()">전체선택</button>
						<!-- <button type="button" class="cart-btn1">선택상품 위시리스트 추가</button> -->
						<button type="button" class="cart-btn3" onclick="frmSubmit('allDel')">선택상품 삭제</button>
					</p><!-- END 옵션버튼 -->

					<!-- 총 주문금액  -->
					<div class="order-total-box">
						<div class="each-price-box">
							<p class="total-tit"><img src="/image/shop/total_tit.png" alt="총 주문금액"></p>
							<ul class="each-price">
								<li><span>상품 총 금액</span>
									<em class="price"><?=number_format($totalPrice)?>원</em>
								</li>
								<li><span>배송비</span>
									<em class="devPrice"><?=number_format($delivery_price)?>원</em>
								</li>
							</ul>
						</div>
						<div class="total-price">
							<!-- <? if($this->session->userdata('USERID')){?><span class="acc-p">( 적립예정 포인트 : <?=number_format($totalPoint)?>P )</span><?}?> -->
							결제 예정 금액 <span class="tt-price"><em><?=number_format($totalPrice+$delivery_price)?></em> 원</span>
						</div>
					</div><!-- END 총 주문금액 -->

				</div><!-- END 장바구니 Wrap -->


				<!-- 하단 버튼 -->
				<div class="float-wrap">
					<div class="float-l">
						<button type="button" class="btn-border" onclick="javascript:location.href='/'">계속 쇼핑하기</button>
					</div>
					<div class="float-r">
						<button type="button" class="btn-normal" onclick="sel_order();">선택상품 주문</button>
						<button type="button" class="btn-emp" onclick="<?if($totalCnt>0){?>location.href='/html/dh_order/shop_order'<?}else{?>alert('주문할 상품이 없습니다.')<?}?>;">전체 주문</button>
					</div>
				</div><!-- END 하단 버튼 -->

			</div><!-- END Shop Wrap -->

			<form method="post" name="cartChangeFrm" id="cartChangeFrm">
			<input type="hidden" name="cart_idx">
			<input type="hidden" name="goods_idx">
			<input type="hidden" name="total_price">
			<input type="hidden" name="goods_cnt">
			<input type="hidden" name="goods_cnt_chagne" value="1">
			<input type="hidden" name="mode">
			</form>


<script>

$(function(){

  $(".all_chk").change(function(){

  var checkObj = $('.chkNum');

		if(this.checked){
      checkObj.prop("checked",true);
			$(".price").html("<?=number_format($totalPrice)?>원");
			$("#delivery_price").val(<?=$delivery_price?>);
			$(".devPrice").html("<?=number_format($delivery_price)?>원");
			$(".tt-price em").html("<?=number_format($totalPrice+$delivery_price)?>");
			$("#totalPrice").val("<?=$totalPrice?>");
    }else{
      checkObj.prop("checked",false);
			$(".price").html("0원");
			$("#delivery_price").val(0);
			$(".devPrice").html("0원");
			$(".tt-price em").html("0");
			$("#totalPrice").val(0);

    }
  });

	$(".chkNum").change(function(){

		var totalPrice = $("#totalPrice").val();
		var delivery_price = $("#delivery_price").val();

		var idx = $(this).attr("idx");
		var price = $(this).attr("price");


		if(this.checked){
			totalPrice = parseInt(totalPrice)+parseInt(price);
		}else{
			totalPrice = parseInt(totalPrice)-parseInt(price);
		}


		$("#totalPrice").val(totalPrice);
		$(".price").html(number_format(totalPrice,0)+"원");

		var basic="";

		if($(".chkNum:checked").length==1){ //단일상품일때

			var idx = $(".chkNum:checked").attr("idx");

			var express_check = $("#express_check"+idx).val();
			var express_money = $("#express_money"+idx).val();
			var express_free = $("#express_free"+idx).val();
			var express_no_basic = $("#express_no_basic"+idx).val();

			basic = "2";


			if(express_no_basic==1){ //배송 기본정책 미사용
				if(express_check==1){ //일반배송 일때

					if(totalPrice >= express_free){ //총 구매액이 지정한도 이상이면 무료배송
						delivery_price = 0;
					}else{
						delivery_price = express_money;
					}
				}else{ //무료배송 일때
					delivery_price = 0;
				}
			}else{ //배송 기본정책 사용
				basic="1";
			}


		}

		if($(".chkNum:checked").length > 1 || basic==1){ //다중상품일때 기본정책으로 적용

			<? if(!$shop_info['express_money']){ $shop_info['express_money'] = 0; } ?>

			if(<?=$shop_info['express_check']?>==1){ //일반배송 일때
				if(totalPrice >= <?=$shop_info['express_free']?>){ //총 구매액이 지정한도 이상이면 무료배송
					delivery_price = 0;
				}else{
					delivery_price =  <?=$shop_info['express_money']?>;
				}
			}else{ //무료배송 일때
				delivery_price = 0;
			}

		}else if(basic==""){
			delivery_price = 0;
		}



		$("#delivery_price").val(delivery_price);
		$(".devPrice").html(number_format(delivery_price,0)+"원");
		$(".tt-price em").html(number_format(parseInt(totalPrice)+parseInt(delivery_price),0));



	});

});


function allChk()
{
	$(".all_chk").prop("checked",true);
  $('.chkNum').prop("checked",true);
}


function frmSubmit(mode)
{
	if($(".chkNum:checked").length==0){
		alert('상품을 선택해주세요.');
		return;
	}


	if(mode=="allDel"){
		if(!confirm("선택상품을 삭제하시겠습니까?")){
			return;
		}
	}

	var form = document.cartFrm;
	form.mode.value=mode;
	form.submit();
}


function goFrm(mode,idx)
{
	var form = document.cartChangeFrm;

	if(mode=="del"){
		if(confirm("삭제하시겠습니까?")){
			form.mode.value=mode;
			form.cart_idx.value=idx;
			form.submit();
		}
	}

}


function sel_order()
{
	var formCnt = <?=$frmCnt?>;
	var send = "";
	var j=0;
	if($(".chkNum:checked").length==0){
		alert('주문할 상품을 선택해주세요.');
		return;
	}

	for(i=1;i<=formCnt;i++){
		if($("input[name='chk"+i+"']:checked").length > 0){
			if(j==0){ j=1; }
			if(j==1){
				send = send+$("#idx"+i).val();
			}else{
				send = send+"a"+$("#idx"+i).val();
			}
			j=2;
		}
	}

	location.href="<?=cdir()?>/dh_order/shop_order/"+send;

}


function cartChange(idx,goods_idx,shop_price)
{
	var form = document.cartChangeFrm;
	var goods_cnt = $("#goods_cnt"+idx).val();

	form.cart_idx.value=idx;
	form.goods_idx.value=goods_idx;
	form.total_price.value=parseInt(shop_price)*parseInt(goods_cnt);
	form.goods_cnt.value=goods_cnt;

	form.submit();
}

function goodsCntChange(idx,mode,shop_price,unlimit,number)
{
	var goods_cnt = $("#goods_cnt"+idx).val();

	if(mode=="u"){

		if(unlimit == 0 && number > 0){

		if(number==goods_cnt){
			alert("상품 재고수량이 부족합니다.");
			return;
		}

		}
		goods_cnt = parseInt(goods_cnt)+1;
		shop_price = parseInt(shop_price)*goods_cnt;

	}else if(mode=="d"){
		if(goods_cnt==1){
			alert("수량은 1개 이상부터 가능합니다.");
			return;
		}else{
			goods_cnt = parseInt(goods_cnt)-1;
		}
	}

	$("#goods_cnt"+idx).val(goods_cnt);
}


</script>