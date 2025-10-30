<?php
session_start();

// Xóa toàn bộ session hiện tại
session_unset();
session_destroy();

// Quay về trang chủ (home)
header("Location: ../index.php?page=home");
exit;
?>
