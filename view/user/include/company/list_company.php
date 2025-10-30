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

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    echo "<script>alert(' Vui lòng đăng nhập bằng tài khoản doanh nghiệp!'); window.location.href='login.php';</script>";
    exit();
}

$company_id = $_SESSION['id'];

// Lấy thông tin hồ sơ công ty
$sql = "SELECT * FROM companies WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ doanh nghiệp</title>
    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .info-row { margin: 15px 0; }
        label { font-weight: bold; display: inline-block; width: 150px; color: #555; }
        .logo {
            width: 100px; height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
        .actions {
            text-align: center;
            margin-top: 25px;
        }
        .btn {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px;
        }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #555; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #1e7e34; }
    </style>
</head>
<body>
<div class="container">
    <h2>👔 Hồ sơ doanh nghiệp</h2>

    <?php if ($company): ?>
        <div class="info-row"><img src="uploads/logo/<?php echo htmlspecialchars($company['logo'] ?: 'default.png'); ?>" class="logo"></div>
        <div class="info-row"><label>Tên công ty:</label> <?php echo htmlspecialchars($company['name']); ?></div>
        <div class="info-row"><label>Địa chỉ:</label> <?php echo htmlspecialchars($company['address']); ?></div>
        <div class="info-row"><label>Website:</label> 
            <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank"><?php echo htmlspecialchars($company['website']); ?></a>
        </div>
        <div class="info-row"><label>Số điện thoại:</label> <?php echo htmlspecialchars($company['phone']); ?></div>
        <div class="info-row"><label>Email:</label> <?php echo htmlspecialchars($company['email']); ?></div>
        <div class="info-row"><label>Mô tả:</label> <?php echo nl2br(htmlspecialchars($company['description'])); ?></div>

        <div class="actions">
            <a href="index.php?page=tt_add_company" class="btn"> Cập nhật hồ sơ</a>
            <a href="public_company.php?id=<?php echo $company_id; ?>" class="btn btn-secondary"> Xem hồ sơ ứng viên </a>
        </div>
    <?php else: ?>
        <div style="text-align:center; margin-top:40px;">
            <p> Bạn chưa có hồ sơ doanh nghiệp.</p>
            <a href="index.php?page=tt_add_company" class="btn btn-success">➕ Tạo hồ sơ công ty</a>
        </div>
    <?php endif; ?>
     <div class="text-center mt-3">
        <a href="index.php?page=company_home" class="btn btn-secondary">⬅️ Quay lại hồ sơ</a>
    </div>
</div>
</body>
</html>
