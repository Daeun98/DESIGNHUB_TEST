
				<div class="float-wrap mb20">
					<h4 class="float-l tab-tit">제품리뷰 <small>(<?=$totalCnt?>)</small></h4>
					<!-- <span class="float-r"><a href="javascript:;" onclick="<? if( $bbs->bbs_write < 9 && !$this->session->userdata('USERID') ) { ?>go_login('<?=cdir()?>/dh_product/prod_view/<?=$this->input->get("goods_idx")?>')<?}else{?>board_write('<?=$bbs->code?>','<?=$this->input->get("goods_idx")?>')<?}?>" class="btn-write">글쓰기</a></span> -->
				</div>

				<!-- Board wrap -->
				<div class="board-wrap">
					<!-- 리뷰 게시판 리스트 -->
					<table class="shop-board board-list review-board">
						<thead>
							<tr>
								<th class="col-num">No.</th>
								<th>제목</th>
								<th class="col-writer">작성자</th>
								<th class="col-date">날짜</th>
								<th class="col-df">평점</th>
								<th class="col-view">조회</th>
						</tr>
					</thead>
					<tbody>
						<?
						$listuse=1;
						if($totalCnt == 0){ 
						$listuse=0;
						?>
							<tr>
								<td colspan="6" class="no-ct">
									<p>등록된 후기가 없습니다.</p>
								</td>
							</tr>
						<?}?>
						<? 
						foreach ($list as $lt){						
						?>
							
							<tr>
								<td><? if($lt->notice > 0){?><img src="/image/board_img/review_best.png" alt="BEST!"><?}else{?><?=$totalCnt?><?}?></td>
								<td class="list-tit"><a href="javascript:view_on(<?=$lt->idx?>)"><?=$lt->subject?></a><? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?></td>
								<td><?=$lt->name?></td>
								<td><?=strDateCut($lt->reg_date,7)?></td>
								<td><span class="review-star" data-grade="<?=$lt->grade?>"><?=$lt->grade?>점</span></td>
								<td><?=$lt->read_cnt?></td>
							</tr>
							<tr class="shop-board-ct view<?=$lt->idx?>" style="display:none;">
								<td colspan="6">
									<div class="u-editor">
										<?=$lt->content?>
									</div>

									<? if($this->session->userdata('USERID') != "" && $this->session->userdata('USERID') == $lt->userid){ //작성자와 로그인아이디가 같을때?>
									<!-- 수정/삭제 -->
									<p class="shop-board-edit">
										<button type="button" class="plain" onclick="javascript:location.href='<?=cdir()?>/dh_board/views/<?=$lt->idx?><?=$query_string.$param?>';">수정</button>
										<span class="ml5 mr5">|</span>
										<button type="button" class="plain" onclick="javascript:location.href='<?=cdir()?>/dh_board/views/<?=$lt->idx?><?=$query_string.$param?>';">삭제</button>
									</p><!-- END 수정/삭제 -->
									<?}?>

									<? if($lt->coment_cnt) {?>
									<!-- 작성된 코멘트가 있을 경우 -->
									<ul class="shop-board-cmt">
										<li>
											<div class="name">
												<em><?=$lt->coment_name?></em>
												<span class="date"><?=$lt->coment_reg_date?></span>
											</div>
											<div class="txt">
												<?=nl2br($lt->coment)?>
											</div>
										</li>
									</ul><!-- END 관리자가 작성된 코멘트가 있을 경우 -->
									<?}?>
								</td>
							</tr>
						
						<?
						$totalCnt--;
						}?>
					</tbody>
				</table>
				
					<?if($listuse){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$PageAjax?>
					</div><!-- END Pager -->
					<?}?>

				</div><!-- END Board wrap -->