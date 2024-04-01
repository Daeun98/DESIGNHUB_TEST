
				<div class="float-wrap mt50">
				</div>


				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:5%;"><col style="width:20%"><col style="width:7%;"><col style="width:6%;"><col style=""><col style="width:20%;">
					</colgroup>
					<thead>
					<tbody class="ft092">
						<tr>
							<th>번호</th>
							<th>키워드</th>
							<th>접속자수</th>
							<th>비율</th>
							<th>그래프</th>
							<th>검색엔진</th>
						</tr>
						<?
						$key_list=array();
						$key_name_tmp = "";
						$key_cnt_tmp = 0;
						$no = -1;

						if(isset($key_list_tmp) && count($key_list_tmp)>0){

						for($ii=0; $ii < count($key_list_tmp); $ii++){

							if($key_name_tmp != $key_list_tmp[$ii]['name']){
								$no++;
								$key_name_tmp = $key_list_tmp[$ii]['name'];
								$key_list[$no]['cnt'] = $key_list_tmp[$ii]['cnt'];
								$key_list[$no]['name'] = $key_list_tmp[$ii]['name'];
								$key_list[$no]['host'] = $key_list_tmp[$ii]['host'];
								$key_list[$no]['portal'] = $key_list_tmp[$ii]['portal'];
							}else{
								if(isset($key_list[$no]['cnt'])){
								$key_list[$no]['cnt'] += $key_list_tmp[$ii]['cnt'];
								}
							}
						}

						if(count($key_list) > 0) rsort($key_list);
						$no = count($key_list);

						$lists = 5;
						$rows = 40;
						if(empty($page)) $page = 1;
						$total = count($key_list);
						$page_count = ceil($total/$rows);
						$start = ($page-1)*$rows;
						$no = $total-$start;

						$cnt = 0;

						if(count($key_list) > 0){

							for($ii=$start; $ii < count($key_list) && $rows > 0; $ii++){

								if(!empty($key_list[$ii]['name'])){

									$percent = ceil(($key_list[$ii]['cnt']/$total_cnt)*100);
						?>
						<tr>
							<td><?=$no?></td>
							<td><a href="<?=$key_list[$ii]['host']?>" target="_blank"><?=$key_list[$ii]['name']?></a></td>
							<td><?=$key_list[$ii]['cnt']?></td>
							<td><?=$percent?>%</td>
							<td><img src='/_dhadm/image/icon/count_body2.gif' width='<?=$percent*10?>%' height='10'></td>
							<td><?=$key_list[$ii]['portal']?></td>
						</tr>
					<?
							$cnt++;
						}

					$rows--;
					$no--;
					}

				}

				}else{
				?>
						<tr>
							<td colspan="6">검색키워드가 없습니다.</td>
						</tr>
				<?}?>
					</thead>
				</tbody>
			</table>