<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    $id = $_POST["id"];
    $pw = base64_encode($_POST["pwd"]);
    $name = $_POST["name"];
    $nick = $_POST["nickName"];
    $email = $_POST["email"];
    $phone = $_POST["phoneNum"];
    $etcNum = $_POST["etcNum"];
    $level = $_POST['level'];
    $apprve= $_POST['apprve'];
    $sql="insert into mpr_member(user_id,user_password,user_lv,user_nm,user_nick,user_mobile,user_phone,user_email,apprve,reg_date) values('$id', '$pw','$level','$name','$nick','$phone','$etcNum','$email','$apprve',now())";
    $result = $DB->query($sql);
    echo "<script> alert('회원등록 완료');
            location.replace('/admin/member/');</script>";

?>