<style type="text/css">
	.margin-bottom{
	  margin-bottom: 10px;
	}
</style>
<div class="row" id="content">
    <div class="col-md-12">
        <h1 class="header">PROMO</h1>
    </div>
    <div class="col-md-12">
    <!--<h3 class="header">Berita</h3>-->
        <!-- start new layout -->
        <div class="row">

        	<?php foreach($promo_news as $news): ?>
	            <div class="col-md-4 margin-bottom">
	                <!--<a data-toggle="modal" data-target="#<?php echo  $list->slug; ?>" href="#">-->
	                <a href="<?= site_url('promo-news/detail/' . $news['id']) ?>">
	                	<?php if( $news['thumbnail_image'] ): ?>
	                    	<img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$news['thumbnail_image']?>" alt="Image" class="img-responsive">
	                    <?php else: ?>
	                    	<img src="<?= IMG_URL . 'no-img-thumbnail.png' ?>" class="img-responsive">
	                    <?php endif; ?>
	                    <div class="title" style="font-weight:bold;"><?=$news['title']?></div>
	                </a>
	            </div>
            <?php endforeach; ?>
        </div>
        <!-- end of new layout -->
    </div>
</div>
<script type="text/javascript" language="javascript" src="<?= JS_URL ?>jquery.carouFredSel-6.2.1-packed.js"></script>
<script type="text/javascript" language="javascript" src="<?= JS_URL ?>jquery.touchSwipe.min.js"></script>
<script type="text/javascript">
	$(window).ready(function(){
	   $('#listPromo a:first').tab('show')
	   $('#listPromo a').click(function (e) {
	      e.preventDefault()
	      $(this).tab('show')
	  });   

	   var overview = $('#listPromo').height();
	   if (overview > 200) {
	       $('#listPromo').css({'margin':'0 0 0 15px'});
	   }
	   $('#foo4').carouFredSel({
	    responsive: true,
	    width: '100%',
	    scroll: 2,
	    items: {
	        width: 250,
	                height: '130%',  //  optionally resize item-height
	                visible: {
	                    min: 1,
	                    max: 4
	                }
	            },
	            pagination  : "#foo4_page",
	            scroll : {
	                pauseOnHover : true,
	                duration : 2000
	            },
	            swipe: {
	                onMouse: true,
	                onTouch: true
	            }
	        });
	});
</script>