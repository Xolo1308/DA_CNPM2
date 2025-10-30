<?php
session_start();

$page = $_GET['page'] ?? 'home';

switch ($page) {

    // ========== ADMIN ==========
    case 'admin':
        include 'view/admin/login.php';
        break;

    // ========== USER HOME ==========
    case 'user_home':
        if (isset($_SESSION["role"]) && $_SESSION["role"] == 0) {
            include 'view/user/include/user_home.php';
        } else {
            echo "<script>alert('Bạn không có quyền truy cập trang người dùng!'); window.location='index.php';</script>";
        }
        break;

    // ========== COMPANY HOME ==========
    case 'company_home':
        if (isset($_SESSION["role"]) && $_SESSION["role"] == 1) {
            include 'view/user/include/compy_home.php';
           
        } else {
            echo "<script>alert('Bạn không có quyền truy cập trang công ty!'); window.location='index.php';</script>";
        }
        break;

case 'job_list_company':
case 'add_job_company':
case 'edit_job_company':
case 'delete_job_company':
    if (isset($_SESSION["role"]) && $_SESSION["role"] == 1) {
        switch ($page) {
            case 'job_list_company':
                include 'view/user/include/company/list_job.php';
                break;

            case 'add_job_company':
                include 'view/user/include/company/add_job.php';
                break;

            case 'edit_job_company':
                include 'view/user/include/company/edit_job.php';
                break;

            case 'delete_job_company':
                include 'view/user/include/company/delete_job.php';
                break;
        }
    } else {
        echo "<script>alert('Chỉ doanh nghiệp mới được truy cập mục này!'); window.location='index.php';</script>";
    }
    break;

    case 'tt_list_company':
case 'tt_add_company':
case 'tt_edit_company':
case 'tt_delete_company':
    if (isset($_SESSION["role"]) && $_SESSION["role"] == '1') {
        switch ($page) {
            case 'tt_list_company':
                include 'view/user/include/company/list_company.php';
                break;
            case 'tt_add_company':
                include 'view/user/include/company/add_company.php';
                break;
            case 'tt_edit_company':
                include 'view/user/include/company/edit_company.php';
                break;
            case 'tt_delete_company':
                include 'view/user/include/company/delete_company.php';
                break;
        }
    } else {
        echo "<script>alert('Chỉ doanh nghiệp mới được truy cập mục này!'); window.location='index.php';</script>";
    }
    break;

    // ========== TRANG CHỦ MẶC ĐỊNH ==========
    default:
        include 'view/user/include/home.php';
        break;
}
?>
