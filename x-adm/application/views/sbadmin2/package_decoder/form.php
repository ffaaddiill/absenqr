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
                    <!-- /.row (nested) -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="title">Decoder Name</label>
                                <input type="text" class="form-control" name="decoder_name" id="decoder_name" value="<?= (isset($post['decoder_name'])) ? $post['decoder_name'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!--div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
                            </div-->
                            <div class="form-group">
                                <label for="price">Price (IDR)</label>
                                <input type="number" class="form-control" name="price_decoder" id="price_decoder" value="<?= (isset($post['price_decoder'])) ? $post['price_decoder'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="uri_path">Position</label>
                                <input type="text" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
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
                                <label for="is_featured">Featured</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_featured" id="is_featured" <?= (isset($post['is_featured']) && !empty($post['is_featured'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <!--div class="form-group">
                                <label for="is_featured">Sold Out</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_soldout" id="is_soldout" <?= (isset($post['is_soldout']) && !empty($post['is_soldout'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div-->
                            <!-- <div class="form-group">
                                <label for="thumbnail_image">Thumbnail Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php /* if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR . 'movie/' . $post['thumbnail_image'])): ?>
                                          <img src="<?= RELATIVE_UPLOAD_DIR . 'movie/' . $post['thumbnail_image'] ?>" id="post-image" />
                                          <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_movie'] ?>" data-type="thumbnail">x</span>
                                          <?php endif; */ ?>                                 
                                        <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != ''): ?>
                                            <img src="<?= AZURE_BLOB_URLPREFIX . AZURE_FOLDER_MOVIE . '/' . $post['thumbnail_image'] ?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_movie'] ?>" data-type="thumbnail">x</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="thumbnail_image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="primary_image">Primary Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php /* if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR . 'movie/' . $post['primary_image'])): ?>
                                          <img src="<?= RELATIVE_UPLOAD_DIR . 'movie/' . $post['primary_image'] ?>" id="post-image" />
                                          <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_movie'] ?>" data-type="primary">x</span>
                                          <?php endif; */ ?>                                        
                                        <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                            <img src="<?= AZURE_BLOB_URLPREFIX . AZURE_FOLDER_MOVIE . '/' . $post['primary_image'] ?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_movie'] ?>" data-type="primary">x</span>
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
                            </div> -->
                        </div>
                    </div>
                    
                    <div class="row">
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
<!--script type="text/javascript">
    $("#decoder_name").keyup(function() {
        $("#uri_path").val(convert_to_uri(this.value));
        
    });
</script-->

