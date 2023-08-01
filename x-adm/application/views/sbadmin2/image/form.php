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
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data" id="form-pages"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <select id="page_id" name="page_id" class="form-control">
                                    <option value="0">Please Select Page</option>
                                    <?php foreach ($page_data as $page): ?>
                                    <option <?= (isset($post['page_id']) && $post['page_id']==$page->id) ? 'selected="selected"' : ' ' ?>value="<?=$page->id?>"><?=$page->title?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" required="required" name="name" id="name" value="<?= (isset($post['name'])) ? $post['name'] : '' ?>"/>
                            </div>
                            
                            
                            
                            
                            
                            
                            
                        </div>
                        <div class="col-lg-4">
                            
                            <div class="form-group">
                                <label for="primary_image">Primary Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['image']) && $post['image'] != ''): ?>
                                            <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_PRABAYAR.'/'.$post['image']?>" id="post-image-primary" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id'] ?>" data-type="">x</span>
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
        <?php if (isset($post['id'])): ?>
        $(".delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var type = self.attr('data-type');
            var post_delete = [{name:"id",value:id},{name:"type",value:type}];
            post_delete.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:post_delete,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    $(".flash-message").html(data['error']);
                }
                if (data['success']) {
                    $(".flash-message").html(data['success']);
                    $("#post-image-primary").remove();
                    self.remove();
                }
            });
        });
        <?php else: ?>
        $("#title").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
        
    });
</script>
