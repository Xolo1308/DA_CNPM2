<?php
session_start();
include 'kn_data.php';

// =================== 1. THÊM TÀI KHOẢN (CREATE) ===================
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = (int)$_POST['role'];

    $check_sql = "(SELECT email FROM users WHERE email=?) UNION ALL (SELECT email FROM companies WHERE email=?)";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("ss", $email, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại!'); window.history.back();</script>";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    if ($role == 0) {

        $insert_sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssi", $name, $email, $password, $role); // sssis: String, String, Integer (role), String, Integer (phone/address)

    } elseif ($role == 1) {

        $insert_sql = "INSERT INTO companies (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssi", $name, $email, $password, $role);
    }
    
    if (isset($stmt) && $stmt->execute()) {
        $stmt->close();
        header("Location: ../view/admin/list_tk.php?msg=add");
    } else {
        echo "Lỗi: " . $stmt->error;
    }
    exit();
}




// =================== 3. XÓA TÀI KHOẢN (DELETE) ===================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $role = intval($_GET['role']); 


    if ($role == 0) {
        $sql = "DELETE FROM users WHERE user_id=?";
    } elseif ($role == 1) {
        $sql = "DELETE FROM companies WHERE company_id=?";
    }
    
    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
             $stmt->close();
             header("Location: ../view/admin/list_tk.php?msg=deleted");
        } else {
             echo "Lỗi: " . $stmt->error;
        }
    }
    exit();
}

$conn->close();
?>