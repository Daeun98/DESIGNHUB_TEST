	<!-- Board Wrap-->
	<div class="board-wrap">
		<!-- Board View : With Comment -->
		<table class="board-view">
			<caption>게시글의 내용을 보여주는 테이블</caption>
			<colgroup>
				<col style="width:15%;"/>
				<col style=""/>
				<col style="width:10%;"/>
				<col style="width:15%;"/>
				<col style="width:10%;"/>
				<col style="width:15%;"/>
			</colgroup>
			<tbody>
				<?if($bbs->bbs_type==7){?>				
				<tr>
					<th>구매제품</th>
					<td colspan="3"><img src="/_data/file/goodsImages/<?=$goods_row->list_img?>" width="60" height="60" class="mr10"><?=$goods_row->name?></td>
					<th>별점</th>
					<td><?=$row->grade?>/5</td>
				</tr>
				<?}?>
				<tr>
					<th>제목</th>
					<td colspan="5"><?=$row->subject?></td>
				</tr>
				<?if($bbs->bbs_type==5){?>			
				<tr>
					<th>이벤트 기간</th>
					<td colspan="5"><?=$row->start_date?> ~ <?=$row->end_date?></td>
				</tr>
				<?}?>
				<tr>
					<th>작성자</th>
					<td><?=$row->name?></td>

					<th>등록일</th>
					<td><?=substr($row->reg_date,0,10)?></td>

					<th>조회수</th>
					<td><?=$row->read_cnt?></td>
				</tr>
				<tr>
					<td colspan="6">
						<div class="board-content">		
						
							<? if($bbs->bbs_type=='6'){ ?>
								<? if($row->dong_src!="" && $row->dong_flag=='dong_src'){?>
									<iframe width="80%" height="300px;" src="https://www.youtube.com/embed/<?=$row->dong_src?>" frameborder="0" allowfullscreen></iframe>
								<?}?>
								<? if($row->dong_sorce!="" && $row->dong_flag=='dong_sorce'){
								$row->dong_sorce = str_replace("&lt;","<",$row->dong_sorce);
								$row->dong_sorce = str_replace("&gt;",">",$row->dong_sorce);
								?>
									<?=$row->dong_sorce?>
								<?}?>
								<br><br>
							<?}?>

							<?=stripslashes($row->content)?>
						</div>
					</td>
				</tr>
				<? if($row->bbs_file!="none" && $row->bbs_file!=""){ ?> 
				<tr>
					<th>첨부파일</th>
					<td colspan="5"><a href="/html/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=1"><?=$row->real_file?></a><!--/<a href="#">filename.doc</a--></td>
				</tr>
				<?}?>
			</tbody>
		</table><!-- END Board View -->
		
		<? if($bbs->bbs_coment == 1){ ?>

		<!-- Comment -->
		<ul class="comment-view">
		<? foreach ($coment as $list){ ?>
			<li>
				<p class="name w100"><?=$list->name?></p>
				<div class="cmt w100 pt5 pb5">
					<p><?=htmlspecialchars($list->coment)?></p>
				</div>
				<p class="date w50"><?=$list->reg_date?></p>
				<p class="edit w50 align-r">
				
				<!--a href="#">수정</a-->
				<a href="javascript:bbs_del(<?=$list->idx?>,'bbs_coment')">삭제</a>		
				
				</p>
			</li>
		<?
			}
		?>
		</ul>
		<!-- END Comment -->


		<!-- Write comment -->
		<form name="bbs_coment_form" method="post">
		<input type="hidden" name="code" value="<?=$row->code?>">
		<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('ADMIN_USERID')) ? @$this->session->userdata('ADMIN_USERID') : "";?>">
		<input type="hidden" name="pwd" value="<? echo (@$this->session->userdata('ADMIN_PASSWD')) ? @$this->session->userdata('ADMIN_PASSWD') : "";?>"/>

		<ul class="comment-write">
			<li class="name w25">
				<p class="mb5"><label for="cmt-name" class="w40">이름</label> 
					<span class="w60"><input type="text" id="cmt-name" name="name" value="관리자"/></span>
				</p>
				<p><label for="cmt-pw" class="w40">비밀번호</label> 
					<span class="w60">********</span>
				</p>
			</li>
			<li class="w65">
				<textarea name="coment" id="comment" cols="30" rows="10" style="height:75px;"></textarea>
			</li>
			<li class="submit w10">
				<a href="javascript:bbs_coment();">등록</a>
			</li>
		</ul><!-- END Write comment -->
		</form>

		<?}?>
		
		<!-- Button -->
		<div class="float-wrap mt20">
			<p class="float-l btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/<?=$query_string.$param?>">목록</a></p>
			<p class="float-r">
				<? if($bbs->bbs_type==1){ ?>
				<span class="btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/write/<?=$row->idx?>/<?=$query_string.$param?>">답변달기</a></span>
				<? } ?>

				<span class="btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">수정하기</a></span>
				<span class="btn-inline btn-tinted-02"><a href="javascript:bbs_del(<?=$row->idx?>,'bbs')">삭제하기</a></span>

			</p>
		</div>
		<!-- END Button -->
		
		
		<!-- Prev/Next -->
		<table class="board-nav mt30">
			<caption>이전글과 다음글의 링크</caption>
			<colgroup>
				<col style="width:15%;" />
				<col style="" />
			</colgroup>
			<tbody>
				<tr>
					<th>이전글</th>
					<td>
						<?echo isset($preRow->subject) ? "<a href='/html/board/bbs/".$row->code."/m/view/".$preRow->idx."/'>".$preRow->subject."</a>" : "" ?></a>
					</td>
				</tr>
				<tr>
					<th>다음글</th>
					<td>
						<?echo isset($nextRow->subject) ? "<a href='/html/board/bbs/".$row->code."/m/view/".$nextRow->idx."/'>".$nextRow->subject."</a>" : "" ?></a>
					</td>
				</tr>
			</tbody>
		</table><!-- ENDPrev/Next -->
	</div><!-- END Board Wrap -->
		

		<form name="del_form" method="post">
			<input type="hidden" name="mode">
			<input type="hidden" name="del_idx">
		</form>


		