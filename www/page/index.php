<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";
    $clientKey = $DB->hexAesEncrypt(trim($_GET['biz']));
    $eventKey = $DB->hexAesEncrypt(trim($_GET['code']));

    $mo_ag = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

    if(preg_match($mo_ag, $_SERVER['HTTP_USER_AGENT'])){
        $isMobile = true;
    }
    else{
        $isMobile = false;
    }

    include_once(trim($_SERVER['DOCUMENT_ROOT'])."/page/inc/page.php");

?>
    <link rel="stylesheet" href="<?php echo LANDING_URL.'/inc/page.css'; ?>">

    <div id="full-wrapper">
        <div id="cont-wrapper-top">
        </div>
        <form id="landing">
            <input type="hidden" name="br_code" value="<?php echo $clientKey; ?>" />
            <input type="hidden" name="br_key" id="br_key" value="<?php echo $eventKey; ?>" />
            <div class="text-row">
                <div class="text-comment">이벤트 기간 : <span class="event-dates"></span> </div>
            </div>
            <div class="text-row">
                <div class="text-comment"><span class="req_mark"><i class="fa-solid fa-asterisk"></i> </span><span class="h5">항목은 <mark>필수 항목</mark>입니다.</span></div>
            </div>
            <div class="form-row" data-form="ev_name">
                <label for="ev_name" class="input-label">이름</label>
                <input type="text" name="ev_name" id="ev_name" onblur="validate(this, 'name');" autocomplete="off" />
                <span class="rejectEl"></span>
            </div>
            <div class="form-row" data-form="ev_tel">
                <label for="ev_tel" class="input-label">연락처</label>
                <input type="tel" name="ev_tel" id="ev_tel" oninput="autoHyphen(this);" onblur="validate(this, 'tel');" maxlength="13" autocomplete="off" placeholder="- 없이 입력" />
                <span class="rejectEl"></span>
            </div>
            <div class="form-row" data-form="ev_sex">
                <label for="ev_sex" class="input-label">성별</label>
                <div class="radio-wrap d-flex">
                    <input type="radio" name="ev_sex" id="ev_sex_m" value="M" onchange="validate(this, 'sex');">
                    <label for="ev_sex_m">남성</label>
                    <input type="radio" name="ev_sex" id="ev_sex_f" value="F" onchange="validate(this, 'sex');">
                    <label for="ev_sex_f">여성</label>
                </div>
            </div>
            <div class="form-row" data-form="ev_age">
                <label for="ev_age" class="input-label">나이</label>
                <input type="number" name="ev_age" id="ev_age" oninput="numLeng(this, 3);" onblur="validate(this, 'age');" autocomplete="off" />
                <span class="rejectEl"></span>
            </div>
            <div class="form-row" data-form="ev_birthday">
                <label for="ev_birthday" class="input-label">생년월일</label>
                <input type="number" name="ev_birthday" id="ev_birthday" oninput="numLeng(this, 6);" onblur="validate(this, 'birth');" autocomplete="off" placeholder="생년월일 6자리 입력" />
                <span class="rejectEl"></span>
            </div>
            <div class="form-row" data-form="ev_rec_person">
                <label for="ev_rec_person" class="input-label">추천인</label>
                <input type="text" name="ev_rec_person" id="ev_rec_person" onblur="validate(this, 'recomm');" autocomplete="off" />
                <span class="rejectEl"></span>
            </div>
            <div class="form-row" data-form="ev_counsel_time">
                <label for="ev_counsel_time" class="input-label">상담가능시간</label>
                <select name="ev_counsel_time" id="ev_counsel_time" onchange="validate(this, 'cstime');">
                    <option value="" selected disabled>상담가능시간 선택</option>
                    <option value="9-11">오전 9시 ~ 11시</option>
                    <option value="11-13">오전 11시 ~ 1시</option>
                    <option value="15-17">오후 3시 ~ 5시</option>
                    <option value="17-19">오후 5시 ~ 7시</option>
                </select>
            </div>
            <div class="form-row" data-form="ev_comment">
                <textarea name="ev_comment" id="ev_comment" placeholder="문의사항 입력" autocomplete="off" onblur="validate(this, 'comm');"></textarea>
            </div>
            <div class="text-row">
                <input type="checkbox" id="is_privacy">
                <label for="is_privacy">개인정보 수집 및 이용에 관한 내용을 확인하고 동의함</label>
                <a href="#" class="link_privacy">자세히보기</a>
            </div>
            <div class="button-row">
                <button type="button" onclick="submitEvent();">신청하기</button>
            </div>
        </form>
        <div id="cont-wrapper-btm">
        </div>
    </div>
    
</body>
</html>