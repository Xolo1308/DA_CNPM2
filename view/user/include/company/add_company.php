<?php
// Kết nối CSDL (Đã có sẵn từ đoạn code trước)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Bắt đầu session nếu chưa có
if (!session_id()) session_start(); 

// 1. Xác thực người dùng (Đã có sẵn từ đoạn code trước)
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    echo "<script>alert('Vui lòng đăng nhập bằng tài khoản doanh nghiệp!'); window.location.href='login.php';</script>";
    exit();
}

$company_id = $_SESSION['id'];
$message = '';

// Lấy thông tin hồ sơ công ty hiện tại (để điền vào form)
$sql_select = "SELECT * FROM companies WHERE company_id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $company_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$company = $result_select->fetch_assoc();
$stmt_select->close();

if (!$company) {
    // Nếu chưa có hồ sơ, chuyển hướng sang trang tạo mới (nếu bạn muốn phân biệt)
    // Hoặc giữ nguyên để form dưới đây hoạt động như form tạo mới
}


// 2. Xử lý Form Gửi đi (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $website = $_POST['website'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $logo_file_name = $company['logo']; // Giữ logo cũ mặc định

    // Xử lý tải lên Logo mới
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $target_dir = "uploads/logo/";
        // Đảm bảo thư mục tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Tạo tên file duy nhất (ID công ty + timestamp)
        $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $new_file_name = $company_id . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $new_file_name;

        // Kiểm tra loại file và kích thước (Tùy chọn)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $message = '<div class="alert alert-danger">❌ Chỉ chấp nhận file JPG, JPEG & PNG.</div>';
        } elseif ($_FILES['logo']['size'] > 500000) { // 500KB
            $message = '<div class="alert alert-danger">❌ Kích thước file quá lớn (tối đa 500KB).</div>';
        } else {
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                $logo_file_name = $new_file_name;
                
                // Xóa logo cũ (Tùy chọn)
                if ($company['logo'] && $company['logo'] != 'default.png' && file_exists($target_dir . $company['logo'])) {
                     unlink($target_dir . $company['logo']);
                }
            } else {
                $message = '<div class="alert alert-danger">❌ Lỗi khi di chuyển file.</div>';
            }
        }
    }

    // 3. Cập nhật cơ sở dữ liệu (Sử dụng Prepared Statement)
    if (empty($message)) { // Chỉ cập nhật nếu không có lỗi file
        $sql_update = "
            UPDATE companies 
            SET 
                name = ?, 
                address = ?, 
                website = ?, 
                phone = ?, 
                description = ?, 
                logo = ?
            WHERE company_id = ?
        ";

        $stmt_update = $conn->prepare($sql_update);
        // Chuỗi tham số: ssssssi (string, string, string, string, string, string, integer)
        $stmt_update->bind_param(
            "ssssssi", 
            $name, 
            $address, 
            $website, 
            $phone, 
            $description, 
            $logo_file_name,
            $company_id
        );

        if ($stmt_update->execute()) {
            $message = '<div class="alert alert-success">✅ Cập nhật hồ sơ thành công!</div>';
            
            // Cập nhật lại biến $company để form hiển thị dữ liệu mới
            $company['name'] = $name;
            $company['address'] = $address;
            $company['website'] = $website;
            $company['phone'] = $phone;
            $company['description'] = $description;
            $company['logo'] = $logo_file_name;

        } else {
            $message = '<div class="alert alert-danger">❌ Lỗi khi cập nhật: ' . $conn->error . '</div>';
        }
        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật hồ sơ doanh nghiệp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-primary">✏️ Cập nhật hồ sơ doanh nghiệp</h2>

    <?= $message ?> <form method="POST" action="" enctype="multipart/form-data">

        <div class="mb-3 text-center">
            <label class="form-label">Logo hiện tại:</label><br>
            <img src="uploads/logo/<?php echo htmlspecialchars($company['logo'] ?: 'default.png'); ?>" 
                 style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #007bff;">
        </div>
        
        <div class="mb-3">
            <label for="logo" class="form-label">Chọn Logo mới:</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg">
            <small class="form-text text-muted">Chỉ chấp nhận file JPG, PNG. Kích thước tối đa 500KB.</small>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Tên công ty:</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($company['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ:</label>
            <input type="text" class="form-control" id="address" name="address" 
                   value="<?= htmlspecialchars($company['address'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website:</label>
            <input type="url" class="form-control" id="website" name="website" 
                   value="<?= htmlspecialchars($company['website'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại:</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                   value="<?= htmlspecialchars($company['phone'] ?? '') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email (Không thể sửa tại đây):</label>
            <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($company['email'] ?? '') ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả về công ty:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Lưu Cập Nhật</button>
            <a href="index.php?page=tt_list_company" class="btn btn-secondary">Hủy và Quay lại</a>
        </div>
    </form>
</div>
<?php 
$conn->close();
?>
</body>
</html>