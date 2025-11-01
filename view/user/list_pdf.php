<?php 
// BẢO ĐẢM SESSION ĐƯỢC BẬT
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<title>Lezo HTML Template | Quản lý CV</title>
<link href="assets/user/css/bootstrap.css" rel="stylesheet">
<link href="assets/user/css/style.css" rel="stylesheet">
<link href="assets/user/css/responsive.css" rel="stylesheet">
<link rel="shortcut icon" href="assets/user/images/favicon.png" type="image/x-icon">
<link rel="icon" href="assets/user/images/favicon.png" type="image/x-icon">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* CSS Tùy chỉnh cho thẻ CV */
    .resume-block .inner-box {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .resume-block .inner-box:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .resume-block h5 a {
        color: #004d99; /* Navy */
        font-weight: bold;
    }
    .resume-actions {
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
        display: flex;
        gap: 10px;
        justify-content: space-around;
    }
    .resume-actions a {
        font-size: 14px;
        text-decoration: none;
        color: #007bff;
        transition: color 0.2s;
    }
    .resume-actions a:hover {
        color: #004d99;
    }
    .text-muted {
        font-size: 0.9em;
    }
</style>

</head>

<body>

<div class="page-wrapper">
    <?php include 'include/header.php'; ?>
    <div class="preloader"></div>
    
    <section class="page-title" style="background-image:url(assets/user/images/2.jpg);">
        <div class="auto-container">
            <h2>Quản lý CV</h2>
        </div>
    </section>
    
    <div class="breadcrumb-outer">
        <div class="auto-container">
            <ul class="bread-crumb text-center">
                <li><a href="index.php?page=home">Home</a> <span class="fa fa-angle-right"></span></li>
                <li>Quản lý CV</li>
            </ul>
        </div>
    </div>
    <?php
    // KẾT NỐI CSDL (GIỮ NGUYÊN)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "job_portal";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    $user_id = $_SESSION['id'] ?? 0; 
    
    if ($user_id === 0) {
        echo '<div class="auto-container py-5"><h3 class="text-center text-danger">Vui lòng đăng nhập để quản lý CV.</h3></div>';
        $conn->close();
        include 'include/footer.php';
        exit;
    }

    $sql = "
        SELECT 
            resume_id, 
            title, 
            summary, 
            created_at,
            skills 
        FROM resumes 
        WHERE user_id = ? 
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    
    <section class="news-section">
        <div class="auto-container">
            <h3 class="title-main mb-4">Danh sách Hồ sơ cá nhân đã tạo (<?= mysqli_num_rows($result) ?> CV)</h3>
            <div class="row clearfix">
                <?php 
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                       
                        $cv_title = htmlspecialchars($row['title'] ?: 'Hồ sơ không tên');
                       
                        $cv_summary = htmlspecialchars(substr($row['summary'], 0, 150)) . '...';
                        
                        $created_date = date("d/m/Y", strtotime($row['created_at']));
                      
                        $cv_skills = htmlspecialchars(substr($row['skills'], 0, 100)) . '...';
                ?>
                
                <div class="resume-block col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="inner-box p-4">
                        <div class="lower-content">
                            <h5><a href="index.php?page=user_detail_cv&id=<?= $row['resume_id'] ?>">
                                <i class="fas fa-file-alt me-2"></i> <?= $cv_title ?>
                            </a></h5>
                            
                            <div class="text mt-3">
                                <p class="mb-1">Kỹ năng: <?= $cv_skills ?></p>
                                <p class="text-muted">Tóm tắt: <?= $cv_summary ?></p>
                            </div>
                            
                            <ul class="post-date mt-3 mb-3">
                                <li><i class="far fa-calendar-alt me-1"></i> Ngày tạo: <?= $created_date ?></li>
                            </ul>
                        </div>
                        
                        <div class="resume-actions">
                            <a href="index.php?page=user_detail_pdf&id=<?= $row['resume_id'] ?>" target="_blank">
                                <i class="fas fa-eye"></i> Xem CV
                            </a>
                           
                             <a href="index.php?page=user_delete_pdf&id=<?= $row['resume_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa CV này không?');" class="text-danger">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php
                    }
                } else {
                ?>
                    <div class="col-12 text-center py-5">
                        <p class="h5 text-muted">Bạn chưa tạo hồ sơ (CV) nào. Hãy bắt đầu tạo hồ sơ đầu tiên của bạn!</p>
                        <a href="index.php?page=user_create_cv" class="theme-btn btn-style-one mt-3">Tạo CV mới</a>
                    </div>
                <?php 
                }
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <?php include 'include/footer.php'; ?>
</div>

<script src="assets/user/js/jquery.js"></script>
<script src="assets/user/js/bootstrap.min.js"></script>
<script src="assets/user/js/script.js"></script>

</body>
</html>