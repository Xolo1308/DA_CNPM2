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
 
    if (!session_id()) session_start();
    echo "<script>alert('Vui lòng đăng nhập bằng tài khoản doanh nghiệp!'); window.location.href='login.php';</script>";
    exit();
}

$company_id = $_SESSION['id']; // Lấy ID công ty từ session

$sql = "
    SELECT 
        jobs.*, companies.name  -- Lấy tên công ty (đã được sửa thành cột 'name')
    FROM jobs
    INNER JOIN companies ON jobs.company_id = companies.company_id
    WHERE jobs.company_id = ?
    ORDER BY jobs.created_at DESC
";
$stmt = $conn->prepare($sql);

// company_id là Integer (i)
$stmt->bind_param("i", $company_id); 
$stmt->execute();
$result = $stmt->get_result();

$i = 1; 

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">📋 Danh sách tin tuyển dụng</h3>
        <a href="index.php?page=add_job_company" class="btn btn-success">+ Đăng tin mới</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Tên công ty</th>
                <th>Tiêu đề</th>
                <th>Miêu tả</th>   
                 <th>Yêu cầu</th>   
                <th>Lương</th>
                 <th>Vị trí</th>
                 <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th width="160">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td> 
                       <td><?= htmlspecialchars($row['title']) ?></td> 
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['requirements']) ?></td>
                    <td><?= htmlspecialchars($row['salary']) ?></td>
                     <td><?= htmlspecialchars($row['location']) ?></td>
                     <td><?= htmlspecialchars($row['deadline']) ?></td>
                      
                    <td>
                        <?php
                        // Đảm bảo không có lỗi nếu cột 'status' không tồn tại
                        $status = $row['status'] ?? 'unknown'; 
                        $color_map = [
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger'
                        ];
                        $color = $color_map[$status] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?= $color ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </td>
                    <td><?= date("d/m/Y H:i", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="index.php?page=edit_job_company&id=<?= $row['job_id'] ?>" class="btn btn-sm btn-primary">
                            Sửa
                        </a>
                        <a href="index.php?page=delete_job_company&id=<?= $row['job_id'] ?>" 
                            class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này?');">
                            Xóa
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Chưa có tin tuyển dụng nào được đăng.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="index.php?page=company_home" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<?php 
// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>