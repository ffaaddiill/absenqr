<div class="hero" style="background-image: url('<?=ASSETS_URL?>images/hero_1_a.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-5">
                    <div class="col-lg-12 col-md-12 intro text-center">
                        <h1><strong>Sewa Mobil</strong> hanya dengan jarimu.</h1>
                    </div>
                </div>
                <?php echo form_open(base_url().'form-sewa-mobil','role="form"'); ?>
                    <div class="row align-items-center trip-form">
                        <div class="mb-3 mb-md-0 col-md-3">
                            <div class="form-control-wrap">
                                <input type="text" name="nama" id="cf-5" placeholder="Nama Pemesan" class="form-control px-3">
                                <span class="icon icon-user"></span>
                            </div>
                        </div>
                        <div class="mb-3 mb-md-0 col-md-3">
                            <div class="form-control-wrap">
                                <input type="email" name="email" id="cf-5" placeholder="Email" class="form-control px-3">
                                <span class="icon icon-mail_outline"></span>
                            </div>
                        </div>
                        <div class="mb-3 mb-md-0 col-md-3">
                            <div class="form-control-wrap">
                                <input type="number" name="hp" id="cf-5" placeholder="Nomor Telepon" class="form-control px-3">
                                <span class="icon icon-phone"></span>
                            </div>
                        </div>
                        <div class="mb-3 mb-md-0 col-md-3">
                            <input type="submit" name="quick_booking" value="Pilih Mobil" class="btn btn-primary btn-sm btn-block py-3 cwhite">
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 text-center order-lg-2">
                <div class="img-wrap-1 mb-5">
                    <img src="<?=ASSETS_URL?>images/aliza-about-home-photo.png" alt="Rental Mobil Jakarta dan Sewa Mobil Jakarta" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-4 ml-auto order-lg-1">
                <h3 class="mb-4 section-heading"><strong>Aliza memudahkan anda memilih mobil sesuai kebutuhan anda.</strong></h3>
                <p class="mb-5">Aliza&nbsp;<a href="https://alizarentalmobil.com">rental mobil jakarta</a>&nbsp;adalah perusahaan penyedia jasa sewa mobil yang sudah terpercaya selama bertahun-tahun, sejak tahun 2015 sampai sekarang kami fokus dalam bidang jasa sewa mobil. Kami berdomisili di Jakarta sebagai kantor pusatnya dan selalu memberikan pelayanan terbaik bagi customer. Kenyamanan adalah&nbsp;prioritas aliza rental mobil.&nbsp;</p>
                <p><a href="<?=base_url()?>tentang-kami" class="btn btn-primary">Selengkapnya</a></p>
            </div>
        </div>
    </div>
</div>
<div class="site-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h2 id="list-mobil" class="section-heading"><strong>List Mobil</strong></h2>
                <p class="mb-5">Berikut adalah list mobil dalam dan luar kota. Armada utama kami adalah Toyota Innova Reborn, Toyota Innova Grand, dan Toyota Avanza</p>
            </div>
        </div>
        <div class="row">
            <?php foreach($list_mobil as $key=>$val): ?>
            <div class="col-md-6 col-lg-4 mb-4" style="padding-top: 20px !important">
                <div class="listing d-block h-100 align-items-stretch">
                    <div class="listing-img mr-4">
                        <img src="<?=base_url().NEWS_IMG_URL.$val['thumbnail_image']?>" alt="<?=(isset($val['title']) && !empty($val['title']))?$val['title']:'Rental Mobil Jakarta dan Sewa Mobil Jakarta'?>" class="img-fluid">
                    </div>
                    <div class="listing-contents h-100">
                        <h3><?=$val['title']?> <?=(isset($val['package_name']) && !empty($val['package_name']))?'('.$val['package_name'].')':''?></h3>
                        <div class="rent-price">
                            <strong>Rp <?=myprice($val['price'])?></strong><span class="mx-1">/</span>12 Jam
                        </div>
                        <div class="custom-charge-price">
                            <div>
                                Area : <?=(isset($val['area_name']) && !empty($val['area_name']))?$val['area_name']:'-'?>
                            </div>
                            <p>Lebih dari 12 Jam dikenakan overtime 10%</p>
                        </div>
                        <div class="d-block d-md-flex mb-3 border-bottom pb-3">
                            <div class="listing-feature pr-4">
                                <span class="caption">Driver:</span>
                                <span class="number<?=$val['is_driver']?>"><?=($val['is_driver']==1)?'Ya':'-'?></span>
                            </div>
                            <div class="listing-feature pr-4">
                                <span class="caption">BBM:</span>
                                <span class="number<?=$val['is_bbm']?>"><?=($val['is_bbm']==1)?'Ya':'-'?></span>
                            </div>
                            <div class="listing-feature pr-4">
                                <span class="caption">Tol:</span>
                                <span class="number<?=$val['is_tol']?>"><?=($val['is_tol']==1)?'Ya':'-'?></span>
                            </div>
                            <div class="listing-feature pr-4">
                                <span class="caption">parkir:</span>
                                <span class="number<?=$val['is_parkir']?>"><?=($val['is_parkir']==1)?'Ya':'-'?></span>
                            </div>
                        </div>
                        <div>
                            <?php if(isset($val['teaser']) && !empty($val['teaser'])): ?>
                            <p>
                                <?=$val['teaser']?>
                            </p>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-7 main-booking-btn-div">
                                    <a href="<?=base_url()?>form-sewa-mobil/<?=$val['id_product']?>" class="btn btn-primary btn-sm">Booking Sekarang</a>
                                </div>
                                <div class="col-md-5 text-center align-self-center">
                                    <a href="<?=base_url()?>sewa-mobil/<?=$val['id_product']?>/<?=$val['slug']?>" class="">Detail</a>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="site-section bg-primary py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-md-0">
                <h2 class="mb-0 text-white">Tunggu apa lagi?</h2>
                <p class="mb-0 opa-7">Nikmati promo dan harga terjangkau lainnya hanya di <a class="cwhite" href="<?=base_url()?>">Aliza Rental Mobil</a></p>
            </div>
            <div class="col-lg-5 text-md-right">
                <a href="<?=base_url()?>form-sewa-mobil" class="btn btn-primary btn-white">Booking Mobilmu Sekarang</a>
            </div>
        </div>
    </div>
</div>