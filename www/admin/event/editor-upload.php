<?php

    // if($_FILES['files']['size']>10240000){//10메가
    //     echo "-1";
    //     exit;

    // }
    // $ext = substr(strrchr($_FILES['files']['name'],"."),1);
    // $ext = strtolower($ext);

    // if ($ext != "jpg" and $ext != "png" and $ext != "jpeg" and $ext != "gif"){
    //     echo "-1";
    //     exit;
    // }

    // $name = "mp_".$now3.substr(rand(),0,4);
    // $filename = $name.'.'.$ext;
    // $destination = $_SERVER['DOCUMENT_ROOT'].'/img_data/'.$filename;
    // $location =  $_FILES["files"]["tmp_name"];

    // move_uploaded_file($location,$destination);

// -----------------------------------------------------------------------------------------------------------

// $boardEditor = trim($_SERVER['DOCUMENT_ROOT']).'/img_data/';

// $error = $_FILES["files"]['error'];
// $orgFile = $_FILES["files"]['name'];
// $extend = strtolower(array_pop(explode('.', $orgFile)));

// $bSuccessUpload = is_uploaded_file($_FILES['files']['tmp_name']);

// if ( trim($_SERVER['REQUEST_METHOD']) == 'POST' && $bSuccessUpload ) {

//     $chagename = str_replace(".{$extend}", '', trim($orgFile));
//     $filename = md5(time().$chagename).'.'.$extend;

//     if ( !move_uploaded_file( $_FILES['files']['tmp_name'], "{$boardEditor}/{$filename}" ) ) {

//         echo json_encode(array(
//             'uploaded'=>'0',
//             'error'=>array('message'=>'첨부파일에 문제가 발생하였습니다.')
//         ));
//         exit;

//     } else {
//         $allowed_ext = array('jpg','jpeg','png','gif','bmp');
//         if( !in_array($extend, $allowed_ext) ) {
//             echo json_encode(array(
//                 'uploaded'=>'0',
//                 'error'=>array('message'=>'허용되지 않는 확장자입니다.')
//             ));
//             exit;
            
//         } else {

//             @chmod($fileSaveDir.'/'.$filename, 0777);

//             try {

//                 $DB->beginTransaction();

//                 $valueArray = array(
//                     'tcode'=>	$getBoard,
//                     'ecode'	=>	$getEcode,
//                     'locate'=>	'E',	//----[2021-06-07] 여기서 올라오는건 다 웹에디터 아닌가?
//                     'oname'	=>	$orgFile,
//                     'cname'	=>	$filename,
//                     'ftype'	=>	$_FILES["files"]['type'],
//                     'fsize'	=>	$_FILES["files"]['size']
//                 );

//                 //$setUrl = trim($_SERVER['DOCUMENT_ROOT']) . $webEditorUrl;
//                 $setUrl = $webEditorUrl;
//                 $getCode = $DB->insert("mpr_board_files", $valueArray);

//                 $DB->commit();
  
//                 $fullPathFile = $setUrl.$filename;

//                 echo json_encode(array(
//                     'uploaded'=>'1',
//                     'fileName'=>$filename,
//                     'url'=>$fullPathFile.'?code='. trim($DB->hexAesEncrypt(intval($getCode)))
//                 ));
//                 exit;

//             } catch(Exception $ex) {

//                 $DB->rollBack();

//                 echo json_encode(array(
//                     'uploaded'=>'0',
//                     'error'=>array('message'=>'첨부파일에 의심되는 문제가 발생하였습니다.')
//                 ));
//                 exit;

//             }
//         }
//     }
// }


// -----------------------------------------------------------------------------------------------------------


$boardEditor = trim($_SERVER['DOCUMENT_ROOT']).'/img_data/';

$getBoard = trim($_REQUEST['b']);
$webEditorUrl = '/data/'. trim($getBoard) .'/editor/';s
?>

<script>
    console.log('<?php echo $_FILES['files']['name']?>');
    console.log('<?php echo $webEditorUrl?>');
</script>

<?php
if ($_FILES['files']['name']) {
    echo $_FILES['files']['name'];
    if (!$_FILES['files']['error']) {
        $temp = explode(".", $_FILES["files"]["name"]);
        $newfilename = round(microtime(true)).'.'.end($temp);
        $destinationFilePath = $_SERVER['DOCUMENT_ROOT'].'/img_data/'.$newfilename;
        if (!move_uploaded_file($_FILES['files']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        }
        else{
            echo $destinationFilePath;
        }
    }
    else {
        echo  $message = '파일 에러 발생!: ' . $_FILES['files']['error'];
    }
}


// -----------------------------------------------------------------------------------------------------------


// if((($_FILES['files']['error'])==0)){
//         $file_tmp_name = $_FILES['files']['tmp_name'];
//         $file_name = $_FILES['files']['name'];
//         //한글 파일명이 깨지지 않도록 보호
//         $fileName = iconv("UTF-8", "EUC-KR",$_FILES['files']['name']);

//         //파일 저장 경로 - document_root //파일 다운 경로 - server_name  다운로드는 url로 가야함
//         $upload_folder =$_SERVER['DOCUMENT_ROOT'].'/img_data/';
        
//         move_uploaded_file($file_tmp_name, $upload_folder.$file_name);
        
//     }else{
//         $file_name=NULL;
//     }
?>