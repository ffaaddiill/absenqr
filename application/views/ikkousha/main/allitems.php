<div id="menu" class="section lb">
    <div class="container-fluid">
        <div class="section-title text-center">
            <h3>Menu</h3>
            <p>Choose your favourite food and beverage bellow.</p>
        </div><!-- end title -->

        <div class="row">
            <?php $this->load->view(TEMPLATE_DIR.'/main/sub-main-menu.php'); ?>
            <?php if(!empty($full_item_img)): ?>
                <p align="center" style="width: 100%"><img class="full-item img-fluid" src="<?=$full_item_img?>" /></p>
            <?php else: ?>
                <div class="col-md-12">
                    <div class="services-inner-box">
                        <div class="ser-icon">
                            <p style="color:#fff;">No image found</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->