<?php
class COIN {
    /**
     * 코인박스에서 발행량 추가시 ...
     * $getPCode : 자체 발행 코인 index
     * $getCode : 자체 발행 코인 Code
     * $getQuantity : 발행액
     * $getDiscript : 발행 내용
     */
    function coinPlus ($getPCode, $getCode, $getQuantity, $getDiscript) {
        global $DB;

        $getQuantity = str_replace(',', '', $getQuantity);

        try {
            $DB->beginTransaction();

            $strSQL = " update mpr_coins set quantity=quantity+:quantity where idx=:idx and code=:code ";
            $DB->query($strSQL, array("quantity"=>$getQuantity, "idx"=>$getPCode, "code"=>$getCode));
        
            $DB->insert("mpr_coinhistory", array("pcode"=>$getPCode, "code"=>$getCode, "plus"=>$getQuantity, "discript"=>$getDiscript));
        
            $DB->commit();
        
            return true;
            //$Bases->gotoAlert('입력하신 내용을 저장하였습니다.', "./");
            exit;
        
        } catch(Exception $ex) {
        
            $DB->rollBack();
            
            //$Bases->gotoBack('네트워크 연결 장애로 인해 입력하신 내용을 저장하지 못하였습니다.');
            return false;
            exit;
        }
    }
    /**
     * 코인박스에서 회원에게 지급할때 ...
     * $getPCode : 자체 발행 코인 index
     * $getCode : 자체 발행 코인 Code
     * $getProvide : 지급액
     * $getDiscript : 지급 내용
     * $membCode : 회원 index , 지급 대상자 index
     * $membId : 회원 아이디 , 지급 대상자 아이디
     */
    function coinMinus ($getPCode, $getCode, $getProvide, $getDiscript, $membCode, $membId){
        global $DB, $Bases;

        try {
            $DB->beginTransaction();

            $isSQL = " select quantity from mpr_coins where idx=:idx and code=:code ";
            $setQuantity = $DB->single($isSQL, array("idx"=>$getPCode, "code"=>$getCode));

            if ( (intval($setQuantity) - floatval($getProvide)) <= 0 ) {
                $Bases->Alert("{$setQuantity}-{$getProvide} 보유 지급량이 충분하지 않습니다. 확인후에 다시 시도하여주세요.");
                return false;
                exit;

            } else {
                /**
                 * 발행량을 수정하지 않는다.
                 */
                /* $strSQL = " update mpr_coins set quantity=quantity-:quantity where idx=:idx and code=:code ";
                $DB->query($strSQL, array("quantity"=>$getProvide, "idx"=>$getPCode, "code"=>$getCode)); */
            
                $DB->insert("mpr_coinhistory", array("pcode"=>$getPCode, "code"=>$getCode, "minus"=>$getProvide, "discript"=>$getDiscript, "mbcode"=>$membCode, "mbids"=>$membId));
            
                $DB->commit();
            }
            return true;
            //$Bases->gotoAlert('입력하신 내용을 저장하였습니다.', "./");
            //exit;
        
        } catch(Exception $ex) {
        
            $DB->rollBack();

            return false;
            //$Bases->gotoBack('네트워크 연결 장애로 인해 입력하신 내용을 저장하지 못하였습니다.');
            //exit;
        }
    }
    function coinName() {
        global $_POST;
        global $DB;
        try {
            $DB->beginTransaction();
            
            $coinArr = $_POST['coinArr'];
            $listCnt = sizeof($coinArr);            

            if($listCnt > 0){

                for($i=0; $i<$listCnt; $i++){

                   $isSQL = " select count(*) as cnt from mpr_coin_names where shortNm =:shortNm and agency=:agency ";
                   $setQuantity = $DB->single($isSQL, array("shortNm"=>$coinArr[$i][1], "agency"=>$coinArr[$i][3]));

                   if($setQuantity == 0){

                       $strSQL = "insert into mpr_coin_names set agency = :agency, shortNm = :shortNm, KorNm = :KorNm, dpYn='Y', prio = :prio";                                               
                       $DB->query($strSQL, array("agency"=>$coinArr[$i][3], "shortNm"=>$coinArr[$i][1], "KorNm"=>$coinArr[$i][0], "prio"=>$coinArr[$i][2]));                    

                   }else{

                       $strSQL = "update mpr_coin_names set dpYn='Y', prio = :prio where agency = :agency and shortNm = :shortNm";                               
                       $DB->query($strSQL, array("prio"=>$coinArr[$i][2], "agency"=>$coinArr[$i][3], "shortNm"=>$coinArr[$i][1]));                      

                   }
                }
            }
            
            $DB->commit();
                                 
            return true;


        } catch(Exception $ex) {
        
            $DB->rollBack();

            return false;
            exit;
        }
              
    
    }

    function delName() {
        global $_POST;
        global $DB;
        try {
            $DB->beginTransaction();
            
            $agency = $_POST['agency'];
			$delCoinCd = $_POST['delCoinCd'];

            if($agency && $delCoinCd){

                $strSQL = "update mpr_coin_names set dpYn='N', prio = 0 where agency = :agency and shortNm = :shortNm";                               
                $DB->query($strSQL, array("agency"=>$agency, "shortNm"=>$delCoinCd));                      
            }
            
            $DB->commit();
                                    
            return true;


        } catch(Exception $ex) {
        
            $DB->rollBack();

            return false;
            exit;
        }  

    }

    /**
     * 사용법 $COIN->naverNewsResult('검색어', '정렬기준', 갯수);
     * print '<pre>';
     * print naverNewsResult('암호화폐', 'date', 20);
     * print naverNewsResult('가상화폐', 'date', 20);
     * print naverNewsResult('코인거래소', 'date', 20);
     * print '</pre>';
     */
    // 네이버 뉴스 검색 API
    // 참고 https://developers.naver.com/docs/search/news/
    // 사용법 naverSearchAPI(검색어, 정렬, 한페이지에 보여줄 개수, 검색 시작 위치);
    function naverNewsResult($query='', $sort='', $display=0, $start=0) {
    
        $api_url = "";
    
        $client_id = "AntkAKFn41rARegMDicf";
        $client_secret = "MvIddMya5G";
    
        // 요청 URL
        $api_url .= "https://openapi.naver.com/v1/search/news.json"; // 뉴스 검색 결과 json
        // $api_url .= "https://openapi.naver.com/v1/search/news.xml"; // 뉴스 검색 결과 xml
        
        // 검색어, 필수 입력
        $api_url .= "?query=".urlencode($query);
    
        // 정렬, sim (정확도순) or date(최신순). 없으면 default 값인 sim 으로 적용됨
        if($sort != "")
            $api_url .= "&sort=".$sort;
    
        // 검색 시작 위치, 없으면 기본값
        if($start > 0)
            $api_url .= "&start=".$start;
    
        // 한 페이지에 보여줄 개수, 없으면 기본값
        if($display > 0)
            $api_url .= "&display=".$display;
    
        $ch = curl_init();
        $ch_headers[] = "X-Naver-Client-Id: ".$client_id;
        $ch_headers[] = "X-Naver-Client-Secret: ".$client_secret;
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ch_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    
        return $result;
    }
    /**
     * stdclass를 배열로
     */
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
        
        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
             return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }

    /**
     * 코인 뉴스 가져오기 
     */
    function getNewApi($obj) {
        global $DB;
        
        for ( $i=0; $i<count($obj); $i++ ) {

            $arryLink = explode("/", $obj[$i]->originallink);
            $code = end($arryLink);
            if ( trim($code) == 'article.html' ){
                $intNumb = count($arryLink);
                $code = $arryLink[$intNumb-2];
            }
            list($head, $tail) = explode("=", $code);
            if ( trim($tail) ) {
                $getCode = trim($tail);
            } else {
                $getCode = trim($head);
            }
        
            $subject = htmlspecialchars($obj[$i]->title, ENT_QUOTES);
            $originallink = $obj[$i]->originallink;
            $link = $obj[$i]->link;
            $content = htmlspecialchars($obj[$i]->description, ENT_QUOTES);
            $rgdate = date('Y-m-d H:i:s', strtotime($obj[$i]->pubDate));
        
            $strSQL = " select count(*) total from mpr_news_board where code like '%{$getCode}%' ";
            if ( $DB->single($strSQL) <= 0 ) {
                $strSQL = " insert into mpr_news_board (code, subject, content, originallink, link, rgdate) values ('{$getCode}', '{$subject}', '{$content}', '{$originallink}', '{$link}', '{$rgdate}') ";
                @$DB->query($strSQL);
            }
        }
    }

    /**
     * S 여기서 부터
     * 코인 실시간 정보가져오기
     */
    function parseResponse($response)
    {
        if (!empty ($response)) {
            $result = explode("\r\n\r\n", $response, 2);
            if (count($result) < 2) {
                echo "invalid response body! it has no HEADER and BODY!\n";
                return array();
            }
            $header = $result [0];
            $body = $result [1];
            $transactionId = $this->get_transaction_id($header);
            $jsonbody = json_decode($body, true);
            return array('transactionId' => $transactionId, 'json' => $jsonbody);
        }

        return array();
    }

    function get_transaction_id($header)
    {
        $header_rows = explode("\n", $header);
        for ($i = 0; $i < count($header_rows); $i++) {
            $fields = explode(":", $header_rows[$i]);
            if (count($fields) < 2) {
                continue;
            }
            $name = trim($fields[0]);
            $value = trim($fields[1]);
            if ("X-Transaction-ID" == $name) {
                return $value;
            }
        }

        return "unknown";
    }
    function getHeader()
    {
        //$timestamp = getTimestamp();
        $header = array(
            'Content-Type: application/json; charset=UTF-8',      
        );
        return $header;
    }
    /**
     * 코인 한글 이름 가져오기
     * code : 코인코드를 ,(콤마) 기준으로 가져오는 문자열
     * name : 코인코드 하나당 이름을 반려한다.
     */
    function getUpbitCoinCode($isUse='code') {
        $baseUrl = "https://api.upbit.com/v1/market/all";
        $ch = curl_init();
        if (!$ch) {
            die ("Couldn't initialize a cURL handle");
        }
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());

        $output = curl_exec($ch);        
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);        
        $error = curl_error($ch);        

        curl_close($ch);
        if (empty ($code)) {
            die ("No HTTP code was returned");
        }
        if (!empty ($error)) {
            die("failed to request");
        }

        $response = $this->parseResponse($output);
        $arrayAgent = array();
        $coinCode = '';
        foreach( $response['json'] as $key => $value ){
            if ( is_array($value) ) {
                if ( strpos($value['market'], 'KRW-')!== false ) {
                    if ( trim($isUse)=='code' ) {
                        $coinCode.=','.$value['market'];
                    } else {
                        $coinCode = str_replace('KRW-', '', $value['market']);
                        $arrayUpbit['koname'] = $value['korean_name'];
                        $arrayAgent[$coinCode]  = trim($value['korean_name']);
                    }
                }
            }
        }

        if ( trim($isUse)=='code' ) {
            return substr($coinCode,1);
        } else {
            return $arrayAgent;
        }

        /* echo '<pre>';
        echo '업비트<br>';
        print_r($arrayAgent);
        echo '</pre>';  */
    }

    /* echo '<pre>';
    print_r( getUpbitCoinCode('name') );
    echo '</pre>'; */

    function coinStates($codename) {
        global $DB;

        $arrCoinName = $this->getUpbitCoinCode('name');

        if ( trim($codename)=='bithumb' ) {
            $baseUrl = "https://api.bithumb.com/public/ticker/ALL_KRW";//빗썸...
        } else if ( trim($codename)=='upbit' ) {
            $strUpbitCoin = $this->getUpbitCoinCode();
            $baseUrl = "https://api.upbit.com/v1/ticker?markets={$strUpbitCoin}";//업비트...
        } else if ( trim($codename)=='coinone' ) {
            $baseUrl = "https://api.coinone.co.kr/ticker/?currency=all";//코인원
        }



        $ch = curl_init();
        if (!$ch) {
            die ("Couldn't initialize a cURL handle");
        }
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=UTF-8'));

        //echo "<script>console.log('".$baseUrl.$uri."');</script>";
        $output = curl_exec($ch);        

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);        
        // Console_log($code);

        $error = curl_error($ch);        
        // Console_log($error);

        curl_close($ch);
        if (empty ($code)) {
            die ("No HTTP code was returned");
        } else {
            //echo "Http Status : " . $code . "\n";
        }
        if (!empty ($error)) {
            //echo "error : $error\n";
            die("failed to request");
        }

        $response = $this->parseResponse($output);


        if ( strpos($baseUrl, 'coinone') !== false ) {
            //---- 코인원
            $arrayAgent = array();
            foreach( $response['json'] as $key => $value ){
                if ( is_array($value) ) {
                    /* $arryCoinone['name'] = strtoupper($value['currency']);
                    $arryCoinone['first'] = $value['first'];
                    $arryCoinone['low'] = $value['low'];
                    $arryCoinone['high'] = $value['high'];
                    $arryCoinone['last'] = $value['last'];
                    $arryCoinone['volume'] = round($value['volume'], 2);
                    $arryCoinone['percent'] = round( (($value['first']/$value['last'])*100)-100, 2);
                    $arrayAgent[]  = $arryCoinone; */
                    
                    $coinname = strtoupper($value['currency']);
                    $coininfo['coinone'][$coinname] = array(
                        'name'=>$arrCoinName[$coinname],
                        'first'=>$value['first'],
                        'low'=>$value['low'],
                        'high'=> $value['high'],
                        'last'=>$value['last'],
                        'volume'=>round($value['volume'], 2),
                        'percent'=>round( (($value['first']/$value['last'])*100)-100, 2),
                        'amount'=>round($value['volume']*$value['last'], 2)
                    );
                    
                }
            }

            $strSQL = " select * from mpr_dp_coins where agency=:agency and display=:display ";
            $getData = $DB->query($strSQL, array('agency'=>'coinone', 'display'=>'Y'));
            for ($i=0; $i<count($getData); $i++) {
                $coinname = $getData[$i]['shortNm'];
                $coininfo['coinone'][$coinname] = array(
                    'name'=>$getData[$i]['KorNm'],
                    'first'=>$getData[$i]['last'],
                    'low'=>$getData[$i]['low'],
                    'high'=>$getData[$i]['high'],
                    'last'=>$getData[$i]['current'],
                    'volume'=>$getData[$i]['volume_24'],
                    'percent'=>round( (($getData[$i]['current']/$getData[$i]['last'])*100)-100, 2),
                    'amount'=>$getData[$i]['amount_24']
                );
            }

            /* echo '<pre>';
            echo '코인원<br>';
            print_r($coininfo);
            echo '</pre>';  */

            return $coininfo;

        } else if ( strpos($baseUrl, 'bithumb') !== false ){
            //---- 빗썸
            $arrayAgent = array();
            foreach( $response['json']['data'] as $key => $value ){
                if ( is_array($value) ) {
                    /* $arrayBithumb['name'] = $key;
                    $arrayBithumb['first'] = $value['opening_price'];
                    $arrayBithumb['low'] = $value['min_price'];
                    $arrayBithumb['high'] = $value['max_price'];
                    $arrayBithumb['last'] = $value['closing_price'];
                    $arrayBithumb['volume'] = round($value['units_traded_24H'], 2);
                    $arrayBithumb['percent'] = round( (($value['opening_price']/$value['closing_price'])*100)-100, 2);
                    $arrayAgent[]  = $arrayBithumb; */

                    $coinname = strtoupper($key);
                    $coininfo['bithumb'][$coinname] = array(
                        'name'=>$arrCoinName[$coinname],
                        'first'=>$value['opening_price'],
                        'low'=>$value['min_price'],
                        'high'=> $value['max_price'],
                        'last'=>$value['closing_price'],
                        'volume'=>round($value['units_traded_24H'], 2),
                        'percent'=>round( (($value['opening_price']/$value['closing_price'])*100)-100, 2),
                        'amount'=>round($value['acc_trade_value_24H'], 2)
                    );
                    
                }
            }

            $strSQL = " select * from mpr_dp_coins where agency=:agency and display=:display ";
            $getData = $DB->query($strSQL, array('agency'=>'bithumb', 'display'=>'Y'));
            for ($i=0; $i<count($getData); $i++) {
                $coinname = $getData[$i]['shortNm'];
                $coininfo['bithumb'][$coinname] = array(
                    'name'=>$getData[$i]['KorNm'],
                    'first'=>$getData[$i]['last'],
                    'low'=>$getData[$i]['low'],
                    'high'=>$getData[$i]['high'],
                    'last'=>$getData[$i]['current'],
                    'volume'=>$getData[$i]['volume_24'],
                    'percent'=>round( (($getData[$i]['current']/$getData[$i]['last'])*100)-100, 2),
                    'amount'=>$getData[$i]['amount_24']
                );
            }
            
            /* echo '<pre>';
            echo '빗썸<br>';
            print_r($arrayAgent);
            echo '</pre>';  */

            return $coininfo;

        } else {
            //---- 업비트
            $arrayAgent = array();
            foreach( $response['json'] as $key => $value ){
                if ( is_array($value) ) {
                    /* $arrayUpbit['name'] = str_replace('KRW-', '', $value['market']);
                    $arrayUpbit['first'] = $value['opening_price'];
                    $arrayUpbit['low'] = $value['low_price'];
                    $arrayUpbit['high'] = $value['high_price'];
                    $arrayUpbit['last'] = $value['prev_closing_price'];
                    $arrayUpbit['volume'] = round($value['acc_trade_volume_24h'], 2);
                    $arrayUpbit['percent'] = round( (($value['opening_price']/$value['prev_closing_price'])*100)-100, 2);
                    $arrayAgent[]  = $arrayUpbit; */
                    
                    $coinname = strtoupper(str_replace('KRW-', '', $value['market']));
                    $coininfo['upbit'][$coinname] = array(
                        'name'=>$arrCoinName[$coinname],
                        'first'=>$value['opening_price'],
                        'low'=>$value['low_price'],
                        'high'=> $value['high_price'],
                        'last'=>$value['trade_price'],
                        'volume'=>round($value['acc_trade_volume_24h'], 2),
                        'percent'=>round( (($value['opening_price']/$value['prev_closing_price'])*100)-100, 2),
                        'amount'=>round($value['acc_trade_price_24h'], 2)
                    );
                    
                }
            }

            $strSQL = " select * from mpr_dp_coins where agency=:agency and display=:display ";
            $getData = $DB->query($strSQL, array('agency'=>'upbit', 'display'=>'Y'));
            for ($i=0; $i<count($getData); $i++) {
                $coinname = $getData[$i]['shortNm'];
                $coininfo['upbit'][$coinname] = array(
                    'name'=>$getData[$i]['KorNm'],
                    'first'=>$getData[$i]['last'],
                    'low'=>$getData[$i]['low'],
                    'high'=>$getData[$i]['high'],
                    'last'=>$getData[$i]['current'],
                    'volume'=>$getData[$i]['volume_24'],
                    'percent'=>round( (($getData[$i]['current']/$getData[$i]['last'])*100)-100, 2),
                    'amount'=>$getData[$i]['amount_24']
                );
            }

            /* echo '<pre>';
            echo '업비트<br>';
            print_r($arrayAgent);
            echo '</pre>';  */

            return $coininfo;
        }
    }
    /**
     * E 여기까지
     * 코인 실시간 정보 가져오기
     */

    /**
     * // 채널명, 썸네일(가로 120px) URL, 썸네일(가로 320px) URL, 영상조회수, 상태값(영상이 없는경우 false)
     */
    function youtubeAPI($url){

        $youtube_api_key = "AIzaSyCacpxaBsQxWJscemhzDDc-_8_JA__VCmw";
        
        parse_str( parse_url( $url, PHP_URL_QUERY ), $u_id );
        //-- https://youtu.be/fdoLXChlJ_4 형태로 들어올수 있으므로 처리 추가
        if($u_id['v'] == ''){
            $url_arr = explode('/', $url);
            $u_id['v'] = end($url_arr);
        }
    
        $snippet_url = "https://www.googleapis.com/youtube/v3/videos?id=".$u_id['v']."&fields=items&key=".$youtube_api_key."&part=snippet"; //채널 ID 알아낼수있음 -> 구독자수
        $snippet_json = file_get_contents($snippet_url);
        $snippet_ob = json_decode($snippet_json);
    
        //-- var_dump($snippet_json); 
        
        foreach ( $snippet_ob->items as $data ){
            $channelId = $data->snippet->channelId;	   // 채널 ID 
            $uploadDate = $data->snippet->publishedAt;	   
                // 업로드일 --------- 업로드일이 등록일이 되는 것임(이유 : 조회수가 이미 많은 영상을 등록 할 수 있음) -- 설정된 날짜(30일 후)의 조회수 - 우리쪽 등록일의 조회수 = ?? 이게 맞는가 ㅋ 확인 필요!
            $thumbnails[120] = $data->snippet->thumbnails->default->url;		// 썸네일 120x90
            $thumbnails[320] = $data->snippet->thumbnails->medium->url;		// 썸네일 320x180
            //-- $thumbnails[480] = $data->snippet->thumbnails->high->url;		// 썸네일 480x360
            //-- $thumbnails[640] = $data->snippet->thumbnails->standard->url;	// 썸네일 640x480
            //-- $thumbnails[1280] = $data->snippet->thumbnails->maxres->url;		// 썸네일 1280x720
        }
    
        $statistics_url = "https://www.googleapis.com/youtube/v3/videos?id=".$u_id['v']."&key=".$youtube_api_key."&part=statistics"; // 영상 좋아요 , 댓글 수 , 조회 수	
    
         //영상 좋아요 댓글, 조회 수
        $statistics_json = file_get_contents($statistics_url);
        $statistics_ob = json_decode($statistics_json);
        
        foreach ( $statistics_ob->items as $data ){   		
            $viewCount = $data->statistics->viewCount;				// 조회수 
            //-- $likeCount = $data->statistics->likeCount;			// 좋아요 수	    
            //-- $commentCount = $data->statistics->commentCount;    // 댓글수	    
        }
        
        if($channelId){
            return array('chnnelId'=>$channelId, 'thumnail1'=>$thumbnails[120], 'thumnail2'=>$thumbnails[320], 'viewCount' => $viewCount, 'state' => true);
            // 채널명, 썸네일(가로 120px) URL, 썸네일(가로 320px) URL, 영상조회수, 상태값(영상이 없는경우 false)
        }else{
            return array('state' => false);
        }
    }

}

$COIN = new COIN();
?>