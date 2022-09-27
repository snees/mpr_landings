<?php
$return = array();
$cate = $_POST['eventName'];
$from_number = $_POST['from'];
$write_table = 'mpr_custlist';


header("Content-Type: text/html; charset=utf-8");
header("Content-Encoding: utf-8");
date_default_timezone_set("Asia/Seoul");

// S :  -----------------------Mysql 연결-----------------------
/// mpr_event, mpr_custlist 조회, 등록만 가능
$conn = mysqli_connect('116.120.59.126', 'f5_mprclients', 'ffive1235', 'f5_mprclients');

if (!$conn) {
    die('연결 실패: ' . mysqli_error());
}

mysqli_query($conn, "set names utf8;");
// E : -----------------------Mysql 연결----------------------

$sql = " select * from {$write_table} where event_name = '{$cate}' and del_yn = 'N' order by rgdate desc limit {$from_number}, 5; ";
$sqlCnt = " select * from {$write_table} ";

$result = mysqli_query($conn, $sql);
$cntRS = mysqli_query($conn, $sqlCnt);
$count = mysqli_num_rows($cntRS);

if($from_number > $count){
    $return['limit'] = 'limit';
}
elseif($from_number >= 30){
    $return['limit'] = 'limit';
}
else {
    for($i=0; $row=@mysqli_fetch_assoc($result); $i++) {
        $return['result'][$i] = $row;
    }
}

$return['fromnum'] = $from_number;
$return['cnt'] = $count;

echo json_encode($return);
?>
