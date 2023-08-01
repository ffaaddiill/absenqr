<div class="hero inner-page" style="background-image: url('<?=ASSETS_URL?>images/hero_1_a.jpg');">
    <div class="container">
        <div class="row align-items-end ">
            <div class="col-lg-12">
                <div class="intro">
                    <h1><strong><?=$product['title']?></strong></h1>
                    <div class="pb-4"><strong class="text-black"><?=indonesian_date($product['publish_date'])?> &bullet; By Admin</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 blog-content">
                <img src="<?=base_url().'uploads/'.$product['primary_image']?>" class="mr-3 mb-3 img-fluid single-page-product" alt="<?=(isset($product['title']) && !empty($product['title']))?$product['title']:'Rental Mobil Jakarta dan Sewa Mobil Jakarta'?>">
                    <?php if(isset($product['description'])): ?>
                            <?=$product['description']?>
                        <?php endif; ?>
            </div>
            <div class="col-md-4 sidebar">
                <div class="sidebar-box">
                    <form action="#" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                        </div>
                    </form>
                </div>
                <div class="sidebar-box">
                    <div class="categories">
                        <h3>Sewa Mobil Lainnya</h3>
                        <?php foreach($products as $product_item): ?>
                            <li>
                                <a href="<?=base_url()?>sewa-mobil/<?=$product_item['id_product']?>/<?=$product_item['slug']?>"><?=$product_item['title']?><?=(isset($product_item['package_name']))?'('.$product_item['package_name'].')':''?>
                                    <span class="font-size-14"><?=$product_item['area_name']?></span>
                                </a>

                            </li>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="sidebar-box">
                    <img src="<?=base_url().ASSETS_URL?>img/admin.jpg" alt="Rental Mobil Jakarta dan Sewa Mobil Jakarta" class="img-fluid mb-4 rounded-circle single-page-admin-img">
                    <h3 class="text-black">Tentang Penulis</h3>
                    <p>Terdapat banyak sewa mobil di jakarta. Sewa mobil terbaik di jakarta adalah Aliza yang mempunyai armada terbaik dan berpengalaman lebih dari 10 tahun.</p>
                </div>
                
            </div>
        </div>
    </div>
</div>