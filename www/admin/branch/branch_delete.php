<?php 
include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";

$code = $_REQUEST['code'];

$DEL_SQL = "UPDATE mpr_branch SET del_yn='Y' WHERE br_code = '{$code}'"; 
$statement = $DB -> query($DEL_SQL);

?>