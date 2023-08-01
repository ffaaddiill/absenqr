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
            <div class="col-md-1">
                <img style="max-width: 100px" class="img-fluid" src="<?=base_url().IMG_URL?>success-image.png">
            </div>
            <div class="col-md-7 align-self-center text-center">
                <h4>Terimakasih, Segera cek kotak masuk email anda untuk menyelesaikan proses pesanan.</h4>
            </div>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-md-7 offset-md-1 text-center">
                <a href="<?=base_url()?>">Kembali ke home</a>
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