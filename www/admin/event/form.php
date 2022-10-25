<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    ob_start();

    $today = date("Y-m-d", time());
    $endDay = strtotime("$today +7 days");
    $endDay = date("Y-m-d", $endDay);

    $start_Date = $today;
    $end_Date = $endDay;
?>
<style>
    .form_div{
        margin-bottom : 15px;
    }
    legend {
        margin : 0px;
    }
    .note-group-image-url {
        display : none;
    }
    .note-modal-footer {
        height : 60px;
    }
</style>

<?php     
        //업체정보
        $company = "del_yn='N' order by (CASE WHEN SUBSTRING(br_name,1,1) RLIKE '[ㄱ-ㅎ가-힣]' THEN 1 WHEN SUBSTRING(br_name,1,1) RLIKE '[a-zA-Z]' THEN 2 ELSE 3 END), br_name";
        $br_code_arr = array();


        $S_SQL = "select * from mpr_branch where {$company} ";
        $res = $DB -> query($S_SQL);
        $options .= "<select class='custom-select form-control-border' id='br_code' name='br_code'>";
        $options .= "<option disabled selected>업체를 선택해 주세요.</option>";
        $i=0;
        foreach($res as $row){
            $options .= "<option value='".$row['br_code']."'>".$row['br_name']."</option>";
            $br_code_arr[$i++] = $row['br_code'];
        }
        $options .='</select>';        
?>

<!-- 등록 / 수정 구분 -->
<?php
    $top_pc_content = "";
    $top_mo_content = "";
    $bottom_pc_content = "";
    $bottom_mo_content = "";
    $ev_color = "#EAEAEA";

    $is_name_checked = "checked";
    $is_tel_checked = "checked";
    $w_stat = "checked";



    if ( trim($_GET['mode'])=='update' ) {
        $btn_value = 'update_btn';
        $strSQL = "SELECT * FROM mpr_event WHERE idx = {$_GET['idx']}; ";
        $result = $DB -> row($strSQL);

        $API = $result['ev_key'];
        $top_pc_content = $result['ev_top_content_pc'];
        $top_mo_content = $result['ev_top_content_mo'];
        $bottom_pc_content = $result['ev_bottom_content_pc'];
        $bottom_mo_content = $result['ev_bottom_content_mo'];
        $company = "br_code='{$result['br_code']}'";
        $start_Date = $result['ev_start'];
        $end_Date = $result['ev_end'];
        $event_cd = $result['ev_code'];
        $ev_color = $result['ev_color'];

        if($result['ev_name_yn'] == "Y") $is_name_checked = "checked";
        else $is_name_checked = "";
        if($result['ev_tel_yn'] == "Y") $is_tel_checked = "checked";
        else $is_tel_checked = "";
        if($result['ev_sex_yn'] == "Y") $is_sex_checked = "checked";
        if($result['ev_age_yn'] == "Y") $is_age_checked = "checked";
        if($result['ev_comment_yn'] == "Y") $is_comment_checked = "checked";
        if($result['ev_birthday_yn'] == "Y") $is_birth_checked = "checked";
        if($result['ev_rec_person_yn'] == "Y") $is_ev_rec_person_checked = "checked";
        if($result['ev_counsel_time_yn'] == "Y") $is_counsel_time_checked = "checked";
        
        if($result['ev_name_req'] == "Y") $is_name_req_checked = "checked";
        if($result['ev_tel_req'] == "Y") $is_tel_req_checked = "checked";
        if($result['ev_sex_req'] == "Y") $is_sex_req_checked = "checked";
        if($result['ev_age_req'] == "Y") $is_age_req_checked = "checked";
        if($result['ev_comment_req'] == "Y") $is_comment_req_checked = "checked";
        if($result['ev_birthday_req'] == "Y") $is_birth_req_checked = "checked";
        if($result['ev_rec_person_req'] == "Y") $is_ev_rec_person_req_checked = "checked";
        if($result['ev_counsel_time_req'] == "Y") $is_counsel_time_req_checked = "checked";
        
        if($result['ev_always'] == "Y") $is_ev_always_checked = "checked";

        if($result['ev_stat'] == "W"){
            $w_stat = "checked";  
        } else if($result['ev_stat'] == "Y"){
            $w_stat = "";
            $y_stat = "checked";
        } else{
            $w_stat = "";
            $n_stat = "checked";
        }

?>
        <script>
            window.onload = function(){      
                $('#delete_btn').show();
                
                if($("#ev_always").is(":checked")){
                    $( "#reservation2" ).show();
                    $( "#reservation" ).hide();
                }else{
                    $( "#reservation" ).show();
                    $( "#reservation2" ).hide();                
                }

                if( $("#ev_sex_req").is(":checked") ){
                    $("#ev_sex_req").attr("disabled" , false);
                }
                if( $("#ev_age_req").is(":checked") ){
                    $("#ev_age_req").attr("disabled" , false);
                }
                if( $("#ev_comment_req").is(":checked") ){
                    $("#ev_comment_req").attr("disabled" , false);
                }
                if( $("#ev_birthday_req").is(":checked") ){
                    $("#ev_birthday_req").attr("disabled" , false);
                }
                if( $("#ev_rec_person_req").is(":checked") ){
                    $("#ev_rec_person_req").attr("disabled" , false);
                }
                if( $("#ev_counsel_time_req").is(":checked") ){
                    $("#ev_counsel_time_req").attr("disabled" , false);
                }
            }
        </script>
<?php
    }else{        
        $btn_value = 'save_btn';
        $strSQL = " select max(code_seq) +1 as seq from mpr_seq";
        $seq = $DB->single($strSQL);
        $event_cd = "L".substr(str_pad($seq, 6, 0, STR_PAD_LEFT),-6);    
        $API = $DB->hexAesEncrypt($event_cd);
             
    }
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    
    var imgFileName = new Object;
    

    $(document).ready(function(){
        
        $('.vendor').append("<?php echo $options; ?>");
        if('<?php echo trim($_GET['mode']); ?>'=='update' ) {
            $("#br_code").val("<?php echo $result['br_code']; ?>").prop("selected", true); 
        }        
        $("#brand_name").val($("#br_code option:checked").text());

        var type;
        
        // summernote 구동
        $('.editor_textarea').summernote({
            height: 300,
            placeholder : "이미지 또는 링크만 업로드 가능합니다.",
            toolbar: [
                ['insert',['picture','link','video']],
		        ['view', ['codeview','fullscreen', 'help']]
            ],
            callbacks :{
                onImageUpload : function(files, editor, welEditable) {
                    type = this.name;
                    for(var i = files.length-1; i >= 0; i--){
                        sendFile(files[i], this);
                    }
                },
                onMediaDelete : function(target) {
                    var del_file = (target[0].src).split("/");
                    var del_fileName = del_file.pop();
                    if(del_file[3] != "img_data"){      // 새로 등록한 사진
                        if(Object.keys(imgFileName).length != 0){   
                            var Key = getKeyValue(imgFileName, del_fileName);
                            delete imgFileName[Key];
                            console.log(imgFileName);
                        }   
                    }
                },
                onKeydown: function(e) {
                    var t = $(".note-editable").text();   
                    if (t.length >= 0) {
                        //delete key
                        if (e.keyCode != 8)
                        e.preventDefault();
                        // add other keys ...
                    }
                }
            }
        });
        
        function sendFile(file, el) {
            var formData = new FormData();
            var key = $("#ev_key").val();
            var code = $("#br_code").val();
            formData.append("files", file);
            formData.append("type", type);
            formData.append("API", key);
            formData.append("code", code);
            $.ajax({
                data : formData,
                type : "POST",
                url: "/admin/event/editor_tmp_upload.php",
                dataType : 'json',
                cache: false,
                contentType : false,
                enctype : 'multipart/form-data',
                processData : false,
                success : function(data) {
                    $(el).summernote('editor.insertImage', data.url);
                    imgFileName[data.orgFile] = data.fileName;
                }
            });
        }

        /* imgFileName obj value 값으로 key 찾는 함수 */
        function getKeyValue(obj, value){
            return Object.keys(obj).find(key => obj[key] === value);
        }
        
        $("#color").spectrum({
            type: "component",
            showInput: true,
            showAlpha: false
        });

        $("input[name='client_sync']:radio").change(function () {
            //CLIENTS 동기화 여부.

                if(this.value == 'Y'){
                    $('#ev_key').val('');
                    $("input[name='ev_key']").attr("readonly",false);
                    $(".vendor").empty();
                    /* var tags = "<input type='text' class='form-control form-control-border' id='br_name' name='br_name' value=''>"; */
                    $(".vendor").append("<input type='text' class='form-control form-control-border' id='br_name' name='br_name' value='' readonly>");
                    $(".vendor").append("<input type='hidden' class='form-control form-control-border' id='br_code' name='br_code' value='' readonly>");
                    // $("#reservation").daterangepicker("option","disabled", true);
                    $("#reservation").attr('disabled', true);
                    $("#reservation2").attr('disabled', true);
                }else{
                    $('#ev_key').val("<?php echo  $API ?>");
                    $("input[name='ev_key']").attr("readonly",true);$(".vendor").empty();
                    $(".vendor").append("<?php echo $options;?>");
                    $("#reservation").attr('disabled', false);
                    $("#reservation2").attr('disabled', false);            
                }
        });

        $("#ev_key").on("change",function() {
            if($(this).val().length == 32){

                var type = "<?php echo $DB->hexAesEncrypt('INQUIRE_LIST'); ?>";
                //ConnectM 데이터 입력
                $.ajax({
                    url: "https://mprclients.mprkorea.com/event/api/apicall_event.php",
                    type : "POST",
                    dataType : "JSON",
                    data : {
                    event_key : $(this).val(), // API KEY 
                    type : type
                    }
                }).done(function(rs){	
                    if(rs.result){

                        // mpr_branch에 해당 업체가 등록되어있는지 확인
                        var br_code = $.trim(rs.br_code);
                        var i=0;
                        var isthere = false;

                        <?php
                            for($i=0; $i<count($br_code_arr); $i++){
                        ?>
                                if(br_code == "<?php echo $br_code_arr[$i]?>"){
                                    isthere = true;
                                }
                        <?php        
                            }
                        ?>
                        
                        if(isthere == false){
                            alert("등록되지 않은 업체입니다.");
                            $('#ev_subject').attr("disabled", true);
                            $('#save_btn').attr("disabled", true);
                            $('#br_name').attr("placeholder", "업체를 등록해주세요.");
                        }else{
                            var evCode_cl = rs.event_cd;
                            <?php 
                                $codeSQL = "SELECT ev_code FROM mpr_event";
                                $res = $DB -> query($codeSQL);
                                $cnt = $DB->single("SELECT count(*) FROM mpr_event");
                                if($cnt > 0){
                                    foreach($res as $row){
                            ?>          
                                        console.log(evCode_cl);
                                        console.log('<?php echo $row['ev_code']?>');
                                        if(evCode_cl == '<?php echo $row['ev_code']?>'){
                                            alert("이미 등록된 이벤트입니다.");
                                            $('#ev_key').val("");
                                        }else{
                                            $('#br_code').val($.trim(rs.br_code));
                                            $('#br_name').val($.trim(rs.cust_nm));
                                            $('#ev_subject').val(rs.event_nm);
                                            $('#ev_code').val(rs.event_cd);
                                            if($.trim(rs.continue) == 'Y'){
                                                $("input:checkbox[id='ev_always']").prop("checked", true); 
                                                $('#reservation2').data('daterangepicker').setEndDate('<?php echo $today;?>');
                                                $( "#reservation2" ).show();
                                                $( "#reservation" ).hide();
                                                $("input[name='reservation']").attr("readonly",false);
                                            }else{
                                                $("input:checkbox[id='ev_always']").prop("checked", false);                             
                                                $('#reservation').data('daterangepicker').setStartDate(rs.from);
                                                $('#reservation').data('daterangepicker').setEndDate(rs.to);
                                                $("input[name='reservation']").attr("readonly",true);
                                                $( "#reservation2" ).hide();
                                                $( "#reservation" ).show();
                                            } 
                                        }   
                            <?php
                                    }
                                }else{
                            ?>
                                    $('#br_code').val($.trim(rs.br_code));
                                    $('#br_name').val($.trim(rs.cust_nm));
                                    $('#ev_subject').val(rs.event_nm);
                                    $('#ev_code').val(rs.event_cd);
                                    if($.trim(rs.continue) == 'Y'){
                                        $("input:checkbox[id='ev_always']").prop("checked", true); 
                                        $('#reservation2').data('daterangepicker').setEndDate('<?php echo $today;?>');
                                        $( "#reservation2" ).show();
                                        $( "#reservation" ).hide();
                                        $("input[name='reservation']").attr("readonly",false);
                                    }else{
                                        $("input:checkbox[id='ev_always']").prop("checked", false);                             
                                        $('#reservation').data('daterangepicker').setStartDate(rs.from);
                                        $('#reservation').data('daterangepicker').setEndDate(rs.to);
                                        $("input[name='reservation']").attr("readonly",true);
                                        $( "#reservation2" ).hide();
                                        $( "#reservation" ).show();
                                    } 
                            <?php
                                }   
                            ?>
                        }
                        
                    }else{  
                        alert(rs.result +' : '+rs.message)
                    }
                }).fail(function(rs){
                    alert(rs.message); 
                    return false;
                }); 

                
            }else{
                console.log('XX');
            }
              //alert("Handler for .keyup() called.");
        });

        $("#br_code").change(function() {
            $("#brand_name").val($("#br_code option:checked").text()); 
        });


    });


    // daterangepicker
    $( function() {

        $("#ev_always").change(function(){

            if($('input[name=client_sync]:checked').val()=='Y'){
                if($("#ev_always").is(":checked")){
                    $("input:checkbox[id='ev_always']").prop("checked", false);                     
                }else{
                    $("input:checkbox[id='ev_always']").prop("checked", true);   
                }
                return false;
            }

            if($("#ev_always").is(":checked")){
                $( "#reservation2" ).show();
                $( "#reservation" ).hide();
                
            }else{
                
                $( "#reservation" ).show();
                $( "#reservation2" ).hide();
            }
        });
        // 상시진행 - x
        $( "#reservation" ).daterangepicker({
            <?php 
                if($end_Date == "0000-00-00"){
                    $end_Date = date("Y-m-d", strtotime("$start_Date +7 days"));
                }
            ?>
            locale:{ 
                format:'YYYY-MM-DD', //일시노출포맷
                applyLabel :"선택",
                cancelLabel:"취소",
                fromLabel: "From",
                toLabel: "To",
                daysOfWeek:["일","월","화","수","목","금","토"],
                monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"]
                },
                startDate: "<?php echo $start_Date ?>",
                endDate: "<?php echo $end_Date ?>",
                drops: "auto"
        });

        // 상시진행
        $( "#reservation2" ).daterangepicker({
            locale:{ 
                format:'YYYY-MM-DD', //일시노출포맷
                applyLabel :"선택",
                cancelLabel:"취소",
                fromLabel: "From",
                toLabel: "To",
                daysOfWeek:["일","월","화","수","목","금","토"],
                monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"]
                },
                startDate: "<?php echo $start_Date ?>",
                drops: "auto",
                singleDatePicker: true 
        });
    });    

    //ConnectM 이벤트 등록
    function callApi(type, ev_key, br_name, ev_subject, ev_code, start_Date, end_Date, is_always, br_code, url){        
        console.log(type+" "+ ev_key+" "+ br_name+" "+ ev_subject+" "+ ev_code+" "+ start_Date+" "+ end_Date+" "+ is_always+" "+ br_code+" "+ url);
        var command =''
        if(type=='insert'){
            command = "<?php echo $DB->hexAesEncrypt('INSERT_EVENT'); ?>";
        }else if(type=='update'){
            command = "<?php echo $DB->hexAesEncrypt('UPDATE_EVENT'); ?>";
        }else{            
            command = "<?php echo $DB->hexAesEncrypt('DELETE_EVENT'); ?>";
        }
        $.ajax({
            url: "https://mprclients.mprkorea.com/event/api/apicall_event.php",
            type : "POST",
            dataType : "JSON",
            data : {
                type          : command,
                event_key     : ev_key,      //이벤트키
                br_code       : br_code,    //업체코드
                cust_nm       : br_name,    //업체이름
                event_nm      : ev_subject, //이벤트제목
                event_cd      : ev_code,     //이벤트 코드
                expose_from   : start_Date,  //시작일
                expose_to     : end_Date,    //종료일
                expose_always : is_always,   //상시체크
                event_url     : url,         //이벤트키
                reg_id        : '<?php echo $_SESSION['userId']; ?>'
            }
        }).done(function(rs){	
            if(rs.result){                
                console.log(rs.result +' : '+rs.message);
            }else{  
                alert(rs.result +' : '+rs.message)
            }
        }).fail(function(rs){
            alert(rs.message); 
            return false;
        }); 
    }


    /* 폼 필수여부 활성화 / 비활성화 */

    $( function() {

        // 기본 폼
        $("#ev_name_yn").change(function(){
            if($("#ev_name_yn").is(":checked")){
                $("#ev_name_req").attr("disabled", false);
            }else{
                $("#ev_name_req").attr("disabled", true);
                $("#ev_name_req").attr("checked", false);
            }
        });
        $("#ev_tel_yn").change(function(){
            if($("#ev_tel_yn").is(":checked")){
                $("#ev_tel_req").attr("disabled", false);
            }else{
                $("#ev_tel_req").attr("disabled", true);
                $("#ev_tel_req").attr("checked", false);
            }
        });

        // 추가 폼
        $("#ev_sex_yn").change(function(){
            if($("#ev_sex_yn").is(":checked")){
                $("#ev_sex_req").attr("disabled", false);
            }else{
                $("#ev_sex_req").attr("disabled", true);
                $("#ev_sex_req").attr("checked", false);
            }
        });
        $("#ev_age_yn").change(function(){
            if($("#ev_age_yn").is(":checked")){
                $("#ev_age_req").attr("disabled", false);
            }else{
                $("#ev_age_req").attr("disabled", true);
                $("#ev_age_req").attr("checked", false);
            }
        });
        $("#ev_comment_yn").change(function(){
            if($("#ev_comment_yn").is(":checked")){
                $("#ev_comment_req").attr("disabled", false);
            }else{
                $("#ev_comment_req").attr("disabled", true);
                $("#ev_comment_req").attr("checked", false);
            }
        });
        $("#ev_birthday_yn").change(function(){
            if($("#ev_birthday_yn").is(":checked")){
                $("#ev_birthday_req").attr("disabled", false);
            }else{
                $("#ev_birthday_req").attr("disabled", true);
                $("#ev_birthday_req").attr("checked", false);
            }
        });
        $("#ev_rec_person_yn").change(function(){
            if($("#ev_rec_person_yn").is(":checked")){
                $("#ev_rec_person_req").attr("disabled", false);
            }else{
                $("#ev_rec_person_req").attr("disabled", true);
                $("#ev_rec_person_req").attr("checked", false);
            }
        });
        $("#ev_counsel_time_yn").change(function(){
            if($("#ev_counsel_time_yn").is(":checked")){
                $("#ev_counsel_time_req").attr("disabled", false);
            }else{
                $("#ev_counsel_time_req").attr("disabled", true);
                $("#ev_counsel_time_req").attr("checked", false);
            }
        });
    });
</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>이벤트 관리</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" id="event-form">
                                        <input type="hidden" name="ev_code" id="ev_code" value="<?php echo $event_cd;?>">
                                        <input type="hidden" name="brand_name" id="brand_name" value="">
                                        <table id="event-form-table" class="table table-bordered" style="table-layout:fixed">
                                            <tbody>

                                                <!-- 1 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_type">등록 양식</label>
                                                    </th>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="ev_type" id="ev_type_f" value="F" checked <?php echo $_REQUEST['mode'] == 'update' ? 'onclick="return(false);"' : '' ?>>
                                                                <label class="form-check-label" for="ev_type_f">기본형</label>
                                                            </div>
                                                            <div class="form-check ml-3">
                                                                <input class="form-check-input" type="radio" name="ev_type" id="ev_type_m" value="M" <?php echo $_REQUEST['mode'] == 'update' ? 'onclick="return(false);"' : '' ?>>
                                                                <label class="form-check-label" for="ev_type_m">사용자 지정</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <th>
                                                        <label for="is_sync">CLIENTS 동기화 여부</label>
                                                    </th>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="client_sync" id="is_sync_y" value="Y" 
                                                                <?php echo substr($result['ev_code'], 0,1) == 'M' ? "checked" : "" ?>
                                                                <?php echo $_REQUEST['mode'] == 'update' ? 'onclick="return(false);"' : '' ?>>
                                                                <label class="form-check-label" for="is_sync_y">사용</label>
                                                            </div>
                                                            <div class="form-check ml-3">
                                                                <input class="form-check-input" type="radio" name="client_sync" id="is_sync_n" value="N" 
                                                                <?php echo substr($result['ev_code'], 0,1) != 'M' ? "checked" : "" ?>
                                                                <?php echo $_REQUEST['mode'] == 'update' ? 'onclick="return(false);"' : '' ?>>
                                                                <label class="form-check-label" for="is_sync_n">미사용</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 2 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_key">이벤트 API KEY</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-border ev_key" style="text-transform: uppercase;" id="ev_key" name="ev_key" value="<?php echo  $API ?>" readonly="readonly">
                                                    </td>
                                                    <th>
                                                        <label for="br_code">업체 선택</label>
                                                    </th>
                                                    <td class='vendor'>
                                                        
                                                    </td>
                                                </tr>

                                                <!-- 3 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_subject">이벤트 제목</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control form-control-border" id="ev_subject" name="ev_subject" autocomplete="off"  value="<?php echo $result['ev_subject']?>" placeholder="이벤트 제목 입력...">                                                    
                                                    </td>
                                                </tr>

                                                <!-- 4 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_top_content_pc">이벤트 PC 상단 이미지</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <textarea class="editor_textarea" id="ev_top_content_pc" name="ev_top_content_pc"><?php echo $top_pc_content?></textarea>
                                                        
                                                        
                                                    </td>
                                                </tr>

                                                <!-- 5 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_top_content_mo">이벤트 모바일 상단 이미지</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <textarea class="editor_textarea" id="ev_top_content_mo" name="ev_top_content_mo"><?php echo $top_mo_content?></textarea>
                                                    </td>
                                                </tr>

                                                <!-- 6 line -->
                                                <tr>
                                                    <th>
                                                        <label for="">이벤트 입력 폼 형식</label>
                                                    </th>
                                                    <td>
                                                        <legend>기본 폼</legend>
                                                        <div class="d-flex form_div">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="ev_name_yn" name="ev_name_yn" <?php echo $is_name_checked?>>
                                                                <label for="ev_name_yn" class="custom-control-label">이름</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_tel_yn" name="ev_tel_yn" <?php echo $is_tel_checked?>>
                                                                <label for="ev_tel_yn" class="custom-control-label">연락처</label>
                                                            </div>
                                                        </div>
                                                        <legend>입력 필수 여부</legend>
                                                        <div class="d-flex">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="ev_name_req" name="ev_name_req" <?php echo $is_name_req_checked?>>
                                                                <label for="ev_name_req" class="custom-control-label">이름</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_tel_req" name="ev_tel_req" <?php echo $is_tel_req_checked?>>
                                                                <label for="ev_tel_req" class="custom-control-label">연락처</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td colspan="2">
                                                        <legend>추가 폼</legend>
                                                        <div class="d-flex form_div">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="ev_sex_yn" name="ev_sex_yn" <?php echo $is_sex_checked?>>
                                                                <label for="ev_sex_yn" class="custom-control-label">성별</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_age_yn" name="ev_age_yn" <?php echo $is_age_checked?>>
                                                                <label for="ev_age_yn" class="custom-control-label">나이</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_comment_yn" name="ev_comment_yn" <?php echo $is_comment_checked?>>
                                                                <label for="ev_comment_yn" class="custom-control-label">문의사항</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_birthday_yn" name="ev_birthday_yn" <?php echo $is_birth_checked?>>
                                                                <label for="ev_birthday_yn" class="custom-control-label">생년월일</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_rec_person_yn" name="ev_rec_person_yn" <?php echo $is_ev_rec_person_checked?>>
                                                                <label for="ev_rec_person_yn" class="custom-control-label">추천인</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_counsel_time_yn" name="ev_counsel_time_yn" <?php echo $is_counsel_time_checked?>>
                                                                <label for="ev_counsel_time_yn" class="custom-control-label">연락가능시간대</label>
                                                            </div>
                                                        </div>
                                                        <legend>입력 필수 여부</legend>
                                                        <div class="d-flex">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="ev_sex_req" name="ev_sex_req" disabled <?php echo $is_sex_req_checked?>>
                                                                <label for="ev_sex_req" class="custom-control-label">성별</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_age_req" name="ev_age_req" disabled <?php echo $is_age_req_checked?>>
                                                                <label for="ev_age_req" class="custom-control-label">나이</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_comment_req" name="ev_comment_req" disabled <?php echo $is_comment_req_checked?>>
                                                                <label for="ev_comment_req" class="custom-control-label">문의사항</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_birthday_req" name="ev_birthday_req" disabled <?php echo $is_birth_req_checked?>>
                                                                <label for="ev_birthday_req" class="custom-control-label">생년월일</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_rec_person_req" name="ev_rec_person_req" disabled <?php echo $is_ev_rec_person_req_checked?>>
                                                                <label for="ev_rec_person_req" class="custom-control-label">추천인</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox ml-3">
                                                                <input class="custom-control-input" type="checkbox" id="ev_counsel_time_req" name="ev_counsel_time_req" disabled <?php echo $is_counsel_time_req_checked?>>
                                                                <label for="ev_counsel_time_req" class="custom-control-label">연락가능시간대</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>이벤트 배경 색상</th>
                                                    <td colspan="3"><input type="text" class="form-control col-3" id="color" value="<?php echo $ev_color?>"/></td>
                                                </tr>
                                                <!-- 7 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_bottom_content_pc">이벤트 PC 하단 이미지</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <textarea class="editor_textarea" id="ev_bottom_content_pc" name="ev_bottom_content_pc"><?php echo $bottom_pc_content?></textarea>
                                                    </td>
                                                </tr>

                                                <!-- 8 line -->
                                                <tr>
                                                    <th>
                                                        <label for="ev_bottom_content_mo">이벤트 모바일 하단 이미지</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <textarea class="editor_textarea" id="ev_bottom_content_mo" name="ev_bottom_content_mo"><?php echo $bottom_mo_content?></textarea>
                                                    </td>
                                                </tr>

                                                <!-- 9 line -->
                                                <tr>
                                                    <th>
                                                        <label for="">이벤트 기간</label>
                                                    </th>
                                                    <td colspan="3">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="ev_always" name="ev_always" <?php echo $is_ev_always_checked ?>>
                                                                <label for="ev_always" class="custom-control-label">상시 진행</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" >
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                                </div>
                                                                <input type="text" class="form-control float-right" id="reservation" name="reservation" style="height:30px; width:220px; margin-right:5px;">
                                                                <input type="text" class="form-control float-right" id="reservation2" name="reservation2" style="height:30px; width:220px; margin-right:5px; display:none;">
                                                            </div>
                                                            <!-- /.input group -->
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Confirm line -->
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="d-flex justify-content-between">
                                                        <div class="d-flex">
                                                            <!-- <a href = "javascript:popup_Open()" target = "_blank">미리보기</a> -->
                                                            <button type="button" class="btn btn-info"  onclick="popup_Open()">미리보기</button>
                                                            <!-- <button type="button" class="btn btn-info"   onclick="window.open('/admin/event/preview.php','new','scrollbars=yes,resizable=no width=500 height=600, left=-1220,top=200');return false">미리보기</button> -->
                                                        </div>
                                                        <div class="d-flex">
                                                            <a href="/admin/event/" class="btn btn-default" style="margin-right:5px;">취소</a>
                                                            <input type="button" class="btn btn-info" value="저장" id="<?php echo $btn_value; ?>" name="<?php echo $btn_value; ?>" style="margin-right:5px;">                                                        
                                                            <input type="button" class="btn btn-danger" value="삭제" id="delete_btn" name="delete_btn" style="display:none;">                                                        
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" aria-label="Close" style="text-align:right;" onclick="modal_close()">
                        <span aria-hidden="true" style="margin:10px;">x</span>
                    </button>
                    <div class="modal-body">
                        <p id="alert_msg"></p>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-info" onclick="modal_close();">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

</div>


<script>
    /* 모달 */ 
    function alertMsg(){
        $("#modal-default").modal("show");
        return false;
    }
    function modal_close(){
        $("#modal-default").modal("hide");
        return false;
    }

    /* 미리보기 팝업 */
    function popup_Open(){
        var url = "/admin/event/preview.php";
        var name = "show_preview";
        var option = "width = 1800, height =1000, top = 100, left = 100, scrollbars=yes, resizable=yes";
        window.open(url, name, option);

        return false;
    }
    
</script>

<script>

    var subject_regex = /^[a-zA-Z가-힣0-9 ]+$/;

    <?php if(!$_GET['idx']){?>
    /* 이벤트 등록 버튼 */
    $("#save_btn").on("click", function(){

        var brCode = $("#br_code").val();
        var ev_always_Check = $("#ev_always").is(":checked") ? "Y" : "N";
        var evURL = 'https://landings.mprkorea.com/page/?biz=' + $("#br_code").val() + '&code=' + $("#ev_key").val();
        var color = $("#color").val();

        var isok = true;
        var evStat = "";
        var today = new Date();
        today = today.toJSON().substr(0,10);
        
        if(ev_always_Check == "Y"){
            var start_Date  =  $("#reservation2").val();
            var end_Date = "";
            
            if(start_Date > today){
                evStat = "W";
            }else if(start_Date <= today){
                evStat = "Y";
            }
        }else{
            var start_Date = $("#reservation").val().split(" ")[0];
            var end_Date = $("#reservation").val().split(" ")[2];

            if(start_Date > today){
                evStat = "W";
            }else if((start_Date <= today) && (today <= end_Date)){
                evStat = "Y";
            }else if(end_Date < today){
                evStat = "N";
            }
        }
        
        if(start_Date == ""){
            start_Date = today;
        }

        var evSubject = $("#ev_subject").val();
        if( !(subject_regex.test(evSubject) && evSubject.length >= 3)){
            $("#alert_msg").text("이벤트 제목은 3자 이상의 한글, 영문, 숫자로만 입력가능합니다.");
            alertMsg();
            isok=false;
        }

        var evKey = $("#ev_key").val();
        if(evKey == ""){
            $("#alert_msg").text("이벤트 API KEY는 필수입니다.");
            alertMsg();
            isok=false;
        }
        if(brCode == null){
            $("#alert_msg").text("업체 선택은 필수입니다.");
            alertMsg();
            isok=false;
        }

        var regID = '<?php echo $_SESSION['userId']?>';
        var formData = $("form").serializeArray();
        
        var isSyncY = $("#is_sync_y").val();
        
        if(isSyncY == "Y" && ev_always_Check == "Y"){
            var formDate = $("#reservation2").val();
            formData.push({name : "reservation2", value : formDate});
        }else if(isSyncY == "Y" && ev_always_Check == "N"){
            var formDate = $("#reservation").val();
            formData.push({name : "reservation", value : formDate});
        }
        
        console.log(formData);
        
        if(isok){
            $.post("/admin/event/event_DB.php", {
                mode : 'register',
                formData : formData,
                brCode : brCode,
                evURL : evURL,
                evStat : evStat,
                regID : regID,
                color : color,
                imgFileName : imgFileName
            }, function(data){
                if ($.trim(data)=='OK') {
                    var evKey = $("#ev_key").val();
                    var brName = $("#brand_name").val();
                    var evCode = $("#ev_code").val();
                    
                    if($('input[name=client_sync]:checked').val()=='N'){
                       callApi("insert", evKey, brName, evSubject, evCode, start_Date, end_Date, ev_always_Check, brCode, evURL );     
                    }        
                    alert("등록되었습니다.");
                    location.href= "/admin/event/index.php";
                } else {
                    console.log($.trim(data));
                    alert("저장하지 못하였습니다.");
                }
            });
        }
        
    });

    <?php }?>

    <?php if($_GET['idx']){?>
    /* 수정 버튼 */
    $("#update_btn").on("click", function(){

        var brCode = $("#br_code").val();
        var ev_always_Check = $("#ev_always").is(":checked") ? "Y" : "N";
        var evURL = 'https://landings.mprkorea.com/page/?biz=' + $("#br_code").val() + '&code=' + $("#ev_key").val();
        var regID = '<?php echo $_SESSION['userId']?>';
        var color = $("#color").val();

        var isok = true;
        var evStat = "";
        var today = new Date();
        today = today.toJSON().substr(0,10);
        

        if(ev_always_Check == "Y"){
            var start_Date  =  $("#reservation2").val();
            var end_Date = "";
            
            
            if(start_Date > today){
                evStat = "W";
            }else if(start_Date <= today){
                evStat = "Y";
            }

        }else{
            var start_Date = $("#reservation").val().split(" ")[0];
            var end_Date = $("#reservation").val().split(" ")[2];

            if(start_Date > today){
                evStat = "W";
            }else if((start_Date <= today) && (today <= end_Date)){
                evStat = "Y";
            }else if(end_Date < today){
                evStat = "N";
            } 

        }
    
        if(start_Date == ""){
            start_Date = today;
        }

        var evSubject = $("#ev_subject").val();
        if( !(subject_regex.test(evSubject) && evSubject.length >= 3)){
            $("#alert_msg").text("이벤트 제목은 3자 이상의 한글, 영문, 숫자로만 입력가능합니다.");
            alertMsg();
            isok=false;
        }

        var imgFileName_del = [];

        var ev_top_content_pc = $("#ev_top_content_pc").val()
        var ev_top_content_mo = $("#ev_top_content_mo").val()
        var ev_bottom_content_pc = $("#ev_bottom_content_pc").val()
        var ev_bottom_content_mo = $("#ev_bottom_content_mo").val()


        // summernote에 올라온 사진 개수만큼 배열에 넣기
        var top_pc_count = ev_top_content_pc.split("src=\"").length-1;
        var top_mo_count = ev_top_content_mo.split("src=\"").length-1;
        var bottom_pc_count = ev_bottom_content_pc.split("src=\"").length-1;
        var bottom_mo_count = ev_bottom_content_mo.split("src=\"").length-1;

        var k=0;
        for(var i=0; i<top_pc_count; i++){
            
            top_pc = ev_top_content_pc.split("src=\"")[i+1];
            top_pc = top_pc.split("/")[5].split("\"")[0];
            console.log(top_pc);

            imgFileName_del[k++] = top_pc;

        }
        for(var i=0; i<top_mo_count; i++){
            
            top_mo = ev_top_content_mo.split("src=\"")[i+1];
            top_mo = top_mo.split("/")[5].split("\"")[0];
            console.log(top_mo);

            imgFileName_del[k++] = top_mo;

        }
        for(var i=0; i<bottom_pc_count; i++){
            
            bottom_pc = ev_bottom_content_pc.split("src=\"")[i+1];
            bottom_pc = bottom_pc.split("/")[5].split("\"")[0];
            console.log(bottom_pc);

            imgFileName_del[k++] = bottom_pc;

        }
        for(var i=0; i<bottom_mo_count; i++){
            
            bottom_mo = ev_bottom_content_mo.split("src=\"")[i+1];
            bottom_mo = bottom_mo.split("/")[5].split("\"")[0];
            console.log(bottom_mo);

            imgFileName_del[k++] = bottom_mo;

        }
        console.log(imgFileName_del);

        var formData = $("form").serializeArray();

        if(isok){
            var idx = <?php echo $_GET['idx']?>;
            $.post("/admin/event/event_DB.php", {
                mode : 'update',
                formData : formData,            
                brCode : brCode,
                evURL : evURL,
                evStat : evStat,
                regID : regID,
                idx : idx,
                color : color,
                imgFileName : imgFileName,
                imgFileName_del : imgFileName_del
            }, function(data){
                if ($.trim(data)=='OK') {   
                    var evKey = $("#ev_key").val();
                    var brName = $("#brand_name").val();
                    var evCode = $("#ev_code").val();
                                  
                    if('<?php echo substr($result['ev_code'], 0,1); ?>' != 'M'){
                        callApi("update", evKey, brName, evSubject, evCode, start_Date, end_Date, ev_always_Check, brCode, evURL);      
                    }              
                    alert("수정되었습니다.");
                    location.href= "/admin/event/index.php";
                } else {
                    alert("수정하지 못하였습니다.");
                }
            });
        }

    });
    <?php } ?>


    /* 삭제 버튼 */
    $("#delete_btn").on("click", function(){

        var brCode = $("#br_code").val();
        var evKey = $("#ev_key").val();

        if(confirm("삭제하시겠습니까?")){
            <?php if($_GET['idx']){?>
            var idx = <?php echo $_GET['idx']?>;
            <?php } ?>
            $.post("/admin/event/event_DB.php", {
                mode : 'delete',
                brCode : brCode,
                evKey : evKey, 
                idx : idx
            }, function(data){
                if ($.trim(data)=='OK') {
                    if('<?php echo substr($result['ev_code'], 0,1); ?>' != 'M'){
                        callApi("delete", $('#ev_key').val());
                    }
                    alert("삭제되었습니다.");
                    location.href= "/admin/event/index.php";             
                } else {
                    alert("삭제하지 못하였습니다.");
                }
            });
        }
    });
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>