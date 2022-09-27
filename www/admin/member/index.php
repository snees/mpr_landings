<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>회원 목록</h1>
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

                                    <table id="member-list" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" aria-controls="member-list">번호</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">회원 ID</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">이름</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">닉네임</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">레벨</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">연락처</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">이메일</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">승인 여부</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd">
                                                <td>6</td>
                                                <td>ironwater_kim</td>
                                                <td>김철수</td>
                                                <td>철수킴</td>
                                                <td>100</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td>N</td>
                                            </tr>
                                            <tr class="even">
                                                <td>5</td>
                                                <td>yoribogo.joribado</td>
                                                <td>나둘리</td>
                                                <td>호이호이</td>
                                                <td>100</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr class="odd">
                                                <td>4</td>
                                                <td>im_indangsoo</td>
                                                <td>심청이</td>
                                                <td>청아청아심청아</td>
                                                <td>100</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr class="even">
                                                <td>3</td>
                                                <td>no.father_no.brother</td>
                                                <td>홍길동</td>
                                                <td>동에번쩍서에번쩍</td>
                                                <td>100</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr class="odd">
                                                <td>2</td>
                                                <td>manager</td>
                                                <td>관리자</td>
                                                <td>mmmannnaggger</td>
                                                <td>200</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr class="even">
                                                <td>1</td>
                                                <td>admin</td>
                                                <td>최고관리자</td>
                                                <td>im.your.master</td>
                                                <td>300</td>
                                                <td>010-****-****</td>
                                                <td>email@aaa.com</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <a class="btn btn-sm btn-primary" href="/admin/member/form.php">신규 등록</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTable-info" role="status">
                                        Page : 1 / Total : 6
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