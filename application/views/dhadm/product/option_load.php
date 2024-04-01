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
	<div class="skin-indigo adm-wrap pd20">
		<h3>옵션 불러오기</h3>
		
		<!-- 제품 옵션 설정 테이블 -->
		<table class="adm-table v-line mt15">
			<caption>제품 옵션 선택을 위한 테이블</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>옵션명</th>
					<td>
						<select name="option_code" id="option_code" onchange="javascrip:location.href='?ajax=1&load=<?=$load?>&option_code='+this.value;">
							<option value="">옵션을 선택하세요.</option>
							<? foreach($list as $lt){?>
							<option value="<?=$lt->code?>" <?if($this->input->get("option_code")==$lt->code){?>selected<?}?>><?=$lt->title?> (<?=$lt->code?>)</option>
							<?}?>
						</select>
					</td>
				</tr>
				<tr>
					<th>옵션코드</th>
					<td>
						<? if($this->input->get("option_code")){?>
						<?=$this->input->get("option_code")?>
						<?}else{?>
						<span class="ft-s">옵션을 선택하세요.</span>
						<?}?>
					</td>
				</tr>
				<tr>
					<th>옵션항목</th>
					<td>
						<div class="opt-setting-box">
							<? if($this->input->get("option_code")){ ?>
							<ul class="opt-setting">							
							<? foreach($option_list as $ot){?>
								<li><?=$ot->name?></li>
							<? } ?>
							</ul>
							<?}else{?>
							<p class="align-c ft-s pt60">옵션을 선택하세요.</p>
							<?}?>
						</div>
						<p class="mt10 ft-s mb5">* 항목변경은 <a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/option_setting/?ajax=1" target="_blank" class="ft-blue underline">옵션관리</a>에서 가능합니다.</p>
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->

		<p class="align-c mt30">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
			<input type="button" class="btn-l btn-ok" value="확인" onclick="option_select();">
		</p>

		<script>
		
		function option_select()
		{
				if($('#option_code').val()==''){ 
					alert('옵션을 선택해주세요.');
					$('#option_code').focus();
					return;
				}else{ 
					
					$.get("/html/product/option_setting/",
								{ajax : 1, option_code : $('#option_code').val(), load : <?=$load?>, option_sel : 1},
								function(data){ 
									$("#option_title"+<?=$load?>,opener.document).val("<?=$row->title?>");
									$(".option_list"+<?=$load?>,opener.document).html(data);
									$("input[name='option_check<?=$load?>']",opener.document).prop("checked",true);
									window.close();	
								}
						);
		
				}
		}
		
		</script>
	</div>
 </body>
</html>