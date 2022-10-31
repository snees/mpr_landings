<?php
include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/session.php"
// ↓ navbar 영역
?>
<script>
    var pageURL = window.location.href;
    page = pageURL.split("/")[4];
    $(function(){
        switch(page){
            case "" : 
                $("#homePage").addClass("active");
                break;
            case "event" :
                $("#eventPage").addClass("active");
                break;
            case "branch" :
                $("#branchPage").addClass("active");
                break;
            case "member" :
                $("#memberPage").addClass("active");
                break;
        }
    });
</script>

    <!-- top navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">

		<!-- top-left nav element -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link pushmenu" data-widget="pushmenu" href="#" role="button"><i class="fa-solid fa-bars"></i></a>
			</li>
		</ul>
        <!-- top-left nav element -end -->

		<!-- top-right nav elements -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item position-relative">
                <i class="fa-solid fa-user-gear"></i>
                <a href="/admin/member/updateinfo/">회원정보 수정</a>
			</li>
            <li>
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="/admin/login/logout.php">로그아웃</span>
            </li>
		</ul>
        <!-- top-right nav elements -end -->

	</nav>
    <!-- top navbar -end -->

    <!-- left navbar -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">

		<!-- brand logo -->
        <a href="/admin/" class="brand-link">
            <span class="brand-text">MPR-LANDINGS</span>
        </a>
        <!-- brand logo end -->
		
		<!-- Menulist wrapper -->
		<div class="sidebar">
			
			<!-- Menulist -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="/admin/" class="nav-link" id="homePage">
                            <i class="fa-solid fa-house-chimney"></i>
                            <p>홈 화면</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/event/" class="nav-link" id="eventPage">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>이벤트 목록</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/branch/" class="nav-link" id="branchPage">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>업체 목록</p>
                        </a>
                    </li>
                    <?php if($_SESSION['lvl']==300){?>
                    <li class="nav-item">
                        <a href="/admin/member/" class="nav-link" id="memberPage">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>회원 목록</p>
                        </a>
                    </li>
                    <?php }?>

                    <hr>

				</ul>
			</nav>
            <!-- Menulist -end -->

		</div>
        <!-- Menulist wrapper -end -->

	</aside>
    <!-- left navbar -end -->
