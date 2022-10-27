<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";

    /* 검색 정보 */
    if(count($_POST)>0){    // 검색했을 때
        $keyword = $_POST['input_search'];                      // 검색어
        $list = $_POST['lines'];                                // 페이지당 조회 건수
    }else{                  // 검색 안했을 때
        $list = 10;
    }
?>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>업체 목록</h1>
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

                                    <table id="client-list" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="padding:0px;">
                                                    <div class="navbar navbar-expand navbar-white navbar-light" id="navbar-search2" style="justify-content: right;">
                                                        <form class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                                                            <div class="input-group input-group-sm" >
                                                                <input class="form-control form-control-navbar" type="text" placeholder="업체명을 입력하세요." value="<?php echo $keyword?>" id="inSearch" name="input_search" autocomplete='off'>
                                                                <div class="input-group-append">
                                                                <button class="btn btn-navbar" type="submit">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                <button class="btn btn-navbar" type="button" id="searchCancel">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="lines" name="lines" value="<?php echo $list ?>">
                                                            <input type="hidden" value="1" name="pageMove" id="pageMove">
                                                        </form>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="sorting sorting_asc" aria-controls="client-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">업체</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">업체 코드</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">아이디</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">등록 이벤트</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $arryWhere = array();
                                                $strQueryString= "";

                                                $lv_SQL = "SELECT user_lv FROM mpr_member WHERE user_id = '{$_SESSION['userId']}'";
                                                $user_lv = $DB -> row($lv_SQL);

                                                if( trim($user_lv['user_lv']) == 100 ){
                                                    $strWhere = "del_yn = 'N' AND user_id = '{$_SESSION['userId']}'";
                                                }else{
                                                    $strWhere = "del_yn = 'N'";
                                                }

                                                if (trim($_POST['input_search']) ) {
                                                    $strWhere = "del_yn = 'N' AND ";
                                                    $arryWhere[] = "br_name like '%{$_POST['input_search']}%' ";
                                                    $strWhere.= implode(' and ', $arryWhere);//---- 배열로 만든다. explode('@', '문자열@문자열@문자열')
                                                    $strQueryString.= "&search={$keyword}";
                                                }
                                                if(isset($_POST['pageMove'])){
                                                    $page = $_POST['pageMove'];
                                                } else {
                                                    $page = 1;
                                                }
                
                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_branch WHERE {$strWhere};");
                                                
                                                if($row_num == 0){
                                                    echo "<tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan='2'>검색결과가 없습니다.</td>
                                                            </tr>";
                                                    $total_page=0;
                                                }else{
                
                                                    $list = 5;
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
                        
                                                    $count = $row_num-$list*($page-1);
                                            ?>

                                            <?php
                                                    $B_SQL = "SELECT * FROM mpr_branch WHERE {$strWhere} order by idx desc LIMIT {$start_num}, {$list} ";
                                                    $res = $DB -> query($B_SQL);
                                                    foreach($res as $row){
                                                        $E_SQL = "SELECT 
                                                                count(case when br_code='{$row['br_code']}' and ev_stat='W' then 1 end) as W_count,
                                                                count(case when br_code='{$row['br_code']}' and ev_stat='Y' then 1 end) as Y_count,
                                                                count(case when br_code='{$row['br_code']}' and ev_stat='N' then 1 end) as N_count
                                                            FROM mpr_event WHERE del_yn='N' ";
                                                        $e_res = $DB -> row($E_SQL);
                                                        echo "<tr>
                                                                    <td>".$count--."</td>
                                                                    <td><a href='/admin/branch/form.php?mode=update&code=".$row['br_code']."' style='color: black;'>".$row['br_name']."</a></td>
                                                                    <td>".$row['br_code']."</td>
                                                                    <td>".$row['user_id']."</td>
                                                                    <td style='color : #8C8C8C;'>진행예정:(".$e_res['W_count'].")&emsp;진행중:(".$e_res['Y_count'].")&emsp;종료:(".$e_res['N_count'].")</td>
                                                                </tr>";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align:right;">
                                                    <div style="float:left;" id="page_Limit">
                                                        <label for="pageLimit" style="float:left; margin : 4px 10px 0 0;" >페이지당 조회 건수</label>
                                                        <select class="form-control select2" name="pageLimit" id="pageLimit" style="width:55px; height:30px; font-size:small; margin-right: 5px;">
                                                            <option value="10" <?php echo trim($list)=='10'?' selected ':'';?>>10개</option>
                                                            <option value="20" <?php echo trim($list)=='20'?' selected ':'';?>>20개</option>
                                                            <option value="30" <?php echo trim($list)=='30'?' selected ':'';?>>30개</option>
                                                        </select>
                                                    </div>
                                                    <a class="btn btn-sm btn-primary" href="/admin/branch/form.php?mode=register">신규 등록</a>
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

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
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
        $("#inSearch").val("");
    });
</script>
<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>