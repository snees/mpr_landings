<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

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

                                                if(isset($_GET['page'])){
                                                    $page = $_GET['page'];
                                                } else {
                                                    $page = 1;
                                                }
                                                
                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_event;");

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

                                                $S_SQL = "SELECT * FROM mpr_event ORDER BY idx DESC LIMIT {$start_num}, {$list};";
                                                $res = $DB -> query($S_SQL);
                                                foreach($res as $row){
                                                    $B_SQL = "SELECT br_name FROM mpr_branch WHERE br_code = '{$row['br_code']}';";
                                                    $b_res = $DB -> row($B_SQL);
                                                    $date = date("ymdh",strtotime($row['reg_date']));
                                            ?>
                                            <tr>
                                                <td><?php echo $row['idx']?></td>
                                                <td><a href="form.php?mode=update&idx=<?php echo $row['idx']?>" style="color:black;"><?php echo $row['ev_subject']?> (<?php echo $date?>)</a></td>
                                                <td><a href="#" onclick="go(this)">URL</a></td>
                                                <td><?php echo $b_res['br_name']?></td>
                                                <td><?php echo $row['ev_start']?> ~ <?php echo $row['ev_end']?></td>
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