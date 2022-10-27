<?php
    session_start();
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    $id=$_GET['id'];
    $sql="select * from mpr_member where user_id = '{$id}'";
    $result=$DB->row($sql);
?>
<body>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>정보수정</h1>
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
                                <div class="card card-primary">
                                  <form id="member_form" name = "member_form" >
                                    <div class="card-body">
                                      <div class="form-group">
                                        <label for="inputid">아이디</label>
                                        <input type="text" class="form-control" id="id" value="<?php echo $id?> "disabled/>
                                      </div>
                                      <div class="form-group">
                                        <label for="inputpwd">비밀번호 변경</label>
                                        <input type="password" class="form-control" id="chgpwd" placeholder="Password" onfocus="able()">
                                        <input type="hidden" id=hiddenpw value="<?php echo $result['user_password']?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="inputpwd">비밀번호 확인</label>
                                        <input type="password" class="form-control" id="chkpwd" placeholder="Password" disabled/>
                                      </div>
                                      <div class="form-group">
                                        <label for="inputnick">닉네임</label>
                                        <input type="text" class="form-control" id="nick"placeholder="Nickname">
                                        <input type="hidden" id=hiddennick value="<?php echo $result['user_nick']?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="inputphone">연락처(전화번호)</label>
                                        <input type="tel" class="form-control" id="phonenum"placeholder="Phone" oninput="autoHyphen2(this)" maxlength="13">
                                        <input type="hidden" id=hiddenphone value="<?php echo $result['user_mobile']?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="inputetc">기타 연락처</label>
                                        <input type="tel" class="form-control" id="etcnum"placeholder="Etcnum" oninput="autoHyphen2(this)" maxlength="13">
                                        <input type="hidden" id=hiddenetc value="<?php echo $result['user_phone']?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="inputemail">이메일</label>
                                        <input type="email" class="form-control" id="email"placeholder="email">
                                        <input type="hidden" id=hiddenemail value="<?php echo $result['user_email']?>">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <?php if($result['user_lv']==100)
                                      {?>
                                        <label><input type="checkbox" id="level" name="level" onclick="doOpenCheck(this)" value="100" checked>&nbsp일반고객&nbsp</label>
                                        <label><input type="checkbox" id="level" name="level" onclick="doOpenCheck(this)" value="200">&nbsp관리고객</label>
                                        <input type="hidden" id="hiddenlevel" value="<?php echo $result['user_lv']?>">
                                    <?php } else{?>
                                        <label><input type="checkbox" id="level" name="level" onclick="doOpenCheck(this)" value="100" >&nbsp일반고객&nbsp</label>
                                          <label><input type="checkbox" id="level" name="level" onclick="doOpenCheck(this)" value="200" checked>&nbsp관리고객</label>
                                          <input type="hidden" id="hiddenlevel" value="<?php echo $result['user_lv']?>">
                                        <?php }?>
                                    </div>

                                    <div class="form-group">
                                      <label>승인여부 &nbsp&nbsp</label>
                                      <select id="apprve" name="apprve" size="1">
                                        <option value="Y">승인</option>
                                        <option value="N">비승인</option>
                                      </select>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                      <div class="d-flex ">
                                        <button type="button" class="btn btn-danger" id="btn2">회원삭제</button>
                                      </div>
                                      <div class="d-flex ">        
                                          <a href="/admin/member/" class="btn btn-default" style="margin-right:5px;">취소</a>
                                          <button type="button" class="btn btn-primary" onclick="checkAll()" id="btn1">확인</button>
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>
<script>
  
function callApi(type, ev_key){        
        // console.log(type+" "+ ev_key+" "+ br_name+" "+ ev_subject+" "+ ev_code+" "+ start_Date+" "+ end_Date+" "+ is_always+" "+ br_code+" "+ url);
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
                // br_code       : br_code,    //업체코드
                // cust_nm       : br_name,    //업체이름
                // event_nm      : ev_subject, //이벤트제목
                // event_cd      : ev_code,     //이벤트 코드
                // expose_from   : start_Date,  //시작일
                // expose_to     : end_Date,    //종료일
                // expose_always : is_always,   //상시체크
                // event_url     : url,         //이벤트키
                // reg_id        : '<?php echo $_SESSION['userId']; ?>'
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


  const autoHyphen2 = (target) => {
        target.value = target.value
        .replace(/[^0-9]/g, '')
        .replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
        }
  function checkAll(){
        if(!checkPassword(member_form.chgpwd.value, member_form.chkpwd.value))
        {
            return false;
        }
        if(!checkNick(member_form.nick.value))
        {
            return false;
        }
        if(!checkPhone(member_form.phonenum.value))
        {
            return false;
        }
        if(!checkEtc(member_form.etcnum.value))
        {
           return false;
        }
        if(!checkemail(member_form.email.value))
        {
            return false;
        }
        if(!checklevel(member_form.level.value))
        {
          return false;
        }
        $.ajax({
                url:"/admin/member/updateinfo/update.php",
                type :"post",
                data:{id:$("#id").val(),
                      pw:$("#hiddenpw").val(),
                      nick:$("#hiddennick").val(),
                      email:$("#hiddenemail").val(),
                      phonenum:$("#hiddenphone").val(),
                      etcnum:$("#hiddenetc").val(),
                      level:$("input:checkbox[name='level']:checked").val(),
                      apprve:$("#apprve").val()},
                dataType :'text',
                success: function(data){
                  // console.log(data);
                  alert('회원수정 완료');
                  location.replace('/admin/member/');
                  console.log($("input:checkbox[name='level']:checked").val());
                },
            }); 
      }

      function checkExist(value,data){
          if(value == "")
          {
              alert(data +" 입력하시오");
              return false;
          }
          return true;
      }
      function checkPassword(pw1,pw2)
      {
        if(!pw1)
        {
          return true;
        }
        else
        {
          if(!checkExist(pw1,"비밀번호"))
            return false;

          var pw = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,20}$/;
          if(!pw.test(pw1))
          {
              alert("영문 대소문자, 숫자 8~20자리 입력하세요");
              member_form.chgpwd.value="";
              member_form.chgpwd.focus();
              return false;
          }
          if(pw1==='<?php echo $result['user_password']?>')
          {
              alert("기존에 입력했던 비밀번호와 같습니다.");
              member_form.chgpwd.value="";
              member_form.chgpwd.focus();
              return false;
          }
          if(!checkExist(pw2,"비밀번호 재확인을"))
              return false;
          if(pw1!=pw2)
          {
              alert("비번이 다릅니다.");
              member_form.chgpwd.value =  "";
              member_form.chkpwd.value="";
              member_form.chkpwd.focus();
              return false;
          }
          document.getElementById("hiddenpw").value = pw1;
          return true;
        }
      }
      function checkNick(nick)
      {
          if(!nick)
          {
              return true;
          }
          else
          {
              if(!checkExist(nickn,"별명"))
                  return false;
              var kor = /^[가-힣a-zA-Z0-9]{3,}$/;
              if(!kor.test(nickn))
              {
                  alert("별명을 다시 입력해주세요");
                  member_form.nick.value=  "";
                  member_form.nick.focus();
                  return false;
              }
              document.getElementById("hiddennick").value = nick;
              return true;
          }
      }
      function checkPhone(phone)
      { 
          if(!phone)
          {
            return true;
          }
          else
          {
            if(!checkExist(phone,"전화번호"))
              return false;
            var num = /[0-9]/;
            if(!num.test(phone))
            {
                alert("전화번호를 다시 입력해주세요");
                member_form.phonenum.value="";
                member_form.phonenum.focus();
                return false;
            }
            document.getElementById("hiddenphone").value = phone;
            return true;
          }
      }
      function checkEtc(etc)
      {   
          if(!etc)
          {
              return true;
          }
          else
          {
              if(!checkExist(etc,"추가번호"))
                  return false;
               var num = /[0-9]/;
              if(!num.test(etc))
              {
                  alert("추가 번호를 다시작성해주세요");
                  member_form.etcnum.value="";
                  member_form.etcnum.focus();
                  return false
              }
              document.getElementById("hiddenetc").value = etc;
              return true
          }
      }
      function checkemail(mail)
      {   
          if(!mail)
          {
            return true;
          }
          else
          {
            var email = /^[A-Za-z0-9_]+[A-Za-z0-9]*[@]{1}[A-Za-z0-9]+[A-Za-z0-9]*[.]{1}[A-Za-z]{1,3}$/;
            if(!checkExist(mail,"이메일"))
                return false;
            
            if(!email.test(mail))
            {
                alert("옳바른 형식의 이메일이 아닙니다.");
                member_form.email.value="";
                member_form.email.focus();
                return false;
            }
            document.getElementById("hiddenemail").value = mail;
            return true;
          }
      }
      function checklevel(level)
      {
        var cnt = $("input:checkbox[name='level']:checked").length;
        if(cnt<1)
        {
          alert("고객 유형을 선택해주세요");
          return false;
        }
        document.getElementById("hiddenlevel").value = level;
        return true;
      }
      function able()
      {
        $("#chkpwd").prop("disabled", false);
      }
      function doOpenCheck(chk){
        var obj = document.getElementsByName("level");
        for(var i=0; i<obj.length; i++){
            if(obj[i] != chk){
                obj[i].checked = false;
            }
        }
    }
      $(document).ready(function(){
        $("#btn2").click(function(){
            if(confirm("회원삭제 시 업체 및 이벤트 등 모든 데이터가 삭제됩니다. 삭제를 진행하시겠습니까?"))
            {
              $.ajax({
                url:"/admin/member/updateinfo/delete.php",
                type :"post",
                data:{id:$("#id").val()},
                dataType :'json',
                success: function(data){
                  // console.log(data);
                  for(var i =0; i<data.length;i++)
                  {
                    // console.log(data[i]['ev_key']);
                    callApi("delete",data[i]['ev_key']);
                  }
                  
                },
              }); 
            }
        });
      });
</script>