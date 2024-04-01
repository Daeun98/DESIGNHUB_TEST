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
						<!-- 글쓰기 -->
						<div class="list-btns">
							<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>" class="btn-write">글쓰기</a>
						</div><!-- END 글쓰기 -->
					<?}?>
					<?}?>


					<ul class="board-list">
						<li class="head">
							<p class="num">번호</p>
							<p class="tit">제목</p>
							<div class="list-info">
								<p class="writer">작성자</p>
								<p class="date">작성일</p>
								<p class="view">조회</p>
							</div>
						</li>
						<? foreach ($notice_list as $nl){ ?>
						<li class="notice" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>';">
							<p class="num"><img src="/image/board_img/notice.png" alt="공지" width="16" height="16"></p>
							<p class="tit"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>"><?=$nl->subject?></a></p>
							<div class="list-info">
								<p class="writer"><?=$nl->name?></p>
								<p class="date"><?=strDateCut($nl->reg_date,3)?></p>
								<p class="view"><?=$nl->read_cnt?></p>
							</div>
						</li>
						<?}?>
						<? if($totalCnt==0){?>
						<li class="no-ct">등록된 게시글이 없습니다.</li>
						<?}else{
						
							foreach ($list as $lt){
							if($bbs->new_check) {
								$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/image/board_img/new.png" alt="NEW">' );
							}
							$file_img="";
							if($bbs->bbs_pds && $lt->bbs_file!="none" && $lt->bbs_file){
								$file_img = '<img src="/image/board_img/file.png" alt="첨부파일">';
							}

							$url = "";

							if( ($this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){
								$url = cdir()."/dh_board/views/".$lt->idx.$query_string.$param;
							}else if($lt->secret=="y"){
								$url = cdir()."/dh_board/passwd/bbs_view/".$lt->idx.$query_string.$param;
							}

						?>
						<li onclick="location.href='<?=$url?>';">
							<p class="num"><?=$listNo?></p>
							<p class="tit"><a href="<?=$url?>">
							<? if($lt->secret=="y"){ ?><img src="/image/board_img/lock.png" alt="비밀글"><? } ?>
							<?=$lt->subject?>
							<?=$file_img?><?=$new_img?>
							<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
							</a></p>
							<div class="list-info">
								<p class="writer"><?=$lt->name?></p>
								<p class="date"><?=strDateCut($lt->reg_date,3)?></p>
								<p class="view"><?=$lt->read_cnt?></p>
							</div>
						</li>
						<? 
							$listNo--;
							}
						}
						?>
					</ul>


					<? if($totalCnt > 0){?>
					<!-- 페이징 -->
					<div class="board-pager">
						<?=$Page2?>
					</div>
					<!-- END 페이징 -->
					<?}?>

					<!-- 검색 -->
					<form action="" name="bbs_search_form" method="get" onSubmit="return false;">
					<div class="board-search">
						<select name="search_item" class="board-search-select">
							<option value="all">전체</option>
							<option value="subject" <?if($this->input->get('search_item')=="subject"){?>selected<?}?>>제목</option>
							<option value="name" <?if($this->input->get('search_item')=="name"){?>selected<?}?>>작성자</option>
							<option value="content" <?if($this->input->get('search_item')=="content"){?>selected<?}?>>내용</option>
						</select>
						<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
						<input type="button" value="검색" class="btn-normal-s board-search-btn" onclick="javascript:search();">
					</div>
					</form>
					<!-- END 검색 -->
				</div><!-- END Board wrap -->