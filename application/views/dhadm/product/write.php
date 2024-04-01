<?
 if(isset($row->idx) && $row->idx){
	$a_idx = $row->idx;
 }else{
	$a_idx = "imsi_".time();
 }
?>
			<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>
			<script src="/_data/js/jquery.form.js"></script>

			<form method="post" name="admin_form" id="admin_form" enctype="multipart/form-data">
			<input type="hidden" name="cate_depth" id="cate_depth" value="1">
			<input type="hidden" name="cate_no" id="cate_no" value="<? echo isset($row->cate_no) ? $row->cate_no : ""; ?>" msg="카테고리를 선택해주세요.">
			<input type="hidden" name="idx" value="<? echo isset($row->idx) ? $row->idx : ""; ?>">
			<input type="hidden" name="a_idx" id="a_idx" value="<?=$a_idx?>">

				<!-- 기본정보 -->
				<h3>기본 정보</h3>
				<table class="adm-table mt10 mb70">
					<caption>제품 등록 - 기본정보</caption>
					<colgroup>
						<col style="width:15%;"><col><col style="width:150px;">
					</colgroup>
					<tbody>
						<? if(isset($row->cate_no)){ ?>
						<tr>
							<th>제품분류</th>
							<td colspan="2">
							<?=$category_name?>
							</td>
						</tr>
						<?}else{?>
						<tr>
							<th>제품분류</th>
							<td colspan="2">
								<select name="cate_no1" onchange="cate_chg(2,this.value)">
									<option value="">1차 카테고리</option>
									<? foreach($cate_list as $cate1){ ?>
									<option value="<?=$cate1->cate_no?>"><?=$cate1->title?></option>
									<?}?>
								</select>
								<select name="cate_no2" id="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;">
									<option value="">2차 카테고리</option>
								</select>
								<select name="cate_no3" id="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;">
									<option value="">3차 카테고리</option>
								</select>
								<select name="cate_no4" id="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;">
									<option value="">4차 카테고리</option>
								</select>
							</td>
						</tr>
						<?}?>
						<tr>
							<th>상품진열</th>
							<td colspan="2">
								<input type="checkbox" name="display_flag[]" id="display_main" value="main" <? echo isset($row->idx) && in_array("main",$row->display_flag) ? "checked" : ""; ?>><label for="display_main">메인페이지 노출</label>
								<!-- <input type="checkbox" name="display_flag[]" id="display_new" value="new" <? echo isset($row->idx) && in_array("new",$row->display_flag) ? "checked" : ""; ?>><label for="display_new">NEW 신상품</label>
								<input type="checkbox" name="display_flag[]" id="display_prim" value="best" <? echo isset($row->idx) && in_array("best",$row->display_flag) ? "checked" : ""; ?>><label for="display_prim">추천상품</label>
								<input type="checkbox" name="display_flag[]" id="display_top" value="top" <? echo isset($row->idx) && in_array("top",$row->display_flag) ? "checked" : ""; ?>><label for="display_top">카테고리 상단노출</label> -->
							</td>
						</tr>
						<tr style="display:<? if($shop_info['shop_use']=="y"){?><?}else{?>none<?}?>;">
							<th>아이콘 선택</th>
							<td>
								<input type="checkbox" name="icon_flag[]" id="icon1" value="new" <? echo isset($row->idx) && in_array("new",$row->icon_flag) ? "checked" : ""; ?>><label for="icon1"><img src="/_dhadm/image/icon/new.gif" alt="신상품"></label>
								<input type="checkbox" name="icon_flag[]" id="icon2" value="sale" <? echo isset($row->idx) && in_array("sale",$row->icon_flag) ? "checked" : ""; ?>><label for="icon2"><img src="/_dhadm/image/icon/sale.gif" alt="세일중"></label>
								<!-- <input type="checkbox" name="icon_flag[]" id="icon3" value="best" <? echo isset($row->idx) && in_array("best",$row->icon_flag) ? "checked" : ""; ?>><label for="icon3"><img src="/_dhadm/image/icon/hot.gif" alt="주문폭주"></label>
								<input type="checkbox" name="icon_flag[]" id="icon4" value="limit" <? echo isset($row->idx) && in_array("limit",$row->icon_flag) ? "checked" : ""; ?>><label for="icon4"><img src="/_dhadm/image/icon/soldout_soon.gif" alt="품절임박"></label> -->
							</td>
							<td>
								<!-- <p class="align-r btn-inline"><button type="button">아이콘 관리</button></p> -->
							</td>
						</tr>
						<tr>
							<th>노출여부</th>
							<td colspan="2">
								<input type="radio" id="display1" name="display" value="1" <? echo isset($row->display) && $row->display==1 ? "checked" : ""; ?> <? if(empty($row->idx)){ echo "checked"; }?>><label for="display1">공개</label>
								<input type="radio" id="display0" name="display" value="0" <? echo isset($row->display) && $row->display==0 ? "checked" : ""; ?>><label for="display0">미공개</label>
							</td>
						</tr>
						<tr>
							<th>브랜드/기획전 분류</th>
							<td colspan="2">
								<? foreach($brand_list as $brand){ ?>
								<input type="checkbox" name="brand_flag[]" id="brand<?=$brand->idx?>" value="<?=$brand->idx?>" <? echo isset($row->idx) && in_array($brand->idx,$row->brand_flag) ? "checked" : ""; ?>><label for="brand<?=$brand->idx?>"><?=$brand->title?></label>
								<?}?>
							</td>
						</tr>
					</tbody>
				</table><!-- END 기본정보 -->

				<!-- 제품정보 -->
				<h3 class="icon-pen">제품 정보<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70 img_add_table">
					<caption>제품정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>제품명</th>
							<td><input type="text" class="width-xl" name="name" value="<? echo isset($row->name) ? $row->name : ""; ?>" msg="제품명을"></td>
							<th>제품코드</th>
							<td><input type="text" class="width-m" readonly name="code" value="<? echo isset($row->code) ? $row->code : time(); ?>"> (자동으로 생성됩니다.)</td>
						</tr>
						<tr>
							<?
							for($dd=1;$dd<=2;$dd++){
								$ff=$dd-1;
								if($dd==1){
									$data_name="브랜드";
								}else{
									$data_name="MATERIAL";
								}

							?>
							<th><input type="text" class="width-s align-c" name="data_name<?=$dd?>" value="<? echo isset($data_row[$ff]->data_name) ? $data_row[$ff]->data_name : $data_name; ?>" readonly></th>
							<td><input type="text" class="width-xl" name="data_txt<?=$dd?>" value="<? echo isset($data_row[$ff]->data_txt) ? $data_row[$ff]->data_txt : ""; ?>"></td>
							<?
								if($dd % 2 == 0){ echo "</tr><tr>"; }
							}
							?>
							<th>제품요약설명<br>(줄바꿈 자동 적용)</th>
							<td colspan="3"><textarea name="detail" cols="30" rows="3"><? echo isset($row->detail) ? $row->detail : ""; ?></textarea></td>
						</tr>
						<tr>
							<th>제품목록 썸네일</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="prod_thumb" name="list_img" onchange="file_chg(this.value,'list')" <? if(empty($row->idx)){?>msg="썸네일 이미지를"<?}?>/><label for="prod_thumb" class="btn-file">파일찾기</label>
										<span class="file-name file-namelist" <? if(isset($row->list_img_real) && $row->list_img!=""){?>onclick="javascript:window.open('/_data/file/goodsImages/<?=$row->list_img?>','','');" style="cursor:pointer;"<?}?>><? echo isset($row->list_img_real) && $row->list_img!="" ? $row->list_img_real : "선택한 파일이 없습니다."; ?></span>
									</p>
									<p class="float-l"><? if(isset($row->list_img) && $row->list_img!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="list_img" style="vertical-align:middle;" onclick="file_del('list_img',<?=$row->idx?>)"><?}?>
									<? if($shop_info['product_list_img']){?><em class="ml10">권장사이즈 : <?=$shop_info['product_list_img']?> px</em><?}?>
									</p>
								</div>
							</td>
						</tr>
						<? /*<input type="hidden" name="img_cnt" id="img_cnt" value="<? echo isset($file_cnt) && $file_cnt>0 ? $file_cnt : "1"; ?>">
							<tr>
								<th class="add_image_th">추가이미지</th>
								<td colspan="3">
									<div class="float-wrap add_image">
										<?
										if(isset($file_cnt) && $file_cnt > 0){
											$f_cnt=0;
											foreach($file_row as $file){
												$f_cnt++;
										?>
										<p class="file mb5">
											<input type="file" id="photo<?=$f_cnt?>" name="add_images<?=$f_cnt?>" onchange="file_chg(this.value,<?=$f_cnt?>)" /><label for="photo<?=$f_cnt?>" class="btn-file">파일찾기</label>
											<span class="file-name file-name<?=$f_cnt?>" <? if(isset($file->real_name) && $file->file_name!=""){?>onclick="javascript:window.open('/_data/file/goodsImages/<?=$file->file_name?>','','');" style="cursor:pointer;"<?}?>><? echo isset($file->real_name) && $file->file_name!="" ? $file->real_name : "선택한 파일이 없습니다."; ?></span>
										</p>

											<p class="float-l">
												<!-- 권장사이즈 : 240 * 240 px --><? if(isset($file->file_name) && $file->file_name!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="add_img<?=$f_cnt?>" style="vertical-align:middle;" onclick="file_del('add_img<?=$f_cnt?>',<?=$file->idx?>,'<?=$f_cnt?>')"><?}?>
												<? if($shop_info['product_view_img']){?><em class="ml10">권장사이즈 : <?=$shop_info['product_view_img']?> px</em><?}?>
												<? if($f_cnt==1){?><button type="button" style="vertical-align:top;" class="btn-clear ml10" onclick="img_add();">이미지 추가</button><?}?>
											</p>

										<?
											}
										}else{?>
										<p class="file mb5">
											<input type="file" id="photo1" name="add_images1" onchange="file_chg(this.value,1)" /><label for="photo1" class="btn-file">파일찾기</label>
											<span class="file-name file-name1">선택한 파일이 없습니다.</span>
										</p>
										<p class="float-l">
											<button type="button" style="vertical-align:top;" class="btn-clear" onclick="img_add();">이미지 추가</button>
											<? if($shop_info['product_list_img']){?><em class="ml10">권장사이즈 : <?=$shop_info['product_view_img']?> px</em><?}?>
										</p>
										<?}?>
									</div>
								</td>
							</tr>
							*/ ?>
						<tr>
							<th>상세내용</th>
							<td colspan="4" class="plain">
								<div>
									<textarea name="content1" id="content1" style="width:100%; height:512px; display:none;"><? echo isset($row->content1) ? $row->content1 : "";?></textarea>
								</div>
							</td>
						</tr>
						<tr <? if($shop_info['mobile_use']!="y"){?>style="display:none;"<?}?>>
							<th>상세내용<br>(모바일용 필요시)</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="m_photo" name="mobile_img" onchange="file_chg(this.value,'m')" /><label for="m_photo" class="btn-file">파일찾기</label>
										<span class="file-name file-namem" <? if(isset($row->mobile_img_real) && $row->mobile_img!=""){?>onclick="javascript:window.open('/_data/file/goodsImages/<?=$row->mobile_img?>','','');" style="cursor:pointer;"<?}?>><? echo isset($row->mobile_img_real) && $row->mobile_img!="" ? $row->mobile_img_real : "선택한 파일이 없습니다."; ?></span>
									</p>
									<p class="float-l"><? if(isset($row->mobile_img) && $row->mobile_img!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="mobile_img" style="vertical-align:middle;" onclick="file_del('mobile_img',<?=$row->idx?>)"><?}?>
									</p>
								</div>
							</td>
						</tr>
						<?
							$cnt=0;
							$height=30;
							if(isset($row->best_prd) && isset($row->best_prd_name) && $row->best_prd_name){
								$best_prd = explode(",",$row->best_prd);
								$best_prd_name = explode("，",$row->best_prd_name);

								if($row->best_prd_name && $row->best_prd_name!="，"){
									$cnt = count($best_prd_name);
									$height = 19 * ($cnt-1);
								}
							}
						?>
						<tr>
							<th>게시판연동</th>
							<td colspan="3">
								<div class="float-wrap">
									<input type="hidden" name="best_prd" id="best_prd" readonly value="<? echo isset($row->best_prd) ? $row->best_prd : ""; ?>">
									<input type="hidden" name="best_prd_name" id="best_prd_name" readonly value="<? echo isset($row->best_prd_name) ? $row->best_prd_name : ""; ?>">
									<select name="prd_name" id="prd_name" size="20" style="width:60%;height:<?=$height?>px;" >
									<?
									if(isset($row->idx) && $row->best_prd_name && $row->best_prd_name!="，"){
										for($i=0;$i<$cnt;$i++){
										if($best_prd_name[$i]){
									?>
										<option value="<?=$best_prd[$i]?>@@<?=$best_prd_name[$i]?>"><?=$best_prd_name[$i]?></option>
									<?
										}
										}
									}
									?>
									</select>
									<img src="/_dhadm/image/icon/bt_up.gif" width="19" height="19" border=0 style="vertical-align:middle;cursor:pointer;" onclick="javascript:cateMove(document.admin_form.prd_name,-1);">
									<img src="/_dhadm/image/icon/bt_down.gif" width="19" height="19" border=0 style="vertical-align:middle;cursor:pointer;" onclick="javascript:cateMove(document.admin_form.prd_name,1);">
									&nbsp;
									<button type="button" onclick="openBestPrd('best_prd','addr','board');">선택하기</button>
									<button type="button" class="btn-alert" onclick="best_prd_del('prd_name');">삭제</button>
									<button type="button" class="btn-clear" onclick="javascript:document.admin_form.best_prd.value=''; $('#prd_name option').remove(); $('#prd_name').attr('style','width:60%;height:30px');">초기화</button>
								</div>
							</td>
						</tr>
						<?
							$cnt=0;
							$height=30;
							if(isset($row->best_prd2) && isset($row->best_prd_name2) && $row->best_prd_name2){
								$best_prd2 = explode(",",$row->best_prd2);
								$best_prd_name2 = explode("，",$row->best_prd_name2);

								if($row->best_prd_name2 && $row->best_prd_name2!="，"){
									$cnt = count($best_prd_name2);
									$height = 19 * ($cnt-1);
								}
							}
						?>
						<tr>
							<th>제품연동</th>
							<td colspan="3">
								<div class="float-wrap">
									<input type="hidden" name="best_prd2" id="best_prd2" readonly value="<? echo isset($row->best_prd2) ? $row->best_prd2 : ""; ?>">
									<input type="hidden" name="best_prd_name2" id="best_prd_name2" readonly value="<? echo isset($row->best_prd_name2) ? $row->best_prd_name2 : ""; ?>">
									<select name="prd_name2" id="prd_name2" size="20" style="width:60%;height:<?=$height?>px;" >
									<?
									if(isset($row->idx) && $row->best_prd_name2 && $row->best_prd_name2!="，"){
										for($i=0;$i<$cnt;$i++){
										if($best_prd_name2[$i]){
									?>
										<option value="<?=$best_prd2[$i]?>@@<?=$best_prd_name2[$i]?>"><?=$best_prd_name2[$i]?></option>
									<?
										}
										}
									}
									?>
									</select>
									<img src="/_dhadm/image/icon/bt_up.gif" width="19" height="19" border=0 style="vertical-align:middle;cursor:pointer;" onclick="javascript:cateMove(document.admin_form.prd_name2,-1);">
									<img src="/_dhadm/image/icon/bt_down.gif" width="19" height="19" border=0 style="vertical-align:middle;cursor:pointer;" onclick="javascript:cateMove(document.admin_form.prd_name2,1);">
									&nbsp;
									<button type="button" onclick="openBestPrd('best_prd2','','',2);">상품선택</button>
									<button type="button" class="btn-alert" onclick="best_prd_del('prd_name2');">삭제</button>
									<button type="button" class="btn-clear" onclick="javascript:document.admin_form.best_prd2.value=''; $('#prd_name2 option').remove(); $('#prd_name2').attr('style','width:60%;height:30px');">초기화</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 제품정보 -->

				<!-- 제품 가격 정보 -->
				<h3 class="icon-pen" style="display:<? if($shop_info['shop_use']=="y"){?>block<?}else{?>none<?}?>;">제품 가격정보<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70" style="display:<? if($shop_info['shop_use']=="y"){?>block<?}else{?>none<?}?>;">
					<caption>제품 가격 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>판매가격</th>
							<td><input type="text" class="width-m" name="shop_price" value="<? echo isset($row->shop_price) ? $row->shop_price : ""; ?>" <? if($shop_info['shop_use']=="y"){?>msg="판매가격을"<?}?>> 원 <small class="ml10">실제 판매금액</small></td>
							<th>표시가격</th>
							<td><input type="text" class="width-m float-l" name="old_price" value="<? echo isset($row->old_price) ? $row->old_price : ""; ?>"><span class="float-l ml5"> 원</span>
							<p class="float-l ml15" style="line-height:1.1em;"><small><span style="text-decoration:line-through;">4,000원</span> 으로 표시<br>미입력시 표기 안됨</small></p></td>
						</tr>
						<tr>
							<th>적립금</th>
							<td colspan="3"><input type="text" class="width-m" name="point" value="<? echo isset($row->point) ? $row->point : ""; ?>"> P<small class="ml10">(기본 정책 : 판매가의 <?=$shop_info['point']?>%, 적립금 별도로 책정 가능)</small></td>
						</tr>
						<tr>
							<th>재고/진열관리</th>
							<td colspan="3">
								<input type="radio" name="unlimit" id="stock_soldout" value="0" <? if(isset($row->idx) && $row->unlimit==0 && $row->number == 0){?>checked<?}?>><label for="stock_soldout"><em class="dh_red">품절상품</em></label>
								<input type="radio" name="unlimit" id="stock_unlimited" value="1" <? if(isset($row->idx) && $row->unlimit==1){?>checked<?}else if(empty($row->idx)){?>checked<?}?>><label for="stock_unlimited">무제한</label>
								<input type="radio" name="unlimit" id="stock_limited" value="2" <? if(isset($row->idx) && $row->unlimit==0 && $row->number > 0){?>checked<?}?>><label for="stock_limited">재고수량</label><input type="text" class="width-xs" name="number" value="<? echo isset($row->number) ? $row->number : ""; ?>"> 개

								<br><small class="mt10">(제품 재고수량은 옵션 미사용일 시에만 적용됩니다. 옵션 사용시 제품별 재고수량은 적용되지 않습니다. )</small>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 제품 가격 정보 -->

				<!-- 제품 가격 정보 -->
				<h3 class="icon-pen" style="display:<? if($shop_info['shop_use']=="y"){?><?}else{?>none<?}?>;">배송비 설정<span class="toggle-btn on"></span> <font size="2">&nbsp;	</font></h3>
				<table class="adm-table mb70" style="display:<? if($shop_info['shop_use']=="y"){?><?}else{?>none<?}?>;">
					<caption>제품 가격 입력 테이블</caption>
					<tbody>
						<tr class="selected">
							<td colspan="4">
								<p style="line-height:1.7em;" class="pt10 pb10 pl20"><strong>
								ㆍ 사이트 기본설정에서 설정해놓은 값이 기본값으로 설정됩니다.<br>
								ㆍ 각 상품의 배송비 설정은 장바구니 구매시에는 적용되지 않고, 단일상품 구매시에만 적용됩니다.<br>
								</strong></p>
							</td>
						</tr>
						<tr>
							<th>배송 기본 정책 사용</th>
							<td>
								<input type="radio" name="express_no_basic" id="express_no_basic0" value="0" <? echo empty($row->express_no_basic) ? "checked" : "";?> <? echo (isset($row->idx) && $row->express_no_basic=="0") ? "checked" : "";?>><label for="express_no_basic0">사용</label> <input type="radio" name="express_no_basic" id="express_no_basic1" value="1" <? echo (isset($row->idx) && $row->express_no_basic=="1") ? "checked" : "";?>><label for="express_no_basic1">미사용</label>
							</td>
							<td colspan="2">미사용시 배송 기본정책이 아닌 제품정책으로 적용됩니다.</td>
						</tr>
						<tr style="display:<?if(isset($row->idx) && $row->express_no_basic=="1"){?><?}else{?>none<?}?>;" class="express_no_basic">
							<th>배송비 기능 설정</th>
							<td><input type="radio" name="express_check" id="express_check1" value="0" onclick="javascript:expressShow();" <? echo empty($row->express_check) ? "checked" : "";?> <? echo (isset($row->idx) && $row->express_check=="0") ? "checked" : "";?>> <label for="express_check1">완전 무료 배송</label>
							<td colspan="2">모든 주문에 대해서 완전 무료 배송을 합니다.</td>
						</tr>
						<tr style="display:<?if(isset($row->idx) && $row->express_no_basic=="1"){?><?}else{?>none<?}?>;" class="express_no_basic">
							<th>일반배송비 기능</th>
							<td><input type="radio" name="express_check" id="express_check2" value="1" onclick="javascript:expressShow();" <? echo (isset($row->idx) && $row->express_check=="1") ? "checked" : "";?>> <label for="express_check2">일반 배송</label>
							<th>배송비</th>
							<td><input type="text" class="width-s" name="express_money" value="<? echo isset($row->express_money) ? $row->express_money : '';?>"> 원</td>
						</tr>
						<tr id="express_view" style="display:<? if(isset($row->express_check)){?><? echo ($row->express_check=="1" && $row->express_no_basic=="1") ? "" : "none";?><?}else{?>none<?}?>;" class="express_no_basic">
							<th>무료 배송</th>
							<td><input type="text" class="width-s" name="express_free" value="<? echo isset($row->express_free) ? $row->express_free : '';?>"> 원
							<td colspan="2">일정금액 이상이 될 경우 배송비 무료적용</td>
						</tr>
					</tbody>
				</table>


				<!-- 제품 옵션 -->
				<h3 class="icon-pen" style="display:<? if($shop_info['shop_use']=="y"){?><?}else{?>none<?}?>;">제품 옵션<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70" style="display:<? if($shop_info['shop_use']=="y"){?><?}else{?>none<?}?>;">
					<caption>제품 옵션 설정을 위한 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>옵션설정</th>
							<td>
								<input type="radio" name="option_use" id="op_not" onchange="optionToggle('op_not');" value="0" <? if(isset($row->idx) && $row->option_use==0){?>checked<?}else if(empty($row->idx)){?>checked<?}?> ><label for="op_not">옵션 사용 안함</label>
								<input type="radio" name="option_use" id="op_each_price" onchange="optionToggle('op_each_price');" value="1" <? if(isset($row->idx) && $row->option_use==1){?>checked<?}?>><label for="op_each_price">옵션 사용</label>
							</td>
						</tr>
						<tr class="op-same-price op-each-price selected" style="display:none;">
							<td colspan="2">
								<p style="line-height:1.7em;" class="pt10 pb10 pl20"><strong>
								ㆍ 해당 옵션을 선택하여 제품을 구매하는 방식입니다.<br>
								ㆍ 옵션은 필수로 1개이상 선택되어야 주문이 가능합니다. (예) 색상 : 빨강, 파랑, 노랑
								</strong></p>
							</td>
						</tr>
							<input type="hidden" name="op_cnt1" id="op_cnt1" >
							<input type="hidden" name="op_cnt2" id="op_cnt2" >
							<input type="hidden" name="op_cnt3" id="op_cnt3" >

						<? for($i=1;$i<=3;$i++){?>
						<tr class="op-each-price" style="display:none;">
							<th><input type="checkbox" id="op_each<?=$i?>" name="option_check<?=$i?>" value="1" <? if(isset($row->idx) && $row->{'option_check'.$i}=="1"){?>checked<?}?> onchange="change_chk(<?=$i?>);"><label for="op_each<?=$i?>">옵션<?=$i?></label></th>
							<td>
								<span class="pl5"> <input type="checkbox" name="option_flag<?=$i?>" id="option_flag<?=$i?>" value="1" <? if( isset(${'option_row'.$i}->flag) && ${'option_row'.$i}->flag==1){?>checked<?}?>> <label for="option_flag<?=$i?>" >가격동일 옵션사용 (미체크시 제품옵션 사용)</label> </span>
								<br><br>
								<input type="hidden" name="option_code<?=$i?>" value="<? echo isset(${'option_row'.$i}->code) ? ${'option_row'.$i}->code : "";?>">
								옵션명 : <input type="text" class="width-m" name="option_title<?=$i?>" id="option_title<?=$i?>" value="<? echo isset(${'option_row'.$i}->title) ? ${'option_row'.$i}->title : "";?>"> <button type="button" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/option_setting/?ajax=1&load=<?=$i?>','prod_option',455,480);">불러오기</button>
								<button type="button" class="ev-add-option-item btn-clear ml5" num="<?=$i?>">항목추가</button>
								<button type="button" class="btn-alert ml5" num="<?=$i?>">항목삭제</button>

								<ul class="op-each-list option_list<?=$i?>">
									<?
										if(isset(${'option_list_cnt'.$i}) && ${'option_list_cnt'.$i} > 0 ){
											${'ot_cnt'.$i} = 0;
											foreach(${'option_list'.$i} as ${'ot'.$i}){
												${'ot_cnt'.$i}++;
									?>
									<li>옵션항목 <?=${'ot_cnt'.$i}?> : <input type="text" class="width-m mr25" name="option_name<?=$i?>_<?=${'ot_cnt'.$i}?>" id="option_name<?=$i?>_<?=${'ot_cnt'.$i}?>" value="<? echo isset(${'ot'.$i}->name) ? ${'ot'.$i}->name : ""; ?>"> 판매가격 : <input type="text" class="width-s" name="option_price<?=$i?>_<?=${'ot_cnt'.$i}?>" id="option_price<?=$i?>_<?=${'ot_cnt'.$i}?>" value="<? echo isset(${'ot'.$i}->price) ? ${'ot'.$i}->price : ""; ?>"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number<?=$i?>_<?=${'ot_cnt'.$i}?>" id="option_number<?=$i?>_<?=${'ot_cnt'.$i}?>" <? if(isset(${'ot'.$i}->unlimit) && ${'ot'.$i}->unlimit=="1"){?>readonly="true" style="background-color:#F0F5F9;"<?}?> value="<? echo isset(${'ot'.$i}->number) ? ${'ot'.$i}->number : ""; ?>"> 개 &nbsp;<input type="checkbox" id="option_unlimit<?=$i?>_<?=${'ot_cnt'.$i}?>" name="option_unlimit<?=$i?>_<?=${'ot_cnt'.$i}?>" value="1" <? if(isset(${'ot'.$i}->unlimit) && ${'ot'.$i}->unlimit=="1"){?>checked<?}?> onchange="num_click('<?=$i?>_<?=${'ot_cnt'.$i}?>')"><label for="option_unlimit<?=$i?>_<?=${'ot_cnt'.$i}?>">무제한</label>
									<!-- 적립금 : <input type="text" class="width-s" name="option_point<?=$i?>_<?=${'ot_cnt'.$i}?>" id="option_point<?=$i?>_<?=${'ot_cnt'.$i}?>" value="<? echo isset(${'ot'.$i}->point) ? ${'ot'.$i}->point : ""; ?>"> P -->
									</li>
									<?
										}
									}else{?>
									<li>옵션항목 1 : <input type="text" class="width-m mr25" name="option_name<?=$i?>_1" id="option_name<?=$i?>_1"> 판매가격 : <input type="text" class="width-s" name="option_price<?=$i?>_1" id="option_price<?=$i?>_1"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number<?=$i?>_1" id="option_number<?=$i?>_1" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" id="option_unlimit<?=$i?>_1" name="option_unlimit<?=$i?>_1" value="1" checked onchange="num_click('<?=$i?>_1')"><label for="option_unlimit<?=$i?>_1">무제한</label>
									<!-- 적립금 : <input type="text" class="width-s" name="option_point<?=$i?>_1" id="option_point<?=$i?>_1"> P -->
									</li>
									<li>옵션항목 2 : <input type="text" class="width-m mr25" name="option_name<?=$i?>_2" id="option_name<?=$i?>_2"> 판매가격 : <input type="text" class="width-s" name="option_price<?=$i?>_2" id="option_price<?=$i?>_2"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number<?=$i?>_2" id="option_number<?=$i?>_2" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" id="option_unlimit<?=$i?>_2" name="option_unlimit<?=$i?>_2" value="1" checked onchange="num_click('<?=$i?>_2')"><label for="option_unlimit<?=$i?>_2">무제한</label>
									<!-- 적립금 : <input type="text" class="width-s" name="option_point<?=$i?>_2" id="option_point<?=$i?>_2"> P -->
									</li>
									<li>옵션항목 3 : <input type="text" class="width-m mr25" name="option_name<?=$i?>_3" id="option_name<?=$i?>_3"> 판매가격 : <input type="text" class="width-s" name="option_price<?=$i?>_3" id="option_price<?=$i?>_3"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number<?=$i?>_3" id="option_number<?=$i?>_3" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" id="option_unlimit<?=$i?>_3" name="option_unlimit<?=$i?>_3" value="1" checked onchange="num_click('<?=$i?>_3')"><label for="option_unlimit<?=$i?>_3">무제한</label>
									<!-- 적립금 : <input type="text" class="width-s" name="option_point<?=$i?>_3" id="option_point<?=$i?>_3"> P -->
									</li>
									<?}?>
								</ul>
							</td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<!-- END 제품 옵션 -->

				<!-- 기타 -->
				<h3 class="icon-pen" style="display:<? if($shop_info['shop_use']=="y"){?>block<?}else{?>none<?}?>;">기타<span class="toggle-btn on"></span></h3>
				<table class="adm-table mb70" style="display:<? if($shop_info['shop_use']=="y"){?>block<?}else{?>none<?}?>;">
					<caption>기타 설정을 위한 입력 테이블</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr class="selected">
							<td colspan="2">
								<p style="line-height:1.7em;" class="pt10 pb10 pl20"><strong>
								ㆍ 배송/교환/반품 안내 내용은 사이트 기본설정에서 설정해놓은 값이 기본값으로 설정됩니다.
								</strong></p>
							</td>
						</tr>
						<!-- <tr>
							<th>사이즈</th>
							<td class="plain">
								<div>
									<textarea name="size_cont" id="size_cont" style="width:100%; height:300px; display:none;"><? echo isset($row->content2) ? $row->content2 : $size->content;?></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<th>세탁 및 주의사항</th>
							<td class="plain">
								<div>
									<textarea name="detail_cont" id="detail_cont" style="width:100%; height:300px; display:none;"><? echo isset($row->content3) ? $row->content3 : $detail->content;?></textarea>
								</div>
							</td>
						</tr> -->
						<tr>
							<th>배송안내</th>
							<td class="plain">
								<div>
									<textarea name="delivery" id="delivery" style="width:100%; height:300px; display:none;"><? echo isset($row->delivery) ? $row->delivery : $delivery->content;?></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<th>교환/반품안내</th>
							<td class="plain">
								<div>
									<textarea name="return" id="return" style="width:100%; height:300px; display:none;"><? echo isset($row->return) ? $row->return : $return->content;?></textarea>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- END 기타 -->
				</form>


				<input type="hidden" name="img_cnt" id="img_cnt" value="<? echo isset($file_cnt) && $file_cnt>0 ? $file_cnt : "1"; ?>">
				<h3 class="icon-pen">추가 이미지<span class="toggle-btn on"></span></h3>
				<table class="adm-table">
					<caption>추가 이미지 </caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
							<tr>
								<th class="add_image_th">추가 이미지</th>
								<td colspan="3">
									<div class="float-wrap add_image">
										<?
										if(isset($file_cnt) && $file_cnt > 0){
											$f_cnt=0;
											foreach($file_row as $file){
												$f_cnt++;
										?>
										<form name="img_form<?=$f_cnt?>" id="img_form<?=$f_cnt?>" enctype="multipart/form-data" method="post">
										<p class="file mb5">
											<input type="file" id="photo<?=$f_cnt?>" name="add_images<?=$f_cnt?>" onchange="ajaxFileUpload(this.value,<?=$f_cnt?>,<?=$file->idx?>)" /><label for="photo<?=$f_cnt?>" class="btn-file">파일찾기</label>
											<span class="file-name file-name<?=$f_cnt?>" <? if(isset($file->real_name) && $file->file_name!=""){?>onclick="javascript:window.open('/_data/file/addImages/<?=$file->file_name?>','','');" style="cursor:pointer;"<?}?>><? echo isset($file->real_name) && $file->file_name!="" ? $file->real_name : "선택한 파일이 없습니다."; ?></span>
										</p>
										</form>


											<p class="float-l">&nbsp;<span class="up_txt<?=$f_cnt?> fileup_txt"><img src="/_data/image/ajax-loader.gif" class="ajax_img<?=$f_cnt?>" style="display:none;"></span>
												<!-- 권장사이즈 : 240 * 240 px --><? if(isset($file->file_name) && $file->file_name!=""){?><img src="/_dhadm/image/icon/prod_delete.jpg" class="add_img<?=$f_cnt?>" style="vertical-align:middle;" onclick="file_del('add_img<?=$f_cnt?>',<?=$file->idx?>,'<?=$f_cnt?>','add');"><?}?>
												<? if($f_cnt==1){?>
												<? if($shop_info['product_view_img']){?><em class="ml10">권장사이즈 : <?=$shop_info['product_view_img']?> px</em><?}?>
												<button type="button" style="vertical-align:top;" class="btn-clear ml10" onclick="img_insert();">이미지 추가</button>
												<?}?>
											</p>

										<?
											}
										}else{?>
										<form name="img_form1" id="img_form1" enctype="multipart/form-data" method="post">
										<p class="file mb5">
											<input type="file" id="photo1" name="add_images1" onchange="ajaxFileUpload(this.value,1)" /><label for="photo1" class="btn-file">파일찾기</label>
											<span class="file-name file-name1">선택한 파일이 없습니다.</span>
										</p>
										</form>
										<p class="float-l">&nbsp;<span class="up_txt1 fileup_txt"><img src="/_data/image/ajax-loader.gif" class="ajax_img1" style="display:none;"></span>
											<span class="del_img1"></span>
											<button type="button" style="vertical-align:top;" class="btn-clear" onclick="img_insert();">이미지 추가</button>
											<? if($shop_info['product_view_img']){?><em class="ml10">권장사이즈 : <?=$shop_info['product_view_img']?> px</em><?}?>
										</p>
										<?}?>
									</div>
								</td>
							</tr>
					</tbody>
				</table>


				<p class="align-c mt40"><input type="button" name="writeBtn" class="btn-ok btn-xl" value="<? echo isset($row->idx) ? "수정하기" : "등록하기"; ?>" onclick="frmChkPrd('admin_form','p_editor');"></p>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//option add event
		$(".ev-add-option-item").on("click", function(){
			var num = $(this).attr("num");
			var $list = $(this).next("button").next("ul");
			var item = $("li", $list).html();
			var idx = $("li",$list).length + 1;


			//var newItem = "<li>"+item.replace(/옵션항목.+?:/, "옵션항목 "+idx+" :")+"</li>";
			var newItem = '<li>옵션항목 '+idx+' : <input type="text" class="width-m mr25" name="option_name'+num+'_'+idx+'" id="option_name'+num+'_'+idx+'"> 판매가격 : <input type="text" class="width-s" name="option_price'+num+'_'+idx+'" id="option_price'+num+'_'+idx+'"> 원<span class="mr40"></span> 재고수량 : <input type="text" class="width-xs" name="option_number'+num+'_'+idx+'" id="option_number'+num+'_'+idx+'" readonly="true" style="background-color:#F0F5F9;"> 개 &nbsp;<input type="checkbox" id="option_unlimit'+num+'_'+idx+'" name="option_unlimit'+num+'_'+idx+'" value="1" checked onchange="num_click(\''+num+'_'+idx+'\')"><label for="option_unlimit'+num+'_'+idx+'">무제한</label>'+
			//'적립금 : <input type="text" class="width-s" name="option_point'+num+'_'+idx+'" id="option_point'+num+'_'+idx+'"> P'+
									'</li>';
			$list.append(newItem);
		});

		$(".btn-alert").on("click", function(){
			var num = $(this).attr("num");
			var $list = $(this).next("ul");
			var idx = $("li",$list).length - 1;
			$("li",$list).eq(idx).remove();

		});

		$("input[name='express_no_basic']").change(function(){
			if(this.checked){
				if($(this).val()=="1"){
					$(".express_no_basic").show();
				}else{
					$(".express_no_basic").hide();
				}
			}
		});
	});

	<? if(isset($row->idx) && $row->option_use==1){?>optionToggle('op_each_price');<?}?>

	function optionToggle(select){
		//option select
		switch (select)
		{
			case 'op_not': $(".op-same-price, .op-each-price").hide();
				break;
			case 'op_same_price':
				$(".op-each-price").hide();
				$(".op-same-price").show();
				break;
			case 'op_each_price':
				$(".op-same-price").hide();
				$(".op-each-price").show();
				//$("input[id='stock_unlimited']").prop("checked",true);
				break;
		}
	}


	function frmChkPrd(frmName,mode)
	{

			if (checkForm(frmName)) {
				if(mode=="editor"){
					oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
				}else if(mode=="p_editor"){
					CKEDITOR.instances.content1.updateElement();
					CKEDITOR.instances.delivery.updateElement();
					CKEDITOR.instances.return.updateElement();
				}

				<? if($shop_info['shop_use']=="y"){?>
				if($("input[id='op_each_price']:checked").length && $("input[name='option_check1']:checked").length==0 && $("input[name='option_check2']:checked").length==0 && $("input[name='option_check3']:checked").length==0){
					alert("옵션을 사용하시려면 옵션내용을 체크&입력해주세요.");
					return;
				}
				for (i=1;i<=3;i++ )
				{
					if($("input[name='option_check"+i+"']:checked").length > 0 && ( $("#option_title"+i).val()=="" || $("#option_name"+i+"_1").val()=="") ){
						alert("옵션 "+i+"의 옵션명과 항목을 입력해주세요.");
						$("#option_title"+i).focus();
						return;
					}
					<? if(empty($row->idx)){?>
					if($("#option_title"+i).val() && $("input[name='option_check"+i+"']:checked").length == 0 ){
						alert("옵션 "+i+"를 사용하시려면 해당 옵션을 체크해주세요.");
						$("#op_each"+i+"']").focus();
						return;
					}
					<?}?>

					if($("input[name='option_check"+i+"']:checked").length > 0){
						$("#op_cnt"+i).val($(".option_list"+i+" li").length);
					}

				}

				<?}?>


				/* 추천제품 사용시에만 start */
				 best_prd_sel();
				/* 추천제품 사용시에만 end */


				$("#"+frmName).submit();
				$("input[name='writeBtn'").attr("disabled",true);
			}
			return;
	}

	function cate_chg(depth, cate_no)
	{
		if(depth==5){
			$("#cate_no").val(cate_no);
		}else{

			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write",
					data: {ajax : "1", depth : depth, cate_no: cate_no, de: "1"},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).hide();
						}
						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no"+depth).show();
							$("#cate_no").val("");
						}else{
							$("#cate_no").val(cate_no);
						}
					}
				});
			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
				}

				$("#cate_depth").val(depth);
				$("#cate_no").val(cate_no);
			}

		}

	}

	function img_add()
	{
		var cnt = parseInt($("#img_cnt").val())+1;

		if(cnt < 6){

		var txt = '<p class="file mb5">'+
								'<input type="file" id="photo'+cnt+'" name="add_images'+cnt+'" onchange="file_chg(this.value,'+cnt+')" /><label for="photo'+cnt+'" class="btn-file">파일찾기</label>'+
								'<span class="file-name file-name'+cnt+'">선택한 파일이 없습니다.</span>'+
							'</p>';

		$("#img_cnt").val( cnt );
		$(".add_image").append(txt);

		var height = $(".add_image_th").css("height");

		$(".add_image_th").css("height",height);
		$(".add_image_th").css("vertical-align","middle");

		}else{
			alert("이미지는 최대 5개까지 등록할 수 있습니다.");
			return;
		}
	}


	function file_del(mode, idx, num, add)
	{
		if(confirm("이미지를 삭제하시겠습니까?")){
			$.ajax({
				url: "<?=cdir()?>/product/file_del",
				data: {ajax : "1", mode : mode, idx: idx},
				async: true,
				cache: false,
				error: function(xhr){
				},
				success: function(data){
					if(mode=="list_img"){
						$(".file-namelist").html("선택한 파일이 없습니다.");
						$("#prod_thumb").attr("msg","썸네일 이미지를");
						$("."+mode).hide();
					}else if(mode=="mobile_img"){
						$(".file-namem").html("선택한 파일이 없습니다.");
						$("."+mode).hide();
					}else{
						$(".file-name"+num).html("선택한 파일이 없습니다.");
						$("."+mode).hide();
					}

					if(add=='add'){
						if(num!=1){
							$("#img_form"+gall_cnt).remove();
						}
					}
				}
			});
		}
	}


	function change_chk(num)
	{
		var cnt = $(".option_list"+num+" li").length;

		if($("input[name='option_check"+num+"']:checked").length==0){

			if(confirm("옵션"+num+" 사용을 취소하시겠습니까?")){
				$("#option_title"+num).val("");

				for(i=1;i<=cnt;i++){
					$("#option_name"+num+"_"+i).val("");
					$("#option_price"+num+"_"+i).val("");
					$("#option_point"+num+"_"+i).val("");
				}

			}else{

				$("input[name='option_check"+num+"']").prop("checked",false);
			}
		}
	}


	function num_click(num)
	{
		if($("input[name='option_unlimit"+num+"']:checked").length > 0){
			$("#option_number"+num).val("");
			$("#option_number"+num).attr("style","background-color:#F0F5F9;");
			$("#option_number"+num).attr("readonly",true);
			$("#option_number"+num).attr("style","background-color:#F0F5F9;");
		}else{
			$("#option_number"+num).attr("readonly",false);
			$("#option_number"+num).attr("style","");
		}
	}




	//추천 제품 순서 변경
function cateMove(index,to)
{
	var list = index;
	var total = list.length-1;
	var index = list.selectedIndex;

	if (index==-1){
		alert("이동할 컨텐츠를 선택하세요.");
		return;
	}

	if (to == +1 && index == total) return alert('이동이 불가능합니다');
	if (to == -1 && index == 0) return alert('이동이 불가능합니다');

	var items = new Array;
	var values = new Array;

	for (i = total; i >= 0; i--) {
		items[i] = list.options[i].text;
		values[i] = list.options[i].value;
	}

	for (i = total; i >= 0; i--) {
		if (index == i) {
			list.options[i + to] = new Option(items[i],values[i], 0, 1);
			list.options[i] = new Option(items[i + to], values[i + to]);
			i--;
		}
		else
		{
			list.options[i] = new Option(items[i], values[i]);
		}
	}
	return;
}

	function best_prd_sel() //추천제품 사용시
	{
			var form = document.admin_form;

				data_cnt =0;

				$("#best_prd").val('');
				$("#best_prd_name").val('');


				for( data_cnt=0; data_cnt < form.prd_name.length; data_cnt ++) {
					var prd_data = form.prd_name.options[data_cnt].value;
					prd_data = prd_data.split("@@");
					form.best_prd.value =form.best_prd.value + prd_data[0] + ",";
					form.best_prd_name.value =form.best_prd_name.value + prd_data[1] + "，";
				}


				data_cnt =0;

				$("#best_prd2").val('');
				$("#best_prd_name2").val('');

				for( data_cnt=0; data_cnt < form.prd_name2.length; data_cnt ++) {
					var prd_data2 = form.prd_name2.options[data_cnt].value;
					prd_data2 = prd_data2.split("@@");
					form.best_prd2.value =form.best_prd2.value + prd_data2[0] + ",";
					form.best_prd_name2.value =form.best_prd_name2.value + prd_data2[1] + "，";
				}

				/* 추천제품이 많아지면 */
				/*
				data_cnt =0;

				$("#best_prd3").val('');
				$("#best_prd_name3").val('');

				for( data_cnt=0; data_cnt < form.prd_name3.length; data_cnt ++) {
					var prd_data3 = form.prd_name3.options[data_cnt].value;
					prd_data3 = prd_data3.split("@@");
					form.best_prd3.value =form.best_prd3.value + prd_data3[0] + ",";
					form.best_prd_name3.value =form.best_prd_name3.value + prd_data3[1] + "，";
				}


				data_cnt =0;

				$("#best_prd4").val('');
				$("#best_prd_name4").val('');

				for( data_cnt=0; data_cnt < form.prd_name4.length; data_cnt ++) {
					var prd_data4 = form.prd_name4.options[data_cnt].value;
					prd_data4 = prd_data4.split("@@");
					form.best_prd4.value =form.best_prd4.value + prd_data4[0] + ",";
					form.best_prd_name4.value =form.best_prd_name4.value + prd_data4[1] + "，";
				}*/
	}

	function best_prd_del(id)
	{
		var num = $("#"+id+" option:selected").index();
		$("#"+id+" option:selected").remove();
		t_cnt = $("#"+id+" option").length;

		if(t_cnt < 2){
			t_cnt = 30;
		}else{
			t_cnt = parseInt(t_cnt) * 19;
		}

		if($("#"+id+" option").length == num){
			num = parseInt(num)-1;
		}

		$("#"+id+" option:eq("+num+")").attr("selected", "selected");

		$("#"+id).attr("style","width:60%;height:"+t_cnt+"px");
	}


	function openBestPrd(id,code,cont,num)
	{
		best_prd_sel();
		url = "";

		if(!cont){ cont = 'product'; }
		if(!num){ num = ''; }

		if(code){
			url = code+"/";
		}

		openWinPopup('<?=cdir()?>/'+cont+'/best_prd/'+url+num+'?ajax=1&prd='+$("#"+id).val(),id,620,650);
	}



	/* 추가 이미지 ajax 시작 */


	function img_insert()
	{
		var cnt = parseInt($("#img_cnt").val())+1;

		//if(cnt < 11){

		var txt = '<form name="img_form'+cnt+'" id="img_form'+cnt+'" enctype="multipart/form-data" method="post"><input type="hidden" id="up_cnt'+cnt+'" value="0">'+
							'<p class="file mb5">'+
								'<input type="file" id="photo'+cnt+'" name="add_images'+cnt+'" onchange="ajaxFileUpload(this.value,'+cnt+')" ins_id=""/><label for="photo'+cnt+'" class="btn-file">파일찾기</label>'+
								'<span class="file-name file-name'+cnt+'">선택한 파일이 없습니다.</span>'+
							'</p>'+
							'<p class="float-l">&nbsp;<span class="up_txt'+cnt+' fileup_txt"><img src="/_data/image/ajax-loader.gif" class="ajax_img'+cnt+'" style="display:none;"></span>&nbsp;<span class="del_img'+cnt+'"></span></form>';

		$("#img_cnt").val( cnt );
		$(".add_image").append(txt);

		var height = $(".add_image_th").css("height");

		$(".add_image_th").css("height",height);
		$(".add_image_th").css("vertical-align","middle");

		/*}else{
			alert("이미지는 최대 10개까지 등록할 수 있습니다.");
			return;
		}*/
	}



				function ajaxFileUpload(value, gall_cnt, del_idx){


					var val = value.split('\\');
					if(!gall_cnt){ gall_cnt = ""; }

					$(".ajax_img"+gall_cnt).show();

					var param = "";

					<? if(isset($row->idx)){?>

						if(del_idx){
							param = "&del_idx="+del_idx;
						}

						param = param + "&mode=edit";

					<?}?>

					if($("#photo"+gall_cnt).attr("ins_id")){
						param = "&del_idx="+$("#photo"+gall_cnt).attr("ins_id");
					}


					$("#img_form"+gall_cnt).attr("action","/html/product/file_up?ajax=1&gall_cnt="+gall_cnt+"&a_idx=<?=$a_idx?>"+param);
					$("#img_form"+gall_cnt).ajaxSubmit({

								success : function(data) {

									if(data){

										$(".ajax_img"+gall_cnt).hide();
										$(".file-name"+gall_cnt).html(val[2]);
										$(".del_img"+gall_cnt).html('<img src="/_dhadm/image/icon/prod_delete.jpg" class="add_img'+gall_cnt+'" style="vertical-align:middle;" onclick="ajaxFiledel('+gall_cnt+','+data+')"> &nbsp;&nbsp;');
										$("#photo"+gall_cnt).attr("ins_id",data);

									}

								},

								error : function(error) {

									//alert("요청 처리 중 오류가 발생하였습니다.");

								}

					});
				}


				function ajaxFiledel(gall_cnt, del_idx)
				{
					$.ajax({
						url: "<?=cdir()?>/product/file_up",
						data: {ajax : "1", mode : 'del', del_idx: del_idx},
						async: true,
						cache: false,
						error: function(xhr){
						},
						success: function(data){
							if(gall_cnt!=1){
								$("#img_form"+gall_cnt).remove();
							}
							$("#photo"+gall_cnt).attr("ins_id","");
							$(".add_img"+gall_cnt).hide();
							$(".file-name"+gall_cnt).html("선택한 파일이 없습니다.");
						}
					});

				}


	/* 추가 이미지 ajax 종료 */

	</script>

<script type="text/javascript" src="/_data/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('content1');
	CKEDITOR.replace('delivery');
	CKEDITOR.replace('return');
</script>