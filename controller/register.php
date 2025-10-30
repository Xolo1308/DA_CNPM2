<?php
include 'kn_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"];
    // Dùng hash cho mật khẩu (BEST PRACTICE)
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); 
    
    $password = $_POST["password"]; 
    $email = $_POST["email"];
    $role = $_POST["role"]; // 0=user, 1=company

    if (!isset($_POST["agree"])) {
        echo "<script>alert('Bạn phải đồng ý với Điều khoản dịch vụ trước khi đăng ký!'); window.history.back();</script>";
        exit;
    }

    $check_sql = "
        (SELECT email FROM users WHERE email=?)
        UNION ALL
        (SELECT email FROM companies WHERE email=?)
    ";
    
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("ss", $email, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại trong hệ thống!'); window.history.back();</script>";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();
    
    
    if ($role == 0) {
  
        $insert_sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssi", $name, $email, $password, $role);

    } elseif ($role == 1) {

        $insert_sql = "INSERT INTO companies (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssi", $name, $email, $password, $role);
        
    } else {
        echo "<script>alert('Role không hợp lệ.'); window.history.back();</script>";
        exit;
    }

    // 5. Thực thi lệnh INSERT
    if ($stmt->execute()) {
        echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location='../view/user/login.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>