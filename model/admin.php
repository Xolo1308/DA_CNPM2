<?php
function check_admin_login($username, $password) {
    global $conn; // dùng kết nối từ file kn_data.php

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}
?>
