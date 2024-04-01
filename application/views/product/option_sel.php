
							<li class="option<?=$option_row->idx?>">
								<div class="info">
									<div class="opt">
										<?=$option_row->title?> | <?=$option_row->name?>
									</div>
									<div class="vol">
										<input type="text" name="optionCnt<?=$option_row->idx?>" id="optionCnt<?=$option_row->idx?>" value="1" readonly>
										<button type="button" class="vol-up" onclick="cntChange(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>,'u',<?=$option_row->unlimit?>,<?=$option_row->number?>)">추가</button>
										<button type="button" class="vol-down" onclick="cntChange(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>,'d',<?=$option_row->unlimit?>,<?=$option_row->number?>)">감소</button>
									</div>
								</div>
								<div class="edit">
									<?=number_format($option_row->price+$row->shop_price)?> <button type="button" class="opt-del" onclick="option_del(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>)">삭제</button>
								</div>
							</li>

							<script>
								var total_price = $("#total_price").val();
								total_price = parseInt(total_price)+<?=$option_row->price+$row->shop_price?>;
								$("#total_price").val(total_price);
								$(".total_price").html(number_format(0,total_price));	
								$("#option_flag").val(1);
							</script>