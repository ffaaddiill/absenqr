<div id="carouselHomeslider" class="carousel slide" data-interval="false">
  
  <div class="carousel-inner">
  	<?php foreach($top_slideshow as $key=>$val): ?>
  	<?php if($val['image_only'] == 1): ?>
    <div class="carousel-item <?=$key==0?'active':''?>">
      <img class="d-block w-100" src="<?=base_url()?>uploads/<?=$val['primary_image']?>" alt="Slide <?=$key?>">
    </div>
    <?php else: ?>
    <div class="carousel-item">
      <img class="d-block w-100" src="<?=base_url()?>uploads/<?=$val['primary_image']?>" alt="Slide <?=$key?>">
      <div class="carousel-caption d-none d-md-block">
		    <div class="container">
	        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

	          <div class="col-md-12 ftco-animate text-center">
	            <h1 class="mb-2"><?=$val['title']?></h1>
	            <h2 class="subheading mb-4"><?=$val['teaser']?></h2>
	            <p><a href="<?=$val['url_link']?>" class="btn btn-primary">View Details</a></p>
	          </div>

	        </div>
	      </div>
		  </div>
    </div>
    <?php endif;?>
  	<?php endforeach; ?>
  </div>
  <a class="carousel-control-prev" href="#carouselHomeslider" role="button" data-slide="prev">
    <i class="slider-prev fas fa-chevron-circle-left"></i>
  </a>
  <a class="carousel-control-next" href="#carouselHomeslider" role="button" data-slide="next">
    <i class="slider-next fas fa-chevron-circle-right"></i>
  </a>
</div>

<!--
<section id="home-section" class="hero">
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<div class="col-md-12">
				<div class="home-slider owl-carousel">
			  	<?php foreach($top_slideshow as $key=>$val): ?>
			  	<?php if($val['image_only'] == 1): ?>
			  	<div class="slider-item" style="background: url(<?=ASSETS_URL?>images/bg-underwater.png);background-size: cover;background-position: bottom;">
			    	<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>" style="width: 1519px;height:auto;margin:0 auto;">
			    </div>
			  	<?php else: ?>

			    <div class="slider-item" style="background-image: url(<?=base_url()?>uploads/<?=$val['primary_image']?>);">
			    	<div class="overlay"></div>
			      <div class="container">
			        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

			          <div class="col-md-12 ftco-animate text-center">
			            <h1 class="mb-2"><?=$val['title']?></h1>
			            <h2 class="subheading mb-4"><?=$val['teaser']?></h2>
			            <p><a href="<?=$val['url_link']?>" class="btn btn-primary">View Details</a></p>
			          </div>

			        </div>
			      </div>
			    </div>
			  	<?php endif;?>
			  	<?php endforeach; ?>
			  </div>
			</div>
		</div>
	</div>
</section>
-->
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
            <h3 class="heading mb-1">Always Fresh</h3>
            <span>Product well package</span>
          </div>
        </div>    
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
        		<span class="flaticon-award"></span>
          </div>
          <div class="media-body">
            <h3 class="heading mb-1">Superior Quality</h3>
            <span>Quality Products</span>
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

<!--
<section id="multiple-product-section" class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 heading-section text-center fadeInUp ftco-animated">
      	<span class="subheading color-primary" style="margin-bottom: 10px">Product Highlight</span>
      	<h2 class="mb-4">The Latest Tilapia</h2>
			</div>
			<div class="col-md-12 ftco-animated fadeInUp">
				<div id="multiple-product-slider" class="owl-carousel">
					<?php foreach($product_slideshow as $key=>$val): ?>
				  <div class="multiple-product-slider-img-wrap">
				  	<img src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				  </div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
-->

<section class="ftco-section gallery-tilapia pb-0">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
      	<span class="subheading">Gallery</span>
        <h2 class="mb-1">Our Tilapia</h2>
        <p>Raised using the pure waters from the Bornean rainforest</p>
      </div>
    </div>   		
	</div>
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<?php foreach($gallery as $key=>$val): ?>
			<?php if($key != (count($gallery)-1)): ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="#"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="<?=base_url()?>gallery">VIEW MORE &rsaquo;&rsaquo;</a>
				</div>	
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ftco-section gallery-ourfarm pb-0">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
      	<span class="subheading">Gallery</span>
        <h2 class="mb-1">Our Farm</h2>
        <p>Very large farms will allow fish to breed freely.</p>
      </div>
    </div>   		
	</div>
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<?php foreach($gallery_ourfarm as $key=>$val): ?>
			<?php if($key != (count($gallery_ourfarm)-1)): ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="#"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="<?=base_url()?>gallery">VIEW MORE &rsaquo;&rsaquo;</a>
				</div>	
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<hr>

<section id="upcoming-product" class="ftco-section pb-0" style="border-top:2px solid #fff"> 
	<div class="container">
		<div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate">
      	<span class="subheading">Stay Tuned !</span>
        <h2 class="mb-1">Upcoming Products</h2>
        <p>Our upcoming products will be launched soon.</p>
      </div>
    </div>   		
	</div>
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<div class="col-md-12">
				<img class="img-fluid img-banner-homepage" src="<?=base_url()?>uploads/<?=$banner_homepage['primary_image']?>">
			</div>
		</div>		
	</div>
</section>

<hr>

<?php /*
<section class="ftco-section ftco-partner section-our-market">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
      	<span class="subheading">Our Markets</span>
        <h2 class="mb-4">Find Us</h2>
      </div>

			<div class="col-sm ftco-animate">
				<a href="#" class="partner">
					<img class="img-fluid img-find-us" src="https://regalsprings.co.id/wp-content/uploads/2019/01/Lotte-Mart-Wholesale-1.png" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner">
					<img class="img-fluid img-find-us" src="https://regalsprings.co.id/wp-content/uploads/2019/01/carrefour-1.png" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner">
					<img class="img-fluid img-find-us" src="https://regalsprings.co.id/wp-content/uploads/2019/01/tiptop-1.png" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner">
					<img class="img-fluid img-find-us" src="https://regalsprings.co.id/wp-content/uploads/2019/01/Hypermart-1.png" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner">
					<img class="img-fluid img-find-us" src="https://regalsprings.co.id/wp-content/uploads/2019/01/Lion-Superindo-1.png" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
		</div>
	</div>
</section>
*/?>

<hr>

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
  <div class="container py-4">
    <div class="row d-flex justify-content-center py-5">
      <div class="col-md-6">
      	<h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
      	<span>Get e-mail updates about our latest tilapia and special offers</span>
      </div>
      <div class="col-md-6 d-flex align-items-center">
        <form action="#" class="subscribe-form">
          <div class="form-group d-flex">
            <input type="text" class="form-control" placeholder="Enter email address">
            <input type="submit" value="Subscribe" class="submit px-3">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>