<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    session_start();
    session_destroy();
    echo "<script>location.replace('/admin/login/');</script>";
?>
