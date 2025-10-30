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


// 1. Xác thực người dùng (giống như trang danh sách)
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    echo "<script>alert('Vui lòng đăng nhập bằng tài khoản doanh nghiệp!'); window.location.href='login.php';</script>";
    exit();
}

$company_id = $_SESSION['id']; // ID công ty từ session

// 2. Lấy job_id từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID công việc không hợp lệ!'); window.location.href='index.php?page=list_jobs_company';</script>";
    exit();
}

$job_id = (int)$_GET['id'];
$job_data = null; // Biến để lưu dữ liệu công việc

// 3. Truy vấn dữ liệu công việc hiện tại VÀ kiểm tra quyền sở hữu
$sql_select = "
    SELECT * FROM jobs 
    WHERE job_id = ? AND company_id = ?
";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("ii", $job_id, $company_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();

if ($result_select->num_rows === 0) {
    echo "<script>alert('Không tìm thấy tin tuyển dụng hoặc bạn không có quyền chỉnh sửa!'); window.location.href='index.php?page=list_jobs_company';</script>";
    exit();
}

$job_data = $result_select->fetch_assoc();
$stmt_select->close();

// Biến để lưu thông báo (thành công/lỗi)
$message = '';

// 4. Xử lý Form Gửi đi (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $deadline = $_POST['deadline'];
    // Lấy status nếu bạn cho phép sửa nó, hoặc để mặc định là 'pending' nếu cần phê duyệt lại
    // $status = 'pending'; // Có thể cần đặt lại trạng thái chờ duyệt sau khi sửa

    // Cập nhật cơ sở dữ liệu
    $sql_update = "
        UPDATE jobs 
        SET 
            title = ?, 
            description = ?, 
            requirements = ?, 
            salary = ?, 
            location = ?, 
            deadline = ?
          
        WHERE job_id = ? AND company_id = ?
    ";

    $stmt_update = $conn->prepare($sql_update);
    // Chuỗi tham số: ssssssii (string, string, string, string, string, string, integer, integer)
    $stmt_update->bind_param(
        "ssssssii", 
        $title, 
        $description, 
        $requirements, 
        $salary, 
        $location, 
        $deadline,
        $job_id, 
        $company_id
    );

    if ($stmt_update->execute()) {
        $message = '<div class="alert alert-success">✅ Cập nhật tin tuyển dụng thành công!</div>';
        
        // Cập nhật lại $job_data với dữ liệu mới để hiển thị trong form
        $job_data['title'] = $title;
        $job_data['description'] = $description;
        $job_data['requirements'] = $requirements;
        $job_data['salary'] = $salary;
        $job_data['location'] = $location;
        $job_data['deadline'] = $deadline;

    } else {
        $message = '<div class="alert alert-danger"> Lỗi khi cập nhật: ' . $conn->error . '</div>';
    }

    $stmt_update->close();
}

// $conn->close(); // CHƯA đóng kết nối ở đây, sẽ đóng ở cuối file HTML.
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">📝 Chỉnh sửa tin tuyển dụng</h3>
    </div>

    <?= $message ?> <form method="POST" action="">
        <input type="hidden" name="job_id" value="<?= $job_data['job_id'] ?>"> 
        
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề công việc:</label>
            <input type="text" class="form-control" id="title" name="title" 
                   value="<?= htmlspecialchars($job_data['title'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Miêu tả công việc:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>
                <?= htmlspecialchars($job_data['description'] ?? '') ?>
            </textarea>
        </div>
        
        <div class="mb-3">
            <label for="requirements" class="form-label">Yêu cầu:</label>
            <textarea class="form-control" id="requirements" name="requirements" rows="3" required>
                <?= htmlspecialchars($job_data['requirements'] ?? '') ?>
            </textarea>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Mức lương:</label>
            <input type="text" class="form-control" id="salary" name="salary" 
                   value="<?= htmlspecialchars($job_data['salary'] ?? '') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="location" class="form-label">Vị trí làm việc:</label>
            <input type="text" class="form-control" id="location" name="location" 
                   value="<?= htmlspecialchars($job_data['location'] ?? '') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="deadline" class="form-label">Thời hạn nộp hồ sơ (YYYY-MM-DD):</label>
            <input type="date" class="form-control" id="deadline" name="deadline" 
                   value="<?= htmlspecialchars($job_data['deadline'] ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary me-2">Lưu Thay Đổi</button>
        <a href="index.php?page=job_list_company" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php 
// Đóng kết nối DB ở cuối file
$conn->close();
?>