<?
if($this->input->get('cate_idx')){
	$send = "?cate_idx=".$this->input->get('cate_idx');
}else{
	$send = "";
}
?>

<? if($bbs->bbs_cate=='Y'){ ?>

				<div class="float-wrap mb30" style="margin-top:-5px;">
					<input type="button" class="<? if(!$this->input->get('cate_idx')){?>btn-ok<?}else{?>btn-clear<?}?>" value="전체" onclick="javascript:location.href='?cate_idx=';">
					<? foreach($cate_list as $c_list){ ?>
					<input type="button" class='<? if($this->input->get('cate_idx') == $c_list->idx){?>btn-ok<?}else{?>btn-clear<?}?>' value="<?=$c_list->name?>" onclick="javascript:location.href='?cate_idx=<?=$c_list->idx?>';">
					<?}?>
				</div>

<?}?>


				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="bbs_search_form" method="get" >
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>검색</th>
							<td>
								<select name="search_item" id="search-scope">
									<option value="all">전체</option>
									<option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>제목</option>
									<option value="content" <?if($this->input->get("search_item")=="content"){?>selected<?}?>>내용</option>
								</select>
								<input type="text" name="search_order" value="<?=$this->input->get("search_order")?>"/>
								<input type="button" value="검색" class="btn-ok" onclick="javascript:search();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>


				<div class="float-wrap mt50">
				</div>

				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:7%"><col style="width:5%"><col style=""><? if($bbs->bbs_pds){ ?><col style="width:10%;"><?}?><col style="width:10%;"><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
							<th>No</th>
							<th>제목</th>
							<? if($bbs->bbs_pds){ ?>
							<th>첨부</th>
							<?}?>
							<th>작성자</th>
							<th>날짜</th>
						</tr>
					</thead>
					<tbody class="ft092">

			<? foreach ($notice_list as $nl){ ?>
				<tr>
					<td colspan="2"><img src="/_data/image/board_img/notice.gif" alt="Notice" /> </td>
					<td class="title"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$nl->idx?>/<?=$query_string?>"><strong><?=$nl->subject?></strong></a></td>
					<? if($bbs->bbs_pds){ //첨부파일?>
					<td>
						<? if($nl->bbs_file != "none" && $nl->bbs_file != ""){
							echo '<img src="/_dhadm/image/board_img/file_icon.png" alt="">';
						}?>
					</td>
					<?}?>
					<td><?=$nl->name?></td>
					<td><?=substr($nl->reg_date,0,10)?></td>
				</tr>
			<? } ?>

			<form name="order_form" method="post" >
			<?
				$list_cnt=0;
				foreach ($list as $lt){
					$list_cnt++;
			?>
				<tr <? if($lt->re_level > 0){?>class="reply"<?}?>>
					<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
					<td><?=$listNo?></td>
					<td class="title">
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a>
						<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
						<? if($lt->secret=="y"){ ?> <img src="/_data/image/board_img/icon_lock.gif" align="middle"><? } ?>
					</td>
					<? if($bbs->bbs_pds){ //첨부파일 ?>
					<td>
					<?
						if($lt->bbs_file != "none" && $lt->bbs_file != ""){
							echo '<img src="/_dhadm/image/board_img/file_icon.png" alt="">';
						}
					?>
					</td>
					<?}?>
					<td><?=$lt->name?></td>
					<td><?=substr($lt->reg_date,0,10)?></td>
				</tr>
			<?
				$listNo--;
				}
			?>
				<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
				</form>
			</tbody>
			</table>


				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
					<span class="btn-inline btn-tinted-02"><a href="javascript:all_del();">삭제</a></span>
					<!-- <span class="btn-inline btn-tinted-03" <? if($bbs->bbs_cate=='Y' && !$this->input->get("cate_idx")){?>style="display:none;"<?}?> ><a href='javascript:openWinPopup("<?=cdir()?>/board/bbs_sort/?ajax=1&code=<?=$bbs->code?>&cate_idx=<?=$this->input->get("cate_idx")?>","",340,400);'>순서변경</a></span> -->
					</div>
					<div class="float-r">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//write/<?=$send?>" class="button btn-ok">글쓰기</a></span>
					</div>
				</div>


					<? if($total_cnt > 0){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
					<?}?>




	</div><!--END Board-->