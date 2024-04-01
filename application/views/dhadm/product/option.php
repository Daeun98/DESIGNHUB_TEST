<?
		$title = $this->input->get('title');
		$name = $this->input->get('name');
		$code = $this->input->get('code');
?>
	<script>
	$(function(){
		$(".chkNum").on("click",function(){
			var checkObj = $(this);
			
       if(checkObj.is(":checked") == true){
				$(".sel"+checkObj.val()).addClass("selected");
       }else{
				$(".sel"+checkObj.val()).removeClass("selected");
       }

		});

     $("#allcheck1").change(function(){

     var checkObj = $('.chkNum');

          if(this.checked){
             checkObj.prop("checked",true);
						$(".ft092 tr").addClass("selected");
          }else{
             checkObj.prop("checked",false);
						$(".ft092 tr").removeClass("selected");
          }
     });
	});
	
	function enterSearch() {
		if(event.keyCode==13) { 
			document.search_form.submit();
		}
	}
	
	</script>
				<h3 class="icon-search">옵션 검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>옵션 검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>										
						<tr>
							<th>옵션검색</th>
							<td>
								<input type="text" name="code" placeholder="코드명으로 검색" class="width-m" value="<?=$code?>" onKeyDown="enterSearch();">
								<input type="text" name="title" placeholder="옵션명으로 검색" class="width-m" value="<?=$title?>" onKeyDown="enterSearch();">
								<input type="text" name="name" placeholder="항목명으로 검색" class="width-m" value="<?=$name?>" onKeyDown="enterSearch();">
								<input type="button" value="검색" class="btn-ok"  onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>



				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 옵션 <strong><?=number_format($totalCnt)?>개</strong></h3>
					<p class="float-r">
						<input type="button" value="옵션등록" class="btn-ok" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/option_setting/?ajax=1','prod_option',455,595);">
					</p>
				</div>
				
				<!-- 옵션 목록 테이블 -->
				<table class="adm-table line align-c">
					<caption>옵션 목록을 보여주는 테이블</caption>
					<colgroup>
						<col style="width:35px;"><col style="width:55px;"><col style="width:135px;"><col style="width:160px;"><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>옵션코드</th>
							<th>옵션명</th>
							<th>옵션항목</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
					<form name="order_form" method="post" >
						<?
							$list_result = 0;
							$list_cnt=0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){ 
								$list_cnt++;
						?>
						<tr class="sel<?=$lt->code?>">
							<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->code?>" class="chkNum"></td>
							<td><?=$totalCnt?></td>
							<td><?=$lt->code?></td>
							<td><?=$lt->title?></td>
							<td class="align-l"><?=$opNameArr[$list_cnt]?></td>
							<td><input type="button" value="수정" class="btn-sm" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/option_setting/<?=$lt->code?>/?ajax=1','prod_option',455,595);">
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk('<?=$lt->code?>')">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 옵션이 없습니다.</td>
						</tr>
						<?}?>
						<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
						</form>
					</tbody>
				</table><!-- END 옵션 목록 테이블 -->
				
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="javascript:if(confirm('삭제하시겠습니까?')){ all_del(); }">
					</div>
					<div class="float-r">
						<input type="button" value="옵션등록" class="btn-ok" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/option_setting/?ajax=1','prod_option',455,595);">
					</div>
				</div><!-- END 제품 액션 버튼 -->

				<!-- END 제품리스트 -->
			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page2?>
				</p><!-- END Pager -->
			<?}?>
				<!-- END 제품리스트 -->

				
	<script>	

	function sel(depth, cate_no)
	{
		$("#cate_no"+depth).val(cate_no).attr("selected", "selected");
	}

	
</script>

		<form name="delFrm" method="post">
		<input type="hidden" name="del_ok" value="1">
		<input type="hidden" name="del_idx">
		</form>