

					<form name="frm" id="frm" method="post" enctype="multipart/form-data" >
					<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('USERID')) ? @$this->session->userdata('USERID') : "";?>" />
					<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
					<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
					<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">
					<input type="hidden" name="cate_idx" value="<? echo isset($row->cate_idx) ? $row->cate_idx : $this->input->get("cate_idx");?>">
					<input type="hidden" name="goods_idx" value="<? echo isset($row->goods_idx) ? $row->goods_idx : $this->input->get("goods_idx");?>">

					<input type="text" class="oq-field" id="oq-dept" placeholder="이름을 입력하세요." name="name" value="<? echo isset($row->name) ? $row->name : ""?>">

								<? if(empty($row->idx)){?>
								<li class="full-width">
									<div class="oqi-label"><label for="oq-code">보안문자</label></div>
									<div class="oqi-field float-wrap pl0">
										<span class="mr20 dh_red" style="font-weight:bold;"><?=$cnum_real?></span>
										<input type="text" class="oq-field" id="oq-code" style="width:150px;" maxlength="4" name="num" msg="보안문자를">
										<span class="dh_gray ml20">왼쪽에 표시된 문자를 입력해주세요.</span>
									</div>
								</li>
								<?}?>
							<p class="align-c">
								<button type="button" class="btn-emp" name="writeBtn" onclick="javascript:frmChk('frm');"><? if(empty($row->idx)){?>제출하기<?}else{?>접수수정<?}?></button>
								<button type="button" class="btn-border ml15" onclick="history.back();">뒤로가기</button>
							</p>
				</form>
