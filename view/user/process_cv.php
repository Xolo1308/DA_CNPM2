<?php
// PHẦN KẾT NỐI CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

// Bắt đầu Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['id'] ?? 0;

if ($user_id == 0) {
    // Chuyển hướng nếu người dùng chưa đăng nhập
    header("Location: login.php");
    exit();
}

// Kiểm tra xem dữ liệu có được gửi bằng phương thức POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. LẤY DỮ LIỆU CƠ BẢN VÀ LÀM SẠCH (Sanitization)
    $resume_id = $_POST['resume_id'] ?? null;
    $action = $_POST['action'] ?? 'save'; // Mặc định là lưu bản nháp

    $cv_title = $conn->real_escape_string($_POST['cv_title'] ?? 'CV Không Tiêu Đề');
    $template_used = $conn->real_escape_string($_POST['template_used'] ?? 'basic_01');
    $summary = $conn->real_escape_string($_POST['summary'] ?? '');
    $skills = $conn->real_escape_string($_POST['skills'] ?? '');

    // Thông tin cá nhân (Chúng ta sẽ KHÔNG UPDATE bảng users ở đây, chỉ lấy để chuẩn bị cho bước Export nếu cần)
    $user_name = $conn->real_escape_string($_POST['name'] ?? '');
    $user_email = $conn->real_escape_string($_POST['email'] ?? '');
    $user_phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $user_address = $conn->real_escape_string($_POST['address'] ?? '');

    // 2. CHUYỂN DỮ LIỆU LẶP LẠI THÀNH JSON
// PHIÊN BẢN NÀY DÀNH CHO TRƯỜNG HỢP FORM CHỈ GỬI LÊN MỘT MẢNG CÁC CHUỖI ĐƠN (Ví dụ: education[0] = "Đại học A", experience[1] = "Mô tả công việc B")

// a) Xử lý Kinh nghiệm (experience) - CHỈ GIỮ LẠI CỘT 'description'
$experience_data = $_POST['experience'] ?? [];
$clean_experience = [];

// Lặp qua mảng đa chiều
foreach ($experience_data as $entry) {
    // Chúng ta chỉ quan tâm đến cột 'description'
    $description = $entry['description'] ?? '';
    
    // Kiểm tra nếu cột 'description' (thành tích) không rỗng
    if (!empty(trim($description))) {
        // Lưu dữ liệu dưới dạng mảng key/value để giữ cấu trúc
        $clean_experience[] = ['description' => $description];
    }
}

$experience_json = $conn->real_escape_string(json_encode(array_values($clean_experience)));

// b) Xử lý Học vấn (education) - CHỈ GIỮ LẠI CỘT 'school'
$education_data = $_POST['education'] ?? [];
$clean_education = [];

// Lặp qua mảng đa chiều
foreach ($education_data as $entry) {
    // Chúng ta chỉ quan tâm đến cột 'school'
    $school = $entry['school'] ?? '';
    
    // Kiểm tra nếu cột 'school' (tên trường) không rỗng
    if (!empty(trim($school))) {
        // Lưu dữ liệu dưới dạng mảng key/value để giữ cấu trúc
        $clean_education[] = ['school' => $school];
    }
}

$education_json = $conn->real_escape_string(json_encode(array_values($clean_education)));
   
if ($resume_id) {
        // CẬP NHẬT (UPDATE) CV ĐÃ TỒN TẠI
        $sql = "UPDATE resumes SET 
                    title = '$cv_title',
                    summary = '$summary',
                    skills = '$skills',
                    experience = '$experience_json',
                    education = '$education_json',
                    template_used = '$template_used',
                    updated_at = NOW()
                WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
        
        $success_message = "Cập nhật CV thành công!";
        $fail_message = "Lỗi khi cập nhật CV: " . $conn->error;

    } else {
        // LƯU MỚI (INSERT)
        $sql = "INSERT INTO resumes (user_id, title, summary, skills, experience, education, template_used, created_at, updated_at)
                VALUES (
                    '$user_id',
                    '$cv_title',
                    '$summary',
                    '$skills',
                    '$experience_json',
                    '$education_json',
                    '$template_used',
                    NOW(),
                    NOW()
                )";
        
        $success_message = "Lưu CV mới thành công!";
        $fail_message = "Lỗi khi lưu CV mới: " . $conn->error;
    }

    if ($conn->query($sql) === TRUE) {
        // Nếu là INSERT, lấy ID mới để dùng cho việc chuyển hướng sau này
        if (!$resume_id) {
            $resume_id = $conn->insert_id;
        }

        if ($action == 'save') {

            $_SESSION['message'] = $success_message;
            header("Location: index.php?page=user_detail_cv&id=$resume_id");
            exit();
        } elseif ($action == 'export') {

            header("Location: index.php?page=user_process_pdf&id=$resume_id"); 
            exit();
        }
        
    } else {
        // Xử lý lỗi
        $_SESSION['error'] = $fail_message;

        header("Location: index.php"); 
        exit();
    }

} else {

    header("Location: index.php?page=user_detail_cv");
    exit();
}
$conn->close();
?>