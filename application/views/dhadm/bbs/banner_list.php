<? 
if($this->input->get('cate_idx')){
	$send = "?cate_idx=".$this->input->get('cate_idx');
}else{
	$send = "";
}

$param="";
if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>	


				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form action="" name="bbs_search_form" method="get" action="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//bbs_list/<?=$bbs->code?>/">
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
									<option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>질문</option>
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

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="cate_table">
<? if($bbs->bbs_cate=='Y'){ ?>
	<tr>
		<td height="30">
			·<a href="<?=self_url()?>" <? if(!$this->input->get('cate_idx')){?>class="on"<?}?>>전체<!-- (<?=$cate_total_cnt?>) --></a> &nbsp; 
			<? 
			foreach($cate_list as $c_list){ 
				foreach($cate_cnt as $c_cnt){
					if($c_cnt->cate_idx == $c_list->idx){
						$cnt = $c_cnt->cnt;
					}
				}
			?>
			·<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/?cate_idx=<?=$c_list->idx?>" <? if($this->input->get('cate_idx') == $c_list->idx){?>class="on"<?}?>><?=$c_list->name?><!-- (<? echo isset($cnt) ? $cnt : 0;?>) --></a>&nbsp;
			<?}?>

			&nbsp;
			<? echo "<a href='#' onClick=\"javascript:window.open('".cdir()."/dhadm/category/".$bbs->code."','','width=470,height=450,scrollbars=yes');\"><font style='font-size:8pt;letter-spacing:-1'>[카테고리관리]</font></a>"; ?>
			
		</td>
	</tr>
<?}?>

</table>


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
							<th>타이틀</th>
							<th>날짜</th>
						</tr>
					</thead>
					<tbody class="ft092">
			

			<form name="order_form" method="post" >
			<? 
				$list_cnt=0;
				foreach ($list as $lt){ 
					$list_cnt++;
			?>
				<tr <? if($lt->re_level > 0){?>class="reply"<?}?>>
					<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
					<td><?=$listNo?></td>
					<td>
						<a href="<?=cdir()?>/board/bbs/<?=$lt->code?>/m/edit/<?=$lt->idx?>/<?=$query_string.$param?>">
						<img src="/_data/file/bbsData/<?=$lt->bbs_file?>" width="200px" height="50px">		&nbsp;						
						<?=$lt->subject?></a>		
					</td>
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