<script type="text/javascript">
    function setGalleryImage(galleryimg) {
        $('#showup-img-gallery').attr('src', galleryimg);
    }
</script>
<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/blog-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span>Ourfarm Gallery</span></p>
                <h1 class="mb-0 bread">Ourfarm Gallery</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section bg-light">
	<div class="container">
		<div class="row">
			<?php foreach($gallery_ourfarm as $key=>$val): ?>
			<div class="col-md-12 outer-gallery-page">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-12">
										
										<img src="<?=base_url()?>uploads/<?=$val['primary_image']?>" class="img-fluid img-gallery mr-3" alt="<?=$val['title']?>">
										<div class="product-more-hover">
											<a class="btn btn-sm btn-warning color-white" href="javascript:void(0)" onclick="setGalleryImage('<?=base_url()?>uploads/<?=$val['primary_image']?>')" data-toggle="modal" data-target="#showup-modal-gallery"><i class="fas fa-search-plus"></i></a>
										</div>
									</div>
								</div>
							</div>
							<div class="col inner-gallery d-flex">
					            <h5 class="mt-0 mb-1 d-flex align-items-center"><?=$val['title']?></h5>
					            <p><?=$val['description']?></p>
							</div>
						</div>
					</div>
				</div>
				<hr class="my-2">
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="showup-modal-gallery" tabindex="-1" role="dialog" aria-labelledby="showup-modal-gallery" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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