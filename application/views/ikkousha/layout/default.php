<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
 
     <!-- Site Metas -->
    <title>Hakata Ikkousha - Restaurant</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=CSS_URL?>bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="<?=CSS_URL?>style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?=CSS_URL?>responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=CSS_URL?>custom.css">
    <!-- Custom Javascript -->
	<script type="text/JavaScript"> src="<?=JS_URL?>modernizr.js"></script> <!-- Modernizr -->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body id="page-top" class="politics_version">

    <!-- LOADER -->
    <div id="preloader">
        <div id="main-ld">
			<div id="loader"></div>  
		</div>
    </div><!-- end loader -->
    <!-- END LOADER -->
	
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container-fluid">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
			<img class="img-fluid" src="<?=IMG_URL?>logo.png" alt="" />
		</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger active" href="http://menuikkousha.com/#about"><span>About</span></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
	
    <?=$content?>
	
	<footer class="main-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="mb-3 img-logo">
						<a href="#">
							 <img src="<?=IMG_URL?>logo.png" alt="">
						</a>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<h4 class="mb-4 ph-fonts-style foot-title">
						Recent Link
					</h4>
					<ul class="ph-links-column">
						<li><a href="#" class="text-black">About us</a></li>
						<li><a href="#" class="text-black">Contact us</a></li>
						<li><a href="#" class="text-black">Menu</a></li>
						<li><a href="#" class="text-black">Careers</a></li>
					</ul>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<h4 class="mb-4 ph-fonts-style foot-title">
						Contact Us
					</h4>
					<div class="cont-box-footer">
						<div class="cont-line">
							<div class="icon-b">
								<i class="fa fa-map-signs" aria-hidden="true"></i>
							</div>
							<div class="cont-dit">
								<p>9236 Winding Way St. Richardson, TX 75080</p>
							</div>
						</div>
						<div class="cont-line">
							<div class="icon-b">
								<i class="fa fa-volume-control-phone" aria-hidden="true"></i>
							</div>
							<div class="cont-dit">
								<p><a href="#">+ 11 888 998 899</a></p>
								<p><a href="#">+ 11 800 990 800</a></p>
							</div>
						</div>
						<div class="cont-line">
							<div class="icon-b">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
							</div>
							<div class="cont-dit">
								<p><a href="#">demoinfo@gmail.com</a></p>
								<p><a href="#">demoinfo@gmail.com</a></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<h4 class="mb-4 ph-fonts-style foot-title">
						SUBSCRIBE
					</h4>
					<p class="ph-fonts-style_p">
						Get monthly updates and free resources.
					</p>
					<div class="media-container-column" data-form-type="formoid">
						<div data-form-alert="" class="align-center" hidden="">
							Thanks for filling out the form!
						</div>

						<form class="form-inline" action="#" method="post">
							<input value="" data-form-email="true" type="hidden">
							<div class="form-group">
								<input class="form-control input-sm input-inverse my-2" name="email" required="" data-form-field="Email" placeholder="Email" id="email" type="email">
							</div>
							<div class="input-group-btn">
								<button href="" class="btn hvr-radial-in btn-primary" type="submit" role="button"><span> Subscribe </span></button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</footer>

    <div class="copyrights">
        <div class="container-fluid">
            <div class="footer-distributed">
                <div class="footer-left">
                    <p class="footer-company-name">All Rights Reserved. &copy; 2020 <a href="#">Menuikkousha</a></p>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="<?=JS_URL?>jquery.min.js"></script>
    <script src="<?=JS_URL?>blowup.js"></script>
    <script src="<?=JS_URL?>all.js"></script>
	<!-- Camera Slider -->
	<script src="<?=JS_URL?>jquery.mobile.customized.min.js"></script>
	<script src="<?=JS_URL?>jquery.easing.1.3.js"></script> 
	<script src="<?=JS_URL?>parallaxie.js"></script>
	<script src="<?=JS_URL?>headline.js"></script>
	<script src="<?=JS_URL?>owl.carousel.js"></script>
	<script src="<?=JS_URL?>jquery.nicescroll.min.js"></script>
	<!-- Contact form JavaScript -->
    <script src="<?=JS_URL?>jqBootstrapValidation.js"></script>
    <script src="<?=JS_URL?>contact_me.js"></script>
    <!-- ALL PLUGINS -->
    
    <script src="<?=JS_URL?>custom.js"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('.full-item').blowup({
				// round magnifying glass
				round: true,

				// width/height of magnifying glass
				width: 200,
				height: 200,

				// background color
				background: "#FFF",

				// border shadow
				shadow: "0 8px 17px 0 rgba(0, 0, 0, 0.2)",

				// border styles
				border: "6px solid #FFF",

				// displays cursor
				cursor: true,

				// z-index
				zIndex: 999999,

				// scale factor
				scale: 1.5,

				// custom CSS classes
				customClasses: ""	
    		});
    	});
	</script>
</body>
</html>