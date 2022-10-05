<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
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
                                                <th class="sorting sorting_asc" aria-controls="client-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">업체(이름/코드)</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">등록 이벤트</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(isset($_GET['page'])){
                                                    $page = $_GET['page'];
                                                } else {
                                                    $page = 1;
                                                }
                
                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_branch;");
                
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
                    
                                                $count = $row_num-$list*($page-1);
                                            ?>

                                            <?php
                                                $B_SQL = "SELECT * FROM mpr_branch order by idx desc LIMIT {$start_num}, {$list} ";
                                                $res = $DB -> query($B_SQL);
                                                // for($i=0; $i<; $i++){
                                                //     $E_SQL = "SELECT 
                                                //                     count(case when br_code='{$row['br_code']}' and ev_stat='W' then 1 end) as W_count,
                                                //                     count(case when br_code='{$row['br_code']}' and ev_stat='Y' then 1 end) as Y_count,
                                                //                     count(case when br_code='{$row['br_code']}' and ev_stat='N' then 1 end) as N_count
                                                //                 FROM mpr_event";
                                                //     $e_res = $DB -> row($E_SQL);
                                                //     echo "<tr>
                                                //                 <td>".$count--."</td>
                                                //                 <td><a href='#' onclick='go(this)' style='color: black;'>".$row['br_name']." (".$row['br_code'].")</a></td>
                                                //                 <td>진행예정:(".$e_res['W_count'].")  진행중:(".$e_res['Y_count'].")  종료:(".$e_res['N_count'].")</td>
                                                //             </tr>";
                                                // }
                                                foreach($res as $row){
                                                    $E_SQL = "SELECT 
                                                            count(case when br_code='{$row['br_code']}' and ev_stat='W' then 1 end) as W_count,
                                                            count(case when br_code='{$row['br_code']}' and ev_stat='Y' then 1 end) as Y_count,
                                                            count(case when br_code='{$row['br_code']}' and ev_stat='N' then 1 end) as N_count
                                                        FROM mpr_event";
                                                    $e_res = $DB -> row($E_SQL);
                                                    echo "<tr>
                                                                <td>".$count--."</td>
                                                                <td><a href='#' onclick='go(this)' style='color: black;'>".$row['br_name']." (".$row['br_code'].")</a></td>
                                                                <td>진행예정:(".$e_res['W_count'].")  진행중:(".$e_res['Y_count'].")  종료:(".$e_res['N_count'].")</td>
                                                            </tr>";
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
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
                                        Page : 1 / Total : <?php echo $block_end ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination">
                                        <!-- <li class="paginate_button page-item previous disabled">
                                            <a href="#" class="page-link">
                                                이전
                                            </a>
                                        </li> -->
                                        <?php
                                            if( ($page-1) > 0){
                                                $prev = $page - 1;
                                                echo "<li class='paginate_button page-item next'><a href='index.php?page={$prev}' class='page-link'>이전</a></li>";
                                            }else{
                                                echo "<li class='paginate_button page-item previous disabled'><a href='#' class='page-link'>이전</a></li>";
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
                                        <!-- <li class="paginate_button page-item next disabled">
                                            <a href="#" class="page-link">
                                                다음
                                            </a>
                                        </li> -->
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
    function go(ths){
        var code = $(ths).text();
        console.log(code);
        code = code.split('(');
        code = code[1].split(')')[0];
        location.href = "/admin/branch/form.php?mode=update&code="+code;
    }
</script>
<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>