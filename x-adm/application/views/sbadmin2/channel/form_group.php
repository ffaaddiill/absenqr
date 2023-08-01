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
                                <label for="title">Channel Group Name</label>
                                <input type="text" class="form-control" name="category_name" id="category_name" value="<?= (isset($post['category_name'])) ? $post['category_name'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" name="colour" id="colour" value="<?= (isset($post['colour'])) ? $post['colour'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
                            </div>
                           <!--  <div class="form-group">
                                <label for="title">Select Color</label>
                                <div class="input-group demo2">
                                    <input type="text" value="<?= (isset($post['colour'])) ? $post['colour'] : '' ?>" id="colour" name="colour" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-4">
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
<script type="text/javascript">
    $("#package_name").keyup(function() {
        $("#uri_path").val(convert_to_uri(this.value));
        
    });
</script>

