<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<!-- 등록 / 수정 구분 -->
<?php
    if ( trim($_GET['mode'])=='update' ) {
        $S_SQL = "SELECT * FROM mpr_branch WHERE br_code = '{$_GET['code']}'; ";
        $res = $DB -> row($S_SQL);
        $code = $res['br_code'];
?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
       
        window.onload = function(){
            
            $('#update_btn').show();
            $('#delete_btn').show();
            $('#ev_stat_a').show();


            $('#register_div').css("width", "68%");
            $('#register_div').css("float", "left");
            $('#register_div').css("margin-right", "10px");
            $('#sign_in_btn').hide();
        }


    </script>
<?php
    }else{
        $code = $random_str;
    }

?>

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
                                                    <label for="br_name">업체명 *</label>
                                                    <input type="text" class="form-control" id="br_name" name="br_name" placeholder="업체명을 입력하세요" autocomplete='off' value="<?php echo $res['br_name']?>" style="display:block">
                                                    
                                                </div>
                                                <!-- 업체 코드 -->
                                                <div class="form-group">
                                                    <label for="br_code">업체 코드 *</label>
                                                    <input type="text" class="form-control" id="br_code" name="br_code" value="<?php echo $code;?>" readonly>
                                                </div>
                                                <!-- 주소 -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="event-form-table">주소</label>
                                                        <div class="input-group col-3">
                                                            <input type="text" class="form-control" id="zip_code" name="zip_code"  value="<?php echo $res['br_post']?>" placeholder="우편 번호">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-block btn-info" onclick="address_search()">search</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $res['br_addr']?>" placeholder="주소">
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="text" class="form-control" id="detail_address" name="detail_address" placeholder="상세 주소">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="reference" value="<?php echo $res['br_addr_etc']?>" placeholder="참고항목" autocomplete='off'>
                                                </div>
                                                <!-- 전화번호 -->
                                                <div class="form-group">
                                                    <label for="exampleInputTel1">전화번호</label>
                                                    <input type="text" class="form-control" name="br_tel" id="br_tel" oninput="autoHyphen(this)" maxlength="13" value="<?php echo $res['br_tel']?>" placeholder="전화번호를 입력하세요." autocomplete='off'>
                                                </div>
                                                <!-- 이메일 -->
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">이메일 </label>
                                                    <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $res['user_email']?>" placeholder="이메일을 입력하세요." autocomplete='off'>
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                            <div class="card-footer d-flex" style="display:flex; justify-content:right;">
                                                <a href="/admin/branch/" class="btn btn-default" style="margin-right: 5px;">취소</a>
                                                <button type="button" class="btn btn-info" name="sign_in_btn" id="sign_in_btn">저장</button>
                                                <button type="button" class="btn btn-info" name="update_btn" id="update_btn" style="display:none; margin-right: 5px;">수정</button>
                                                <button type="button" class="btn btn-danger" name="delete_btn" id="delete_btn" style="display:none;">삭제</button>
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
                    document.getElementById("reference").value = extraAddr;
                
                } else {
                    document.getElementById("reference").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('zip_code').value = data.zonecode;
                document.getElementById("address").value = addr;
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


<script>
    function alertMsg(){
        $("#modal-default").modal("show");
        return false;
    }
    function modal_close(){
        $("#modal-default").modal("hide");
        return false;
    }
</script>

<script>

    /* 정규식 */
    var local_tel = /^((0(2|3[1-3]|4[1-4]|5[1-5]|6[1-4])))-(\d{3,4})-(\d{4})$/;
    var Phone = /^(?:(010-\d{4})|(01[1|6|7|8|9]-\d{3,4}))-(\d{4})$/;
    var mail = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
    var name_match = /^[a-zA-Z가-힣 ]+$/;
    var alert_msg = "";

    /* 등록 버튼 눌렀을 때 */
    $("#sign_in_btn").on("click", function(){

        var brName = $("#br_name").val();
        var brCode = $("#br_code").val();
        var brPost = $("#zip_code").val();
        var brAddr = $('#address').val() + " " + $("#detail_address").val();
        var brRef = $("#reference").val();
        var brTel = $("#br_tel").val();
        var brMail = $("#user_email").val();

        var isok = true;


        /* 업체명 입력 여부 확인 */
        if( brName.trim() ){

            /* 업체명 형식 확인 */
            if(!(name_match.test(brName) && brName.length >= 3)){
                $("#alert_msg").text("업체명은 3자 이상의 한글 또는 영문으로만 입력가능합니다.");
                alertMsg();
                isok=false;
            }
        }else{
            $("#alert_msg").text("업체명을 입력하세요.");
            alertMsg();
            isok=false;
        }

        /* 전화번호 입력 여부 확인 */
        if( brTel.trim() ) {

            /* 전화번호 형식 확인 */
            if( !(Phone.test(brTel)) ){
                if( !(local_tel.test(brTel)) ){
                    $("#alert_msg").text("전화번호의 형식이 맞지 않습니다.");
                    alertMsg();  
                    isok=false;
                }
            }
        }

        /* 이메일 입력 여부 확인 */
        if( brMail.trim() ){

            /* 이메일 형식 확인 */
            if( !(mail.test(brMail)) ){
                $("#alert_msg").text("올바른 이메일 형식이 아닙니다.");
                alertMsg();
                isok=false;
            }
        }

        console.log(isok);
        if(isok){
            $.post("/admin/branch/branch_db.php", {
                "mode" : 'register', "brName" : brName, "brCode" : brCode, "brPost" : brPost, "brAddr" : brAddr, "brRef" : brRef, "brTel" : brTel, "brMail" : brMail
            }, function(data){
                alert("저장 되었습니다.");
                location.href='/admin/branch/index.php';
                
            });
        }
    });


    /* 수정 버튼 눌렀을 때 */
    $("#update_btn").on("click", function(){

        var brName = $("#br_name").val();
        var brCode = $("#br_code").val();
        var brPost = $("#zip_code").val();
        var brAddr = $('#address').val() + " " + $("#detail_address").val();
        var brRef = $("#reference").val();
        var brTel = $("#br_tel").val();
        var brMail = $("#user_email").val();

        var nowPageCode = "<?php echo $_GET['code']?>";

        var isok = true;

        /* 업체명 입력 여부 확인 */
        if( brName.trim() ){

            /* 업체명 형식 확인 */
            if(!(name_match.test(brName) && brName.length >= 3)){
                $("#alert_msg").text("업체명은 3자 이상의 한글 또는 영문으로만 입력가능합니다.");
                alertMsg();
                isok=false;
            }
        }else{
            $("#alert_msg").text("업체명을 입력하세요.");
            alertMsg();
            isok=false;
        }

        /* 전화번호 입력 여부 확인 */
        if( brTel.trim() ) {

            /* 전화번호 형식 확인 */
            if( !(Phone.test(brTel)) ){
                if( !(local_tel.test(brTel)) ){
                    $("#alert_msg").text("전화번호의 형식이 맞지 않습니다.");
                    alertMsg();  
                    isok=false;
                }
            }
        }

        /* 이메일 입력 여부 확인 */
        if( brMail.trim() ){

            /* 이메일 형식 확인 */
            if( !(mail.test(brMail)) ){
                $("#alert_msg").text("올바른 이메일 형식이 아닙니다.");
                alertMsg();
                isok=false;
            }
        }

        if(isok){
            $.post("/admin/branch/branch_db.php", {
                "mode" : 'update', "brName" : brName, "brCode" : brCode, "brPost" : brPost, "brAddr" : brAddr, "brRef" : brRef, "brTel" : brTel, "brMail" : brMail, "nowPageCode" : nowPageCode
            }, function(data){
                alert("수정되었습니다.");
                location.href='/admin/branch/index.php';
                
            });
        }
    });


    $("#delete_btn").on("click", function(){
        var question = confirm("삭제하시겠습니까?");
        var mode = "delete";
        if(question){
            var code = "<?php echo $_GET['code']?>";
            $.post("/admin/branch/branch_delete.php", {
                code : code
            }, function(data){
                if ($.trim(data)=='OK') {
                    alert("삭제되었습니다.");
                    location.href='/admin/branch/index.php';
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