<?php 
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";


    $SQL = "SELECT * FROM mpr_event";
    $res = $DB -> query($SQL);

    foreach($res as $row){
        $now = date("Y-m-d");
        $str_now = strtotime($now);
        $str_start = strtotime($row['ev_start']);
        $str_end = strtotime($row['ev_end']);

        if($row['ev_always'] == "Y"){
            if($str_start > $str_now){
                $ev_stat = "W";
            }else{
                $ev_stat = "Y";
            }
        }else{
            if($str_start > $str_now){
                $ev_stat = "W";
            }else if(($str_start <= $str_now) && ($str_now <= $str_end)){
                $ev_stat = "Y";
            }else if($str_end < $str_now){
                $ev_stat = "N";
            }
        }

        $UP_SQL = "UPDATE mpr_event SET ev_stat = '{$ev_stat}' WHERE idx = {$row['idx']}";
        $statement = $DB -> query($UP_SQL);
    }

?>


<!-- 0 0 * * * /admin/event/ev_stat_update.php -->