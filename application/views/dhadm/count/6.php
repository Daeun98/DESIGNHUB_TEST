
				<div class="float-wrap mt50">
				</div>


				<table class="adm-table line align-l" style="border-top:0px;">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style=""><col style="width:14%;">
					</colgroup>
					<thead>
					<tbody class="ft092">
						<? 
						if(count($list)>0){
						foreach ($list as $lt){ 
							$engine="";
							$step="";
							$text="";

							if(stristr($lt->referer,"yahoo")){ $engine="야후에서";}
							elseif(stristr($lt->referer,"www".$_SERVER['HTTP_HOST'])){ $engine="우리홈에서"; }
							elseif(stristr($lt->referer,"naver")){ $engine="네이버에서"; }
							elseif(stristr($lt->referer,"empas")){ $engine="엠파스에서"; }
							elseif(stristr($lt->referer,"nate")){ $engine="네이트에서"; }
							elseif(stristr($lt->referer,"hanaro")){ $engine="하나로에서"; }
							elseif(stristr($lt->referer,"google")){ $engine="구글에서"; }
							elseif(stristr($lt->referer,"empas")){ $engine="엠파스에서"; }
							elseif(stristr($lt->referer,"hanmir")){ $engine="한미르에서" ;}
							elseif(stristr($lt->referer,"daum")){ $engine="다음에서" ;}
							elseif(stristr($lt->referer,"simmani")){ $engine="심마니에서" ;}
							elseif(stristr($lt->referer,"lycos")){ $engine="라이코스에서"; }

							else{ $engine="기타"; }

							if(stristr($lt->referer,"search")){ $step="키워드검색으로"; }
							else if(stristr($lt->referer,"dir")){ $step="카테고리검색으로"; }
							else if(stristr($lt->referer,"mail")){ $step="메일받고"; }
							else if(stristr($lt->referer,"bbs") or stristr($lt->referer,"board") ){ $step="게시판에서"; }

						 if(strlen($lt->referer)>200)
						 {
							$temp=substr($lt->referer,0,200);
							$text=$temp."...";
						 }else{
							$text=$lt->referer;
						 }

						 if(!@preg_match("즐", $lt->referer)) $lt->referer="$engine $step $text";

						?>
						<tr>
							<td><?=$lt->referer?></td>
							<td class="align-c"><font color=#A92B05>접속횟수 : <?=number_format($lt->hit)?></font></td>
						</tr>
						<?
						}
						}else{
						?>
						<tr>
							<td colspan="2" class="align-c">검색된 접속경로가 없습니다.</td>
						</tr>
						<?}?>
					</thead>
				</tbody>
			</table>