<?
	$subject = $this->input->get('subject');
	$prd = $this->input->get('prd');
	$cate_no1 = $this->input->get('cate_no1');
	$cate_no2 = $this->input->get('cate_no2');
	$cate_no3 = $this->input->get('cate_no3');
	$cate_no4 = $this->input->get('cate_no4');
	$goods_idx = $this->input->get('goods_idx');

	$prd_arr = explode(",",$prd);

		$num="";
	if($code=="teacher"){
		$num="2";
	}
	$cnt=0;
?>

<!doctype html>
<html lang="ko">
 <head>
  <title>컨텐츠 불러오기</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>

	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">

	<?if($this->uri->segment(3) =="safeguard"){//개인정보처리방침?>

        <form name="copy_form" method="post">

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col style="5%;"><col style=""><col style="20%;">
					</colgroup>
					<thead>
						<tr>
							<th colspan="2">개인정보처리방침 시행일자</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$cnt=0;
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($safeguard_list as $lt){
							$cnt++;
						?>
						<tr>
							<td class="align-l"><?=$lt->subject?></td>
						</tr>

						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 내용이 없습니다.</td>
						</tr>
						<?}
						?>
						  <input type="hidden" name="param" value="<?=$prd?>">
              <input type="hidden" name="idx" value="<?=$lt->idx?>">

					</tbody>
				</table>
				</form>

			 <? /*
				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col style="5%;"><col style=""><col style="20%;">
					</colgroup>
					<thead>
						<tr>
							<!-- <th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th> -->
							<th colspan="2">제목</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$cnt=0;
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){
							$cnt++;
						?>
						<!-- <tr class="sel<?=$cnt?> <? if(in_array($lt->idx,$prd_arr)){?>selected<?}?>"> -->
						<!-- 	<td><input type="checkbox" name="check<?=$cnt?>" id="check<?=$cnt?>" value="<?=$lt->idx?>" cnt="<?=$cnt?>" prd_name="<?=$lt->subject?>" class="sel" <? if(in_array($lt->idx,$prd_arr)){?>checked<?}?>></td> -->
						<tr>
							<td><input type="radio" name ="radio" id="radio" value="<?=$lt->idx?>"></td>
							<td class="align-l"><?=$lt->subject?></td>
							<td><?=substr($lt->reg_date,0,10)?></td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 내용이 없습니다.</td>
						</tr>
						<?}
						?>

					</tbody>
				</table>
				*/ ?>

	<? }else { //그외?>
		<h3>컨텐츠 연동하기</h3>
				<!-- 제품검색 -->

				<form name="search_form">
				<input type="hidden" name="ajax" value="1">
				<input type="hidden" name="prd" value="<?=$prd?>">
				<input type="hidden" name="code" value="<?=$code?>">
				<table class="adm-table">
					<caption>제품 검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>카테고리</th>
							<td>
								<select id="cate_no1" name="cate_no1" onchange="cate_chg(2,this.value)">
										<option value="">1차 카테고리</option>
										<? foreach($cate_list as $cate1){ ?>
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

									<input type="button" class="search" value="검색" onclick="document.search_form.submit();">
							</td>
						</tr>
						<tr>
							<th>초기화</th>
							<td><input type="button" value="초기화" class="btn-clear" onclick="javascript:location.href='<?=cdir()?>/board/best_prd/<?=$code?>?ajax=1&prd=<?=$prd?>';">
							</td>
						</tr>
					</table>
				</form>



				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 컨텐츠 <strong><?=$totalCnt?>개</strong></h3>
					<p class="float-r">
						<input type="button" value="확인" class="btn-ok" onclick="select_product();">
					</p>
				</div>

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col style="width:100px;"><col style=""><col style="width:90px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th colspan="2">제목</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$cnt=0;
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){
							$cnt++;
						?>
						<tr class="sel<?=$cnt?> <? if(in_array($lt->idx,$prd_arr)){?>selected<?}?>">
							<td><input type="checkbox" name="check<?=$cnt?>" id="check<?=$cnt?>" value="<?=$lt->idx?>" cnt="<?=$cnt?>" prd_name="<?=$lt->subject?>" class="sel" <? if(in_array($lt->idx,$prd_arr)){?>checked<?}?>></td>
							<td class="pr0" onclick="sel(<?=$cnt?>)"><img src="<? if($lt->bbs_file){?>/_data/file/bbsData/<?=$lt->bbs_file?><?}else{?>/_dhadm/image/common/thumb.jpg<?}?>" alt="" width="70" height="60" class="block"></td>
							<td class="align-l" onclick="sel(<?=$cnt?>)"><?=$lt->subject?></td>
							<td onclick="sel(<?=$cnt?>)"><?=substr($lt->reg_date,0,10)?></td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 내용이 없습니다.</td>
						</tr>
						<?}
						?>

					</tbody>
				</table>
	<? } ?>
				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt30">
					<div class="align-c">
						<!-- <input type="button" value="확인" class="btn-ok" onclick="select_product();"> -->
					</div>
				</div><!-- END 제품 액션 버튼 -->


				<div class="select_bar"></div>
				<?if($this->uri->segment(3)=="safeguard"){?>
				<button class="sel_btn" onclick="copy_safeguard();">복사</button>
				<?}else{?>
				<button class="sel_btn" onclick="select_product();">확인</button>
				<?}?>


	</div>

<script>

	<? if($cate_no1){ ?>
		cate_chg(2, "<?=$cate_no1?>");
	<?}?>

	<? if($cate_no2){ ?>
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


	$(".sel").change(function(){

		if(this.checked){
			var num = $(this).attr("cnt");
			$(".sel"+num).addClass("selected");
		}else{
			var num = $(this).attr("cnt");
			$(".sel"+num).removeClass("selected");
		}

	});

	$("#allcheck1").change(function(){

		if(this.checked){
			$(".adm-table .ft092 tr").addClass("selected");
			$(".sel").prop("checked",true);
		}else{
			$(".adm-table .ft092 tr").removeClass("selected");
			$(".sel").prop("checked",false);
		}

	});


	function sel(num)
	{
		if($("input[name='check"+num+"']:checked").length==0){
			$(".sel"+num).addClass("selected");
			$("input[name='check"+num+"']").prop("checked",true);
		}else{
			$(".sel"+num).removeClass("selected");
			$("input[name='check"+num+"']").prop("checked",false);
		}
	}

	function select_product()
	{
		var num = "<?=$this->uri->segment(4)?>";
		var cnt = <?=$cnt?>;
		var t_cnt = 0;
		var txt = "";
		var prd_name = "";

		$("#prd_name"+num+" option",opener.document).remove();

		for(i=1;i<=cnt;i++){
			if($('input[name="check'+i+'"]').is(":checked") == true){
				t_cnt++;
				txt += $("#check"+i).val() + ",";
				prd_name = $("#check"+i).attr("prd_name");
				$("#prd_name"+num,opener.document).append("<option value='"+$("#check"+i).val()+"@@"+prd_name+"'>"+prd_name+"</option>");
				/*if(i != cnt){
					prd_name += "\n";
				}*/
			}
		}

		if(txt==""){
			alert("등록할 컨텐츠를 선택해주세요.");
			return;
		}else{

			if(t_cnt < 2){
				t_cnt = 30;
			}else{
				t_cnt = t_cnt * 19;
			}

			//$("#prd_name"+num,opener.document).val(prd_name);
			$("#prd_name"+num,opener.document).attr("style","width:60%;height:"+t_cnt+"px");
			$("#best_prd"+num,opener.document).val(txt);
			window.close();
		}
	}




	function prod_select(cate_no,sel_no)
	{
			if(cate_no){
				$.ajax({
					url: "<?=cdir()?>/product/goods_list_load",
					data: {ajax : "1", cate_no: cate_no, sel_idx: sel_no},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						$("#goods_idx").html(data);
						$("#goods_idx").show();
					}
				});
			}else{
				$("#goods_idx").hide();
			}

			if(sel_no){
				$(".schBtn").show();
			}else{
				$(".schBtn").hide();
			}

	}
		<? if($this->input->get("goods_idx")){?>
		prod_select("<?=$cate_no1?>",'<?=$this->input->get("goods_idx")?>');
	<?}?>


	function winFun(txt,prd_name,t_cnt)
	{
		alert(prd_name);
		alert(txt);
		alert(t_cnt);

			window.close();
	}

	function copy_safeguard(param,idx)
	{
		if(confirm('복사를 하겠습니까?')){
			document.copy_form.submit();
		}
	}


	</script>

<form name="wincloseFrm">
<input type="hidden" name="best_prd" value="">
<input type="hidden" name="best_prd_name" value="">
</form>
 </body>
</html>
