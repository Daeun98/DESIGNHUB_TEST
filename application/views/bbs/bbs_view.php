<? if($this->session->userdata('USERID')){ $USERID = $this->session->userdata('USERID'); }else{ $USERID = ""; } ?>
				
	<script type="text/javascript">
	jQuery(document).ready(function(){
		//댓글 리스트 토글
		$(".cmt-tit").on("click", function(){
			$(".comment-view").toggle();
		});
		//대댓글 작성 토글
		$(".write-cofc").on("click", function(){
			$(this).closest("li").find(".comment-write").toggle();
		});
		//대댓글 리스트 토글
		$(".view-cofc").on("click", function(){
			$(this).closest("li").find(".cmt-of-cmt").toggle();
		});
	});
	</script>


			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board view -->
				<div class="board-view">
					
					<p class="board-view-tit"><?=$row->subject?></p>
					<p class="board-view-info"><?=$row->name?> <span>|</span> <?=substr($row->reg_date,0,10)?> <span>|</span> 조회 <?=$row->read_cnt?></p>
					
					<? if($bbs->bbs_type==7){?>

					<!-- 리뷰 게시판일 경우 -->
					<div class="board-view-prod">
						<span class="rv-prod-img"><a href="<?=cdir()?>/dh_product/prod_view/<?=$row->goods_idx?>?cate_no=<?=$goods_row->cate_no?>"><img src="/_data/file/goodsImages/<?=$goods_row->list_img?>" alt="@제품명 의 썸네일" width="70" height="70"></a></span>
						<div class="rv-prod-info">
							<p class="rv-prod-name"><a href="<?=cdir()?>/dh_product/prod_view/<?=$row->goods_idx?>?cate_no=<?=$goods_row->cate_no?>"><?=$goods_row->name?></a></p>
							<p class="rv-prod-price">
							<?if($goods_row->old_price){?>							
								<ins><?=number_format($goods_row->shop_price)?>원</ins> <del><?=number_format($goods_row->old_price)?>원</del>
							<?}else{?>
								<?=number_format($goods_row->shop_price)?>원
							<?}?>
							</p>
						</div>
					</div>
					<!-- END 리뷰 게시판일 경우 -->

					<?}?>

					<div class="board-view-ct">
						<?=stripslashes($row->content)?>

						<? if($bbs->bbs_pds){ ?> 
						<!-- 첨부 -->
						<ul class="board-view-file">
							<? if($row->bbs_file!="none" && $row->bbs_file!=""){ ?> <li><a href="<?=cdir()?>/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=1"><?=$row->real_file?></a></li><?}?>
							<? if($row->bbs_file2!="none" && $row->bbs_file2!=""){ ?> <li><a href="<?=cdir()?>/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=2"><?=$row->real_file2?></a></li><?}?>
						</ul><!-- END 첨부 -->
						<?}?>
					</div>

				<? if($bbs->bbs_coment == 1){ ?>

					<!-- Comment View -->
					<div class="comment-wrap">
						<p class="cmt-tit">댓글 <span>(<?=$coment_cnt?>)</span></p>

						<!-- <p class="no-ct">작성된 댓글이 없습니다. 제일 먼저 댓글을 작성해 보세요!</p> -->

						<!-- 댓글 리스트 -->
						<ul class="comment-view">
						<? foreach ($coment as $list){ ?>
							<li class="my-cmt">
								<div class="cmt-item">
									<p class="cmt-name"><?=$list->name?></p>
									<p class="cmt-content"><?=nl2br($list->coment)?></p>
									<p class="cmt-date"><?=$list->reg_date?></p>
									<div class="cmt-options">
										<? if($USERID != "" && $USERID == $list->userid){ //작성자와 로그인아이디가 같을때?>
										<button type="button" onclick="javascript:document.del_form.del_idx.value='<?=$list->idx?>';document.del_form.mode.value='bbs_coment';document.del_form.submit();">삭제</button>
										<?}else{?>
										<button type="button" onclick="javascript:location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_coment_del/<?=$row->idx?>/<?=$list->idx?>';">삭제</button>
										<?}?>
									</div>
								</div>
							</li>
							<?}?>
						</ul><!-- END 댓글 리스트 -->

						<!-- 댓글 쓰기 -->
						<form name="bbs_coment_form" method="post">
						<input type="hidden" name="code" value="<?=$row->code?>">
						<input type="hidden" name="userid" value="<? echo isset($USERID) ? $USERID : "";?>">
						<div class="comment-write">
							<div class="cmt-writer-info">
								<span class="cmt-writer"><label for="cmt-writer">작성자</label><input type="text" id="cmt-writer" name="name" value="<? echo (@$this->session->userdata('NAME')) ? @$this->session->userdata('NAME') : "";?>"></span>
								<span class="cmt-pw"><label for="cmt-pw">비밀번호</label><input type="password" id="cmt-pw" name="pwd"></span>
							</div>
							<div class="cmt-field">
								<textarea name="coment" id="cmt-cont" cols="30" rows="3" <? if( $bbs->bbs_write == 1 && !$this->session->userdata('USERID') ) {?>placeholder="로그인 후 댓글을 작성해 주세요." readonly<?}?>></textarea>
								<p class="cmt-field-btn">
									<input type="button" class="btn-border-s" value="등록" onclick="<? if( $bbs->bbs_write == 1 && !$this->session->userdata('USERID') ) {?>alert('로그인 후 댓글을 작성해주세요.');location.href='<?=cdir()?>/dh_member/login/?go_url=<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$row->idx?><?=$query_string.$param?>';<?}else{?>bbs_coment()<?}?>">
								</p>
							</div>
						</div><!-- END 댓글 쓰기 -->
						</form>

					</div><!-- END Comment View -->
					<?}?>

					<!-- 이전/다음 컨텐츠 -->
					<ul class="board-view-nav">
						<li><span class="lb">이전글<img src="/image/board_img/icon_prev.gif" alt=""></span>							
						<? if(isset($preRow->subject)){?>
							<? if($preRow->secret && $preRow->secret=="y"){ 
									if($this->session->userdata('USERID') && $this->session->userdata('USERID') == $preRow->userid){
							?>
								<?echo $preRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/views/".$preRow->idx."'>".$preRow->subject."</a>" : "" ?></a>
							<?
									}else{
								?>
								<?echo $preRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/passwd/bbs_view/".$preRow->idx."'>".$preRow->subject."</a>" : "" ?></a>
								<?}?>
								<img src="/image/board_img/icon_lock.gif" align="middle">
							<?}else{?>
								<?echo $preRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/views/".$preRow->idx."'>".$preRow->subject."</a>" : "" ?></a>
							<?}?>		
						<?}else{?>
						<span class="dh_gray">이전글이 없습니다.</span>
						<?}?>
						</li>
						<li><span class="lb">다음글<img src="/image/board_img/icon_next.gif" alt=""></span>				
						<? if(isset($nextRow->subject)){?>			
							<? if($nextRow->secret && $nextRow->secret=="y"){
									if($this->session->userdata('USERID') && $this->session->userdata('USERID') == $nextRow->userid){
							?>
								<?echo $nextRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/views/".$nextRow->idx."'>".$nextRow->subject."</a>" : "" ?></a>
							<?
									}else{
								?>
								<?echo $nextRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/passwd/bbs_view/".$nextRow->idx."'>".$nextRow->subject."</a>" : "" ?></a>
								<?}?>
							 <img src="/image/board_img/icon_lock.gif" align="middle">
							<?}else{?>
								<?echo $nextRow->subject ? "<a href='".cdir()."/".$this->uri->segment(1)."/views/".$nextRow->idx."'>".$nextRow->subject."</a>" : "" ?></a>
							 <?}?>	
						<?}else{?>
						<span class="dh_gray">다음글이 없습니다.</span>
						<?}?>
						</li>
					</ul>
					<!-- END 이전/다음 컨텐츠 -->
					
					<!-- Buttons -->
					<div class="board-view-btns">
						<!-- <a href="board_list.php" class="btn-normal-s">목록으로</a> -->
						<div class="float-l">
							<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/lists/<?=$row->code?>/<?=$page?><?=$query_string.$param?>" class="btn-normal-s">목록으로</a>
						</div>
						<? if($bbs->bbs_write!=9) {?>
						<div class="float-r">
							<? if($USERID != "" && $USERID == $row->userid){ //작성자와 로그인아이디가 같을때?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/edit/<?=$row->idx?><?=$query_string.$param?>" class="btn-border-s">수정</a>
								<a href="javascript:document.del_form.del_idx.value='<?=$row->idx?>';document.del_form.mode.value='bbs';document.del_form.submit();" class="btn-border-s">삭제</a>							
							<?}else{ //비밀번호 입력폼?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_edit/<?=$row->idx?><?=$query_string.$param?>" class="btn-border-s">수정</a>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_del/<?=$row->idx?><?=$query_string.$param?>" class="btn-border-s">삭제</a>						
							<? } ?>
							<? if($bbs->bbs_type==1){ ?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$row->code?>/<?=$row->idx?>" class="btn-normal-s">답글쓰기</a>
							<?}?>
						</div>
						<?}?>
					</div><!-- END Buttons -->

				</div><!-- END board view -->
				</div><!-- END Board wrap -->
				

		<form name="del_form" method="post">
			<input type="hidden" name="mode">
			<input type="hidden" name="del_idx">
		</form>
