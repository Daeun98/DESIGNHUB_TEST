<?php

// 파일명 중복체크 함수
function GetUniqFileName($FN, $PN){
	$FileExt = substr(strrchr($FN, "."), 1); // 확장자 추출
	$FileName = substr($FN, 0, strlen($FN) - strlen($FileExt) - 1); // 파일명 추출

	$ret = "$FileName.$FileExt";
	while(file_exists($PN.$ret)){	// 파일명이 중복되지 않을때까지 반복함
    $FileCnt++;
    $ret = $FileName."_".$FileCnt.".".$FileExt; // 파일명뒤에 (_1 ~ n)의 값을 붙여서....
  }

  return($ret); // 중복되지 않는 파일명 리턴
}

// 이미지가 업로드될 폴더의 전체 경로입니다.
// 여기서는 구현을 간단히 하기 위해서 웹 루트 안에 업로드합니다.
$uploadfullPath = $_SERVER['DOCUMENT_ROOT']."/_data/file/_editor_images/";

// 이미지가 웹에서 보여질때 사용되어질 기본 URL입니다.
// 웹루트 부터의 절대 URL을 입력합니다.
$imageBaseUrl = "/_data/file/_editor_images/";

// 에디터가 만들어진 textarea의 id 값이 넘어옵니다.
$CKEditor = $_GET['CKEditor'] ;

// 이미지 업로드 후 에디터 내에 이미지를 표시하는데 사용되는 값입니다.
// CKEditor의 addFunction으로 추가된 함수를 호출하기 위한 키값입니다.
$funcNum = $_GET['CKEditorFuncNum'] ;

// 브라우저의 언어코드가 넘어옵니다. (ko)
// 필요하다면 파일명 엔코딩 등에 사용되어질 수 있습니다.
$langCode = $_GET['langCode'] ;

// 업로드후 이미지를보여줄 이미지 url
$url = '' ;

// 에러가 발생하면 메세지를 보여줍니다.
$message = '';

// 업로드 성공여부
//$uploaded = '';

// CKEditor에서 이미지 업로드는 파일 키값으로 upload를 사용합니다.
if (isset($_FILES['upload'])) {
	$file_name = date("Ymdhis").$_FILES['upload']['name'];
	$name = GetUniqFileName($file_name, $uploadfullPath);

	// 파일 이름 중복 체크는 없습니다.(실제 구현에는 직접 작성해야 할 것입니다.)
	move_uploaded_file($_FILES["upload"]["tmp_name"], $uploadfullPath . $name);

	// 업로드후 이미지를 보여줄 URL 을 만듭니다.
	//$uploaded = 1;
	$url = $imageBaseUrl . $name ;
	$result = array(
		'uploaded'=>1,
		'fileName'=>$name,
		'url'=>$url
	);
}
else {
	//$uploaded = 0;
	$message = '업로드에 실패하였습니다.';

	$result = array(
		'uploaded'=>0,
		'error'=>array(
			'message'=>$message
		)
	);
}

echo json_encode($result);

// 이미지 업로드는 iframe을 사용해서 처리되므로 parent 와 통신하기 위해서
// 자바스크립트를 사용합니다.
//echo "<script type='text/javascript'>; window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";

// 에디터 메뉴 사용자 정의 /editor/ckeditor/samples/toolbarconfigurator/index.html
?>