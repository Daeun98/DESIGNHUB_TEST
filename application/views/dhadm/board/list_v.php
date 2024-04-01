<?php
$defurl = "/html/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);
?>

				<h3 class="icon-search">목록</h3>
				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<col width="100">
					<col>
					<col width="150">
					<col width="150">
					<thead>
						<tr>
							<th>번호</th>
							<th>제목</th>
							<th>작성자</th>
							<th>날짜</th>
						</tr>
					</thead>
					<tbody class="ft092">
<?php
foreach($notice as $nt){
?>
							<tr>
								<td>[공지]</td>
								<td><a href="<?php echo $defurl."/view/".$nt->idx; ?>"><?php echo $nt->subject?></a></td>
								<td><?php echo $nt->name?></td>
								<td><?php echo substr($nt->reg_date,0,10)?></td>
							</tr>
<?php
}

foreach($list as $lt){
?>
								<tr>
									<td><?php echo "번호";?></td>
									<td><a href="<?php echo $defurl."/view/".$lt->idx; ?>"><?php echo $lt->subject?></a></td>
									<td><?php echo $lt->name?></td>
									<td><?php echo substr($lt->reg_date,0,10)?></td>
								</tr>
<?php
}
?>
					</tbody>
				</table>

				<div class="float-wrap mt20">
					<div class="float-r">
						<a href="<?php echo $defurl."/add";?>" class="button btn-ok">글쓰기</a></span>
					</div>
				</div>