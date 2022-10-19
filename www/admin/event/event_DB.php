<?php 
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/common.top.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/config.php";

    $mode = $_REQUEST['mode'];
    
    $brCode = $_REQUEST['brCode'];
    $evCode = $_REQUEST['evCode'];
    $evKey = $_REQUEST['evKey'];
    $evType = $_REQUEST['evType'];
    $evURL = $_REQUEST['evURL'];
    $evSubject = $_REQUEST['evSubject'];
    $ev_top_content_pc = $_REQUEST['ev_top_content_pc'];
    $ev_top_content_mo = $_REQUEST['ev_top_content_mo'];
    $evName_yn = $_REQUEST['evName_yn'];
    $evTel_yn = $_REQUEST['evTel_yn'];
    $evSex_yn = $_REQUEST['evSex_yn'];
    $evAge_yn = $_REQUEST['evAge_yn'];
    $evComment_yn = $_REQUEST['evComment_yn'];
    $evBrith_yn = $_REQUEST['evBrith_yn'];
    $evRec_person_yn = $_REQUEST['evRec_person_yn'];
    $evCounsel_time_yn = $_REQUEST['evCounsel_time_yn'];
    $ev_bottom_content_pc = $_REQUEST['ev_bottom_content_pc'];
    $ev_bottom_content_mo = $_REQUEST['ev_bottom_content_mo'];
    $evAlways = $_REQUEST['evAlways'];
    $evStart = $_REQUEST['evStart'];
    $evEnd = $_REQUEST['evEnd'];
    $evStat = $_REQUEST['evStat'];
    $regID = $_REQUEST['regID'];
    $idx = $_REQUEST['idx'];
    $imgFileName = $_REQUEST['imgFileName'];

    if($mode != "delete" && count($imgFileName) != 0){
        $orgfileName = array();
        $orgfileName = array_keys($imgFileName);

        $newfileName = array();
        $newfileName = array_values($imgFileName);
    }

    /* img_tmp -> img_data 복사 */
    function fileCopy($tmp, $upload, $imgFileName, $isCopy){
        if(count($imgFileName)!=0){
            if (is_dir($tmp)){                        
                if ($dir = opendir($tmp)){
                    while (($file = readdir($dir)) !== false){   
                        if(($file !== ".") && ($file !== "..") && ($file !== "")) {
                            if(is_dir($tmp."/".$file)){
                                fileCopy($tmp."/".$file, $upload.$file, $imgFileName, $isCopy);
                            }else{
                                if(in_array($file, $imgFileName)){
                                    if(!file_exists($upload.$file)){
                                        if(copy($tmp."/".$file, $upload.$file)){
                                            $isCopy = true;
                                            return $isCopy;
                                        }
                                    }else{
                                        $isCopy = true;
                                        return $isCopy;
                                    }
                                }
                            }
                        }
                    }                                           
                    closedir($dir);
                }                                             
            }
        }    
    }

    /* 이미지 저장 경로 */
    $tmp_dir = '/home/fs_landings/www/img_tmp/event/'.trim($brCode)."/".trim($evKey);
    $isCopy = false;

    if( trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc)){

        $webFilePath = '/img_data/event/'.trim($brCode)."/";
        $boardEditor = trim($_SERVER['DOCUMENT_ROOT']).'/img_data/event/'.trim($brCode);
        $uploads_dir = trim($boardEditor)."/";

        if ( !is_dir($boardEditor) ) {
            @mkdir($boardEditor, 0777, true);
            @chmod($boardEditor, 0777);
            
        }
        if ( !is_dir($uploads_dir) ) {
            @mkdir($uploads_dir, 0777, true);
            @chmod($uploads_dir, 0777);
            
        }
        
        $webFilePath = trim($webFilePath).trim($evKey)."/";
        $boardEditor = trim($boardEditor)."/".trim($evKey);
        $uploads_dir = trim($boardEditor)."/";

        if ( !is_dir($boardEditor) ) {
            @mkdir($boardEditor, 0777, true);
            @chmod($boardEditor, 0777);
        }
        if ( !is_dir($uploads_dir) ) {
            @mkdir($uploads_dir, 0777, true);
            @chmod($uploads_dir, 0777);
        }
    }





    /* 신규 이벤트 등록 */
    if($mode == "register"){
        $SQL = 
        "INSERT INTO mpr_event
            (br_code, ev_code, ev_key, ev_type, ev_url, ev_subject, 
            ev_top_content_pc, ev_top_content_mo ,ev_name_yn, ev_tel_req, 
            ev_tel_yn, ev_sex_yn, ev_age_yn, ev_comment_yn, ev_birthday_yn, 
            ev_rec_person_yn, ev_counsel_time_yn, ev_bottom_content_pc , 
            ev_bottom_content_mo , ev_always , ev_start , ev_end , ev_stat, reg_id, reg_date, chg_date, del_yn) 
        VALUES 
            ('{$brCode}', '{$evCode}', '{$evKey}' , '{$evType}', '{$evURL}' ,'{$evSubject}',
            '{$ev_top_content_pc}','{$ev_top_content_mo}' ,'{$evName_yn}', 'Y', 
            '{$evTel_yn}', '{$evSex_yn}', '{$evAge_yn}', '{$evComment_yn}', '{$evBrith_yn}', 
            '{$evRec_person_yn}', '{$evCounsel_time_yn}', '{$ev_bottom_content_pc}',
            '{$ev_bottom_content_mo}' , '{$evAlways}' , '{$evStart}', '{$evEnd}', '{$evStat}', '{$regID}', now(), now(), 'N');";


       


        /* 이미지 파일 tmp -> data 옮기기 */
        if( trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc)){
            
            $tmp_dir = '/home/fs_landings/www/img_tmp/event/'.trim($brCode)."/".trim($evKey);

            if(fileCopy($tmp_dir, $uploads_dir, $imgFileName, $isCopy)){
                $AI_SQL = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'fs_landings' AND TABLE_NAME = 'mpr_event';";
                $AI_res = $DB -> query($AI_SQL);
                $ev_idx = $AI_res[0]['AUTO_INCREMENT'];

                $imgSize = filesize($tmp."/".$file)/1024;
                $imgSize = floor($imgSize);

                for($i=0; $i<count($imgFileName); $i++){
                    $file_SQL = 
                    "INSERT INTO mpr_files 
                        (ev_idx, edt_type, og_name, ch_name, file_size, reg_date, chg_date, del_yn)
                    VALUES ({$ev_idx}, '{$evType}', '{$orgfileName[$i]}', '{$newfileName[$i]}', {$imgSize}, now(), now(), 'N')";

                    $file_DB = $DB->query($file_SQL);
                }
            }
            
        }

        
        
        if( $DB->query($SQL) ){
            $strSQL = "UPDATE mpr_seq SET code_seq	= code_seq + 1 ";
            $seq = $DB->query($strSQL);

            echo "OK";
        }else{
            echo "NO";
        }
    }

    /* 이벤트 수정 */
    else if($mode == "update"){
        $UP_SQL = 
        "UPDATE 
            mpr_event 
        SET 
            br_code = '{$brCode}',
            ev_code = '{$evCode}', 
            ev_key = '{$evKey}', 
            ev_type = '{$evType}', 
            ev_url = '{$evURL}', 
            ev_subject = '{$evSubject}', 
            ev_top_content_pc = '{$ev_top_content_pc}', 
            ev_top_content_mo = '{$ev_top_content_mo}' ,
            ev_name_yn = '{$evName_yn}', 
            ev_tel_yn = '{$evTel_yn}', 
            ev_sex_yn = '{$evSex_yn}', 
            ev_age_yn = '{$evAge_yn}', 
            ev_comment_yn = '{$evComment_yn}', 
            ev_birthday_yn = '{$evBrith_yn}', 
            ev_rec_person_yn = '{$evRec_person_yn}', 
            ev_counsel_time_yn = '{$evCounsel_time_yn}', 
            ev_bottom_content_pc =  '{$ev_bottom_content_pc}', 
            ev_bottom_content_mo = '{$ev_bottom_content_mo}',
            ev_always = '{$evAlways}',
            ev_start = '{$evStart}', 
            ev_end = '{$evEnd}', 
            ev_stat = '{$evStat}', 
            chg_id = '{$regID}', 
            chg_date = now()
        WHERE
            idx = {$idx};";


        /* 이미지 파일 tmp -> data 옮기기 */
        if( trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc) || trim($ev_top_content_pc)){

            if(fileCopy($tmp_dir, $uploads_dir, $imgFileName, $isCopy)){

                $imgSize = filesize($tmp."/".$file)/1024;
                $imgSize = floor($imgSize);

                $file_sql = "SELECT ch_name FROM mpr_files WHERE ev_idx = {$idx}";
                $res = $DB->query($file_sql);
                foreach($res as $row){
                    $isEx = false;
                    for($i=0; $i<count($imgFileName); $i++){
                        if($row['ch_name'] == $newfileName[$i]){
                            echo $row['ch_name'];
                            $isEx = true;
                            break;
                        }
                    }
                }

                if(!$isEx){
                    for($i=0; $i<count($imgFileName); $i++){
                        $file_SQL = 
                        "INSERT INTO mpr_files 
                            (ev_idx, edt_type, og_name, ch_name, file_size, reg_date, chg_date, del_yn)
                        VALUES ({$idx}, '{$evType}', '{$orgfileName[$i]}', '{$newfileName[$i]}', {$imgSize}, now(), now(), 'N')";
                        
                        $file_DB = $DB->query($file_SQL);
                    }
                }
            }
        }
        
        if( $DB->query($UP_SQL) ){
            echo "OK";
        }else{
            echo "NO";
        }
    }

    /* 이벤트 삭제 */
    else if($mode == "delete"){
        $DEL_SQL = "UPDATE mpr_event SET del_yn = 'Y' WHERE idx = $idx"; 
        if( $DB -> query($DEL_SQL) ){
            $del_file = "UPDATE mpr_files SET del_yn = 'Y' WHERE ev_idx = {$idx}";
            if($DB->query($del_file)){
                echo "OK";
            }else{
                echo $del_file;
                echo "NO";
            }
        }else{
            echo "NO";
        }
    }
?>