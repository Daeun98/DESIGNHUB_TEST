
<!doctype html> 
<html lang="ko">
 <head>
  <title>쿠폰 관리</title>
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
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	
	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	h3 em { font-size:12.5px;}
	.adm-table td a { color:#09569c; }
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>쿠폰 관리 <em>( ID : <?=$mem_row->userid?> )</em></h3>


		<h4 class="mt25">· 쿠폰 지급하기</h4>
		
		<form method="post" name="coupon_write" id="coupon_write">
		<input type="hidden" name="search" value="1">
		<table class="adm-table v-line mt15">
			<caption>쿠폰 지급하기</caption>
			<colgroup>
				<col style="width:100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>쿠폰코드</th>
					<td>
						<input type="text" name="code" class="width-l" msg="쿠폰코드를" placeholder="지급할 쿠폰코드를 입력해주세요" value="<?=$this->input->post("code")?>"> <input type="button" class="btn-ok" value="검색" onclick="frmChk('coupon_write');">
						<small class="ml5"><a href="<?=cdir()?>/order/coupon/m" target="_blank">[전체쿠폰보기]</a></small>
					</td>
				</tr>
				<? if($this->input->post("code") && $this->input->post("search")==1){ ?>
				<tr>
					<th>검색결과</th>
					<td>					
					<table class="tmp_list">
						<tbody>
							<? if($codeCnt>0){

								foreach($couponList as $couponRow){
							
								if($couponRow->date_flag==1){
									$max_day = explode(" ",$couponRow->max_day);	
									$max_day_text = explode("+",$max_day[0]);	
								}
							?>
							<tr>
								<td class="align-l pd10" style="font-weight:normal;">
									<strong>&lt; <?=$couponRow->name?> &gt;</strong><br>
									· 쿠폰코드 : <?=$couponRow->code?><br>
									· 쿠폰타입 : <? if($couponRow->type==0){ echo "할인쿠폰"; }else if($couponRow->type==1){ echo "기념일쿠폰"; }else if($couponRow->type==2){ echo "회원가입쿠폰"; }else if($couponRow->type==3){ echo "배송비무료쿠폰"; } ?><br>
									· 이용기한 : 
										<? if($couponRow->date_flag==0){?>
											<?=$couponRow->start_date?>~<?=$couponRow->end_date?>
										<?}else if($couponRow->date_flag==1){?>
											발급일자로부터 <?=$max_day_text[1]?><?if($max_day[1]=="day"){?>일<?}else if($max_day[1]=="month"){?>개월<?}?>
										<?}?>
										<br>
									· 할인 : <?if($couponRow->type==3){?>배송비 전액<?}else{?><?=number_format($couponRow->price)?><? if($couponRow->discount_flag==0){?>원<?}else if($couponRow->discount_flag==1){?>%<?}?><?}?><br>
									· 최초결제금액 : <?=number_format($couponRow->min_price)?>원<br>
									<?if($couponRow->discount_flag==1){?>· 최대할인금액 : <?=number_format($couponRow->max_price)?>원<br><?}?>
									<?if($couponRow->member_use=="1"){?>· 회원등급 : <?=$couponRow->level_name?><br><?}?>
								</td>
								<td class="">
									<input type="button" class="btn-clear ml10 mr10" value="선택하기" onclick="javascript:location.href='<?=cdir()?>/dh_order/couponGive/<?=$couponRow->code?>/<?=$mem_row->userid?>/1';">
								</td>
							</tr>
							<?
							}
							}else{?>
							<tr>
								<td class="align-c pd10" style="font-weight:normal;height:60px;">
									검색된 쿠폰코드가 없습니다.
								</td>
							</tr>
							<?}?>
						</tbody>
					</table>							
					</td>
				</tr>
				<?}?>
			</tbody>
		</table>
		</form>

		<h4 class="mt40">· <?=$mem_row->userid?>의 쿠폰 리스트 <p class="list-adding float-r">Total : <a class="on"><?=number_format($couponCnt)?></a>개</p></h4>

				<table class="adm-table line align-c">
					<caption>쿠폰 사용 내역</caption>
					<colgroup>
						<col style="width:15%;"><col style="width:20%;"><col style="width:10%;"><col style="width:20%;"><col style="width:12%;"><col style="width:5%;">
					</colgroup>
					<thead>
						<tr>
							<th>쿠폰코드</th>
							<th>쿠폰명</th>
							<th>할인</th>
							<th>유효기간</th>
							<th>사용일자</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							foreach ($list as $lt){ 
						?>
						<tr>
							<td><?=$lt->code?></td>
							<td><?=$lt->name?></td>
							<td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
							<td>
								<?=$lt->start_date?>~<?=$lt->end_date?>
							</td>
							<td style="color:red;">
								<? if($lt->trade_code){?><?=substr($lt->use_date,0,10)?><?}?>
							</td>
							<td><? if($lt->trade_code==""){?><input type="button" class="btn-sm btn-alert" value="삭제" onclick="delOk(<?=$lt->idx?>);"><?}?></td>
						</tr>
						<?}?>
					</tbody>
				</table>

		<p class="align-c mt40">
			<input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();">
		</p>
	</div>

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>

 </body>
</html>