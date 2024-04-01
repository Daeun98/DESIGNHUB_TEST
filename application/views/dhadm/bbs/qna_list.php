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
			·<a href="<?=cdir()?>/board/bbs/<?=$bbs->code?>/m" <? if(!$this->input->get('cate_idx')){?>class="on"<?}?>>전체<!-- (<?=$cate_total_cnt?>) --></a> &nbsp;
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

		<?if($bbs->code=="safeguard_content"){?>
				<div class="float-wrap mb30" style="margin-top:-5px;">
					<input type="button" class="<? if(!$this->input->get('data1')){?>btn-ok<?}else{?>btn-clear<?}?>" value="전체" onclick="javascript:location.href='<?= cdir() ?>/<?= $this->uri->segment(1) ?>/<?= $this->uri->segment(2) ?>/<?= $this->uri->segment(3) ?>';">
					<? foreach($safeguard_cate as $s_list){ ?>
					<input type="button" class='<? if($this->input->get('data1') == $s_list->idx){?>btn-ok<?}else{?>btn-clear<?}?>' value="<?=$s_list->subject?>" onclick="javascript:location.href='<?= cdir() ?>/<?= $this->uri->segment(1) ?>/<?= $this->uri->segment(2) ?>/<?= $this->uri->segment(3) ?>/m/?data1=<?=$s_list->idx?>';">
					<?}?>
				</div>
		<?}?>
</table>

				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
					 <?if($bbs->code=="safeguard_content"){?>
						<col style="width:7%"><col style="width:5%"><col style="width:25%"><col style=""><? if($bbs->bbs_pds){ ?><col style="width:10%;"><?}?><col style="width:10%;">
					 <?} else{ ?>
						<col style="width:7%"><col style="width:5%">><col style=""><? if($bbs->bbs_pds){ ?><col style="width:10%;"><?}?><col style="width:10%;"><col style="width:10%;">
					 <?}?>
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
							<th>No</th>
							<?if($bbs->code=="safeguard_content"){?>
							<th>시행일자</th>
					    <th>제목</th>
							<?} else{ ?>
							<th>질문</th>
							<?}?>
							<th>날짜</th>
						</tr>
					</thead>
					<tbody class="ft092">

			<form name="order_form" method="post">

			<?
				$list_cnt=0;
				foreach ($list as $lt){
					$list_cnt++;
			?>
				<tr <? if($lt->re_level > 0){?>class="reply"<?}?>>
					<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
					<td><?=$listNo?></td>
					<?if($bbs->code=="safeguard_content"){?>
	          <td>
						<? foreach($safeguard_list as $s_list){
						 if($lt->data1 == $s_list->idx){ ?>
					   	<?=$s_list->subject?>
						<? }
			      }
						?>
						</td>
					<?}?>
					<td class="title">
						<? if($lt->secret=="y"){ ?><font style='font-size:8pt;letter-spacing:-1;color:red;'>[BEST]</font><? } ?>
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//view/<?=$lt->idx?>/<?=$query_string?>"><?=$lt->subject?></a>
						<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>

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
					 <?if($bbs->code=="safeguard_content"){?>
				   <button type="button" onclick="openBestPrd('best_prd1','safeguard','board','1');">선택복사</button>
					<?}?>
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

	function openBestPrd(id,code,cont,num)
	{
		// 선택된 게시물이 있는지 여부 ( 없으면 alert )
		// 선택한 게시물 반복문 돌려서 idx 추출
		// 파라미터로 팝업창에 전달

    /*
		if(!$(".chkNum:checked").length){	//체크한게 없을경우
			alert("복사할 게시글을 선택해주세요.");
		}
		*/

   if($(".chkNum:checked").length > 0){	// 선택된 게시물이 있는지 여부 ( 없으면 alert )

		param = '';//파라미터

		$(".chkNum").each(function(e){ //반복문
			if($(this).prop('checked')) param += ","+$(this).val();//체크된 값 파라미터로
		});

		//console.log(param);

		if(code){
			url = code+"/";
		}

		openWinPopup('<?=cdir()?>/'+cont+'/best_prd/'+url+num+'?ajax=1&prd='+param,id,620,650); //팝업창에 파라미터 같이 뜨게


	 }else{
		alert('복사할 게시글을 선택해주세요.');

	 }

	}


 </script>
