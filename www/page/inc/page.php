<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
   

    $S_SQL = "select * from mpr_event where ev_key = '{$_GET['code']}' ";
    $res = $DB -> query($S_SQL);
    echo "<script> console.log(".json_encode($res).") </script>";
?>
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
            $("[data-form='"+form+"']").remove();
        }
    }

    // 유효성
    const validate = (el, type) => {

        let elValue = el.value;
        let elValueSize = elValue.length;
        let elName;
        if(type != 'sex'){
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
                    if (elValueSize < 2 || elValueSize > 20 ){
                        isReqForm(el, 'null');
                        rejectValidate(el, elName+"은(는) 최소 2자에서 20자 이하여야 합니다.");
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
                        if( elDataset == 'required' ){
                            isReqForm(el, 'fill');
                        }
                    }
                    break;
                case 'tel' :
                    if (elValueSize > 13 || elValueSize < 9 ){
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
                    if (evValueSize <= 0){
                        isReqForm(el, 'null');
                    }
                    else {
                        el.nextElementSibling.innerHTML = '';
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

    // 등록 처리
    const submitEvent = () => {

        if(!$('#is_privacy').is(':checked')){
            alert('개인정보 수집 및 이용 동의는 필수입니다.');
            return false;
        }

        let evFrm = $('#landing').serialize();

        $.ajax({
            url: "<?php echo BASE_URL.'/ajax/ajax.submit.php'; ?>",
            type : "POST",
            dataType : "JSON",
            data : evFrm,
        }).done(function(r){
            if(r == 'OK'){
                // alert('성공');
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: '신청 완료!',
                showConfirmButton: false,
                timer: 2000
                });
                setTimeout(() => location.reload(), 2100);

                var type = "<?php echo $DB->hexAesEncrypt('INSERT_DATA'); ?>";
                //ConnectM 데이터 입력
                /* $.ajax({
                    url: "https://mprclients.mprkorea.com/event/api/apicall.php",
                    type : "POST",
                    dataType : "JSON",
                    data : {
                    type : type,
                    key : "<?php echo $res['ev_key']; ?>", //API KEY  
                    cust_nm : "<?php echo $res['ev_name']; ?>", // 접수자 이름 (필수)
                    cust_hp : "<?php echo $res['ev_tel']; ?>", // 접수자연락처 (필수)
                    etc : { "cust_sex" : "<?php echo $res['ev_sex']; ?>", 
                            "cust_age" : "<?php echo $res['ev_age']; ?>",
                            "cust_birth" : "<?php echo $res['ev_birthday']; ?>", 
                            "rec_person" : "<?php echo $res['ev_rec_person']; ?>", 
                            "cust_counsel_time" : "<?php echo $res['ev_counsel_time']; ?>",  
                            "cust_comment" : "<?php echo $res['ev_comment']; ?>"
                           } //기타추가항목
                    }
                }).done(function(rs){	
                    console.log($.trim(rs.result));
                    if($.trim(rs.result)){                        
                        alert(rs.message);                         
                        $('#fastAjax')[0].reset();
                    }
                }).fail(function(rs){
                    alert(rs.message);
                    return false;
                });
 */
            }
            else {
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: '모종의 이유로 신청되지 못했습니다.',
                showConfirmButton: false,
                timer: 2000
                });
            }

        }).fail(function(error){
            console.log(error);
            return false;
        });  

        return false;

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
                alert('페이지를 불러올 수 없습니다.');
                return false;
            }
            else {

                let type = pv.ev_type;
                let title = pv.ev_subject;
                let isAlways = pv.ev_always;
                let sdate = dateFormatter(pv.ev_start);
                let edate = dateFormatter(pv.ev_end);
                let isDel = pv.del_yn;
                if(type == 'F'){

                    // content
                    let ptop = removal(pv.ev_top_content_pc);
                    let mtop = removal(pv.ev_top_content_mo);
                    let pbtm = removal(pv.ev_bottom_content_pc);
                    let mbtm = removal(pv.ev_bottom_content_mo);

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

                    // setUsingFormElements
                    let arrUsingFrm = [pv.ev_name_yn, pv.ev_tel_yn, pv.ev_sex_yn, pv.ev_age_yn, pv.ev_birthday_yn, pv.ev_rec_person_yn, pv.ev_counsel_time_yn, pv.ev_comment_yn];
                    for(let f = 0 ; f < arrUsingFrm.length ; f++){

                        let frmName = $('.form-row').eq(f).data('form');
                        let frmVal = arrUsingFrm[f];

                        isVisibleForm(frmName, frmVal);
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
                        if(ptop){
                            topCont.innerHTML = ptop;
                        }
                        if(pbtm){
                            btmCont.innerHTML = pbtm;
                        }
                        if(mtop){
                            topCont.innerHTML = mtop;
                        }
                        if(mbtm){
                            btmCont.innerHTML = mbtm;
                        }
                    }
                }
                else if(type == 'M'){

                    let cont = pv.ev_content;

                }

                // SetEventDates
                let ev_dates = '';
                if(isAlways != 'Y'){
                    ev_dates = sdate + ' ~ ' + edate + '까지';
                }
                else {
                    ev_dates = '상시진행되는 이벤트 입니다.';
                }

                $('.event-dates').text(ev_dates);

                // SetTitleAttribute
                document.querySelector('title').innerText = title;
            }

        }).fail(function(error){
            console.log(error);
            return false;
        });
   
    });

</script>