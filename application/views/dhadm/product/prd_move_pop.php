
<!doctype html> 
<html lang="ko">
 <head>
  <title>제품 <?if($mode=="move"){?>이동<?}else{?>복사<?}?> </title>
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

	<script>
	
	function cate_chg(depth, cate_no)
	{
		var level = depth-1;

		$("#cate_no"+level+" li a").removeClass("on");
		$(".cate"+cate_no).addClass("on");

		if(depth==5){
			$("#cate_no").val(cate_no);
		}else{

			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write/",
					data: {ajax : "1", depth : depth, cate_no: cate_no, de: "2"},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).html("");
						}

						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no").val("");
						}else{
							$("#cate_no").val(cate_no);
						}
					}	
				});
			}else{				
				
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).html("");
				}

				$("#cate_depth").val(depth);
				$("#cate_no").val(cate_no);
			}

		}

			$(".level"+level).html($(".cate"+cate_no).html());
			if(level > 1){ $(".level"+level).prepend(" &gt; "); }

			for(j=4;j>level;j--){
				$(".level"+j).html("");
			}

	}


	function cate_sel()
	{
		var cate_no = $("#cate_no").val();
		if(cate_no){
			opener.document.select_form.sel_cate_no.value=cate_no;
			opener.document.select_form.submit();
			window.close();
		}else{
			alert("카테고리를 선택해주세요.");
			return;
		}
	}
	</script>
 </head>

 <body>


	<div class="skin-indigo adm-wrap pd20" style="min-width:600px;">
		<h3>제품 <?if($mode=="move"){?>이동<?}else{?>복사<?}?>하기</h3>

		<p class="border-box">총 <strong><?=$this->input->get("sel_cnt")?></strong>개의 제품이 선택되었습니다.</p>
		
		<form method="post" name="admin_form" id="admin_form" enctype="multipart/form-data">
		<input type="hidden" name="cate_depth" id="cate_depth" value="1">
		<input type="hidden" name="cate_no" id="cate_no" value="">


		<!-- 카테고리 선택 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품이 <?if($mode=="move"){?>이동<?}else{?>복사<?}?>할 카테고리를 선택하기 위한 테이블</caption>
			<colgroup>
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
			</colgroup>
			<thead>
				<tr>
					<th scope="col">1차 카테고리</th>
					<th scope="col">2차 카테고리</th>
					<th scope="col">3차 카테고리</th>
					<th scope="col">4차 카테고리</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no1">										
								<? foreach($cate_list as $cate1){ ?>
								<li><a href="javascript:cate_chg(2,<?=$cate1->cate_no?>);" class="cate<?=$cate1->cate_no?>"><?=$cate1->title?></a></li>
								<?}?>
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no2">
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no3">
							</ul>
						</div>
					</td>
					<td class="pd0">
						<div class="move-category anchor-toggle-list">
							<ul id="cate_no4">
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table><!-- END 카테고리 선택 테이블 -->

		</form>

		<p class="tint-box pt20 pb20">
			<strong><span class="level1">카테고리를 선택해 주세요</span><span class="level2"></span><span class="level3"></span><span class="level4"></span></strong>
		</p>

		<p class="align-c ft092 mt25">선택한 제품을 위 카테고리로 <?if($mode=="move"){?>이동<?}else{?>복사<?}?>합니다.</p>
		<p class="align-c mt20">
			<input type="button" class="btn-xl btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-xl btn-ok" value="확인" onclick="cate_sel()">
		</p>
	</div>


 </body>
</html>
