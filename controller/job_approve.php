<?php
session_start();
include 'kn_data.php';

$job_id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

$new_status = null;
if ($action == 'approve') {
    $new_status = 'approved';
} elseif ($action == 'reject') {
    $new_status = 'rejected';
}

if ($job_id && $new_status) {
    // Sử dụng Prepared Statement để ngăn chặn SQL Injection
    $sql = "UPDATE jobs SET status = ? WHERE job_id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("si", $new_status, $job_id);

    if ($stmt->execute()) {
        $message = ($new_status == 'approved') ? "Duyệt tin tuyển dụng thành công!" : "Đã từ chối tin tuyển dụng.";
        echo "<script>alert('$message'); window.location.href='../view/admin/ql_dtin.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật CSDL: " . $stmt->error . "'); window.location.href='.../view/admin/ql_dtin.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Hành động không hợp lệ.'); window.location.href='../view/admin/job_approval_list.php';</script>";
}

$conn->close();
?>