<div class="container mt25">
    <div class="row">
        <div class="col-md-9"><!-- main -->
            <div class="row">
            	<?php foreach($news_list as $key=>$val): ?>
            		<?php if($key<4) : ?>
	                <div class="col-md-6 thumb-list-headline thumb-list-category">
	                		<a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
	                    		<img class="img-fluid mb10" src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>">
	                   	</a>
	                   	<div class="col-md-12 mb5 pl0">
				        		<i class="far fa-clock"></i><span class="fs12 ml5"><?=indonesian_date($val['create_date'])?></span>
				        </div>
				        <div class="col-md-12 mb10 pl0">
		                   	<a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
		                    		<strong class="big-headline-title"><?=$val['title']?></strong>
		                    	</a>
		                	</div>
                   		<div class="row">
                   			<div class="col-md-12 category-teaser">
                   				<?=trim_content_by_word($val['teaser'], 200)?>
                   				<p><a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">Selengkapnya >></a></p>
                   			</div>
                   		</div>
	                </div>
	                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="row"></div>
            <hr class="section" />
        </div>
        <div class="col-md-3 sidebar-terkini" ><!-- terkini -->
        		<center>
				<?php //$this->load->view(TEMPLATE_DIR.'/ads/longverticalbanner-sidebar'); ?>
			</center>
			
			<h3 style="border-bottom: 1px solid #ccc">Terkini</h3>
            <ul class="list-unstyled thumb-list-ul">
            		<?php foreach($sidebar_news_list as $key=>$val): ?>
                <li class="media">
                		<a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
                    		<img src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>" class="mr-3 thumb-list" alt="<?=$val['title']?>">
                  	</a>
                    <div class="media-body">
                    		<a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
                        		<h5 class="mt-0 mb-1 thumb-list-title"><?=$val['title']?></h5>
                   		</a>
                   		<div class="sidebar-meta-category"><a href="<?=base_url().$val['slug']?>" class="fs11"><?=$val['category_name']?></a></div>
                   		<div class="fs11"><?=indonesian_date($val['create_date'], 'l, j M Y | H:i', 'WIB')?></div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <span class="leavespace"></span>
        </div>
    </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<ul class="list-unstyled thumb-list-ul">
				<?php foreach($news_list as $key=>$val): ?>
	            		<?php if($key>3): ?>
		                <li class="media">
		                		<a href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
		                    		<img src="<?=base_url().NEWS_IMG_URL.$val['primary_image']?>" class="mr-3 thumb-list" alt="<?=$val['title']?>">
		                   	</a>
		                    <div class="media-body">
			                    <a class="news-link" href="<?=base_url().$val['slug'].'/'.$val['id_news'].'/'.$val['uri_path']?>">
			                        <h5 class="mt-0 mb-1 thumb-list-title"><?=$val['title']?></h5>
			                    </a>
			                    <div class="col-md-12 category-teaser pl0">
		               				<i class="far fa-clock"></i><div class="fs12 d-inline-block ml5"><?=indonesian_date($val['create_date'], 'l, j M Y | H:i', 'WIB')?></div>
		               			</div>
		                    </div>
		                </li>
		                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="row">
	            <div class="col-md-12 text-center">
	        			<a class="btn btn-sm btn-outline-dark rounded-0" href="<?=base_url().$category_slug?>/index-berita">Selanjutnya</a>
				</div>
			</div>
		</div>
		
		<?php if(isset($_GET['debug']) && $_GET['debug']=='123'): ?>
		<div class="col-md-12">
			<?=$links?>
		</div>
		<?php endif; ?>
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