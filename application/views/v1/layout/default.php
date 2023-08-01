<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUNTINGTON Public Schools</title>
    
    <!-- Styles -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,800" rel="stylesheet" type="text/css"><!-- Google web fonts -->
    <link href="<?= CSS_URL ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- font-awesome -->
    <link href="<?= JS_URL ?>dropdown-menu/dropdown-menu.css" rel="stylesheet" type="text/css"><!-- dropdown-menu -->
    <link href="<?= CSS_URL ?>bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"><!-- Bootstrap -->
    <link href="<?= JS_URL ?>fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"><!-- Fancybox -->
    <link href="<?= JS_URL ?>audioplayer/audioplayer.css" rel="stylesheet" type="text/css"><!-- Audioplayer -->
    <link href="<?= CSS_URL ?>style.css" rel="stylesheet" type="text/css"><!-- theme styles -->
    <link href="<?= CSS_URL ?>custom-style.css" rel="stylesheet" type="text/css"><!-- theme styles -->

  </head>
  
  <body role="document">
    <!-- device test, don't remove. javascript needed! -->
    <span class="visible-xs"></span><span class="visible-sm"></span><span class="visible-md"></span><span class="visible-lg"></span>
    <!-- device test end -->
    
    <div id="k-head" class="container"><!-- container + head wrapper -->
    
        <div class="row"><!-- row -->
        
            <div class="col-lg-12">
        
                <div id="k-site-logo" class="pull-left"><!-- site logo -->
                
                    <h1 class="k-logo">
                        <a href="index-2.html" title="Home Page">
                            <img src="<?= IMG_URL ?>site-logo.png" alt="Site Logo" class="img-responsive" style="width: 166px" />
                        </a>
                    </h1>
                    
                    <a id="mobile-nav-switch" href="#drop-down-left"><span class="alter-menu-icon"></span></a><!-- alternative menu button -->
            
                </div><!-- site logo end -->

                <nav id="k-menu" class="k-main-navig"><!-- main navig -->
        
                    <ul id="drop-down-left" class="k-dropdown-menu">
                    <?php foreach($navmenus as $menu => $val): ?>
                        <?php $url_path = ($val['ext_link'] != '') ? $val['ext_link'] : ( ($val['uri_path'] != '') ? site_url($val['uri_path']) : site_url($val['module']) ); ?>>
                        <?php if( isset($val['children']) && !empty($val['children']) ): ?>
                            <?php foreach($val['children'] as $menu1 => $val1): ?>
                                <?php $url_path1 = ($val1['ext_link'] != '') ? $val1['ext_link'] : ( ($val1['uri_path'] != '') ? site_url($val1['uri_path']) : site_url($val1['module']) ); ?>
                                <li>
                                    <a href="<?=$url_path?>" class="Pages Collection" title="More Templates"><?= $val['page_name'] ?></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?=$url_path1?>"><?= $val1['page_name'] ?></a></li>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                                <a href="<?=$url_path?>" title="Our School News"><?= $val['page_name'] ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </ul>
        
                </nav><!-- main navig end -->
            
            </div>
            
        </div><!-- row end -->
    
    </div><!-- container + head wrapper end -->
    
    <?= $content ?>
    
    <div id="k-footer"><!-- footer -->
    
        <div class="container"><!-- container -->
        
            <div class="row no-gutter"><!-- row -->
            
                <div class="col-lg-4 col-md-4"><!-- widgets column left -->
            
                    <div class="col-padded col-naked">
                    
                        <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_nav_menu"><!-- widgets list -->
                    
                                <h1 class="title-widget">Useful links</h1>
                                
                                <ul>
                                    <li><a href="#" title="menu item">Placement Exam Schedule</a></li>
                                    <li><a href="#" title="menu item">Superintendent's Hearing Audio</a></li>
                                    <li><a href="#" title="menu item">Budget Central</a></li>
                                    <li><a href="#" title="menu item">Job Opportunities - Application</a></li>
                                    <li><a href="#" title="menu item">College Acceptances as of May 12</a></li>
                                </ul>
                    
                            </li>
                            
                        </ul>
                         
                    </div>
                    
                </div><!-- widgets column left end -->
                
                <div class="col-lg-4 col-md-4"><!-- widgets column center -->
                
                    <div class="col-padded col-naked">
                    
                        <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_recent_news"><!-- widgets list -->
                    
                                <h1 class="title-widget">School Contact</h1>
                                
                                <div itemscope itemtype="http://data-vocabulary.org/Organization"> 
                                
                                    <h2 class="title-median m-contact-subject" itemprop="name">Buntington Public Schools</h2>
                                
                                    <div class="m-contact-address" itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                                        <span class="m-contact-street" itemprop="street-address">19 Tower Avenue, Buntington Station</span>
                                        <span class="m-contact-city-region"><span class="m-contact-city" itemprop="locality">New York</span>, <span class="m-contact-region" itemprop="region">NY</span></span>
                                        <span class="m-contact-zip-country"><span class="m-contact-zip" itemprop="postal-code">11506</span> <span class="m-contact-country" itemprop="country-name">USA</span></span>
                                    </div>
                                     
                                    <div class="m-contact-tel-fax">
                                        <span class="m-contact-tel">Tel: <span itemprop="tel">631-551-3678</span></span>
                                        <span class="m-contact-fax">Fax: <span itemprop="fax">631-551-3688</span></span>
                                    </div>
                                    
                                </div>
                                
                                <div class="social-icons">
                                
                                    <ul class="list-unstyled list-inline">
                                    
                                        <li><a href="#" title="Contact us"><i class="fa fa-envelope"></i></a></li>
                                        <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    
                                    </ul>
                                
                                </div>
                    
                            </li>
                            
                        </ul>
                        
                    </div>
                    
                </div><!-- widgets column center end -->
                
                <div class="col-lg-4 col-md-4"><!-- widgets column right -->
                
                    <div class="col-padded col-naked">
                    
                        <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                            <li class="widget-container widget_sofa_flickr"><!-- widgets list -->
                    
                                <h1 class="title-widget">Flickr Stream</h1>
                                
                                <ul class="k-flickr-photos list-unstyled">
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-1.jpg" alt="Photo 1" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-2.jpg" alt="Photo 2" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-3.jpg" alt="Photo 3" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-4.jpg" alt="Photo 4" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-5.jpg" alt="Photo 5" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-6.jpg" alt="Photo 6" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-7.jpg" alt="Photo 7" /></a></li>
                                    <li><a href="#" title="Flickr photo"><img src="<?= IMG_URL ?>dummy/flickr-8.jpg" alt="Photo 8" /></a></li>
                                </ul>
                    
                            </li>
                            
                        </ul> 
                        
                    </div>
                
                </div><!-- widgets column right end -->
            
            </div><!-- row end -->
        
        </div><!-- container end -->
    
    </div><!-- footer end -->
    
    <div id="k-subfooter"><!-- subfooter -->
    
        <div class="container"><!-- container -->
        
            <div class="row"><!-- row -->
            
                <div class="col-lg-12">
                
                    <p class="copy-text text-inverse">
                    &copy; 2015 Buntington Public Schools. All rights reserved.
                    </p>
                
                </div>
            
            </div><!-- row end -->
        
        </div><!-- container end -->
    
    </div><!-- subfooter end -->

    <!-- jQuery -->
    <script src="<?= JS_URL ?>jquery.min.js"></script>
    <script src="jQuery/jquery-migrate-1.2.1.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="<?= JS_URL ?>bootstrap.min.js"></script>
    
    <!-- Drop-down -->
    <script src="<?= JS_URL ?>/dropdown-menu/dropdown-menu.js"></script>
    
    <!-- Fancybox -->
    <script src="<?= JS_URL ?>fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?= JS_URL ?>fancybox/jquery.fancybox-media.js"></script><!-- Fancybox media -->
    
    <!-- Responsive videos -->
    <script src="<?= JS_URL ?>jquery.fitvids.js"></script>
    
    <!-- Audio player -->
    <script src="<?= JS_URL ?>audioplayer/audioplayer.min.js"></script>
    
    <!-- Pie charts -->
    <script src="<?= JS_URL ?>jquery.easy-pie-chart.js"></script>
    
    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
    
    <!-- Theme -->
    <script src="<?= JS_URL ?>theme.js"></script>
    
  </body>
</html>