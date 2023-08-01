<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Borneo Tropical Stream is a premium tilapia farming company based in South Borneo, Indonesia.">
    <meta name="keyword" content="tilapia, tilapia fish, premium tilapia, tilapia farming, tilapia company, south borneo tilapia, tilapia indonesia">
    <title><?=$get_site_info['site_name']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:image" content="<?=!isset($news['primary_image'])?base_url().ASSETS_URL.'images/fish/primary_logo.png':base_url().'uploads/'.$news['primary_image']?>"/>  
    <meta property="og:title" content="<?=!isset($news['title'])?'Borneo Tropical Stream':strip_tags($news['title'])?>"/>  
    <meta property="og:description" content="<?=!isset($news['teaser'])?'Borneo Tropical Stream is a premium tilapia farming company based in South Borneo, Indonesia':strip_tags($news['teaser'])?>"/>  

    <script src="https://kit.fontawesome.com/0a41bae84c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=CSS_URL?>open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?=CSS_URL?>animate.css">
    
    <link rel="stylesheet" href="<?=CSS_URL?>owl.carousel.min.css">
    <link rel="stylesheet" href="<?=CSS_URL?>owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=CSS_URL?>magnific-popup.css">

    <link rel="stylesheet" href="<?=CSS_URL?>aos.css">

    <link rel="stylesheet" href="<?=CSS_URL?>ionicons.min.css">

    <link rel="stylesheet" href="<?=CSS_URL?>bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?=CSS_URL?>jquery.timepicker.css">

    
    <link rel="stylesheet" href="<?=CSS_URL?>flaticon.css">
    <link rel="stylesheet" href="<?=CSS_URL?>icomoon.css">
    <link rel="stylesheet" href="<?=CSS_URL?>style.css">
    <link rel="stylesheet" href="<?=CSS_URL?>custom-bts.css">
    <link rel="stylesheet" href="<?=CSS_URL?>responsive.css">
    <script src="<?=JS_URL?>jquery.min.js"></script>
    <script src="<?=JS_URL?>jquery-migrate-3.0.1.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body class="goto-here">
		<div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">

          <div class="col-xs-12 d-none d-sm-none">
            <div class="row">
              <div class="col-xs-12">
                <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2">  </span>
                </div>
                <span class="text"><?=$get_site_info['phone']?></span>
              </div>
              <div class="col-xs-12">
                <div class="icon mr-2 d-flex justify-content-center align-items-center">
                  <span class="icon-paper-plane"></span>
                </div>
                <span class="text"><?=$get_site_info['email']?></span>
              </div>
              <div class="col-xs-12">
                <span class="text">5 days/week for business day</span>
              </div>
            </div>
          </div>

	    		<div class="col-lg-12 d-none d-md-block d-xl-block">
		    		<div class="row d-flex">
		    			<div class="col-lg-4 col-md-12 pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex d-none d-sm-none d-md-none d-lg-block d-xl-block justify-content-center align-items-center">
                  <span class="icon-phone2"></span>
                </div>
						    <span class="text top-site-info-phone"><?=$get_site_info['phone']?></span>
					    </div>
					    <div class="col-lg-4 col-md-12 pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex d-none d-sm-none d-md-none d-lg-block d-xl-block justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text"><?=$get_site_info['email']?></span>
					    </div>
					    <div class="col-lg-4 col-md-12 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text">5 days/week for business day</span>
					    </div>
				    </div>
			    </div>

		    </div>
		  </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="<?=base_url()?>">
	      	<img src="<?=ASSETS_URL?>images/fish/primary_logo.png" class="logo img-fluid">
	      </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	        	
	          <li class="nav-item <?=empty($this->uri->segment(1))?'active':''?>"><a href="<?=base_url()?>" class="nav-link">Home</a></li>
            <?php foreach($top_menu as $key=>$val): ?>
            <li class="nav-item <?=($val['slug']==strtolower($this->uri->segment(1)))?'active':''?> <?=(isset($val['child_menu']) && !empty($val['child_menu']))?'dropdown':''?>">
              <a href="<?=( $val['page_type']==1 )?base_url('pages/').$val['slug']:($val['page_type']==2?base_url().$val['module']:(($val['page_type']==3 && !empty($val['ext_link']) && $val['ext_link']=='#')?'#':$val['ext_link']))?>" class="nav-link <?=(isset($val['child_menu']) && !empty($val['child_menu']))?'dropdown-toggle':''?>" <?=(isset($val['child_menu']) && !empty($val['child_menu']))?'id="dropdown-'.$val['slug'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"':''?>>
                <?=$val['page_name']?>
              </a>
              <?php if(isset($val['child_menu']) && !empty($val['child_menu'])): ?>
              <div class="dropdown-menu" aria-labelledby="dropdown-<?=$val['slug']?>">
                <?php foreach($val['child_menu'] as $k=>$c): ?>
                <a class="dropdown-item" href="<?=( $c['page_type']==1 )?base_url('pages/').$c['slug']:($c['page_type']==2?$c['module']:(($c['page_type']==3 && !empty($c['ext_link']) && $c['ext_link']=='#')?'#':$c['ext_link']))?>"><?=$c['title']?></a>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <?= $content ?>

    <footer class="ftco-footer ftco-section pb-2 pt-5">
      <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-3">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              
              <p>
              	<img src="<?=ASSETS_URL?>images/fish/white_logo.png" class="footer-logo img-fluid">
              </p>

              <p><?=$get_site_info['slogan']?></p>
              
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled footer-menu">
                <li class="my-1"><a href="<?=base_url()?>" class="py-1 d-block">Home</a></li>
                <?php foreach($top_menu as $key=>$val): ?>
                <li class="my-1"><a href="<?=( $val['page_type']==1 )?base_url('pages/').$val['slug']:($val['page_type']==2?base_url().$val['module']:(($val['page_type']==3 && !empty($val['ext_link']) && $val['ext_link']=='#')?'#':$val['ext_link']))?>" class="py-1 d-block"><?=$val['page_name']?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled footer-menu mr-l-5 pr-l-3 mr-4">
	                <li class="my-1"><a href="#" class="py-1 d-block">Terms &amp; Conditions</a></li>
	                <li class="my-1"><a href="#" class="py-1 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled footer-menu">
	                <li class="my-1"><a href="#" class="py-1 d-block">FAQs</a></li>
	                <li class="my-1"><a href="#" class="py-1 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text"><?=$get_site_info['site_address']?></span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text"><?=$get_site_info['phone']?></span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text"><?=$get_site_info['email']?></span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-12 d-flex justify-content-center">
        		<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
        	</div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center color-white">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> <?=$get_site_info['site_name']?>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>
    
<!-- Modal Subscriber -->
<div class="modal fade" id="subscriber-modal" tabindex="-1" role="dialog" aria-labelledby="subscriber-modal" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 0;">
      <div class="modal-body p-0">
        <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
          <button type="button" class="close position-absolute" style="top:10px;right:12px" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size: 30px">&times;</span>
          </button>
          <div class="container py-4">
            <?php echo form_open(base_url().'subscribe','role="form" class="subscribe-form"'); ?>
            <div class="row d-flex justify-content-center pt-4 pb-2">
              <div class="col">
                <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
                <span>Get e-mail updates about our latest tilapia and special offers</span>
              </div>
              <div class="col-md-6">
                  <div class="form-group d-flex">
                    <input type="email" name="customer_email" class="form-control" placeholder="Enter email address">
                    <input type="submit" value="Subscribe" class="submit px-3">
                  </div>
              </div>
            </div>
            <div class="row d-flex justify-content-center py-1">
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <div class="form-group text-center" style="background-color: transparent">
                    <div class="g-recaptcha" data-sitekey="6LdMvNIkAAAAAF6hwGnpg-lFMqDLZz0Mba42yPLj"></div>
                    <p class="captcha_false text-left" style="color:#ff0000"></p>
                    <p class="error_msg text-left" style="color:#ff0000"></p>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script src="<?=JS_URL?>popper.min.js"></script>
  <script src="<?=JS_URL?>bootstrap.min.js"></script>
  <script src="<?=JS_URL?>jquery.easing.1.3.js"></script>
  <script src="<?=JS_URL?>jquery.waypoints.min.js"></script>
  <script src="<?=JS_URL?>jquery.stellar.min.js"></script>
  <script src="<?=JS_URL?>owl.carousel.min.js"></script>
  <script src="<?=JS_URL?>jquery.magnific-popup.min.js"></script>
  <script src="<?=JS_URL?>aos.js"></script>
  <script src="<?=JS_URL?>jquery.animateNumber.min.js"></script>
  <script src="<?=JS_URL?>bootstrap-datepicker.js"></script>
  <script src="<?=JS_URL?>scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="<?=JS_URL?>google-map.js"></script>
  <script src="https://kit.fontawesome.com/0a41bae84c.js" crossorigin="anonymous"></script>
  <script src="<?=JS_URL?>main.js"></script>
  <?php if($this->session->flashdata('captcha_false')): ?>
  <script type="text/javascript">
      $('#subscriber-modal').modal('show');
      $('.captcha_false').attr('style="color: #f8d7da"');
      $('.captcha_false').html('Wrong captcha ! Please try again.');
  </script>
  <?php endif; ?>

  <?php if($this->session->flashdata('error_code')==1062): ?>
  <script type="text/javascript">
      $('#subscriber-modal').modal('show');
      $('.error_msg').attr('style="color: #f8d7da"');
      $('.error_msg').html('Your email address is already registered as a subscriber. Please use another email address.');
  </script>
  <?php endif; ?>
  </body>
</html>