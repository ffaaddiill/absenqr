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
                    <li class="active">News</li>
                </ol>
                
            </div><!-- breadcrumbs end -->               
            
        </div><!-- row end -->
        
        <div class="row no-gutter"><!-- row -->
            
            <div class="col-lg-8 col-md-8"><!-- doc body wrapper -->
                
                <div class="col-padded"><!-- inner custom column -->
                
                    <div class="row gutter"><!-- row -->
                    
                        <?php foreach($news_list as $news) : ?>
                            <?php $url_path = ($news['ext_link'] != '') ? $news['ext_link'] : site_url('news/view_news/'.$news['uri_path']); ?>
                            <div class="k-article-summary col-lg-12 col-md-12">
                                <?php if (isset($news['thumbnail_image']) && $news['thumbnail_image'] != ''): ?>
                                    <figure class="news-featured-image">    
                                        <a href="<?= $url_path ?>" title="<?= $news['title'] ?>"><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$news['thumbnail_image'] ?>" alt="Featured image 4" class="img-responsive" /></a>
                                    </figure>
                                <?php elseif (isset($news['primary_image']) && $news['primary_image'] != ''): ?>
                                    <figure class="news-featured-image">    
                                        <a href="<?= $url_path ?>" title="<?= $news['title'] ?>"><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.str_replace('news/','news/thumb/',$news['primary_image']) ?>" alt="Featured image 4" class="img-responsive" /></a>
                                    </figure>
                                <?php endif; ?>
                                
                                <div class="news-title-meta">
                                    <h1 class="page-title"><a href="<?= $url_path ?>" title="<?= $news['title'] ?>"><?= $news['title'] ?></a></h1>
                                    <div class="news-meta">
                                        <span class="news-meta-date"><?=dateToIndo($news['create_date'])?></span>
                                        <span class="news-meta-category"><a href="#" title="<?=$news['category_name']?>"><?=$news['category_name']?></a></span>
                                        <!-- <span class="news-meta-comments"><a href="#" title="3 comments">3 comments</a></span> -->
                                    </div>
                                </div>
                                
                                <div class="news-body">
                                    <!--
                                    Duis ornare magna sit amet dui eleifend imperdiet. Aliquam at porta elit. Proin lorem lacus, tempus id diam sit amet, porttitor tempor lectus. Praesent id felis sagittis, suscipit ligula sed, condimentum nisi. In non commodo risus<a href="#" class="more-link">...READ MORE</a> 
                                     -->
                                    <p>
                                        <?=$news['teaser']?><a href="<?= $url_path ?>" class="more-link">...READ MORE</a> 
                                    </p>
                                </div>
                            
                            </div>
                        <?php endforeach; ?>
                    
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