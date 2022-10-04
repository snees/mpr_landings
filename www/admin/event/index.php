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
                                                $S_SQL = "SELECT * FROM mpr_event ORDER BY idx DESC;";
                                                $res = $DB -> query($S_SQL);
                                                foreach($res as $row){
                                                    $B_SQL = "SELECT br_name FROM mpr_branch WHERE br_code = '{$row['br_code']}';";
                                                    $b_res = $DB -> row($B_SQL);
                                                    $date = date("ymdh",strtotime($row['reg_date']));
                                            ?>
                                            <tr>
                                                <td><?php echo $row['idx']?></td>
                                                <td><?php echo $row['ev_subject']?> (<?php echo $date?>)</td>
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
                                        Page : 1 / Total : 5
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled">
                                            <a href="#" class="page-link">
                                                이전
                                            </a>
                                        </li>
                                        <li class="paginate_button page-item active">
                                            <a href="#" class="page-link">
                                                1
                                            </a>
                                        </li>
                                        <li class="paginate_button page-item next disabled">
                                            <a href="#" class="page-link">
                                                다음
                                            </a>
                                        </li>
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