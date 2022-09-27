<?php
class SMS {
    //private $from = '0517499476';
    private $fromNo = '051-749-9476';

    public function smsSend() {
        global $_POST;
        global $DB;

        $message = $_POST['message'];
	    $noList = $_POST['noList'];
        
        for($i=0; $i<count($noList); $i++){
            if ( $noList[$i] ) {
                $getPhone = $noList[$i];
                $toPhone = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $getPhone);
                $from = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $this->fromNo);
                //$to = "82".substr($phone,1);
                
                $strSQL = "select MAX(sms_cnt) + 1 as cnt from mpr_sms_cnt";
                $message_id = $DB->single($strSQL);//---- single

                /* if(!$row){
                    $row['cnt'] = 1000;
                }
                $message_id = $row['cnt']; */
            
                //문자메세지
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://rest.surem.com/sms/v1/json",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\n    \"usercode\": \"mpr2017\",\n    \"deptcode\": \"MM-1K8-JU\",\n    \"messages\": [\n        {\n        \t\"message_id\":\"$message_id\",\n            \"to\": \"$toPhone\"\n        }\n    ],\n    \"text\": \"$message\",\n    \"from\": \"$from\"\n}",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "cache-control: no-cache"
                    ),
                ));
            
                $response = curl_exec($curl);
                $response = json_decode($response, true);
                curl_close($curl);
                
                if ($response['code'] != 200) {
                    echo "cURL Error #:" . $response['code']." ".$response['message'];

                    $strSQL = "insert into mpr_sms_log set fromNo = '{$this->fromNo}', toNo = '{$getPhone}', message = '({$response['code']}){$response['message']}', cdate = now(), sendYn = 'N'";
                    $row = $DB->query($strSQL);
                    return false;
                
                } else {
                    $strSQL = "update mpr_sms_cnt set sms_cnt = sms_cnt + 1";
                    $row = $DB->query($strSQL);
                    $strSQL = "insert into mpr_sms_log set fromNo = '{$this->fromNo}', toNo = '{$getPhone}', message = '{$message}', cdate = now(), sendYn = 'Y'";            
                    $row = $DB->query($strSQL);
                    return true;
                
                }
            }
		}
	}

    public function cfgSend($msg, $phone) {
        global $_POST;

        $_POST['message']   = trim($msg);
        $_POST['noList']    = array(trim($phone));//----전화번호를 하나의 배열로 만들어준다.

        $this->smsSend();
    }

}


$SMS = new SMS();
?>