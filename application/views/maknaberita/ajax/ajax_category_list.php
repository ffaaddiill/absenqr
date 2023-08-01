<?php foreach($news_list as $key=>$val): ?>
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
<?php endforeach; ?>
<div><?=$links?></div>