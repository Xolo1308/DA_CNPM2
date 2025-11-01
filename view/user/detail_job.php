<?php
include('controller/kn_data.php'); // file kết nối bạn vừa gửi

?>

<!DOCTYPE html>
<html>

<!-- account36:25-->
<head>
<meta charset="utf-8">
<title>Lezo HTML Template | Blog</title>
<!-- Stylesheets -->
<link href="assets/user/css/bootstrap.css" rel="stylesheet">
<link href="assets/user/css/style.css" rel="stylesheet">
<link href="assets/user/css/slick.css" rel="stylesheet">
<link href="assets/user/css/responsive.css" rel="stylesheet">
<!--Color Switcher Mockup-->
<link href="assets/user/css/color-switcher-design.css" rel="stylesheet">
<!--Color Themes-->
<link id="theme-color-file" href="assets/user/css/color-themes/default-theme.css" rel="stylesheet">

<link rel="shortcut icon" href="assets/user/images/favicon.png" type="image/x-icon">
<link rel="icon" href="assets/user/images/favicon.png" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

</head>

<body>

<div class="page-wrapper">
 	<?php include 'include/header.php'; ?>
	
    <section class="page-title" style="background-image:url(assets/user/images/background/2.jpg);">
    	<div class="auto-container">
        	<h2>Tin đăng tuyển dụng</h2>
        </div>
    </section>
    
    <!--Breadcrumb-->
    <div class="breadcrumb-outer">
    	<div class="auto-container">
        	<ul class="bread-crumb text-center">
            	<li><a href="index.php?page=user_list_job">Home</a> <span class="fa fa-angle-right"></span></li>
                <li>Tin đăng tuyển dụng</li>
            </ul>
        </div>
    </div>
    <!--End Page Title-->
	<!--Sidebar Page Container-->
    <div class="sidebar-page-container">
    	<div class="auto-container">
        	<div class="row clearfix">
            	
                <!--Content Side-->
<?php

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "job_portal";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			die("Kết nối thất bại: " . $conn->connect_error);
		}

		// 2. Lấy ID công việc từ URL
		if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			echo "<script>alert('ID công việc không hợp lệ!'); window.location.href='index.php';</script>";
			exit();
		}

$job_id = (int)$_GET['id'];

// 3. Truy vấn chi tiết công việc và thông tin công ty
$sql = "
    SELECT 
        j.*, 
        c.name AS company_name, 
        c.logo AS company_logo,
        c.address AS company_address,
        c.website AS company_website
    FROM jobs j
    JOIN companies c ON j.company_id = c.company_id
    WHERE j.job_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job_data = $result->fetch_assoc();
$stmt->close();

// 4. Kiểm tra nếu không tìm thấy công việc
if (!$job_data) {
    echo "<script>alert('Không tìm thấy tin tuyển dụng!'); window.location.href='index.php';</script>";
    exit();
}

$title = htmlspecialchars($job_data['title']);
$company_name = htmlspecialchars($job_data['company_name']);
$location = htmlspecialchars($job_data['location']);
$salary = htmlspecialchars($job_data['salary']);
$description = nl2br(htmlspecialchars($job_data['description'])); // nl2br giữ định dạng xuống dòng
$requirements = nl2br(htmlspecialchars($job_data['requirements'])); // Yêu cầu công việc
$deadline = date("d M Y", strtotime($job_data['deadline']));
$created_at = date("d M Y", strtotime($job_data['created_at']));
$logo_path = 'uploads/logo/' . htmlspecialchars($job_data['company_logo'] ?: 'default.png');

?>
<?php 

?>

<div class="auto-container">
    <div class="row clearfix">
        
        <div class="content-side col-lg-8 col-md-12 col-sm-12">
            <div class="blog-single">
                <div class="inner-box">
                    <div class="lower-content">
                        <h2 class="mb-3"><?= $title ?></h2> 

                        <ul class="post-meta">
                            <li><span class="icon fa fa-building"></span><h4>Công ty: <strong><?= $company_name ?></strong></h4></li>
                            <li><span class="icon fa fa-map-marker"></span><h4>Địa điểm: <strong><?= $location ?></strong></h4></li>
                            <li><span class="icon fa fa-money"></span><h4>Mức lương: <strong><?= $salary ?></strong></h4></li>
                            <li><span class="icon fa fa-calendar"></span><h4>Ngày đăng: <strong><?= $created_at ?></strong></h4></li>
                            <li><span class="icon fa fa-hourglass-end"></span><h4>Hạn nộp: <strong><?= $deadline ?></strong></h4></li>
                        </ul>
                        
                        <hr>

                        <div class="text">
                            <h2>Chi tiết thông tin tuyển dụng</h2>

                            <h4>Mô tả Công việc</h4>
                            <div class="text-block"><blockquote><?= $description ?></blockquote></div>

                            <h4>Yêu cầu Công việc</h4>
                            <div class="text-block"><blockquote><?= $requirements ?></blockquote></div>

                            <h4>Thu nhập</h4>
                            <div class="text-block">
                                <blockquote>
                                    - Lương cơ bản: <?= $salary ?> 
                                    - Thu nhập: Thoả thuận -
                                    <br>
                                    - Lương cứng không phụ thuộc doanh số
                                </blockquote>
                            </div>

                            <h4>Quyền lợi</h4>
                            <div class="text-block">
                                <blockquote>
                                    • Lương: UPTO 40.000.000/tháng
                                    + Ăn sáng + trưa free tại tập đoàn
                                    <br>
                                    • Tối thiểu 13 tháng lương/năm.
                                    + Thử việc nhận 100% lương
                                    + Xét tăng lương 1- 2 lần/năm.
                                    <br>
                                    - Lương cứng không phụ thuộc doanh số
                                </blockquote>
                            </div>
                        </div>

                        <div class="actions mt-4 text-center">
                            <a href="application_form.php?job_id=<?= $job_id ?>" class="theme-btn btn-style-one bg-success text-white">
                                <span class="fa fa-send"></span> Ứng Tuyển Ngay
                            </a>
                        </div>
                        
                        <div class="post-share-options clearfix">
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-side sticky-container col-lg-4 col-md-12 col-sm-12">
            <aside class="sidebar default-sidebar">
                <div class="inner sticky-box">
                    
                    <div class="author-box sidebar-widget">    
                        <div class="sidebar-title"><h6>Giới thiệu về Công ty</h6></div>
                        <div class="author-comment">
                            
                            <div class="inner-box text-center">
                                <div class="image">
                                    <img src="<?= $logo_path ?>" alt="<?= $company_name ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #007bff;" />
                                </div>
                                
                                <h4 class="mt-3"><?= $company_name ?></h4> 
                                <div class="actions mt-4 text-center">
                                    <a href="index.php?page=user_tt_company" class="theme-btn btn-style-one bg-success text-white">
                                        <span class="fa fa-send"></span> Xem thông tin 
                                    </a>
                                </div>
                                <hr>
                                    
                                <div class="text text-left">
                                    <p><strong><span class="fa fa-map-marker"></span> Địa chỉ:</strong> <?= $job_data['company_address'] ?? 'Đang cập nhật' ?></p>
                                    <p><strong><span class="fa fa-globe"></span> Website:</strong> 
                                        <a href="<?= $job_data['company_website'] ?? '#' ?>" target="_blank"><?= $job_data['company_website'] ?? 'N/A' ?></a>
                                    </p>
                                    </div>
                                
                                <ul class="social-icon-one mt-3">
                                    </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sidebar-widget popular-posts">
                        <div class="sidebar-title"><h6>Recent News</h6></div>

                        <article class="post">
                            <div class="text"><a href="blog-detail.html">Tips for small small industry decoration</a></div>
                            <div class="post-info">20 Nov. 2017</div>
                        </article>

                        <article class="post">
                            <div class="text"><a href="blog-detail.html">Tips for small small industry decoration</a></div>
                            <div class="post-info">20 Nov. 2017</div>
                        </article>
                        
                        </div>

                    <div class="sidebar-widget popular-tags">
                        <div class="sidebar-title"><h6>Popular Tags</h6></div>
                        <a href="#">Energy</a>
                        <a href="#">Import</a>
                        <a href="#">Recycling</a>
                        <a href="#">Forests</a>
                        <a href="#">Industries</a>
                        <a href="#">wastage</a>
                    </div>
                    
                </div>
            </aside>
        </div>

    </div>
</div>
<?php 
$conn->close();
?>
			
	
</div>
                           
                
  
   
  
</div>
 <?php include 'include/footer.php'; ?>
</body>
<script src="assets/user/js/jquery.js"></script>
<script src="assets/user/js/popper.min.js"></script>
<script src="assets/user/js/bootstrap.min.js"></script>
<script src="assets/user/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/user/js/jquery.fancybox.js"></script>
<script src="assets/user/js/appear.js"></script>
<script src="assets/user/js/owl.js"></script>
<script src="assets/user/js/wow.js"></script>
<script src="assets/user/js/jquery-ui.js"></script>
<script src="assets/user/js/script.js"></script>
<script src="assets/user/js/color-settings.js"></script>
<!-- account36:25-->
</html>