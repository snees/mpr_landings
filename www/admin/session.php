<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    if(!$_SESSION['userId'])
    {
        echo "<script>location.replace('/admin/login/');</script>";
        echo "<script>console.log('457".$_SESSION['userId']."');</script>";
    }
    // else
    // {
    //     echo "<script>location.replace('/admin/member/');</script>";
    // }
?>