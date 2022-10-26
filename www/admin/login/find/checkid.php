<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $id = $_POST["id"];
    $sql = "select user_id from mpr_member where user_email = '{$email}' and user_nm = '{$name}'";
    $result = $DB->row($sql);
    
    if(!$result['user_id']){
        echo "이름 혹은 ID를 확인하세요.";
    }
    else {
        $result['user_id']=preg_replace('/.(?=.$)/u', '*', $result['user_id']);
        echo "아이디는".$result['user_id']."입니다.";
    }
?>