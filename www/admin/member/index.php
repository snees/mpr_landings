<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.php";
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }
    if(isset($_GET['listnum']))
    {
        $listNum=$_GET['listnum'];
    }
    else
    {
        $listNum=10;
    }
    $sql="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' order by reg_Date asc";
    $tmp=$DB->query($sql);
    $cnt = count($tmp);
    $category=$_GET["category"];
    $search=$_GET["search"];
    $sort=$_REQUEST["orderby"];
    $updown=$_REQUEST["updown"];
    $compare=$_REQUEST["compare"];
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
    if(!$search)
    {   
        if(!$sort)
        {
            $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' order by reg_date desc limit $start, $listNum";
        }
        else
        {
            $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' order by $sort $updown limit $start, $listNum";
        }
        
    }
    else{
        if(!$sort)
        {
            $sql_tmp="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by reg_date asc";
            $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by reg_date desc limit $start, $listNum";
        }
        else
        {
            $sql_tmp="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by $sort $updown";
            $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by $sort $updown limit $start, $listNum";
        }
        // $sql_tmp="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by reg_date asc";
        // $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' and $category like '%$search%' order by reg_date desc limit $start, $listNum";
        $tmp=$DB->query($sql_tmp);
        $cnt = count($tmp);
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
    }
    $result=$DB->query($sql2);
    // echo "<script>console.log('1234:".$sort."');</script>";
    // echo "<script>console.log('5678:".$compare."');</script>";
    $max = $cnt-(($page-1)*$listNum)+1;
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
                                                    <div class="navbar navbar-expand navbar-white navbar-light d-flex justify-content-between" id="navbar-search2">
                                                    <div style="width: 90px; justify-content:left;">
                                                                    <select class="form-control select2" name="listnum" style="width:100%; height:30px; font-size:small; margin-right: 5px;" onchange="sort(this.value)">
                                                                        <option value="">조회개수</option>
                                                                        <option value="10">10개</option>
                                                                        <option value="15">15개</option>
                                                                        <option value="20">20개</option>
                                                                    </select>
                                                            </div>
                                                    <form class="form-inline" action="index.php?test=test" method="get" name ="form2">
                                                        <input type = "hidden" value="test">
                                                            <div class="form-group" style="width: 90px; justify-content:right;">
                                                                    <select class="form-control select2" name="category" style="width:100%; height:30px; font-size:small; margin-right: 5px;" >
                                                                        <option value="user_nm">이름</option>
                                                                        <option value="user_id">회원ID</option>
                                                                    </select>
                                                            </div>
                                                            
                                                            <div class="input-group input-group-sm">
                                                                <input class="form-control form-control-navbar" type="search" placeholder="검색어를 입력해주세요." aria-label="Search" name="search" autocomplete="off">
                                                                <!-- <input type="hidden" name="page" value="> -->
                                                                <div class="input-group-append">
                                                                <button class="btn btn-navbar" type="submit" >
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
                                                <th class="sorting sorting_asc" aria-controls="member-list" id="num" data-name="user_lv" onclick="updown(this.id)">레벨
                                                    <?php 
                                                    if($updown=="asc" and $sort=="user_lv")
                                                        {?> <i class="fa-solid fa-caret-down" id="updownImg"></i>
                                                  <?php } else if($updown=="desc" and $sort=="user_lv"){?>
                                                    <i class="fa-solid fa-caret-up" id="updownImg"></i></th>
                                                  <?php } else {?>
                                                            <i class="fa-solid fa-caret-down" id="updownImg"></i>
                                                        <?php }?>
                                                <th class="sorting sorting_asc" aria-controls="member-list">연락처</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list">이메일</th>
                                                <th class="sorting sorting_asc" aria-controls="member-list" id="apprve" data-name="apprve" onclick="updown(this.id)">승인 여부
                                                <?php 
                                                    if($updown=="asc" and $sort=="apprve")
                                                        {?> <i class="fa-solid fa-caret-down" id="updownImg"></i>
                                                  <?php } else if($updown=="desc" and $sort=="apprve"){?>
                                                    <i class="fa-solid fa-caret-up " id="updownImg"></i></th>
                                                  <?php } else {?>
                                                            <i class="fa-solid fa-caret-down" id="updownImg"></i>
                                                        <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            //  if(isset($_GET['page'])){
                                            //     $page=$_GET['page'];
                                            // }
                                            // else{
                                            //     $page=1;
                                            // }
                                            // $sql="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' order by reg_Date asc";
                                            // $tmp=$DB->query($sql);
                                            // $cnt = count($tmp);
                                            // $category=$_GET["category"];
                                            // $search=$_GET["search"];
                                            // $listNum=5;
                                            // $pageNum=5;
                                            // $totalPage=ceil($cnt/$listNum); // 총 페이지 수
                                            // $totalBlock=ceil($totalPage/$pageNum); // 총 블럭 수
                                            // $nowBlock=ceil($page/$pageNum);
                                            // $startPageNum=($nowBlock-1)*$pageNum+1;
            
                                            // if($startPageNum<=0){
                                            //     $startPageNum = 1;
                                            // };
                                        
                                            // $endPageNum= $nowBlock*$pageNum;
                                            // if($endPageNum>$totalPage){
                                            //     $endPageNum=$totalPage;
                                            // }; 
                                            
                                            // $start=($page-1)*$listNum;
                                            // if(!$category or !$search)
                                            // {   
                                            //     $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' order by reg_Date desc limit $start, $listNum";
                                            // }
                                            // else{
                                            //     $sql_tmp="select user_id, user_nm, user_nick, user_lv, user_mobile, user_email, apprve from mpr_member where del_yn='N' and locate('$search',$category)order by reg_Date asc";
                                            //     $sql2 = "select user_id, user_nm, user_nick, user_lv, user_mobile,user_email, apprve from mpr_member where del_yn='N' and locate('$search',$category) order by reg_Date desc limit $start, $listNum";
                                            //     $tmp=$DB->query($sql_tmp);
                                            //     $cnt = count($tmp);
                                            //     $listNum=5;
                                            //     $pageNum=5;
                                            //     $totalPage=ceil($cnt/$listNum); // 총 페이지 수
                                            //     $totalBlock=ceil($totalPage/$pageNum); // 총 블럭 수
                                            //     $nowBlock=ceil($page/$pageNum);
                                            //     $startPageNum=($nowBlock-1)*$pageNum+1;

                                            //     if($startPageNum<=0){
                                            //         $startPageNum = 1;
                                            //     };
                                            
                                            //     $endPageNum= $nowBlock*$pageNum;
                                            //     if($endPageNum>$totalPage){
                                            //         $endPageNum=$totalPage;
                                            //     }; 
                                                
                                            //     $start=($page-1)*$listNum;
                                            // }
                                            
                                            // $result=$DB->query($sql2);
                                            // $max = $cnt-(($page-1)*$listNum)+1;
                                            // echo "<script>console.log('".$cnt."');</script>";
                                            if(count($result)==0){?>
                                                <tr class="odd">
                                                        <td colspan="8" align="center">해당하는 정보가 없습니다.</td>
                                                            <!-- <?php echo "<script>console.log('count:".count($result)."');</script>";?>
                                                            <?php echo "<script>console.log('search:".$search."');</script>";?>
                                                            <?php echo "<script>console.log('count search:".count($search)."');</script>";?>
                                                            <?php echo "<script>console.log('len search:".strlen($search)."');</script>";?> -->
                                                </tr>    
                                    <?php } else{
                                                for($i=0; $i < count($result); $i++){
                                                    $max--;?>
                                                        <tr class="odd">
                                                            <td><?php echo $max; ?></td>
                                                            <td><a href="/admin/member/updateinfo.php?id=<?php echo $result[$i]['user_id'];?>"><?php echo $result[$i]['user_id'];?></a></td>
                                                            <td><?php echo $result[$i]['user_nm'];?></td>
                                                            <td><?php echo $result[$i]['user_nick'];?></td>
                                                            <td><?php if($result[$i]['user_lv']==100){?>일반회원
                                                            <?php }else {?> 관리자<?php }?></td>
                                                            <td><?php echo $result[$i]['user_mobile'];?></td>
                                                            <td><?php echo $result[$i]['user_email'];?></td>
                                                            <td><?php if($result[$i]['apprve']=="Y"){?>승인
                                                            <?php }else {?> 비승인 <?php }?></td>
                                                            <!-- <?php echo "<script>console.log('count:".count($result)."');</script>";?>
                                                            <?php echo "<script>console.log('search:".$search."');</script>";?>
                                                            <?php echo "<script>console.log('count search:".count($search)."');</script>";?>
                                                            <?php echo "<script>console.log('len search:".strlen($search)."');</script>";?> -->
                                                        </tr>
                                                <?php }
                                                }?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8">
                                                            <a class="btn btn-sm btn-primary" href="/admin/member/form.php">신규 등록</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>        
                                            <form name="form1" id="form1" method="post">
                                                    <input type="hidden" name="orderby" id="orderby" value="<?php echo $sort?>">
                                                    <input type="hidden" name="updown" id="updown1" value="<?php echo $updown?>">
                                                    <input type="hidden" name="compare" id="compare" value="">
                                            </form>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTable-info" role="status">
                                        Page : <?php echo $page?> / Total : <?php echo $totalPage; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination">
                                            <?php if(!$search){
                                                if($page<=1)
                                                {?>
                                                    <li class="paginate_button page-item previous disabled"><a href ="/admin/member/index.php?listnum=<?php echo $listNum?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=1" class="page-link">이전</a></li>
                                            <?php } else {?>
                                                <li class="paginate_button page-item previous "><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo ($page-1);?>" class="page-link">이전</a></li><?php } ?>
                                                <li class="paginate_button page-item active">
                                                    <?php
                                                    for($printPage = $startPageNum; $printPage <= $endPageNum; $printPage++){
                                                        if($page==$printPage){?>
                                                        <li class="paginate_button page-item active"><a href="#" class="page-link" ><?php echo $printPage;?></a></li>
                                                        <?php } else {?>
                                                        <li class="paginate_button page-item"><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo $printPage; ?>" class="page-link" ><?php echo $printPage;?></a></li>
                                                        <?php }?>
                                                    <?php };?>
                                                </li>
                                                <?php if($page >= $totalPage){?>
                                                <li class="paginate_button page-item next disabled"><a href="/admin/member/index.php?page=<?php echo $totalPage;?>" class="page-link">다음</a></li>
                                            <?php } else{?>
                                                <li class="paginate_button page-item next"><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo ($page+1)?>" class="page-link">다음</a></li><?php }?>
                                            </li>
                                            <?php } else {
                                                    if($page<=1)
                                                    {?>
                                                        <li class="paginate_button page-item previous disabled"><a href ="/admin/member/index.php?listnum=<?php echo $listNum?>&category=<?php echo $category ?>&search=<?php echo $search?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=1" class="page-link">이전</a></li>
                                                <?php } else {?>
                                                    <li class="paginate_button page-item previous "><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&category=<?php echo $category ?>&search=<?php echo $search?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo ($page-1);?>" class="page-link">이전</a></li><?php } ?>
                                                    <li class="paginate_button page-item active">
                                                        <?php
                                                        for($printPage = $startPageNum; $printPage <= $endPageNum; $printPage++){
                                                            if($page==$printPage){?>
                                                            <li class="paginate_button page-item active"><a href="#" class="page-link" ><?php echo $printPage;?></a></li>
                                                    <?php } else {?>
                                                            <li class="paginate_button page-item"><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&category=<?php echo $category ?>&search=<?php echo $search?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo $printPage; ?>" class="page-link" ><?php echo $printPage;?></a></li>
                                                        <?php } ?>
                                                        <?php };?>
                                                    </li>
                                                    <?php if($page >= $totalPage){?>
                                                    <li class="paginate_button page-item next disabled"><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&category=<?php echo $category ?>&search=<?php echo $search?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo $totalPage;?>" class="page-link">다음</a></li>
                                                <?php } else{?>
                                                    <li class="paginate_button page-item next"><a href="/admin/member/index.php?listnum=<?php echo $listNum?>&category=<?php echo $category ?>&search=<?php echo $search?>&orderby=<?php echo $sort?>&updown=<?php echo $updown ?>&page=<?php echo ($page+1)?>" class="page-link">다음</a></li><?php }?>
                                            <?php }?>

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
    function sort(value)
    {   
        var a="<?php echo $search?>";
        if(!a)
        {
            location.replace("/admin/member/index.php?listnum="+value);
        }
        else
        {
            location.replace("/admin/member/index.php?category=<?php echo $category ?>&search=<?php echo $search?>&listnum="+value);
        }
    }

    function updown(value)
    {
        var test = document.getElementById(value).dataset.name;
        var tmp = $('#updown1').val();
        var ex = document.getElementById(value).firstElementChild;
        var a = document.getElementById("updownImg");
        if(test==ex.parentElement.dataset.name)
        {
            if(tmp=="desc")
            {
                document.getElementById("orderby").value=test;
                $("#updown1").attr("value","asc");
                $("#compare").attr("value",ex.parentElement.dataset.name);
                ex.setAttribute("class","fa-solid fa-caret-up");
                // ex.classList.replace("fa-caret-up","fa-caret-down");
            }
            else
            {
                document.getElementById("orderby").value=test;
                $("#updown1").attr("value","desc");
                $("#compare").attr("value",ex.parentElement.dataset.name);
                ex.setAttribute("class","fa-solid fa-caret-down");
                // ex.classList.replace("fa-caret-down","fa-caret-up");
            }
        }
        console.log("1번값:" + ex.parentElement.dataset.name);
        console.log("2번값:" + a.parentElement.dataset.name);
        console.log("3번값:" + test);
        console.log(ex);
        $("#form1").submit();
    }
    // document.getElementById("updownImg").addEventListener("click",function(event){
    //     event.preventDefault();
    //     var test = document.getElementById("num").dataset.name;
    //     var tmp = $('#updown1').val();
    //     if(tmp=="desc")
    //     {
    //         document.getElementById("orderby").value=test;
    //         $("#updown1").attr("value","asc");
    //     }
    //     else
    //     {
    //         document.getElementById("orderby").value=test;
    //         $("#updown1").attr("value","desc");
    //     }
    //     console.log(tmp);
    //     $("#form1").submit();
    // })

</script>