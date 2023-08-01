<div id="k-body"><!-- content wrapper -->

    <div class="container"><!-- container -->
    
        <div class="row"><!-- row -->
        
            <div id="k-top-search" class="col-lg-12 clearfix"><!-- top search -->
            
                <form action="#" id="top-searchform" method="get" role="search">
                    <div class="input-group">
                        <input type="text" name="s" id="sitesearch" class="form-control" autocomplete="off" placeholder="Type in keyword(s) then hit Enter on keyboard" />
                    </div>
                </form>
                
                <div id="bt-toggle-search" class="search-icon text-center"><i class="s-open fa fa-search"></i><i class="s-close fa fa-times"></i></div><!-- toggle search button -->
            
            </div><!-- top search end -->
        
            <div class="k-breadcrumbs col-lg-12 clearfix"><!-- breadcrumbs -->
            
                <ol class="breadcrumb">
                    <li><a href="index-2.html">Home</a></li>
                    <li class="active">Gallery</li>
                </ol>
                
            </div><!-- breadcrumbs end -->               
            
        </div><!-- row end -->
        
        <div class="row no-gutter"><!-- row -->
            
            <div class="col-lg-8 col-md-8"><!-- doc body wrapper -->
                
                <div class="col-padded"><!-- inner custom column -->
                
                    <div class="row gutter"><!-- row -->
                    
                        <div class="col-lg-12 col-md-12">
                
                            <h1 class="page-title">School Galleries</h1><!-- category title -->
                        
                        </div>
                    
                    </div><!-- row end -->
                
                    <div class="row gutter"><!-- row -->
                    
                        <div class="col-lg-12 col-md-12">

                            <?php foreach ($events as $row => $event): ?>
                                <?php $url_path = site_url('event/detail/'.$event['uri_path']); ?>
                                <div class="gallery-wrapper"><!-- gallery single wrap -->
                                
                                    <figure class="gallery-last-photo clearfix">
                                        <a href="<?= $url_path ?>" title="<?= $event['title'] ?>"><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$event['image'] ?>" alt="Leading photo" /></a>
                                    </figure>
                                    
                                    <div class="gallery-info">
                                        <span class="gallery-photos-num"><?= $event['total_gallery'] ?></span>
                                        <span class="gallery-photos-tag">photos</span>
                                    </div>
                                    
                                    <div class="gallery-meta">
                                        <h1 class="gallery-title"><a href="<?= $url_path ?>" title="<?= $event['title'] ?>"><?= $event['title'] ?></a></h1>
                                        <p class="gallery-description">
                                        <?= $event['teaser'] ?>...
                                        </p>
                                    </div>
                                
                                </div><!-- gallery single wrap end -->

                            <?php endforeach; ?>
                        
                        </div>
                    
                    </div><!-- row end -->
                    
                    <div class="row gutter"><!-- row -->
                    
                        <div class="col-lg-12">
                    
                            <ul class="pagination pull-right"><!-- pagination -->
                                <li class="disabled"><a href="#">Prev</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Next</a></li>
                            </ul><!-- pagination end -->
                        
                        </div>
                        
                    </div><!-- row end -->
                
                </div><!-- inner custom column end -->
                
            </div><!-- doc body wrapper end -->
            
            <div id="k-sidebar" class="col-lg-4 col-md-4"><!-- sidebar wrapper -->
                
                <div class="col-padded col-shaded"><!-- inner custom column -->
                
                    <ul class="list-unstyled clear-margins"><!-- widgets -->
                        
                        <li class="widget-container widget_newsletter"><!-- widget -->
                        
                            <h1 class="title-titan">School Newsletter</h1>
                            
                            <form role="search" method="get" class="newsletter-form" action="#">
                                <div class="input-group">
                                    <input type="text" placeholder="Your e-mail address" autocomplete="off" class="form-control newsletter-form-input" name="email" />
                                    <span class="input-group-btn"><button type="submit" class="btn btn-default">GO!</button></span>
                                </div>
                                <span class="help-block">* Enter your e-mail address to subscribe.</span>
                            </form>
                        
                        </li>
                        
                        <li class="widget-container widget_text"><!-- widget -->
                        
                            <a href="#" class="custom-button cb-red" title="How to apply?">
                                <i class="custom-button-icon fa fa-empire"></i>
                                <span class="custom-button-wrap">
                                    <span class="custom-button-title">Donate Now</span>
                                    <span class="custom-button-tagline">Become a corporate sponsor of our schools!</span>
                                </span>
                                <em></em>
                            </a>
                        
                        </li>
                        
                    </ul><!-- widgets end -->
                
                </div><!-- inner custom column end -->
                
            </div><!-- sidebar wrapper end -->
        
        </div><!-- row end -->
    
    </div><!-- container end -->

</div><!-- content wrapper end -->