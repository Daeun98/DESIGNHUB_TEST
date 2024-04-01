<h3 class="icon-list">목록</h3>

				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<thead>
						<tr>
							<th>번호		</th>
							<th>이름		</th>
							<th>코드		</th>
							<th>타입		</th>
							<th>자료실	</th>
							<th>접근		</th>
							<th>쓰기		</th>
							<th>읽기		</th>
							<th>카테고리</th>
							<th>관리		</th>
						</tr>
					</thead>
					<tbody class="ft092">
		
		<?
			$b_cnt = 0;
			foreach($bbs_row as $bbs){
				$b_cnt++;
				if( $bbs->bbs_type == 1 ) { $type = "답변형"; } else if( $bbs->bbs_type == 2 ) { $type = "공지사항형"; }	else if( $bbs->bbs_type == 3 ) {	$type = "갤러리형"; }else if( $bbs->bbs_type == 4 ) {	$type = "FAQ형"; }else if( $bbs->bbs_type == 5 ) {	$type = "이벤트형"; } else if( $bbs->bbs_type == 6 ) {	$type = "동영상형"; } else if( $bbs->bbs_type == 7 ) {	$type = "상품후기형"; } else if( $bbs->bbs_type == 8 ) {	$type = "온라인폼"; } else if( $bbs->bbs_type == 9 ) {	$type = "배너형"; } else if( $bbs->bbs_type == 10 ) {	$type = "히스토리형";  } //게시판타입
				
				if( $bbs->bbs_pds ) {	$pds_check = "사용"; } else { $pds_check = "미사용"; }	 // 자료실 사용유무				
				if( $bbs->bbs_access == 0 ) { $access_check = "비회원"; }	else if( $bbs->bbs_access == 1 ) { $access_check = "회원"; } // 접근 권한
				if( $bbs->bbs_write == 0 ) {	$write_check = "비회원"; }	else if( $bbs->bbs_write == 1 ) { $write_check = "회원"; }else if( $bbs->bbs_write == 9 ) { $write_check = "관리자"; } // 쓰기 권한
				if( $bbs->bbs_read == 0 ) { $read_check = "비회원"; } else if( $bbs->bbs_read == 1 ) { $read_check = "회원"; } // 읽기 권한
				

		?>
		<tr> 
			<td height="25"><?=$b_cnt?></td>
			<td height="25"><a href="<?=cdir()?>/board/bbs/<?=$bbs->code?>/m"><?=$bbs->name?></a></td>
			<td height="25"><?=$bbs->code?></td>
			<td height="25"><?=$type?></td>
			<td height="25"><?=$pds_check?></td>
			<td height="25"><?=$access_check?></td>
			<td height="25"><?=$write_check?></td>
			<td height="25"><?=$read_check?></td>
			<td>
				<?
					if($bbs->bbs_cate=='Y'){	 
						echo "<a href='#' onClick=\"javascript:window.open('".cdir()."/dhadm/category/".$bbs->code."','','width=470,height=450,scrollbars=yes');\"><font style='font-size:8pt;letter-spacing:-1'>[카테고리관리]</font></a>";
					}else{
						echo "-";
					}
				?>
			</td>
			<td><input type="button" class="btn-sm" value="수정" onclick="javascript:window.location.href='<?=self_url();?>/edit/<?=$bbs->code?>/>';">&nbsp;<input type="button" class="btn-sm btn-alert" value="삭제" onclick="javascript:location.href='<?=self_url();?>/del/<?=$bbs->idx?>/>'"></td>
		</tr>
		<?
			}
		?>
		</table>
				<div class="float-wrap mt20">
					<div class="float-r">
						<a href="<?=self_url();?>/write/" class="button btn-ok">게시판 등록</a></span>
					</div>
				</div>