<?php
    session_start();
    session_destroy();
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    $id = $_POST["id"];
    $sql = "update mpr_member set del_yn = 'Y' where user_id='{$id}'";
    $result=$DB->query($sql);
?>