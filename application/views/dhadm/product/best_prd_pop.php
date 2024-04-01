<?
			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
			$cate_no3 = $this->input->get('cate_no3');
			$cate_no4 = $this->input->get('cate_no4');
			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$prd = $this->input->get('prd');

			$prd_arr = explode(",",$prd);
?>
<!doctype html> 
<html lang="ko">
 <head>
  <title>옵션 불러오기</title>
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
	<script>
	$(function(){
		$(".sel").on("click",function(){
			var checkObj = $(this);
			
       if(checkObj.is(":checked") == true){
				$(".sel"+checkObj.val()).addClass("selected");
       }else{
				$(".sel"+checkObj.val()).removeClass("selected");
       }

		});

     $("#allcheck1").change(function(){

     var checkObj = $('.sel');

          if(this.checked){
            checkObj.prop("checked",true);
						$(".ft092 tr").addClass("selected");
          }else{
            checkObj.prop("checked",false);
						$(".ft092 tr").removeClass("selected");
          }
     });
	});
	

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
					url: "/html/product/write",
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
	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">

		<h3>제품 연동하기</h3>

				<!-- 제품검색 -->
				<form name="search_form">
				<input type="hidden" name="cate_no" value="">
				<input type="hidden" name="ajax" value="1">
				<input type="hidden" name="prd" value="<?=$prd?>">
				<table class="adm-table">
					<caption>제품 검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>						
						<tr>
							<th>제품분류</th>
							<td>
									<select id="cate_no1" name="cate_no1" onchange="cate_chg(2,this.value)" style="width:110px;">
										<option value="">1차 카테고리</option>
										<? foreach($cate_list as $cate1){ ?>
										<option value="<?=$cate1->cate_no?>" <? if(isset($cate_no1) && $cate_no1==$cate1->cate_no){?>selected<?}?>><?=$cate1->title?></option>
										<?}?>
									</select>
									<select id="cate_no2" name="cate_no2" onchange="cate_chg(3,this.value)" style="display:none;width:110px;">
										<option value="">2차 카테고리</option>
									</select>
									<select id="cate_no3" name="cate_no3" onchange="cate_chg(4,this.value)" style="display:none;width:110px;">
										<option value="">3차 카테고리</option>
									</select>
									<select id="cate_no4" name="cate_no4" onchange="cate_chg(5,this.value)" style="display:none;width:110px;">
										<option value="">4차 카테고리</option>
									</select>
							</td>
						</tr>					
						<tr>
							<th>제품검색</th>
							<td>
								<input type="text" name="name" placeholder="제품명으로 검색" class="width-m" value="<?=$name?>">
								<input type="text" name="code" placeholder="코드명으로 검색" class="width-m" value="<?=$code?>">
								<input type="button" value="검색" class="btn-ok"  onclick="javascript:document.search_form.submit();">
								<input type="button" value="초기화" class="btn-clear"  onclick="javascript:document.location.href='<?=cdir()?>/product/best_prd/?ajax=1'">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>


				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 제품 <strong><?=$totalCnt?>개</strong></h3>
				</div>

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col style="width:100px;"><col style=""><col style=""><col style="width:100px;"><col style="width:100px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>가격</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							$cnt=0;
							foreach ($list as $lt){ 
							$cnt++;
						?>
						<tr class="sel<?=$lt->idx?> <? if(in_array($lt->idx,$prd_arr)){?>selected<?}?>">
							<td><input type="checkbox" name="check<?=$cnt?>" id="check<?=$cnt?>" value="<?=$lt->idx?>" prd_name="<?=$lt->name?>" class="sel" <? if(in_array($lt->idx,$prd_arr)){?>checked<?}?>></td>
							<td><?=$lt->code?></td>
							<td class="pr0"><img src="<? if($lt->list_img){?>/_data/file/goodsImages/<?=$lt->list_img?><?}else{?>/_dhadm/image/common/thumb.jpg<?}?>" alt="" width="70" height="60" class="block"></td>
							<td class="align-l"><?=$lt->name?></td>
							<td><?=number_format($lt->shop_price)?>원</td>
							<td><?=substr($lt->register,0,10)?></td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 내용이 없습니다.</td>
						</tr>
						<?}?>

					</tbody>
				</table>

				<div class="select_bar"></div>
				<button class="sel_btn" onclick="select_product();">확인</button>

	</div>

<script>
	

	function sel(depth, cate_no)
	{
		$("#cate_no"+depth).val(cate_no).attr("selected", "selected");
	}

	function select_product()
	{
		var num = "<?=$this->uri->segment(3)?>";
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
			alert("등록할 제품을 선택해주세요.");
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
	
	</script>
 
 </body>
</html>
