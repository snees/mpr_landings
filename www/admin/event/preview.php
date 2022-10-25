<?php 
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";

?>

<style>
    #top_img_div, #bottom_img_div {
        margin: auto;
        width: 90%;
    }
    img{
        width : 100%;
    }
    form{
        width : 90%;
        margin : auto;
    }
    iframe {
        width : 100%;
        height : 500px;
    }
    .inline-YTPlayer{
        max-width : 100%;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.1/css/jquery.mb.YTPlayer.min.css">

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.1/jquery.mb.YTPlayer.min.js"></script>
<script>

    // <title></title> 
    var title = opener.document.getElementById("ev_subject").value;
    var color = opener.document.getElementById("color").value;

    if(title != ""){
        document.title = title;
    }
    // 폼 형식

    <?php 
    
        $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";
        if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){

            /* 모바일 */
    ?> 

            // top
            var top_content_mo =  opener.document.getElementById("ev_top_content_mo").value;
            if(!(top_content_mo.trim())){
                top_content_mo = opener.document.getElementById("ev_top_content_pc").value;
            }
            
            // bottom
            var bottom_content_mo = opener.document.getElementById("ev_bottom_content_mo").value;
            if(!(bottom_content_mo.trim())){
                bottom_content_mo = opener.document.getElementById("ev_bottom_content_pc").value;
            }
            
            var top_count_mo = top_content_mo.split("src=\"").length-1;
            var bottom_count_mo = bottom_content_mo.split("src=\"").length-1;


            var top_img_url = [];
            var top_img = [];

            var bottom_img_url = [];
            var bottom_img = [];


            $(document).ready(function(){

                $("#landing").css("background", color);
                
                /* Mobile 상단 이미지 */
                for(var i=0; i<top_count_mo; i++){
                    top_img_url[i] = top_content_mo.split("src=\"")[i+1].split("\"")[0];

                    if( (top_img_url[i].split("/")[1]) == "img_data" ){
                        top_img[i] = document.createElement('img'); 
                        top_img[i].src = "https://landings.mprkorea.com/"+top_img_url[i];
                    }else{
                        var container = document.createElement('div');
                        container.setAttribute("id", "background"+[i]);
                        container.setAttribute("class", "player");
                        var property = "{videoURL:'https:"+top_img_url[i]+"', mute: true, showControls: false, useOnMobile: true, quality: 'highres', containment: 'self', loop: true, autoPlay: true, stopMovieOnBlur: false, startAt: 0, opacity: 1, disabledkb : 0, controls : 0}";
                        container.setAttribute("data-property", property);
                        top_img[i] = container;
                    }
                    
                    $("#top_img_div").append(top_img[i]);

                    
                }

                /* Mobile 하단 이미지 */
                for(var i=0; i<bottom_count_mo; i++){
                    bottom_img_url[i] = top_content_mo.split("src=\"")[i+1].split("\"")[0];

                    if( (bottom_img_url[i].split("/")[1]) == "img_data" ){
                        bottom_img[i] = document.createElement('img'); 
                        bottom_img[i].src = "https://landings.mprkorea.com/"+bottom_img_url[i];
                    }else{
                        var container = document.createElement('div');
                        container.setAttribute("id", "background"+[i]);
                        container.setAttribute("class", "player");
                        var property = "{videoURL:'https:"+bottom_img_url[i]+"', mute: true, showControls: false, useOnMobile: true, quality: 'highres', containment: 'self', loop: true, autoPlay: true, stopMovieOnBlur: false, startAt: 0, opacity: 1, disabledkb : 0, controls : 0}";
                        container.setAttribute("data-property", property);
                        bottom_img[i] = container;
                    }
                    
                    $("#bottom_img_div").append(bottom_img[i]);
                
                }
            })
    <?php
        }else{

            // pc
    ?>
            var top_content_pc =  opener.document.getElementById("ev_top_content_pc").value;
            var bottom_content_pc = opener.document.getElementById("ev_bottom_content_pc").value;
            if(!(top_content_pc.trim())){
                top_content_pc = opener.document.getElementById("ev_top_content_mo").value;
            }
            if(!(bottom_content_pc.trim())){
                bottom_content_pc = opener.document.getElementById("ev_bottom_content_mo").value;
            }
            
            var top_count_pc = top_content_pc.split("src=\"").length-1;
            var bottom_count_pc = bottom_content_pc.split("src=\"").length-1;
            

            var top_img_url = [];
            var top_img = [];

            var bottom_img_url = [];
            var bottom_img = [];


            $(document).ready(function(){

                $("#landing").css("background", color);
                
                /* PC 상단 이미지 */
                for(var i=0; i<top_count_pc; i++){
                    top_img_url[i] = top_content_pc.split("src=\"")[i+1].split("\"")[0];

                    if( (top_img_url[i].split("/")[1]) == "img_data" ){
                        top_img[i] = document.createElement('img'); 
                        top_img[i].src = "https://landings.mprkorea.com/"+top_img_url[i];
                    }else{
                        var container = document.createElement('div');
                        container.setAttribute("id", "background"+[i]);
                        container.setAttribute("class", "player");
                        var property = "{videoURL:'https:"+top_img_url[i]+"', mute: true, showControls: false, useOnMobile: true, quality: 'highres', containment: 'self', loop: true, autoPlay: true, stopMovieOnBlur: false, startAt: 0, opacity: 1, disabledkb : 0, controls : 0}";
                        container.setAttribute("data-property", property);
                        top_img[i] = container;
                    }
                    
                    $("#top_img_div").append(top_img[i]);
                }

                /* PC 하단 이미지 */
                for(var i=0; i<bottom_count_pc; i++){
                    bottom_img_url[i] = bottom_content_pc.split("src=\"")[i+1].split("\"")[0];

                    if( (bottom_img_url[i].split("/")[1]) == "img_data" ){
                        bottom_img[i] = document.createElement('img'); 
                        bottom_img[i].src = "https://landings.mprkorea.com/"+bottom_img_url[i];
                    }else{
                        var container = document.createElement('div');
                        container.setAttribute("id", "background"+[i]);
                        container.setAttribute("class", "player");
                        var property = "{videoURL:'https:"+bottom_img_url[i]+"', mute: true, showControls: false, useOnMobile: true, quality: 'highres', containment: 'self', loop: true, autoPlay: true, stopMovieOnBlur: false, startAt: 0, opacity: 1, disabledkb : 0, controls : 0}";
                        container.setAttribute("data-property", property);
                        bottom_img[i] = container;
                    }
                    
                    $("#bottom_img_div").append(bottom_img[i]);
                    
                } 
            })
    <?php
        }

    ?>

    var ev_name = opener.document.getElementById("ev_name_yn").checked;
    var tel = opener.document.getElementById("ev_tel_yn").checked;
    var sex = opener.document.getElementById("ev_sex_yn").checked;
    var age = opener.document.getElementById("ev_age_yn").checked;
    var comment = opener.document.getElementById("ev_comment_yn").checked;
    var birth = opener.document.getElementById("ev_birthday_yn").checked;
    var rec_person = opener.document.getElementById("ev_rec_person_yn").checked;
    var counsel_time = opener.document.getElementById("ev_counsel_time_yn").checked;
    var always = opener.document.getElementById("ev_always").checked;

    if(always){
        var date = opener.document.getElementById("reservation2").value;

        var ev_term_str = "이벤트 기간 : " + date + " ~ (상시 진행)" ;
    }else{
        var date = opener.document.getElementById("reservation").value;
        var start_date = date.split(" ")[0];
        var end_date = date.split(" ")[2];

        var ev_term_str = "이벤트 기간 : " + start_date + " ~ " + end_date;
        // console.log(ev_term_str);
    }

    $(document).ready(function(){
        $("#ev_term").text(ev_term_str);
        $('.player').YTPlayer();

        if(ev_name == true){
            $("#name_input_div").show();
        }
        if(tel == true){
            $("#tel_input_div").show();
        }
        if(sex == true){
            $("#sex_input_div").show();
        }
        if(age == true){
            $("#age_input_div").show();   
        }
        if(birth == true){
            $("#birth_input_div").show();   
        }
        if(rec_person == true){
            $("#rec_person_input_div").show();   
        }
        if(counsel_time == true){
            $("#counsel_time_input_div").show();   
        }
        if(comment == true){
            $("#comment_input").show();   
        }
        

    })

</script>


<link rel="stylesheet" href="https://landings.mprkorea.com/page/inc/page.css">
<div class="full-wrapper" style="max-width:1920px; margin:auto;">
    <div id="input_form">
        <div id="top_img_div"></div>
    
        <form id="landing">
            <!-- 이벤트 기간 -->
            <div id="ev_term" style="text-align:center; margin: 2%;"></div>

            <div>
                <!-- 이름 -->
                <div class="form-row" id="name_input_div" style="display:none;">
                    <label for="name_input" class="input-label">이름</label>
                    <input type="text" name="name_input" disabled />
                </div>
                
                <!-- 연락처 -->
                <div class="form-row" id="tel_input_div" style="display:none;">
                    <label for="tel_input" class="input-label">연락처</label>
                    <input type="text" id="tel_input" disabled />
                </div>
                
                <!-- 성별 -->

                <div class="form-row" data-form="ev_sex">
                    <label for="ev_sex" class="input-label">성별</label>
                    <div class="radio-wrap d-flex">
                        <input class="form-check-input" type="radio" name="sex_type" id="sex_type_M" value="M">
                        <label class="form-check-label" for="sex_type_M" >남성</label>
                        <input class="form-check-input" type="radio" name="sex_type" id="sex_type_F" value="F">
                        <label class="form-check-label" for="sex_type_F" >여성</label>
                    </div>
                </div>

                <!-- 나이 -->
                <div class="form-row" id="age_input_div" style="display:none;">
                    <label for="exampleInputCode1" class="input-label">나이</label>
                    <input type="text" disabled />
                </div>

                <!-- 생년월일 -->
                <div class="form-row" id="birth_input_div" style="display:none;">
                    <label for="exampleInputCode1" class="input-label">생년월일</label>
                    <input type="text" disabled />
                </div>

                <!-- 추천인 -->
                <div class="form-row" id="rec_person_input_div" style="display:none;">
                    <label for="exampleInputCode1" class="input-label">추천인</label>
                    <input type="text" disabled />
                </div>

                <!-- 상담시간 -->
                <div class="form-row" id="counsel_time_input_div" style="display:none;">
                    <label for="counsel_time_input_div" class="input-label">상담시간</label>
                    <select class="custom-select form-control-border" id="counsel_time_input_div" name="counsel_time_input_div">
                        <option value="" disabled selected>상담 가능 시간 선택</option>
                        <option value="9to11">오전 9시 ~ 11시</option>
                        <option value="11to1">오전 11시 ~ 1시</option>
                        <option value="3to5">오전 3시 ~ 5시</option>
                        <option value="5to7">오전 5시 ~ 7시</option>
                    </select>
                </div>

                <!-- ansdml -->
                <div class="form-row" id="comment_input" style="display:none; width:100%;">
                    <textarea placeholder="문의사항 입력" style="width:100%;" disabled ></textarea>
                </div>
                <div class="text-row">
                    <input type="checkbox" id="is_privacy">
                    <label for="is_privacy">개인정보 수집 및 이용에 관한 내용을 확인하고 동의함</label>
                    <a href="#" class="link_privacy">자세히보기</a>
                </div>
                <div class="button-row">
                    <button type="button" onclick="submitEvent();" disabled="disabled">신청하기</button>
                </div>
            </div>
        </form>

        <div id="bottom_img_div">
        </div>
    </div>
</div>

