<div id="content" class="row">
	<div class="col-md-12">
		<h1><?=$promonews['title']?></h1>
		<?php if($promonews['image']): ?>
			<img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS . '/' . $promonews['image']?>" class="img-responsive">
		<?php endif; ?>
	</div>
	<div class="col-md-12"><?=$promonews['description']?></div>
</div>