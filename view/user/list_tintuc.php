<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<title>Lezo HTML Template | Account</title>
<link href="assets/user/css/bootstrap.css" rel="stylesheet">
<link href="assets/user/css/style.css" rel="stylesheet">
<link href="assets/user/css/slick.css" rel="stylesheet">
<link href="assets/user/css/responsive.css" rel="stylesheet">
<link href="assets/user/css/color-switcher-design.css" rel="stylesheet">
<link id="theme-color-file" href="assets/user/css/color-themes/default-theme.css" rel="stylesheet">

<link rel="shortcut icon" href="assets/user/images/favicon.png" type="image/x-icon">
<link rel="icon" href="assets/user/images/favicon.png" type="image/x-icon">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

</head>

<body>

<div class="page-wrapper">
 	<?php include 'include/header.php'; ?>
	<!--Page Title-->
     <!-- Preloader -->
    <div class="preloader"></div>
	
	<!--Page Title-->
    <section class="page-title" style="background-image:url(assets/user/images/2.jpg);">
    	<div class="auto-container">
        	<h2>Tin tuyển dụng</h2>
        </div>
    </section>
    
    <!--Breadcrumb-->
    <div class="breadcrumb-outer">
    	<div class="auto-container">
        	<ul class="bread-crumb text-center">
            	<li><a href="index.php?page=home">Home</a> <span class="fa fa-angle-right"></span></li>
                <li>Tin tuyển dụng</li>
            </ul>
        </div>
    </div>
    <!--End Page Title-->

    <?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>
<?php
$sql = "
    SELECT 
        j.job_id, 
        j.title, 
        j.location, 
        j.salary, 
        j.created_at, 
        j.description,
        c.name AS company_name,
        c.logo AS company_logo  
    FROM jobs j
    JOIN companies c ON j.company_id = c.company_id
    ORDER BY j.created_at DESC
";

$result = mysqli_query($conn, $sql); 

?>
<section class="news-section">
    <div class="auto-container">
    <div class="row clearfix">
        <?php 
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
        <div class="news-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
                <div class="image">
                    
                    <?php
                        
                        $logo_path = 'uploads/logo/' . htmlspecialchars($row['company_logo'] ?: 'default.png');
                    ?>
                    <a href="index.php?page=user_detail_job&id=<?= $row['job_id'] ?>">
                        <img src="<?= $logo_path ?>" alt="<?= htmlspecialchars($row['company_name']) ?> Logo" 
                            style="width: 100%; height: 200px; object-fit: cover;" /> 
                    </a>
                    <ul class="category">
                        <li><a href="job_list.php?location=<?= urlencode($row['location']) ?>"><?= htmlspecialchars($row['location']) ?></a></li>
                    </ul>
                </div>
                <div class="lower-content">
                    <div class="author">
                        <?= htmlspecialchars($row['company_name']) ?>
                    </div>
                    
                    <h5><a href="job_detail.php?id=<?= $row['job_id'] ?>"><?= htmlspecialchars($row['title']) ?></a></h5>
                    
                    <div class="text">
                        Lương: <?= htmlspecialchars($row['salary']) ?>
                    </div>
                    
                    <div class="text">
                        <?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...
                    </div>
                    
                    <ul class="post-date">
                        <li>Ngày đăng:<?= date("d/m/Y", strtotime($row['created_at'])) ?></li>
                    </ul>
                    
                    <a href="index.php?page=user_detail_job&id=<?= $row['job_id'] ?>" class="theme-btn btn-style-one">Xem thông tin </a>
                </div>
            </div>
        </div>
        
        <?php
            }
        } else {
            echo '<div class="col-12"><p class="text-center">Hiện chưa có tin tuyển dụng nào.</p></div>';
        }
        ?>
        
    </div>
</div>

 
   <?php include 'include/footer.php'; ?>
</div>

</body>
<script src="assets/user/js/jquery.js"></script>
<script src="assets/user/js/popper.min.js"></script>
<script src="assets/user/js/bootstrap.min.js"></script>
<script src="assets/user/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/user/js/jquery.fancybox.js"></script>
<script src="assets/user/js/appear.js"></script>
<script src="assets/user/js/owl.js"></script>
<script src="assets/user/js/wow.js"></script>
<script src="assets/user/js/slick.js"></script>
<script src="assets/user/js/jquery-ui.js"></script>
<script src="assets/user/js/script.js"></script>
<script src="assets/user/js/color-settings.js"></script>
<!-- account36:25-->
</html>