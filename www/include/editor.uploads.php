<?php
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";

$getBdCode = trim($_REQUEST["tb"]);
$getECode = trim($_REQUEST["ecode"]);
$files = trim($_FILES["upload"]);

$baseEditorUrl = trim($_SERVER['DOCUMENT_ROOT']) ."/data/{$getBdCode}";
if ( !is_dir($baseEditorUrl) ) {
	@mkdir($baseEditorUrl, 0777, true);
	@chmod($baseEditorUrl, 0777);
}
$uploads_dir = "{$baseEditorUrl}/editor";
if ( !is_dir($uploads_dir) ) {
	@mkdir($uploads_dir, 0777, true);
	@chmod($uploads_dir, 0777);
}

$allowed_ext = array('jpg','jpeg','png','gif');

// 변수 정리
$error = $_FILES["upload"]['error'];
$orgFile = $_FILES["upload"]['name'];
//----$ext = strtolower(array_pop(explode('.', $name)));
$extend = strtolower(end(explode('.', $orgFile)));

// 오류 확인
$message = '';
if( $error != UPLOAD_ERR_OK ) {
	switch( $error ) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			$message = "파일이 너무 큽니다. ($error)";
			break;
		case UPLOAD_ERR_NO_FILE:
			$message = "파일이 첨부되지 않았습니다. ($error)";
			break;
		default:
			$message = "파일이 제대로 업로드되지 않았습니다. ($error)";
	}
	echo '{"uploaded": 0, "error": {"message": "'. $message .'"}}';
	exit;
}

// 확장자 확인
if( !in_array($extend, $allowed_ext) ) {
	$message = "허용되지 않는 확장자입니다.";
	echo '{"extend":"'.$orgFile.'", "uploaded": 0, "error": {"message": "'. $message .'"}}';
	exit;
}

// 파일 이동
$chagename = str_replace(".{$extend}", '', trim($orgFile));
$filename = md5(time().$chagename).'.'.$extend;
if ( !move_uploaded_file( $_FILES["upload"]['tmp_name'], "{$uploads_dir}/{$filename}") ) {

	$message = "첨부파일에 문제가 발생하였습니다.";
	echo '{"uploaded": 0, "error": {"message": "'. $message .'"}}';

} else {
	@chmod($uploads_dir.'/'.$filename, 0777);

	try {
		$DB->beginTransaction();

		$valueArray = array(
			'tcode'=>	$getBdCode,
			'ecode'	=>	$getECode,
			'locate'=>	'E',	//----[2021-06-07] 여기서 올라오는건 다 웹에디터 아닌가?
			'oname'	=>	$orgFile,
			'cname'	=>	$filename,
			'ftype'	=>	$_FILES["upload"]['type'],
			'fsize'	=>	$_FILES["upload"]['size']
		);

		$setUrl = "/data/{$getBdCode}/editor/";
		$getCode = $DB->insert("mpr_files", $valueArray);

		$DB->commit();
		$fullPathFile = $setUrl.$filename;

		echo '{"uploaded" : 1, "filename":"'. $filename .'", "url":"'. trim($fullPathFile) .'"}';

	} catch(Exception $ex) {

		$DB->rollBack();

		$message = "첨부파일에 의심되는 문제가 발생하였습니다.";
		echo '{"uploaded": 0, "error": {"message": "'. $message .'"}}';
	}


}

?>