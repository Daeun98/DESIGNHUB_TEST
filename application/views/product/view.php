
					<!-- View top -->
					<div class="shop_view_top">
						<div class="prod_img_wrap">
							<ul class="prod_img">
								<? foreach($file_list as $file){ ?>
								<li><img src="/_data/file/goodsImages/<?=$file->file_name?>" alt="<?=$row->name?>" width="270" height="350"></li>
								<?}?>
							</ul>
						</div>
						<div class="prod_info_wrap">
							<h2 class="prod_name"><?=$row->name?></h2>
							<p class="prod_name_en"><!-- [EGF Serum] --></p>

							<p class="prod_cmt"><?=$row->detail?></p>

							<dl class="prod_info">
								<? 
								foreach($data_list as $data){ ?>
								<dt><?=$data->data_name?></dt>
								<dd><?=$data->data_txt?></dd>
								<?}?>
							</dl>

							<p class="rel_tit">함께 사용하면 좋은제품</p>
							<ul class="rel_prod">
								<? 
								if(isset($best_row[0]['idx'])){
								$best_row_cnt = count($best_row)-1;
								for($i=0;$i<count($best_row);$i++){ 
								?>
								<li <?if($i==$best_row_cnt){?>class="last"<?}?>><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$best_row[$i]['idx']?>?&cate_no=<?=$best_row[$i]['cate_no']?>">
									<p class="thumb"><img src="/_data/file/goodsImages/<?=$best_row[$i]['list_img']?>" alt="" width="83" height="110"></p>
									<span><?=$best_row[$i]['name']?></span>
									</a>
								</li>
								<? }
								}
								?>
							</ul>
						</div>
					</div>
					<!-- END View top -->

					<!-- View detail -->
					<div class="shop_view">
						<h4><em>제품설명</em></h4>
						<div class="prod_dt">
							<?=$row->content1?>
						</div>
					</div>
<!-- 
					<div class="shop_view">
						<h4><em>주요기능</em></h4>
						<div class="prod_dt">
							· 손상된 피부 개선 및 예방<br>
							· 피부 장벽 강화<br>
							· 피부에 영양공급
						</div>
					</div>

					<div class="shop_view">
						<h4><em>주요성분</em></h4>
						<div class="prod_dt">
							올리고펩타이드, 이스트 추출물, 비사보롤, 비타민E, 스쿠알란
						</div>
					</div>
					
					<div class="shop_view">
						<h4><em>사용방법</em></h4>
						<div class="prod_dt">
							아침, 저녁에 토너 정리를 한 후 EGF 세럼을 3-4방울 덜어서 부드럽게 마사지 하듯 펴 바른다.
						</div>
					</div> -->
					<!-- END View detail -->