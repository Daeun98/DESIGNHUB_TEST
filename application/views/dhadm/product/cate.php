

				<!-- 카테고리 관리 및 설정 -->
				<div class="float-wrap">
					<!-- 카테고리 관리 -->
					<div class="float-l cate_list" style="width:38%;">
					</div><!-- END 카테고리 관리 -->

					<!-- 카테고리 설정 -->
					<div class="float-r cate_view" style="width:60%">
						<h3 class="icon-pen">카테고리 상세설정</h3>
						<p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 카테고리를 선택해주세요.</p>
					</div><!-- END 카테고리 설정 -->

				</div><!-- END 카테고리 관리 및 설정 -->


				
	
	<script type="text/javascript">

	list();

	function list(up_idx,mode)
	{		
		if(!up_idx && $("#moveIdx").val()!=""){
			//up_idx = $("#moveIdx").val();
			$("#moveIdx").val("");
		}

		$.ajax({
			url: "<?=cdir()?>/product/cate",
			data: {ajax : "1", mode : 'lists', up_idx: up_idx},
			async: true,
			cache: false,
			error: function(xhr){
			},
			success: function(data){
				$('.cate_list').html(data);
				$('.cate_view').html('<h3 class="icon-pen">카테고리 상세설정</h3><p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 카테고리를 선택해주세요.</p>');
				$("#addIndex").val(0);

				if(up_idx){
					view('view', up_idx);
				}
			}	
		});
	}


	function view(mode, idx)
	{	
		if(!idx){ idx = ""; }

		$.ajax({
			url: "<?=cdir()?>/product/cate",
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
				data: {ajax : "1",moveIdx:moveIdx, action:action},
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