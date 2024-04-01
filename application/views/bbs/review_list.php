
			<!-- Board wrap -->
			<div class="board-wrap">
				<? if($bbs->bbs_write < 9  && $bbs->bbs_type!=7){ 
					if($bbs->bbs_write == 0 || ($bbs->bbs_write==1 && $this->session->userdata('USERID'))){
				?>
				<div class="list-btns">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>" class="btn-write">글쓰기</a>
				</div><!-- END 글쓰기 -->
				<?}?>
				<?}?>


				<!-- 리뷰 게시판 리스트 -->
				<table class="board-list review-board">
					<thead>
						<tr>
							<th class="col-num">No.</th>
							<th class="col-df">제품</th>
							<th>제목</th>
							<th class="col-writer">작성자</th>
							<th class="col-date">날짜</th>
							<th class="col-df">평점</th>
							<th class="col-view">조회</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($notice_list as $nl){ ?>
						<tr class="list-notice">
							<td><img src="/image/board_img/speaker.png" alt="NOTICE"></td>
							<td>-</td>
							<td class="list-tit"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>"><?=$nl->subject?></a></td>
							<td><?=$nl->name?></td>
							<td><?=strDateCut($nl->reg_date,3)?></td>
							<td>-</td>
							<td><?=$nl->read_cnt?></td>
						</tr>
						<? } ?>
						<? 
						$listuse=1;
						if($totalCnt == 0){ 
						$listuse=0;
						?>
						<tr>
							<td colspan="7" class="no-ct">
								<p>등록된 게시물이 없습니다.</p>
							</td>
						</tr>
						<?}?>
						<? 
						foreach ($list as $lt){
							if($bbs->new_check) {
								$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/image/board_img/icon_new.gif" alt="NEW">' );
							}
						?>
						<tr>
							<td><?=$totalCnt?></td>
							<td><a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?cate_no=<?=$lt->cate_no?>"><img src="/_data/file/goodsImages/<?=$lt->goods_img?>" alt="@<?=$lt->goods_name?>" title="@<?=$lt->goods_name?>" width="60" height="60"></a></td>
							<td class="list-tit">
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$lt->idx?><?=$query_string.$param?>"><span class="review-list-prod">[<?=$lt->goods_name?>]</span><br>
								<? if($lt->secret=="y"){ ?><img src="/image/board_img/icon_lock.gif" alt="비밀글"><? } ?>
								<?=$lt->subject?></a> <?=$new_img?>
								<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
							</td>
							<td><?=$lt->name?></td>
							<td><?=strDateCut($lt->reg_date,3)?></td>
							<td><span class="review-star" data-grade="<?=$lt->grade?>"><?=$lt->grade?>점</span></td>
							<td><?=$lt->read_cnt?></td>
						</tr>
						<? 
							$totalCnt--;
							} 
						?>
					</tbody>
				</table><!-- END 리뷰 게시판 리스트 -->
				

					<?if($listuse){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$Page2?>
					</div><!-- END Pager -->
					<?}?>


				<!-- 검색 -->
				<form action="" name="bbs_search_form" method="get" action="<?cdir()?>/<?=$this->uri->segment(1)?>/lists/<?=$bbs->code?>/"  onSubmit="return false;">
				<div class="board-search">
					<select name="search_item" class="board-search-select">
						<option value="all">전체</option>
						<option value="subject">제목</option>
						<option value="name">작성자</option>
						<option value="content">내용</option>
					</select>
					<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
				</form>
				<!-- END 검색 -->




			</div><!-- END Board wrap -->