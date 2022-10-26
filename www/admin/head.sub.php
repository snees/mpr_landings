<?php
session_start();
include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/common.top.php";
include_once trim($_SERVER['DOCUMENT_ROOT'])."/config.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPR-LANDINGS</title>

    <!-- Fontsets -->
    <link rel="stylesheet" href="<?php echo INC_URL ?>/fonts.css">
    <!-- Fonts Awesome -->
    <link rel="stylesheet" href="<?php echo INC_URL ?>/font-awesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo INC_URL ?>/font-awesome/css/solid.css">
    <link rel="stylesheet" href="<?php echo INC_URL ?>/font-awesome/css/brand.css">
    <!-- Swiper CSS -->
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" >
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="<?php echo INC_URL; ?>/summernote/summernote-lite.css">
    <!-- ColorPicker CSS -->
    <link rel="stylesheet" href="<?php echo INC_URL; ?>/spectrum/spectrum.css"/>
    <!-- TimePicker CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <!-- Theme style -->
	<link rel="stylesheet" href="<?php echo INC_URL; ?>/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo INC_URL ?>/default.css">

    <!-- jQuery -->
    <script src="<?php echo INC_URL ?>/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo INC_URL; ?>/bootstrap.bundle.min.js"></script>
    <!-- Summernote JS -->
    <script src="<?php echo INC_URL; ?>/summernote/summernote-lite.js"></script>
    <script src="<?php echo INC_URL; ?>/summernote/summernote-ko-KR.js"></script>
    <!-- ColorPicker JS -->
    <script src="<?php echo INC_URL; ?>/spectrum/spectrum.js"></script>
    <!-- TimePicker JS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <!-- AdminLTE App -->
	<script src="<?php echo INC_URL; ?>/adminlte.min.js"></script>
	<!-- High Chart -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<!-- High Chart labeling Module -->
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">