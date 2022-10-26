<?php
    ob_start();
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
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
                                                <th colspan="8" style="padding:0px;">
                                                    <div class="navbar navbar-expand navbar-white navbar-light" id="navbar-search2" style="justify-content: right;">
                                                        <form class="form-inline" action="searchResult.php" method="get" name ="form2">
                                                            <div class="form-group" style="width: 90px; justify-content:right;">
                                                                    <select class="form-control select2" name="category" style="width:100%; height:30px; font-size:small; margin-right: 5px;">
                                                                        <option value="user_nm">이름</option>
                                                                        <option value="user_id">회원ID</option>
                                                                    </select>
                                                            </div>
                                                            <div class="input-group input-group-sm">
                                                                <input class="form-control form-control-navbar" type="search" placeholder="업체명을 입력하세요." aria-label="Search" name="search" autocomplete="off">
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
                                                </th>
                                            </tr>
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
                                        <?php
                                             if(isset($_GET['page'])){
                                                $page=$_GET['page'];
                                            }
                                            else{
                                                $page=1;
                                            }
                                            $sql="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' order by reg_Date asc";
                                            $tmp=$DB->query($sql);
                                            $cnt = count($tmp);

                                            $category=$_GET["category"];
                                            $search=$_GET["search"];
                                            $listNum=5;
                                            $pageNum=5;
                                            $totalPage=ceil($cnt/$listNum); // 총 페이지 수
                                            $totalBlock=ceil($totalPage/$pageNum); // 총 블럭 수
                                            $nowBlock=ceil($page/$pageNum);
                                            $startPageNum=($nowBlock-1)*$pageNum+1;
            
                                            if($startPageNum<=0){
                                                $startPageNum = 1;
                                            };
                                        
                                            $endPageNum= $nowBlock*$pageNum;
                                            if($endPageNum>$totalPage){
                                                $endPageNum=$totalPage;
                                            }; 
                                            $start=($page-1)*$listNum;
                                            $max = ($page-1)*$listNum;
                                            $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' and locate('$search',$category) order by reg_Date desc limit $start, $listNum";
                                            $result=$DB->query($sql2);
                                            
                                            // echo "<script>console.log('".$search."');</script>";
                                            // exit;
                                            if(!$search or count($result)==0){?>
                                                <tr class="odd">
                                                        <td colspan="8" align="center">해당하는 정보가 없습니다.</td>
                                                        <?php echo "<script>console.log('".count($result)."');</script>";?>
                                                </tr>    
                                    <?php } else{
                                                for($i=0; $i < count($result); $i++){
                                                    $max++;?>
                                                        <tr class="odd">
                                                            <td><?php echo $max; ?></td>
                                                            <td><a href="/admin/member/updateinfo.php?id=<?php echo $result[$i]['user_id'];?>"><?php echo $result[$i]['user_id'];?></a></td>
                                                            <td><?php echo $result[$i]['user_nm'];?></td>
                                                            <td><?php echo $result[$i]['user_nick'];?></td>
                                                            <td><?php echo $result[$i]['user_lv'];?></td>
                                                            <td><?php echo $result[$i]['user_mobile'];?></td>
                                                            <td><?php echo $result[$i]['user_email'];?></td>
                                                            <td><?php echo $result[$i]['apprve'];?></td>
                                                            <?php echo "<script>console.log('".count($result)."');</script>";?>
                                                        </tr>
                                                <?php }
                                                }?>

                                                </tbody>
                                            </table>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTable-info" role="status">
                                        Page : <?php echo $page?> / Total : <?php echo $totalPage; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <!-- <form action="searchResult.php" method="get" name ="form2" onsubmit="return false">
                                            <select name="category">
                                                <option value="user_nm">이름</option>
                                                <option value="user_id">회원ID</option>
                                            </select>
                                            <input type="text" name="search" size="20" ><input type="button" class="btn btn-primary btn-sm" value="검색" onclick="testPage(this.form)">                
                                    </form> -->
                                    <ul class="pagination">
                                            <?php if($page<=1){?>
                                                <li class="paginate_button page-item previous disabled"><a href ="/admin/member/searchResult.php?page=1" class="page-link">이전</a></li>
                                            <?php } else{?>
                                                <li class="paginate_button page-item previous "><a href="/admin/member/searchResult.php?page=<?php echo ($page-1);?>" class="page-link">이전</a></li><?php } ?>
                                        <li class="paginate_button page-item active">
                                            <?php
                                                for($printPage = $startPageNum; $printPage <= $endPageNum; $printPage++){?>
                                                    <li><a href="/admin/member/searchResult.php?page=<?php echo $printPage; ?>" class="page-link" onclick="test()"><?php echo $printPage;?></a></li>
                                            <?php };?>
                                        </li>
                                            <?php if($page >= $totalPage){?>
                                                <li class="paginate_button page-item next disabled"><a href="/admin/member/searchResult.php?page=<?php echo $totalPage;?>" class="page-link">다음</a></li>
                                            <?php } else{?>
                                                <li class="paginate_button page-item next"><a href="/admin/member/searchResult.php?page=<?php echo ($page+1)?>" class="page-link">다음</a></li><?php }?>
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
<script>
    function testPage(frm){
        frm.action="/admin/member/searchResult.php";
        frm.submit();
        return true;
    }
</script>