<script type="text/javascript">
var widget1;
var widget2;
var widget3;
var widget4;
    var CaptchaCallback = function(){
        widget1 = grecaptcha.render('RecaptchaField1', {'sitekey' : '6LfG1QoTAAAAAFYD84Awf0djtz1Yet82oXWj2Smv'});
        widget2 = grecaptcha.render('RecaptchaField2', {'sitekey' : '6LfG1QoTAAAAAFYD84Awf0djtz1Yet82oXWj2Smv'});
        widget3 = grecaptcha.render('RecaptchaField3', {'sitekey' : '6LfG1QoTAAAAAFYD84Awf0djtz1Yet82oXWj2Smv'});
        widget4 = grecaptcha.render('RecaptchaField4', {'sitekey' : '6LfG1QoTAAAAAFYD84Awf0djtz1Yet82oXWj2Smv'});
    };
</script>

<!-- CONTENT AREA BEGIN HERE -->

<div class="row customer" id="content">
    <div class="col-md-12"><h1 class="header">Pelanggan</h1></div>
    <div class="col-md-6 gray-skin">
        <img class="img-responsive" src="<?= UPLOADS_URL ?>/images/PHOTO-553f15267bf91.jpg" alt="">
    </div>
    <div class="col-md-6">

        <div class="panel-group accordion-customer" id="accordion">
            <!-- isi saldo voucher fisik -->
            <div class="panel panel-default">
                <div class="panel-heading showoff">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                            Isi Saldo (Dengan Voucher Fisik)
                        </a>
                    </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse">
                    <div class="panel-body" style="padding:15px 15px 0 15px">
                        <div class="box-customer">
                            <div class="panel-group sub-menu" id="accordion2">
                                <div class="row">
                                    <div class="col-md-12" style="padding:0 25px 0 25px;">
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="BIGTV ID" name='isi_customer_nbr' id='isi_customer_nbr'>
                                                e.g. 3 XXX XXX XXX (untuk STB BIGTV HD), 6 XXX XXX XXX (untuk STB Matrix), 7 XXX XXX XXX (untuk STB Tanaka)
                                            </div>  
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Kode Voucher" name='isi_voucher' id='isi_voucher'>
                                            </div>                                      
                                           
                                            <div class="form-group">
                                                <div id="RecaptchaField1"></div>
                                            </div>
                                            <div class="action-submit" style="text-align: center;">
                                                <input type="text" class="btn btn-default btn-green" value="Submit" name='btnIsi' id='btnIsi'/>
                                            </div>                      
                                        </form>                         
                                    </div>
                                </div>
                            </div>                  
                        </div>
                    </div>
                </div>
            </div><!-- isi saldo voucher fisik -->
            <!-- isi saldo online -->
            <div class="panel panel-default">
                <div class="panel-heading showoff">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                            Isi Saldo (Lewat Online)
                        </a>
                    </h4>
                </div>
                <div id="collapseSeven" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box-customer">
                            <div class="row">
                                <div class="col-md-12" style="padding:10px 25px;">
                                    <!--<form>-->
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option selected="">Metode Pembayaran</option>
                                            <!--<option>Transfer</option>-->
                                            <option>Online</option>
                                        </select>
                                    </div>  
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="bigtvID" placeholder="BIGTV ID">
                                        e.g. 3 XXX XXX XXX (untuk STB BIGTV HD), 6 XXX XXX XXX (untuk STB Matrix), 7 XXX XXX XXX (untuk STB Tanaka)
                                                                 
                                    </div>
                                    <div class="form-group">
                                        <div id="RecaptchaField2"></div>                          
                                    </div>
                                    <div class="action-submit" style="text-align: center;">
                                        <input type="text" class="btn btn-default btn-green" id="btnSubmit" value="Submit" />
                                    </div>                      
                                    <!--</form>-->                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- isi saldo online -->
            <!-- pilih / beli paket -->
            <div class="panel panel-default">
                <div class="panel-heading showoff">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            PILIH / beli PAKET
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box-customer">
                            <div class="panel-group sub-menu" id="accordion2">
                                <div class="row">
                                    <div class="col-md-12" style="padding:0 25px 0 25px;">
                                        <form>
                                            <div class="form-group">
                                                <input type="text" name="customer_nbr" id="customer_nbr" class="form-control" placeholder="BIGTV ID">
                                                e.g. 3 XXX XXX XXX (untuk STB BIGTV HD), 6 XXX XXX XXX (untuk STB Matrix), 7 XXX XXX XXX (untuk STB Tanaka)
                                            </div>  
                                            <!--<div class="form-group">
                                                    <input type="text" name="imtv_number" id="imtv_number" class="form-control" placeholder="Nomer IMTV">
                                                    e.g. 1XX XXX XXX XXX XXX
                                            </div>  
                                            <div class="form-group">
                                                    <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
                                                    e.g 09092013 (DDMMYYYY)
                                            </div>  -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <!--<div class="col-md-6">
                                                          <input type="text" name="plan_code" id="plan_code" class="form-control" placeholder="Kode Paket"> 
                                                    </div>-->
                                                    <div class="col-md-6" id="plan_code_list">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="lihatChPaket" style="width:100%;height:34px;padding-top:5px; font-size:14px; background:#fff;text-align:center; cursor:pointer;">
                                                            Lihat Channel Per Paket
                                                        </div>
                                                    </div>
                                                </div>                          
                                            </div>
                                            <div class="form-group">
                                                <div class="row">


                                                </div>
                                            </div>
                                            <div class="action-submit" style="text-align: center;">
                                                <input type="submit" name="btnBuy" id="btnBuy" class="btn btn-default btn-green" value="Submit" />
                                            </div>                      
                                        </form>                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- pilih / beli paket -->
            <!-- cek saldo -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Cek Saldo
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box-customer">
                            <div class="panel-group sub-menu" id="accordion2">
                                <div class="row">
                                    <div class="col-md-12" style="padding:0 25px 0 25px;">
                                        <form role="form" id="cek-saldo" action="/index.php/customer" method="post"> 
                                            <div class="form-group">
                                                <input class="form-control" id="bigtvIDa" placeholder="BIGTV ID" name="CekSaldo[paket_id]" type="text">
                                                e.g. 3 XXX XXX XXX (untuk STB BIGTV HD), 6 XXX XXX XXX (untuk STB Matrix), 7 XXX XXX XXX (untuk STB Tanaka)
                                                <div class="errorMessage" id="CekSaldo_paket_id_em_" style="display:none"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div id="RecaptchaField3"></div>                          
                                            </div>
                                            <div class="action-submit" style="text-align: center;">
                                                <input class="btn btn-default btn-green" id="btnCheckSaldo" type="text" name="yt0" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- cek saldo -->
            <!-- cek paket aktif -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            CEK PAKET AKTIF
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box-customer">
                            <div class="panel-group sub-menu" id="accordion2">
                                <div class="row">
                                    <div class="col-md-12" style="padding:0 25px 0 25px;">
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="bigtvIDb" placeholder="BIGTV ID">
                                                e.g. 3 XXX XXX XXX (untuk STB BIGTV HD), 6 XXX XXX XXX (untuk STB Matrix), 7 XXX XXX XXX (untuk STB Tanaka)
                                            </div>  
                                            <div class="form-group">
                                                <div id="RecaptchaField3"></div>                          
                                            </div>
                                            <div class="action-submit" style="text-align: center;">
                                                <input type="submit" class="btn btn-default btn-green" id="btnCheckPaket" value="Submit" />
                                            </div>
                                            <div id='result_package'></div>
                                        </form>                         
                                    </div>
                                </div>                                          
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- cek paket aktif -->
        </div>
    </div>
</div>
</div>
<script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
<div id="overlay" style="display:none;position:fixed; top:0; z-index:9999; width:100%; height:100%; background:rgba(255,255,255,0.5);"></div>
<div id="overlay2" style="display:none; position:fixed; top:0; z-index:9999; width:100%; height:100%; background:rgba(255,255,255,0.5);">
</div>

<div id="divChPaket" style="top:10px;z-index:99999;width:100%;height:100%;position:fixed;margin:0 auto; display:none;">

    <div id="linkChPaket" style="width:800px;background:'<?= UPLOADS_URL ?>/images/paket_prepaid.jpg';margin:0 auto;z-index:99999999;overflow:scroll;">
        <img src="http://www.northcoastwineevent.com/wp-content/themes/infowaytheme/images/close-icon.png" style="position:absolute;padding-left:800px;top:5px;"/>
        <img id="imgChPaket" src="<?= UPLOADS_URL ?>/images/paket_prepaid.jpg" width="100%"/>
    </div>
</div>

<div id="loading" style="display:none;z-index:99999; top: 200px; position:fixed; left:45%; ">
    <div id="ballsWaveG">
        <div id="ballsWaveG_1" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_2" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_3" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_4" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_5" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_6" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_7" class="ballsWaveG">
        </div>
        <div id="ballsWaveG_8" class="ballsWaveG">
        </div>
    </div>
</div>
<div id='result_sms'></div>
<div id='result_aktivasi_sms'></div>
<div id='result_isi_saldo'></div>
<style>
    #ballsWaveG{
    position:relative;
    width:128px;
    height:30px}

    .ballsWaveG{
    position:absolute;
    top:0;
    background-color:#006800;
    width:16px;
    height:16px;
    -moz-animation-name:ballsWaveG;
    -moz-animation-duration:1.3s;
    -moz-animation-iteration-count:infinite;
    -moz-animation-direction:linear;
    -moz-border-radius:8px;
    -webkit-animation-name:ballsWaveG;
    -webkit-animation-duration:1.3s;
    -webkit-animation-iteration-count:infinite;
    -webkit-animation-direction:linear;
    -webkit-border-radius:8px;
    -ms-animation-name:ballsWaveG;
    -ms-animation-duration:1.3s;
    -ms-animation-iteration-count:infinite;
    -ms-animation-direction:linear;
    -ms-border-radius:8px;
    -o-animation-name:ballsWaveG;
    -o-animation-duration:1.3s;
    -o-animation-iteration-count:infinite;
    -o-animation-direction:linear;
    -o-border-radius:8px;
    animation-name:ballsWaveG;
    animation-duration:1.3s;
    animation-iteration-count:infinite;
    animation-direction:linear;
    border-radius:8px;
    }

    #ballsWaveG_1{
    left:0;
    -moz-animation-delay:0.52s;
    -webkit-animation-delay:0.52s;
    -ms-animation-delay:0.52s;
    -o-animation-delay:0.52s;
    animation-delay:0.52s;
    }

    #ballsWaveG_2{
    left:16px;
    -moz-animation-delay:0.65s;
    -webkit-animation-delay:0.65s;
    -ms-animation-delay:0.65s;
    -o-animation-delay:0.65s;
    animation-delay:0.65s;
    }

    #ballsWaveG_3{
    left:32px;
    -moz-animation-delay:0.78s;
    -webkit-animation-delay:0.78s;
    -ms-animation-delay:0.78s;
    -o-animation-delay:0.78s;
    animation-delay:0.78s;
    }

    #ballsWaveG_4{
    left:48px;
    -moz-animation-delay:0.91s;
    -webkit-animation-delay:0.91s;
    -ms-animation-delay:0.91s;
    -o-animation-delay:0.91s;
    animation-delay:0.91s;
    }

    #ballsWaveG_5{
    left:64px;
    -moz-animation-delay:1.04s;
    -webkit-animation-delay:1.04s;
    -ms-animation-delay:1.04s;
    -o-animation-delay:1.04s;
    animation-delay:1.04s;
    }

    #ballsWaveG_6{
    left:80px;
    -moz-animation-delay:1.17s;
    -webkit-animation-delay:1.17s;
    -ms-animation-delay:1.17s;
    -o-animation-delay:1.17s;
    animation-delay:1.17s;
    }

    #ballsWaveG_7{
    left:96px;
    -moz-animation-delay:1.3s;
    -webkit-animation-delay:1.3s;
    -ms-animation-delay:1.3s;
    -o-animation-delay:1.3s;
    animation-delay:1.3s;
    }

    #ballsWaveG_8{
    left:112px;
    -moz-animation-delay:1.43s;
    -webkit-animation-delay:1.43s;
    -ms-animation-delay:1.43s;
    -o-animation-delay:1.43s;
    animation-delay:1.43s;
    }

    @-moz-keyframes ballsWaveG{
    0%{
    background-color:#006800;
    }

    100%{
    background-color:#b1d249;
    }

    }

    @-webkit-keyframes ballsWaveG{
    0%{
    background-color:#006800;
    }

    100%{
    background-color:#b1d249;
    }

    }

    @-ms-keyframes ballsWaveG{
    0%{
    background-color:#006800;
    }

    100%{
    background-color:#b1d249;
    }

    }

    @-o-keyframes ballsWaveG{
    0%{
    background-color:#006800;
    }

    100%{
    background-color:#b1d249;
    }

    }

    @keyframes ballsWaveG{
    0%{
    background-color:#006800;
    }

    100%{
    background-color:#b1d249;
    }

    }

</style>

<script>
    $(function () {
        $('#imgChPaket').click(function () {
            window.open('<?=site_url("info-paket")?>');
        });
        $('#divChPaket').click(function () {
            $(this).hide();
            $('#overlay2').hide();
        });
        $('#linkChPaket').click(function () {
            // window.href.location = "http://prabayar.big-tv.com/info-paket";
        });
        $('#lihatChPaket').click(function () {
            $('#overlay2').appendTo('body').show();
            $('#divChPaket').appendTo('body').show();
            $('#linkChPaket').css('height', $(window).height() - 10);
        });
        $('#btnCheckSaldo').click(function () {
            var response_captcha = grecaptcha.getResponse(widget3);

            if(response_captcha){
                $('#overlay').appendTo('body').show();
                $('#loading').appendTo('body').show();
                var data = {
                    bigtvid: $('#bigtvIDa').val(),
                    flag: 'saldo'
                };
                var customer_nbr = $('#bigtvIDa').val();
                if (customer_nbr.length == 10) {
                    $.ajax({
                        type: 'POST',
                        data: data,
                        url: '<?=base_url()?>getcustomerbalance.php',
                        success: function (e) {
                            $('#overlay').appendTo('body').hide();
                            $('#loading').appendTo('body').hide();
                            alert(e);
                            location.reload();
                        }
                    });
                } else {
                    alert('Maaf data tidak valid.');
                    location.reload();
                }
            }else{
                alert('reCaptcha unsuccessfull. Please try again.');
            }
            
            return false;
        });

        $('#btnBuy').click(function () {
            $('#overlay').appendTo('body').show();
            $('#loading').appendTo('body').show();
            var data = {
                customer_nbr: $('#customer_nbr').val(),
                imtv_number: $('#imtv_number').val(),
                plan_code: $('#plan_code').val(),
                start_date: $('#start_date').val(),
                flag: 'buy'
            };
            var customer_nbr = $('#customer_nbr').val();
            if (customer_nbr.length == 10) {
                // alert(JSON.stringify(data));
                $.ajax({
                    type: 'POST',
                    data: data,
                    url: '<?=base_url()?>api_send_sms.php',
                    success: function (e) {
                        $('#overlay').appendTo('body').hide();
                        $('#loading').appendTo('body').hide();
                        $('#result_sms').html(e);
                    }
                });
            } else {
                alert('Maaf data tidak valid.');
                location.reload();
            }
            return false;
        });

        $('#btnIsi').click(function () {
            var response_captcha = grecaptcha.getResponse(widget1);

            if(response_captcha){
                $('#overlay').appendTo('body').show();
                $('#loading').appendTo('body').show();
                var data = {
                    customer_nbr: $('#isi_customer_nbr').val(),
                    voucher_code: $('#isi_voucher').val(),
                    flag: 'isi_voucher'
                };
                var customer_nbr = $('#isi_customer_nbr').val();
                if (customer_nbr.length == 10) {
                    $.ajax({
                        type: 'POST',
                        data: data,
                        url: '<?=base_url()?>api_send_sms.php',
                        success: function (e) {
                            $('#overlay').appendTo('body').hide();
                            $('#loading').appendTo('body').hide();
                            $('#result_isi_saldo').html(e);
                        }
                    });
                } else {
                    alert('Maaf data tidak valid.');
                    location.reload();
                }
            }else{
                alert('reCaptcha unsuccessfull. Please try again.');
            }
            
            return false;
        });

        $('#btnCheckPaket').click(function () {
            var response_captcha = grecaptcha.getResponse(widget4);
            if(response_captcha){
                $('#overlay').appendTo('body').show();
                $('#loading').appendTo('body').show();
                var data = {
                    bigtvid: $('#bigtvIDb').val(),
                    flag: 'paket'
                };
                var customer_nbr = $('#bigtvIDb').val();
                if (customer_nbr.length == 10) {
                    $.ajax({
                        type: 'POST',
                        data: data,
                        url: '<?=base_url()?>getcustomerbalance.php',
                        success: function (e) {
                            $('#overlay').appendTo('body').hide();
                            $('#loading').appendTo('body').hide();
                            // console.log(e);
                            // $('#result_package').html(e);
                            alert(e);
                            // alert($('#result_package').val());
                            location.reload();
                        }
                    });
                } else {
                    alert('Maaf data tidak valid.');
                    location.reload();
                }
            }else{
                alert('reCaptcha unsuccessfull. Please try again.');
            }
            
            return false;
        });

        $('#btnSubmit').click(function () {
            
            var response_captcha_2 = grecaptcha.getResponse(widget2);
           
            if(response_captcha2){
                window.open('http://my.big-tv.com/selfcare/top_up.php?id=' + $("#bigtvID").val(), '_blank');
            }else{
                alert('reCaptcha unsuccessfull. Please try again.');
            }
            
        });

        $.ajax({//create an ajax request to load_page.php
            type: "POST",
            url: "<?=base_url()?>getcustomerbalance.php",
            data: {flag: 'plancode'},
            dataType: "html", //expect html to be returned                
            success: function (response) {
                $("#plan_code_list").html(response);
            }

        });
    });
</script>

<!-- END OF CONTENT AREA -->