<?php
require 'vendor/autoload.php'; // Nếu dùng Composer
use Dompdf\Dompdf;


$dompdf = new Dompdf();

$conn = new mysqli("localhost", "root", "", "job_portal"); 
if ($conn->connect_error) { die("Kết nối thất bại"); }

$resume_id = $_GET['id'] ?? die("Không tìm thấy ID CV.");

// Lấy toàn bộ dữ liệu CV và User liên quan
$sql = "SELECT r.*, u.name, u.email, u.phone, u.address 
        FROM resumes r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.resume_id = '$resume_id'";

$result = $conn->query($sql);
if ($result->num_rows == 0) { die("CV không tồn tại."); }

$data = $result->fetch_assoc();
$template_key = $data['template_used'];

// Chuẩn bị dữ liệu JSON thành mảng PHP
$data['experience'] = json_decode($data['experience'], true) ?: [];
$data['education'] = json_decode($data['education'], true) ?: [];


// PHẦN TẠO HTML NỘI DUNG CV DỰA TRÊN TEMPLATE
// ---------------------------------------------
$html = '';

// Dựa vào $template_key (ví dụ: 'basic_01', 'modern_02') để include file template HTML tương ứng.
// Bạn phải tạo các file template này (ví dụ: 'templates/basic_01.html.php')
// Trong các file template này, bạn sẽ sử dụng biến $data để hiển thị thông tin.

if ($template_key == 'basic_01') {
    ob_start(); // Bắt đầu bộ đệm đầu ra
    include 'templates/basic_01_template.php'; // File này chứa HTML/CSS cho mẫu cơ bản
    $html = ob_get_clean(); // Lấy nội dung HTML đã tạo
} else {
    // Xử lý các mẫu khác hoặc mẫu mặc định
    ob_start();
    include 'templates/default_template.php'; 
    $html = ob_get_clean();
}

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$filename = 'CV-' . $data['name'] . '.pdf'; 

$dompdf->stream($filename, ["Attachment" => true]); // 

exit();
?>