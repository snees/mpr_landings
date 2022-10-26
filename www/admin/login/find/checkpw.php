<?php
    function getRandStr($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/inc/mailer.lib.php";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $id = $_POST["id"];
    $tmp=getRandStr();
    $content="임시 비밀번호는".$tmp."입니다. 해당링크로 가서 비밀번호를 변경해주세요<a target='_self' href='http://landings.mprkorea.com/admin/login/'>바로가기</a>";
    $pw=$DB->hexAesEncrypt($tmp,getRandStr());
    $sql = "select user_password from mpr_member where user_email = '{$email}' and user_nm = '{$name}' and user_id='{$id}'";
    $result = $DB->row($sql);
    if(!$result['user_password']){
        $tmpnum=0;
        }
    else {
        $sql_update="update mpr_member set user_password='{$pw}' where user_email = '{$email}' and user_nm = '{$name}' and user_id='{$id}'";
        $password=$DB->query($sql_update);
        mailer("mpr","mprkorea@naver.com",$email,"임시비밀번호발급",$content,"1");
    }
?>