<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
?>

<script>

$(function () {

    // summernote 구동
    $('.editor_textarea').summernote();
    
});

</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>이벤트 관리</h1>
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
                                    <form action="/" method="POST" id="event-form">

                                    <table id="event-form-table" class="table table-bordered">
                                        <tbody>

                                            <!-- 1 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_type">등록 양식</label>
                                                </th>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ev_type" id="ev_type_f" value="F" checked>
                                                            <label class="form-check-label" for="ev_type_f">기본형</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_type" id="ev_type_m" value="M">
                                                            <label class="form-check-label" for="ev_type_m">사용자 지정</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <th>
                                                    <label for="is_sync">CLIENTS 동기화 여부</label>
                                                </th>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="" id="is_sync_y" value="Y">
                                                            <label class="form-check-label" for="is_sync_y">사용</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="" id="is_sync_n" value="N" checked>
                                                            <label class="form-check-label" for="is_sync_n">미사용</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- 2 line -->
                                            <tr>
                                                <th>
                                                    <label for="br_key">이벤트 API KEY</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control form-control-border" id="br_key" name="br_key" autocomplete="off" placeholder="이벤트 API KEY 입력...">
                                                </td>
                                                <th>
                                                    <label for="br_code">업체 선택</label>
                                                </th>
                                                <td>
                                                    <select class="custom-select form-control-border" id="br_code" name="br_code">
                                                        <option value="">Value 1</option>
                                                        <option value="">Value 2</option>
                                                        <option value="">Value 3</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <!-- 3 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_subject">이벤트 제목</label>
                                                </th>
                                                <td colspan="3">
                                                    <input type="text" class="form-control form-control-border" id="ev_subject" name="ev_subject" autocomplete="off" placeholder="이벤트 제목 입력...">
                                                </td>
                                            </tr>

                                            <!-- 4 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_top_content_pc">이벤트 PC 상단 이미지</label>
                                                </th>
                                                <td colspan="3">
                                                    <textarea class="editor_textarea" id="event-pc-image-top" name="ev_top_content_pc"></textarea>
                                                </td>
                                            </tr>

                                            <!-- 5 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_top_content_mo">이벤트 모바일 상단 이미지</label>
                                                </th>
                                                <td colspan="3">
                                                    <textarea class="editor_textarea" id="ev_top_content_mo" name="ev_top_content_mo"></textarea>
                                                </td>
                                            </tr>

                                            <!-- 6 line -->
                                            <tr>
                                                <th>
                                                    <label for="">폼 형식</label>
                                                </th>
                                                <td>
                                                    <legend>기본 폼</legend>
                                                    <div class="d-flex">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="ev_name_yn" checked>
                                                            <label for="ev_name_yn" class="custom-control-label">이름</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_tel_yn" checked>
                                                            <label for="ev_tel_yn" class="custom-control-label">연락처</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <legend>추가 폼</legend>
                                                    <div class="d-flex">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="ev_sex_yn">
                                                            <label for="ev_sex_yn" class="custom-control-label">성별</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_age_yn">
                                                            <label for="ev_age_yn" class="custom-control-label">나이</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_comment_yn">
                                                            <label for="ev_comment_yn" class="custom-control-label">문의사항</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_birthday_yn">
                                                            <label for="ev_birthday_yn" class="custom-control-label">생년월일</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_rec_person_yn">
                                                            <label for="ev_rec_person_yn" class="custom-control-label">추천인</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox ml-3">
                                                            <input class="custom-control-input" type="checkbox" id="ev_counsel_time_yn">
                                                            <label for="ev_counsel_time_yn" class="custom-control-label">연락가능시간대</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- 7 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_bottom_content_pc">이벤트 PC 하단 이미지</label>
                                                </th>
                                                <td colspan="3">
                                                    <textarea class="editor_textarea" id="ev_bottom_content_pc" name="ev_bottom_content_pc"></textarea>
                                                </td>
                                            </tr>

                                            <!-- 8 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_bottom_content_mo">이벤트 모바일 하단 이미지</label>
                                                </th>
                                                <td colspan="3">
                                                    <textarea class="editor_textarea" id="ev_bottom_content_mo" name="ev_bottom_content_mo"></textarea>
                                                </td>
                                            </tr>

                                            <!-- 9 line -->
                                            <tr>
                                                <th>
                                                    <label for="">이벤트 기간</label>
                                                </th>
                                                <td colspan="3">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="ev_always">
                                                            <label for="ev_always" class="custom-control-label">상시 진행</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ev_start">시작일</label>
                                                        <input type="date" class="form-control" name="ev_start" id="ev_start">
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="ev_end">종료일</label>
                                                            <input type="date" class="form-control" name="ev_end" id="ev_end">
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- 10 line -->
                                            <tr>
                                                <th>
                                                    <label for="ev_stat">상태</label>
                                                </th>
                                                <td colspan="3">
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_w" value="W" checked>
                                                            <label class="form-check-label" for="ev_stat_w">진행 예정</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_y" value="Y">
                                                            <label class="form-check-label" for="ev_stat_y">진행중</label>
                                                        </div>
                                                        <div class="form-check ml-3">
                                                            <input class="form-check-input" type="radio" name="ev_stat" id="ev_stat_n" value="N">
                                                            <label class="form-check-label" for="ev_stat_n">종료</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Confirm line -->
                                            <tr>
                                                <td colspan="4">
                                                    <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-info">미리보기</button>
                                                    </div>
                                                    <div class="d-flex">
                                                        <a href="/admin/event/" class="btn btn-danger">취소</a>
                                                        <button type="button" class="btn btn-primary">저장</button>
                                                    </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    </form>
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