

	<input type="hidden" name="addIndex" id="addIndex" value="0">
	<input type="hidden" name="moveIdx" id="moveIdx" value="">

						<!-- 클래스명 정리 :
							1. 하위 카테고리가 있을 경우에만 부모 li 태그에 'parent' 클래스 추가
							2. 카테고리 항목(p태그) 선택시 해당 p태그에 'on' 클래스 추가

							참고 : em.ic는 폴더 아이콘 표시를 위한 태그로 상위 li의 클래스에 따라 모양이 변경됨.
						-->

						<div class="float-wrap">
							<h3 class="icon-cate float-l">분류 관리</h3>
							<p class="float-r">
								<button type="button" class="plain mr5 mt5" title="새로고침" onclick="list()"><img src="/_dhadm/image/icon/refresh_16.png" alt="새로고침"></button>
								<input type="button" value="대분류 추가" class="btn-ok" onclick="addItem()">
							</p>
						</div>
						<div class="adm-category-box">
							<ul class="adm-category">	
							<? foreach($data as $lt){?>
							<li onclick="view('view', <?=$lt->idx?>)"><p <?if($this->input->get("up_idx")==$lt->idx){?>class="on"<?}?>><em class="ic"></em><?=$lt->title?></p></li>
							<?}?>
							</ul>
						</div>
						<p class="align-r mt10 ft-xs">선택한 분류 이동<span class="ml10"></span>
							<button type="button" class="btn-icon btn-clear" onclick="move('u');">▲</button>
							<button type="button" class="btn-icon btn-clear" onclick="move('d');">▼</button>
						</p>


						
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//하위 카테고리가 있을 경우 li 에 .parent 추가
		$(".adm-category li").each(function(){
			var $dep = $(this).children("ul");
			if ($dep.length > 0) $(this).addClass("parent");
		});
		
		//카테고리 폴더 아이콘에 이벤트 추가(열기/닫기)
		$(".adm-category .ic").each(function(){
			var $child = $(this).parent("p").siblings("ul");
			$(this).on("click", function(){
				toggleCategoryChild($child);
			});
		});

		//카테고리 선택
		$(".adm-category p").on("click", function(e){
			var $on = $(this);
			if ((e.target.className!="ic" || !$on.parent("li").hasClass("parent")) && e.target.nodeName!="INPUT")
			{
				$(".adm-category p").not($on).removeClass("on");
				$on.addClass("on");
			}
		});
	});
	//category open, close toggle
	function toggleCategoryChild($child){
		$child.stop().toggle(200,function(){
			var $parent = $child.parent("li");
			if ($child.css("display") == "none") {
				$parent.removeClass("open");
				$("ul", $child).hide();
				$("li", $child).removeClass("open");
				$("p", $child).removeClass("on"); //하위 카테고리의 선택을 해제
			} else {
				$parent.addClass("open");
			}
		});
	}
	//각 카테고리의 하위 항목추가
	function addItem(){

		if($("#addIndex").val() == "0"){
			$(".adm-category").append('<li class="imsi"><p class="on"><em class="ic"></em>분류 추가 <img src="/_dhadm/image/icon/opt_del.png" onclick="delItem();"></p></li>');
			$("li p").removeClass("on");
			$(".imsi p").addClass("on");
			$("#addIndex").val(1);
			
			view('write');
		}
	}

	function delItem()
	{
		$(".imsi").remove();
		$("#addIndex").val(0);
		$('.cate_view').html('<h3 class="icon-pen">분류 상세설정</h3><p class="pt80 align-c" style="border-top:2px solid #666;">왼쪽에서 분류를 선택해주세요.</p>');
	}
</script>