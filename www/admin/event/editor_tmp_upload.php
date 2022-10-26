<?php

    $API_KEY = $_REQUEST['API'];
    $code = $_REQUEST['code'];

    $webFilePath = '/img_tmp/event/'.trim($code)."/";
    $boardEditor = trim($_SERVER['DOCUMENT_ROOT']).'/img_tmp/event/'.trim($code);
    $uploads_dir = trim($boardEditor)."/";

    if ( !is_dir($boardEditor) ) {
        @mkdir($boardEditor, 0777, true);
        @chmod($boardEditor, 0777);
        
    }
    if ( !is_dir($uploads_dir) ) {
        @mkdir($uploads_dir, 0777, true);
        @chmod($uploads_dir, 0777);
        
    }

    $webFilePath = '/img_tmp/event/'.trim($code)."/".trim($API_KEY)."/";
    $boardEditor = trim($_SERVER['DOCUMENT_ROOT']).'/img_tmp/event/'.trim($code)."/".trim($API_KEY);
    $uploads_dir = trim($boardEditor)."/";

    if ( !is_dir($boardEditor) ) {
        @mkdir($boardEditor, 0777, true);
        @chmod($boardEditor, 0777);
    }
    if ( !is_dir($uploads_dir) ) {
        @mkdir($uploads_dir, 0777, true);
        @chmod($uploads_dir, 0777);
    }


    $error = $_FILES["files"]['error'];
    $orgFile = $_FILES["files"]['name'];
    $extend = strtolower(array_pop(explode('.', $orgFile)));



    $date = date("Ymd",time());

    $chagename = str_replace(".{$extend}", '', trim($orgFile));
    $filename = $date."_".md5(time().$chagename).'.'.$extend;

    if ($_FILES['files']['name']) {
        if (!$_FILES['files']['error']) {
            $temp = explode(".", $_FILES["files"]["name"]);
            
            if (!move_uploaded_file($_FILES['files']['tmp_name'], "{$uploads_dir}/{$filename}")) {
                echo json_encode(array(
                    'uploaded'=>'0',
                    'error'=>array('message'=>'첨부파일에 문제가 발생하였습니다.')
                ));
                exit;
            }else{
                $allowed_ext = array('jpg','jpeg','png','gif','bmp');
                if( !in_array($extend, $allowed_ext) ) {
                    echo json_encode(array(
                        'uploaded'=>'0',
                        'error'=>array('message'=>'허용되지 않는 확장자입니다.')
                    ));
                    exit;
                    
                }else{

                    $webFilePath = $webFilePath.$filename;
                    echo json_encode(array(
                        'uploaded'=>'1',
                        'fileName'=>$filename,
                        'url'=>$webFilePath,
                        'orgFile'=>$orgFile
                    ));
                    exit;  
                }
            }
        }
        else {
            echo  $message = '파일 에러 발생!: ' . $_FILES['files']['error'];
        }
    }


?>