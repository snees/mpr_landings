<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    // 태그 제거
    const removal = (keyword) => {
        let removalKeyword = keyword.replace(/<br>/gi, '').replace(/<p>/gi, '').replace(/<\/p>/gi, '').trim();
        return removalKeyword;
    }

    // 날짜 형식 변경
    const dateFormatter = (date) => {
        let getDate = new Date(date);
        let formatDate = getDate.getFullYear() + '년 ' + (getDate.getMonth()+1) + '월 ' + getDate.getDate() + '일';
        return formatDate;
    }

    // 오토 하이픈
    const autoHyphen = (target) => {
        target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
    }

    // 언어 유형
    const getLanguageType = (str) => {
        let char_code = str.charCodeAt(0);
        let lang_type = '';
        if ( str ){
            if( char_code >= 123 ){
                lang_type += 'KOR';
            }
            else if( char_code > 64 && char_code < 123 ){
                lang_type += 'ENG';
            }
            else {
                lang_type += 'ETC';
            }
            return lang_type;
        }
    }

    // 숫자 길이 조절
    const numLeng = (el, maxlength) => {
        if(el.value.length > maxlength)  {
            el.value 
            = el.value.substr(0, maxlength);
        }
    }

    // 유효한 폼 ON/OFF
    const isVisibleForm = (form, value) => {
        if(value != 'Y'){
            $("[data-form='"+form+"']").hide();
        }
    }

    // 유효성
    const validate = (el, type) => {

        let elValue = el.value;
        let elValueSize = elValue.length;
        let elName;

        if(type != 'sex' && type != 'comm'){
            elName = el.previousElementSibling.innerText;
        }
        let checNums = /^[0-9]$/;

        let elDataset = el.parentElement.dataset.req;
        if(type == 'sex'){
            elDataset = el.parentElement.parentElement.dataset.req;
        }

        if( elValueSize <= 0 ){
            if( elDataset == 'required' ){
                isReqForm(el, 'null');
                rejectValidate(el, elName+"을(를) 입력하세요");
            }
        }
        else {
            switch(type){
                case 'name' :
                    if (elValueSize < 2 | elValueSize > 20 ){
                        isReqForm(el, 'null');
                        rejectValidate(el, elName+"은(는) 최소 2자에서 20자 이하여야 합니다.");
                    }
                    else if(getLanguageType(elValue) == 'ETC'){
                        isReqForm(el, 'null');
                        rejectValidate(el, "한글 또는 영문자만 입력 가능합니다.");
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'tel' :
                    if (elValueSize < 13){
                        isReqForm(el, 'null');
                        rejectValidate(el, elName+" 길이를 확인해 주세요.");
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'sex' :
                    if( elDataset == 'required' ){
                        isReqForm(el.parentElement, 'fill');
                    }
                    break;
                case 'age' :
                    if (elValueSize > 3 ){
                        isReqForm(el, 'null');
                        rejectValidate(el, elName+" 길이는 최대 3자까지 입니다.");
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'birth' :
                    if (elValueSize > 6 ){
                        isReqForm(el, 'null');
                        rejectValidate(el, elName+" 길이는 최대 6자까지 입니다.");
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'recomm' :
                    if (elValueSize <= 0){
                        isReqForm(el, 'null');
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'cstime' :
                    if( elDataset == 'required' ){
                        isReqForm(el, 'fill');
                    }
                    break;
                case 'comm' :
                    if (elValueSize <= 0){
                        isReqForm(el, 'null');
                    }
                    else {
                        //el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
            }
        }

        let reqLeng = $('[data-req*="required"]').length;
        let statLeng = $('[data-stat="true"]').length;

        if(reqLeng == statLeng){
            $('form#landing .button-row button').attr('disabled', false);
        }

    }

    // 유효성 통과 처리
    const isReqForm = (el, isNull) => {
        if(isNull == 'fill'){
            el.parentElement.dataset.stat = true;
            el.previousElementSibling.querySelector('i').classList.remove("fa-asterisk");
            el.previousElementSibling.querySelector('i').classList.add("fa-check");

        }
        else if(isNull == 'null'){
            el.parentElement.dataset.stat = false;
            el.previousElementSibling.querySelector('i').classList.remove("fa-check");
            el.previousElementSibling.querySelector('i').classList.add("fa-asterisk");
        }
    }

    // 유효성 반환 처리
    const rejectValidate = (el, msg) => {
        let thisEl = el;
        let thisNextEl = thisEl.nextElementSibling;
        thisNextEl.innerHTML = msg;
        // el.focus();
        return false;
    }

    // Alert 처리
    const setAlert = (booltype, action, msg) => {
        let alertIcon = '';
        if(booltype == 'good'){
            alertIcon = 'success';
        }
        else {
            alertIcon = 'error';
        }

        Swal.fire({
            position: 'center',
            icon: alertIcon,
            title: msg,
            showConfirmButton: false,
            timer: 1500
        });

        switch(action){
            case 'reload' :
                setTimeout(() => location.reload(), 1600);
            break;
            case 'goback' :
                setTimeout(() => history.length>1?window.history.back():window.close() , 1600);
            break;
            default :
                return false;
        }
    }

    // 등록 처리
    const submitEvent = () => {

        if(!$('#is_privacy').is(':checked')){
            alert('개인정보 수집 및 이용 동의는 필수입니다.');
            return false;
        }

        let evFrm = $('#landing').serialize();

        $.ajax({
            url: "https://mprclients.mprkorea.com/event/api/apicall.php",
            type : "POST",
            dataType : "JSON",
            data : {
            key : $('#br_key').val(), /* API KEY */  
            cust_nm : $('#ev_name').val(), /* 접수자 이름 (필수) */
            cust_hp : $('#ev_tel').val(), /* 접수자연락처 (필수) */
            etc : { "counsel" : $('#ev_comment').val() , "cust_age" : $('#ev_age').val() , 
                    "cust_time" : $('#ev_counsel_time').val(), "birthday" : $('#ev_birthday').val(), 
                    "gender" : $('input[name="ev_sex"]:checked').val(), "referral" : $('#ev_rec_person').val()
                } /* 기타추가항목 */
            }
        }).done(function(rs){	
            if($.trim(rs.result)){
                setAlert('good', 'reload', '신청 완료!'); 
            }
            else {
                setAlert('bad', '', '신청에 실패하였습니다.');
            }
        }).fail(function(rs){
            alert(rs.message); 
            return false;
        });            

    }

    $(document).ready(function(){

        $('form#landing .button-row button').attr('disabled', true);
        
        $.ajax({
            url: "<?php echo BASE_URL.'/ajax/ajax.page.php'; ?>",
            type : "POST",
            dataType : "JSON",
            data : {
                ckey : '<?php echo $clientKey; ?>',
                ekey : '<?php echo $eventKey; ?>'
            }
        }).done(function(r){
            let pv = r.result;

            if(!pv) {
                setAlert('bad', 'goback', '불러올 페이지가 없습니다.');
            }
            else {

                let type = pv.ev_type;
                let title = pv.ev_subject;
                let isAlways = pv.ev_always;
                let evStat = pv.ev_stat;
                let sdate = dateFormatter(pv.ev_start);
                let edate = dateFormatter(pv.ev_end);
                let isDel = pv.del_yn;

                // 삭제 이벤트 처리
                if(isDel == 'Y'){
                    setAlert('bad', 'goback', '존재하지 않는 이벤트입니다.');
                }

                // 상시 진행이 아닌 '진행 예정' 또는 '종료' 이벤트 처리
                let ev_dates = '';
                if(isAlways != 'Y'){
                    ev_dates = sdate + ' ~ ' + edate + '까지';
                    if(evStat == 'W'){
                        // 진헹 예정 이벤트 처리
                        $('.form-row input, .form-row select, .form-row textarea').attr('disabled', true);
                        $('.event-dates').css('color', 'rgba(0, 0, 0, .1)');
                    }
                    else if(evStat == 'N'){
                        // 종료 이벤트 처리
                        setAlert('bad', 'goback', '이미 종료된 이벤트 입니다.');
                    }
                }
                else {
                    ev_dates = '상시진행되는 이벤트 입니다.';
                }

                $('.event-dates').text(ev_dates);

                // 기본형 폼 설정
                if(type == 'F'){

                    // content
                    let ptop = removal(pv.ev_top_content_pc);
                    let mtop = removal(pv.ev_top_content_mo);
                    let pbtm = removal(pv.ev_bottom_content_pc);
                    let mbtm = removal(pv.ev_bottom_content_mo);

                    // setUsingFormElements
                    let arrUsingFrm = [pv.ev_name_yn, pv.ev_tel_yn, pv.ev_sex_yn, pv.ev_age_yn, pv.ev_birthday_yn, pv.ev_rec_person_yn, pv.ev_counsel_time_yn, pv.ev_comment_yn];
                    for(let f = 0 ; f < arrUsingFrm.length ; f++){

                        let frmName = $('.form-row').eq(f).data('form');
                        let frmVal = arrUsingFrm[f];

                        isVisibleForm(frmName, frmVal);
                    }

                    // setRequireFormElements
                    let arrReqFrm = [pv.ev_name_req, pv.ev_tel_req, pv.ev_sex_req, pv.ev_age_req, pv.ev_birthday_req, pv.ev_rec_person_req, pv.ev_counsel_time_req, pv.ev_comment_req];
                    for(let f = 0 ; f < arrReqFrm.length ; f++){
                        let frmVal = arrReqFrm[f];
                        if(frmVal == 'Y'){
                            let strReq  = '<span class="req_mark"><i class="fa-solid fa-asterisk"></i></span>';
                            $('.form-row').eq(f).attr('data-req', 'required');
                            $('.form-row').eq(f).attr('data-stat', false);
                            $('.form-row').eq(f).children('label').append(strReq);
                        }
                    }

                    // SetContentElements
                    let topCont = document.querySelector('#cont-wrapper-top');
                    let btmCont = document.querySelector('#cont-wrapper-btm');
                    if(ptop && pbtm && mtop && mbtm){
                    <?php if($isMobile){ ?>
                        topCont.innerHTML = mtop;
                        btmCont.innerHTML = mbtm;
                    <?php } else { ?>
                        topCont.innerHTML = ptop;
                        btmCont.innerHTML = pbtm;
                    <?php } ?>
                    }
                    else {
                        if(ptop && mtop){
                            <?php if($isMobile){ ?>
                                topCont.innerHTML = mtop;
                            <?php } else { ?>
                                topCont.innerHTML = ptop;
                            <?php } ?>
                        }
                        else {
                            if(ptop){
                                topCont.innerHTML = ptop;
                            }
                            else {
                                topCont.innerHTML = mtop;
                            }
                        }

                        if(pbtm && mbtm){
                            <?php if($isMobile){ ?>
                                btmCont.innerHTML = mbtm;
                            <?php } else { ?>
                                btmCont.innerHTML = pbtm;
                            <?php } ?>
                        }
                        else {
                            if(ptop){
                                btmCont.innerHTML = pbtm;
                            }
                            else {
                                btmCont.innerHTML = mbtm;
                            }
                        }
                    }
                }
                else if(type == 'M'){
                    let cont = pv.ev_content;
                }

                // SetTitleAttribute
                document.querySelector('title').innerText = title;
            }

        }).fail(function(error){
            console.log(error);
            return false;
        });
   
    });

</script>