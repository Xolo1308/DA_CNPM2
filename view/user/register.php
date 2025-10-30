<!DOCTYPE html>
<html>

<!-- account36:25-->
<head>
<meta charset="utf-8">
<title>Lezo HTML Template | Account</title>
<!-- Stylesheets -->
<link href="../../assets/user/css/bootstrap.css" rel="stylesheet">
<link href="../../assets/user/css/style.css" rel="stylesheet">
<link href="../../assets/user/css/slick.css" rel="stylesheet">
<link href="../../assets/user/css/responsive.css" rel="stylesheet">
<!--Color Switcher Mockup-->
<link href="../../assets/user/css/color-switcher-design.css" rel="stylesheet">
<!--Color Themes-->
<link id="theme-color-file" href="../../assets/user/css/color-themes/default-theme.css" rel="stylesheet">

<link rel="shortcut icon" href="../../assets/user/images/favicon.png" type="image/x-icon">
<link rel="icon" href="../../assets/user/images/favicon.png" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body>

<div class="page-wrapper">  
 	<?php include 'include/header.php'; ?>
	<!--Page Title-->
    <section class="page-title" style="background-image:url(../../assets/user/images/background/2.jpg);">
    	<div class="auto-container">
        	<h2>Đăng ký tài khoản</h2>
        </div>
    </section>
    
    <!--Breadcrumb-->
    <div class="breadcrumb-outer">
    	<div class="auto-container">
        	<ul class="bread-crumb text-center">
            	<li><a href="../../index.php?page=home">Home</a> <span class="fa fa-angle-right"></span></li>
                <li>Account</li>
            </ul>
        </div>
    </div>
    <!--End Page Title-->
	
	<!--Register Section-->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                
                <!--Form Column-->
              
                <!--Form Column-->
                <div class="form-column column col-lg-6 col-md-12 col-sm-12">
                
                    <div class="sec-title">
                        <h6>Đăng ký tài khoản </h1>
                        <h6>Chào mừng bạn đến với TH_CV
Cùng xây dựng một hồ sơ nổi bật và nhận được các cơ hội sự nghiệp lý tưởng</h2>
                    </div>
                    
                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="../../controller/register.php">
                           
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                <input type="text" name="name" value="" placeholder="Your Username *">
                            </div>
                             <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                <input type="email" name="email" value="" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                <input type="password" name="password" value="" placeholder="Enter Password">
                            </div>
                             
                            <label>Loại tài khoản:</label><br>
                                <select name="role">
                                <option value="0">User</option>
                                <option value="1">Company</option>
                            </select><br><br>
                             <div class="clearfix">
                                <div class="pull-left">
                                    <input type="checkbox" id="agree" name="agree"><label class="remember-me" for="remember-me">&nbsp; Tôi đã đọc và đồng ý với <a href="dk.php"> Điều khoản dịch vụ </a> và <a href="csbm.php"> Chính sách bảo mật của TH_CV</a></label>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-one">Đăng ký </button>
                                </div>
                                <div class="form-group submit-text pull-right">
                                    Tôi đã có tài khoản <a href="login.php">Đăng nhập</a>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>
   <?php include 'include/footer.php'; ?>
</div>

</body>
<script src="../../assets/user/js/jquery.js"></script>
<script src="../../assets/user/js/popper.min.js"></script>
<script src="../../assets/user/js/bootstrap.min.js"></script>
<script src="../../assets/user/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="../../assets/user/js/jquery.fancybox.js"></script>
<script src="../../assets/user/js/appear.js"></script>
<script src="../../assets/user/js/owl.js"></script>
<script src="../../assets/user/js/wow.js"></script>
<script src="../../assets/user/js/slick.js"></script>
<script src="../../assets/user/js/jquery-ui.js"></script>
<script src="../../assets/user/js/script.js"></script>
<script src="../../assets/user/js/color-settings.js"></script>
<!-- account36:25-->
</html>