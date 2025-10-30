<?php
session_start();
if (!isset($_SESSION["id"])) {
   header("Location: /DA_CNPM/view/user/login.php");
    exit;
}
?>
