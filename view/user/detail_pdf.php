<?php
// ... PHẦN KẾT NỐI CSDL CỦA BẠN (GIỮ NGUYÊN) ...
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$user_id = $_SESSION['id'] ?? 1; // Giả sử ID = 1 nếu chưa đăng nhập/test
$resume_id = $_GET['id'] ?? 0;

$sql_resume = "SELECT * FROM resumes WHERE user_id = ? AND resume_id = ?"; 
$stmt_resume = $conn->prepare($sql_resume);
$stmt_resume->bind_param("ii", $user_id, $resume_id);
$stmt_resume->execute();
$data_resume = $stmt_resume->get_result()->fetch_assoc();
$stmt_resume->close();

if (!$data_resume) {

    $data_resume = [
        'title' => 'Vị trí Ứng tuyển', 
        'skills' => '', 
        'summary' => 'Chưa có tóm tắt.',
        'experience' => '[]', 
        'education' => '[]'
    ];
}

// Giải mã JSON
$experience_list = json_decode($data_resume['experience'] ?? '[]', true) ?: [];
$education_list = json_decode($data_resume['education'] ?? '[]', true) ?: [];


// ==========================================================
// B. TRUY VẤN DỮ LIỆU TỪ BẢNG USERS (THÔNG TIN CÁ NHÂN)
// ==========================================================
$sql_user = "SELECT name, email, phone, address FROM users WHERE user_id = ?"; 
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id); 
$stmt_user->execute();
$data_user = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

$name = htmlspecialchars($data_user['name'] ?? 'HỌ TÊN CỦA BẠN');
$email = htmlspecialchars($data_user['email'] ?? 'email@example.com');
$phone = htmlspecialchars($data_user['phone'] ?? '000-000-0000');
$address = htmlspecialchars($data_user['address'] ?? 'Địa chỉ hiện tại');
$image_path = 'duong_dan_anh_dai_dien.jpg'; 
$title = htmlspecialchars($data_resume['title'] ?? 'VỊ TRÍ ỨNG TUYỂN');
$summary = htmlspecialchars($data_resume['summary'] ?? 'Chưa có tóm tắt.');
$skills_raw = htmlspecialchars($data_resume['skills'] ?? '');
$skills_list = array_map('trim', explode(',', $skills_raw)); 

function get_fancy_icon($type) {
    $icons = [
        'phone'    => '&#x1F4DE;', 
        'email'    => '&#x2709;',
        'location' => '&#x1F4CD;',
        'company'  => '&#x1F3E2;',
        'education'=> '&#x1F393;',
    ];
    return $icons[$type] ?? '&#x2022;';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CV: <?= $name ?></title>
    <style>
       
        body { 
            font-family: DejaVu Sans, sans-serif; 
            margin: 0; padding: 0; font-size: 10pt; color: #333; line-height: 1.4;
        }
        .cv-container { 
            width: 850px; margin: 20px auto; display: flex; box-shadow: 0 0 10px rgba(0,0,0,0.1); 
            border-radius: 5px; overflow: hidden; 
        }
        
        :root {
            --primary-color: #004d99;
            --accent-color: #007bff;
            --light-bg: #f5f5f5;
        }

       
        .sidebar { 
            flex-basis: 35%; padding: 30px 20px; box-sizing: border-box; background-color: var(--light-bg);
        }
        .profile-photo {
            width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 30px auto;
            border: 4px solid var(--primary-color);
        }
        .profile-photo img { width: 100%; height: 100%; object-fit: cover; }
        .contact-item { 
            margin-bottom: 15px; padding-left: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px;
            font-size: 10pt; color: #555; position: relative;
        }
        .contact-item span.icon { 
            position: absolute; left: 0; top: 2px; color: var(--primary-color); 
            font-size: 12pt;
        }
        .contact-label {
            display: block; font-weight: bold; color: var(--primary-color); font-size: 9pt; margin-bottom: 2px;
        }
        .sidebar .section-title { 
            font-size: 13pt; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); 
            padding-bottom: 5px; margin-top: 25px; margin-bottom: 15px; font-weight: bold; text-transform: uppercase;
        }
        .list-item { list-style: none; padding-left: 0; margin-top: 5px; }
        .list-item li { position: relative; padding-left: 15px; margin-bottom: 8px; font-size: 10pt; }
        .list-item li:before {
             content: '►'; color: var(--accent-color); font-weight: bold; position: absolute; left: 0; font-size: 8pt;
             line-height: 1.5;
        }
        
      
        .main-content { 
            flex-basis: 65%; padding: 30px 40px; box-sizing: border-box; 
        }
        .main-header { 
            background-color: var(--primary-color); 
            color: #fff;
            padding: 10px 15px;
            margin: -30px -40px 25px -40px; 
        }
        .main-header h1 { font-size: 24pt; color: #fff; margin: 0; text-transform: uppercase; }
        .main-header p { font-size: 14pt; color: #eee; margin: 0; font-weight: 300; }
        
        .main-content .section-title { 
            font-size: 15pt; color: #333; border-bottom: 2px solid #333; padding-bottom: 5px; 
            margin-top: 30px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase;
        }
        .main-content .section-title:first-of-type { margin-top: 0; }
        .job-block { margin-bottom: 30px; }
        .job-header {
            display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 5px;
        }
        .job-header h3 { 
            font-size: 11pt; font-weight: bold; color: var(--primary-color); margin: 0; text-transform: uppercase;
        }
        .job-header p.duration { font-size: 9pt; color: #777; margin: 0; }
        .job-title { 
            font-size: 10pt; font-weight: 500; color: #555; margin: 0 0 10px 0;
        }
        .job-description { list-style-type: disc; padding-left: 20px; font-size: 10pt; }
        .job-description li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="cv-container">
        
        <div class="sidebar">
            
            <div class="profile-photo">
                <img src="assets/user/images/8.png" alt="Ảnh đại diện">
            </div>

            <div class="contact-info">
                <div class="contact-item">
                    <span class="icon"><?= get_fancy_icon('phone') ?></span>
                    <span class="contact-label">Số điện thoại</span>
                    <?= $phone ?>
                </div>
                <div class="contact-item">
                    <span class="icon"><?= get_fancy_icon('email') ?></span>
                    <span class="contact-label">Email</span>
                    <a href="mailto:<?= $email ?>"><?= $email ?></a>
                </div>
                <div class="contact-item">
                    <span class="icon"><?= get_fancy_icon('location') ?></span>
                    <span class="contact-label">Địa chỉ</span>
                    <?= $address ?>
                </div>
                </div>

            <h2 class="section-title">Kỹ Năng</h2>
            <?php if (!empty($skills_list) && $skills_list[0] != ''): ?>
                <ul class="list-item">
                    <?php foreach ($skills_list as $skill): ?>
                        <li><?= htmlspecialchars($skill) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Chưa có thông tin kỹ năng.</p>
            <?php endif; ?>
        </div>

        <div class="main-content">
            
            <div class="main-header">
                <h1><?= $name ?></h1>
                <p><?= $title ?></p>
            </div>

            <h2 class="section-title">Tóm Tắt Nghề Nghiệp</h2>
            <div class="summary-block">
                <p><?= nl2br($summary) ?></p>
            </div>

            <h2 class="section-title">Kinh Nghiệm Làm Việc</h2>
            <?php if (empty($experience_list)): ?>
                <p>Chưa có thông tin kinh nghiệm làm việc.</p>
            <?php else: ?>
                <?php foreach ($experience_list as $exp): ?>
                    <div class="job-block">
                        <div class="job-header">
                            <h3><?= get_fancy_icon('company') ?> <?= htmlspecialchars($exp['company'] ?? 'Tên Công ty') ?>: Viettel</h3>
                            
                        </div>
                        
                        <ul class="job-description">
                            <li>Mô tả công việc: <?= nl2br(htmlspecialchars($exp['description'] ?? 'Mô tả công việc (Chưa cập nhật)')) ?></li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <h2 class="section-title">Học Vấn</h2>
            <?php if (empty($education_list)): ?>
                <p>Chưa có thông tin học vấn.</p>
            <?php else: ?>
                <?php foreach ($education_list as $edu): ?>
                    <div class="job-block">
                        <div class="job-header">
                            <h3><?= get_fancy_icon('education') ?> <?= htmlspecialchars($edu['school'] ?? 'Tên Trường/Đơn vị') ?></h3>
                            
                        </div>
                        
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
    </div>
</body>
</html>