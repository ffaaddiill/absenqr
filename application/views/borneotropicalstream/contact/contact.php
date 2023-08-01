<div class="hero-wrap hero-bread" style="background-image: url('<?=ASSETS_URL?>images/aboutus-banner-top.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> > <span><?=$contact_page['title']?></span></p>
                <h1 class="mb-0 bread"><?=$contact_page['title']?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="w-100"></div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Address:</span> <?=$contact['site_address']?></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Phone:</span> <a href="#"><?=$contact['phone']?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Email:</span> <a  style="font-size:13px" href="#"><?=$contact['email']?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Website</span> <a style="font-size:13px" href="<?=base_url()?>"><?=$contact['site_url']?></a></p>
                </div>
            </div>
        </div>
        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
                <?php echo form_open(base_url().'contact','role="form" class="bg-white p-5 contact-form"'); ?>
                    <?php /*
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    <input type="hidden" name="action" value="validate_captcha">
                    */ ?>

                    <div class="form-group">
                        <input type="text" name="customer_name" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="customer_email" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <input type="text" name="customer_subject" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea name="customer_message" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <div class="g-recaptcha" data-sitekey="6LdMvNIkAAAAAF6hwGnpg-lFMqDLZz0Mba42yPLj"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary py-3 px-5">Send Message</button>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-6 d-flex">
                <?=$contact['maps']?>
            </div>
        </div>
    </div>
</section>
