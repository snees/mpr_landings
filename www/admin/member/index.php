<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";

    /* 검색 정보 */
    if(count($_POST)>0){    // 검색했을 때
        $orderBy_val = $_POST['orderBy_input'];             // 정렬 기준 (idx, userLv, apprve)
        $search = $_POST['search'];                         // 검색어
        $category = $_POST['category'];                     // 검색 종류
        $list = $_POST['lines'];                            // 페이지당 조회 건수
    }else{                  // 검색 안했을 때
        $orderBy_val = "idx DESC";
        $list = 10;
        $stat = "total";
    }
    $orderBy = $orderBy_val;
?>
<style>
    .btn:first-child:hover{
        background-color : white;
        border-color : white;
    }
    .btn:first-child:hover{
        border-color : white;
    }

</style>

<script>
    $(function(){
        /* 레벨 정렬 */
        $("#user_lvBtn").on("click", function(){
            console.log("fds");
            var className = $("#user_lv").attr("class");
            console.log(className);

            if(className.split(" ")[1] == "fa-caret-down"){

                $("#user_lv").removeClass("fa-caret-down");
                $("#user_lv").addClass("fa-caret-up");
                $("#orderBy_input").val("user_lv ASC");
                $("form").submit();

            }else if(className.split(" ")[1] == "fa-caret-up"){

                $("#user_lv").removeClass("fa-caret-up");
                $("#user_lv").addClass("fa-caret-down");
                $("#orderBy_input").val("user_lv DESC");
                $("form").submit();
            
            }
        });

        /* 승인 여부 정렬 */
        $("#apprveBtn").on("click", function(){
            var className = $("#apprve").attr("class");
            console.log(className);

            if(className.split(" ")[1] == "fa-caret-down"){

                $("#apprve").removeClass("fa-caret-down");
                $("#apprve").addClass("fa-caret-up");
                $("#orderBy_input").val("apprve ASC");
                $("form").submit();

            }else if(className.split(" ")[1] == "fa-caret-up"){

                $("#apprve").removeClass("fa-caret-up");
                $("#apprve").addClass("fa-caret-down");
                $("#orderBy_input").val("apprve DESC");
                $("form").submit();
            
            }
        });
    })

    /* 화살표 모양 유지 */
    $(document).ready(function(){

        var order = $("#orderBy_input").val();
        
        if(order == "user_lv ASC"){
            $("#user_lv").removeClass("fa-caret-down");
            $("#user_lv").addClass("fa-caret-up");
        }
        
        if(order == "apprve ASC" ){
            $("#apprve").removeClass("fa-caret-down");
            $("#apprve").addClass("fa-caret-up");
        }
    });
</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>회원 목록</h1>
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

                                    <table id="member-list" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="8" style="padding:0px;">
                                                    <div class="navbar navbar-expand navbar-white navbar-light d-flex" id="navbar-search2" style="justify-content:right;">
                                                        <form class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                                                            <input type = "hidden" value="test">
                                                            <div class="form-group">
                                                                <select class="form-control select2" name="category" style="width:100%; height:30px; font-size:small; margin-right: 5px;" >
                                                                    <option value="user_nm" <?php echo trim($category)=='user_nm'?' selected ':'';?>>이름</option>
                                                                    <option value="user_id" <?php echo trim($category)=='user_id'?' selected ':'';?>>회원ID</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group input-group-sm">
                                                                <input class="form-control form-control-navbar" type="text" placeholder="검색어를 입력해주세요." name="search" id="search" value="<?php echo $search?>" autocomplete="off">
                                                                <div class="input-group-append">
                                                                <button class="btn btn-navbar" type="submit" >
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                <button class="btn btn-navbar" type="button" id="searchCancel">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="orderBy_input" id="orderBy_input" value="<?php echo $orderBy_val?>">
                                                            <input type="hidden" name="lines" id="lines" value="<?php echo $list?>">
                                                            <input type="hidden" name="pageMove" id="pageMove" value="1">
                                                        </form>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="sorting sorting_asc" aria-controls="member-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">회원 ID</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">이름</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">닉네임</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">레벨 <button type="button" class="btn submitBtn" style="padding:0px;" id="user_lvBtn"><i class="fa-solid fa-caret-down" id="user_lv"></i></button></th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">연락처</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">이메일</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">승인 여부 <button type="button" class="btn submitBtn" style="padding:0px;" id="apprveBtn"><i class="fa-solid fa-caret-down" id="apprve"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(isset($_POST['pageMove'])){
                                                $page=$_POST['pageMove'];
                                            }
                                            else{
                                                $page=1;
                                            }

                                            if(!trim($_POST['search'])){    // 검색 안했을 때
                                                $strWhere = "del_yn='N'";
                                            } else{                         // 검색했을 때
                                                $strWhere = "del_yn='N' AND {$category} like '%{$search}%'";
                                            }
                                        
                                            $cnt = $DB->single("SELECT count(*) FROM mpr_member WHERE {$strWhere}");

                                            if($cnt==0){
                                                echo    "<tr class='odd'>
                                                            <td colspan='8' style='text-align : center;'>해당하는 정보가 없습니다.</td>
                                                        </tr>";
                                                $totalPage = 0;
                                                $list = 0;
                                            } else{
                                                $pageNum=5;

                                                $nowBlock=ceil($page/$pageNum);                 // 현재 페이지 블록
                                                $startPageNum=(($nowBlock-1)*$pageNum)+1;       // 블록의 시작번호
                                                $endPageNum= $startPageNum + $pageNum -1;       // 블록의 마지막 번호
                                                $totalPage=ceil($cnt/$list);                    // 총 페이지 수

                                                if($endPageNum>$totalPage){
                                                    $endPageNum=$totalPage;
                                                }; 

                                                $start=($page-1)*$list;

                                                $sql2 =
                                                    "SELECT 
                                                        user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve 
                                                    FROM mpr_member 
                                                    WHERE {$strWhere}
                                                    ORDER BY {$orderBy} limit $start, $list";

                                                $result=$DB->query($sql2);
                                                $max = $cnt-$list*($page-1);

                                                for($i=0; $i < count($result); $i++){
                                        ?>
                                                        <tr class="odd">
                                                            <td><?php echo $max--;?></td>
                                                            <td><a href="/admin/member/updateinfo.php?id=<?php echo $result[$i]['user_id'];?>"><?php echo $result[$i]['user_id'];?></a></td>
                                                            <td><?php echo $result[$i]['user_nm'];?></td>
                                                            <td><?php echo $result[$i]['user_nick'];?></td>
                                                            <td>
                                                                <?php 
                                                                    if($result[$i]['user_lv']==100){
                                                                        echo "일반회원";
                                                                    }else {
                                                                        echo "관리자";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $result[$i]['user_mobile'];?></td>
                                                            <td><?php echo $result[$i]['user_email'];?></td>
                                                            <td>
                                                                <?php 
                                                                    if($result[$i]['apprve']=="Y"){
                                                                        echo "승인"; 
                                                                    } else {
                                                                        echo "비승인";
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                <div style="display:flex; justify-content: space-between"  id="ev_reg">
                                                    <div style="float:left;" id="page_Limit">
                                                        <label for="pageLimit" style="float:left; margin : 4px 5px 0 0;" >페이지당 조회 건수</label>
                                                        <select class="form-control select2" name="pageLimit" id="pageLimit" style="width:55px; height:30px; font-size:small; margin-right: 5px;">
                                                            <option value="10" <?php echo trim($list)=='10'?' selected ':'';?>>10개</option>
                                                            <option value="20" <?php echo trim($list)=='20'?' selected ':'';?>>20개</option>
                                                            <option value="30" <?php echo trim($list)=='30'?' selected ':'';?>>30개</option>
                                                        </select>
                                                    </div>
                                                    <a class="btn btn-sm btn-primary" href="/admin/member/form.php">신규 등록</a>
                                                </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTable-info" role="status">
                                        Page : <?php echo $page?> / Total : <?php echo $totalPage; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination">
                                        <?php
                                            if( ($page-1) > 0){
                                                $prev = $page - 1;
                                                echo "<li class='paginate_button page-item next'><button class='page-link' id='prevBtn' value='".$prev."'>이전</button></li>";
                                            }else{
                                                echo "<li class='paginate_button page-item next disabled'><button class='page-link' disabled>이전</button></li>";
                                            }
                                            for($i=$startPageNum; $i<=$endPageNum; $i++){ 
                                                if($totalPage !=0 ){
                                                    if($page == $i){  
                                                        echo "<li class='paginate_button page-item active'><button class='page-link' disabled>".$i."</button></li>";
                                                    }else{
                                                        echo "<li class='paginate_button page-item'><button class='page-link nextPage".$i."' value='".$i."' onclick='nextPage(this.value)'>".$i."</button></li>";
                                                    }
                                                }else{
                                                    echo "<li class='paginate_button page-item active'><button class='page-link'>1</button></li>";
                                                }
                                            }
                                            if( ($page+1) <=$block_end){
                                                $next = $page + 1;
                                                echo "<li class='paginate_button page-item next'><button class='page-link' id='nextBtn' value='".$next."'>다음</button></li>";
                                            }else{
                                                echo "<li class='paginate_button page-item next disabled'><button class='page-link' disabled>다음</button></li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    /* 페이지당 조회 건수 */
    $('#pageLimit').change(function(){
        var lines = $(this).val();
        $("#lines").val(lines);
        $("form").submit();
    });

    /* 페이지 */
    $("#prevBtn").on("click", function(){
        var pageMove = $("#prevBtn").val();
        $("#pageMove").val(pageMove);
        $("form").submit();
    });
    $("#nextBtn").on("click", function(){
        var pageMove = $("#nextBtn").val();
        $("#pageMove").val(pageMove);
        $("form").submit();
    });
    function nextPage(nextPage){
        $("#pageMove").val(nextPage);
        $("form").submit();
    }

    /* 검색 취소 버튼 */
    $("#searchCancel").on("click", function(){
        $("#search").val("");
    });
</script>


<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>