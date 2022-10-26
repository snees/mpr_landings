<?php  
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
?>

<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <b>회원정보변경</b>
  </div>
  <!-- User name -->
  <div class="lockscreen-name" align="center">비밀번호를 입력해주세요</div>
        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <div class="lockscreen-credentials">
                <div class="input-group">
                <input type="password" class="form-control" id="password" placeholder="Password" autofocus>
                    <div class="input-group-append">
                        <button type="button" class="btn" id="enterbtn">
                        <!-- "location.replace('/admin/member/updateinfo.php')" -->
                            <span class="fas fa-arrow-right text-muted"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            $("#enterbtn").click();
          }
          else(
            console.log("13")
          )
        });
        $("#enterbtn").click(function(){
            if(!checkempty($("#password").val(),"비밀번호"))
                return false;
            $.ajax({
                url:"/admin/member/updateinfo/checkpw.php",
                type :"post",
                data:{pw:$("#password").val()},
                dataType :'text',
                success: function(data){
                    if(data==1)
                    {
                        location.replace('/admin/member/updateinfo/updateinfo.php');
                    }
                    else
                    {
                        alert("비밀번호를 입력해주세요");
                        console.log(data);
                    }
                },
            }); 
        });
    });
</script>