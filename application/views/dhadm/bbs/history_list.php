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
									<option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>내용</option>
									<option value="year" <?if($this->input->get("search_item")=="year"){?>selected<?}?>>연도</option>
									<option value="month" <?if($this->input->get("search_item")=="month"){?>selected<?}?>>월</option>
								</select>
								<input type="text" name="search_order" value="<?=$this->input->get("search_order")?>"/>
								<input type="button" value="검색" class="btn-ok" onclick="javascript:search();">
							</td>
						</tr>	
					</tbody>
				</table><!-- END 제품검색 -->
				</form>
				<div class="float-wrap mt30">
				</div>

<? if($bbs->bbs_cate=='Y'){ ?>

				<div class="float-wrap mb30" style="margin-top:-5px;">
					<input type="button" class="<? if(!$this->input->get('cate_idx')){?>btn-ok<?}else{?>btn-clear<?}?>" value="전체" onclick="javascript:location.href='?cate_idx=';">
					<? foreach($cate_list as $c_list){ ?>
					<input type="button" class='<? if($this->input->get('cate_idx') == $c_list->idx){?>btn-ok<?}else{?>btn-clear<?}?>' value="<?=$c_list->name?>" onclick="javascript:location.href='?cate_idx=<?=$c_list->idx?>';">
					<?}?>
				</div>
<?}?>

<h3><em style="font-size:12px;">연혁 리스트는 연도,월 순서대로 출력됩니다.</em></h3>


				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:5%"><col style="width:12%"><col style="width:8%"><!-- <col style="width:8%"> --><col style=""><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
							<th>연도</th>
							<th>월</th>
							<!-- <th>일</th> -->
							<th>내용</th>
							<th>등록일자</th>
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
					<!-- <td><?=$total_cnt?></td> -->
					<td><?=$lt->year?></td>
					<td><?=$lt->month?></td>
					<!-- <td><?=$lt->day?></td> -->
					<td class="title"><a href="<?=cdir()?>/board/bbs/<?=$lt->code?>/m/edit/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a></td>
					<td><?=substr($lt->reg_date,0,10)?></td>
				</tr>
			<? 
				$total_cnt--;
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