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


if (!isset($_GET['id'])) {
    echo "<script>alert('Thiếu ID tin cần xóa!'); window.location='index.php?page=job_list_company';</script>";
    exit;
}

$job_id = (int)$_GET['id'];

// Kiểm tra tin tồn tại
$sql = "SELECT title FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

if (!$job) {
    echo "<script>alert('Không tìm thấy tin tuyển dụng này!'); window.location='index.php?page=job_list_company';</script>";
    exit;
}

// Nếu xác nhận xóa
if (isset($_POST['confirm_delete'])) {
    $sql_delete = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();

    echo "<script>alert('Đã xóa tin tuyển dụng thành công!'); window.location='index.php?page=job_list_company';</script>";
    exit;
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <div class="card shadow p-4 border-danger">
        <h3 class="text-center text-danger mb-3">Xác nhận xóa tin tuyển dụng</h3>
        <p class="text-center fs-5">
            Bạn có chắc chắn muốn xóa tin:
            <strong class="text-primary">"<?= htmlspecialchars($job['title']) ?>"</strong>?
        </p>

        <form method="POST" class="text-center mt-4">
            <button type="submit" name="confirm_delete" class="btn btn-danger px-4">
                 Xóa ngay
            </button>
            <a href="index.php?page=job_list_company" class="btn btn-secondary px-4 ms-2">
                 Quay lại
            </a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
