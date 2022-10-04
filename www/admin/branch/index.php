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
                                                $S_SQL = "SELECT * FROM mpr_branch ORDER BY idx DESC;";
                                                $res = $DB -> query($S_SQL);
                                                $count = $DB -> single("SELECT count(*) FROM `mpr_branch` b LEFT JOIN `mpr_event` e ON b.br_code = e.br_code;");
                                                foreach($res as $row){
                                                    $E_SQL = "SELECT ev_subject FROM mpr_event WHERE br_code = '{$row['br_code']}';";
                                                    $ev_res = $DB -> query($E_SQL);
                                                    $ev_count = $DB -> single("SELECT count(*) FROM mpr_event WHERE br_code = '{$row['br_code']}';");
                                                    $i = $ev_count;
                                                    if($ev_count >= 1){
                                                        foreach($ev_res as $ev_row){
                                                            if($i == $ev_count){
                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count--?></td>
                                                                    <td rowspan="<?php echo $ev_count?>"><a href="#" onclick="go(this)" style="color: black;"><?php echo $row['br_name']?> (<?php echo $row['br_code']?>)</a></td>
                                                                    <td><?php echo $ev_row['ev_subject']?></td>
                                                                </tr>
                                            <?php
                                                            }else{
                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count--?></td>
                                                                    <td><?php echo $ev_row['ev_subject']?></td>
                                                                </tr>
                                            <?php                    
                                                            }
                                                            $i--;          
                                                        }
                                                }else{
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $count--?></td>
                                                            <td><a href="#" onclick="go(this)" style="color: black;"><?php echo $row['br_name']?> (<?php echo $row['br_code']?>)</a></td>
                                                            <td>-</td>
                                                        </tr>
                                            <?php
                                                    }
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