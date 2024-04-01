
	<script type="text/javascript">
	jQuery(document).ready(function($){
		checkCurrentSkin();
	});
	function checkCurrentSkin(){
		//현재 스킨 선택
		var nowSkin=$("#wrap").attr("class");
		$("#"+nowSkin).attr("checked","checked");
	}
	//스킨 미리보기
	function skinPreview(skinCode){ $("#wrap").attr("class",skinCode); }

	</script>


			<form method="post" name="admin_form" enctype="multipart/form-data">
				<!-- 관리자 정보 -->
				<h3 class="icon-pen">관리자 설정</h3>
				<table class="adm-table">
					<caption>관리자 설정</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>관리자 아이디</th>
							<td><input type="text" class="width-m" name="admin_userid" value="<?=$admin2->userid?>"></td>
							<th>관리자 비밀번호</th>
							<td><input type="password" class="width-m" name="admin_passwd" autocomplete="new-password"></td>
						</tr>
						<tr>
							<th>로고 설정</th>
							<td colspan="3">
								<p class="pb5"><img src="/_data/file/<? echo isset($shop_info['logo_image']) ? $shop_info['logo_image'] : "profile.png";?>" alt="@업체명" width="160"></p>
								<div class="float-wrap mb10">
									<p class="file">
										<input type="file" id="photo2" name="logo_image" onchange="file_chg(this.value)"><label for="photo2" class="btn-file">파일찾기</label>
										<span class="file-name"><? echo isset($shop_info['logo_image_name']) ? $shop_info['logo_image_name'] : "선택한 파일이 없습니다.";?></span>
									</p>
									<p class="float-l">권장 가로사이즈 : 159 px</p>
								</div>
								<small class="ml10">※ 홈페이지 대표이미지로 들어갑니다.</small>
							</td>
						</tr>
						<tr>
							<th>스킨 설정</th>
							<td colspan="3">
								<ul class="skin-list">
									<li><input type="radio" name="skin" id="skin-indigo" value="skin-indigo" onchange="skinPreview(this.id);"><label for="skin-indigo">Indigo(기본)<em class="skin-thumb indigo"></em></label></li>
									<li><input type="radio" name="skin" id="skin-mint" value="skin-mint" onchange="skinPreview(this.id);"><label for="skin-mint">Mint<em class="skin-thumb mint"></em></label></li>
									<li><input type="radio" name="skin" id="skin-green" value="skin-green" onchange="skinPreview(this.id);"><label for="skin-green">Green<em class="skin-thumb green"></em></label></li>
									<li><input type="radio" name="skin" id="skin-orange" value="skin-orange" onchange="skinPreview(this.id);"><label for="skin-orange">Orange<em class="skin-thumb orange"></em></label></li>
									<li><input type="radio" name="skin" id="skin-indipink" value="skin-indipink" onchange="skinPreview(this.id);"><label for="skin-indipink">Indigo Pink<em class="skin-thumb indipink"></em></label></li>
								</ul>
							</td>
						</tr>

						<tr style="display:<? if($this->session->userdata('ADMIN_LEVEL')<2){?><?}else{?>none<?}?>;">
							<th><strong class="dh_blue">쇼핑몰 사용</strong></th>
							<td><input type="checkbox" name="shop_use" value="y" <? echo (isset($shop_info['shop_use']) && $shop_info['shop_use']=="y") ? "checked" : "";?>></td>
							<th><strong class="dh_blue">모바일 유무</strong></th>
							<td><input type="checkbox" name="mobile_use" value="y" <? echo (isset($shop_info['mobile_use']) && $shop_info['mobile_use']=="y") ? "checked" : "";?>></td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt50 mb60"></p>
				<!-- END 관리자 정보 -->

				<!-- 업체 정보 -->
				<h3 class="icon-pen">업체 정보</h3>
				<table class="adm-table">
					<caption>업체 정보</caption>
					<colgroup>
						<col style="width:18%;"><col style="width:32%;">
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>업체명</th>
							<td colspan="3"><input type="text" class="width-m" name="shop_name" value="<? echo isset($shop_info['shop_name']) ? $shop_info['shop_name'] : "";?>">
							<small class="ml10">※ 홈페이지 타이틀로 들어갑니다.</small>
							</td>
						</tr>
						<tr>
							<th>도메인 (og:url)</th>
							<td colspan="3">http:// <input type="text" class="width-l" name="shop_domain" value="<? echo isset($shop_info['shop_domain']) ? $shop_info['shop_domain'] : "";?>">
							<small class="ml10">※ 홈페이지 주소로 들어갑니다.</small>
							</td>
						</tr>
						<tr>
							<th>대표명</th>
							<td><input type="text" class="width-xl" name="shop_ceo" value="<? echo isset($shop_info['shop_ceo']) ? $shop_info['shop_ceo'] : "";?>"></td>
							<th>사업자번호</th>
							<td><input type="text" class="width-xl" name="shop_num" value="<? echo isset($shop_info['shop_num']) ? $shop_info['shop_num'] : "";?>"></td>
						</tr>
						<tr>
							<th>전화번호1</th>
							<td><input type="text" class="width-xl" name="shop_tel1" value="<? echo isset($shop_info['shop_tel1']) ? $shop_info['shop_tel1'] : "";?>"></td>
							<th>전화번호2</th>
							<td><input type="text" class="width-xl" name="shop_tel2" value="<? echo isset($shop_info['shop_tel2']) ? $shop_info['shop_tel2'] : "";?>"></td>
						</tr>
						<tr>
							<th>팩스</th>
							<td><input type="text" class="width-xl" name="shop_fax" value="<? echo isset($shop_info['shop_fax']) ? $shop_info['shop_fax'] : "";?>"></td>
							<th>이메일</th>
							<td><input type="text" class="width-xl" name="shop_email" value="<? echo isset($shop_info['shop_email']) ? $shop_info['shop_email'] : "";?>"></td>
						</tr>
						<tr>
							<th>통신판매업허가번호</th>
							<td><input type="text" class="width-xl" name="shop_license" value="<? echo isset($shop_info['shop_license']) ? $shop_info['shop_license'] : "";?>"></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th>사업장 주소</th>
							<td colspan="3"><input type="text" class="width-xl" name="shop_address" value="<? echo isset($shop_info['shop_address']) ? $shop_info['shop_address'] : "";?>"></td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt50 mb60"></p>


				<!-- 업체 정보 -->
				<h3 class="icon-pen">기타 검색 정보</h3>
				<table class="adm-table">
					<caption>검색 정보</caption>
					<colgroup>
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>description</th>
							<td colspan="3"><input type="text" class="width-xl" name="description" value="<? echo isset($shop_info['description']) ? $shop_info['description'] : "";?>">
							<small class="mt5 dh_blue" style="display:block;">※ 네이버 검색등에 노출되는 문구입니다. 30자 이내로 작성하세요.</small>
							</td>
						</tr>
						<tr>
							<th>og:description</th>
							<td colspan="3"><input type="text" class="width-xl" name="og_description" value="<? echo isset($shop_info['og_description']) ? $shop_info['og_description'] : "";?>">
							<small class="mt5 dh_blue" style="display:block;">※ description과 동일해도 됩니다. SNS용 설명문구입니다.</small>
							</td>
						</tr>
						<tr>
							<th>og:title</th>
							<td colspan="3"><input type="text" class="width-xl" name="og_title" value="<? echo isset($shop_info['og_title']) ? $shop_info['og_title'] : "";?>">
							<small class="mt5 dh_blue" style="display:block;">※ 홈페이지 제목을 입력하세요. 예: 디자인허브</small>
							</td>
						</tr>
						<tr>
							<th>og:Image</th>
							<td colspan="3">
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="og_image" name="og_image" onchange="$('.og_image_name').html(this.value)"><label for="og_image" class="btn-file">파일찾기</label>
										<span class="og_image_name"><? echo isset($shop_info['og_image']) ? "<a href='/_data/file/".$shop_info['og_image']."' target='_blank'>".$shop_info['og_image_name']."</a>" : "선택한 파일이 없습니다.";?></span>
									</p>
									<p class="float-l">사이즈 : 1200 x 630 px</p>
								</div>
							<small class="mt5 dh_blue" style="display:block;">※ 카카오톡, 네이트온 등 도메인 입력시 자동완성/노출되는 이미지입니다.</small>
							</td>
						</tr>
						<tr>
							<th>검색 태그<br>(네이버웹마스터 제공)</th>
							<td colspan="3"><input type="text" class="width-xl" name="naver_tag" value="<? echo isset($shop_info['naver_tag']) ? $shop_info['naver_tag'] : "";?>">
							<small class="mt5 dh_blue" style="display:block;">※ 예) meta name="naver-site-verification" content="38916429df5aaf5d8ef61d90ecc3bd798d25d735" : content 부분만 입력해 주세요.</small>
							</td>
						</tr>
						<tr>
							<th>검색엔진사용</th>
							<td colspan="3"><input type="checkbox" name="search_use" id="search_use" value="y" <? echo (isset($shop_info['search_use']) && $shop_info['search_use']=="y") ? "checked" : "";?>>
							<label for="search_use"><small class="ml10 dh_blue">※ 홈페이지 오픈시 사용체크 하셔야 검색사이트에 노출이 허용됩니다.</small></label>
							</td>
						</tr>
						<tr>
							<th>네이버 연관채널 사용</th>
							<td colspan="3"><input type="checkbox" name="naver_channel" id="naver_channel" value="y" <? echo (isset($shop_info['naver_channel']) && $shop_info['naver_channel']=="y") ? "checked" : "";?>>
							<label for="naver_channel"><small class="ml10 dh_blue">※ 네이버 연관채널을 사용할 시에 체크해주세요.</small></label>
							</td>
						</tr>
						<tr class="naver_channel" <?if(empty($shop_info['naver_channel']) || (isset($shop_info['naver_channel']) && $shop_info['naver_channel']!="y")){?>style="display:none;"<?}?> >
							<th>ㄴ 연관채널 추가</th>
							<td>
								<div class="delivery_div">
									<input type="hidden" name="naver_channel_cnt" id="naver_channel_cnt" value="<? echo $shop_info['naver_channel_cnt'] > 0 ? $shop_info['naver_channel_cnt'] : "1";?>">
									<div><input type="text" name="naver_channel_url1" id="naver_channel_url1" class="width-xll" placeholder="사용할 연관채널의 링크를 입력해주세요." value="<? echo isset($shop_info['naver_channel_url1']) ? $shop_info['naver_channel_url1'] : "";?>"> <input type="button" class="btn-clear" value="추가" onclick="channel_add()"> <input type="button" value="삭제" onclick="channel_del()"></div>
									<!-- <div><input type="text" name="" class="width-xll" placeholder="사용할 연관채널의 링크를 입력해주세요."></div>
									<div><input type="text" name="" class="width-xll" placeholder="사용할 연관채널의 링크를 입력해주세요."></div> -->
									<?
										if($shop_info['naver_channel_cnt'] > 1){
											for($i=2;$i<=$shop_info['naver_channel_cnt'];$i++){
									?>
										<div class="naver_channel_div<?=$i?>"><input type="text" name="naver_channel_url<?=$i?>" id="naver_channel_url<?=$i?>" class="width-xll" placeholder="사용할 연관채널의 링크를 입력해주세요." value="<? echo isset($shop_info['naver_channel_url'.$i]) ? $shop_info['naver_channel_url'.$i] : "";?>"></div>
									<?
											}
									}?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>


				<? if(isset($shop_info['shop_use']) && $shop_info['shop_use']=="y"){ ?>

				<style>
				.pay_info_table th, .pay_info_table td { border:none; }
				.pay_info_table th { padding:5px 0; }
				.pay_info_table td { padding:0 8px; }
				.delivery_div { width:100%; line-height:35px; }
				</style>

				<p class="align-c mt50 mb60"></p>
				<h3 class="icon-pen">결제 정보</h3>
				<table class="adm-table">
					<caption>결제 정보</caption>
					<colgroup>
						<col style="width:18%;"><col style="width:32%;">
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<?/*
						<tr class="selected">
							<td colspan="4">
								<!-- <p style="line-height:1.7em;" class="pt10 pb10 pl20">
								<strong>※ 결제사별 테스트 계정정보</strong><br>
								<strong>ㆍ KCP　</strong>아이디 : T0000 <br><span class="ml40">　&nbsp;키 : 3grptw1.zW0GSo4PQdaGvsF__</span><br>
								<strong>ㆍ Inicis　</strong>아이디 : INIpayTest<br><span class="ml60">&nbsp;패스워드 : 1111</span><br>
								<strong>ㆍ Nicepay　</strong>아이디 : nictest00m <br><span class="ml70">　키 : 33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==</span><br>
								</p> -->

								<table class="pay_info_table mb5">
								<colgroup>
									<col style="width:11%;"><col style="width:*;">
								</colgroup>
									<tr>
										<th class="align-l" colspan="2">※ 결제사별 테스트 계정정보</th>
									</tr>
									<tr>
										<th class="align-l">ㆍ KCP</th>
										<td>아이디 : T0000</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>키 : 3grptw1.zW0GSo4PQdaGvsF__</td>
									</tr>
									<tr>
										<th class="align-l">ㆍ Inicis</th>
										<td>아이디 : INIpayTest</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>패스워드 : 1111</td>
									</tr>
									<tr>
										<th class="align-l">ㆍ Nicepay</th>
										<td>아이디 : nictest00m</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>키 : 33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<th>카드결제사(PG)</th>
							<td>
									<select name="pg_company" onChange="javascript:escro_view(this.value);">
										<option value="" selected>선택하세요</option>
										<option value="kcp" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="kcp") ? "selected" : "";?>>Kcp</option>
										<option value="inicis" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="inicis") ? "selected" : "";?>>Inicis</option>
										<option value="nicepay" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="nicepay") ? "selected" : "";?>>Nicepay</option>
										<!-- <option value="lguplus" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="lguplus") ? "selected" : "";?>>LG uplus</option> -->
									</select>
							</td>
							<th>상점 아이디</th>
							<td><input type="text" class="width-l" name="pg_id" value="<? echo isset($shop_info['pg_id']) ? $shop_info['pg_id'] : "";?>"></td>
						</tr>
						<tr class="pay kcp nicepay">
							<th>상점 키<br>

							<input type="checkbox" class="ml10 kcp_test" name="kcp_test" id="kcp_test" <? if(isset($shop_info['kcp_test']) && $shop_info['kcp_test']=="1"){ echo "checked"; }?>>
							<label for="kcp_test" class="kcp_test">테스트모드
							</th>
							<td colspan="3"><input type="text" class="width-xl" name="pg_key" value="<? echo isset($shop_info['pg_key']) ? $shop_info['pg_key'] : "";?>">
							</label>
							</td>
						</tr>
						<tr class="pay inicis">
							<th>키 패스워드</th>
							<td colspan="3"><input type="text" class="width-l" name="pg_pw" value="<? echo isset($shop_info['pg_pw']) ? $shop_info['pg_pw'] : "";?>"></td>
						</tr>
						*/?>

						<?php
						if($this->session->userdata("ADMIN_LEVEL") == "1"){	// 디자인허브 최고 관리자 (통합 관리자) 로그인
						/*
						?>
						<tr class="selected">
							<td colspan="4">
								<!-- <p style="line-height:1.7em;" class="pt10 pb10 pl20">
								<strong>※ 결제사별 테스트 계정정보</strong><br>
								<strong>ㆍ KCP　</strong>아이디 : T0000 <br><span class="ml40">　&nbsp;키 : 3grptw1.zW0GSo4PQdaGvsF__</span><br>
								<strong>ㆍ Inicis　</strong>아이디 : INIpayTest<br><span class="ml60">&nbsp;패스워드 : 1111</span><br>
								<strong>ㆍ Nicepay　</strong>아이디 : nictest00m <br><span class="ml70">　키 : 33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==</span><br>
								</p> -->

								<table class="pay_info_table mb5">
								<colgroup>
									<col style="width:11%;"><col style="width:*;">
								</colgroup>
									<tr>
										<th class="align-l" colspan="2">※ 결제사별 테스트 계정정보</th>
									</tr>
									<tr>
										<th class="align-l">ㆍ KCP</th>
										<td>아이디 : T0000</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>키 : 3grptw1.zW0GSo4PQdaGvsF__</td>
									</tr>
									<tr>
										<th class="align-l">ㆍ Inicis</th>
										<td>아이디 : INIpayTest</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>패스워드 : 1111</td>
									</tr>
									<tr>
										<th class="align-l">ㆍ Nicepay</th>
										<td>아이디 : nictest00m</td>
									</tr>
									<tr>
										<th class="align-l"></th>
										<td>키 : 33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==</td>
									</tr>
								</table>
							</td>
						</tr>
						<? */ ?>
						<tr>
							<th>카드결제사(PG)</th>
							<td colspan="3">
									<select name="pg_company" onChange="javascript:escro_view(this.value);">
										<option value="" selected>선택하세요</option>
										<option value="kcp" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="kcp") ? "selected" : "";?>>Kcp</option>
										<option value="inicis" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="inicis") ? "selected" : "";?>>Inicis</option>
										<option value="nicepay" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="nicepay") ? "selected" : "";?>>Nicepay</option>
										<!-- <option value="lguplus" <? echo (isset($shop_info['pg_company']) && $shop_info['pg_company']=="lguplus") ? "selected" : "";?>>LG uplus</option> -->
									</select>

										<input type="checkbox" class="ml10 kcp_test" name="kcp_test" id="kcp_test" <? if(isset($shop_info['kcp_test']) && $shop_info['kcp_test']=="1"){ echo "checked"; }?>>
										<label for="kcp_test" class="kcp_test">테스트모드</label>
										<small class="kcp_real" <?if($shop_info['kcp_test']=="1"){?>style="display:none;"<?}?>>※ 실결제시 site_conf_inc.php 파일의 상점id와 상점key를 수정해주세요.</small>
							</td>
						</tr>
						<tr>
							<th class="pay inicis nicepay">상점 아이디</th>
							<td class="pay inicis nicepay"><input type="text" class="width-l" name="pg_id" value="<? echo isset($shop_info['pg_id']) ? $shop_info['pg_id'] : "";?>"></td>
							<th class="pay nicepay">상점 키</th>
							<td class="pay nicepay"><input type="text" class="width-xl" name="pg_key" value="<? echo isset($shop_info['pg_key']) ? $shop_info['pg_key'] : "";?>">

							<th class="pay inicis">키 패스워드</th>
							<td colspan="3" class="pay inicis"><input type="text" class="width-l" name="pg_pw" value="<? echo isset($shop_info['pg_pw']) ? $shop_info['pg_pw'] : "";?>"></td>

							</td>
						</tr>
						<?php
						}
						else{		// 상점 관리자 로그인
						?>
						<tr>
							<th>카드결제사(PG)</th>
							<td>
								<input type="hidden" name="pg_company" value="<?=@$shop_info['pg_company']?>"> <?=@$shop_info['pg_company']?>
							</td>
							<th>상점 아이디</th>
							<td>
								<input type="hidden" name="pg_id" value="<?=@$shop_info['pg_id']?>"> <?=@$shop_info['pg_id']?>
							</td>
						</tr>
						<tr class="pay kcp nicepay">
							<th>상점 키<br>
								<input type="checkbox" class="ml10 kcp_test" name="kcp_test" id="kcp_test" <? if(isset($shop_info['kcp_test']) && $shop_info['kcp_test']=="1"){ echo "checked"; }?>>
								<label for="kcp_test" class="kcp_test">테스트모드
							</th>
							<td colspan="3">
								<input type="text" class="width-xl" name="pg_key" value="<? echo isset($shop_info['pg_key']) ? $shop_info['pg_key'] : "";?>">
								</label>
							</td>
						</tr>
						<tr class="pay inicis">
							<th>키 패스워드</th>
							<td colspan="3">
								<input type="hidden" name="pg_pw" value="<?=@$shop_info['pg_pw']?>"> <?=@$shop_info['pg_pw']?>
							</td>
						</tr>
						<?php
						}
						?>

						<tr class="op-each-price">
							<th>무통장 입금</th>
							<td colspan="3">
								<ul class="op-each-list" style="margin-bottom:10px;">
									<? if(isset($shop_info['bank_cnt']) && $shop_info['bank_cnt'] > 0){ ?>
									<? for($i=1;$i<=$shop_info['bank_cnt'];$i++){?>
										<li class="bank<?=$i?>">
											은행명 : <input type="text" class="width-s mr10" name="bank_name<?=$i?>" value="<? echo isset($shop_info['bank_name'.$i]) ? $shop_info['bank_name'.$i] : "";?>"> 계좌번호 : <input type="text" class="width-xm" name="bank_num<?=$i?>" value="<? echo isset($shop_info['bank_num'.$i]) ? $shop_info['bank_num'.$i] : "";?>"> <span class="mr10"></span>예금주 : <input type="text" class="width-s" name="input_name<?=$i?>" value="<? echo isset($shop_info['input_name'.$i]) ? $shop_info['input_name'.$i] : "";?>"><? if($i==1){?><button type="button" class="btn-clear ml20" onclick="bank_add()">추가</button><button type="button" class="ml5" onclick="bank_del()">삭제</button><?}?>
										</li>
									<?}?>
									<?}else{?>
									<li>
										은행명 : <input type="text" class="width-s mr10" name="bank_name1"> 계좌번호 : <input type="text" class="width-xm" name="bank_num1"> <span class="mr10"></span>예금주 : <input type="text" class="width-s" name="input_name1"><button type="button" class="btn-clear ml20" onclick="bank_add()">추가</button><button type="button" class="ml5" onclick="bank_del()">삭제</button>
									</li>
									<?}?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>배송비 기능 설정</th>
							<td><input type="radio" name="express_check" value="0" onclick="javascript:expressShow();" <? echo (isset($shop_info['express_check']) && $shop_info['express_check']=="0") ? "checked" : "";?>> 완전 무료 배송
							<td colspan="2">모든 주문에 대해서 완전 무료 배송을 합니다.</td>
						</tr>
						<tr>
							<th>일반배송비 기능</th>
							<td><input type="radio" name="express_check" value="1" onclick="javascript:expressShow();" <? echo (isset($shop_info['express_check']) && $shop_info['express_check']=="1") ? "checked" : "";?>> 일반 배송
							<th>배송비</th>
							<td><input type="text" class="width-s" name="express_money" value="<? echo isset($shop_info['express_money']) ? $shop_info['express_money'] : "";?>"> 원</td>
						</tr>
						<tr id="express_view" style="display:<? echo (isset($shop_info['express_check']) && $shop_info['express_check']=="1") ? "" : "none";?>;">
							<th>무료 배송</th>
							<td><input type="text" class="width-s" name="express_free" value="<? echo isset($shop_info['express_free']) ? $shop_info['express_free'] : "";?>"> 원
							<td colspan="2">일정금액 이상이 될 경우 배송비 무료적용</td>
						</tr>
						<tr id="express_view2" style="display:<? echo (isset($shop_info['express_check']) && $shop_info['express_check']=="1") ? "" : "none";?>;">
							<th>제주/섬지방 배송비</th>
							<td><input type="text" class="width-s" name="express_money2" value="<? echo isset($shop_info['express_money2']) ? $shop_info['express_money2'] : "";?>"> 원
							<td colspan="2">섬지방 또는 제주도로 배송시 배송비 따로 설정</td>
						</tr>
						<tr class="op-each-price">
							<th>배송회사 추가</th>
							<td colspan="3">
								<ul class="op-each-list2" style="margin-bottom:10px;">
									<? if(isset($shop_info['delivery_cnt']) && $shop_info['delivery_cnt'] > 0){ ?>
									<? for($i=1;$i<=$shop_info['delivery_cnt'];$i++){?>
										<li class="delivery<?=$i?>">
											택배회사명 : <input type="text" class="width-s mr10" name="delivery_idx<?=$i?>" value="<? echo isset($shop_info['delivery_idx'.$i]) ? $shop_info['delivery_idx'.$i] : "";?>"> url : <input type="text" class="width-lss" name="delivery_url<?=$i?>" value="<? echo isset($shop_info['delivery_url'.$i]) ? $shop_info['delivery_url'.$i] : "";?>"> <? if($i==1){?><button type="button" class="btn-clear ml20" onclick="delivery_add()">추가</button><button type="button" class="ml5" onclick="delivery_del()">삭제</button><?}?>
										</li>
									<?}?>
									<?}else{?>
									<li>
										택배회사명 : <input type="text" class="width-s mr10" name="delivery_idx1"> url : <input type="text" class="width-lss" name="delivery_url1"> <button type="button" class="btn-clear ml20" onclick="delivery_add()">추가</button><button type="button" class="ml5" onclick="delivery_del()">삭제</button>
									</li>
									<?}?>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="bank_cnt" id="bank_cnt" value="<? echo isset($shop_info['bank_cnt']) ? $shop_info['bank_cnt'] : "1";?>">
				<input type="hidden" name="delivery_cnt" id="delivery_cnt" value="<? echo isset($shop_info['delivery_cnt']) ? $shop_info['delivery_cnt'] : "1";?>">


				<p class="align-c mt50 mb60"></p>
				<h3 class="icon-pen">포인트 정보</h3>
				<table class="adm-table">
					<caption>포인트 정보</caption>
					<colgroup>
						<col style="width:18%;"><col style="width:32%;">
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>가입 포인트</th>
							<td><input type="text" class="width-s" name="point_register" value="<? echo isset($shop_info['point_register']) ? $shop_info['point_register'] : "";?>"> P</td>
							<th>적립 포인트</th>
							<td><input type="text" class="width-s" name="point" value="<? echo isset($shop_info['point']) ? $shop_info['point'] : "";?>"> %</td>
						</tr>
						<tr>
							<th>사용가능 포인트</th>
							<td><input type="text" class="width-s" name="point_use" value="<? echo isset($shop_info['point_use']) ? $shop_info['point_use'] : "";?>"> P</td>
							<td colspan="2">일정 포인트 이상이 될 경우에만 결제시 사용가능</td>
						</tr>
						<tr>
							<th>포인트결제 설정</th>
							<td>
									<select name="point_percent" class="input">
										<?
											for($a=1;$a<=10;$a++){
												$aa	=	$a*10;
										?>
										<option value="<?=$aa?>"  <? if(isset($shop_info['point_percent']) && $shop_info['point_percent']==$aa){ echo "Selected"; } ?>><?=$aa?>%</option>
										<?	 }	?>
									</select>
							</td>
							<td colspan="2">총구매액에서 결제할 수 있는 포인트 사용 한도</td>
						</tr>
					</tbody>
				</table>
				<? if($this->session->userdata('ADMIN_LEVEL')<2){?>

				<p class="align-c mt50 mb60"></p>
				<h3 class="icon-pen">기타 쇼핑몰 설정</h3>
				<table class="adm-table">
					<caption>기타 쇼핑몰 설정</caption>
					<colgroup>
						<col style="width:18%;"><col style="width:32%;">
						<col style="width:18%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th><strong class="dh_blue">리뷰 사용</strong></th>
							<td>
							<input type="checkbox" name="shop_review" value="y" <? echo (isset($shop_info['shop_review']) && $shop_info['shop_review']=="y") ? "checked" : "";?>>
							&nbsp; 게시판 코드 : <input type="text" class="width-s" name="review_code" value="<? echo isset($shop_info['review_code']) ? $shop_info['review_code'] : "review";?>">
							</td>
							<th><strong class="dh_blue">Q&A 사용</strong></th>
							<td><input type="checkbox" name="shop_qna" value="y" <? echo (isset($shop_info['shop_qna']) && $shop_info['shop_qna']=="y") ? "checked" : "";?>>
							&nbsp; 게시판 코드 : <input type="text" class="width-s" name="qna_code" value="<? echo isset($shop_info['qna_code']) ? $shop_info['qna_code'] : "qna";?>">
							</td>
						</tr>
					</tbody>
				</table>

				<?}?>
				<?}?>

				<p class="align-c mt30 mb30"><input type="button" class="btn-l btn-ok" value="적용" onclick="basic_setup_sendit()";></p>
				<!-- END 업체 정보 -->
</form>


<script>
$(function(){
	$("input[name='kcp_test']").change(function(){
		if(this.checked){
			$(".kcp_real").hide();
		}else{
			$(".kcp_real").show();
		}
	});

	$("input[name='naver_channel']").change(function(){
		if(this.checked){
			$(".naver_channel").show();
		}else{
			$(".naver_channel").hide();
		}
	});
});
function bank_add()
{
	var cnt = parseInt($("#bank_cnt").val())+1;
	$("#bank_cnt").val(cnt);

	$(".op-each-list").append('<li class="bank'+cnt+'">은행명 : <input type="text" class="width-s mr10" name="bank_name'+cnt+'"> 계좌번호 : <input type="text" class="width-xm" name="bank_num'+cnt+'"> <span class="mr10"></span>예금주 : <input type="text" class="width-s" name="input_name'+cnt+'">');

}

function bank_del()
{
	var cnt = parseInt($("#bank_cnt").val());

	if(cnt > 1){
		$(".bank"+cnt).remove();
		$("#bank_cnt").val(cnt-1);
	}

}


function delivery_add()
{
	var cnt = parseInt($("#delivery_cnt").val())+1;
	$("#delivery_cnt").val(cnt);

	$(".op-each-list2").append('<li class="delivery'+cnt+'">택배회사명 : <input type="text" class="width-s mr10" name="delivery_idx'+cnt+'"> url : <input type="text" class="width-lss" name="delivery_url'+cnt+'">');

}

function delivery_del()
{
	var cnt = parseInt($("#delivery_cnt").val());

	if(cnt > 1){
		$(".delivery"+cnt).remove();
		$("#delivery_cnt").val(cnt-1);
	}

}
escro_view("<?=$shop_info['pg_company']?>");

function escro_view(text)
{
	$(".pay").hide();
	$("."+text).show();

	if(text!="kcp"){
		$(".kcp_test").hide();
	}else{
		$(".kcp_test").show();
	}
}


function channel_add()
{
	var cnt = $("#naver_channel_cnt").val();
	cnt = parseInt(cnt)+1;

	var txt = '<div class="naver_channel_div'+cnt+'"><input type="text" name="naver_channel_url'+cnt+'" id="naver_channel_url'+cnt+'" class="width-xll" placeholder="사용할 연관채널의 링크를 입력해주세요."></div>';
	$(".delivery_div").append(txt);
	$("#naver_channel_cnt").val(cnt);
}

function channel_del()
{
	var cnt = $("#naver_channel_cnt").val();

	if(cnt > 1){

	$(".naver_channel_div"+cnt).remove();
	cnt = parseInt(cnt)-1;
	$("#naver_channel_cnt").val(cnt);

	}
}

</script>