

<header class="main-header header-style-two">
<div class="header-top">
    <div class="auto-container">
        <div class="clearfix">
            
            <!--Top Left-->
            <div class="top-left">
                <div class="text">
                    Tiếp cận 60.000+ tin tuyển dụng việc làm từ hàng nghìn doanh nghiệp uy tín tại Việt Nam
                </div>
            </div>
            
            <!--Top Right-->
            <div class="top-right">
                <?php if (isset($_SESSION["id"])): ?>
                    <!-- Nếu đã đăng nhập -->
                    <div class="language dropdown">
                        <a class="btn btn-default dropdown-toggle" id="dropdownMenu2" href="#">
                            <span class="flag-icon">
                                <img src="assets/images/icons/flag-icon.jpg" alt=""/>
                            </span>
                           <?php echo htmlspecialchars($_SESSION["name"]); ?>&nbsp;
                        </a>
                    </div>
                    <div class="language dropdown">
                       <a class="btn btn-default dropdown-toggle" id="dropdownMenu2" href="controller/logout.php">
							<span class="flag-icon">
								<img src="assets/images/icons/flag-icon.jpg" alt=""/>
							</span>
							Đăng xuất&nbsp;
						</a>
                    </div>
                <?php else: ?>
                    <!-- Nếu chưa đăng nhập -->
                    <ul class="social-box">
                        <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                        <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                        <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                    </ul>
                    <div class="language dropdown"> <a class="btn btn-default dropdown-toggle" id="dropdownMenu2" href="view/user/login.php"><span class="flag-icon"><img src="assets/images/icons/flag-icon.jpg" alt=""/></span>Đăng nhập&nbsp;</span></a> </div>
                    <div class="language dropdown"> <a class="btn btn-default dropdown-toggle" id="dropdownMenu2" href="view/user/register.php"><span class="flag-icon"><img src="assets/images/icons/flag-icon.jpg" alt=""/></span>Đăng ký&nbsp;</span></a> </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

    	
    	<!--Header-Upper-->
        <div class="header-upper">
        	<div class="auto-container">
            	<div class="clearfix">
                	
                	<div class="pull-left logo-box">
                    	<div class="logo"><a href="index-2.html"><img src="assets/user/images/logo.png" alt="" title=""></a></div>
                    </div>
                    
                    <div class="pull-right upper-right clearfix">
                    	
                        <!--Info Box-->
                        <div class="upper-column info-box">
                        	<div class="icon-box"><span class="flaticon-pin"></span></div>
                            <ul>
								<li>Tòa FS - GoldSeason <br> số 4, Thành Vinh, Nghệ An</li>
                            </ul>
                        </div>
                        
                        <!--Info Box-->
                        <div class="upper-column info-box">
                        	<div class="icon-box"><span class="flaticon-technology-1"></span></div>
                            <ul>
								<li>0973213610<br> nguyenkhanhtoan@gmail.com</li>
                            </ul>
                        </div>
                        
                        <!--Info Box-->
                        
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <!--End Header Upper-->
        
		<!-- Hidden Nav Toggler -->
		<div class="nav-toggler">
		   <div class="nav-btn"><button class="hidden-bar-opener"><span class="icon flaticon-menu"></span></button></div>
		</div>
		<!-- / Hidden Nav Toggler -->
		
        <!--Header Lower-->
        <div class="header-lower">
            
        	<div class="auto-container">
            	<div class="nav-outer clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md">
                        <div class="navbar-header">
                            <!-- Toggle Button -->    	
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li><a href="index.php?page=user_list_job">Làm việc </a>
									
								</li>

								<li><a href="index.php?page=user_list_cv">Tạo Cv mẫu</a>									
								</li>
                               
						        </li>
								<li class="dropdown"><a href="#">Cẩm nang nghề nghiệp</a>

								</li>
                                <li class="dropdown"><a href="#">Bài Viết nổi bật</a>
							
						        </li>
								
                            </ul>
                        </div>
                    </nav>
                    
                    <!-- Main Menu End-->
                    <div class="outer-box clearfix">
					
						<!--Option Box-->
                    	<div class="option-box">
							<!--Cart Box-->
							<div class="cart-box">
								<div class="dropdown">
									<button class="cart-box-btn dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flaticon-shopping-cart-of-checkered-design"></span><span class="total-cart">2</span></button>
									
								</div>
							</div>
							
							<!--Search Box-->
							<div class="search-box-outer">
								<div class="dropdown">
									<button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
									<ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
										<li class="panel-outer">
											<div class="form-container">
												<form method="post" action="#">
													<div class="form-group">
														<input type="search" name="field-name" value="" placeholder="Search Here" required>
														<button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
													</div>
												</form>
											</div>
										</li>
									</ul>
								</div>
							</div>
							
						</div>
                    </div>
					<div class="side-curve"></div>
                </div>
            </div>
        </div>
        <!--End Header Lower-->
        
        <!--Sticky Header-->
        <div class="sticky-header">
        	<div class="auto-container clearfix">
            	<!--Logo-->
            	<div class="logo pull-left">
                	<a href="index-2.html" class="img-responsive"><img src="assets/user/images/logo-small.png" alt="" title=""></a>
                </div>
                
                <!--Right Col-->
                <div class="right-col pull-right">
                	<!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent1">
		
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
                
            </div>
        </div>
        <!--End Sticky Header-->
    
    </header>