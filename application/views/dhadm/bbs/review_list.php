<? 
if($this->input->get('cate_idx')){
	$send = "?cate_idx=".$this->input->get('cate_idx');
}else{
	$send = "";
}
?>
<?
	$cate_no1 = $this->input->get('cate_no1');
	$cate_no2 = $this->input->get('cate_no2');
	$cate_no3 = $this->input->get('cate_no3');
	$cate_no4 = $this->input->get('cate_no4');

?>	

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="cate_table">
<? if($bbs->bbs_cate=='Y'){ ?>
	<tr>
		<td height="30">
			·<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/" <? if(!$this->input->get('cate_idx')){?>class="on"<?}?>>전체(<?=$cate_total_cnt?>)</a> &nbsp; 
			<? 
			foreach($cate_list as $c_list){ 
				foreach($cate_cnt as $c_cnt){
					if($c_cnt->cate_idx == $c_list->idx){
						$cnt = $c_cnt->cnt;
					}
				}
			?>
			·<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/<?=$query_string?>&cate_idx=<?=$c_list->idx?>" <? if($this->input->get('cate_idx') == $c_list->idx){?>class="on"<?}?>><?=$c_list->name?>(<? echo isset($cnt) ? $cnt : 0;?>)</a>&nbsp;
			<?}?>
			
		</td>
	</tr>
<?}?>

</table>

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
							<th>카테고리</th>
							<td>
									<select id="cate_no1" name="cate_no1" onchange="cate_chg(2,this.value)">
										<option value="">1차 카테고리</option>
										<? foreach($product_cate_list as $cate1){ ?>
										<option value="<?=$cate1->cate_no?>" <? if(isset($cate_no1) && $cate_no1==$cate1->cate_no){?>selected<?}?>><?=$cate1->title?></option>
										<?}?>
									</select>
									<select id="cate_no2" name="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;">
										<option value="">2차 카테고리</option>
									</select>
									<select id="cate_no3" name="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;">
										<option value="">3차 카테고리</option>
									</select>
									<select id="cate_no4" name="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;">
										<option value="">4차 카테고리</option>
									</select>
							</td>
						</tr>			
						<tr>
							<th>상세검색</th>
							<td>
								<select name="search_item" id="search-scope">
									<option value="all">전체</option>
									<option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>제목</option>
									<option value="content" <?if($this->input->get("search_item")=="content"){?>selected<?}?>>내용</option>
								</select>
								<input type="text" name="search_order" value="<?=$this->input->get("search_order")?>"/>
								<input type="button" value="검색" class="btn-ok" onclick="javascript:document.bbs_search_form.submit();">
							</td>
						</tr>	
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

				<div class="float-wrap mt70">
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
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a>
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


	<script>
	
	<? if(isset($cate_no2)){ ?>
		cate_chg(2, "<?=$cate_no1?>","<?=$cate_no2?>");
	<?}?>

	<? if(isset($cate_no3)){ ?>
		setTimeout('cate_chg(3, "<?=$cate_no2?>","<?=$cate_no3?>")',50);
	<?}?>
	
	<? if(isset($cate_no4)){ ?>
		setTimeout('cate_chg(4, "<?=$cate_no3?>","<?=$cate_no4?>")',100);
	<?}?>

	function cate_chg(depth, cate_no, sel_no)
	{
			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write",
					data: {ajax : "1", depth : depth, cate_no: cate_no, sel_no: sel_no},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).hide();
							$("#cate_no"+i).val("");
						}
						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no"+depth).show();							
						}
					}	
				});
			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
					$("#cate_no"+i).val("");
				}
				
				$("#cate_depth").val(depth);
			}

	}
	
	</script>