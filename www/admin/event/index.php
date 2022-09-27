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
                                            <tr class="odd">
                                                <td>5</td>
                                                <td>신규 제품 이벤트 (22092614)</td>
                                                <td><a href="//">URL</a></td>
                                                <td>업체 A</td>
                                                <td>2022-09-26 ~ 10-25</td>
                                                <td>진행중</td>
                                            </tr>
                                            <tr class="even">
                                                <td>4</td>
                                                <td>신규 제품 이벤트 (22091411)</td>
                                                <td><a href="//">URL</a></td>
                                                <td>업체 B</td>
                                                <td>2022-09-11 ~ 10-10</td>
                                                <td>진행중</td>
                                            </tr>
                                            <tr class="odd">
                                                <td>3</td>
                                                <td>신규 제품 이벤트 (22100113)</td>
                                                <td><a href="//">URL</a></td>
                                                <td>업체 C</td>
                                                <td>2022-10-01 ~ 10-31</td>
                                                <td>진행예정</td>
                                            </tr>
                                            <tr class="even">
                                                <td>2</td>
                                                <td>신규 제품 이벤트 (22082520)</td>
                                                <td><a href="//">URL</a></td>
                                                <td>업체 F</td>
                                                <td>2022-08-25 ~ 10-25</td>
                                                <td>진행중</td>
                                            </tr>
                                            <tr class="odd">
                                                <td>1</td>
                                                <td>신규 제품 이벤트 (22080110)</td>
                                                <td><a href="//">URL</a></td>
                                                <td>업체 D</td>
                                                <td>2022-08-01 ~ 08-31</td>
                                                <td>종료</td>
                                            </tr>
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