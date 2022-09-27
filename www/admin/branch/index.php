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
                                            <tr class="odd">
                                                <td>5</td>
                                                <td rowspan="3">업체 A (kekekekek)</td>
                                                <td>할인 이벤트</td>
                                            </tr>
                                            <tr class="even">
                                                <td>4</td>
                                                <td>신규 제품 이벤트</td>
                                            </tr>
                                            <tr class="evodden">
                                                <td>3</td>
                                                <td>감사 이벤트</td>
                                            </tr>
                                            <tr class="even">
                                                <td>2</td>
                                                <td>업체 B (rirjtijr)</td>
                                                <td>계절맞이 이벤트</td>
                                            </tr>
                                            <tr class="even">
                                                <td>1</td>
                                                <td>업체 C (fsd0935ds)</td>
                                                <td>신 지점 개점 이벤트</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <a class="btn btn-sm btn-primary" href="/admin/branch/form.php">신규 등록</a>
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