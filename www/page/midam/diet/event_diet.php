<?php
header("Content-Type: text/html; charset=utf-8");
header("Content-Encoding: utf-8");
date_default_timezone_set("Asia/Seoul");


    /* 
    name : name,
    phone : phone,
    age : age
    */

    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    // $age   = '';
    $cmemo = '나의 고민은? : ' . $_POST['qlistA'] . '\n';
    $cmemo .= '목표감량 kg은? : ' . $_POST['qlistB'] . '\n';
    $cmemo .= '목표 개월은? : ' . $_POST['qlistC'];
    $key   = $_POST['key'];
    $today = date("Y-m-d");

    $rcdate = $today;
    

    /// -----------------------Mysql 연결-----------------------
    /// mpr_event, mpr_custlist 조회, 등록만 가능

    $system_connect = mysqli_connect('116.120.59.126', 'f5_mprclients', 'ffive1235', 'f5_mprclients');
    if (!$system_connect) {
    die('연결 실패: ' . mysqli_error());
    }
    mysqli_query($system_connect, "set names utf8;");
    /// -----------------------Mysql 연결----------------------

    $sql  = " select * from mpr_event where event_key = '{$key}' ";
    $result = @mysqli_fetch_assoc(mysqli_query($system_connect, $sql));

    /* 이벤트 기간 체크 */
    if(trim($result['expose_from']) != "0000-00-00" && trim($result['expose_to']) != "0000-00-00 "){
        $str_now = strtotime($today);
        
        $str_from = strtotime($result['expose_from']);
        $str_to = strtotime($result['expose_to']);
        if($str_from != $str_now || $str_to != $str_now){
            if( $str_from > $str_now){
                $data = array('result'=>false, 'message'=>'이벤트 기간이 아닙니다! ['.$result['expose_from']." ~ ".$result['expose_from']."]");
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                exit;
            }        
            
            if( $str_to < $str_now){
                $data = array('result'=>false, 'message'=>'이벤트 기간이 아닙니다. ['.$result['expose_from']." ~ ".$result['expose_from']."]");
                echo json_encode($data, JSON_UNESCAPED_UNICODE);    
                exit;
            }
        }
    }

    //brand : 병원명
    //event_name : 이벤트명
    //cname : 이름
    //chp : 연락처
    //url : event_url

    $intSql  = " insert into mpr_custlist (rcdate, brand, event_name, cname, chp, age, url, user_ip, cmemo)";
    $intSql .= " values ('{$rcdate}', '{$result['cust_nm']}', '{$result['event_nm']}', '{$name}', '{$phone}', '{$age}', '{$result['event_url']}', '{$_SERVER['REMOTE_ADDR']}', '{$cmemo}') ";

    $client_rs = mysqli_query($system_connect, $intSql);  

    $return['result'] = $client_rs;    
    
    echo json_encode($return, JSON_UNESCAPED_UNICODE);

?>