<div class="hero inner-page" style="background-image: url('<?=ASSETS_URL?>images/hero_1_a.jpg');background-position-y:15%">
    <div class="container">
        <div class="row align-items-end ">
            <div class="col-lg-5">
                <div class="intro">
                    <h1><strong>Form Sewa Mobil</strong></h1>
                    <div class="custom-breadcrumbs"><a href="index.html">Home</a> <span class="mx-2">/</span> <strong>Sewa Mobil</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section bg-light" id="contact-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-7 text-center mb-5">
                <h2>Gunakan Form untuk Melakukan Pemesanan.</h2>
                <p>Semua kolom bersifat mandatory dan wajib dilengkapi. Isi data anda secara benar.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 mb-5" >

                <?php echo form_open('','class="trip-form" style="background:none !important"'); ?>
                <form action="" method="post" class="trip-form" style="background: none !important">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-control-wrap">
                                <input type="text" id="cf-3" name="start_date" placeholder="Pick up" class="form-control datepicker px-3">
                                <span class="icon icon-date_range"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-control-wrap">
                                <input type="text" id="cf-4" name="end_date" placeholder="Drop off" class="form-control datepicker px-4">
                                <span class="icon icon-date_range"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <select name="id_product" class="custom-select form-control">
                                <option value="">Pilih Mobil</option>
                                <?php foreach($product as $key=>$val): ?>
                                <option value="<?=$val['id_product']?>" <?=(!empty($this->uri->segment(2)) && $this->uri->segment(2) == $val['id_product'])?'SELECTED':''?>><?=$val['title']?> <?=(isset($val['area_name']) && !empty($val['area_name']))?' - Area '.$val['area_name']:'-'?> <?=(isset($val['package_name']) && !empty($val['package_name']))?'('.$val['package_name'].')':''?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 mb-4 mb-lg-0">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" <?=(isset($quick_booking_nama))?'value="'.$quick_booking_nama.'"':''?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="number" name="hp" class="form-control" placeholder="Nomor Telepon" <?=(isset($quick_booking_hp))?'value="'.$quick_booking_hp.'"':''?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" placeholder="Alamat email" <?=(isset($quick_booking_email))?'value="'.$quick_booking_email.'"':''?>>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <?php if(isset($form_message)): ?>
                            <?=$form_message?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12 mr-auto text-center">
                            <input type="submit" class="btn btn-primary text-white py-3 px-5" value="Booking Sekarang">
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            
        </div>
    </div>
</div>

<div id="form-message" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?=$form_message?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>