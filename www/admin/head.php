<?php

include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/head.sub.php";

// ↓ navbar 영역
?>

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
                <span>회원정보 수정</span>
			</li>
            <li>
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>로그아웃</span>
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
                        <a href="/admin/" class="nav-link">
                            <i class="fa-solid fa-house-chimney"></i>
                            <p>홈 화면</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/event/" class="nav-link">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>이벤트 목록</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/branch/" class="nav-link">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>업체 목록</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/member/" class="nav-link">
                            <i class="fa-solid fa-list-ul"></i>
                            <p>회원 목록</p>
                        </a>
                    </li>

                    <hr>

                    <!-- 리스트 형식 견본 -->
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                견본 링크
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/main/index.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/main/pages/charts/chartjs.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Charts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/main/pages/tables/simple.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tables</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/main/pages/examples/project-add.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Add</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/main/pages/examples/login-v2.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Login</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/main/pages/examples/register-v2.html" class="nav-link" target="_blank">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register</p>
                                </a>
                            </li>
                        </ul>
                    </li>

				</ul>
			</nav>
            <!-- Menulist -end -->

		</div>
        <!-- Menulist wrapper -end -->

	</aside>
    <!-- left navbar -end -->