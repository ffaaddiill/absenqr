<div id="k-body"><!-- content wrapper -->
    
    <div class="container custom-container"><!-- container -->
    
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
                    <li><a href="#">Home</a></li>
                    <li class="active"><?=$this->uri->segment(1)?></li>
                </ol>
                
            </div><!-- breadcrumbs end -->
            
        </div><!-- row end -->
        
        <div class="row no-gutter fullwidth"><!-- row -->
        
            <div class="col-lg-12 clearfix"><!-- featured posts slider -->
            
                <div id="carousel-featured" class="carousel slide" data-interval="4000" data-ride="carousel"><!-- featured posts slider wrapper; auto-slide -->
                
                    <ol class="carousel-indicators"><!-- Indicators -->
                        <li data-target="#carousel-featured" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-featured" data-slide-to="1"></li>
                        <li data-target="#carousel-featured" data-slide-to="2"></li>
                        <li data-target="#carousel-featured" data-slide-to="3"></li>
                        <li data-target="#carousel-featured" data-slide-to="4"></li>
                    </ol><!-- Indicators end -->
                
                    <div class="carousel-inner"><!-- Wrapper for slides -->
                        <?php
                        $slide = 0;
                        foreach ($slideshows as $row => $slideshow): ?>
                            <?php if($slide < 1): ?>
                                <div class="item active">
                                    <img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$slideshow['primary_image']?>" alt="Image slide 3" />
                                </div>
                            <?php else: ?>
                                <div class="item">
                                    <img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$slideshow['primary_image']?>" alt="Image slide 3" />
                                </div>
                            <?php endif; ?>
                        <?php 
                            $slide++;
                        endforeach;
                        ?>

                        <!-- <div class="item active">
                            <img src="<?= IMG_URL ?>dummy/slide-3.jpg" alt="Image slide 3" />
                            <div class="k-carousel-caption pos-1-3-right scheme-dark">
                                <div class="caption-content">
                                    <h3 class="caption-title">Learning makes us stronger for life</h3>
                                    <p>
                                        We could brag about all of the great opportunities that our students have... or you could hear it from the students themselves.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="item">
                            <img src="<?= IMG_URL ?>dummy/slide-2.jpg" alt="Image slide 2" />
                            <div class="k-carousel-caption pos-1-3-left scheme-light">
                                <div class="caption-content">
                                    <h3 class="caption-title">Learning makes us stronger for life</h3>
                                    <p>
                                        We could brag about all of the great opportunities that our students have... or you could hear it from the students themselves.
                                    </p>
                                </div>
                            </div>
                        </div> -->
                    </div><!-- Wrapper for slides end -->
                
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-featured" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="right carousel-control" href="#carousel-featured" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                    <!-- Controls end -->
                    
                </div><!-- featured posts slider wrapper end -->
                    
            </div><!-- featured posts slider end -->
            
        </div><!-- row end -->
        
        <div class="row no-gutter"><!-- row -->
            
            <div class="col-lg-4 col-md-4"><!-- upcoming events wrapper -->
                
                <div class="col-padded col-shaded"><!-- inner custom column -->
                
                    <ul class="list-unstyled clear-margins"><!-- widgets -->
                    
                        <li class="widget-container widget_up_events"><!-- widgets list -->
                
                            <h1 class="title-widget">Alumni News</h1>
                            
                            <ul class="list-unstyled">
                            
                                <?php foreach ($alumni_news_list as $alumni_news): ?>
                                    <?php $url_path = ($alumni_news['ext_link'] != '') ? $alumni_news['ext_link'] : site_url('news/view_news/'.$alumni_news['uri_path']); ?>
                                    <li class="recent-news-wrap">
                                
                                        <h1 class="title-median"><a href="<?= $url_path ?>" title="<?= $alumni_news['title'] ?>"><?= $alumni_news['title'] ?></a></h1>
                                        
                                        <div class="recent-news-meta">
                                            <div class="recent-news-date"><?=dateToIndo($alumni_news['create_date'])?></div>
                                        </div>
                                        
                                        <div class="recent-news-content clearfix">
                                            <?php if (isset($alumni_news['thumbnail_image']) && $alumni_news['thumbnail_image'] != ''): ?>
                                                <figure class="recent-news-thumb">
                                                    <a href="<?= $url_path ?>" title="Megan Boyle flourishes..."><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$alumni_news['thumbnail_image'] ?>" class="attachment-thumbnail wp-post-image" alt="Thumbnail 1" /></a>
                                                </figure>
                                            <?php elseif (isset($alumni_news['primary_image']) && $alumni_news['primary_image'] != ''): ?>
                                                <figure class="recent-news-thumb">
                                                    <a href="<?= $url_path ?>" title="Megan Boyle flourishes..."><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.str_replace('news/','news/thumb/',$alumni_news['primary_image']) ?>" class="attachment-thumbnail wp-post-image" alt="Thumbnail 1" /></a>
                                                </figure>
                                            <?php endif; ?>
                                            <div class="recent-news-text">
                                                <p>
                                                <?=$alumni_news['teaser']?>... <a href="<?= $url_path ?>" class="moretag" title="read more">MORE</a> 
                                                </p>
                                            </div>
                                        </div>
                                    
                                    </li>
                                <?php endforeach; ?>
                            
                            </ul>
                        
                        </li><!-- widgets list end -->
                    
                    </ul><!-- widgets end -->
                
                </div><!-- inner custom column end -->
                
            </div><!-- upcoming events wrapper end -->
            
            <div class="col-lg-4 col-md-4"><!-- recent news wrapper -->
                
                <div class="col-padded"><!-- inner custom column -->
                
                    <ul class="list-unstyled clear-margins"><!-- widgets -->
                    
                        <li class="widget-container widget_recent_news"><!-- widgets list -->
                
                            <h1 class="title-widget">School News</h1>
                            
                            <ul class="list-unstyled">

                                <?php foreach ($news_list as $news): ?>
                                    <?php $url_path = ($news['ext_link'] != '') ? $news['ext_link'] : site_url('news/view_news/'.$news['uri_path']); ?>
                                    <li class="recent-news-wrap">
                                
                                        <h1 class="title-median"><a href="<?= $url_path ?>" title="<?= $news['title'] ?>"><?= $news['title'] ?></a></h1>
                                        
                                        <div class="recent-news-meta">
                                            <div class="recent-news-date"><?=dateToIndo($alumni_news['create_date'])?></div>
                                        </div>
                                        
                                        <div class="recent-news-content clearfix">
                                            <?php if (isset($news['thumbnail_image']) && $news['thumbnail_image'] != ''): ?>
                                                <figure class="recent-news-thumb">
                                                    <a href="<?= $url_path ?>" title="Megan Boyle flourishes..."><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$news['thumbnail_image'] ?>" class="attachment-thumbnail wp-post-image" alt="Thumbnail 1" /></a>
                                                </figure>
                                            <?php elseif (isset($news['primary_image']) && $news['primary_image'] != ''): ?>
                                                <figure class="recent-news-thumb">
                                                    <a href="<?= $url_path ?>" title="Megan Boyle flourishes..."><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.str_replace('news/','news/thumb/',$news['primary_image']) ?>" class="attachment-thumbnail wp-post-image" alt="Thumbnail 1" /></a>
                                                </figure>
                                            <?php endif; ?>
                                            <div class="recent-news-text">
                                                <p>
                                                <?=$news['teaser']?>... <a href="<?= $url_path ?>" class="moretag" title="read more">MORE</a> 
                                                </p>
                                            </div>
                                        </div>
                                    
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            
                        </li><!-- widgets list end -->
                    
                    </ul><!-- widgets end -->
                
                </div><!-- inner custom column end -->
                
            </div><!-- recent news wrapper end -->
            
            <div class="col-lg-4 col-md-4"><!-- misc wrapper -->
                
                <div class="col-padded col-shaded"><!-- inner custom column -->
                
                    <ul class="list-unstyled clear-margins"><!-- widgets -->
                    
                        <li class="widget-container widget_course_search"><!-- widget -->
                        
                            <h1 class="title-titan">Course Finder</h1>
                            
                            <form role="search" method="get" id="course-finder" action="#">
                                <div class="input-group">
                                    <input type="text" placeholder="Find a course..." autocomplete="off" class="form-control" id="find-course" name="find-course" />
                                    <span class="input-group-btn"><button type="submit" class="btn btn-default">GO!</button></span>
                                </div>
                                <span class="help-block">* Enter course ID, title or the course instructor name</span>
                            </form>
                        
                        </li><!-- widget end -->
                        
                        <li class="widget-container widget_text"><!-- widget -->
                        
                            <a href="http://36.78.162.132/simdosq" class="custom-button cb-green" title="How to apply?">
                                <i class="custom-button-icon fa fa-check-square-o"></i>
                                <span class="custom-button-wrap">
                                    <span class="custom-button-title">Sim Sekolah</span>
                                    <span class="custom-button-tagline">Join us whenewer you feel it’s time!</span>
                                </span>
                                <em></em>
                            </a>
                            
                            <a href="#" class="custom-button cb-gray" title="Campus tour">
                                <i class="custom-button-icon fa  fa-play-circle-o"></i>
                                <span class="custom-button-wrap">
                                    <span class="custom-button-title">Campus tour</span>
                                    <span class="custom-button-tagline">Student's life at the glance. Take a tour...</span>
                                </span>
                                <em></em>
                            </a>
                            
                            <a href="#" class="custom-button cb-yellow" title="Prospectus">
                                <i class="custom-button-icon fa  fa-leaf"></i>
                                <span class="custom-button-wrap">
                                    <span class="custom-button-title">Prospectus</span>
                                    <span class="custom-button-tagline">Request a free School Prospectus!</span>
                                </span>
                                <em></em>
                            </a>
                        
                        </li><!-- widget end -->
                        
                        <li class="widget-container widget_sofa_twitter"><!-- widget -->
                        
                            <ul class="k-twitter-twitts list-unstyled">
                            
                                <li class="twitter-twitt">
                                    <p>
                                    <a href="https://twitter.com/DanielleFilson">@MattDeamon</a> Why it always has to be so complicated? Try to get it via this link <a href="http://usap.co/potter">mama.co/hpot</a> Good luck mate!
                                    </p>
                                </li>
                            
                            </ul>
                            
                            <div class="k-twitter-twitts-footer">
                                <a href="#" class="k-twitter-twitts-follow" title="Follow!"><i class="fa fa-twitter"></i>&nbsp; Follow us!</a>
                            </div>
                        
                        </li><!-- widget end -->
                        
                    </ul><!-- widgets end -->
                
                </div><!-- inner custom column end -->
                
            </div><!-- misc wrapper end -->
        
        </div><!-- row end -->
    
    </div><!-- container end -->

</div><!-- content wrapper end -->