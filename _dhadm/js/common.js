jQuery(document).ready(function($){
	toggleNext();
});

function toggleNext(){
	$(".toggle-btn, .toggle-btn-sm").parent().css("position","relative");
	$(".toggle-btn, .toggle-btn-sm").parent().each(function(){
		$(this).on("click", function(){
			var $idx = $(this);
			var $toggleContent = ($(this).next().hasClass("toggle-line")) ? $(this).next().next() : $(this).next() ;
			$toggleContent.toggle();

			if ($toggleContent.css("display") == "none")
			{
				$(this).find(".toggle-btn, .toggle-btn-sm").removeClass("on");
				$(this).after("<span class='toggle-line'></span>");
			} else {
				$(this).find(".toggle-btn, .toggle-btn-sm").addClass("on");
				$(this).next(".toggle-line").remove();
			}
		});
	});	
}

// Script In SHOP
function openWinPopup(url, name, w, h){
	var str = "width=" + w + ", height=" + h + ", left=50, top=50, scrollbars=auto";
	window.open(url, name, str);
}
function openInParent(url, closeSelf){
	window.opener.location.href=url;
	if (closeSelf)
	{
		window.close();
	}
}
$(function(){
	$("#menu_frm").attr("src","/_dhadm/tree/?DHadminMd5ValString=201210");
});

function del_bbs(id){
	if(confirm('게시판을 삭제하시겠습니까?\n삭제시 모든 데이터가 지워지며 복구가 불가능합니다.')){
		location.href="dhadm/bbs/del/"+id;	
	}	
}