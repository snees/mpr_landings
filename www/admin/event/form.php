<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    ob_start();

    $today = date("Y-m-d", time());
    $endDay = strtotime("$today +7 days");
    $endDay = date("Y-m-d", $endDay);

    $start_Date = $today;
    $end_Date = $endDay;
?>

<?php     
        //업체정보
        $company = "del_yn='N' order by (CASE WHEN SUBSTRING(br_name,1,1) RLIKE '[ㄱ-ㅎ가-힣]' THEN 1 WHEN SUBSTRING(br_name,1,1) RLIKE '[a-zA-Z]' THEN 2 ELSE 3 END), br_name";
        $br_code_arr = array();


        $S_SQL = "select * from mpr_branch where {$company} ";
        $res = $DB -> query($S_SQL);
        $options .= "<select class='custom-select form-control-border' id='br_code' name='br_code'>";
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
            
            $('#ev_top_content_pc').val();
            $('#delete_btn').show();
            
            if($("#ev_always").is(":checked")){
                $( "#reservation2" ).show();
                $( "#reservation" ).hide();
                    
            }else{
                $( "#reservation" ).show();
                $( "#reservation2" ).hide();                
            }
        }

    </script>
<?php
    }else{        
        $btn_value = 'save_btn';
        /* $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $id_len = rand(8,15);
        $var_size = strlen($chars);
        $random_str="";
        for( $i = 0; $i < $id_len ; $i++ ) {  
            $random_str= $random_str.$chars[ rand( 0, $var_size - 1 ) ];
        }   */  
        $strSQL = "select max(code_seq) +1 as seq from mpr_seq";
        $seq = $DB->single($strSQL);
        $event_cd = "L".substr(str_pad($seq, 6, 0, STR_PAD_LEFT),-6);    
        $API = $DB->hexAesEncrypt($random_str);

    }
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $(document).ready(function(){

        $('.vendor').append("<?php echo $options; ?>");

        var type;
        // summernote 구동
        $('.editor_textarea').summernote({
            height: 300,
            callbacks :{
                onImageUpload : function(files, editor, welEditable) {
                    type = this.name;
                    for(var i = files.length-1; i >= 0; i--){
                        sendFile(files[i], this);
                    }
                }
            }
        });
        function sendFile(file, el) {
            var formData = new FormData();
            var key = '<?php echo $API ?>';
            var code = $("#br_code").val();
            formData.append("files", file);
            formData.append("type", type);
            formData.append("API", key);
            formData.append("code", code);
            $.ajax({
                data : formData,
                type : "POST",
                url: "/admin/event/editor-upload.php",
                dataType : 'json',
                cache: false,
                contentType : false,
                enctype : 'multipart/form-data',
                processData : false,
                success : function(data) {
                    $(el).summernote('editor.insertImage', data.url);
                    
                }
            });
        }

        $("input[name='client_sync']:radio").change(function () {
            //CLIENTS 동기화 여부.
            var noticeCat = this.value;

                if(this.value == 'Y'){
                    $('.ev_key').val('');
                    $("input[name='ev_key']").attr("readonly",false);
                    $(".vendor").empty();
                    var tags = "<input type='text' class='form-control form-control-border' id='br_name' name='br_name' value=''>";
                    $(".vendor").append("<input type='text' class='form-control form-control-border' id='br_name' name='br_name' value=''>");
                    $(".vendor").append("<input type='hidden' class='form-control form-control-border' id='br_code' name='br_code' value=''>");
                    // $("#reservation").daterangepicker("option","disabled", true);
                    $("#reservation").attr('disabled', true);
                    $("#reservation2").attr('disabled', true);
                    $("#br_name").attr('readonly', true);
                }else{
                    $('#ev_key').val("<?php echo  $API ?>");
                    $("input[name='ev_key']").attr("readonly",true);$(".vendor").empty();
                    $(".vendor").append("<?php echo $options;?>");
                    $("#reservation").attr('disabled', false);
                    $("#reservation2").attr('disabled', false);            
                }
        });

        $("#ev_key").change(function() {
            if($(this).val().length == 32){

                var type = "<?php echo $DB->hexAesEncrypt('INQUIRE_LIST'); ?>";
                //ConnectM 데이터 입력
                $.ajax({
                    url: "https://mprclients.mprkorea.com/event/api/apicall_new.php",
                    type : "POST",
                    dataType : "JSON",
                    data : {
                    key : $(this).val(), // API KEY 
                    type : type
                    }
                }).done(function(rs){	
                    /* console.log($.trim(rs.result));
                    console.log($.trim(rs.message)); */
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
                                    <table id="event-form-table" class="table table-bordered">
                                        <tbody>

                                            <!-- 1 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_type">등록 양식</label>
                                                </th>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ev_type" id="ev_type_f" value="F" checked>
                                                            <label class="form-check-label" for="ev_type_f">기본형</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_type" id="ev_type_m" value="M">
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
                                                            <input class="form-check-input" type="radio" name="client_sync" id="is_sync_y" value="Y">
                                                            <label class="form-check-label" for="is_sync_y">사용</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="client_sync" id="is_sync_n" value="N" checked>
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
                                                    <input type="text" class="form-control form-control-border ev_key" style="text-transform: uppercase;" id="ev_key" name="ev_key" value="<?php echo  $API ?>" readonly>
                                                    <!-- <input type="text" class="form-control form-control-border" id="ev_key2" name="ev_key2" value="<?php echo $API?>" style="display:none;" readonly> -->
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
                                                    <label for="">폼 형식</label>
                                                </th>
                                                <td>
                                                    <legend>기본 폼</legend>
                                                    <div class="d-flex">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="ev_name_yn" name="ev_name_yn" <?php echo $is_name_checked?>>
                                                            <label for="ev_name_yn" class="custom-control-label">이름</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_tel_yn" name="ev_tel_yn" <?php echo $is_tel_checked?>>
                                                            <label for="ev_tel_yn" class="custom-control-label">연락처</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <legend>추가 폼</legend>
                                                    <div class="d-flex">
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
                                                </td>
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
                                                        <input type="submit" class="btn btn-info" value="저장" id="<?php echo $btn_value; ?>" name="<?php echo $btn_value; ?>">                                                        
                                                        <input type="submit" class="btn btn-danger" value="삭제" id="delete_btn" name="delete_btn" style="display:none;">                                                        
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
            <button type="button" class="btn btn-default" id="modal_btn" data-toggle="modal" data-target="#modal-default" style="display:none;"></button>
        </div>
        <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Default Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="alert_msg"></p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                        <button type="button" class="btn btn-default">확인</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

</div>

<?php

    $ev_subject = '/^[a-zA-Z가-힣0-9 ]+$/';
    $alert_msg = "";

    // 이벤트 신규 등록 버튼
    if(array_key_exists('save_btn', $_POST)){

        $name_check = isset($_POST['ev_name_yn']) ? "Y" : "N";
        $tel_check = isset($_POST['ev_tel_yn']) ? "Y" : "N";
        $sex_check = isset($_POST['ev_sex_yn']) ? "Y" : "N";
        $age_check = isset($_POST['ev_age_yn']) ? "Y" : "N";
        $comment_check = isset($_POST['ev_comment_yn']) ? "Y" : "N";
        $birth_check = isset($_POST['ev_birthday_yn']) ? "Y" : "N";
        $ev_rec_person_check = isset($_POST['ev_rec_person_yn']) ? "Y" : "N";
        $ev_counsel_time_check = isset($_POST['ev_counsel_time_yn']) ? "Y" : "N";
        $ev_always_check = isset($_POST['ev_always']) ? "Y" : "N";

        if($ev_always_check == "Y"){
            $start_Date  =  $_POST["reservation2"];
            $end_Date = "";
        }else{
            $start_Date  =  explode(" ", $_POST["reservation"])[0];
            $end_Date = explode(" ", $_POST["reservation"])[2];
        }
        
        $now = date("Y-m-d");
        $str_now = strtotime($now);
        $str_start = strtotime($start_Date);
        $str_end = strtotime($end_Date);

        if($str_start > $str_now){
            $ev_stat = "W";
        }else if($str_start <= $str_now && $str_now <= $str_end){
            $ev_stat = "Y";
        }else if($str_end < $str_now){
            $ev_stat = "N";
        }

        if($start_Date == ""){
            $start_Date = $today;
        }

        $url = 'landings.mprkorea.com/page/?biz='.$_POST['br_code'].'&code='.$_POST['ev_key'];

        $SQL = 
        "INSERT INTO 
            mpr_event
            (br_code, ev_code, ev_key, ev_type, ev_url, ev_subject, 
            ev_top_content_pc, ev_top_content_mo ,ev_name_yn, ev_tel_req, 
            ev_tel_yn, ev_sex_yn, ev_age_yn, ev_comment_yn, ev_birthday_yn, 
            ev_rec_person_yn, ev_counsel_time_yn, ev_bottom_content_pc , 
            ev_bottom_content_mo , ev_always , ev_start , ev_end , ev_stat, reg_date, chg_date, del_yn) 
        VALUES 
            ('{$_POST['br_code']}', '{$_POST['ev_code']}', '{$_POST['ev_key']}' , '{$_POST['ev_type']}', '{$url}' ,'{$_POST['ev_subject']}',
            '{$_POST['ev_top_content_pc']}','{$_POST['ev_top_content_mo']}' ,'{$name_check}', '010-3269-7977', 
            '{$tel_check}', '{$sex_check}', '{$age_check}', '{$comment_check}', '{$birth_check}', 
            '{$ev_rec_person_check}', '{$ev_counsel_time_check}', '{$_POST['ev_bottom_content_pc']}',
            '{$_POST['ev_bottom_content_mo']}' , '{$ev_always_check}' , '{$start_Date}', '{$end_Date}' , '{$ev_stat}', now(), now(), 'N');";

        if(preg_match($ev_subject, $_POST['ev_subject']) && strlen($_POST['ev_subject']) >= 3){
            $statement = $DB->query($SQL);
            echo '<script> alert("등록되었습니다.");</script>';
            echo "<script>location.href='/admin/event/index.php'</script>";
        }else{
            $alert_msg = "ev_name_form_err";
        }
        
    }

    // 기존 이벤트 수정 버튼
    if(array_key_exists('update_btn', $_POST)){        

        $name_check = isset($_POST['ev_name_yn']) ? "Y" : "N";
        $tel_check = isset($_POST['ev_tel_yn']) ? "Y" : "N";
        $sex_check = isset($_POST['ev_sex_yn']) ? "Y" : "N";
        $age_check = isset($_POST['ev_age_yn']) ? "Y" : "N";
        $comment_check = isset($_POST['ev_comment_yn']) ? "Y" : "N";
        $birth_check = isset($_POST['ev_birthday_yn']) ? "Y" : "N";
        $ev_rec_person_check = isset($_POST['ev_rec_person_yn']) ? "Y" : "N";
        $ev_counsel_time_check = isset($_POST['ev_counsel_time_yn']) ? "Y" : "N";
        $ev_always_check = isset($_POST['ev_always']) ? "Y" : "N";

        if($ev_always_check == "Y"){
            $start_Date  =  $_POST["reservation2"];
            $end_Date = "";
        }else{
            $start_Date  =  explode(" ", $_POST["reservation"])[0];
            $end_Date = explode(" ", $_POST["reservation"])[2];
        }

        $now = date("Y-m-d");
        $str_now = strtotime($now);
        $str_start = strtotime($start_Date);
        $str_end = strtotime($end_Date);

        if($str_start > $str_now){
            $ev_stat = "W";
        }else if($str_start <= $str_now && $str_now <= $str_end){
            $ev_stat = "Y";
        }else if($str_end < $str_now){
            $ev_stat = "N";
        }
        


        $url = 'landings.mprkorea.com/page/index?biz='.$_POST['br_code'].'&code='.$_POST['ev_key2'];

        $UP_SQL = 
        "UPDATE 
            mpr_event 
        SET 
            br_code = '{$_POST['br_code']}', 
            ev_key = '{$_POST['ev_key']}', 
            ev_type = '{$_POST['ev_type']}', 
            ev_url = '{$url}', 
            ev_subject = '{$_POST['ev_subject']}', 
            ev_top_content_pc = '{$_POST['ev_top_content_pc']}', 
            ev_top_content_mo = '{$_POST['ev_top_content_mo']}' ,
            ev_name_yn = '{$name_check}', 
            ev_tel_yn = '{$tel_check}', 
            ev_sex_yn = '{$sex_check}', 
            ev_age_yn = '{$age_check}', 
            ev_comment_yn = '{$comment_check}', 
            ev_birthday_yn = '{$birth_check}', 
            ev_rec_person_yn = '{$ev_rec_person_check}', 
            ev_counsel_time_yn = '{$ev_counsel_time_check}', 
            ev_bottom_content_pc =  '{$_POST['ev_bottom_content_pc']}', 
            ev_bottom_content_mo = '{$_POST['ev_bottom_content_mo']}',
            ev_always = '{$ev_always_check}',
            ev_start = '{$start_Date}', 
            ev_end = '{$end_Date}', 
            ev_stat = '{$ev_stat}', 
            chg_date = now()
        WHERE
            idx = {$_GET['idx']};";
        if(preg_match($ev_subject, $_POST['ev_subject']) && strlen($_POST['ev_subject']) >= 3){
            $statement = $DB->query($UP_SQL);
            echo '<script> alert("수정되었습니다.");</script>';
            echo "<script>location.href='/admin/event/index.php'</script>";
        }else{
            $alert_msg = "ev_name_form_err";
        }
        
    }

    if(array_key_exists("delete_btn", $_POST)){
?>
        <script>
            var question = confirm("삭제하시겠습니까?");
            if(question == true){
                idx = <?php echo $_GET['idx']?>;
                $.post("https://landings.mprkorea.com/admin/event/event_delete.php", {"idx":idx}, function(data){
                    alert("삭제되었습니다.");
                    location.href='/admin/event/index.php';
                });
            }
        </script>
<?php
    }
        
?>


<script>
    //  모달 
    var msg = "<?php echo $alert_msg?>";
    if(msg != ""){
        if(msg == "ev_name_form_err"){
            $("#alert_msg").text("이벤트 제목은 3자 이상의 한글 또는 영문으로만 입력가능합니다.");
            document.getElementById('modal_btn').click();
        }
    }

    // 미리보기 팝업
    function popup_Open(){
        var url = "/admin/event/preview.php";
        var name = "show_preview";
        var option = "width = 500, height = 500, top = 100, left = 200, scrollbars=yes, resizable=yes";
        window.open(url, name, option);

        return false;
    }
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>