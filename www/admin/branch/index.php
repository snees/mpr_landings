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
                                                <th colspan="3">
                                                    <nav class="navbar navbar-expand navbar-white navbar-light" style="justify-content: right; height:35px;">
                                                        <a class="nav-link" data-widget="navbar-search" data-target="#navbar-search2" href="#" role="button">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                        <div class="navbar-search-block" id="navbar-search2">
                                                            <form class="form-inline" action="index.php?mode=search">
                                                                <div class="input-group input-group-sm">
                                                                    <input class="form-control form-control-navbar" type="search" placeholder="업체명을 입력하세요." aria-label="Search" name="input_search" autocomplete='off'>
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
                                                    </nav>
                                                </th>
                                            </tr>
                                            
                                            
                                            <tr>
                                                <th class="sorting sorting_asc" aria-controls="client-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">업체(이름/코드)</th>
                                                <th class="sorting sorting_asc" aria-controls="client-list">등록 이벤트</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $arryWhere = array();
                                                $strQueryString= "";
                                                $strWhere = '(1)';

                                                if (trim($_GET['input_search']) ) {
                                                    $strWhere = '';
                                                    $arryWhere[] = "br_name like '%{$_GET['input_search']}%' ";
                                                    $strWhere.= implode(' and ', $arryWhere);//---- 배열로 만든다. explode('@', '문자열@문자열@문자열')
                                                    $strQueryString.= "&search={$keyword}";
                                                }
                                                if(isset($_GET['page'])){
                                                    $page = $_GET['page'];
                                                } else {
                                                    $page = 1;
                                                }
                
                                                $row_num = $DB -> single("SELECT count(*) FROM mpr_branch WHERE {$strWhere};");
                                                
                                                if($row_num == 0){
                                                    echo "<tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan='2'>검색결과가 없습니다.</td>
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
                                                            FROM mpr_event";
                                                        $e_res = $DB -> row($E_SQL);
                                                        echo "<tr>
                                                                    <td>".$count--."</td>
                                                                    <td><a href='#' onclick='go(this)' style='color: black;'>".$row['br_name']." (".$row['br_code'].")</a></td>
                                                                    <td>진행예정:(".$e_res['W_count'].")  진행중:(".$e_res['Y_count'].")  종료:(".$e_res['N_count'].")</td>
                                                                </tr>";
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

    // 업체 정보 페이지 이동
    function go(ths){
        var code = $(ths).text();
        console.log(code);
        code = code.split('(');
        code = code[1].split(')')[0];
        location.href = "/admin/branch/form.php?mode=update&code="+code;
    }

    // 검색
    function search(){

    }
</script>
<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/tail.php";
?>