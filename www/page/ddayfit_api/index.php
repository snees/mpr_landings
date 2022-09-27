<?php include_once($_SERVER['DOCUMENT_ROOT'].'/head.php'); ?>
<body>
    <div class="ddayfit">
        <img src="<?php echo LANDING_URL ?>/ddayfit/01.jpg" alt="이벤트" class="img-responsive m-auto">
    
        <div class="container_manual">     
            <form name="fastAjax" id="fastAjax" onsubmit="return fastAjax_main(this);" class="counsel">
                <div class="box">
                    <div class="counselBox">
                        <div class="txt bold500 font-52">이&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;름</div>
                        <input type="text" placeholder="" name="wr_name" required>
                    </div>
                    <div class="counselBox">
                        <div class="txt bold500 font-52">나&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;이</div>
                        <input type="tel" placeholder="" name="wr_2" required>
                    </div>
                    <div class="counselBox">
                        <div class="txt bold500 font-52">전화번호</div>
                        <input type="tel" placeholder=" - 없이 입력" name="wr_1" required>
                    </div>      
                    <div class="checkBox">				
                        <input type="checkbox" id="agree_chk" name="agg" required checked>
                        <label for="agree_chk" class="font-24">개인정보 수집 및 이용에 관한 내용을 확인하고 동의함</label>
                        <a href="/info/privacy" tager="_blank" class="policy font-24">[자세히보기]</a>
                    </div>
                </div>
                
                <input type="submit" value="상담 신청하기" id="submitt" style="display:none">
                
                <a class="submit" href="javascript:void(0);" alt="상담 신청하기">
                    <img src="<?php echo LANDING_URL ?>/ddayfit/02.jpg" alt="이벤트" class="img-responsive m-auto"></a>
            </form>
        </div>

         

<script>	
    $(document).ready(function(){
        $("a.submit").click(function(){
            $("#submitt").trigger('click');
        }); 
    });
    
    function fastAjax_main(f) {
        var cate = "디데이핏";
        var name = f.wr_name.value;
        var phone = f.wr_1.value;
        var age = f.wr_2.value;
        var chkP = f.agg.checked;

        if (!name) { alert('이름을 입력하세요.'); f.wr_name.focus(); return false; }
        if (!phone) { alert('연락처를 입력하세요.'); f.wr_1.focus(); return false; }
        let reg_num = /^[0-9]{8,13}$/;
        if (reg_num.test(phone) === false) {
            alert('양식에 맞게(-없이 입력)를 올바르게 입력하세요.');
            f.wr_1.focus();
            return false;
        }
        if (!chkP) {
            alert('개인정보 취급방침에 동의는 필수입니다.');
            return false;
        }
        
        //ConnectM 데이터 입력
        $.ajax({
            url: "http://mprclients.mprkorea.com/event/api/apicall.php",
            type : "POST",
            dataType : "JSON",
            data : {
            key : "E2EAA9BE5443ADCC5CDC0A6B1B9763F2", /* API KEY */  
            cust_nm : name, /* 접수자 이름 (필수) */
            cust_hp : phone, /* 접수자연락처 (필수) */
            etc : { "cust_age" : age, "counsel" : "상담문의" } /* 기타추가항목 */
            }
        }).done(function(rs){	
            console.log($.trim(rs.result));
            if($.trim(rs.result)){
                /* alert('상담이 접수되었습니다.🙂'); */
                alert(rs.message); 
                /* location.reload(); */
                $('#fastAjax')[0].reset();
            }
        }).fail(function(rs){
            alert(rs.message); 
            return false;
        });  

        return false;
    }
</script>

        <img src="<?php echo LANDING_URL ?>/ddayfit/03.jpg" alt="이벤트" class="img-responsive m-auto">
    </div>
</body>
</html>