<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/aboutus-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span><?=$about_page['title']?></span></p>
                <h1 class="mb-0 bread"><?=$about_page['title']?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
	<div class="container">
		<div class="row">
			<div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?=base_url('uploads/').$about_page['primary_image']?>);">
				<?php /*<a href="https://www.youtube.com/watch?v=YAOaPtNI4hk" class="icon popup-vimeo d-flex justify-content-center align-items-center"> */?>
        <a href="https://www.youtube.com/watch?v=qHB0wJ0IRNE" class="icon d-flex justify-content-center align-items-center">
					<span class="icon-play"></span>
				</a>
			</div>
			<div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
	          	<?=$about_page['description']?>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
		<div class="container">
    <div class="row no-gutters ftco-services">
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-shipped"></span>
          </div>
          <div class="media-body">
            <h3 class="heading mb-1">Safe Delivery</h3>
            <span>With the best courier</span>
          </div>
        </div>      
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-diet"></span>
          </div>
          <div class="media-body">
            <h3 class="heading mb-1">Fresh Quality</h3>
            <span>Always Fresh With Vacuum Sealed</span>
          </div>
        </div>    
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-award"></span>
          </div>
          <div class="media-body">
            <h3 class="heading mb-1">High Quality</h3>
            <span>High Quality Sustainable Tilapia</span>
          </div>
        </div>      
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-customer-service"></span>
          </div>
          <div class="media-body">
            <h3 class="heading mb-1">Support</h3>
            <span>24/7 Support</span>
          </div>
        </div>      
      </div>
    </div>
  </div>
	</section>

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
  <div class="container py-4">
    <div class="row d-flex justify-content-center py-5">
      <div class="col-md-6">
        <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
        <span>Get e-mail updates about our latest tilapia and special offers</span>
      </div>
      <div class="col-md-6 d-flex align-items-center">
        <form class="subscribe-form">
          <div class="form-group d-flex">
            <input type="text" data-toggle="modal" data-target="#subscriber-modal" class="form-control subscribe-input-to-modal" placeholder="Enter email address">
            <input type="submit" value="Subscribe" class="submit px-3">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>