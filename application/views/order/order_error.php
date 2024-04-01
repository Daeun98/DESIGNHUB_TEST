	
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<div class="order-finish-msg error-msg">
						<p><img src="/image/shop/error_txt.png" alt="주문에 실패했습니다."></p>
						<p class="mt15">에러코드 : <?=$this->uri->segment(3)?> <?if($this->uri->segment(3)=="VB10"){?><br>에러메세지 : 해당 은행 계좌 없음<?}else if($this->input->get("msg")){?><br>에러메세지 : <?=$this->input->get("msg")?><?}?></p>
						<p class="mt10">계속해서 문제가 발생한다면, 고객센터로 연락 바랍니다.</p>
					</div>
					
						
					<!-- 하단 버튼 -->
					<div class="align-c mb50" style="text-align:center;">
						<button type="button" class="btn-border" onclick="javascript:location.href='<? if($this->input->get("go_url")){?><?=$this->input->get("go_url")?><? if($this->input->get("nologin")){ echo "?nologin=1"; }?><?}else{?>/<?}?>';">메인으로 돌아가기</button>
					</div><!-- END 하단 버튼 -->
					
					
				</div><!-- END 주문 Wrap -->
			
			</div><!-- END Shop Wrap -->