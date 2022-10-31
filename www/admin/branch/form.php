<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

<style>
    :focus-visible{
        outline: none;
    }
</style>
<!-- 업체 코드 랜덤 발급 -->
<?php
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
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
        $userID = $res['user_id'];
?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
       
        window.onload = function(){
            
            $('#update_btn').show();
            $('#delete_btn').show();
            $('#ev_stat_a').show();
            $('#reg_map').hide();
            $('#up_map').show();
            $('#code_Addr').css("float","none")
            initMap("upMap", "<?php echo $res['br_name']?>");



            $('#register_div').css("width", "68%");
            $('#register_div').css("float", "left");
            $('#register_div').css("margin-right", "10px");
            $('#sign_in_btn').hide();

            $(".userId_div").append("<label for='in_UserID'>업체 아이디 *</label>");
            $(".userId_div").append("<input type='text' class='form-control' id='in_UserID' value='<?php echo $userID?>' disabled>");
            $(".userId_div").css("margin-right", "10px")
            
        }


    </script>
<?php
    }else{

        $code = $random_str;    // 업체 코드

        $userlvSQL = "SELECT user_lv FROM mpr_member WHERE user_id = '{$_SESSION['userId']}' AND del_yn='N'";
        $res = $DB->row($userlvSQL);
        $userLv = $res['user_lv'];
        if($userLv != 100){
            $userIdSQL = "SELECT user_id FROM mpr_member WHERE del_yn='N' AND user_lv = 100";
            $res = $DB->query($userIdSQL);   
            $options .= "<label for='user_id'>업체 아이디 *</label>";
            $options .= "<input type='text' list='user_id' class='form-control' id='in_UserID' autocomplete='off'>";
            $options .= "<datalist id='user_id'>";
            $options .= "<option disabled selected>업체 관리자 아이디를 선택해주세요.</option>";

            foreach($res as $row){
                $options .= "<option value='".$row['user_id']."'></option>";
            }
            $options .= "</datalist>";
?>
            <script>
                $(function(){
                    $(".userId_div").css("width", "20%");
                    $(".userId_div").css("margin-right", "10px");
                    $(".brCode_div").css("width", "20%");
                    $(".userId_div").append("<?php echo $options?>");

                    $('#up_map').hide();
                    initMap("regMap","MPR");
                });
            </script>
<?php
        }
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
                                        <form method="POST" id="branch-form">
                                            <div class="card-body">
                                                <!-- 업체 이름 -->
                                                <div class="form-group">
                                                    <label for="br_name">업체명 *</label>
                                                    <input type="text" class="form-control" id="br_name" name="br_name" placeholder="업체명을 입력하세요" autocomplete='off' value="<?php echo $res['br_name']?>" style="display:block">
                                                </div>
                                                <!-- 업체 코드 -->
                                                <div id="code_Addr" style="width : 60%; float:left; margin-right : 20px;">
                                                    <div class="form-group d-flex">
                                                        <div class="userId_div">
                                                        </div>
                                                        <div class="brCode_div">
                                                            <label for="br_code">업체 코드 *</label>
                                                            <input type="text" class="form-control" id="br_code" name="br_code" value="<?php echo $code;?>" disabled>
                                                        </div>
                                                    </div>
                                                    <!-- 주소 -->
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="event-form-table">주소</label>
                                                            <div class="input-group col-4">
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
                                                </div>
                                                <div class="card" id="reg_map">
                                                    <div class="card-body">
                                                        <div class="form-group" style="margin:0px">
                                                            <div id="regMap" style="width:100%; min-height: 25vh;"></div>
                                                        </div>
                                                    </div>
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
                                            <div class="card-footer d-flex" style="display:flex; justify-content:right;">
                                                <a href="/admin/branch/" class="btn btn-default" style="margin-right: 5px;">취소</a>
                                                <button type="button" class="btn btn-info" name="sign_in_btn" id="sign_in_btn">저장</button>
                                                <button type="button" class="btn btn-info" name="update_btn" id="update_btn" style="display:none; margin-right: 5px;">수정</button>
                                                <button type="button" class="btn btn-danger" name="delete_btn" id="delete_btn" style="display:none;">삭제</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card card-primary" id="ev_stat_a" style="display:none;">
                                        <form method="POST" id="branch-form">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>진행 예정</label>
                                                    <ul style="list-style:none; display:flex; flex-wrap:wrap;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'W' AND del_yn='N' ";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'W' AND del_yn='N' ");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
                                                                }
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <br>
                                                <div class="form-group" >
                                                    <label>진행중</label>
                                                    <ul style="list-style:none; display:flex; flex-wrap:wrap;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'Y' AND del_yn='N' ";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'Y' AND del_yn='N' ");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
                                                                }
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label>종료</label>
                                                    <ul style="list-style:none; display:flex; flex-wrap:wrap;">
                                                        <?php
                                                            $E_SQL = "SELECT ev_subject, idx FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'N' AND del_yn='N' ";
                                                            $e_res = $DB -> query($E_SQL);
                                                            $count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code='{$_GET['code']}' AND ev_stat = 'N' AND del_yn='N'");
                                                            if($count>0){
                                                                for($i=0; $i<$count; $i++){
                                                                    echo "<li style='margin-right:15px;'><a href='../event/form.php?mode=update&idx={$e_res[$i]['idx']}'>{$e_res[$i]['ev_subject']}</a></li>";
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
                                    <div class="card" style="margin:0px; display:none;" id="up_map">
                                        <form method="POST" id="branch-form">
                                            <div class="card-body">
                                                <div class="form-group" style="margin:0px">
                                                    <div id="upMap" style="width:100%; min-height: 30vh;"></div>
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
            </div>
        </div>
    </section>
    
</div>

<!-- 주소 -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqbwCkqqEzEY0xEzIu-ihiJLBlegyHM0I"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>

    /* 구글 맵 API */
    function initMap(id, brName) {
        var map = new google.maps.Map(document.getElementById(id), {
            zoom: 18,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var address = $("#address").val();                                  // DB에서 주소 가져와서 검색하거나 왼쪽과 같이 주소를 바로 코딩 
        if(!address.trim()){
            address = "부산 수영구 광남로 211";
        }
        var marker = null;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( {'address': address}, function(results, status) { // 주소값 입력 받은 후 경도 위도 변환해서 지도에 찍어주기
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker = new google.maps.Marker({
                map : map,
                title : brName,                                             // 마커에 마우스 포인트를 갖다댔을 때 뜨는 타이틀                                
                position: results[0].geometry.location});
                var content = brName;                                       // 말풍선 안에 들어갈 내용  // 마커를 클릭했을 때의 이벤트. 말풍선              
                var infowindow = new google.maps.InfoWindow({content: content});
                infowindow.open(map,marker);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    /* 주소 찾기 API */
    function address_search() {
        new daum.Postcode({
            oncomplete: function(data) {
                
                var addr = '';      // 주소 변수
                var extraAddr = ''; // 참고항목 변수
                
                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') {            // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else {                                        // 사용자가 지번 주소를 선택했을 경우(J)
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
                var mode = '<?php echo $_GET['mode']?>';
                if( mode == 'register' ){
                    initMap("regMap", $("#br_name").val());
                }else{
                    initMap("upMap", $("#br_name").val())
                }
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("detail_address").focus();
            }
        }).open();
    }

    /* autoHyphen */
    const autoHyphen = (target) => {
        target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
    }

    /* 모달 */
    function alertMsg(){
        $("#modal-default").modal("show");
        return false;
    }
    function modal_close(){
        $("#modal-default").modal("hide");
        return false;
    }
    
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

        <?php 
            if($userLv != 100){
        ?>
            /* 업체 아이디 입력 확인 */
            var userID = $("#in_UserID").val();
            if(!userID.trim()){
                $("#alert_msg").text("업체 아이디를 입력해주세요.");
                alertMsg();
                isok=false;
            }else{
                /* 업체 아이디 맞는지 확인 */
                var IdOK = false;
                <?php
                    $userSQL = "SELECT user_id FROM mpr_member WHERE del_yn='N' AND user_lv=100";
                    $res = $DB->query($userSQL);

                    foreach($res as $row){
                ?>
                        if(userID == "<?php echo $row['user_id']?>"){
                            IdOK = true;
                        }
                <?php
                    }
                ?>

                if(!IdOK){
                    $("#alert_msg").text("등록되지 않은 업체 아이디입니다.");
                    alertMsg();
                    isok=false;
                }
            }
        <?php 
            }else{
        ?>  
                userID = "<?php echo $_SESSION['userId']?>";
        <?php
            }
        ?>

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
                mode : 'register', 
                brName : brName, 
                brCode : brCode, 
                brPost : brPost, 
                brAddr : brAddr, 
                brRef : brRef, 
                brTel : brTel, 
                brMail : brMail,
                regID : userID
            }, function(data){
                if ($.trim(data)=='OK') {
                    alert("저장 되었습니다.");
                    location.href='/admin/branch/index.php';
                } else {
                    alert("저장하지 못하였습니다.");
                }
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
                "mode" : 'update',
                brName : brName, 
                brCode : brCode, 
                brPost : brPost, 
                brAddr : brAddr, 
                brRef : brRef, 
                brTel : brTel, 
                brMail : brMail, 
                nowPageCode : nowPageCode,
                regID : '<?php echo $_SESSION['userId']?>'
            }, function(data){
                if ($.trim(data)=='OK') {
                    alert("수정되었습니다.");
                    location.href='/admin/branch/index.php';
                } else {
                    alert("수정하지 못하였습니다.");
                }
            });
        }
    });


    $("#delete_btn").on("click", function(){

        var question = confirm("삭제하시겠습니까?");
        if(question){

            var nowPageCode = "<?php echo $_GET['code']?>";

            $.post("/admin/branch/branch_db.php", {
                "mode" : 'delete', nowPageCode : nowPageCode
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