<div class="container mt25">
    <div class="row">
        <div class="col-md-9"><!-- main -->
            <div class="row">
                <div class="col-md-7">
                		<a href="<?=base_url().$headline_home[0]['slug'].'/'.$headline_home[0]['id_news'].'/'.$headline_home[0]['uri_path']?>">
                    		<img class="img-fluid w100" src="<?=base_url().NEWS_IMG_URL.$headline_home[0]['primary_image']?>">
                   	</a>
                    <div class="mt10">
                    		<a class="news-link" href="<?=base_url().$headline_home[0]['slug']?>">
                        		<span class="cl-bluesky"><?=$headline_home[0]['category_name']?></span>
                        </a>
                    </div>
                    <div class="fs11"><?=indonesian_date($headline_home[0]['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
                    <div class="content">
                			<a class="news-link mb10 mt5 d-block" href="<?=base_url().$headline_home[0]['slug'].'/'.$headline_home[0]['id_news'].'/'.$headline_home[0]['uri_path']?>">
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
	                        	<a class="news-link" href="<?=base_url().$headline_home[1]['slug']?>">
	                        		<span class="cl-bluesky"><?=$headline_home[1]['category_name']?></span>
                        		</a>
                        		<div class="fs11"><?=indonesian_date($headline_home[1]['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
	                        	<a class="news-link" href="<?=base_url().$headline_home[1]['slug'].'/'.$headline_home[1]['id_news'].'/'.$headline_home[1]['uri_path']?>">
	                        		<h5 class="thumb-list-title"><?=$headline_home[1]['title']?></h5>
	                        	</a>
                        </div>
                        <div class="col-md-12 thumb-list-headline">
                        		<a href="<?=base_url().$headline_home[2]['slug'].'/'.$headline_home[2]['id_news'].'/'.$headline_home[2]['uri_path']?>">
                            		<img class="img-fluid mb10" src="<?=base_url().NEWS_IMG_URL.$headline_home[2]['primary_image']?>">
                            	</a>
                            	<a class="news-link" href="<?=base_url().$headline_home[2]['slug']?>">
	                        		<span class="cl-bluesky"><?=$headline_home[2]['category_name']?></span>
                        		</a>
                        		<div class="fs11"><?=indonesian_date($headline_home[2]['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
                            <a class="news-link" href="<?=base_url().$headline_home[2]['slug'].'/'.$headline_home[2]['id_news'].'/'.$headline_home[2]['uri_path']?>">
                            		<h5 class="thumb-list-title"><?=$headline_home[2]['title']?></h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
        <div class="col-md-3 sidebar-home"><!-- terkini -->
            <ul class="list-unstyled thumb-list-ul">
            	<!-- <?= base_url().IMG_URL ?> -->
                <center>
                	<?php //$this->load->view(TEMPLATE_DIR.'/ads/mr1'); ?>
                	<?php /*<img class="img-fluid" src="<?= base_url().IMG_URL ?>mr.jpg" /> */ ?>
            	</center>
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
	                    	<div class="sidebar-meta-category"><a href="<?=base_url().$val['slug']?>" class="fs11"><?=$val['category_name']?></a></div>
                   		<div class="fs11"><?=indonesian_date($val['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
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
            
            <?php /*
            <div class="col-md-2 offset-md-5 col-xs-12 col-sm-12 pl0 border1 no-border-bottom mt20">
                <div class="pl10 pr5 pt5 pb5 text-center"><a class="news-link" href="<?=base_url()?>video" class="d-block">Video &raquo;</a></div>  
            </div>
			*/ ?>
			
            <hr class="section mt0">
        </div>
        <div class="col-md-12">
        		<div class="row video-slider">
        			<?php foreach($news_video as $key=>$val): ?>
		  		<div class="col-md-3 pb-video">
		  			<a data-toggle="modal" id="video-list" data-idnews="<?=$val['id_news']?>" data-target="#video_modal" style="display:block" onclick="getModalVideo(this)">
						<img class="img-fluid img-video mx-auto d-block" src="https://img.youtube.com/vi/<?=$val['video_id']?>/hqdefault.jpg" />
					</a>
					<div class="fs11 mt5"><?=indonesian_date($val['publish_date'], 'l, j M Y | H:i', 'WIB')?></div>
					<div class="news-video-title">
		                <a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
		                		<?=$val['title']?>
		                	</a>
		            </div>
		  		</div>
		  		<?php endforeach; ?>
			</div>
			<div class="row">
	            <div class="col-md-12 text-center">
	        			<a class="btn btn-sm border-1 no-border-bottom rounded-0" href="<?=base_url()?>video">Video Lainnya</a>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="container">
    <div class="row">
		<div class="col-md-12">
			<hr class="section mt0">
		</div>
		
		<?php
		if(isset($_GET['debug']) && $_GET['debug'] == '999') {
			echo '<pre>';
			print_r(get3CategoryList(['sports','nasional','ekonomi'], [$this->uri->segment(1)]));
			exit;
		}
		?>

		<?php foreach(get3CategoryList(['sports','nasional','ekonomi'], [$this->uri->segment(1)])['three_cat'] as $key=>$value): ?>
	        <div class="col-xs-12 col-md-4">
	            
	            <div class="col-md-12 pl0 <?=$value['color_class']?>">
	                <div class="pl10 pr5 pt5 pb5"><a class="white news-link" href="<?=base_url().$value['category']['slug']?>" class="d-block"><?= $value['category']['title'] ?> &raquo;</a></div>  
	            </div>
				 
				<?php foreach($value['list'] as $k=>$v): ?>
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
	            <?php foreach($value['list'] as $k=>$v): ?>
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