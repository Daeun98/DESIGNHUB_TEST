
					<!-- 리스트 상단 -->
					<div class="shop_list_top">
						<p class="cnt">총 <em><?=number_format($totalCnt)?>개</em>의 상품</p>
						<!-- <ul class="list_tab">
							<li class="on"><a href="#">트리트먼트</a></li>
							<li><a href="#">홈케어</a></li>
						</ul> -->
					</div><!-- END 리스트 상단 -->

					<ul class="shop_list">
						<? 
						$list_cnt=0;
						foreach($list as $lt){
							$list_cnt++;
						?>
						<li<?if($list_cnt%4==0){?> class="mr0"<?}?>><a href="/html/dh_product/shop_view/<?=$lt->idx.$query_string.$param?>">
								<div class="thumb">
									<img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt="<?=$lt->name?>" width="205" height="275">
									<p class="mover"><?=$lt->detail?></p>
								</div>
								<!-- <p class="name_en"><?=$lt->name?></p> -->
								<p class="name_ko"><?=$lt->name?></p>
							</a>
						</li>
						<? } ?>
					</ul>
				<? if($totalCnt > 0){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page2?>
				</p><!-- END Pager -->
				<?}?>