<div class="row" id="slideContainer">
    <div class="col-xs-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                    foreach ($slideshows as $key => $li) {
                        $active_li = '';
                        if($key==0){
                            $active_li='active';
                        }
                ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?=$key?>" class="<?=$active_li?>"></li>
                <?php     # code...
                    }
                ?>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">                
                <?php
                    foreach ($slideshows as $key => $slideshow) {
                        $active_item = '';
                        if($key==0){
                            $active_item='active';
                        }
                ?>
                    <div class="item <?=$active_item?>">
                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_PRABAYAR.'/'.$slideshow['image']?>" alt="">
                    </div>
                <?php     
                    }
                ?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <div class="sprite-left"></div>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <div class="sprite-right"></div>
            </a>
        </div>
    </div>
</div>
<!-- your content, example : -->
<div id="content" class="row">
    <div class="col-md-12">
        <h2 class="header"><?=$detail_page['title']?></h2>
    </div>
    <div class="col-md-12">
    	<?php
    		if($detail_page['image'] != ''){

    		
    	?>
    	<img class="img-responsive" src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_PRABAYAR.'/'.$detail_page['image']?>">
    	<?php
    		}
    	?>
    	<?=$detail_page['description']?>
    </div>
</div>