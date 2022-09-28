<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
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
                                        <div class="card card-primary">
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                            <form method="POST" id="branch-form">
                                                <div class="card-body">
                                                    <!-- 업체 이름 -->
                                                    <div class="form-group">
                                                        <label for="exampleInputCompany1">업체명 *</label>
                                                        <input type="text" class="form-control" id="exampleInputCompany1" name="company_name" placeholder="업체명을 입력하세요" autocomplete='off'>
                                                    </div>
                                                    <!-- 업체 코드 -->
                                                    <div class="form-group">
                                                        <label for="exampleInputCode1">업체 코드 *</label>
                                                        <input type="text" class="form-control" id="exampleInputCode1" name="company_code" value="<?php echo $random_str;?>" readonly>
                                                    </div>
                                                    <!-- 주소 -->
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="event-form-table">주소</label>
                                                            <div class="input-group col-3">
                                                                <input type="text" class="form-control" id="zip_code" placeholder="우편 번호">
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-block btn-info" onclick="address_search()">search</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <input type="text" class="form-control" id="address" placeholder="주소">
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text" class="form-control" id="detail_address" placeholder="상세 주소">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="reference" placeholder="참고항목" autocomplete='off'>
                                                    </div>
                                                    <!-- 전화번호 -->
                                                    <div class="form-group">
                                                        <label for="exampleInputTel1">전화번호</label>
                                                        <input type="text" class="form-control" name="br_tel" id="exampleInputTel1" oninput="autoHyphen(this)" maxlength="13" placeholder="전화번호를 입력하세요." autocomplete='off'>
                                                    </div>
                                                    <!-- 이메일 -->
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">이메일 </label>
                                                        <input type="email" class="form-control" name="user_email" id="exampleInputEmail1" placeholder="이메일을 입력하세요." autocomplete='off'>
                                                    </div>
                                                </div>
                                        <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <a href="/admin/branch/" class="btn btn-default float-right">취소</a>
                                                    <button type="submit" class="btn btn-info float-right" name="sign_in_btn" style="margin-right: 5px;">Sign in</button>
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

<!-- 등록 버튼 눌렀을 때 -->

<?php
    
    $Phone = '/^(010|011|016|017|018|019)-[0-9]{3,4}-[0-9]{4}$/';
    $mail = '/^[a-zA-Z0-9]{1}[a-zA-Z0-9\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]{1}[a-z.]+[a-z]{1}[a-z]+)|([a-z]+))$/';
    $alert_msg = "";


    if(array_key_exists('sign_in_btn',$_POST)){
        // 업체명 조건
        if( trim($_POST['company_name']) && strlen(trim($_POST['company_name'])) >= 3){

            // 전화번호 입력 여부 확인
            if( trim($_POST['br_tel']) ){

                // 전화번호 형식 확인
                if( preg_match($Phone, $_POST['br_tel']) ){
                    // 이메일 입력 여부 확인
                    if( trim($_POST['user_email']) ){

                        // 이메일 형식 확인
                        if( preg_match($mail, $_POST['user_email']) ){
                            echo '<script> alert("등록되었습니다.");</script>';
                            echo "<script>location.href='/admin/branch/index.php'</script>";
                        }else{
                            $alert_msg = "email_form_err";
                        }

                    }else{
                        echo '<script> alert("등록되었습니다.");</script>';
                        echo "<script>location.href='/admin/branch/index.php'</script>";
                    }

                }else{
                    $alert_msg = "tel_form_err";
                }

            }else{
                echo '<script> alert("등록되었습니다.");</script>';
                echo "<script>location.href='/admin/branch/index.php'</script>";
            }

        }else{
            $alert_msg = "c_name_input_err";
        }
    }
?>

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
        }
    }
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>