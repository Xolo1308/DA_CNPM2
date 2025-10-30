<?php
// Bao gồm các file cần thiết (Header, Sidebar, và KẾT NỐI CSDL)
include('include/main.php'); 
include('include/sidebar.php'); 
include('include/header.php'); 
include('../../controller/kn_data.php'); // Kết nối CSDL (sử dụng $conn)

// Khai báo biến
$user_data = null;
$message = '';

// 1. Lấy ID tài khoản từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tài khoản không hợp lệ!'); window.location.href='list_users.php';</script>";
    exit();
}

$id = (int)$_GET['id'];

// 2. Lấy dữ liệu tài khoản hiện tại
// Do bạn chỉ hiển thị tài khoản CÔNG TY trong danh sách, ta chỉ SELECT từ bảng 'companies'
$sql_select = "
    SELECT user_id, name, email, password, role 
    FROM users 
    WHERE user_id = ?
";
$stmt_select = mysqli_prepare($conn, $sql_select);
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result_select = mysqli_stmt_get_result($stmt_select);

if (mysqli_num_rows($result_select) === 0) {
    echo "<script>alert('Không tìm thấy tài khoản người dùng!'); window.location.href='list_users.php';</script>";
    exit();
}
$user_data = mysqli_fetch_assoc($result_select);
mysqli_stmt_close($stmt_select);


// 3. Xử lý Form Gửi đi (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password']; // Cẩn thận với việc cập nhật mật khẩu TRỰC TIẾP (không hash)

    // Cập nhật cơ sở dữ liệu
    $sql_update = "
        UPDATE users
        SET 
            name = ?, 
            email = ?, 
            password = ? 
        WHERE user_id = ?
    ";

    $stmt_update = mysqli_prepare($conn, $sql_update);
    // Chuỗi tham số: sssi (string, string, string, integer)
    mysqli_stmt_bind_param(
        $stmt_update, 
        "sssi", 
        $new_name, 
        $new_email, 
        $new_password, 
        $id
    );

    if (mysqli_stmt_execute($stmt_update)) {
        $message = '<div class="alert alert-success">✅ Cập nhật tài khoản thành công!</div>';
        
        // Cập nhật lại $user_data để hiển thị thông tin mới trong form
        $user_data['name'] = $new_name;
        $user_data['email'] = $new_email;
        $user_data['password'] = $new_password; 

    } else {
        $message = '<div class="alert alert-danger">❌ Lỗi khi cập nhật: ' . mysqli_error($conn) . '</div>';
    }

    mysqli_stmt_close($stmt_update);
}
?>

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row"> 
           <div id="page-wrapper" class="gray-bg">
    <div class="wrapper wrapper-content">
        <div class="container mt-4">
            <h2 class="mb-3">📝 Chỉnh sửa tài khoản người  (ID: <?= $user_data['user_id'] ?>)</h2>
            
            <?= $message ?> <form method="POST" action="">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên:</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= htmlspecialchars($user_data['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($user_data['email']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu:</label>
                    <input type="text" class="form-control" id="password" name="password" 
                           value="<?= htmlspecialchars($user_data['password']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary me-2">Lưu Thay Đổi</button>
                <a href="list_tk.php" class="btn btn-secondary">Quay lại danh sách</a>
            </form>
        </div>
    </div>
</div>