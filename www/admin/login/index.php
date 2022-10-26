<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";
    // echo "<script>console.log('세션:".$_SESSION['userId']."');</script>";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    if($_SESSION['userId'])
    {
        echo "<script>location.replace('/admin/');</script>";
        echo "<script>console.log('457".$_SESSION['userId']."');</script>";
    }
?>
<body class="hold-transition login-page">
<div class="login-box m-auto">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <span class="h1"><b>로그인</b></span>
    </div>
    <div class="card-body">
      <form>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id ="id"placeholder="ID" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="col-12 text-center">
            <button type="button" class="btn btn-primary col-12" id="login">로그인</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-1" align=center>
        <a href="" class="find_ID" onclick="window.open('/admin/login/find/id.php','_blank','width=430,height=500,location=no,status=no,scrollbars=yes');">아이디찾기 |</a>
        <a href="" class="find_PW" onclick="window.open('/admin/login/find/pw.php','_blank','width=430,height=500,location=no,status=no,scrollbars=yes');">비밀번호찾기 |</a>
        <a href="/admin/login/register" class="text-center">회원가입</a>
      </p>
      <p class="mb-0">
        
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
</body>
<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>
<script>
  function checkempty(value,data)
  {
    if(value == "")
        {
            alert(data +" 입력하시오");
            return false;
        }
        return true;
  }

  $(document).ready(function(){
        $("input").keyup(function(event){
          if(event.which===13)
          {
            $("#login").click();
          }
        });
        $("#login").click(function(){
          if(!checkempty($("#id").val(),"아이디"))
            return false;
          if(!checkempty($("#password").val(),"비밀번호"))
            return false;
            $.ajax({
                url:"/admin/login/login.php",
                type :"post",
                data:{id:$("#id").val(),
                      password:$("#password").val()},
                dataType :'text',
                success: function(data){
                  // console.log(data)
                  if(data==0)
                  {
                    alert("ID 혹은 비밀번호를 잘못 입력하셨습니다.");
                  }
                  else if(data==1)
                  {
                    location.href="/admin/";
                  }
                  else
                  {
                    alert("탈퇴한 회원입니다.");
                  }
                },
            }); 
        });
    });
  
</script>