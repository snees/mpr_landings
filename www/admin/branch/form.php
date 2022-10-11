<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

<!-- 등록 / 수정 구분 -->
<?php
if ( trim($_GET['mode'])=='update' ) {
    $S_SQL = "SELECT * FROM mpr_branch WHERE br_code = '{$_GET['code']}'; ";
    $res = $DB -> row($S_SQL);
?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
       
        window.onload = function(){
            
            $('#exampleInputCompany2').show();
            $('#exampleInputCode2').show();
            $('#zip_code2').show();
            $('#address2').show();
            $('#reference2').show();
            $('#exampleInputTel2').show();
            $('#exampleInputEmail2').show();
            $('#update_btn').show();
            $('#delete_btn').show();
            $('#ev_stat_a').show();


            $('#register_div').css("width", "68%");
            $('#register_div').css("float", "left");
            $('#register_div').css("margin-right", "10px");
            $('#exampleInputCompany1').hide();
            $('#exampleInputCode1').hide();
            $('#zip_code1').hide();
            $('#address1').hide();
            $('#reference1').hide();
            $('#exampleInputTel1').hide();
            $('#exampleInputEmail1').hide();
            $('#sign_in_btn').hide();
        }


    </script>
<?php
}

?>

<!-- 업체 코드 랜덤 발급 -->
<?php
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $id_len = rand(4,6);
    $var_size = strlen($chars);
    $random_str="";
    for( $i = 0; $i < $id_len ; $i++ ) {  
        $random_str= $random_str.$chars[ rand( 0, $var_size - 1 ) ];
    }
?>
<script>
    console.log('<?php echo $random_str;?>');
</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>업체 등록</h1>
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
                                    <div class="card card-primary" id="register_div">
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form method="POST" id="branch-form">
                                            <div class="card-body">
                                                <!-- 업체 이름 -->
                                                <div class="form-group">
                                                    <label for="exampleInputCompany1">업체명 *</label>
                                                    <input type="text" class="form-control" id="exampleInputCompany1" name="br_name1" placeholder="업체명을 입력하세요" autocomplete='off' style="display:block">
                                                    <input type="text" class="form-control" id="exampleInputCompany2" name="br_name2" value="<?php echo $res['br_name']?>" autocomplete='off' style="display:none">
                                                </div>
                                                <!-- 업체 코드 -->
                                                <div class="form-group">
                                                    <label for="exampleInputCode1">업체 코드 *</label>
                                                    <input type="text" class="form-control" id="exampleInputCode1" name="br_code1" value="<?php echo $random_str;?>" readonly>
                                                    <input type="text" class="form-control" id="exampleInputCode2" name="br_code2" value="<?php echo $res['br_code']?>" readonly style="display:none">
                                                </div>
                                                <!-- 주소 -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="event-form-table">주소</label>
                                                        <div class="input-group col-3">
                                                            <input type="text" class="form-control" id="zip_code1" name="zip_code1" placeholder="우편 번호">
                                                            <input type="text" class="form-control" id="zip_code2" name="zip_code2" value="<?php echo $res['br_post']?>" style="display:none">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-block btn-info" onclick="address_search()">search</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" id="address1" name="address1" placeholder="주소">
                                                            <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $res['br_addr']?>" style="display:none">
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="text" class="form-control" id="detail_address" name="detail_address" placeholder="상세 주소">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="reference1" placeholder="참고항목" autocomplete='off'>
                                                    <input type="text" class="form-control" id="reference2" value="<?php echo $res['br_addr_etc']?>" style="display:none" placeholder="참고항목" autocomplete='off'>
                                                </div>
                                                <!-- 전화번호 -->
                                                <div class="form-group">
                                                    <label for="exampleInputTel1">전화번호</label>
                                                    <input type="text" class="form-control" name="br_tel1" id="exampleInputTel1" oninput="autoHyphen(this)" maxlength="13" placeholder="전화번호를 입력하세요." autocomplete='off'>
                                                    <input type="text" class="form-control" name="br_tel2" id="exampleInputTel2" oninput="autoHyphen(this)" maxlength="13" value="<?php echo $res['br_tel']?>" placeholder="전화번호를 입력하세요." autocomplete='off' style="display:none">
                                                </div>
                                                <!-- 이메일 -->
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">이메일 </label>
                                                    <input type="email" class="form-control" name="user_email1" id="exampleInputEmail1" placeholder="이메일을 입력하세요." autocomplete='off'>
                                                    <input type="email" class="form-control" name="user_email2" id="exampleInputEmail2" value="<?php echo $res['user_email']?>" placeholder="이메일을 입력하세요." autocomplete='off' style="display:none">
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                            <div class="card-footer d-flex" style="display:flex; justify-content:right;">
                                                <a href="/admin/branch/" class="btn btn-default" style="margin-right: 5px;">취소</a>
                                                <button type="submit" class="btn btn-info" name="sign_in_btn" id="sign_in_btn">저장</button>
                                                <button type="submit" class="btn btn-info" name="update_btn" id="update_btn" style="display:none; margin-right: 5px;">수정</button>
                                                <button type="submit" class="btn btn-danger" name="delete_btn" id="delete_btn" style="display:none;">삭제</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card card-primary" id="ev_stat_a" style="width:30%; display:none;">
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form method="POST" id="branch-form">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">진행 예정</label>
                                                    <ul style="list-style:none;" style="overflow: auto;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'W'";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'W'");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='float:left; margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
                                                                }
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <br>
                                                <div class="form-group" >
                                                    <label for="exampleInputEmail1">진행중</label>
                                                    <ul style="list-style:none;" style="overflow: auto;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'Y'";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'Y'");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='float:left; margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
                                                                }
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">종료</label>
                                                    <ul style="list-style:none;" style="overflow: auto;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'N'";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'N'");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='float:left; margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
                                                                }
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button type="button" class="btn btn-default" id="modal_btn" data-toggle="modal" data-target="#modal-default" style="display:none;">
            </button>
        </div>

        <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Default Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
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



<!-- 주소 찾기 -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function address_search() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수
                
                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }
        
                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("reference1").value = extraAddr;
                
                } else {
                    document.getElementById("reference1").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('zip_code1').value = data.zonecode;
                document.getElementById("address1").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("detail_address").focus();
            }
        }).open();
    }
</script>

<!-- autoHyphen -->
<script>
    const autoHyphen = (target) => {
        target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
    }
</script>  

<!-- 등록 버튼 눌렀을 때 -->

<?php
    
    $Phone = '/^(010|011|016|017|018|019)-[0-9]{3,4}-[0-9]{4}$/';
    $mail = '/^[a-zA-Z0-9]{1}[a-zA-Z0-9\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]{1}[a-z.]+[a-z]{1}[a-z]+)|([a-z]+))$/';
    $br_name = '/^[a-zA-Z가-힣 ]+$/';
    $alert_msg = "";
    
    if(array_key_exists('sign_in_btn',$_POST)){

        if(trim($_POST['zip_code1'])){
            $addr = $_POST['address1']." ".$_POST['detail_address'];
            $SQL = "INSERT INTO mpr_branch (user_id, br_code, br_name, br_post, br_addr, br_addr_etc, br_tel, user_email, reg_date, chg_date, del_yn) VALUES ('snees', '{$_POST['br_code1']}', '{$_POST['br_name1']}', {$_POST['zip_code1']}, '{$addr}', '{$_POST['reference1']}', '{$_POST['br_tel1']}' , '{$_POST['user_email1']}', now(), now(), 'N');";
        }else{
            $SQL = "INSERT INTO mpr_branch (user_id, br_code, br_name, br_tel, user_email, reg_date, chg_date, del_yn) VALUES ('snees', '{$_POST['br_code1']}', '{$_POST['br_name1']}', '{$_POST['br_tel1']}' ,'{$_POST['user_email1']}', now(), now(), 'N');";
        }

        // 업체명 입력 여부 확인
        if( trim($_POST['br_name1']) ){

            // 업체명 형식 확인
            if(preg_match($br_name, $_POST['br_name1']) && strlen($_POST['br_name1']) >= 3){

                // 전화번호 입력 여부 확인
                if( trim($_POST['br_tel1']) ){

                    // 전화번호 형식 확인
                    if( preg_match($Phone, $_POST['br_tel1']) ){
                        // 이메일 입력 여부 확인
                        if( trim($_POST['user_email1']) ){

                            // 이메일 형식 확인
                            if( preg_match($mail, $_POST['user_email1']) ){
                                $statement = $DB->query($SQL);
                                echo '<script> alert("등록되었습니다.");</script>';
                                echo "<script>location.href='/admin/branch/index.php'</script>";
                            }else{
                                $alert_msg = "email_form_err";
                            }

                        }else{
                            $statement = $DB->query($SQL);
                            echo '<script> alert("등록되었습니다.");</script>';
                            echo "<script>location.href='/admin/branch/index.php'</script>";
                        }

                    }else{
                        $statement = $DB->query($SQL);
                        $alert_msg = "tel_form_err";
                    }

                }else{
                    $statement = $DB->query($SQL);
                    echo '<script> alert("등록되었습니다.");</script>';
                    echo "<script>location.href='/admin/branch/index.php'</script>";
                }
            }else{
                $alert_msg = "c_name_form_err";
            }
            

        }else{
            $alert_msg = "c_name_input_err";
        }
    }

    // 수정 버튼 눌렀을때
    if(array_key_exists('update_btn', $_POST)){
        
        if(trim($_POST['zip_code2'])){
            $addr = $_POST['address2']." ".$_POST['detail_address'];

            $Up_SQL = 
            "UPDATE 
                mpr_branch 
            SET 
                user_id = 'snees', 
                br_code = '{$_POST['br_code2']}', 
                br_name = '{$_POST['br_name2']}', 
                br_post = {$_POST['zip_code2']}, 
                br_addr = '{$addr}' , 
                br_addr_etc = '{$_POST['reference2']}' , 
                br_tel = '{$_POST['br_tel2']}', 
                user_email = '{$_POST['user_email2']}', 
                chg_date = now()
            WHERE 
                br_code = '{$_GET['code']}'";
        }else{
            $Up_SQL = 
            "UPDATE 
                mpr_branch 
            SET 
                user_id = 'snees',
                br_code = '{$_POST['br_code2']}', 
                br_name = '{$_POST['br_name2']}' , 
                br_tel = '{$_POST['br_tel2']}', 
                user_email = '{$_POST['user_email2']}', 
                chg_date = now()
            WHERE 
                br_code = '{$_GET['code']}'";
        }

        // 업체명 입력 여부 확인
        if( trim($_POST['br_name2']) ){

            // 업체명 형식 확인
            if(preg_match($br_name, $_POST['br_name2']) && strlen($_POST['br_name2']) >= 3){

                // 전화번호 입력 여부 확인
                if( trim($_POST['br_tel2']) ){

                    // 전화번호 형식 확인
                    if( preg_match($Phone, $_POST['br_tel2']) ){
                        // 이메일 입력 여부 확인
                        if( trim($_POST['user_email2']) ){

                            // 이메일 형식 확인
                            if( preg_match($mail, $_POST['user_email2']) ){
                                $statement = $DB->query($Up_SQL);
                                echo '<script> alert("수정되었습니다.");</script>';
                                echo "<script>location.href='/admin/branch/index.php'</script>";
                            }else{
                                $alert_msg = "email_form_err";
                            }

                        }else{
                            $statement = $DB->query($Up_SQL);
                            echo '<script> alert("수정되었습니다.");</script>';
                            echo "<script>location.href='/admin/branch/index.php'</script>";
                        }

                    }else{
                        $alert_msg = "tel_form_err";
                    }

                }else{
                    $statement = $DB->query($Up_SQL);
                    echo '<script> alert("수정되었습니다.");</script>';
                    echo "<script>location.href='/admin/branch/index.php'</script>";
                }
            }else{
                $alert_msg = "c_name_form_err";
            }
            

        }else{
            $alert_msg = "c_name_input_err";
        }
    }

    // 삭제 버튼 눌렀을때
    if(array_key_exists('delete_btn', $_POST)){
?>
        <script>
            var question = confirm("삭제하시겠습니까?");
            if(question == true){
                var code = "<?php echo $_GET['code']?>";
                $.post("https://landings.mprkorea.com/admin/branch/branch_delete.php", {"code":code}, function(data){
                    alert("삭제되었습니다.");
                    location.href='/admin/branch/index.php';
                });
            }
        </script>
<?php
    }
?>

<!-- modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var msg = "<?php echo $alert_msg?>";
    if(msg != ""){
        switch(msg){
            case "email_form_err" : 
                $("#alert_msg").text("올바른 이메일 형식이 아닙니다.");
                document.getElementById('modal_btn').click();
                break;
            case "tel_form_err" :
                $("#alert_msg").text("전화번호의 형식이 맞지 않습니다.");
                document.getElementById('modal_btn').click();
                break;
            case "c_name_input_err" :
                $("#alert_msg").text("업체명을 입력하세요.");
                document.getElementById('modal_btn').click();
                break;
            case "c_name_form_err" :
                $("#alert_msg").text("업체명은 3자 이상의 한글 또는 영문으로만 입력가능합니다.");
                document.getElementById('modal_btn').click();
                break;
        }
    }
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>