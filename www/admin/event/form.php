<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    ob_start();

    $now_timestamp = time();
?>

<!-- API 코드 랜덤 발급 -->
<?php
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $id_len = rand(8,15);
    $var_size = strlen($chars);
    $random_str="";
    for( $i = 0; $i < $id_len ; $i++ ) {  
        $random_str= $random_str.$chars[ rand( 0, $var_size - 1 ) ];
    }
?>

<!-- 등록 / 수정 구분 -->
<?php
$top_pc_content = "";
$top_mo_content = "";
$bottom_pc_content = "";
$bottom_mo_content = "";

$company = "(1)";

$is_name_checked = "checked";
$is_tel_checked = "checked";
$w_stat = "checked";

$start_date = date("Y-m-d", time());
$timestamp = strtotime("$start_date +7days");
$end_date = date("Y-m-d", $timestamp);
$API = $random_str;


if ( trim($_GET['mode'])=='update' ) {
    $strSQL = "SELECT * FROM mpr_event WHERE idx = {$_GET['idx']}; ";
    $result = $DB -> row($strSQL);

    $API = $result['br_key'];
    $top_pc_content = $result['ev_top_content_pc'];
    $top_mo_content = $result['ev_top_content_mo'];
    $bottom_pc_content = $result['ev_bottom_content_pc'];
    $bottom_mo_content = $result['ev_bottom_content_mo'];
    $company = "br_code='{$result['br_code']}'";
    $start_date = $result['ev_start'];
    $end_date = $result['ev_end'];

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
           
           $('#br_key2').show();
           $('#ev_subject2').show();
           $('#update_btn').show();
           $('#ev_top_content_pc').val();
           
           $('#br_key').hide();
           $('#ev_subject').hide();
           $('#save_btn').hide();
       }

   </script>
<?php
}
?>


<script>
$(document).ready(function(){
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
        formData.append("files", file);
        formData.append("type", type);
        formData.append("API", key);
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
});
</script>

<?php
    $start_Date  =  $_POST["ev_start"];
    $end_Date = $_POST["ev_end"];

    //입력 받은 데이터 값이 null이 아닌 경우
    if (!empty($start_Date)){
        //입력 받은 데이터 값을 데이터 타입으로
        $startDate = new DateTime($start_Date);
        //형식을 Y년m월d일 형태로 표시
        $start_date = $startDate ->format( "Y-m-d" );
    }

    if (!empty($end_Date)){
        //입력 받은 데이터 값을 데이터 타입으로
        $endDate = new DateTime($end_Date);
        //형식을 Y년m월d일 형태로 표시
        $end_date = $endDate ->format( "Y-m-d" );
    }
?>

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
                                                    <label for="br_key">이벤트 API KEY</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control form-control-border" id="br_key" name="br_key" value="<?php echo  $API ?>" readonly>
                                                    <input type="text" class="form-control form-control-border" id="br_key2" name="br_key2" value="<?php echo $API?>" style="display:none;" readonly>
                                                </td>
                                                <th>
                                                    <label for="br_code">업체 선택</label>
                                                </th>
                                                <td>
                                                    <select class="custom-select form-control-border" id="br_code" name="br_code">
                                                        <?php
                                                            $S_SQL = "SELECT * FROM mpr_branch WHERE $company;";
                                                            $res = $DB -> query($S_SQL);
                                                            foreach($res as $row){
                                                        ?>
                                                            <option value="<?php echo $row['br_code']?>"><?php echo $row['br_name']?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <!-- 3 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_subject">이벤트 제목</label>
                                                </th>
                                                <td colspan="3">
                                                    <input type="text" class="form-control form-control-border" id="ev_subject" name="ev_subject" autocomplete="off" placeholder="이벤트 제목 입력...">
                                                    <input type="text" class="form-control form-control-border" id="ev_subject2" name="ev_subject2" value="<?php echo $result['ev_subject']?>" autocomplete="off" placeholder="이벤트 제목 입력..." style="display:none;">
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
                                                            <input class="custom-control-input" type="checkbox" id="ev_always" name="ev_always">
                                                            <label for="ev_always" class="custom-control-label">상시 진행</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ev_start">시작일</label>
                                                        <input type="date" class="form-control" name="ev_start" id="ev_start" value="<?php echo $start_date?>">
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="ev_end">종료일</label>
                                                            <input type="date" class="form-control" name="ev_end" id="ev_end" value="<?php echo $end_date?>">
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- 10 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_stat">상태</label>
                                                </th>
                                                <td colspan="3">
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_w" value="W" <?php echo $w_stat?>>
                                                            <label class="form-check-label" for="ev_stat_w">진행 예정</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_y" value="Y" <?php echo $y_stat?>>
                                                            <label class="form-check-label" for="ev_stat_y">진행중</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_n" value="N" <?php echo $n_stat?>>
                                                            <label class="form-check-label" for="ev_stat_n">종료</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Confirm line -->
                                            <tr>
                                                <td colspan="4">
                                                    <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-info">미리보기</button>
                                                    </div>
                                                    <div class="d-flex">
                                                        <a href="/admin/event/" class="btn btn-danger" style="margin-right:5px;">취소</a>
                                                        <input type="submit" class="btn btn-primary" value="저장" id="save_btn" name="save_btn">
                                                        <input type="submit" class="btn btn-primary" value="저장" id="update_btn" name="update_btn" style="display:none;">
                                                    </div>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

</div>

<?php

    $ev_subject = '/^[a-zA-Z가-힣 ]+$/';
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
        $ev_always = isset($_POST['ev_counsel_time_yn']) ? "Y" : "N";

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


        $url = 'landings.mprkorea.com/page/index?biz='.$_POST['br_code'].'&code='.$_POST['br_key'];

        $SQL = "INSERT INTO mpr_event (br_code, br_key, ev_type, ev_url, ev_subject, ev_top_content_pc, ev_top_content_mo ,ev_name_yn, ev_tel, ev_tel_yn, ev_sex_yn, ev_age_yn, ev_comment_yn, ev_birthday_yn, ev_rec_person_yn, ev_counsel_time_yn, ev_bottom_content_pc , ev_bottom_content_mo , ev_start , ev_end , ev_stat, reg_date, chg_date, del_yn) 
        VALUES ('{$_POST['br_code']}', '{$_POST['br_key']}' , '{$_POST['ev_type']}', '{$url}' ,'{$_POST['ev_subject']}','{$_POST['ev_top_content_pc']}','{$_POST['ev_top_content_mo']}' ,'{$name_check}', '010-3269-7977', '{$tel_check}', '{$sex_check}', '{$age_check}', '{$comment_check}', '{$birth_check}', '{$ev_rec_person_check}', '{$ev_counsel_time_check}', '{$_POST['ev_bottom_content_pc']}','{$_POST['ev_bottom_content_mo']}' , '{$start_date}', '{$end_date}' , '{$ev_stat}', now(), now(), 'N');";

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
        $ev_always = isset($_POST['ev_counsel_time_yn']) ? "Y" : "N";

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


        $url = 'landings.mprkorea.com/page/index?biz='.$_POST['br_code'].'&code='.$_POST['br_key2'];

        $UP_SQL = 
        "UPDATE 
            mpr_event 
        SET 
            br_code = '{$_POST['br_code']}', 
            br_key = '{$_POST['br_key2']}', 
            ev_type = '{$_POST['ev_type']}', 
            ev_url = '{$url}', 
            ev_subject = '{$_POST['ev_subject2']}', 
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
            ev_start = '{$start_date}', 
            ev_end = '{$end_date}', 
            ev_stat = '{$ev_stat}', 
            chg_date = now()
        WHERE
            idx = {$_GET['idx']};";
        if(preg_match($ev_subject, $_POST['ev_subject2']) && strlen($_POST['ev_subject2']) >= 3){
            $statement = $DB->query($UP_SQL);
            echo '<script> alert("수정되었습니다.");</script>';
            echo "<script>location.href='/admin/event/index.php'</script>";
        }else{
            $alert_msg = "ev_name_form_err";
        }
        
    }
?>

<!-- 모달 -->
<script>
    var msg = "<?php echo $alert_msg?>";
    if(msg != ""){
        if(msg == "ev_name_form_err"){
            $("#alert_msg").text("이벤트 제목은 3자 이상의 한글 또는 영문으로만 입력가능합니다.");
            document.getElementById('modal_btn').click();
        }
    }
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>