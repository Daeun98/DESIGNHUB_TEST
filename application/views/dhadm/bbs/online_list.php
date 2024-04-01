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
									<option value="name" <?if($this->input->get("search_item")=="name"){?>selected<?}?>>작성자</option>
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

<? if($bbs->bbs_cate=='Y'){ ?>

				<div class="float-wrap mb30" style="margin-top:-5px;">
					<input type="button" class="<? if(!$this->input->get('cate_idx')){?>btn-ok<?}else{?>btn-clear<?}?>" value="전체" onclick="javascript:location.href='?cate_idx=';">
					<? foreach($cate_list as $c_list){ ?>
					<input type="button" class='<? if($this->input->get('cate_idx') == $c_list->idx){?>btn-ok<?}else{?>btn-clear<?}?>' value="<?=$c_list->name?>" onclick="javascript:location.href='?cate_idx=<?=$c_list->idx?>';">
					<?}?>
				</div>
<?}?>


				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:7%"><col style="width:5%"><col style="width:15%;"><col style="width:15%;"><col style="width:15%;"><col style="width:15%;"><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
							<th>No</th>
							<th>제목</th>
							<th>작성자</th>
							<th>휴대폰정보</th>
							<th>이메일</th>
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
					<td><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a></td>
					<td><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->name?></a></td>
					<td><?=$lt->data1?></td>
					<td><?=$lt->email?></td>
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
				</div>

					<? if($total_cnt > 0){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
					<?}?>
	</div><!--END Board-->