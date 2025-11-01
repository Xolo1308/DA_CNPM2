<?php
// BẢO ĐẢM SESSION ĐƯỢC BẬT
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  
    header('Location: index.php?page=error&msg=database_error');
    exit; 
}

$current_user_id = $_SESSION['id'] ?? 0; 

$resume_id = $_GET['id'] ?? 0; 

if ($current_user_id === 0) {
    $_SESSION['error_message'] = "Vui lòng đăng nhập để thực hiện hành động này.";
    header('Location: index.php?page=login');
    exit;
}

if ($resume_id === 0 || !is_numeric($resume_id)) {
    $_SESSION['error_message'] = "ID CV không hợp lệ.";
    header('Location: index.php?page=user_list_cv'); // Quay về trang danh sách
    exit;
}

$sql_delete = "DELETE FROM resumes WHERE resume_id = ? AND user_id = ?"; 
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $resume_id, $current_user_id); 

if ($stmt_delete->execute()) {
   
    if ($stmt_delete->affected_rows > 0) {
        $_SESSION['success_message'] = "CV đã được xóa thành công.";
    } else {
        
        $_SESSION['error_message'] = "Không tìm thấy CV để xóa hoặc bạn không có quyền xóa CV này.";
    }
} else {

    $_SESSION['error_message'] = "Đã xảy ra lỗi trong quá trình xóa CV: " . $stmt_delete->error;
}

$stmt_delete->close();
$conn->close();


header('Location: index.php?page=user_list_pdf');
exit;
?>