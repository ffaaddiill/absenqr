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
                        <li><a href="news.html">News</a></li>
                        <li class="active">Megan Boyle flourishes at Boston University</li>
                    </ol>
                    
                </div><!-- breadcrumbs end -->               
                
            </div><!-- row end -->
            
            <div class="row no-gutter"><!-- row -->
                
                <div class="col-lg-8 col-md-8"><!-- doc body wrapper -->
                    
                    <div class="col-padded"><!-- inner custom column -->
                    
                        <div class="row gutter"><!-- row -->
                        
                            <div class="col-lg-12 col-md-12">
                                <?php if (isset($news['primary_image']) && $news['primary_image'] != ''): ?>
                                    <figure class="news-featured-image">    
                                        <img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$news['primary_image'] ?>" alt="Featured image 4" class="img-responsive" />
                                    </figure>
                                <?php endif; ?>
                                
                                
                                <div class="news-title-meta">
                                    <h1 class="page-title"><?=$news['title']?></h1>
                                    <div class="news-meta">
                                        <span class="news-meta-date"><?=dateToIndo($news['create_date'])?></span>
                                        <span class="news-meta-category"><a href="news.html" title="News"><?=$news['category_name']?></a></span>
                                        <!-- <span class="news-meta-comments"><a href="#" title="3 comments">3 comments</a></span>
 -->                                    </div>
                                </div>
                                
                                <div class="news-body">
                                    <?=$news['description']?>                               
                                </div>
                                
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