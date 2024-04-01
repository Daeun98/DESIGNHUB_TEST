
			<!-- Member Wrap -->
			<div class="member-wrap">
				<!-- Join -->
				<div class="join-wrap">
					<!-- Join Top -->
					<div class="join-top">
						<p class="join-title"><img src="/image/members/join.png" alt="JOIN"></p>
						<p class="join-step">
							<img src="/image/members/join_tap01_on.png" alt="STEP01. 약관동의">
							<img src="/image/members/join_tap02.png" alt="STEP02. 정보입력">
							<img src="/image/members/join_tap03.png" alt="STEP03. 가입완료">
						</p>
					</div><!-- END Join Top -->
					
		<form name="join_form" id="join_form" action="?agree=1" method="post">
					<!-- 약관동의 -->
					<div class="join-agree">
						<p class="join-agree-l"><img src="/image/members/join_txt01.png" alt="약관동의"></p>
						<div class="join-agree-r">
							<div class="join-condition">
								<?=$agreement->content?>
							</div>
							<p><input type="checkbox" id="agree01" name="agree01" msg="약관에 동의해주세요." value="1">
								<label for="agree01">위 약관에 동의하시면 체크해 주세요.</label>
							</p>
						</div>
					</div><!-- END 약관동의 -->
					
					<!-- 개인정보취급방침 -->
					<div class="join-agree mt30">
						<p class="join-agree-l"><img src="/image/members/join_txt02.png" alt="개인정보취급방침"></p>
						<div class="join-agree-r">
							<div class="join-condition">
								<?=$safeguard->content?>
							</div>

							<p><input type="checkbox" id="agree02" name="agree02" msg="개인정보취급방침에 동의해주세요." value="1">
								<label for="agree02">위 약관에 동의하시면 체크해 주세요.</label>
							</p>
						</div>
					</div><!-- END 개인정보취급방침 -->
					
					<!-- Join Button -->
					<p class="join-btn" style="padding-left:150px;">
						<input type="button" value="취소" class="join-btn-cancel" onclick="javascript:history.back(-1);">
						<input type="button" value="다음단계로" class="join-btn-ok" onclick="frmChk('join_form')">
					</p>
					<!-- End Join Button -->	
		</form>


				</div><!-- END Join -->
			</div><!-- END Member Wrap -->
