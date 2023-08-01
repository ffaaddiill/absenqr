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
                    <li><a href="gallery.html">Gallery</a></li>
                    <li class="active"><?= $gallery_record['title'] ?></li>
                </ol>
                
            </div><!-- breadcrumbs end -->               
            
        </div><!-- row end -->
        
        <div class="row no-gutter fullwidth"><!-- row -->
            
            <div class="col-lg-12 col-md-12"><!-- doc body wrapper -->
                
                <div class="col-padded"><!-- inner custom column -->
                    
                    <h1 class="page-title"><?= $gallery_record['title'] ?> <span class="label label-info"><?= $gallery_record['total_gallery'] ?> photos</span></h1>
                    
                    <div class="news-body">
                        
                        <div class="row gutter k-equal-height"><!-- row -->
                        
                            <?php foreach($gallery_record['galleries'] as $key => $gal) : ?>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <figure class="gallery-photo-thumb">
                                        <a href="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$gal['gallery_file'] ?>" title="Image 1" data-fancybox-group="gallery-bssb" class="fancybox"><img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$gal['gallery_file'] ?>" alt="<?= $gallery_record['title'] ?>" /></a>
                                    </figure>
                                    <div class="gallery-photo-description">
                                        <?= $gal['gallery_caption'] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        
                        </div><!-- row end -->
                        
                    </div>
                
                </div><!-- inner custom column end -->
                
            </div><!-- doc body wrapper end -->
        
        </div><!-- row end -->
    
    </div><!-- container end -->
    
    </div><!-- content wrapper end -->