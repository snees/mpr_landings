<?php 
include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";

$idx = $_REQUEST['idx'];

$DEL_SQL = "UPDATE mpr_event SET del_yn = 'Y' WHERE idx = $idx"; 
$statement = $DB -> query($DEL_SQL);

?>