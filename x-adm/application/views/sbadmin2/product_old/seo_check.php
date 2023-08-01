<div class="form-group">
    <div class="display_search_engine">
        <h3><?=$title?></h3>
        <span class="meta_link"><?=$permalink?></span>
        <span class="meta_description"><?=$meta_description?> ...<span>
    </div>
    <div class="analisis_seo">
        <h3>Analisa SEO :</h3>
        <div class="box meta_keyword">
            <div class="title"><span>Meta Keyword :</span> <?=$meta_keyword?></div>
            <div class="details"><?=$meta_keyword_detail?></div>
        </div>
        <div class="box meta_title">
            <div class="title"><span>Meta Title :</span> <?=$title?></div>
            <div class="details"><?=$title_detail?></div>
        </div>
        <div class="box meta_description">
            <div class="title"><span>Meta Description :</span><?=$meta_description?></div>
            <div class="details"><?=$meta_description_detail?></div>
        </div>
    </div>
    <div class="review_seo">
        <h3>Review SEO :</h3>
        <?=$review?>
    </div>
</div>