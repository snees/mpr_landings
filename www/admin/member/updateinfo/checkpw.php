<?php
    function getRandStr($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    session_start();
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    
    $tmp = 0;
    $pw = $DB->hexAesEncrypt($_POST["pw"],getRandStr());
    $sql="select user_password from mpr_member where user_id = '{$_SESSION['userId']}'";
    $result = $DB->row($sql);
    if($result['user_password']==$pw)
    {
        $tmp=1;
        echo $tmp;
    }
    else
    {
        $tmp=0;
        echo $tmp;
    }
?>