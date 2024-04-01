<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 if ( ! function_exists('kdate')){
 	function kdate($stamp){
 		return date('o년 n월 j일, G시 i분 s초', $stamp);
 	}
 }


 if ( ! function_exists('u8_strcut')){
	function u8_strcut($str, $limit)
		/* Note: */
		/* $str must be a valid UTF-8 string */
		/* it may return an empty string even if $limit > 0 */
		{
			 $len= strlen($str);

			 if ($len<= $limit )
				return $str;

			 $len= $limit;

			 /* ASCII are encoded in the range 0x00 to 0x7F
			* The first byte of multibyte sequence is in the range 0xC0 to 0xFD.
			* All furthur bytes are in the range 0x80 to 0xBF.
			*/

			 while ($len > 0 && ($ch = ord($str[$len])) >= 128 && ($ch < 192))
				$len --;


			 return substr($str, 0, $len) ."..";

	}
 }


 if ( ! function_exists('encode')){  // 엔코드
	function encode($data) {
		return base64_encode($data)."||";
	}
 }


 if ( ! function_exists('decode')){ // 디코드
	function decode($data){
		$vars=explode("@@",base64_decode(str_replace("||","",$data)));
		$vars_num=count($vars);
		for($i=0;$i<$vars_num;$i++) {
			$elements=explode("=",$vars[$i]);
			$var[$elements[0]]=$elements[1];
		}
		return $var;
	}
}



	if ( ! function_exists('bbsNewImg')){ // 디코드
		function bbsNewImg( $dateStr, $h, $imgStr ) {
			$h		=	60 * 60 * $h;
			$today		=	time();
			$year		=	substr($dateStr, 0, 4);
			$mon		=	substr($dateStr, 5, 2);
			$day		=	substr($dateStr, 8, 2);
			$hour		=	substr($dateStr, 11, 2);
			$minute	=	substr($dateStr, 14, 2);
			$second	=	substr($dateStr, 17, 2);
			$regiDay	=	mktime($hour, $minute, $second, $mon, $day, $year);
			if($regiDay > ($today - $h)) {
				$img		= $imgStr;
			} else {
				$img		= "";
			}
			return $img;
		}
	}


	// 날자출력 형태
 if ( ! function_exists('strDateCut')){
	function strDateCut($str, $chk = 1) {
		if( $chk==1 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."/".$mon."/".$day;
		} else if( $chk==2 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."/".$mon."/".$day." ".$time.":".$minu;
		} else if( $chk==3 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."-".$mon."-".$day;
		} else if( $chk==4 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."-".$mon."-".$day." ".$time.":".$minu;
		} else if( $chk==5 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."년 ".$mon."월 ".$day."일";
		} else if( $chk==6) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."년 ".$mon."월 ".$day."일 ".$time."시 ".$minu."분";
		} else if( $chk==7 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year.".".$mon.".".$day;
		}
		return $str;
	}
}


 if ( ! function_exists('reDate')){ //날짜자르기
	function reDate($date, $str){
		$date_str = substr($date,0,10);
		$date_str = str_replace("-",$str,$date_str);
		$date_str = str_replace("/",$str,$date_str);
		$date_str = str_replace(".",$str,$date_str);

		return $date_str;
	}
 }



 if ( ! function_exists('script_exe')){ //스크립트 실행
	function script_exe($str){

    echo "<script language='javascript'>";
		echo $str;
    echo"</script>";

	}
 }



 if ( ! function_exists('alert')){ //메시지창 or 페이지이동
	function alert($url='',$message=''){
		if($message){
        echo"
			<script language='javascript'>
			window.alert('$message');
			</script>
		";
		}

		if($url){
			echo"<meta http-equiv='refresh' content='0; URL=$url'>";
		}
		exit;
	}
 }


 if ( ! function_exists('back')){ //메세지를 보내고 뒤로 이동
	function back($message='',$where='-1'){
		echo "<script type=\"text/javascript\">";
		if($message){
				echo "window.alert('$message');";
		}
		echo "history.go($where);
			</script>
		";
		exit;
	}
 }


 if ( ! function_exists('closeWin')){ //메세지를 보내고 현재창 닫기
	function closeWin($message=''){
		echo "<script language='javascript'>";
		if($message){
			echo "window.alert('$message');";
		}

		echo "window.close(self);";
		echo "</script>";
		exit;
	}
}


 if ( ! function_exists('pUrlClose')){ //부모창에 URL 을 보내고 메세지를 띄운후 현재창 닫기
	function pUrlClose($message,$URL){
		echo"
			<script language='javascript'>
			opener.location.href='$URL';
			";

		if($message){
			echo "window.alert('$message');";
		}

		echo "window.close(self);";
		echo "</script>";
		exit;
	}
}



 if ( ! function_exists('Page')){
		function Page($totalCnt='0',$PageNumber='1',$url,$list_num='15',$page_num='5',$query_string='')
		{
			$page = "";

			$total_page=ceil($totalCnt/$list_num); // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다.
			$listNo=$totalCnt - $list_num*($PageNumber-1); //현재 글번호

			//먼저, 한 화면에 보이는 블록($page_num 기본값 이상일 때 블록으로 나뉘어짐 )
			@$total_block=ceil($total_page/$page_num);
			@$block=ceil($PageNumber/$page_num); //현재 블록

			@$first=($block-1)*$page_num; // 페이지 블록이 시작하는 첫 페이지
			@$last=$block*$page_num; //페이지 블록의 끝 페이지

			if($block >= $total_block) {
				$last=$total_page;
			}



			//[처음][*개앞]
			if($block > 1) {
					$prev=$first-1;
					$page.= "<button type='button' onclick='javascript:location.href=\"$url/$query_string&PageNumber=1\"';><img src='/image/board_img/arrow_l_end.gif' alt='맨 앞으로'></button> ";
			} else {
					$page.= "<button type='button'><img src='/image/board_img/arrow_l_end.gif' alt='맨 앞으로'></button> ";
			}

			//[이전]
			if($PageNumber > 1) {
					$go_page=$PageNumber-1;
					$page.= "<button type='button' onclick='javascript:location.href=\"$url/$query_string&PageNumber=$go_page\"';><img src='/image/board_img/arrow_l.gif' alt='이전'></button> ";
			} else {
					$page.= "<button type='button'><img src='/image/board_img/arrow_l.gif' alt='이전'></button> ";
			}

			//페이지 링크
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
					if($page_link==$PageNumber) {
						$pageclass="class='on'";
					} else {
						$pageclass="";
					}
					$page.="<a href='$url/$query_string&PageNumber=$page_link' $pageclass>$page_link</a> ";
			}

			//[다음]
			$page.="";
			if($total_page > $PageNumber) {
					$go_page=$PageNumber+1;
					$page.="<button type='button' onclick='javascript:location.href=\"$url/$query_string&PageNumber=$go_page\"';><img src='/image/board_img/arrow_r.gif' alt='다음'></button> ";
			} else {
					$page.="<button type='button'><img src='/image/board_img/arrow_r.gif' alt='다음'></button> ";
			}

			//[*개뒤][마지막]
			if($block < $total_block) {
					$next=$last+1;
					$page.="<button type='button' onclick='javascript:location.href=\"$url/$query_string&PageNumber=$total_page\";'><img src='/image/board_img/arrow_r_end.gif' alt='맨 뒤로'></button> ";
			} else {
					$page.="<button type='button'><img src='/image/board_img/arrow_r_end.gif' alt='맨 뒤로'></button> ";
			}

			return $page;


		}
	}


 if ( ! function_exists('Page2')){
		function Page2($totalCnt='0',$PageNumber='1',$url,$list_num='15',$page_num='5',$query_string='')
		{
			$page = "";

			$total_page=ceil($totalCnt/$list_num); // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다.
			$listNo=$totalCnt - $list_num*($PageNumber-1); //현재 글번호

			//먼저, 한 화면에 보이는 블록($page_num 기본값 이상일 때 블록으로 나뉘어짐 )
			@$total_block=ceil($total_page/$page_num);
			@$block=ceil($PageNumber/$page_num); //현재 블록

			@$first=($block-1)*$page_num; // 페이지 블록이 시작하는 첫 페이지
			@$last=$block*$page_num; //페이지 블록의 끝 페이지

			if($block >= $total_block) {
				$last=$total_page;
			}



			//[처음][*개앞]
			if($block > 1) {
					$prev=$first-1;
					$page.= "<a href='$url/$query_string&PageNumber=1'><img src='/_dhadm/image/board_img/arrow_l_end.gif' alt='맨 처음으로' /></a>";
			} else {
					$page.= "<a href='javascript:;'><img src='/_dhadm/image/board_img/arrow_l_end.gif' alt='맨 처음으로' /></a> ";
			}

			//[이전]
			if($PageNumber > 1) {
					$go_page=$PageNumber-1;
					$page.= "<a href='$url/$query_string&PageNumber=$go_page'><img src='/_dhadm/image/board_img/arrow_l.gif' alt='이전' /></a> ";
			} else {
					$page.= "<a href='javascript:;'><img src='/_dhadm/image/board_img/arrow_l.gif' alt='이전' /></a> ";
			}

			//페이지 링크
			$page.="<span> ";
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
					if($page_link==$PageNumber) {
						$pageclass="class='on'";
					} else {
						$pageclass="";
					}
					$page.="<a href='$url/$query_string&PageNumber=$page_link' $pageclass>$page_link</a> ";
			}
			$page.="</span> ";

			//[다음]
			$page.="";
			if($total_page > $PageNumber) {
					$go_page=$PageNumber+1;
					$page.="<a href='$url/$query_string&PageNumber=$go_page'><img src='/_dhadm/image/board_img/arrow_r.gif' alt='다음' /></a> ";
			} else {
					$page.="<a href='javascript:;'><img src='/_dhadm/image/board_img/arrow_r.gif' alt='다음' /></a> ";
			}

			//[*개뒤][마지막]
			if($block < $total_block) {
					$next=$last+1;
					$page.="<a href='$url/$query_string&PageNumber=$total_page'><img src='/_dhadm/image/board_img/arrow_r_end.gif' alt='맨 뒤로' /></a> ";
			} else {
					$page.="<a href='javascript:;'><img src='/_dhadm/image/board_img/arrow_r_end.gif' alt='맨 뒤로' /></a> ";
			}

			return $page;

		}
	}


 if ( ! function_exists('PageAjax')){
		function PageAjax($totalCnt='0',$PageNumber='1',$url,$list_num='15',$page_num='5',$query_string='',$code)
		{
			$page = "";

			$total_page=ceil($totalCnt/$list_num); // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다.
			$listNo=$totalCnt - $list_num*($PageNumber-1); //현재 글번호

			//먼저, 한 화면에 보이는 블록($page_num 기본값 이상일 때 블록으로 나뉘어짐 )
			@$total_block=ceil($total_page/$page_num);
			@$block=ceil($PageNumber/$page_num); //현재 블록

			@$first=($block-1)*$page_num; // 페이지 블록이 시작하는 첫 페이지
			@$last=$block*$page_num; //페이지 블록의 끝 페이지

			if($block >= $total_block) {
				$last=$total_page;
			}



			//[처음][*개앞]
			if($block > 1) {
					$prev=$first-1;
					$page.= "<button type='button' onclick='javascript:bbs_load(\"".$code."\",1);'><img src='/image/board_img/arrow_l_end.gif' alt='맨 앞으로'></button>";
			} else {
					$page.= "<button type='button'><img src='/image/board_img/arrow_l_end.gif' alt='맨 앞으로'></button>";
			}

			//[이전]
			if($PageNumber > 1) {
					$go_page=$PageNumber-1;
					$page.= "<button type='button' onclick='javascript:bbs_load(\"".$code."\",$go_page);'><img src='/image/board_img/arrow_l.gif' alt='이전'></button>";
			} else {
					$page.= "<button type='button'><img src='/image/board_img/arrow_l.gif' alt='이전'></button>";
			}

			//페이지 링크
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
					if($page_link==$PageNumber) {
						$pageclass="class='on'";
					} else {
						$pageclass="";
					}
					$page.="<a href='javascript:bbs_load(\"".$code."\",$page_link);' $pageclass>$page_link</a> ";
			}

			//[다음]
			$page.="";
			if($total_page > $PageNumber) {
					$go_page=$PageNumber+1;
					$page.="<button type='button' onclick='javascript:bbs_load(\"".$code."\",$go_page);'><img src='/image/board_img/arrow_r.gif' alt='다음'></button>";
			} else {
					$page.="<button type='button'><img src='/image/board_img/arrow_r.gif' alt='다음'></button>";
			}

			//[*개뒤][마지막]
			if($block < $total_block) {
					$next=$last+1;
					$page.="<button type='button' onclick='javascript:bbs_load(\"".$code."\",$total_page);'><img src='/image/board_img/arrow_r_end.gif' alt='맨 뒤로'></button>";
			} else {
					$page.="<button type='button'><img src='/image/board_img/arrow_r_end.gif' alt='맨 뒤로'></button>";
			}

			return $page;


		}
	}





		if ( ! function_exists('result')){
		function result($ret, $msg='', $url='')
		{

			if($ret)
			{
				if($url){
					if($msg){
						alert($url,$msg." 되었습니다.");
					}else{
						alert($url);
					}
				}else{
					if($msg){
						alert($_SERVER['PHP_SELF'] ,$msg." 되었습니다.");
					}else{
						alert($_SERVER['PHP_SELF']);
					}
				}
			}
			else
			{
					back($msg."에 실패하였습니다.");
			}

		}

	}



		if ( ! function_exists('parent_result')){
			function parent_result($msg='', $script='')
			{
				echo "<script>";
				if($msg){
					echo "alert('".$msg." 되었습니다.');";
				}
				if($script){
					echo $script;
				}
				echo "</script>";

			}

		}



		if ( ! function_exists('cdir')){
		function cdir()
		{
			$cdir = explode("/",$_SERVER['PHP_SELF']);
			return "";
		}
		}

		if ( ! function_exists('self_url')){
		function self_url()
		{
			$self_url = str_replace("/index.php","",$_SERVER['PHP_SELF']);
			return $self_url;
		}
		}


		if ( ! function_exists('data_arr')){ //데이타를 불러와서 배열로 만듦
			function data_arr($data){
				$vars=explode("&",$data);
				$vars_num=count($vars);
				for($i=0;$i<$vars_num;$i++) {
					$elements=explode("=",$vars[$i]);
					$var[$elements[0]]=$elements[1];
				}
				return $var;
			}
		}

		if ( ! function_exists('inicis_bank_array')){ //데이타를 불러와서 배열로 만듦
			function inicis_bank_array($code){

				$bank_array = array(
					"01"=>"외환","04"=>"현대","11"=>"BC","14"=>"신한","16"=>"NH","21"=>"해외비자","23"=>"JCB","25"=>"해외다이너스","03"=>"롯데","06"=>"국민","12"=>"삼성","15"=>"한미","17"=>"하나SK","22"=>"해외마스터","24"=>"해외아멕스","02"=>"한국산업은행","04"=>"국민은행 (주택은행)","07"=>"수협중앙회","12"=>"단위농협","20"=>"우리은행","23"=>"제일은행","26"=>"신한은행","31"=>"대구은행","34"=>"광주은행","37"=>"전북은행","39"=>"경남은행","53"=>"씨티은행","03"=>"기업은행","05"=>"외환은행","11"=>"농협중앙회","16"=>"축협중앙회","21"=>"신한은행 (조흥은행)","25"=>"하나은행 (서울은행)","27"=>"한국씨티은행 (한미은행)","32"=>"부산은행","35"=>"제주은행","38"=>"강원은행","41"=>"비씨카드","54"=>"홍콩상하이은행","71"=>"우체국","81"=>"하나은행","83"=>"평화은행","87"=>"신세계","88"=>"신한은행(조흥 통합)","D1"=>"동양종합금융증권","D2"=>"현대증권","D3"=>"미래에셋증권","D4"=>"한국투자증권","D5"=>"우리투자증권","D6"=>"하이투자증권","D7"=>"HMC투자증권","D8"=>"SK증권","D9"=>"대신증권","DA"=>"하나대투증권","DB"=>"굿모닝신한증권","DC"=>"동부증권","DD"=>"유진투자증권","DE"=>"메리츠증권","DF"=>"신영증권"
				);

				$bank_name = $bank_array[$code];

				if(!$bank_name){ $bank_name = "기타"; }

				return $bank_name;
			}
		}

		if ( ! function_exists('pr')){ //데이타를 불러와서 배열로 만듦
			function pr($arr){
				echo "<pre>";
				print_r($arr);
				echo "</pre>";
			}
		}

		if(!function_exists('exc_dbin')){
			function exc_dbin($arr){
				foreach($arr as $k=>$v){
					echo "&insert_datas['".$k."'] = &this->input->post(\"".$k."\", true);<BR>";
				}
			}
		}

		if(!function_exists('timenow')){
			function timenow(){
				return date("Y-m-d H:i:s");
			}
		}


		if(!function_exists('spam_img')){
			function spam_img($num){
				$imgName = "";

				switch($num)
				{
					case 0 : $imgName = "FCEE"; break;
					case 1 : $imgName = "J766"; break;
					case 2 : $imgName = "AAD6"; break;
					case 3 : $imgName = "5DAC"; break;
					case 4 : $imgName = "64CA"; break;
					case 5 : $imgName = "IA37"; break;
					case 6 : $imgName = "97CA"; break;
					case 7 : $imgName = "B9D6"; break;
					case 8 : $imgName = "CE3A"; break;
					case 9 : $imgName = "HC38"; break;
				}

				return $imgName;
			}
		}

		if(!function_exists('ssl_check')){
			function ssl_check(){
				$prot = "";
				if((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')){
					$prot = "https";
				}
				else{
					$prot = "http";
				}
				return $prot;
			}
		}
?>