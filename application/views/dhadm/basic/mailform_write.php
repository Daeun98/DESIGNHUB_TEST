
<?
if($this->uri->segment(4)=="edit"){

	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}

$title = $row->title;
$title = str_replace("[shop_name]",$shop_info['shop_name'],$title);

$content = $row->content;

$content = str_replace("[shop_url]",$shop_info['shop_domain'],$content);
$content = str_replace("[shop_name]",$shop_info['shop_name'],$content);
$content = str_replace("[shop_addr]",$shop_info['shop_address'],$content);
$content = str_replace("[shop_tel]",$shop_info['shop_tel1'],$content);
$content = str_replace("[shop_fax]",$shop_info['shop_fax'],$content);
?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:10%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>제목</th>
							<td colspan="3"><input type="text" class="width-xl" name="subject" msg="타이틀을" value="<? echo isset($row->subject) ? $row->subject : "";?>"></td>
						</tr>
						<tr>
							<th>메일 제목</th>
							<td colspan="3"><input type="text" class="width-xl" name="title" msg="메일 제목을" value="<? echo isset($title) ? $title : "";?>"></td>
						</tr>
						<tr>
							<th>메일 내용</th>
							<td colspan="3">
							<textarea name="tx_content" id="tx_content" style="width:100%; height:412px; display:none;"><? echo isset($content) ? $content : "";?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/basic/mailform/m/<?=$query_string?>';">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk('frm','editor');">
				</p>

			</form>

<script type="text/javascript" src="/_data/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('tx_content');
</script>