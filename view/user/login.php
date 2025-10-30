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
        	<h2>Chào mừng bạn đến với TH_CV</h2>
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
                <div class="form-column column col-lg-6 col-md-12 col-sm-12">
                
                    <div class="sec-title">
                        <h2>Đăng nhập và khám phá cùng TH_CV</h2>
                    </div>
                    
                    <!--Login Form-->
                    <div class="styled-form login-form">
                        <form method="post" action="../../controller/login.php">
                            
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                <input type="email" name="email" value="" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                <input type="password" name="password" value="" placeholder="Mật khẩu">
                            </div>
                            
                            <div class="clearfix">
                                <div class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-one">Đăng nhập </button>
                                </div>
                                <div class="form-group social-links-two pull-right">
                                    Hoặc đăng nhập bằng <a href="#" class="img-circle facebook"><span class="fa fa-facebook-f"></span></a> <a href="#" class="img-circle twitter"><span class="fa fa-twitter"></span></a> <a href="#" class="img-circle google-plus"><span class="fa fa-google-plus"></span></a>
                                </div>
                                  <div class="form-group submit-text pull-right">
                                    Tôi chưa có tài khoản <a href="register.php">Đăng ký</a>
                                </div>
                            </div>
                           
                            
                            
                        </form>
                    </div>
                    
                </div>
                
                <!--Form Column-->
              
                
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