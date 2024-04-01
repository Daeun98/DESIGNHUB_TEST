
				<div class="float-wrap mb20">
					<h4 class="float-l tab-tit">Q&amp;A <small>(<?=$totalCnt?>)</small></h4>
					<span class="float-r"><a href="javascript:;" onclick="<? if( $bbs->bbs_write < 9 && !$this->session->userdata('USERID') ) { ?>go_login('<?=cdir()?>/dh_product/prod_view/<?=$this->input->get("goods_idx")?>')<?}else{?>board_write('<?=$bbs->code?>','<?=$this->input->get("goods_idx")?>')<?}?>" class="btn-write">글쓰기</a></span>
				</div>

				
<?
$total_cnt = $totalCnt;
$write="";

if($bbs->bbs_write==0){
	$write = 1;
}else if($bbs->bbs_write==1 && $this->session->userdata('USERID')){
	if($bbs->write_level==0){ //전체권한
		$write=1;
	}else if($this->session->userdata('LEVEL') >= $bbs->write_level){
		$write=1;
	}

}
?>
			<!-- Board wrap -->
			<div class="board-wrap">
<!-- 리뷰 게시판 리스트 -->
					<table class="shop-board board-list review-board">
						<thead>
							<tr>
								<th class="col-num">No.</th>
								<?if($bbs->bbs_cate=="Y"){?>
								<th class="col-df">문의유형</th>
								<?}?>
								<th>제목</th>
								<th class="col-writer">작성자</th>
								<th class="col-date">날짜</th>
								<th class="col-re">답변여부</th>
							</tr>
						</thead>
						<tbody>
						<? foreach ($notice_list as $nl){ ?>
						<tr class="list-notice">
							<td><img src="/image/board_img/speaker.png" alt="NOTICE"></td>
							<?if($bbs->bbs_cate=="Y"){?>
							<td class="qna-list-type">공지</td>
							<?}?>
							<td class="list-tit"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>"><?=$nl->subject?></a></td>
							<td><?=$nl->name?></td>
							<td><?=strDateCut($nl->reg_date,3)?></td>
							<td>-</td>
						</tr>
						<? } ?>
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
							if($bbs->new_check) {
								$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/image/board_img/icon_new.gif" alt="NEW">' );
							}
							$file_img="";
							if($bbs->bbs_pds && $lt->bbs_file!="none" && $lt->bbs_file){
								$file_img = '<img src="/image/board_img/icon_file.gif" alt="첨부파일">';
							}				
						?>
							<tr>
								<td><?=$totalCnt?></td>
								<td class="qna-list-type">[<?=$lt->cate_name?>]</td>
								<td class="list-tit">									
									<? if( ($this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){?>
									<a href="javascript:view_on(<?=$lt->idx?>)">
									<? }else if($lt->secret=="y"){ ?>
									<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_view/<?=$lt->idx?><?=$query_string.$param?>">
									<?}?>
									<? if($lt->secret=="y"){ ?><img src="/image/board_img/icon_lock.gif" alt="비밀글"><? } ?>
									<?=$lt->subject?></a> <?=$file_img?><?=$new_img?>
								</td>
								<td><?=$lt->name?></td>
								<td><?=strDateCut($lt->reg_date,3)?></td>
								<td><? if($lt->coment_cnt) {?><em class="list-re-ok">답변완료</em><?}else{?><em class="list-re">답변대기중</em><?}?></td>
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
							} 
						?>
						</tbody>
					</table><!-- END 리뷰 게시판 리스트 -->
				

					<?if($listuse){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$PageAjax?>
					</div><!-- END Pager -->
					<?}?>


				</div><!-- END Board wrap -->