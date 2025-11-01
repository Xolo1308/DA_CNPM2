<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Nên hiển thị lỗi thân thiện hơn trong môi trường Production
    die("Kết nối thất bại: " . $conn->connect_error);
}

// MẢNG CHỨA CÁC MẪU CV THIẾT KẾ CỐ ĐỊNH (Templates)
$cv_templates = [
    'basic_01' => ['name' => 'Mẫu Cơ Bản', 'image' => 'assets/cv_templates/basic_01.png'],
    'modern_02' => ['name' => 'Mẫu Hiện Đại', 'image' => 'assets/cv_templates/modern_02.png'],
    'professional_03' => ['name' => 'Mẫu Chuyên Nghiệp', 'image' => 'assets/cv_templates/professional_03.png'],
];

$default_template_key = 'basic_01';

$user_id = $_SESSION['id'] ?? 0;

// Khởi tạo dữ liệu mặc định/rỗng
$resume_id = $_GET['id'] ?? null; // Lấy resume_id từ URL nếu đang chỉnh sửa

$cv_data = [
    'resume_id' => null,
    'title' => '',
    'skills' => '',
    'summary' => '',
    'template_used' => $default_template_key,

    'experience' => [0 => ['description' => '']], // Chỉ còn trường description
    'education' => [0 => ['school' => '']], // Chỉ còn trường school
];

$user_data = ['name' => '', 'email' => '', 'phone' => '', 'address' => ''];
$default_image_path = $cv_templates[$default_template_key]['image'];


if ($user_id) {
    // 1. Lấy thông tin cá nhân từ bảng USERS
    $sql_user = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result_user = $conn->query($sql_user);
    if ($result_user && $result_user->num_rows > 0) {
        $user_data = $result_user->fetch_assoc();
    }

    // 2. Nếu có resume_id, lấy dữ liệu CV từ bảng RESUMES
    if ($resume_id) {
        $sql_cv = "SELECT * FROM resumes WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
        $result_cv = $conn->query($sql_cv);

        if ($result_cv && $result_cv->num_rows > 0) {
            $data = $result_cv->fetch_assoc();

            // Ghi đè dữ liệu rỗng bằng dữ liệu CV đã lưu
            $cv_data['resume_id'] = $data['resume_id'];
            $cv_data['title'] = $data['title'];
            $cv_data['skills'] = $data['skills'];
            $cv_data['summary'] = $data['summary'] ?? ''; // Giả định cột summary có tồn tại
            $cv_data['template_used'] = $data['template_used'] ?? $default_template_key;

            // Chuyển đổi JSON thành mảng PHP cho các mục lặp lại
            $cv_data['experience'] = json_decode($data['experience'], true) ?: [];
            $cv_data['education'] = json_decode($data['education'], true) ?: [];

            // Nếu dữ liệu JSON rỗng sau khi giải mã, đảm bảo có một mục tối thiểu
            if (empty($cv_data['experience'])) $cv_data['experience'][] = ['title' => '', 'company' => '', 'duration' => '', 'description' => ''];
            if (empty($cv_data['education'])) $cv_data['education'][] = ['degree' => '', 'school' => '', 'duration' => ''];
        }
    }

    // Cập nhật đường dẫn ảnh mẫu hiển thị mặc định
    $default_image_path = $cv_templates[$cv_data['template_used']]['image'] ?? $cv_templates[$default_template_key]['image'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Danh Sách Mẫu CV</title>
    <link href="assets/user/css/bootstrap.css" rel="stylesheet">
    <link href="assets/user/css/style.css" rel="stylesheet">
    <style>
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
    </style>
</head>

<body>

    <div class="page-wrapper">
        <?php include 'include/header.php'; ?>

        <section class="page-title" style="background-image:url(assets/user/images/background/2.jpg);">
            <div class="auto-container">
                <h2>Chọn Mẫu & Tạo CV</h2>
            </div>
        </section>

        <div class="breadcrumb-outer"></div>

        <section class="cv-creator-section pt-5 pb-5">
            <div class="auto-container">
                <div class="row clearfix">

                    <div class="col-lg-6 col-md-12 col-sm-12 content-side">

                        <div id="template-selection-view" style="<?= $cv_data['resume_id'] ? 'display:none;' : '' ?>">
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

                            <hr class="mt-4">
                            <button type="button" id="start-creation-btn" class="theme-btn btn-style-one bg-success text-white">
                                <span class="fa fa-pencil"></span> **THIẾT KẾ & TẠO CV VỚI MẪU NÀY**
                            </button>
                        </div>
                        <div id="cv-creation-form" style="<?= $cv_data['resume_id'] ? '' : 'display:none;' ?>">
                            <h3>Nhập Thông Tin Hồ Sơ CV</h3>
                            <hr>

                            <button type="button" id="back-to-selection-btn" class="btn btn-sm btn-outline-secondary mb-3">
                                <span class="fa fa-arrow-left"></span> Quay lại chọn mẫu
                            </button>

                            <form id="cv-input-form" method="POST" action="index.php?page=user_process_cv">
                                <input type="hidden" name="resume_id" value="<?= $cv_data['resume_id'] ?>">
                                <input type="hidden" name="template_used" id="hidden-template-used" value="<?= $cv_data['template_used'] ?>">

                                <fieldset class="p-3 border rounded mb-4">
                                    <legend class="w-auto px-2">Thông tin Cá nhân và Tóm tắt</legend>

                                    <div class="form-group">
                                        <label>Tiêu đề CV </label>
                                        <input type="text" name="cv_title" class="form-control" placeholder="Ví dụ: CV Lập trình viên PHP" value="<?= htmlspecialchars($cv_data['title']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Họ và Tên</label>
                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user_data['name']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user_data['email']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user_data['phone']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user_data['address']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Tóm Tắt Bản Thân / Mục Tiêu Nghề Nghiệp</label>
                                        <textarea name="summary" class="form-control" rows="4" placeholder="Viết một đoạn tóm tắt ngắn về bản thân và mục tiêu nghề nghiệp."><?= htmlspecialchars($cv_data['summary']) ?></textarea>
                                    </div>
                                </fieldset>

                                <fieldset class="p-3 border rounded mb-4">
                                    <legend class="w-auto px-2">Kỹ năng (Skills)</legend>
                                    <div class="form-group">
                                        <label>Danh sách Kỹ năng</label>
                                        <textarea name="skills" class="form-control" rows="3" placeholder="Ví dụ: PHP, MySQL, JavaScript (Ngăn cách bằng dấu phẩy)"><?= htmlspecialchars($cv_data['skills']) ?></textarea>
                                    </div>
                                </fieldset>

                                <fieldset class="p-3 border rounded mb-4">
                                    <legend class="w-auto px-2">Kinh nghiệm Làm việc (Experience)</legend>
                                    <div id="experience-section">
                                        <?php foreach ($cv_data['experience'] as $index => $exp): ?>
                                            <div class="experience-entry mb-3 p-3 border rounded bg-light">
                                                <textarea name="experience[<?= $index ?>][description]" class="form-control" rows="3" placeholder="Mô tả công việc và thành tích chính"><?= htmlspecialchars($exp['description'] ?? '') ?></textarea>
                                                <?php if ($index > 0): ?>
                                                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-entry">Xóa</button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="add-experience-btn" class="theme-btn btn-style-one bg-info text-white btn-sm"><span class="fa fa-plus"></span> Thêm Kinh nghiệm</button>
                                </fieldset>

                                <fieldset class="p-3 border rounded mb-4">
                                    <legend class="w-auto px-2">Học vấn (Education)</legend>
                                    <div id="education-section">
                                        <?php foreach ($cv_data['education'] as $index => $edu): ?>
                                            <div class="education-entry mb-3 p-3 border rounded bg-light">
                                                
                                                <input type="text" name="education[<?= $index ?>][school]" class="form-control mb-2" placeholder="Tên Trường/Tổ chức" value="<?= htmlspecialchars($edu['school'] ?? '') ?>">
                                               
                                                <?php if ($index > 0): ?>
                                                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-entry">Xóa</button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="add-education-btn" class="theme-btn btn-style-one bg-info text-white btn-sm"><span class="fa fa-plus"></span> Thêm Học vấn</button>
                                </fieldset>

                                <hr>
                                <button type="submit" name="action" value="save" class="theme-btn btn-style-one bg-success text-white">
                                    <span class="fa fa-save"></span> Lưu Bản Nháp
                                </button>
                                <button type="submit" name="action" value="export" class="theme-btn btn-style-two bg-primary text-white ml-2">
                                    <span class="fa fa-download"></span> Xuất PDF
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 sidebar-side">
                        <aside class="sidebar default-sidebar sticky-sidebar">
                            <div class="sidebar-widget">

                                <h3>📋 Mẫu CV Tham Khảo</h3>
                                <hr>

                                <div id="template-preview-area" class="mt-4 p-2 border rounded text-center">
                                    <h4 id="template-name-display" class="mb-3 text-info"><?= $cv_templates[$cv_data['template_used']]['name'] ?></h4>
                                    <img id="template-image" src="<?= $default_image_path ?>"
                                        alt="Mẫu CV Tham Khảo" class="img-fluid" style="border: 1px solid #ddd;">
                                    <p class="mt-2 text-muted">Ảnh mẫu thiết kế CV.</p>
                                </div>

                                <div id="template-buttons-container" style="<?= $cv_data['resume_id'] ? 'display:none;' : '' ?>">
                                    <h4 class="mt-4">Danh sách các mẫu CV có sẵn:</h4>
                                    <div class="template-list-buttons text-center">
                                        <?php foreach ($cv_templates as $key => $template): ?>
                                            <button type="button" class="btn btn-primary m-1 template-select-btn" data-template-key="<?= $key ?>">
                                                <span class="fa fa-file-text-o"></span> <?= htmlspecialchars($template['name']) ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
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

            var templates = <?= json_encode($cv_templates) ?>;

            $('#start-creation-btn').on('click', function() {
                $('#template-selection-view').hide();
                $('#template-buttons-container').hide(); // Ẩn nút chọn mẫu ở cột phải
                $('#cv-creation-form').fadeIn(300);
            });

            $('#back-to-selection-btn').on('click', function() {
                $('#cv-creation-form').hide();
                $('#template-buttons-container').fadeIn(300); // Hiện nút chọn mẫu lại
                $('#template-selection-view').fadeIn(300);
            });

            $('.template-select-btn').on('click', function() {
                var selectedKey = $(this).data('template-key');
                var newImagePath = templates[selectedKey].image;
                var newName = templates[selectedKey].name;

                $('#template-image').attr('src', newImagePath);
                $('#template-name-display').text(newName);

                $('#hidden-template-used').val(selectedKey);

                $('.template-select-btn').removeClass('btn-info').addClass('btn-primary');
                $(this).removeClass('btn-primary').addClass('btn-info');
            });

            // Kích hoạt nút mặc định/đã chọn khi tải trang
            $('.template-select-btn[data-template-key="<?= $cv_data['template_used'] ?>"]').click();


            let experienceCount = $('#experience-section').children().length;
            let educationCount = $('#education-section').children().length;

            function addDynamicSection(sectionId, inputName, placeholderTitles, currentCount) {
    let count = currentCount;

    $(`#add-${sectionId}-btn`).on('click', function() {
        let entryContent = '';
        if (inputName === 'experience') {
            // Chỉ tạo textarea cho experience (description)
            entryContent = `<textarea name="${inputName}[${count}][description]" class="form-control" rows="3" placeholder="${placeholderTitles[0]}"></textarea>`;
        } else if (inputName === 'education') {
            // Chỉ tạo input cho education (school)
            entryContent = `<input type="text" name="${inputName}[${count}][school]" class="form-control mb-2" placeholder="${placeholderTitles[0]}">`;
        }
        
        // Tạo HTML mới
        let newEntry = `
            <div class="${sectionId}-entry mb-3 p-3 border rounded bg-light">
                ${entryContent}
                <button type="button" class="btn btn-sm btn-danger mt-2 remove-entry">Xóa</button>
            </div>
        `;
        
        $(`#${sectionId}`).append(newEntry);
        count++; // Tăng biến đếm cho lần thêm tiếp theo
    });

    // Xử lý nút Xóa (sử dụng delegation)
    $(`#${sectionId}`).on('click', '.remove-entry', function() {
        $(this).closest(`.${sectionId}-entry`).remove();
    });
}

// Khởi tạo lại với placeholder mới và index mới (thay thế dòng cũ)
addDynamicSection('experience-section', 'experience', ['Mô tả công việc và thành tích chính'], experienceCount);
addDynamicSection('education-section', 'education', ['Tên Trường/Tổ chức'], educationCount);
        });
    </script>
</body>

</html>