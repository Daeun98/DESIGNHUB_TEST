

			<!-- Member Wrap -->
			<div class="member-wrap">
				<!-- Join OK -->
				<div class="join-ok">
					<p><img src="/image/members/welcome_bg.png" alt="WELCOME"></p>

					<div class="join-result">
						<dl>
							<dt>이름</dt>
							<dd><?=$row->name?></dd>
							<dt>아이디</dt>
							<dd><?=$row->userid?></dd>
							<dt>이메일</dt>
							<dd><?=$row->email?></dd>
						</dl>

						<div class="join-result-btn">
							<a href="<?=cdir()?>/dh_member/login"><img src="/image/members/btn_login02.png" alt="로그인하기"></a>
							<a href="<?=cdir()?>/dh/main"><img src="/image/members/btn_home.png" alt="홈으로"></a>
						</div>
					</div>

					<p>가입해주셔서 진심으로 감사드립니다.<br>
					아이디와 비밀번호 등 개인정보 유출에 유의하시길 바랍니다.</p>
				</div><!-- END Join OK -->
			</div><!-- END Member Wrap -->