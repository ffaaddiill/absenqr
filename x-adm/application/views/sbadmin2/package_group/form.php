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
                    <!--.package-->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Package Info</a></li>
                            <li role="presentation"><a href="#channel" aria-controls="channel" role="tab" data-toggle="tab">Item</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#info -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <!-- /.row (nested) -->
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="title">Package Name</label>
                                            <input type="text" class="form-control" name="package_name" id="package_name" value="<?= (isset($post['package_name'])) ? $post['package_name'] : '' ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="teaser">Summary</label>
                                            <textarea class="form-control" name="summary" id="summary" rows="8"><?= (isset($post['summary'])) ? $post['summary'] : '' ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="uri_path">SEO URL / SLUG</label>
                                            <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="position">Position</label>
                                            <input type="text" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price (IDR)</label>
                                            <input type="number" class="form-control" name="price" id="price" value="<?= (isset($post['price'])) ? $post['price'] : '' ?>"/>
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
                                        <div class="form-group">
                                            <label for="is_featured">Sold Out</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_soldout" id="is_soldout" <?= (isset($post['is_soldout']) && !empty($post['is_soldout'])) ? 'checked="checked"' : '' ?>/>Yes
                                                </label>
                                            </div>
                                        </div>
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
                            </div><!-- /#info -->
                            <!-- /#channel -->
                            <div role="tabpanel" class="tab-pane fade" id="channel">
                                <!-- /.row (nested) -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Main Package</label>
                                        <?php foreach ($main_packages as $row => $package): $package_checked=''; ?>
                                            <?php if (isset($post['packages'])) {
                                                $post_package = array_column($post['packages'], 'id_package');
                                                if (in_array($package['id_package'], $post_package)) {
                                                    $package_checked = 'checked="checked"';
                                                }
                                            } ?>
                                            <div class="checkbox">
                                                <label>
                                                <input type="checkbox" id="package_<?=$row?>" value="<?=$package['id_package']?>" name="packages[][id_package]" <?=$package_checked?>/> <?=$package['package_name']?>
                                                </label>
                                            </div>
                                            
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Addon Package</label>
                                        <?php foreach ($addon_packages as $row => $addon_package): $addon_package_checked=''; ?>
                                            <?php if (isset($post['addon_packages'])) {
                                                $post_addon_package = array_column($post['addon_packages'], 'id_package');
                                                if (in_array($addon_package['id_package_addon'], $post_addon_package)) {
                                                    $addon_package_checked = 'checked="checked"';
                                                }
                                            } ?>
                                            <div class="checkbox">
                                                <label>
                                                <input type="checkbox" id="addon_package_<?=$row?>" value="<?=$addon_package['id_package_addon']?>" name="addon_packages[][id_package_addon]" <?=$addon_package_checked?>/> <?=$addon_package['addon_name']?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div><!-- /#addon_package -->
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

