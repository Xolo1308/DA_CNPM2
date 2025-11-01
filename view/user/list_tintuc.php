<?php
// ... (Phần include kn_data.php, header, breadcrumb không đổi)

// Đảm bảo bạn đã lấy được $user_id từ Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Dựa trên file xử lý trước, user_id được lưu là 'id' trong session
$user_id = $_SESSION['id'] ?? 0; 


$sql = "
    SELECT 
        resume_id, 
        title, 
        skills, 
        updated_at,
        template_used
    FROM resumes 
    WHERE user_id = '$user_id' 
    ORDER BY updated_at DESC
";

$result = mysqli_query($conn, $sql); 

?>
<section class="news-section">
    <div class="auto-container">
        <h2 style="margin-bottom: 30px; text-align: center;">Danh Sách Hồ Sơ (CV) Đã Tạo</h2>
        
        <div class="row clearfix">
        
            <?php 
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            
            <div class="news-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <div class="image">
                        
                        <?php
                            
                            $template_image = 'assets/user/images/cv_templates/' . htmlspecialchars($row['template_used']) . '.png';
                        ?>
                        <a href="index.php?page=user_detail_cv&id=<?= $row['resume_id'] ?>">
                            <img src="<?= $template_image ?>" 
                                alt="Mẫu CV: <?= htmlspecialchars($row['template_used']) ?>" 
                                style="width: 100%; height: 200px; object-fit: cover; border: 1px solid #ddd;" 
                                onerror="this.onerror=null; this.src='assets/user/images/default_cv.png';"/> 
                        </a>
                        <ul class="category">
                            <li><a href="#"><?= strtoupper(htmlspecialchars($row['template_used'])) ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="lower-content">
                        <div class="author">
                            ID: <?= htmlspecialchars($row['resume_id']) ?>
                        </div>
                        
                        <h5><a href="index.php?page=user_detail_cv&id=<?= $row['resume_id'] ?>"><?= htmlspecialchars($row['title']) ?></a></h5>
                        
                        <div class="text">
                            Kỹ năng: <?= htmlspecialchars(substr($row['skills'], 0, 80)) ?>...
                        </div>
                        
                        <ul class="post-date">
                            <li>Cập nhật lần cuối: <?= date("d/m/Y H:i", strtotime($row['updated_at'])) ?></li>
                        </ul>
                        
                        <a href="index.php?page=user_detail_cv&id=<?= $row['resume_id'] ?>" class="theme-btn btn-style-one">Chỉnh sửa</a>
                        
                        <a href="index.php?page=user_process_pdf&id=<?= $row['resume_id'] ?>" class="theme-btn btn-style-two" style="background-color: #dc3545;">
                            <span class="fa fa-file-pdf-o"></span> Xuất PDF
                        </a>
                    </div>
                </div>
            </div>
            
            <?php
                } // End while
            } else {
            ?>
                <div class="col-12 text-center" style="padding: 50px;">
                    <p>Bạn chưa tạo bất kỳ Hồ sơ (CV) nào. Hãy bắt đầu tạo hồ sơ đầu tiên của bạn!</p>
                    <a href="index.php?page=user_detail_cv" class="theme-btn btn-style-one">Tạo CV Mới</a>
                </div>
            <?php
            } // End if/else
            ?>
            
        </div>
    </div>
</section>