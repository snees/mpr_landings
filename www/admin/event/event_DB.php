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
    $ev_top_contetnt_pc = $_REQUEST['ev_top_contetnt_pc'];
    $ev_top_contetnt_mo = $_REQUEST['ev_top_contetnt_mo'];
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
            '{$ev_top_contetnt_pc}','{$ev_top_contetnt_mo}' ,'{$evName_yn}', 'Y', 
            '{$evTel_yn}', '{$evSex_yn}', '{$evAge_yn}', '{$evComment_yn}', '{$evBrith_yn}', 
            '{$evRec_person_yn}', '{$evCounsel_time_yn}', '{$ev_bottom_content_pc}',
            '{$ev_bottom_content_mo}' , '{$evAlways}' , '{$evStart}', '{$evEnd}', '{$evStat}', '{$regID}', now(), now(), 'N');";

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
            ev_top_content_pc = '{$ev_top_contetnt_pc}', 
            ev_top_content_mo = '{$ev_top_contetnt_mo}' ,
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
            echo "OK";
        }else{
            echo "NO";
        }
    }
?>