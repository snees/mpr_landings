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

    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/inc/mailer.lib.php";
    $id = $_POST["id"];
    $pw = $DB->hexAesEncrypt($_POST["pwd"], getRandStr());
    $name = $_POST["name"];
    $nick = $_POST["nickName"];
    $email = $_POST["email"];
    $phone = $_POST["phoneNum"];
    $etcNum = $_POST["etcNum"];
    $content= "아이디".$id."님이 회원가입을 진행하였습니다. 확인 후 승인 부탁드립니다.";

    $sql="insert into mpr_member(user_id,user_password,user_lv,user_nm,user_nick,user_mobile,user_phone,user_email,reg_date) values('$id', '$pw','100','$name','$nick','$phone','$etcNum','$email',now())";
    $result = $DB->query($sql);

    mailer("mpr","mprkorea@naver.com","eoehd1802@naver.com","회원가입안내", $content);
    echo "<script> alert('회원가입 완료');
            location.replace('/admin/login/');</script>";
    
?>