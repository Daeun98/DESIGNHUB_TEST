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

				<? if($bbs->bbs_write < 9  && $bbs->bbs_type!=7){
					if($bbs->bbs_write == 0 || ($bbs->bbs_write==1 && $this->session->userdata('USERID'))){
				?>
				<div class="list-btns">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>" class="btn-write">글쓰기</a>
				</div><!-- END 글쓰기 -->
				<?}?>
				<?}?>


				<!-- 일반 게시판 리스트 -->
				<table class="board-list">
					<thead>
						<tr>
							<th class="col-num">No.</th>
							<?if($bbs->bbs_cate=="Y"){?>
							<th class="col-df">문의유형</th>
							<?}?>
							<th>제목</th>
							<th class="col-writer">작성자</th>
							<th class="col-date">날짜</th>
							<th class="col-re">조회</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($notice_list as $nl){ ?>
						<tr class="list-notice">
							<td><img src="/image/board_img/speaker.png" alt="NOTICE"></td>
							<?if($bbs->bbs_cate=="Y"){?>
							<td class="qna-list-type">-</td>
							<?}?>
							<td class="list-tit"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>"><?=$nl->subject?></a></td>
							<td><?=$nl->name?></td>
							<td><?=strDateCut($nl->reg_date,3)?></td>
							<td><?=$nl->read_cnt?></td>
						</tr>
						<? } ?>
						<?
						$listuse=1;
						if($totalCnt == 0){
						$listuse=0;
						?>
						<tr>
							<td colspan="6" class="no-ct">
								<p>등록된 게시물이 없습니다.</p>
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
							<td><?=$listNo?></td>
							<?if($bbs->bbs_cate=="Y"){?>
							<td class="qna-list-type">[<?=$lt->cate_name?>]</td>
							<?}?>
							<td class="list-tit">
								<? if( ($this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$lt->idx?><?=$query_string.$param?>">
								<? }else if($lt->secret=="y"){ ?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_view/<?=$lt->idx?><?=$query_string.$param?>">
								<?}?>
								<? if($lt->secret=="y"){ ?><img src="/image/board_img/icon_lock.gif" alt="비밀글"><? } ?>
								<?=$lt->subject?></a> <?=$file_img?><?=$new_img?>
								<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
							</td>
							<td><?=$lt->name?></td>
							<td><?=strDateCut($lt->reg_date,3)?></td>
							<td><?=$lt->read_cnt?></td>
						</tr>
						<?
							$listNo--;
							}
						?>
					</tbody>
				</table><!-- END 일반 게시판 리스트 -->


					<?if($listuse){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$Page2?>
					</div><!-- END Pager -->
					<?}?>


				<!-- 검색 -->
				<form action="" name="bbs_search_form" method="get"  onSubmit="return false;">
				<div class="board-search">
					<select name="search_item" class="board-search-select">
						<option value="all">전체</option>
						<option value="subject" <?if($this->input->get('search_item')=="subject"){?>selected<?}?>>제목</option>
						<option value="name" <?if($this->input->get('search_item')=="name"){?>selected<?}?>>작성자</option>
						<option value="content" <?if($this->input->get('search_item')=="content"){?>selected<?}?>>내용</option>
					</select>
					<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
				</form>
				<!-- END 검색 -->
