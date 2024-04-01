														
							<? 
							$cnt=0;
							foreach($option_list as $ot){
							$cnt++;
							?>																		
									<li>옵션항목 <?=$cnt?> : <input type="text" class="width-m mr25" name="option_name<?=$load?>_<?=$cnt?>" id="option_name<?=$load?>_<?=$cnt?>" value="<?=$ot->name?>"> 판매가격 : <input type="text" class="width-s" name="option_price<?=$load?>_<?=$cnt?>" id="option_price<?=$load?>_<?=$cnt?>" value="<?=$ot->price?>"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number<?=$load?>_<?=$cnt?>" id="option_number<?=$load?>_<?=$cnt?>" <?if($ot->unlimit=="1"){?>readonly="true" style="background-color:#F0F5F9;"<?}?> value="<?=$ot->number?>"> 개 &nbsp;<input type="checkbox" id="option_unlimit<?=$load?>_<?=$cnt?>" name="option_unlimit<?=$load?>_<?=$cnt?>" value="1" <?if($ot->unlimit=="1"){?>checked<?}?> onchange="num_click('<?=$load?>_<?=$cnt?>')"><label for="option_unlimit<?=$load?>_<?=$cnt?>">무제한</label>
									</li>
							<? } ?>