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


// 1. Kiểm tra đăng nhập và Role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='../view/user/login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $company_id = $_SESSION['id']; 
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $deadline = $_POST['deadline'];
    
    $status = 'pending'; 

    $sql = "INSERT INTO jobs (company_id, title, description, requirements, salary, location, deadline, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("isssssss", $company_id, $title, $description, $requirements, $salary, $location, $deadline, $status);

    // 4. Thực thi
    if ($stmt->execute()) {
        echo "<script>alert('Đăng tin tuyển dụng thành công! Vui lòng chờ duyệt.')</script>";
    } else {
        echo "<script>alert('Lỗi đăng tin: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!-- ✅ Giao diện đẹp bằng Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <div class="card shadow-lg p-4 border-0 rounded-4">
        <h3 class="text-center text-primary mb-4 fw-bold">
            🆕 Đăng tin tuyển dụng mới
        </h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Tiêu đề công việc</label>
                <input type="text" name="title" class="form-control" required placeholder="VD: Nhân viên Marketing">
            </div>
           
            <div class="mb-3">
                <label class="form-label fw-semibold">Yêu cầu công việc</label>
                <input type="text" name="requirements" class="form-control" required placeholder="VD: Kinh nghiệm 1 năm">
            </div>
            

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Địa điểm</label>
                    <input type="text" name="location" class="form-control" placeholder="VD: Hà Nội">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Mức lương</label>
                    <input type="text" name="salary" class="form-control" placeholder="VD: 15–20 triệu">
                </div>
                 <div class="mb-3">
                    <label class="form-label fw-semibold">vị trí công việc</label>
                    <textarea name="location" class="form-control" placeholder="Vị trí công việc"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Thời gian</label>
                    <textarea name="deadline" class="form-control" placeholder="Thời gian tuyển dụng"></textarea>
                </div>
            </div>  
            <div class="mb-3">
                <label class="form-label fw-semibold">Yêu cầu ứng viên</label>
                <textarea name="requirements" class="form-control" rows="3" placeholder="Yêu cầu kỹ năng, kinh nghiệm..."></textarea>
            </div>         

            <div class="mb-3">
                <label class="form-label fw-semibold">Mô tả công việc</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết công việc..."></textarea>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-5 py-2 fw-bold">
                    <i class="bi bi-send"></i> Đăng tin
                </button>
                <a href="index.php?page=job_list_company" class="btn btn-secondary px-5 py-2 fw-bold">Hủy</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
