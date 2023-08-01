<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=$page_title?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? $post['title'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="url_link">URL</label>
                                <input type="text" class="form-control" name="url_link" id="url_link" placeholder="with http://" value="<?= (isset($post['url_link'])) ? $post['url_link'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" name="position" id="uri_path" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="id_status">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="id_status" id="id_status" <?= (isset($post['id_status']) && !empty($post['id_status'])) ? 'checked="checked"' : '' ?>/>Active
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_site">Site</label>
                                <?php
                            if(!isset($list_site)){


                                foreach ($sites as $key => $value) {
                                

                                ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                    </label>
                                </div>
                                <?php
                                 }
                             }else{
                                foreach ($sites as $key => $value) {
                                    $checked_p="";
                                    if(in_array($value['id_site'], $list_site)){
                                        $checked_p = 'checked="checked"';
                                    }
                                ?>

                                <div class="checkbox">
                                    <label>
                                        <input <?=$checked_p?> type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                    </label>
                                </div>
                                <?php
                                }
                             }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="url_link">Microsite Setting</label>
                                <div class="panel-group" id="accordion_product" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion_product" href="#product_list" aria-expanded="true" aria-controls="product_list">
                                                    Assign to product
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="product_list" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">

                                                <?php 
                                                $a = 0;
                                                foreach($list_product as $key => $value) : ?>
                                                    <?php if(!isset($list_product)) : ?>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" value="<?=$value['id_product']?>" name="id_product" id="id_site"/><?=$value['title']?>
                                                            </label>
                                                        </div>
                                                    <?php else : ?>
                                                        <?php if($value['id_product'] == $product_slideshow['id_product']) : ?>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input checked="checked" type="radio" value="<?=$value['id_product']?>" name="id_product" id="id_product"/><?=$value['title']?>
                                                                </label>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="radio" value="<?=$value['id_product']?>" name="id_product" id="id_product"/><?=$value['title']?>
                                                                </label>
                                                            </div>
                                                        <?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php $a++; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="primary_image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php /* if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR . 'slideshow/' . $post['primary_image'])): ?>
                                            <img src="<?= RELATIVE_UPLOAD_DIR . 'slideshow/' . $post['primary_image'] ?>" id="post-image" />
                                        <?php endif; */ ?>
                                        <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                            <img src="<?=LOCAL_BLOB_URLPREFIX.LOCAL_FOLDER_UPLOADS.'/'.$post['primary_image']?>" id="post-image" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="primary_image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="img_alt">Image Alt</label>
                                <input type="text" class="form-control" name="image_alt" id="img_alt" value="<?= (isset($post['image_alt'])) ? $post['image_alt'] : '' ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

