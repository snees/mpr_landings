<?php 
    //include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/common.top.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/config.php";

    $code = $_REQUEST['code'];

    $DEL_SQL = "UPDATE mpr_branch SET del_yn='Y' WHERE br_code = '{$code}'"; 
    //echo $DEL_SQL;
    if ( $DB -> query($DEL_SQL) ) {
        echo 'OK';
    } else {
        echo 'No';
    }
    exit;

?>