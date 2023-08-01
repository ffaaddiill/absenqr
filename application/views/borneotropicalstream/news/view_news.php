<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/blog-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span>Blog</span></p>
                <h1 class="mb-0 bread"><?=$news['title']?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-degree-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 ftco-animate">
				<h2 class="mt-4 mb-0"><?=$news['title']?></h2>
        <div class="d-block mb-3" style="color: #919191"><a href="#" style="color: #919191">
          <?=date('l, F jS Y', strtotime($news['publish_date']))?></a>. Posted by Admin</div>
        <img class="img-fluid mb-3" src="<?=base_url()?>/uploads/<?=$news['primary_image']?>">
        <?=$news['description']?>
      </div> <!-- .col-md-8 -->
      <div class="col-lg-4 sidebar ftco-animate">
        <div class="sidebar-box mb-0">
          <?php echo form_open(base_url().'search','role="form" class="search-form"'); ?>
            <div class="form-group">
              <button type="submit" class="icon ion-ios-search" style="background:none; border:none;cursor:pointer"></button>
              <input type="text" name="keyword" class="form-control" placeholder="Search...">
            </div>
          <?php echo form_close(); ?>
        </div>
        <div class="sidebar-box pt-1 ftco-animate">
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
</section> <!-- .section -->