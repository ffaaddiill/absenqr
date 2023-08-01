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
                                <label for="description">Description</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- <div class="form-group">
                                <label for="title">Position</label>
                                <input type="text" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
                            </div> -->
                            <div class="form-group">
                                <label for="editiontime">Edition Time</label>
                                <input type="text" class="form-control" id="editiontime" value="<?= (isset($post['editiontime'])) ? $post['editiontime'] : '' ?>" name="editiontime"/>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['image']) && $post['image'] != ''): ?>
                                            <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MAGZ.'/'.$post['image']?>" id="post-image" />
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
                            <div class="form-group">
                                <label for="filemagz">File</label>
                                <?php if (isset($post['filemagz']) && $post['filemagz'] != ''): ?>
                                    <?=$post['filemagz']?><br/>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="filemagz" id="filemagz"/>
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

<script type="text/javascript">
    $(function() {
        <?php if (!isset($post['id_news'])): ?>
        $("#title").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
    $("form").on('focus','#editiontime',function() {
        $('#editiontime').datetimepicker({
            format: 'YYYY-MM',
            viewMode: "months", 
        });
    });
</script>
