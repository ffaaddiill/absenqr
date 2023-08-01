<!-- google adsense -->
<div class="container mt25">
    <div class="row">
		<div class="col-md-9 mb30">
    			<div class="row">
		        <div class="col-md-12">
		        		<h3 class="mt15 mb15"><?=$category_name?></h3>
            			<hr class="section">
		        </div>
		        
		        <div class="col-md-12">
		        		<ul class="list-unstyled thumb-list-ul">
		            		<?php foreach($news_list as $key=>$val): ?>
		                <li class="media">
		                    <a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
		                    		<img src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>" class="mr-3 thumb-list" alt="<?=$val['title']?>">
		                   	</a>
		                    	<div class="media-body">
	                    			<a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
	                        			<h5 class="mt-0 mb-1 thumb-list-title"><?=$val['title']?></h5>
		                       	</a>
		                  		<div class="lh10"><a href="<?=base_url().$val['slug']?>" class="fs11"><?=$val['category_name']?></a></div>
		                   		<span class="fs11"><?=indonesian_date($val['create_date'], 'l, j M Y | H:i', 'WIB')?></span>
		                    </div>
		                </li>
		                <?php endforeach; ?>
		                <?php /*
		                <li class="media">
		                    <img src="<?=base_url().IMG_URL?>news/3.jpg" class="mr-3 thumb-list" alt="...">
		                    <div class="media-body">
		                        <h5 class="mt-0 mb-1 thumb-list-title">Kesbangpol DKI harapkan instruksi terkait pencari suaka</h5>
		                    </div>
		                </li> */?>
		            </ul>
		            <nav aria-label="Page navigation">
		            		<?=$links?>
		            </nav>
		        </div>
			</div>
		</div>
		<div class="col-md-3"><!-- terkini -->
			<h3 style="border-bottom: 1px solid #ccc" class="mt30">Terkini</h3>
            <ul class="list-unstyled thumb-list-ul">
            	<?php foreach($sidebar_latest_news as $key=>$val): ?>
                <li class="media">
                    <a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
                    	<img src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>" class="mr-3 thumb-list" alt="<?=$val['title']?>">
                   	</a>
                    <div class="media-body">
                    	<a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
                        	<h5 class="mt-0 mb-1 thumb-list-title"><?=$val['title']?></h5>
                        </a>
                        <span class="fs11"><?=indonesian_date($val['create_date'], 'l, j M Y | H:i', 'WIB')?></span>
                    </div>
                </li>
                <?php endforeach; ?>
                <?php /*
                <li class="media">
                    <img src="<?=base_url().IMG_URL?>news/3.jpg" class="mr-3 thumb-list" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1 thumb-list-title">Kesbangpol DKI harapkan instruksi terkait pencari suaka</h5>
                    </div>
                </li> */?>
            </ul>
            <span class="leavespace"></span>
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