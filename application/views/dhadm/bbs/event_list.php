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
					<caption>게시판 목록</caption>
					<colgroup>
						<col><col><col style="width:70px;"><col style="width:250px;"><col><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th colspan="2">제목</th>
							<th>기간</th>
							<th>상태</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="ft092">
					<form name="order_form" method="post" >
					<?
						$today = date("Y-m-d");
						$list_cnt=0;
						foreach ($list as $lt){
							$list_cnt++;
					?>
						<tr>
							<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
							<td><?=$listNo?></td>
							<td class="pr0"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/view/<?=$lt->idx?>/<?=$query_string.$param?>"><img src="<? if($lt->bbs_file){ ?>/_data/file/bbsData/<?=$lt->bbs_file?><? }else{ ?>/_dhadm/image/common/thumb.jpg<?}?>" alt="" width="95" height="60" class="block"></a></td>
							<td class="align-l"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a></td>
							<td><?=$lt->start_date?> ~ <?=$lt->end_date?></td>
							<td><? if(strtotime($today) > strtotime($lt->end_date)){ echo "<span class='dh_red'>마감</span>"; }else{ echo "<span class='dh_blue'>진행중</span>"; } ?></td>
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
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//write/<?=$send?>" class="button btn-ok">등록하기</a></span>
					</div>
				</div>


					<? if($total_cnt > 0){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
					<?}?>


