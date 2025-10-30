<?php
session_start();
include 'kn_data.php';
include '../model/admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (check_admin_login($username, $password)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../view/admin/index.php");
        exit();
    } else {    
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='../index.php?page=admin';</script>";
    }
}
?>
