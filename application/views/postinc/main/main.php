<div class="container">
    <div class="jumbotron p-0 text-white rounded-0 bg-white mb15">
        <div class="col-md-12 p-0">
            <div class="position-absolute zi-1000 white text-right fs45 photo-of-the-week mr15 mb15">
                <span class="ff-hvb d-block lh60">PHOTO</span>
                <span class="ff-hvl d-block lh35">OF THE WEEK</span>
            </div>
            <div id="carouselPhotoOfTheWeekControls" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?=IMG_URL?>dummy/P1052022-reducedsize.jpg" class="d-block w90 mx-auto" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?=IMG_URL?>dummy/P1051955-reducedsize.jpg" class="d-block w90 mx-auto" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?=IMG_URL?>dummy/P1051915-reducedsize.jpg" class="d-block w90 mx-auto" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?=IMG_URL?>dummy/P1051940-reducedsize.jpg" class="d-block w90 mx-auto" alt="...">
                    </div>
                </div>
                <a class="carousel-control-prev justify-content-start pl15 d-none d-md-flex" href="#carouselPhotoOfTheWeekControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next justify-content-end pr15 d-none d-md-flex" href="#carouselPhotoOfTheWeekControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

                <a class="carousel-control-prev justify-content-start d-xs-flex d-md-none" href="#carouselPhotoOfTheWeekControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next justify-content-end d-xs-flex d-md-none" href="#carouselPhotoOfTheWeekControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row todays-top-news">
        <div class="col-xs-12 col-md-12 section-title fs35">
            <hr class="hr-section mb0 mt0">
            <div class="d-inline-block mt5"><span class="ff-hvl">TODAY'S</span> <span class="ff-hvb">TOP NEWS</span></div>
            <hr class="hr-thin-section mt0">
        </div>
        <div class="col col-content">
            <?php foreach($todays_news as $key=>$val): ?>
            <div class="row todays-top-news-list">
                <div class="col-xs-12 col-md-5">
                    <img class="img-fluid mb25" src="<?=base_url_dev().NEWS_IMG_URL.$val['primary_image']?>">
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="d-block py-1 px-2 top-news-head-meta bg-dark mb10">
                        <div class="d-block pinc-yellow ff-hvb lh20"><?=$val['category_name']?></div>
                        <div class="d-block white ff-hvl fs12 lh15"><?=indonesian_date($val['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
                    </div>
                    <h5 class="mt-0 mb-2 ff-hvb fs17"><?=$val['title']?></h5>
                    <div class="d-block ff-hvn fs14"><?=trim_content_by_word($val['teaser'], 200)?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-3" style="min-width:330px">
            <div class="d-block sidebar-latest-headline">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-block p15">
                            <span class="ff-hvb fs25 ls1 d-flex justify-content-center">LATEST HEADLINE</span>
                            <hr class="hr-thin-section my-0">
                        </div>
                        <ul class="list-unstyled p15 pt0">
                            <li class="lh17">
                                <div class="ff-hvb fs15">Resso, Layanan Musik Streaming Kompetitor Spotify & iTunes</div>
                                <div class="d-block ff-hvl fs12 lh16">Rabu, 11 Desember 2019 | 20.00 WIB</div>
                            </li>
                            <li class="lh17">
                                <div class="ff-hvb fs15">Kasus Polio Kembali Muncul di Malaysia Setelah Menghilang Hampir 3 Dekade</div>
                                <div class="d-block ff-hvl fs12 lh16">Rabu, 11 Desember 2019 | 20.00 WIB</div>
                            </li>
                            <li class="lh17">
                                <div class="ff-hvb fs15">Kasus Polio Kembali Muncul di Malaysia Setelah Menghilang Hampir 3 Dekade</div>
                                <div class="d-block ff-hvl fs12 lh16">Rabu, 11 Desember 2019 | 20.00 WIB</div>
                            </li>
                            <li class="lh17">
                                <div class="ff-hvb fs15">Kasus Polio Kembali Muncul di Malaysia Setelah Menghilang Hampir 3 Dekade</div>
                                <div class="d-block ff-hvl fs12 lh16">Rabu, 11 Desember 2019 | 20.00 WIB</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row must-watch mt-3">
        <div class="col-xs-12 col-md-12 section-title fs35">
            <hr class="hr-section mb0 mt0">
            <div class="d-inline-block mt5"><span class="ff-hvl">MUST</span> <span class="ff-hvb">WATCH</span></div>
            <hr class="hr-thin-section mt0">
        </div>
        <div class="col-xs-12 col-md-12">
            <div class="jumbotron p-0 text-white rounded-0 bg-white mb15">
        
                <!--Carousel Wrapper-->
                <div id="multi-item-carousel-mustwatch" class="carousel slide carousel-multi-item" data-ride="carousel">
                    
                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        <!--First slide-->
                        <?php foreach($news_video as $key=>$val): ?>
                        <div class="carousel-item <?=$key==0?'active':''?>">
                            <div class="row">
                                <?php foreach($val as $k=>$v): ?>
                                <div class="col-md-4">
                                    <div class="card position-relative rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="https://img.youtube.com/vi/<?=$v['video_id']?>/hqdefault.jpg">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="news-video-title mt20">
                                        <a class="the-link ff-hvb fs15 lh18" href="<?=base_url().$v['slug'].'/'.$v['id_news'].'/'.$v['uri_path']?>">
                                            <?=$v['title']?>
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!--/.First slide-->
                        
                    </div><!--/.Carousel Inner-->
                    <!-- Carousel Control -->
                    <a class="carousel-control-prev justify-content-start pl0 d-none d-md-flex" href="#multi-item-carousel-mustwatch" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next justify-content-end pr0 d-none d-md-flex" href="#multi-item-carousel-mustwatch" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                    <a class="carousel-control-prev justify-content-start d-xs-flex d-md-none" href="#multi-item-carousel-mustwatch" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next justify-content-end d-xs-flex d-md-none" href="#multi-item-carousel-mustwatch" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <!--/.Carousel Control-->
                    <!--Indicators-->
                    <ol class="carousel-indicators position-relative mb0 ">
                        <?php foreach($news_video as $key=>$val): ?>
                        <li data-target="#multi-item-carousel-mustwatch" data-slide-to="<?=$key?>" <?=$key==0?'class="active"':''?>></li>
                        <?php endforeach; ?>
                    </ol>
                    <!--/.Indicators-->
                    <!--/.Slides-->
                </div>
                <!--/.Carousel Wrapper-->
            </div><!--/.Jumbotron-->
        </div>
    </div>

    <div class="row infografis mt0">
        <div class="col-xs-12 col-md-12 section-title fs35">
            <hr class="hr-section mb0 mt0">
            <div class="d-inline-block mt5"><span class="ff-hvl">INFO</span><span class="ff-hvb">GRAFIS</span></div>
            <hr class="hr-thin-section mt0 mb0">
        </div>
        <div class="col-xs-12 col-md-12">
            <div class="jumbotron p-0 text-white rounded-0 bg-white mb15">
        
                <!--Carousel Wrapper-->
                <div id="multi-item-carousel-infografis" class="carousel slide carousel-multi-item" data-ride="carousel">
                    
                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        <!--First slide-->
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.First slide-->
                        <!--Second slide-->
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card position-relative my-3 rounded-0">
                                        <div class="card-body p0">
                                            <a data-toggle="modal" class="position-relative" id="video-list" data-idnews="1" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
                                                
                                                <img class="card-img-top img-video rounded-0" src="<?=IMG_URL?>dummy/infografis.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.Second slide-->
                        
                    </div><!--/.Carousel Inner-->
                    <!-- Carousel Control -->
                    <a class="carousel-control-prev justify-content-start pl0 d-none d-md-flex" href="#multi-item-carousel-infografis" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next justify-content-end pr0 d-none d-md-flex" href="#multi-item-carousel-infografis" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                    <a class="carousel-control-prev justify-content-start d-xs-flex d-md-none" href="#multi-item-carousel-infografis" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next justify-content-end d-xs-flex d-md-none" href="#multi-item-carousel-infografis" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <!--/.Carousel Control-->
                    <!--/.Slides-->
                </div>
                <!--/.Carousel Wrapper-->

            </div><!--/.Jumbotron-->
        </div>
    </div>

    <!-- END SECTION HR LINE -->
    <div class="row mt10">
        <div class="col-xs-12 col-md-12">
            <hr class="hr-section mb0 mt0">
        </div>
    </div>
    
</div>