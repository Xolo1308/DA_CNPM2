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
// ... Đảm bảo $_SESSION['user_id'] đã được đặt sau khi đăng nhập ...

$user_id = $_SESSION['id'] ?? 0; // Lấy ID người dùng hiện tại
// Hoặc, nếu bạn đang lấy CV theo ID CV: $resume_id = $_GET['cv_id'] ?? 0;

// Sử dụng user_id để truy vấn
$sql = "SELECT * FROM resumes WHERE user_id = ?"; 
$stmt = $conn->prepare($sql);

// Giả sử $user_id là một số nguyên (integer - 'i')
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();
$data_from_db = $result->fetch_assoc();
$stmt->close();

// Kiểm tra xem có dữ liệu CV hay không
if (!$data_from_db) {
    die("Không tìm thấy dữ liệu CV cho ID: " . $resume_id);
}

$experience_list = json_decode($data_from_db['experience'] ?? '[]', true) ?: [];
$education_list = json_decode($data_from_db['education'] ?? '[]', true) ?: [];


$fullname = htmlspecialchars($data_from_db['fullname'] ?? 'Chưa cập nhật');
$title = htmlspecialchars($data_from_db['title'] ?? 'Chưa cập nhật');
$phone = htmlspecialchars($data_from_db['phone'] ?? 'Chưa cập nhật');
$email = htmlspecialchars($data_from_db['email'] ?? 'Chưa cập nhật');
$address = htmlspecialchars($data_from_db['address'] ?? 'Chưa cập nhật');
$summary = htmlspecialchars($data_from_db['summary'] ?? 'Chưa cập nhật');
// Thêm bất kỳ trường nào khác ở đây: $skill = htmlspecialchars($data_from_db['skill'] ?? '');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Của <?= $fullname ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ... CSS đã cung cấp ở phản hồi trước ... */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .cv-container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .cv-header h1 { color: #007bff; margin-bottom: 0; }
        .cv-header h2 { color: #6c757d; font-size: 1.2rem; margin-top: 5px; }
        .contact-info p { margin-bottom: 5px; font-size: 0.95rem; }
        .cv-section { margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .cv-section h3 { color: #343a40; border-left: 5px solid #007bff; padding-left: 10px; font-size: 1.5rem; }
        .cv-item { margin-bottom: 15px; }
        .cv-item strong { display: block; margin-bottom: 5px; color: #007bff; }
    </style>
</head>
<body>

<div class="cv-container">
    
    <div class="cv-header text-center pb-3">
       
        <h2><?= $title ?></h2>
        <div class="contact-info mt-3 row justify-content-center">
            <p class="col-auto"><i class="fas fa-phone me-2 text-primary"></i> <?= $phone ?></p>
            <p class="col-auto"><i class="fas fa-envelope me-2 text-primary"></i> <?= $email ?></p>
            <p class="col-12"><i class="fas fa-map-marker-alt me-2 text-primary"></i> <?= $address ?></p>
        </div>
    </div>

    <hr class="my-4">

    <section class="cv-section">
        <h3><i class="fas fa-user-tie me-2"></i> TÓM TẮT</h3>
        <p><?= nl2br($summary) ?></p>
    </section>

    <section class="cv-section">
        <h3><i class="fas fa-briefcase me-2"></i> KINH NGHIỆM LÀM VIỆC</h3>
        <?php 
        if (!empty($experience_list)):
            foreach ($experience_list as $exp): 
        ?>
        <div class="cv-item">
            <p class="mb-1"><?= nl2br(htmlspecialchars($exp['description'] ?? '')) ?></p>
        </div>
        <?php 
            endforeach;
        else: 
        ?>
            <div class="cv-item text-muted">Không có kinh nghiệm làm việc nào được liệt kê.</div>
        <?php endif; ?>
    </section>

    <section class="cv-section">
        <h3><i class="fas fa-graduation-cap me-2"></i> HỌC VẤN</h3>
        <?php 
        if (!empty($education_list)):
            foreach ($education_list as $edu): 
        ?>
        <div class="cv-item">
            <strong>Tên Trường:</strong>
            <p class="mb-1"><?= htmlspecialchars($edu['school'] ?? '') ?></p>
        </div>
        <?php 
            endforeach;
        else: 
        ?>
            <div class="cv-item text-muted">Không có thông tin học vấn.</div>
        <?php endif; ?>
    </section>
    
    <?php
    // Giả sử cột 'skills' cũng là một trường đơn lẻ trong bảng
    $skills = htmlspecialchars($data_from_db['skills'] ?? '');
    if (!empty($skills)):
    ?>
    <section class="cv-section">
        <h3><i class="fas fa-tools me-2"></i> KỸ NĂNG</h3>
        <p><?= nl2br($skills) ?></p>
    </section>
    <?php endif; ?>

    <div class="text-center mt-4 pt-3 border-top">
        <p class="text-muted small">Tạo bởi Ứng dụng Quản lý CV</p>
    </div>
</div>

</body>
</html>