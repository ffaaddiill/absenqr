<script type="text/javascript">
    function setGalleryImage(galleryimg) {
        $('#showup-img-gallery').attr('src', galleryimg);
    }

   	var VID = '';
    function setVideo(param) {
    	console.log('videoid: ' + $(param).data('videoid'));
    	var modal_video = $(param).data('target');
    	var video_url = $(param).data('video-url');
    	//$('#iframe-video').attr('src',video_url + "?enablejsapi=1&autoplay=1&origin=<?=base_url()?>");

    	//$(document).ready(function() {
    		//$(modal_video).on('shown.bs.modal', function (e) {
					VID = $(param).data('videoid');
					console.log('VID:'+VID);
				  //function generateYT() {
					  // 2. This code loads the IFrame Player API code asynchronously.
					  
					    
						// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
						//$('#iframe-video').attr('src',video_url + "?enablejsapi=1&autoplay=1&origin=<?=base_url()?>");
						//generateYT(VID);
				//});
    	//});
				
    }
</script>
<section id="section-carousel">
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<div class="col-md-12">
				<div id="carouselHomeslider" class="carousel slide" data-interval="false">
				  <div class="carousel-inner">
				  	<?php foreach($top_slideshow as $key=>$val): ?>
				  	<?php if($val['image_only']): ?>
				    <div class="carousel-item <?=$key==0?'active':''?>">
				      <img class="d-block w-100" src="<?=base_url()?>uploads/<?=$val['primary_image']?>" alt="Slide <?=$key?>">
				    </div>
				  	<?php elseif($val['is_video']): ?>
				  	<script type="text/javascript">
				  		
				  	</script>
				  	<div class="carousel-item <?=$key==0?'active':''?>">
				  		<a class="video-overlay" onclick="setVideo(this)" data-backdrop="static" data-toggle="modal" data-videoid="<?=youtubeVideoID($val['video_url'])?>" data-video-url="<?=$val['video_url']?>" data-target="#showup-modal-video" href="#"></a>
				  		<div class="embed-responsive embed-responsive-21by9">
				  			<iframe class="embed-responsive-item" width="1280" height="720" src="<?=$val['video_url']?>?autoplay=0" allowfullscreen></iframe>
				  		</div>
				  	</div>
				    <?php else: ?>
				    <div class="carousel-item <?=$key==0?'active':''?>">
				      <img class="d-block w-100" src="<?=base_url()?>uploads/<?=$val['primary_image']?>" alt="Slide <?=$key?>">
				      <div class="carousel-caption d-block">
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
			</div>
		</div>
	</div>
</section>
<section class="ftco-section">
	<div class="container">
		<div class="row no-gutters ftco-services">
      <div class="col-xs-6 col-sm-3 col-md-3 text-center d-flex align-self-stretch ftco-animate">
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
      <div class="col-xs-6 col-sm-3 col-md-3 text-center d-flex align-self-stretch ftco-animate">
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
      <div class="col-xs-6 col-sm-3 col-md-3 text-center d-flex align-self-stretch ftco-animate">
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
      <div class="col-xs-6 col-sm-3 col-md-3 text-center d-flex align-self-stretch ftco-animate">
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

<section class="ftco-section gallery-tilapia pb-0">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
      	<span class="subheading">Product Gallery</span>
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
				<a class="gallery-overlay" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"></a>
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6 col-lg-4 ftco-animate">

				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="<?=base_url().$gallery_slug?>">VIEW MORE &rsaquo;&rsaquo;</a>
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
      	<span class="subheading">Farm Gallery</span>
        <h2 class="mb-1">Our Farm</h2>
        <p>Breeding and harvesting in natural environment</p>
      </div>
    </div>   		
	</div>
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<?php foreach($gallery_ourfarm as $key=>$val): ?>
			<?php if($key != (count($gallery_ourfarm)-1)): ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<a class="gallery-overlay" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"></a>
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="<?=base_url().$gallery_ourfarm_slug?>">VIEW MORE &rsaquo;&rsaquo;</a>
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

<section class="ftco-section gallery-tilapia pb-0">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate"> 
      	<span class="subheading">R&D Gallery</span>
        <h2 class="mb-1">Our Hatchery and R&D</h2>
        <p>The Research and Development method in our lab creates the best quality Tilapia</p>
      </div>
    </div>   		
	</div>
	<div class="container-fluid px-0">
		<div class="row no-gutters">
			<?php foreach($gallery_hatcherylab as $key=>$val): ?>
			<?php if($key != (count($gallery)-1)): ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<a class="gallery-overlay" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"></a>
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="#" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="outer-img-gallery">
					<img class="img-fluid" src="<?=base_url()?>uploads/<?=$val['primary_image']?>">
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6 col-lg-4 ftco-animate">
				<div class="product-more-hover">
					<a class="btn btn-sm btn-warning color-white" href="<?=base_url().$gallery_hatcherylab_slug?>">VIEW MORE &rsaquo;&rsaquo;</a>
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

<!-- Modal -->
<div class="modal fade" id="showup-modal-gallery" tabindex="-1" role="dialog" aria-labelledby="showup-modal-gallery" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 0;">
      <div class="modal-header" style="border-top-left-radius: 0; border-top-right-radius: 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <img id="showup-img-gallery" class="img-fluid" src="">
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showup-modal-video" tabindex="-1" role="dialog" aria-labelledby="showup-modal-video" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 0;">
      <button type="button" class="close btn-modal-video-close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
				<!-- <div class="embed-responsive embed-responsive-16by9">
				  <iframe id="iframe-video" class="embed-responsive-item" src="" allowfullscreen></iframe>
				</div> -->
					<div class="embed-responsive embed-responsive-16by9">
						<div id="iframe-video" class="iframe-video"></div>
					</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // 3. This function creates an <iframe> (and YouTube player)
  //    after the API code downloads.
  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('iframe-video', {
      width: '1920',
      height: '1080',
      videoId: 'qHB0wJ0IRNE',
      playerVars: {
        'playsinline': 1
      },
      rel: 0,
      modestbranding: 1,
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  }

  // 4. The API will call this function when the video player is ready.
  function onPlayerReady(event) {
    //event.target.playVideo();
    //event.target.loadVideoById('qHB0wJ0IRNE');
  }

  // 5. The API calls this function when the player's state changes.
  //    The function indicates that when playing a video (state=1),
  //    the player should play for six seconds and then stop.
  var done = false;
  function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
      //setTimeout(stopVideo, 2000);
      $('#showup-modal-video').on('hide.bs.modal', function (e) {
      	pauseVideo();
      });
      done = true;
    }
  }

  function stopVideo() {
    player.stopVideo();
  }

  function pauseVideo() {
    player.pauseVideo();
  }
</script>

<script type="text/javascript">
	// $(document).ready(function() {
  //   $('#showup-modal-video').on('hide.bs.modal', function (e) {
  //   	//player.stopVideo();
	// 	});
  // });
</script>