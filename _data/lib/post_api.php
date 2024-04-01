<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
function sample6_execDaumPostcode() {
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 각 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var fullAddr = ''; // 최종 주소 변수
			var extraAddr = ''; // 조합형 주소 변수

			// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
			if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
				fullAddr = data.roadAddress;
			} else { // 사용자가 지번 주소를 선택했을 경우(J)
				fullAddr = data.jibunAddress;
			}

			// 사용자가 선택한 주소가 도로명 타입일때 조합한다.
			if(data.userSelectedType === 'R'){
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

			document.getElementById("address1").value = fullAddr;

			// 커서를 상세주소 필드로 이동한다.
			document.getElementById("address2").value='';
			document.getElementById("address2").focus();
		}
	}).open();
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
