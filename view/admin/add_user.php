<?php
include('include/main.php'); 
include('include/header.php');
include('include/sidebar.php');

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row"> 
           <div id="page-wrapper" class="gray-bg">
          <div class="container mt-4">
    <h2>➕ Thêm tài khoản mới</h2>
    <form action="../../controller/Controller_user.php" method="POST" class="mt-3">
        
        <div class="mb-3">
            <label>Tên đăng nhập:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Vai trò:</label>
            <select name="role" class="form-select">
                <option value="0">Người dùng</option>
                <option value="1">Công ty</option>
            
            </select>
        </div>
        <button type="submit" name="add_user" class="btn btn-success">Lưu</button>
        <a href="list_tk.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</div>  






