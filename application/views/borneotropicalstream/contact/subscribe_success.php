<?php if($this->session->flashdata('success_msg')==1): ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/images/aboutus-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span>Notification</span></p>
                <h1 class="mb-0 bread">Notification</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section ftco-degree-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 ftco-animate">
        <div class="row">
          <div class="col-md-12">
            <h2 class="mt-4 mb-0"><i class="fa fa-check ok-check mr-2"></i>You have been registered for the subscription</h2>
          </div>
        </div>
      </div>
      <!-- .col-md-8 -->
      <div class="col-lg-4 sidebar ftco-animate">
        <div class="sidebar-box">
          <?php echo form_open(base_url().'search','role="form" class="search-form"'); ?>
            <div class="form-group">
              <button type="submit" class="icon ion-ios-search" style="background:none; border:none;cursor:pointer"></button>
              <input type="text" name="keyword" class="form-control" placeholder="Search...">
            </div>
          <?php echo form_close(); ?>
        </div>
        <div class="sidebar-box ftco-animate">
          <h3 class="heading">Categories</h3>
          <ul class="categories">
            <?php foreach($categories_arr as $key=>$val): ?>
              <li><a href="<?=base_url('blog/').$val['slug']?>"><?=$val['category_name']?> <span>(<?=$val['number_of_news']?>)</span></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- .section -->
<?php else: ?>
  <?php redirect(base_url().'contact') ?>
<?php endif; ?>