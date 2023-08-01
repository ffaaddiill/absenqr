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
                   	<!-- /#content program -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="quiz_title">Program Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?=(isset($post['name'])) ? $post['name'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="quiz_content">Description Program</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?=(isset($post['description'])) ? $post['description'] : ''?></textarea>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <input type="text" readonly class="form-control" name="uri_path" id="uri_path" value="<?=(isset($post['uri_path'])) ? $post['uri_path'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label for="quiz_status">Status</label>
                                <select class="form-control" name="id_status">
                                	<?php
                                	foreach ($status_list as $status) {
                                	?>
                                	<option <?=(isset($post['id_status']) && $post['id_status']==$status['id_status']) ? 'selected="selected"' : ''?> value="<?=$status['id_status']?>"><?=$status['status_text']?></option>
                                	<?php
                                	}
                                	?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['quiz_image']) && $post['quiz_image'] != '' && file_exists(UPLOAD_DIR.'quiz/'.$post['quiz_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'quiz/'.$post['quiz_image']?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?=$post['id_quiz']?>">x</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#content program -->
                            
                    
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
$("#name").keyup(function() {
        $("#uri_path").val(convert_to_uri(this.value));
        
    });
</script>

