<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";

    $max_date = $DB -> row("SELECT MAX(ev_end) AS max_date FROM mpr_event");
    $min_date = $DB -> row("SELECT MIN(ev_start) AS min_date FROM mpr_event");

    /* 검색 정보 */
    if(count($_POST)>0){    // 검색했을 때
        $regDateVal = $_POST['regDateInput'];                   // 등록일 정렬
        $startDate = explode(" ", $_POST['reservation'])[0];    // 검색 시작일
        $endDate = explode(" ", $_POST['reservation'])[2];      // 검색 종료일
        $keyword = $_POST['input_search'];                      // 검색어
        $strSearch = $_POST['search'];                          // 검색 종류
        $list = $_POST['lines'];                                // 페이지당 조회 건수
        $stat = $_POST['stat'];                                 // stat
    }else{                  // 검색 안했을 때
        $regDateVal = "ORDER BY e.idx DESC";
        $startDate = $min_date['min_date'];
        $endDate = $max_date['max_date'];
        $list = 10;
        $stat = "total";
    }
    $oderBy = $regDateVal;

?>

<style>
    .input-group-append > .btn:first-child:hover{
        background-color : #dadfe4;
        border-color : #ced4da;
    }
    .btn:first-child:hover{
        background-color : white;
        border-color : white;
    }
    .btn:first-child:hover{
        border-color : white;
    }

</style>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $( function() {

        /* DatarangePicker */
        $( "#reservation" ).daterangepicker({
            locale:{ 
                format:'YYYY-MM-DD', //일시노출포맷
                applyLabel :"선택",
                cancelLabel:"취소",
                fromLabel: "From",
                toLabel: "To",
                daysOfWeek:["일","월","화","수","목","금","토"],
                monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"]
                },
                startDate: "<?php echo $startDate?>",
                endDate: "<?php echo $endDate?>",
                drops: "auto"
        }, function (start, end, label){
            console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        });

        /* 등록일 정렬 */
        $("#regDateBtn").on("click", function(){
            var className = $("#regDateImg").attr("class");
            console.log(className);

            if(className.split(" ")[1] == "fa-caret-down"){

                $("#regDateImg").removeClass("fa-caret-down");
                $("#regDateImg").addClass("fa-caret-up");
                $("#regDateInput").val("ORDER BY e.reg_date ASC");
                $("form").submit();

            }else if(className.split(" ")[1] == "fa-caret-up"){

                $("#regDateImg").removeClass("fa-caret-up");
                $("#regDateImg").addClass("fa-caret-down");
                $("#regDateInput").val("ORDER BY e.reg_date DESC");
                $("form").submit();
            
            }
        });
        
    });

    /* stat */
    var stat = '<?php echo $stat?>';
    switch(stat){
        case "total" :
            $(function(){
                $('#st_total').css("color", "#050099");
            });
            break;
        case "W" :
            $(function(){
                $('#st_w').css("color", "#050099");
            });
            break;
        case "Y" :
            $(function(){
                $('#st_y').css("color", "#050099");
            });
            break;
        case "N" :
            $(function(){
                $('#st_n').css("color", "#050099");
            });
            break;
    }

    $(document).ready(function(){

        /* 등록일 정렬 */
        var reg = $("#regDateInput").val();
        if(reg == "ORDER BY e.reg_date DESC" || reg == "ORDER BY e.idx DESC"){
            $("#regDateImg").removeClass("fa-caret-up");
            $("#regDateImg").addClass("fa-caret-down");
        }else{
            $("#regDateImg").removeClass("fa-caret-down");
            $("#regDateImg").addClass("fa-caret-up");
        }

        /* stat:hover */
        $(".statBtn").hover(function(){
            $(this).css("color", "#6B66FF");
        }, function(){
            switch(stat){
                case "total" :
                    $(function(){
                        $('#st_total').css("color", "#050099");
                    });
                    break;
                case "W" :
                    $(function(){
                        $('#st_w').css("color", "#050099");
                    });
                    break;
                case "Y" :
                    $(function(){
                        $('#st_y').css("color", "#050099");
                    });
                    break;
                case "N" :
                    $(function(){
                        $('#st_n').css("color", "#050099");
                    });
                    break;
            }
            $(this).css("color", "#BDBDBD");
        });
        
    });

</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>이벤트 목록</h1>
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
                                    <table id="event-list" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="7" style="padding:0px;">
                                                    <div class="navbar navbar-expand navbar-white navbar-light d-flex justify-content-between" id="navbar-search2" >
                                                        <ul class="nav navbar-nav" style="list-style:none; margin:0px; padding:0 10px;">
                                                            <li style="float:left; margin-right:5px;"><button type="button" class="btn statBtn" style="padding:0px; color:#BDBDBD; font-weight:bold;" id="st_total">전체</button></a></li>
                                                            <li style="float:left; margin-right:5px;"><button type="button" class="btn statBtn" style="padding:0px; color:#BDBDBD; font-weight:bold;" id="st_w">진행 예정</a></li>
                                                            <li style="float:left; margin-right:5px;"><button type="button" class="btn statBtn" style="padding:0px; color:#BDBDBD; font-weight:bold;" id="st_y">진행중</a></li>
                                                            <li style="float:left; margin-right:5px;"><button type="button" class="btn statBtn" style="padding:0px; color:#BDBDBD; font-weight:bold;" id="st_n">종료</a></li>
                                                        </ul>
                                                        <form class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                                                            <div class="form-group" >
                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend" style="height:30px;">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                    </div>
                                                                    
                                                                    <input type="text" class="form-control float-right" id="reservation" name="reservation"style="height:30px; width:200px; text-align : center;">
                                                                    <div class="input-group-append" style="height:30px; margin-right:5px;">
                                                                        <button class="btn btn-navbar date_search submitBtn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" style="width: 90px; justify-content:right;">
                                                                <select class="form-control select2" name="search" style="width:100%; height:30px; font-size:small; margin-right: 5px;">
                                                                    <option value="br_name" <?php echo trim($strSearch)=='br_name'?' selected ':'';?>>업체</option>
                                                                    <option value="ev_subject" <?php echo trim($strSearch)=='ev_subject'?' selected ':'';?>>이벤트 제목</option>
                                                                </select>
                                                            </div>

                                                            <div class="input-group input-group-sm" >
                                                                <input class="form-control form-control-navbar" type="text" value="<?php echo trim($keyword);?>" placeholder="검색어를 입력하세요." id="inSearch" name="input_search" autocomplete='off'>
                                                                <div class="input-group-append">
                                                                <button class="btn btn-navbar submitBtn" type="submit">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                <button class="btn btn-navbar" type="button" id="searchCancel">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="regDateInput" name="regDateInput" value="<?php echo $regDateVal ?>">
                                                            <input type="hidden" id="lines" name="lines" value="<?php echo $list ?>">
                                                            <input type="hidden" value="<?php echo $stat?>" name="stat" id="stat">
                                                            <input type="hidden" value="1" name="pageMove" id="pageMove">
                                                        </form>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="sorting sorting_asc" aria-controls="event-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">이벤트 제목</th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">이벤트 URL</th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">업체</th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">이벤트 기간</th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">등록일 <button type="button" class="btn submitBtn" style="padding:0px;" id="regDateBtn"><i class="fa-solid fa-caret-down" id="regDateImg"></i></button></th>
                                                <th class="sorting sorting_asc" aria-controls="event-list">상태</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $arryWhere = array();

                                                $lv_SQL = "SELECT user_lv FROM mpr_member WHERE user_id = '{$_SESSION['userId']}'";
                                                $user_lv = $DB -> row($lv_SQL);

                                                if(trim($user_lv['user_lv']) == 100){
                                                    $strWhere = "b.user_id = '{$_SESSION['userId']}' AND ";
                                                }

                                                /* 검색했을때 테이블 가져오기 */
                                                if ( trim($_POST['search']) && trim($_POST['input_search']) ) {
                                                    $strWhere .= "e.del_yn='N' AND b.del_yn='N' AND ev_start >= '{$startDate}' AND ev_end <= '{$endDate}' AND ";
                                                    if( trim($_POST['stat']) != "total"){
                                                        $arryWhere[] = "ev_stat = '{$_POST['stat']}' and {$_POST['search']} like '%{$_POST['input_search']}%' ";
                                                    }else{
                                                        $arryWhere[] = "{$_POST['search']} like '%{$_POST['input_search']}%' ";
                                                    }
                                                    $strWhere.= implode(' and ', $arryWhere);//---- 배열로 만든다. explode('@', '문자열@문자열@문자열')
                                                    
                                                }else{
                                                    /* 검색 안했을때 테이블 가져오기 */
                                                    if($stat =="total"){
                                                        $strWhere .= "e.del_yn='N' AND b.del_yn='N' AND ev_start >= '{$startDate}' AND ev_end <= '{$endDate}'";
                                                    }else{
                                                        $strWhere .= "e.del_yn='N' AND b.del_yn='N' AND ev_stat = '{$stat}'";
                                                    }
                                                }

                                                if(isset($_POST['pageMove'])){
                                                    $page = $_POST['pageMove'];
                                                } else {
                                                    $page = 1;
                                                }

                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_event e LEFT JOIN mpr_branch b ON e.br_code = b.br_code WHERE {$strWhere};");

                                                if($row_num == 0){
                                                    echo "<tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan='6'>검색결과가 없습니다.</td>
                                                            </tr>";
                                                    $total_page = 0;
                                                    $list = 0;
                                                }else{
                                                    
                                                    $block_ct = 10;
                                                            
                                                    $block_num = ceil($page/$block_ct);                 // 현재 페이지 블록 구하기
                                                    $block_start = (($block_num - 1) * $block_ct) + 1;  // 블록의 시작번호
                                                    $block_end = $block_start + $block_ct - 1;          //블록 마지막 번호
                                                    
                                                    
                                                    $total_page = ceil($row_num / $list);
                                                    if($block_end > $total_page) {
                                                        $block_end = $total_page;                       //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
                                                    }
                                                    $total_block = ceil($total_page/$block_ct);         //블럭 총 개수
                                                    $start_num = ($page-1) * $list;                     //시작번호 (page-1)에서 $list를 곱한다.
                        
                                                    $first_num = $row_num-$list*($page-1);

                                                    $count = $row_num-$list*($page-1);

                                                    $S_SQL = 
                                                    "SELECT 
                                                        e.idx, e.ev_subject, e.ev_url, e.ev_start, e.ev_end, e.ev_stat, e.ev_always, e.reg_date , br_name
                                                    FROM 
                                                        mpr_event e LEFT JOIN mpr_branch b ON e.br_code = b.br_code WHERE {$strWhere}
                                                    {$oderBy}
                                                    LIMIT {$start_num}, {$list}";

                                                    $res = $DB -> query($S_SQL);
                                                    foreach($res as $row){
                                            ?>
                                            <tr>
                                                <td><?php echo $count--;?></td>
                                                <td><a href="form.php?mode=update&idx=<?php echo $row['idx']?>" style="color:black;"><?php echo $row['ev_subject']?></a></td>
                                                <td><a href="<?php echo $row['ev_url']?>" target="_blank">URL</a></td>
                                                <td><?php echo $row['br_name']?></td>
                                                <?php 
                                                    if($row['ev_always'] == "Y"){
                                                        echo '<td>상시</td>';
                                                    }else{
                                                        echo '<td>'.$row['ev_start']."~".$row['ev_end'].'</td>';
                                                    }
                                                ?>
                                                <td>
                                                    <?php 
                                                        $regDate = date("Y-m-d", strtotime($row['reg_date']));
                                                        echo $regDate;
                                                    ?>
                                                    </td>
                                                <td>
                                                    <?php 
                                                        switch($row['ev_stat']){
                                                            case "W" :
                                                                echo "진행 예정";
                                                                break;
                                                            case "Y" :
                                                                echo "진행중";
                                                                break;
                                                            case "N" :
                                                                echo "종료";
                                                                break;
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
                                                <td colspan="7">
                                                    <div style="display:flex; justify-content: space-between"  id="ev_reg">
                                                        <div style="float:left;" id="page_Limit">
                                                            <label for="pageLimit" style="float:left; margin : 4px 10px 0 0;" >페이지당 조회 건수</label>
                                                            <select class="form-control select2" name="pageLimit" id="pageLimit" style="width:55px; height:30px; font-size:small; margin-right: 5px;">
                                                                <option value="10" <?php echo trim($list)=='10'?' selected ':'';?>>10개</option>
                                                                <option value="20" <?php echo trim($list)=='20'?' selected ':'';?>>20개</option>
                                                                <option value="30" <?php echo trim($list)=='30'?' selected ':'';?>>30개</option>
                                                            </select>
                                                        </div>
                                                        <a class="btn btn-sm btn-primary" href="/admin/event/form.php">신규 등록</a>
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
                                        Page : <?php echo $page?> / Total : <?php echo $total_page ?>
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
                                            for($i=$block_start; $i<=$block_end; $i++){ 
                                                if($total_page !=0 ){
                                                    if($page == $i){  
                                                        echo "<li class='paginate_button page-item active'><button class='page-link' disabled>".$i."</button></li>";
                                                    }else{
                                                        echo "<li class='paginate_button page-item'><button class='page-link nextPage".$i."' value='".$i."' onclick='nextPage(this.value)'>".$i."</button></li>";
                                                    }
                                                }else{
                                                    echo "<li class='paginate_button page-item active'><button class='page-link'>1</button></li>";
                                                }
                                            }
                                            if( ($page+1) <= $block_end){
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

    /* stat */
    $('#st_total').on("click", function(){
        $("#stat").val("total");
        $("form").submit();
    });
    $('#st_w').on("click", function(){
        $("#stat").val("W");
        $("form").submit();
    });
    $('#st_y').on("click", function(){
        $("#stat").val("Y");
        $("form").submit();
    });
    $('#st_n').on("click", function(){
        $("#stat").val("N");
        $("form").submit();
    });

    $(".applyBtn").on("click", function(){
        console.log("hi");
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
        $("#inSearch").val("");
    });
</script>

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>