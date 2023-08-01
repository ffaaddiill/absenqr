<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/blog-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span>Blog</span></p>
                <h1 class="mb-0 bread">Blog</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section ftco-degree-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 ftco-animate">
        <div class="row">
          <!-- start blog -->
          <?php foreach($news_list as $key=>$val): ?>
          <div class="col-md-12 d-flex ftco-animate">
            <div class="blog-entry align-self-stretch d-md-flex pt-4">
              <a href="<?=base_url()?>blog/<?=$val['news_category_slug']?>/<?=$val['slug']?>" class="block-20" style="background-image: url('<?=base_url()."/uploads/".$val['primary_image']?>');">
              </a>
              <div class="text d-block pl-md-4">
                <div class="meta mb-3">
                  <div class="mb-0"><a href="#"><?=date('l, F jS Y', strtotime($val['publish_date']))?></a></div>
                  <div class="d-block" style="color: #919191"><a href="#" style="color: #919191">Category <?=$val['news_category_name']?></a>. Posted by Admin</div>
                  <a href="<?=base_url()?>blog/<?=$val['news_category_slug']?>/<?=$val['slug']?>">
                    <h3 class="heading">
                    <?=$val['title']?>
                    </h3>
                  </a>
                  <!--<div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>-->
                </div>
                <h3 class="heading"><a href="<?=base_url()?>blog/<?=$val['news_category_slug']?>/<?=$val['slug']?>"></a></h3>
                <p><?=$val['teaser']?></p>
                <p><a href="<?=base_url()?>blog/<?=$val['news_category_slug']?>/<?=$val['slug']?>" class="btn btn-primary py-2 px-3">Read more</a></p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <!-- end blog -->
        </div>
      </div>
      <!-- .col-md-8 -->
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
</section>
<!-- .section -->