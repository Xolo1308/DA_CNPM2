<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>

<?php

$cv_templates = [
    'basic_01' => ['name' => 'Mẫu Cơ Bản', 'image' => 'assets/cv_templates/basic_01.png'],
    'modern_02' => ['name' => 'Mẫu Hiện Đại', 'image' => 'assets/cv_templates/modern_02.png'],
    'professional_03' => ['name' => 'Mẫu Chuyên Nghiệp', 'image' => 'assets/cv_templates/professional_03.png'],
];

$default_template_key = 'basic_01';
$default_image_path = $cv_templates[$default_template_key]['image'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Danh Sách Mẫu CV</title>
<link href="assets/user/css/bootstrap.css" rel="stylesheet">
<link href="assets/user/css/style.css" rel="stylesheet">
</head>

<body>

<div class="page-wrapper">
    <?php include 'include/header.php'; ?>
    
    <section class="page-title" style="background-image:url(assets/user/images/background/2.jpg);">
        <div class="auto-container">
            <h2>Chọn Mẫu CV</h2>
        </div>
    </section>
     <div class="breadcrumb-outer">
    	<div class="auto-container">
        	<ul class="bread-crumb text-center">
            	<li><a href="index.php?page=home">Home</a> <span class="fa fa-angle-right"></span></li>
                <li>Tin đăng tuyển dụng</li>
            </ul>
        </div>
    </div>
    <div class="breadcrumb-outer">
        </div>

    <section class="cv-creator-section pt-5 pb-5">
        <div class="auto-container">
            <div class="row clearfix">
                
                <div class="col-lg-6 col-md-12 col-sm-12 content-side">
                    <h3> Chọn Thiết Kế CV</h3>
                    <hr>
                    <div class="p-4 border rounded bg-light">
                        <p>Vui lòng chọn một mẫu thiết kế từ danh sách bên dưới. Mẫu bạn chọn sẽ được hiển thị ở cột bên phải để tham khảo.</p>
                        <p class="font-weight-bold mt-3">Đây sẽ là giao diện CV của bạn khi xuất ra file PDF.</p>
                        </div>
                    
                    <h4 class="mt-4">Danh sách các mẫu CV có sẵn:</h4>
                    <div class="template-list-buttons">
                        <?php foreach ($cv_templates as $key => $template): ?>
                            <button type="button" class="btn btn-primary m-1 template-select-btn" data-template-key="<?= $key ?>">
                                <span class="fa fa-file-text-o"></span> <?= htmlspecialchars($template['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="actions mt-4 text-center">
                        <a href="index.php?page=user_detail_cv" class="theme-btn btn-style-one bg-success text-white">
                            <span class="fa fa-send"></span>  Tạo cv mẫu
                        </a>
                        <a href="index.php?page=user_list_pdf" class="theme-btn btn-style-one bg-success text-white">
                            <span class="fa fa-send"></span>  Xem lại mẫu cv
                        </a>
                    </div>
                    
                </div>
                
                <div class="col-lg-6 col-md-12 col-sm-12 sidebar-side">
                    <aside class="sidebar default-sidebar">
                        <div class="sidebar-widget">
                            
                            <h3>📋 Mẫu CV Tham Khảo</h3>
                            <hr>
                            
                            <div id="template-preview-area" class="mt-4 p-2 border rounded text-center" style="max-height: 800px; overflow-y: auto;">
                                <h4 id="template-name-display" class="mb-3 text-info"><?= $cv_templates[$default_template_key]['name'] ?></h4>
                                <img id="template-image" src="<?= $default_image_path ?>" 
                                     alt="Mẫu CV Tham Khảo" style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                <p class="mt-5 text-muted">Ảnh mẫu thiết kế CV.</p>
                            </div>
                        </div>
                    </aside>
                </div>
                
            </div>
        </div>
    </section>
    <?php include 'include/footer.php'; ?>
</div>

<script src="assets/user/js/jquery.js"></script>
<script src="assets/user/js/popper.min.js"></script>
<script src="assets/user/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    
    // Khởi tạo danh sách mẫu từ PHP
    var templates = <?= json_encode($cv_templates) ?>;

    // --- LOGIC HIỂN THỊ MẪU TĨNH KHI NHẤN NÚT ---
    $('.template-select-btn').on('click', function() {
        // 1. Lấy KEY của mẫu được chọn
        var selectedKey = $(this).data('template-key'); 

        // 2. Lấy đường dẫn ảnh và tên mẫu mới
        var newImagePath = templates[selectedKey].image;
        var newName = templates[selectedKey].name;

        // 3. Cập nhật thẻ <img>
        $('#template-image').attr('src', newImagePath);

        // 4. Cập nhật tên mẫu
        $('#template-name-display').text(newName);
        
        // 5. Cập nhật trạng thái nút (làm nổi bật nút đang được chọn)
        $('.template-select-btn').removeClass('btn-info').addClass('btn-primary');
        $(this).removeClass('btn-primary').addClass('btn-info');
    });

    // Kích hoạt nút mặc định khi tải trang
    $('.template-select-btn[data-template-key="<?= $default_template_key ?>"]').click();
});
</script>
</body>
</html>