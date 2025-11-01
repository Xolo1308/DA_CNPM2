<?php
session_start();
include 'kn_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Lấy dữ liệu POST
    $email = $_POST["email"];
    $password = $_POST["password"];


    $sql = "
        (SELECT user_id AS id, name AS name, email, password, role FROM users WHERE email=? AND password=?)
        UNION ALL
        (SELECT company_id AS id, name AS name, email, password, role FROM companies WHERE email=? AND password=?)
    ";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssss", $email, $password, $email, $password); 
    
    // 4. Thực thi
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["name"] = $user["name"]; 
        $_SESSION["phone"] = $phone["phone"];
         $_SESSION["address"] = $addess[""];

        $_SESSION["role"] = $user["role"]; 

        // 6. Chuyển hướng theo role
        if ($user["role"] == 0) {
            header("Location: ../index.php?page=home");
        } elseif ($user["role"] == 1) {
            header("Location: ../index.php?page=company_home");
        }
        exit;
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu'); window.history.back();</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>