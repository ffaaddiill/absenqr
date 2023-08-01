<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Big TV Prabayar</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="language" content="en" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript" src="<?= JS_URL ?>jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?= JS_URL ?>bigtv.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>


        <!-- bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL ?>bootstrap/bootstrap.css" />
        <!-- <link rel="stylesheet" type="text/css" href="<?= CSS_URL ?>bootstrap/bootstrap-responsive.css" media="screen" /> -->
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL ?>bootstrap/yiistrap.css" />

        <script type="text/javascript" src="<?= JS_URL ?>jquery.yiiactiveform.js"></script>
        <script type="text/javascript" src="<?= JS_URL ?>isotope.pkgd.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?= CSS_URL ?>jquery.custom-scrollbar.css"/>
        <link href="<?= CSS_URL ?>style.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            body { padding-top: 80px; }
            #big-header {
                width: 100%;
            }
            #topmenu > .navbar-nav > li > a {
                font-size: 11px;
            }
            .footer {position:relative !important;bottom:0 !important;}
            .sprite-ig{
                background-position: -327px -9px;
                height: 47px;
                width: 50px;
            }
            .sprite-fb{
                background-position: -158px -9px;
                height: 47px;
                width: 50px;
            }
            .sprite-tw{
                background-position: -215px -9px;
                height: 47px;
                width: 50px;
            }
            .sprite-yt{
                background-position: -270px -9px;
                height: 47px;
                width: 50px;
            }
        </style>
        <script type="text/javascript">
            var token_name = '<?=$this->security->get_csrf_token_name()?>';
            var token_key = '<?=$this->security->get_csrf_hash()?>';
        </script>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-53957956-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <div id="big-header" class="navbar navbar-default navbar-static-top navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topmenu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><img src="<?= IMG_URL ?>new.png" /></a>
                </div>
                <div class="navbar-collapse collapse" id="topmenu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Tentang Prabayar</a>                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?=site_url('info-pra-bayar')?>">Info Prabayar</a></li>
                                <li><a href="<?=site_url('info-paket')?>">Info Paket</a></li>
                                <li><a href="<?=site_url('info-channel')?>">Info Channel</a></li>
                                <li><a href="<?=site_url('perangkat')?>">Perangkat</a></li>                                
                                <li><a href="<?=site_url('faq')?>">FAQ</a></li>
                                <li><a href="<?=site_url('contact')?>">Kontak</a></li>
                            </ul>
                        </li>
                        <li><a class="" href="<?=site_url('distributor-dealer')?>">Distributor & Dealer</a></li>
                        <li><a class="" href="<?=site_url('promo-news')?>">Promo</a></li>
                        <li><a class="" href="/index.php/customer">Isi Saldo/Beli Paket</a></li>
                        <li><a class="" href="<?=site_url('panduan')?>">Panduan</a></li>
                        <li><a class="" href="/index.php/activation">Aktivasi</a></li>
                        <!--li><a class="" href="/index.php/mitra">Mitra</a></li-->
                    </ul>
                    <!--<form class="navbar-form navbar-right" role="search">
                        <div class="form-group box-search">
                        <input type="text" class="form-control" placeholder="Search">
                        <button type="submit">Go</button>
                        </div>
                    <!--                        <button type="submit" class="btn btn-default">Submit</button>--
                    </form>-->
                    <a href="http://bigtvhd.com/pra/beli" class="btn-beli btn-beli-primary">Beli Sekarang</a>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
        <!-- CONTENT AREA BEGIN HERE -->

            <?=$content?>

        <!-- END OF CONTENT AREA -->
        </div>
        
        <div class="footer">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-5">
                                <div class="sprite-logofooter"></div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="float:left;"><h4 style="margin:0;font-size:15px;">Connect With Us from BIGTV</h4></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div style="float:left;margin-right:5px;"><a href="#" target="_blank"><div class="sprite-fb"></div></a></div>
                                        <div style="float:left;margin-right:5px;"><a href="#" target="_blank"><div class="sprite-tw"></div></a></div>
                                        <div style="float:left;margin-right:5px;"><a href="#" target="_blank"><div class="sprite-yt"></div></a></div>
                                        <div style="float:left;margin-right:5px;"><a href="https://instagram.com/bigtivi/" target="_blank"><div class="sprite-ig"></div></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12" style="font-size:12px;color:#f0ed00; margin-top:5px;text-align:justify;">
                                © 2014 PT. Indonesia Media Televisi. All Right Reserved. Partnership | Corporate. Disclaimer: Semua Paket, Harga, dan Channel dapat berganti sewaktu-waktu tanpa pemberitahuan.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="margin:0;font-size:15px;">Call Center</h4>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="call-center">
                                            <li>
                                                <div class="sprite-phone"></div>
                                                Matrix : 0804 1 628 749
                                                <br>
                                                Tanaka : (021) 628 6289
                                                <br>
                                                BIGTV Prabayar HD : 0804 1 222 222
                                                <br>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">                      
                                        <ul class="call-center">
                                            <li>
                                                <div class="sprite-message"></div>
                                                Matrix : support@matrixparabola.com
                                                <br>
                                                Tanaka : cs@tanaka.co.id
                                                <br>
                                                BIGTV Prabayar HD : customer.service@bigtv.co.id
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
        </div>
        
        <script src='<?= JS_URL ?>jquery.custom-scrollbar.js' type="text/javascript" charset="utf-8"></script>
        <script>
            $(document).ready(function () {
                var content = $('#content');
                var slider = $('#carousel-example-generic');
                if (content.height() + slider.height() < ($(window).height() - 312)) {
                    var footer = $('.footer');
                    footer.css({'position': 'fixed', 'bottom': 0, 'width': '100%'});
                }
                $('[class*="bigscroll"]').customScrollbar({
                    //skin: "default-skin", 
                    hScroll: false,
                    updateOnWindowResize: true
                });
                $('.carousel').carousel({interval: 4000});
                var ww = $(window).width();
                if (ww >= 1920) {
                    $('#content').css({'min-height': '500px'});
                }
                else if (ww >= 1024) {
                    $('.navbar-nav .dropdown').hover(function () {
                        $(this).addClass('active');
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideDown();
                    }, function () {
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideUp();
                        $(this).removeClass('active');
                    });
                }
                
                // set menu affix
                /*$('#big-header').affix({
                    offset: {
                        top: 0,
                        bottom: function () {
                            return (this.bottom = $('.footer').outerHeight(true));
                        }
                    }
                });*/
            });
        </script>
        <script type="text/javascript" src="<?= JS_URL ?>bootstrap.min.js"></script>
    </body>
</html>
