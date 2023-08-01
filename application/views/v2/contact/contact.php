<div class="row" id="content">
    <div class="col-md-12">
        <h1 class="header" style="margin-bottom: 20px;">Kontak</h1>

        <!-- show this success message if contact form has been submited -->
        <div class="flash-success" style="display: none">
            
        </div>

        <!-- error message -->
        <div class="errorMessage" id="global-error-message" style="display: none">
            
        </div>
        
        <form method="post" role="form" id="contact-form">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" placeholder="nama" id="nama" name="nama" type="text" required>
                        <div class="errorMessage" id="nama_em" style="display:none"></div>                 
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" placeholder="email" id="email" name="email" type="email">
                        <div class="errorMessage" id="email_em" style="display:none"></div>                
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" placeholder="alamat" id="alamat" name="alamat" type="text">
                        <div class="errorMessage" id="alamat_em" style="display:none"></div>                   
                    </div>  
                    <div class="col-md-6">
                        <input class="form-control" placeholder="telepon" id="telepon" name="telepon" type="tel">
                        <div class="errorMessage" id="telepon_em" style="display:none"></div>                  
                    </div>
                </div>
            </div>
            <div class="form-group">
                <textarea rows="13" class="form-control" placeholder="pesan" id="pesan" name="pesan"></textarea>
                <div class="errorMessage" id="pesan_em" style="display:none"></div>
            </div>
            <div class="action-submit" style="text-align: right;">
                <input id="contact-submit-btn" type="submit" class="btn btn-default btn-green" value="Kirim">
            </div>              
        </form>

    </div><!-- form -->
</div>
<script>
    $(document).ready(function(){
        $('.navbar-nav .dropdown').hover(function() {
          $(this).addClass('active');
          $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideDown();
        }, function() {
          $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideUp();
          $(this).removeClass('active');
        });    
        var ww = $(window).width();
        var wh = $(window).height();
        var headBig = $('#big-header').height();
        var footBig = $('.footer').height();
        if (ww >= 1200 ) {
            $('#content').css({'min-height': wh - footBig - headBig - 30 +'px' });
        }   
    });

    $("#contact-submit-btn").click(function () {
            var self = $(this);
            var self_html = $(this).html();
            var nama = $('#nama').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            var telepon = $('#telepon').val();
            var pesan = $('#pesan').val();
            console.log(nama + ' ' + email + ' ' + alamat + ' ' + telepon + ' ' + pesan);

            var flag = true;

            var data = [
                {name:"nama",value:nama},
                {name:"email",value:email},
                {name:"alamat",value:alamat},
                {name:"telepon",value:telepon},
                {name:"pesan",value:pesan}
            ];
             
            ajax_post_form('<?=site_url("contact/save")?>',data,self)
                .done(function(response) {
                    //$('.message-callback-modal').html('');
                    self.html(self_html);
                    if (response['success']) {
                        $('#global-error-message').css('display', 'none');
                        $('.flash-success').css('display', 'block');
                        $('.flash-success').html('<?=alert_box("Thank you for contacting us. We will respond to you as soon as possible.", "success")?>');
                    } else {
                        console.log('error is not suckses');
                        $('#global-error-message').css('display', 'block');
                        $('.flash-success').css('display', 'none');
                        $('#global-error-message').html(response['error']);
                    }
                });
        });
</script>