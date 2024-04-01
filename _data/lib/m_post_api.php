<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<style type="text/css">
#layer {
	position: absolute;
	margin-top:-150px;
	z-index:99999999 !important;
}
</style>
<div id="layer" style="display:none;position:absolute;overflow:hidden;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function sample6_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
								if(data.zonecode){
									document.getElementById("zipcode1").value = data.zonecode;
								}else{
									document.getElementById("zipcode1").value = data.postcode1+data.postcode2;
								}

                document.getElementById('address1').value = fullAddr;
								document.getElementById("address2").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width : '100%',
            height : '100%'
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 300; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = $(window).scrollTop() + ((window.innerHeight || document.documentElement.clientHeight)/2) + 'px' ;
    }


    //SNS 연동
    function SNS_Send(val, subject, content, idx)
    {
				var DocSummary = encodeURIComponent(content);
				var DocImage = "";
        var snsTitle = encodeURIComponent(subject);

        //var naverURL   = encodeURIComponent('http://<?=$_SERVER["HTTP_HOST"]?>/html/naver_ret.php?bbs_idx='+idx+'&mode=view');
        var snsURL   = encodeURIComponent('http://<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>');
				var faceURL = encodeURIComponent('http://<?=$_SERVER["HTTP_HOST"]?>/html/dh/facebook_ret?url=<?=$_SERVER["REQUEST_URI"]?>&subject='+snsTitle+'&content='+DocSummary);

        if (val == 'tw')
        {
            window.open("http://twitter.com/home?status=" + snsTitle + " - "+ DocSummary +"("+snsURL+")",val,'');
        }

        if (val == 'face')
        {
						window.open("http://www.facebook.com/sharer/sharer.php?u=" + faceURL,val,'width=700,height=350');
        }

        if (val == 'naver')
        {
						window.open("http://share.naver.com/web/shareView.nhn?url="+naverURL+"&title="+snsTitle,val,'width=410px,height=500px,scrollbars=no');
        }

    }
</script>
