<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    session_start();

    $id = $_POST["id"];
    if($_SESSION['lvl']!=300){
        session_destroy();
    }

    /* 파일 삭제 함수 */
    function rmdirAll($dir){
        if (!file_exists($dir)) {
            return true;
        }
        $files = opendir($dir);
        if($files){
            while(false !== ($file = readdir($files))){
                if(is_dir($dir."/".$file)){
                    if( ($file != ".") && ($file != "..") ){
                        rmdirAll($dir."/".$file);
                    }
                }else{
                    unlink($dir."/".$file);
                }
            }
            closedir($files);
        }
        rmdir($dir);
        return true;
    }

    /* 이미지 파일 삭제 */
    $brSQL = "SELECT e.br_code as brCode, e.ev_key as evKey , e.idx as idx FROM mpr_event e LEFT JOIN mpr_branch b ON e.br_code = b.br_code WHERE b.user_id = '{$id}'";
    $res = $DB->query($brSQL);

    foreach($res as $row){
        $delete_img_url = '/home/fs_landings/www/img_data/event/'.trim($row['brCode'])."/".trim($row['evKey']);
        rmdirAll($delete_img_url);
        $fileDelSQL = "UPDATE mpr_files SET del_yn='Y' WHERE ev_idx={$row['idx']}";
        $statement = $DB->query($fileDelSQL);
    }

    $sql = "update mpr_member set del_yn = 'Y' where user_id='{$id}'";
    $result=$DB->query($sql);
    $sql2 = "UPDATE mpr_branch b LEFT JOIN mpr_event e ON e.br_code = b.br_code SET b.del_yn = 'Y', e.del_yn = 'Y' WHERE b.user_id='{$id}'";
    $result2=$DB->query($sql2);
    
    
?>