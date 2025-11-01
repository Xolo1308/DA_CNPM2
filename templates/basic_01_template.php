<?php
// Sử dụng các biến từ $data được truyền từ generate_pdf.php
$name = htmlspecialchars($data['name']);
$email = htmlspecialchars($data['email']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CV: <?= $name ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; } /* Quan trọng cho việc hỗ trợ tiếng Việt */
        .header { background-color: #f0f0f0; padding: 10px; }
        .section-title { color: #337ab7; border-bottom: 1px solid #337ab7; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="cv-container">
        <div class="header">
            <h1><?= $name ?></h1>
            <p>Email: <?= $email ?> | Phone: <?= htmlspecialchars($data['phone']) ?></p>
        </div>

        <h2 class="section-title">Tóm Tắt</h2>
        <p><?= nl2br(htmlspecialchars($data['summary'])) ?></p>
        
        <h2 class="section-title">Kỹ Năng</h2>
        <p><?= htmlspecialchars($data['skills']) ?></p>

        <h2 class="section-title">Kinh Nghiệm Làm Việc</h2>
        <?php foreach ($data['experience'] as $exp): ?>
            <p><strong><?= htmlspecialchars($exp['title']) ?></strong> tại <?= htmlspecialchars($exp['company']) ?> (<?= htmlspecialchars($exp['duration']) ?>)</p>
            <ul>
                <li><?= nl2br(htmlspecialchars($exp['description'])) ?></li>
            </ul>
        <?php endforeach; ?>

        </div>
</body>
</html>