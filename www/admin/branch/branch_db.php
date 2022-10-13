<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/common.top.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/config.php";
    
    $mode = $_REQUEST['mode'];
    $brName = $_REQUEST['brName'];
    $brCode = $_REQUEST['brCode'];
    $brPost = $_REQUEST['brPost'];
    $brAddr = $_REQUEST['brAddr'];
    $brRef = $_REQUEST['brRef'];
    $brTel = $_REQUEST['brTel'];
    $brMail = $_REQUEST['brMail'];
    $nowPageCode = $_REQUEST['nowPageCode'];
    

    if($mode == "register"){
        if(trim($brPost)){
            $SQL = 
            "INSERT INTO mpr_branch 
                (user_id, br_code, br_name, br_post, br_addr, br_addr_etc, br_tel, user_email, reg_date, chg_date, del_yn)
            VALUES
                ('snees', '{$brCode}', '{$brName}', {$brPost}, '{$brAddr}', '{$brRef}', '{$brTel}' , '{$brMail}', now(), now(), 'N');";
        }else{
            $SQL = 
            "INSERT INTO mpr_branch 
                (user_id, br_code, br_name, br_tel, user_email, reg_date, chg_date, del_yn)
            VALUES 
                ('snees', '{$brCode}', '{$brName}', '{$brTel}' ,'{$brMail}', now(), now(), 'N');";
        }

        $statement = $DB -> query($SQL);

    }else if($mode == "update"){
        if(trim($brPost)){

            $Up_SQL = 
            "UPDATE 
                mpr_branch 
            SET 
                user_id = 'snees', 
                br_code = '{$brCode}', 
                br_name = '{$brName}', 
                br_post = {$brPost}, 
                br_addr = '{$brAddr}' , 
                br_addr_etc = '{$brRef}' , 
                br_tel = '{$brTel}', 
                user_email = '{$brMail}', 
                chg_date = now()
            WHERE 
                br_code = '{$nowPageCode}'";
        }else{
            $Up_SQL = 
            "UPDATE 
                mpr_branch 
            SET 
                user_id = 'snees',
                br_code = '{$brCode}', 
                br_name = '{$brName}' , 
                br_tel = '{$brTel}', 
                user_email = '{$brMail}', 
                chg_date = now()
            WHERE 
                br_code = '{$nowPageCode}'";
        }

        $statement = $DB -> query($Up_SQL);
    }

    if($alert_msg == ""){
        $arrayData = array('brName'=>trim($brName), 'brCode'=>trim($brCode), 'brPost'=>trim($brPost), 'brAddr'=>trim($brAddr), 'brRef'=>trim($brRef), 'brTel'=>trim($brTel), 'brMail'=>trim($brMail));
        
    }else{
        $arrayData = array('alertMsg'=>trim($alert_msg));
    }
    // echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
?>