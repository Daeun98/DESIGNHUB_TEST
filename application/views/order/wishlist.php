
				<!-- 장바구니 Wrap -->
				<div class="shop-cart-wrap">
					<!-- <p class="order-tit">WISH LIST에 담긴 상품</p> -->
					
					<form name="wishlistFrm" id="wishlistFrm" method="post" onsubmit="return false;">
					<input type="hidden" name="mode">
					<table class="shop-cart">
						<caption>위시 리스트</caption>
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
										<?=$lt->goods_cnt?>
										<?}else{?>
										<? if($lt->goods_cnt>0){ echo $lt->goods_cnt; }?>
										<?}?>
									</div>
								</td>
								<td><?=number_format($lt->total_price)?>원</td>
								<? if($this->session->userdata('USERID')){?><td><!-- 회원구매시<br> --><?=number_format($lt->goods_point)?>원</td><?}?>
								<!-- <td></td> -->
								<td class="cart-edit">
									<button type="button" class="cart-btn2" onclick="javascript:location.href='<?=cdir()?>/dh_order/shop_cart/<?=$lt->idx?>';">장바구니</button><br>
									<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
								</td>
							</tr>
						<?}?>
						</tbody>
					</table>
					<input type="hidden" name="frmCnt" value="<?=$frmCnt?>">
					</form>
					
					<!-- 옵션버튼 -->
					<p class="cart-op-btns">
						<button type="button" class="cart-btn2" onclick="allChk()">전체선택</button>
						<button type="button" class="cart-btn3" onclick="frmSubmit('allDel')">선택상품 삭제</button>
					</p><!-- END 옵션버튼 -->
					
					<!-- 총 주문금액  -->
					<div class="order-total-box">
					</div><!-- END 총 주문금액 -->
					
				</div><!-- END 장바구니 Wrap -->
				
					
				<!-- 하단 버튼 -->
				<div class="float-wrap">
					<div class="float-l">
						<button type="button" class="btn-border" onclick="location.href='<?=cdir()?>';">계속 쇼핑하기</button>
					</div>
					<div class="float-r">
						<button type="button" class="btn-emp" onclick="location.href='<?=cdir()?>/dh_order/shop_cart';">장바구니로 가기</button>
					</div>
				</div><!-- END 하단 버튼 -->
			
			</div><!-- END Shop Wrap -->

			<form method="post" name="cartChangeFrm" id="cartChangeFrm">
			<input type="hidden" name="wishlist_idx">
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
    }else{
      checkObj.prop("checked",false);
    }
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

	var form = document.wishlistFrm;
	form.mode.value=mode;
	form.submit();
}

			
function goFrm(mode,idx)
{
	var form = document.cartChangeFrm;

	if(mode=="del"){
		if(confirm("삭제하시겠습니까?")){
			form.mode.value=mode;
			form.wishlist_idx.value=idx;
			form.submit();
		}
	}

}

			
			</script>