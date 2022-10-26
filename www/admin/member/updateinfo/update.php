<?php
    function getRandStr($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    };
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    $id = $_POST["id"];
    $pw=$_POST['pw'];
    $nick = $_POST["nick"];
    $email = $_POST["email"];
    $phone = $_POST["phonenum"];
    $etcNum = $_POST["etcnum"];
    $level = $_POST['level'];
    $apprve= $_POST['apprve'];

    $tmp_sql="select*from mpr_member where user_id = '{$id}'";
    $tmp =  $DB->row($tmp_sql);

    if($pw==$tmp['user_password'])
    {
        $pwd=$tmp['user_password'];
    }
    else
    {
        $pwd=$DB->hexAesEncrypt($pw,getRandStr());    
    }

    if(!$level and !$apprve)
    {
        $level = $tmp['user_lv'];
        $apprve= $tmp['apprve'];
    }
    $sql="update mpr_member set user_password='{$pwd}', user_nick='{$nick}', user_email='{$email}', user_mobile='{$phone}', user_phone='{$etcNum}', user_lv='{$level}', apprve='{$apprve}' where user_id= '{$id}'";
    $result = $DB->query($sql);
?>