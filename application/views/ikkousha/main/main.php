<div id="menu" class="section lb">
    <div class="container-fluid">
        <div class="section-title text-center">
            <h3>Menu</h3>
            <p>Choose your favourite food and beverage bellow.</p>
        </div><!-- end title -->

        <div class="row">
            <?php $this->load->view(TEMPLATE_DIR.'/main/sub-main-menu.php'); ?>

            <?php if(!empty($food_beverage)): foreach($food_beverage as $key=>$val): ?>
            <div class="col-md-3">
                <div class="services-inner-box">
                    <div class="ser-icon">
                        <img src="<?=base_url().NEWS_IMG_URL.$val['thumbnail_image']?>" class="img-fluid" alt="<?=$val['title']?>" />
                    </div>
                    <h2><?=$val['title']?></h2>
                    <a class="hvr-radial-in" href="#">Rp. <?=myprice($val['price'])?></a>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-md-12">
                <div class="services-inner-box">
                    <div class="ser-icon">
                        <p style="color:#fff;">No food or beverage found</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->