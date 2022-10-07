<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";

    $strSearch = trim($_GET['search']);
    $keyword = trim($_GET['input_search']);

    $max_date = $DB -> row("SELECT MAX(ev_end) AS max_date FROM mpr_event");
    $min_date = $DB -> row("SELECT MIN(ev_start) AS min_date FROM mpr_event");
    if(trim($_GET['reservation'])){
        $datepicker = $_GET['reservation'];
        $startDate = explode(" ", $datepicker)[0];
        $endDate = explode(" ", $datepicker)[2];
        
    }else{
        $startDate = $min_date['min_date'];
        $endDate = $max_date['max_date'];
    }
    if(!trim($_GET['stat'])){
        $stat = "total";
    }else{
        $stat = $_GET['stat'];
    }
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $( function() {
        $( "#reservation" ).daterangepicker({
            <?php 
                
            ?>
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
    });


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
        $(".a_link").hover(function(){
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
    })
    
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
                                                <th colspan="6" style="padding:0px;">
                                                    
                                                    <div class="navbar navbar-expand navbar-white navbar-light d-flex justify-content-between" id="navbar-search2" >
                                                        <ul class="nav navbar-nav" style="list-style:none; margin:0px; padding:0 10px;">
                                                            <li style="float:left; margin-right:5px;"><a class="a_link" href="index.php?stat=total" id="st_total" style="color:#BDBDBD;">전체</a></li>
                                                            <li style="float:left; margin-right:5px;"><a class="a_link" href="index.php?stat=W" id="st_w" style="color:#BDBDBD;">진행 예정</a></li>
                                                            <li style="float:left; margin-right:5px;"><a class="a_link" href="index.php?stat=Y" id="st_y" style="color:#BDBDBD;">진행중</a></li>
                                                            <li style="float:left; margin-right:5px;"><a class="a_link" href="index.php?stat=N" id="st_n" style="color:#BDBDBD;">종료</a></li>
                                                        </ul>
                                                        
                                                        <form class="form-inline" action="index.php?stat=<?php echo $stat?>">
                                                            <div class="form-group" >
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right" id="reservation" name="reservation"style="height:30px; width:220px; margin-right:5px;">
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                            <input type="hidden" value="<?php echo $stat?>" name="in_stat">
                                                            <div class="form-group" style="width: 90px; justify-content:right;">
                                                                <select class="form-control select2" name="search" style="width:100%; height:30px; font-size:small; margin-right: 5px;">
                                                                    <option value="br_name" <?php echo trim($strSearch)=='br_name'?' selected ':'';?>>업체</option>
                                                                    <option value="ev_subject" <?php echo trim($strSearch)=='ev_subject'?' selected ':'';?>>이벤트 제목</option>
                                                                </select>
                                                            </div>

                                                            <div class="input-group input-group-sm" >
                                                                <input class="form-control form-control-navbar" type="search" value="<?php echo trim($keyword);?>" placeholder="검색어를 입력하세요." aria-label="Search" name="input_search" autocomplete='off'>
                                                                <div class="input-group-append">
                                                                <button class="btn btn-navbar" type="submit">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                </div>
                                                            </div>
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
                                                <th class="sorting sorting_asc" aria-controls="event-list">상태</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $arryWhere = array();

                                                // 검색 안했을때 테이블 가져오기
                                                if($stat =="total"){
                                                    $strWhere = "e.del_yn='N' AND ev_start >= '{$startDate}' AND ev_end <= '{$endDate}'";
                                                }else{
                                                    $strWhere = "e.del_yn='N' AND ev_stat = '{$stat}'";
                                                }
                                                // 검색했을때 테이블 가져오기
                                                if ( trim($_GET['search']) && trim($_GET['input_search']) ) {
                                                    $strWhere = "e.del_yn='N' AND ev_start >= '{$startDate}' AND ev_end <= '{$endDate}' AND ";
                                                    if( trim($_GET['in_stat']) != "total"){
                                                        $arryWhere[] = "ev_stat = '{$_GET['in_stat']}' and {$_GET['search']} like '%{$_GET['input_search']}%' ";
                                                    }else{
                                                        $arryWhere[] = "{$_GET['search']} like '%{$_GET['input_search']}%' ";
                                                    }
                                                    $strWhere.= implode(' and ', $arryWhere);//---- 배열로 만든다. explode('@', '문자열@문자열@문자열')
                                                    
                                                    
                                                }
                                                echo '<script>console.log("'.$strWhere.'");</script>';
                                                if(isset($_GET['page'])){
                                                    $page = $_GET['page'];
                                                } else {
                                                    $page = 1;
                                                }

                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_event e LEFT JOIN mpr_branch b ON e.br_code = b.br_code WHERE {$strWhere};");
                                                // echo $row_num;

                                                if($row_num == 0){
                                                    echo "<tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan='5'>검색결과가 없습니다.</td>
                                                            </tr>";
                                                }else{

                                                    $list = 5;
                                                    $block_ct = 10;
                                                            
                                                    $block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
                                                    $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
                                                    $block_end = $block_start + $block_ct - 1; //블록 마지막 번호
                                                    
                                                    
                                                    $total_page = ceil($row_num / $list);
                                                    if($block_end > $total_page) {
                                                        $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
                                                    }
                                                    $total_block = ceil($total_page/$block_ct); //블럭 총 개수
                                                    $start_num = ($page-1) * $list; //시작번호 (page-1)에서 $list를 곱한다.
                        
                                                    $first_num = $row_num-$list*($page-1);

                                                    $count = $row_num-$list*($page-1);

                                                    $S_SQL = 
                                                    "SELECT 
                                                        e.idx, e.ev_subject, e.ev_url, e.ev_start, e.ev_end, e.ev_stat, br_name
                                                    FROM 
                                                        mpr_event e LEFT JOIN mpr_branch b ON e.br_code = b.br_code WHERE {$strWhere}
                                                    order by idx desc
                                                    LIMIT {$start_num}, {$list}";

                                                    // echo $S_SQL;
                                                    $res = $DB -> query($S_SQL);
                                                    foreach($res as $row){
                                                        $date = date("ymdh",strtotime($row['reg_date']));
                                            ?>
                                            <tr>
                                                <td><?php echo $count--;?></td>
                                                <td><a href="form.php?mode=update&idx=<?php echo $row['idx']?>" style="color:black;"><?php echo $row['ev_subject']?> (<?php echo $date?>)</a></td>
                                                <td><a href="#" onclick="go(this)">URL</a></td>
                                                <td><?php echo $row['br_name']?></td>
                                                <?php 
                                                    if($row['ev_end'] == "0000-00-00"){
                                                        $end = "";
                                                    }else{
                                                        $end = $row['ev_end'];
                                                    }
                                                ?>
                                                <td><?php echo $row['ev_start']?> ~ <?php echo $end?></td>
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
                                                <td colspan="3">
                                                    <a class="btn btn-sm btn-primary" href="/admin/event/form.php">신규 등록</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTable-info" role="status">
                                        Page : <?php echo $page?> / Total : <?php echo $block_end ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination">
                                        <?php
                                            if( ($page-1) > 0){
                                                $prev = $page - 1;
                                                echo "<li class='paginate_button page-item next'><a href='index.php?page={$prev}' class='page-link'>이전</a></li>";
                                            }else{
                                                echo "<li class='paginate_button page-item next disabled'><a href='#' class='page-link'>이전</a></li>";
                                            }
                                            for($i=$block_start; $i<=$block_end; $i++){ 
                                                if($page == $i){  
                                                    echo "<li class='paginate_button page-item active'><a href='#' class='page-link'>$i</a></li>";
                                                }else{
                                                    echo "<li class='paginate_button page-item'><a href='index.php?page={$i}' class='page-link'>$i</a></li>";
                                                }
                                            }
                                            if( ($page+1) <= $block_end){
                                                $next = $page + 1;
                                                echo "<li class='paginate_button page-item next'><a href='index.php?page={$next}' class='page-link'>다음</a></li>";
                                            }else{
                                                echo "<li class='paginate_button page-item next disabled'><a href='#' class='page-link'>다음</a></li>";
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

<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>