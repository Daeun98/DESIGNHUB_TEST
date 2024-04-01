
	<input type="hidden" name="addIndex" id="addIndex" value="0">
	<input type="hidden" name="moveIdx" id="moveIdx" value="">

				<!-- 카테고리 관리 및 설정 -->
				<div class="float-wrap">
					<!-- 카테고리 관리 -->
					<div class="float-l cate_list" style="width:37%;">
						<div class="float-wrap">
							<h3 class="icon-cate float-l">분류 관리</h3>
							<p class="float-r">
								<button type="button" class="plain mr5 mt5" title="새로고침"><img src="/_dhadm/image/icon/refresh_16.png" alt="새로고침"></button>
								<input type="button" value="대분류 추가" class="btn-ok" onclick="addItem()">
							</p>
						</div>
						<div class="adm-category-box">
							<ul class="adm-category">							
							</ul>
						</div>
						<p class="align-r mt10 ft-xs">선택한 분류 이동<span class="ml10"></span>
							<button type="button" class="btn-icon btn-clear">▲</button>
							<button type="button" class="btn-icon btn-clear">▼</button>
						</p>
					</div><!-- END 카테고리 관리 -->

					<!-- 카테고리 설정 -->
					<div class="float-r cate_view" style="width:61%">
						<h3 class="icon-pen">분류 상세설정</h3>
						<p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 분류를 선택해주세요.</p>
					</div><!-- END 카테고리 설정 -->
				</div><!-- END 카테고리 관리 및 설정 -->

					<? /*
				<h3 class="icon-search mt60">제품 검색</h3>
				<!-- 제품검색 -->
				<table class="adm-table">
					<caption>제품 검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>						
						<tr>
							<th>브랜드/기획전 분류</th>
							<td>
								<select name="">
									<option value="">분류명1</option>
									<option value="">분류명2</option>
								</select>
							</td>
						</tr>					
						<tr>
							<th>제품검색</th>
							<td>
								<input type="text" placeholder="제품명으로 검색" class="width-m">
								<input type="text" placeholder="코드명으로 검색" class="width-m">
								<input type="button" value="검색" class="btn-ok">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
*/?>

				<!-- 제품리스트
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">등록 제품 <strong>99개</strong></h3>
					<p class="list-adding float-r">
						<a href="#" class="on">등록일순</a>
						<a href="#">높은가격순<em>▲</em></a>
						<a href="#">낮은가격순<em>▼</em></a>
						<a href="#">이름순<em>▲</em></a>
						<a href="#">이름순<em>▼</em></a>
					</p>
				</div>

				<table class="adm-table line align-c">
					<caption>제품 목록</caption>
					<colgroup>
						<col><col><col><col style="width:70px;"><col style="width:250px;"><col><col><col><col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>No</th>
							<th>제품코드</th>
							<th colspan="2">제품명</th>
							<th>가격</th>
							<th>재고</th>
							<th>등록일</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>∞</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr class="selected">
							<td><input type="checkbox" checked></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td><img src="/_dhadm/image/icon/soldout.gif" alt="품절"></td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td>30</td>
							<td>ABCKDO3920394</td>
							<td class="pr0"><img src="/_dhadm/image/common/thumb.jpg" alt="" width="70" height="60" class="block"></td>
							<td class="align-l">소니 바이오 VGN-SZ465N/C (코어2듀오 2.0Ghz, 1.5G, 120G, Multi, 13.3LCD, Vista)</td>
							<td>239,000원</td>
							<td>99</td>
							<td>2016-01-01</td>
							<td><input type="button" value="수정" class="btn-sm">
								<input type="button" value="삭제" class="btn-sm btn-alert">
							</td>
						</tr>
					</tbody>
				</table>
				
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택이동" class="btn-ok" onclick="openMoveProduct();">
						<input type="button" value="선택복사" class="btn-ok">
						<input type="button" value="선택삭제" class="btn-alert" onclick="confirm('선택하신 제품을 삭제합니다. \n삭제하신 제품은 복구할 수 없습니다.');">
					</div>
				</div>

				<p class="list-pager align-c" title="페이지 이동하기">
					<a href="#"><img src="/_dhadm/image/board_img/arrow_l_end.gif" alt="맨 처음으로" /></a>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_l.gif" alt="이전" /></a>
					<span>
						<a href="#" class="on">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#">5</a>
					</span>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_r.gif" alt="다음" /></a>
					<a href="#"><img src="/_dhadm/image/board_img/arrow_r_end.gif" alt="맨 뒤로" /></a>
				</p><!-- END Pager -->

				

	<script type="text/javascript">

	list();

	function list(up_idx,mode)
	{		
		if(!up_idx && $("#moveIdx").val()!=""){
			//up_idx = $("#moveIdx").val();
			$("#moveIdx").val("");
		}

		$.ajax({
			url: "<?=cdir()?>/product/brand",
			data: {ajax : "1", mode : 'lists', up_idx: up_idx},
			async: true,
			cache: false,
			error: function(xhr){
			},
			success: function(data){
				$('.cate_list').html(data);
				$('.cate_view').html('<h3 class="icon-pen">분류 상세설정</h3><p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 분류를 선택해주세요.</p>');
				$("#addIndex").val(0);

				if(up_idx){
					view('view', up_idx);
				}
			}	
		});
	}

	function view(mode, idx)
	{	
		if(!idx){ idx = ""; }else{ delItem(); }

		$.ajax({
			url: "<?=cdir()?>/product/brand",
			data: {ajax : "1", mode : mode, idx:idx},
			async: true,
			cache: false,
			error: function(xhr){
			},
			success: function(data){
				$('.cate_view').html(data);
				if(mode=="view")
				{
					$("#moveIdx").val(idx);
				}else{
					$("#moveIdx").val("");
				}
			}	
		});
	}

	
	function move(action)
	{

		var moveIdx = $("#moveIdx").val();

		if(moveIdx){
			
			$.ajax({
				url: "<?=cdir()?>/product/cate_move",
				data: {ajax : "1",moveIdx:moveIdx, action:action, flag:"brand"},
				async: true,
				cache: false,
				error: function(xhr){
				},
				success: function(data){
					if(data=="u"){
						alert('가장 상위 순서 입니다.');
					}else if(data=="d"){
						alert('가장 하위 순서 입니다.');
					}else if(data==1){
						list(moveIdx);
					}
				}	
			});

		}else{
			alert('카테고리를 선택해주세요.');
			return;
		}
	}
	

	function del()
	{
		if(confirm("삭제하시겠습니까?")){
			var form = document.cate_write;
			form.mode.value="del";
			form.submit();
		}
	}


	</script>
