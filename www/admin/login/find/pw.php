<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";
?>
<body>
<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">비밀번호 찾기</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">이름</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="name" placeholder="name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">아이디</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="id" placeholder="ID">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">이메일</label>
                    <div class="col-sm-10">
                      <input type="mail" class="form-control" id="email" placeholder="email">
                    </div>
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="button" class="btn btn-info" id="chkbtn">확인</button>
                  <button type="button" class="btn btn-default float-right" id="btncancel" onclick="self.close()">취소</button>
                </div>
                <!-- /.card-footer -->
              </form>
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
        $("#chkbtn").click(function(){
          if(!checkempty($("#name").val(),"이름"))
            return false;
          if(!checkempty($("#id").val(),"아이디"))
            return false;
          if(!checkempty($("#email").val(),"이메일"))
            return false;
            $.ajax({
                url:"/admin/login/find/checkpw.php",
                type :"post",
                data:{name:$("#name").val(),
                      id:$("#id").val(),
                      email:$("#email").val()},
                dataType :'text',
                success: function(data){
                  if(data==0)
                  {
                    alert("이름 혹은 ID, 이메일을 확인해주세요");
                  }
                  else
                  {
                    alert("임시 비밀번호가 이메일로 발송되었습니다.");
                    self.close();
                  }
                },
            }); 
        });
    });
</script>