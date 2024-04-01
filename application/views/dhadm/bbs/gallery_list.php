<?
if($this->input->get('cate_idx')){
	$send = "?cate_idx=".$this->input->get('cate_idx');
}else{
	$send = "";
}

$param="";
if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>

<div class="board-wrap">
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
				<table class="adm-table mb50">
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

<table width="100%" border="0" cellspacing="0" cellpadding="3" class="gallery_board" bordercolor='#dddddd' style="table-layout:fixed;">
	<tr>
	<form name="order_form" method="post" >
		<?
			$list_cnt=0;
			$new_tr = 0;
			$new_td =0;
			$td_width = $bbs->list_width ; // 가로리스트 수

			foreach ($list as $lt){
				$list_cnt++;
		?>
			<td width="<? $width_td = 100/$bbs->list_width; echo($width_td."%");?>" align="center" valign="top" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:8px;margin-right:8px;">
				<tr>
					<td align="center">
					<table border="0" cellpadding="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/view/<?=$lt->idx?>/<?=$query_string.$param?>"><img src="<? if($lt->bbs_file=='none' || $lt->bbs_file==''){ ?><? }else{ ?>/_data/file/bbsData/<?=$lt->bbs_file?><?}?>" border="0" style="width:100%;"></a></td></tr></table></td>
						</tr>
						<tr>
							<td align="center" class="menu" height="25"><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"> &nbsp;<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject;?></a></td>
						</tr>
					</table>
					</td>
		<? if (($list_cnt % $td_width) == 0) { $new_tr++;?>
				</tr>
				<tr>
					<td height="10" colspan="<?=$bbs->list_width;?>"></td>
				</tr>
				<tr>
			<?}
			}?>
			<?
				$new_td = $td_width - ($list_cnt%$td_width);
				for($i=0; $i<$new_td; $i++) {
					if( $list_cnt != $td_width * $new_tr) {?>
				<td width="<? $width_td = 100/$bbs->list_width; echo($width_td."%");?>" align="center">&nbsp;</td>
			<?
					}
				}
			?>
			<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
			</form>
		</tr>
</table>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
					<span class="btn-inline btn-tinted-02"><a href="javascript:all_del();">삭제</a></span>
<!-- 					<span class="btn-inline btn-tinted-03" <? if($bbs->bbs_cate=='Y' && !$this->input->get("cate_idx")){?>style="display:none;"<?}?> ><a href='javascript:openWinPopup("<?=cdir()?>/board/bbs_sort/?ajax=1&code=<?=$bbs->code?>&cate_idx=<?=$this->input->get("cate_idx")?>","",340,400);'>순서변경</a></span> -->
					</div>
					<div class="float-r">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/write" class="button btn-ok">글쓰기</a></span>
					</div>
				</div>


					<? if($total_cnt > 0){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
					<?}?>
</div><!--END Board-->