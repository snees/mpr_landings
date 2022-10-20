<?php
header("Content-Type: text/html; charset=utf-8");
header("Content-Encoding: utf-8");
date_default_timezone_set("Asia/Seoul");

if(count($argv)==2) {
    $arg = $argv[1];
    
    if($arg != 'Y'){
        exit;
    }

    //clients data 조회
    $sql  = " select * from mpr_event where isdel = 'N' and isuse ='Y' and left(event_cd,1)='M' ";
    $rs = db_clients($sql);
  
    if(count($rs) > 0 ){
        //landing 업데이트
        $result = db_landings($rs);
        echo $result;
    }

}else {
    echo "ex) php sync_date.php Y/N";
}

//clients DB
function db_clients($sql){
    $cnt=0;
    $connect = mysqli_connect('116.120.59.126', 'f5_mprclients', 'ffive1235', 'f5_mprclients') or die('연결 실패 mc: ' . mysqli_error());;
    
    mysqli_query($connect, "set names utf8;");

    $result = mysqli_query($connect, $sql);
    for($i=0; $row=mysqli_fetch_array($result); $i++){
        $result_array[] = $row;
    }
    
    mysqli_close($connect);

    return $result_array;
}
//landings DB
function db_landings($rs){
    
    if(count($rs) > 0 ){
    
        $now = date("Y-m-d");
        $str_now = strtotime($now);
        $connect_ld = mysqli_connect('localhost', 'fs_landings', 'ffive1235', 'fs_landings') or  die('연결 실패 ld: ' . mysqli_error());
        mysqli_query($connect_ld, "set names utf8;");
        
    
        for($i=0; $i < count($rs) ; $i++){

            //data exist check
            $sql  = " select count(*) as cnt from mpr_event where ev_code = '{$rs[$i]['event_cd']}' and del_yn = 'N' ";
            $cnt = mysqli_fetch_row(mysqli_query($connect_ld, $sql));
            
            if($cnt[0] > 0){

                if($rs[$i]['expose_always'] == 'Y'){
                    $ev_stat = "Y";
                }else {
                    if($rs[$i]['expose_from'] > $str_now){
                        $ev_stat = "W";
                    }else if($rs[$i]['expose_from'] <= $str_now && $str_now <= $rs[$i]['expose_to']){
                        $ev_stat = "Y";
                    }else{
                        $ev_stat = "N";
                    }
                }

                //data update
                $sql  = " update mpr_event 
                            set ev_start = '{$rs[$i]['expose_from']}', 
                                ev_end = '{$rs[$i]['expose_to']}',  
                                ev_always = '{$rs[$i]['expose_always']}',
                                ev_stat = '{$ev_stat}'
                        where  ev_code = '{$rs[$i]['event_cd']}' ";
                if(mysqli_query($connect_ld, $sql)){
                    echo "updated ".$rs[$i]['event_cd']." ".$rs[$i]['expose_from']." ".$rs[$i]['expose_to']." ".$rs[$i]['expose_always']."\n";                    
                }else{
                    echo "error : ".$sql."\n".mysqli_error($conn)."\n";
                }        
            }
    
        }
        
        mysqli_commit($connect_ld);
        mysqli_close($connect_ld);
        return "OK!";
    }
}

?>

