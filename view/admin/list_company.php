<?php
include('include/main.php'); 
include('include/sidebar.php'); 
include('include/header.php'); 
include('../../controller/kn_data.php'); // Kết nối CSDL

// Lấy danh sách tài khoản
$sql = "
        (SELECT company_id AS id, name AS name, email, password, role FROM companies )";
$result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row"> 
           <div id="page-wrapper" class="gray-bg">
    <div class="wrapper wrapper-content">
        <div class="container mt-4">
            <h2 class="mb-3">📋 Quản lý tài khoản</h2>
            <a href="add_user.php" class="btn btn-primary mb-3">+ Thêm tài khoản</a>

            <table class="table table-hover table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Mật khẩu</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['password'] ?></td>
                            <td class="text-center">
                                <?php
                                   
                                    if ($row['role'] == 1) echo '<span class="badge bg-success">Công ty</span>';
                                  
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="update_company.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="../../controller/controller_user.php?delete=<?= $row['id'] ?>"
                                   onclick="return confirm('Xác nhận xoá tài khoản này?')"
                                   class="btn btn-danger btn-sm">Xoá</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>      


