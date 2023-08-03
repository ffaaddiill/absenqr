<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=get_site_info()['site_name']?></title>
        <!-- Bootstrap -->
        <link href="<?=ASSETS_URL?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?=ASSETS_URL?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?=ASSETS_URL?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?=ASSETS_URL?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?=ASSETS_URL?>build/css/custom.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>build/css/custom2.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet"/>
        <!-- Cropper -->
        <link href="<?=ASSETS_URL?>vendors/cropper/dist/cropper.min.css" rel="stylesheet">
        <!-- Datetimepicker style -->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS_URL?>vendors/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!-- DataTables -->
        <link href="<?=ASSETS_URL?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?=ASSETS_URL?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

        <!-- Global var js -->
        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var current_ctrl = '<?= current_controller() ?>';
            var current_url = '<?= current_url() ?>';
            var assets_url = '<?= ASSETS_URL ?>';
            var token_name = '<?=$this->security->get_csrf_token_name()?>';
            var token_key = '<?=$this->security->get_csrf_hash()?>';
            var objToken = {};
            objToken[token_name] = token_key;
        </script>

        <!-- Moment.js -->
        <script src="<?=ASSETS_URL?>vendors/bootstrap-datetimepicker/moment-with-locales.js"></script>

        <!-- CKEditor 4 -->
        <script src="<?=ASSETS_URL?>vendors/ckeditor/ckeditor.js"></script>

        <!-- jQuery -->
        <script src="<?=ASSETS_URL?>vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/ckeditor/adapters/jquery.js"></script>

        <script type="text/javascript">
            $(window).load(function(){
                //CKEDITOR.replace( 'teaser' );
                //CKEDITOR.replace( 'description' );
                $('#teaser').ckeditor();
                $('#description').ckeditor();
            });
        </script>

        <script src="<?=ASSETS_URL?>vendors/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
        <!-- DataTables JS -->
        <script src="<?=JS_URL?>custom.js"></script>

    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="index.html" class="site_title" <?=count(explode(' ', get_site_info()['site_name'] ?? ''))>2?'style="font-size: 15px"':''?>><i class="fa fa-flag"></i> <span><?=get_site_info()['site_name']?></span></a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="<?=ASSETS_URL?>img/img.jpg" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?=$ADM_SESSION['admin_name']?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- /menu profile quick info -->
                        <br />
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>Main Menu</h3>
                                <ul class="nav side-menu">
                                <?=$left_menu?>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url()?>logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <nav class="nav navbar-nav">
                            <ul class=" navbar-right">
                                <li class="nav-item dropdown open" style="padding-left: 15px;">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <?php /*<img src="images/img.jpg" alt="">*/?><?=$ADM_SESSION['admin_name']?>
                                    </a>
                                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item"  href="javascript:;"> Profile</a>
                                        <a class="dropdown-item"  href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                        </a>
                                        <a class="dropdown-item"  href="javascript:;">Help</a>
                                        <a class="dropdown-item"  href="<?=base_url()?>logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </div>
                                </li>
                                <?php /*
                                <li role="presentation" class="nav-item dropdown open">
                                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <div class="text-center">
                                                <a class="dropdown-item">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                */ ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main" style="min-height: 947px;">
                    <div class="">
                        <?=$content?>
                    </div>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        
        <!-- Bootstrap -->
        <script src="<?=ASSETS_URL?>vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Datetimepicker -->
        <script src="<?=ASSETS_URL?>vendors/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <!-- FastClick -->
        <script src="<?=ASSETS_URL?>vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?=ASSETS_URL?>vendors/nprogress/nprogress.js"></script>
        <!-- Datatables -->
        <script src="<?=ASSETS_URL?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="<?=ASSETS_URL?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/jszip/dist/jszip.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/pdfmake/build/vfs_fonts.js"></script>
        <!-- Cropper -->
        <script src="<?=ASSETS_URL?>vendors/cropper/dist/cropper.min.js"></script>
        <script src="<?=ASSETS_URL?>vendors/jquery-cropper/dist/jquery-cropper.min.js"></script>
        <?php /* <script src="<?=ASSETS_URL?>vendors/jquery-cropper/cropper_upload_function.js"></script>*/ ?>
        <!-- iCheck -->
        <script src="<?=ASSETS_URL?>vendors/iCheck/icheck.min.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="<?=ASSETS_URL?>build/js/custom.min.js"></script>
        <script type="text/javascript">
        
        $('#end_date').datetimepicker({
            locale: 'id-ID',
            format: 'DD-MM-YYYY hh:kk:ss'
        });

        $('#publish_date').datetimepicker({
            locale: 'id-ID',
            format: 'DD-MM-YYYY hh:kk:ss'
        });

        $('#tanggal_izin_start').datetimepicker({
            locale: 'id-ID',
            format: 'DD-MM-YYYY hh:kk:ss'
        });

        $('#tanggal_izin_end').datetimepicker({
            locale: 'id-ID',
            format: 'DD-MM-YYYY hh:kk:ss'
        });

        if($('#tanggal_izin_start').length > 0 ) {
            $('#tanggal_izin_start input').val(moment().format('DD-MM-YYYY HH:kk:ss'));
        }
        if( $('#tanggal_izin_end').length > 0) {
            $('#tanggal_izin_end input').val(moment().format('DD-MM-YYYY HH :kk:ss'));
        }
        </script>
    </body>
</html>