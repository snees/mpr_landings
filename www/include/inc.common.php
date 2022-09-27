<?php
include_once dirname($_SERVER['DOCUMENT_ROOT'])."/env.setting.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/class/PDO.class.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/class/Bases.class.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/class/sms.class.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/class/coin.class.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/class/Rsa.class.php";

//자동로그인 처리

if ($_SESSION['sess_usids'] !="") {
    if (array_key_exists(md5('ck_id'), $_COOKIE)){
        $temp_id = base64_decode($_COOKIE[$cookie]);
    }

    if ($temp_id) {

        $temp_id = substr(preg_replace("/[^a-zA-Z0-9_]*/", "", $temp_id), 0, 20);
        // 최고관리자는 자동로그인 금지
        //if (strtolower($temp_id) !== strtolower($config['cf_admin'])) {
            $strSQL = " select * from mpr_members where uids=:uid ";
            $getData = $DB->row($strSQL, array('uid'=>$temp_id));
            $getPass    = $Rsa->decrypt($getData['upass']);
            if($getPass){
                $key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['HTTP_USER_AGENT'] . $getPass);
                // 쿠키에 저장된 키와 같다면
                if (array_key_exists(md5('ck_auto'), $_COOKIE)){
                    $tmp_key = base64_decode($_COOKIE[$tmp_key]);
                }

                if ($tmp_key === $key && $tmp_key) {
                    // 세션에 회원아이디를 저장
                    
                    $_SESSION['sess_usidx'] = trim($getData['uidx']);
                    $_SESSION['sess_usids'] = trim($getData['uids']);
                    $_SESSION['sess_uname'] = trim($getData['uname']);
                    $_SESSION['sess_urank'] = trim($getData['ismng'])=='Y'?'':'';
                    $_SESSION['sess_email'] = trim($getData['email']);
                    $_SESSION['sess_group'] = trim($getData['ismng'])=='Y'?'MNG':'GNR';     //---- 최고관리자, 관리자, 매니저, 일반
                    $_SESSION['sess_level'] = trim($getData['ismng'])=='Y'?500:100;         //---- 최고관리자를 어케 해줘야 하나..ㅡㅡㅋ

                    
                    //sendMsg
                    $cfgSQL = " select * from mpr_config ";
                    $cfgData = $DB->row($cfgSQL);
                    $sendMsg = '';
                    if ( trim($cfgData['islog'])=='Y' ) {
                        //$joinMsg = trim($cfgData['joinmsg']);
                        $sendMsg = str_replace('{이름}', trim($getData['uname']), trim($cfgData['logmsg']));
                        $sendMsg = str_replace('{아이디}', trim($getData['uids']), trim($sendMsg));
                        $sendMsg = str_replace('{일시}', date('Y-m-d H:i', time()), trim($sendMsg));
                        $sendMsg = str_replace('{아이피}', trim($_SERVER['REMOTE_ADDR']), trim($sendMsg));
            
                        $SMS->cfgSend($sendMsg, $getData['phone']);
                    }


                    // 페이지를 재실행
                    echo "<script type='text/javascript'> window.location.reload(); </script>";
                    exit;
                    
                }
            }
            // $getData 배열변수 해제
            unset($getData);
        //}
    }
}
//자동로그인 처리
?>
