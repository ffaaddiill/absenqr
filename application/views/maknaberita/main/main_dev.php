<div class="container mt25">
    <div class="row">
        <div class="col-md-9"><!-- main -->
            <div class="row">
                <div class="col-md-7">
                	<a href="<?=base_url().$headline_home[0]['slug'].'/'.$headline_home[0]['id_news'].'/'.$headline_home[0]['uri_path']?>">
                    	<img class="img-fluid" src="<?=base_url().NEWS_IMG_URL.$headline_home[0]['primary_image']?>">
                   	</a>
                    <div class="mt10">
                    	<a class="news-link" href="<?=base_url().$headline_home[0]['slug']?>">
                        	<span class="cl-bluesky"><?=$headline_home[0]['category_name']?></span>
                        </a>
                    </div>
                    <div class="content">
                    	<a class="news-link" href="<?=base_url().$headline_home[0]['slug'].'/'.$headline_home[0]['id_news'].'/'.$headline_home[0]['uri_path']?>">
                        	<strong class="big-headline-title"><?=$headline_home[0]['title']?></strong>
                       </a>
                        <p>
                            <?=$headline_home[0]['teaser']?>
                        </p>
                        <p><a href="<?=base_url().$headline_home[0]['slug'].'/'.$headline_home[0]['id_news'].'/'.$headline_home[0]['uri_path']?>">Selengkapnya >></a></p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12 thumb-list-headline">
                        	<a href="<?=base_url().$headline_home[1]['slug'].'/'.$headline_home[1]['id_news'].'/'.$headline_home[1]['uri_path']?>">
                        		<img class="img-fluid mb10" src="<?=base_url().NEWS_IMG_URL.$headline_home[1]['primary_image']?>">
                        	</a>
                        	<a class="news-link" href="<?=base_url().$headline_home[1]['slug'].'/'.$headline_home[1]['id_news'].'/'.$headline_home[1]['uri_path']?>">
                        		<h5 class="thumb-list-title"><?=$headline_home[1]['title']?></h5>
                        	</a>
                        </div>
                        <div class="col-md-12 thumb-list-headline">
                        	<a href="<?=base_url().$headline_home[2]['slug'].'/'.$headline_home[2]['id_news'].'/'.$headline_home[2]['uri_path']?>">
                            	<img class="img-fluid mb10" src="<?=base_url().NEWS_IMG_URL.$headline_home[2]['primary_image']?>">
                            </a>
                            <a class="news-link" href="<?=base_url().$headline_home[2]['slug'].'/'.$headline_home[2]['id_news'].'/'.$headline_home[2]['uri_path']?>">
                            	<h5 class="thumb-list-title"><?=$headline_home[2]['title']?></h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
        <div class="col-md-3"><!-- terkini -->
            <ul class="list-unstyled thumb-list-ul">
            	<!-- <?= base_url().IMG_URL ?> -->
                <?php //$this->load->view(TEMPLATE_DIR.'/ads/mr1'); base_url().IMG_URL ?>
                <img class="img-fluid" src="<?= base_url().IMG_URL ?>mr.jpg" />
                <?php foreach($headline_home as $key=>$val): ?>
                	<?php if($key>2): ?>
	                <li class="media">
	            		<a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
	                    	<img src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>" class="mr-3 thumb-list" alt="<?=$val['title']?>">
	                   	</a>
	                    <div class="media-body">
	                    	<a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
	                        	<h5 class="mt-0 mb-1 thumb-list-title"><?=$val['title']?></h5>
	                    	</a>
	                    </div>
	                </li>
	                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <span class="leavespace"></span>
        </div>
    </div>
</div>

<div class="container">
	
    <div class="row">
        <div class="col-md-12">
            <hr class="section">
        </div>
        <?php if(isset($_GET['dev']) && $_GET['dev'] == '123'): ?>
        <script>
        	alert('tes');
        </script>
        <!-- Top content -->
        <div class="top-content">
        	<div class="container-fluid">
        		<div id="carousel-example" class="carousel slide" data-ride="carousel">
        			<div class="carousel-inner row w-100 mx-auto" role="listbox">
        				<?php foreach($news_video as $key=>$val): ?>
            			<div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 active">
							<img class="img-fluid img-video mx-auto d-block" src="http://img.youtube.com/vi/<?=$val['video_id']?>/hqdefault.jpg" />
						</div>
						<?php endforeach; ?>
        			</div>
        			<a class="carousel-control-prev" href="#carousel-example" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
        		</div>
        	</div>
        </div>
        <?php else: ?>
        	<script>
        		alert('else');
        	</script>
        	<?php foreach($news_video as $key=>$val): ?>
	        <div class="col-md-3 pb-video">
	        	<?php /*
	        	<iframe id="ytplayer" type="text/html" width="300" height="150" src="https://www.youtube.com/embed/<?=$val['video_id']?>?autoplay=0&origin=http://maknaberita.com" frameborder="0"></iframe>
	            */ ?>
	            <a data-toggle="modal" id="video-list" data-idnews="<?=$val['id_news']?>" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
	            	<img class="img-fluid img-video" src="http://img.youtube.com/vi/<?=$val['video_id']?>/hqdefault.jpg" />
	            	<?php /*<i class="far fa-play-circle video_icon_play"></i>*/ ?>
	            </a>
	            
	            <div>
	                <?=$val['title']?>
	            </div>
	        </div>
        	<?php endforeach; ?>
       	<?php endif; ?>     
    </div>
</div>

<div class="container mt25">
    <div class="row">
    	<?php /*
        <div class="col-md-12">
            <h3>Latest News</h3>
            <hr class="section">
        </div>
		 * */ ?>
		<div class="col-md-12">
			<hr class="section">
		</div>
		
		<?php foreach(get3CategoryList(['sports','internasional','ekonomi'])['three_cat'] as $key=>$value): ?>
        <div class="col-xs-12 col-md-4">
    		<?php foreach($value as $k=>$v): ?>
        		<?php if($k==0): ?>
        			<a href="<?=base_url().$v['slug'].'/'.$v['id_news'].'/'.$v['uri_path']?>">
	            		<img class="img-fluid" src="<?=base_url().NEWS_IMG_URL.$v['primary_image']?>">
	            	</a>
	            	<a class="news-link" href="<?=base_url().$v['slug'].'/'.$v['id_news'].'/'.$v['uri_path']?>">
	            		<h4 class="latest-title mt5"><?=$v['title']?></h4>
	            	</a>
	            <?php endif; ?>
            <?php endforeach; ?>
            <ul class="latest-news-list list-unstyled">
            <?php foreach($value as $k=>$v): ?>
            	<?php if($k>0): ?>
                <li>
                	<a class="news-link" href="<?=base_url().$v['slug'].'/'.$v['id_news'].'/'.$v['uri_path']?>">
                    	<span class="latest-news-list-title"><?=$v['title']?></span>
                   	</a>
                </li>
                <?php endif; ?>
	        <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</div>