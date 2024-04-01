<? 
	$option_cnt=0;
?>
<script>
function option_select(idx)
{
	if(idx){

	var cnt = $("#option_cnt").val();
	var option_sel = $("#option_sel").val();

	$.ajax({
			url: "/html/dh_product/prod_view/<?=$row->idx?>",
			data: {ajax: 1, option_idx: idx},
			async: true,
			cache: false,
			error: function(xhr){	},
			success: function(data){

				if(cnt == 0){
					$(".prod-selected").show();
				}
				var position = option_sel.indexOf("/"+idx+"/");

				if(position <= -1){
					$(".prod-selected ul").append(data);
					$("#option_cnt").val(parseInt(cnt)+1);
					$("#option_sel").val(option_sel+idx+"/");
				}

				//$(".prod-selected ul .option"+idx).remove();

			}	
	});

	}
}

function onView(imgName)
{
	$(".prod-img-zoom img").attr("src","/_data/file/addImages/"+imgName);
}


function option_del(idx,price)
{
	if(idx)
	{
		var cnt = $("#option_cnt").val();		
		var option_sel = $("#option_sel").val();
		var total_price = $("#total_price").val();
		var optionCnt = $("#optionCnt"+idx).val();
		price = parseInt(price)*parseInt(optionCnt);

		if(cnt > 0){
			
			total_price = parseInt(total_price)-parseInt(price);

			$("#total_price").val(total_price);
			$(".total_price").html(number_format(0,total_price));	

			option_sel = option_sel.replace("/"+idx+"/","/");
			$("#option_sel").val(option_sel);
			$("#option_cnt").val(parseInt(cnt)-1);
			$(".prod-selected ul .option"+idx).remove();

			if(cnt==1){
				$(".prod-selected").hide();
			}

			if(total_price==0){ 
				$(".total_price").html(number_format(0,<?=$row->shop_price?>));
				document.prod_form.reset();
			}

		}
	}
}


function sendOrder(mode)
{
var option_cnt=0;

	<? if($row->unlimit==0 && $row->number == 0){?>
		
		alert("품절상품 입니다.");
		return;

	<?}?>

	<? if($row->option_use==1){ ?> //옵션사용일경우


	<? 
	for($i=1;$i<=3;$i++){
		if($row->{'option_check'.$i}==1){
	?>
		if($("#option<?=$i?>").val()==""){
			alert("<?=${'option_row'.$i}->title?>을(를) 선택해주세요.");
			$("#option<?=$i?>").focus();
			return;
		}
	<?
		}
	}
	?>

		var option_sel = $("#option_sel").val();
		option_sel = option_sel.split("/");
		var option_sel_cnt = $("#option_sel_cnt").val();


		for(i=0;i<option_sel.length;i++){
			if(option_sel[i]){
				option_sel_cnt = option_sel_cnt + $("#optionCnt"+option_sel[i]).val() + "/";
			}
		}
		$("#option_sel_cnt").val(option_sel_cnt);


	<?}?>
	
	if($("#total_price").val()==0){
		$("#total_price").val(<?=$row->shop_price?>);
	}

	if(mode=="buy") //바로구매
	{
		document.prod_form.action="<?=cdir()?>/dh_order/shop_order";
	}else if(mode=="cart"){
		document.prod_form.action="<?=cdir()?>/dh_order/shop_cart";
	}else if(mode=="wish"){
		<? if(!$this->session->userdata('USERID')){ ?>
			alert('로그인이 필요합니다.');
			location.href='<?=cdir()?>/dh_member/login/?go_url=<?=cdir()?>/dh_product/prod_view/<?=$row->idx?>/?cate_no=<?=$row->cate_no?>';
			return;

		<?}else{?>

		document.prod_form.action="<?=cdir()?>/dh_order/wishlist";

		<?}?>
	}

	document.prod_form.submit();

}

function cntChange(idx,price,mode,unlimit,number)
{
	var total_price = $("#total_price").val();
	var opCnt = $("#optionCnt"+idx).val();

	if(mode=="u"){
		if(unlimit==0 && number==0){
			alert("품절상품 입니다.");
			return;
		}else if(unlimit==0 && number==opCnt ){
			alert("상품 재고수량이 부족합니다.");
			return;
		}
		opCnt = parseInt(opCnt)+1;
		total_price = parseInt(total_price)+parseInt(price);
	}else if(mode=="d"){
		if(opCnt > 1){
			opCnt = parseInt(opCnt)-1;
		total_price = parseInt(total_price)-parseInt(price);
		}else{
			alert("수량은 1개 이상부터 가능합니다.");
			return;
		}
	}
	$("#optionCnt"+idx).val(opCnt);

	$("#total_price").val(total_price);
	$(".total_price").html(number_format(0,total_price));	

}

function goodsCntChange(mode)
{
	var goods_cnt = $("#goods_cnt").val();
	var shop_price = <?=$row->shop_price?>;
	var number = <?=$row->number?>;

	if(mode=="u"){

		<? if($row->unlimit == 0 && $row->number > 0){?>

		if(number==goods_cnt){
			alert("상품 재고수량이 부족합니다.");
			return;
		}

		<?}?>
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

	$("#goods_cnt").val(goods_cnt);
	$("#total_price").val(shop_price);
	$(".total_price").html(number_format(0,shop_price));	
}



function bbs_load(code,PageNumber)
{		
	var goods_idx = "<?=$row->idx?>";
	if(!PageNumber){ PageNumber = 1; }
	$.ajax({
		url: "<?=cdir()?>/dh_board/lists/"+code,
		data: {ajax : "1", PageNumber : PageNumber, goods_idx : goods_idx},
		async: true,
		cache: false,
		error: function(xhr){
		},
		success: function(data){
			$("."+code+"_list").html(data);
		}	
	});
}

function view_on(idx)
{
	$(".view"+idx).toggle();
}
</script>

			<!-- 제품상단 -->
			<div class="prod-top">

				<!-- 제품이미지 -->
				<div class="prod-img">
					<div class="prod-img-zoom">
						<img src="<? if(isset($file_list) && $file_list!=""){ ?>/_data/file/addImages/<?=$file_list[0]->file_name?><?}else{?>/_data/file/goodsImages/<?=$row->list_img?><?}?>" alt="제품 확대이미지">
					</div>
					<div class="prod-img-sm">
						<ul class="prod-thumbs">
							<? 
							$cnt=1;
							if(isset($file_list) && $file_list!=""){
							foreach($file_list as $file){ 
								$cnt++;
							?>
							<li <?if($cnt==6){?>class="mr0"<?}?>><a href="javascript:onView('<?=$file->file_name?>');"><img src="/_data/file/addImages/<?=$file->file_name?>" class="" alt="제품상세 이미지 <?=$cnt?>"></a></li>
							<?}
							}?>
						</ul>
					</div>
				</div><!-- END 제품이미지 -->


				<!-- 제품정보 -->
				<div class="prod-info-wrap">
					<p class="prod-cate opensans"><? echo isset($data_list[0]->data_txt) ? $data_list[0]->data_txt : "";?></p>
					<h3 class="prod-name"><?=$row->name?></h3>
					
					<!-- 우측 스티커 -->
					<div class="prod-sticker">
						<?if(in_array("sale",$row->icon_flag)){?><span><img src="/image/shop/prod_sale.png" alt="SALE"></span><?}?>
						<?if(in_array("new",$row->icon_flag)){?><span><img src="/image/shop/prod_new.png" alt="NEW"></span><?}?>
						<?if($row->unlimit==0 && $row->number == 0){?><span><img src="/image/shop/prod_soldout.png" alt="SOLD OUT"></span><?}?>
					</div><!-- END 우측 스티커 -->
					
					<!-- 제품설명 -->
					<div class="prod-desc-wrap">
						<div class="prod-desc">
							<?=nl2br($row->detail)?>
						</div>
						<!-- <span class="more">더보기</span> -->
					</div>
					<!-- END 제품설명 -->
					
				<form name="prod_form" id="prod_form" method="post" onsubmit="return false;">
					<input type="hidden" name="goods_idx" value="<?=$row->idx?>">
					<input type="hidden" name="total_price" id="total_price" value="<? if($row->option_use=="1"){?>0<?}else{?><?=$row->shop_price?><?}?>">
					<input type="hidden" name="option_cnt" id="option_cnt" value="0">
					<input type="hidden" name="option_sel" id="option_sel" value="/">
					<input type="hidden" name="option_sel_cnt" id="option_sel_cnt" value="/">
					<input type="hidden" name="option_flag" id="option_flag" value="0">
					<!-- 제품정보 -->
					<ul class="prod-info opensans">
						<li><span class="label">PRICE</span>
						<?if($row->old_price){?>						
							시중가 : <del><?=number_format($row->old_price)?></del> <span class="ml25"></span>
							판매가 : <ins><?=number_format($row->shop_price)?></ins>
						<?}else{?>
							<?=number_format($row->shop_price)?>
						<?}?>
						</li>
						
						<? if($row->option_use=="1"){?>
						<? 
						for($i=1;$i<=3;$i++){
							if($row->{'option_check'.$i}==1){
							$option_cnt++;
						?>
							<li><span class="label"><?=${'option_row'.$i}->title?></span>
								<select id="option<?=$i?>" <? if(${'option_row'.$i}->flag==1){?>name="option<?=$i?>"<?}?> <? if(${'option_row'.$i}->flag!=1){?>onchange="option_select(this.value)"<?}?>>
									<option value="">선택해주세요</option>
									<?
										foreach(${'option_list'.$i} as $opList){									
										$price = explode("-",$opList->price);
										$plus="";
										if(count($price)<2){ $plus="+"; }
									?>
									<option value="<?=$opList->idx?>" <?if($opList->unlimit==0 && $opList->number==0){?>disabled<?}?>><?=$opList->name?> <?if($opList->price!=0){?>(<?=$plus?><?=number_format($opList->price)?>)<?}?> | <?if($opList->unlimit==0 && $opList->number==0){?>품절<?}else if($opList->unlimit==0 && $opList->number>0){?>재고 : <?=$opList->number?><?}else{?>재고있음<?}?></option>
									<?}?>
								</select>
							</li>
						<?
							}
						}
						?>
						<?}?>
						<?if($row->option_use==0 || ($option_flag_cnt>0 && $option_flag_cnt2==0)){?>
						<li><span class="label">수량</span>
						<? if($row->unlimit==1 || ( $row->unlimit==0 && $row->number > 0 ) ){?>
						<li>
							<div class="cart-vol">
								<input type="text" name="goods_cnt" id="goods_cnt" value="1" readonly>
								<button class="vol-up" onclick="goodsCntChange('u')">추가</button>
								<button class="vol-down" onclick="goodsCntChange('d')">감소</button>
							</div>
						</li>
						<?}else{?>
							<font color="red">품절</font>
						<?}?>
						</li>
						<?}?>

						<? if(isset($data_list[1]->data_txt)){ ?>
						<li><span class="label">MATERIAL</span>
							<?=$data_list[1]->data_txt?>
						</li>
						<?}?>
					</ul><!-- END 제품정보 -->
					<input type="hidden" name="optionCnt" id="optionCnt" value="<?=$option_cnt?>">
					</form>

					<!-- 선택옵션 -->
					<div class="prod-selected" style="display:none;">
						<span class="label">OPTION</span>
						<ul>
						</ul>
					</div><!-- END 선택옵션 -->
					
					<!-- 총 가격 -->
					<div class="prod-total">
						<span class="label">TOTAL PRICE</span>
						<span class="total_price"><?=number_format($row->shop_price)?></span> <span class="unit">WON</span>
					</div><!-- END 총 가격 -->

					<ul class="prod-btns">
						<li><button type="button" class="plain shop-btn-ok" onclick="sendOrder('buy')">BUY IT NOW</button></li>
						<li><button type="button" class="plain shop-btn-border" onclick="sendOrder('cart')">ADD TO CART</button></li>
						<li><button type="button" class="plain shop-btn-border" onclick="sendOrder('wish')">WISH LIST</button></li>
					</ul>

				</div><!-- END 제품정보 -->
			
			</div><!-- END 제품상단 -->
			

			
			<!-- 제품 상세 -->
			<div class="prod-detail">
				<?=$row->content1?>
			</div><!-- END 제품 상세 -->

			
			<!-- 제품상세탭 -->
			<ul class="shop-tab">
				<li><a href="#attach1">사이즈</a></li>
				<li><a href="#attach2">세탁 및 주의사항</a></li>
				<li><a href="#attach3">배송안내</a></li>
				<li><a href="#attach4">반품 및 교환</a></li>
			</ul><!-- END 제품상세탭 -->
			
			<!-- 사이즈 -->
			<div class="shop-tab-ct" id="attach1">
				<?=$row->content2?>
			</div>
			<!-- END 사이즈 -->

			<!-- 세탁 및 주의사항 -->
			<div class="shop-tab-ct" id="attach2">
				<?=$row->content3?>
			</div>
			<!-- END 세탁 및 주의사항 -->

			<!-- 배송 안내 사항 -->
			<div class="shop-tab-ct" id="attach3">
				<?=$row->delivery?>
			</div>
			<!-- END 배송 안내 사항 -->

			<!-- 반품 및 교환 -->
			<div class="shop-tab-ct" id="attach4">
				<?=$row->{'return'}?>
			</div>
			<!-- END 반품 및 교환 -->

			
			<? 
			if($shop_info['shop_review'] == "y"){ 					
			?>
			<script> bbs_load("<?=$shop_info['review_code']?>"); </script>

			<!-- 후기게시판 -->
			<h4 class="page_tit mt20 mb20">REVIEW</h4>			
			<div class="shop-board-wrap <?=$shop_info['review_code']?>_list" id="<?=$shop_info['review_code']?>_list">
			</div>

			<?}?>


			<? if($shop_info['shop_qna'] == "y"){ ?>
			<script> bbs_load("<?=$shop_info['qna_code']?>"); </script>

			<!-- QNA -->
			<h4 class="page_tit mt70 mb20">Q &amp; A</h4>
			
			<div class="shop-board-wrap <?=$shop_info['qna_code']?>_list" id="<?=$shop_info['qna_code']?>_list">
			</div>
			<!-- END QNA -->

			<?}?>

						
							<?
/*sns 공유시
							 $subject = $row->name;
							 $content = "";
							?>
							<dd>
								<a href="javascript:SNS_Send('face','<?=$subject?>','<?=$content?>');"><img src="/image/shop/sns_fb.jpg" alt="페이스북"></a><span class="ml5"></span>
								<a href="javascript:SNS_Send('tw','<?=$subject?>','<?=$content?>');"><img src="/image/shop/sns_twt.jpg" alt="트위터"></a>
							</dd>

							<? */