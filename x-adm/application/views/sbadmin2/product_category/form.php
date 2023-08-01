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
                                <label for="category_name">Category</label>
                                <input type="text" class="form-control" name="category_name" id="category_name" value="<?= (isset($post['category_name'])) ? $post['category_name'] : '' ?>" placeholder="Category Name" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                        	<div class="form-group">
                                <label for="slug">SEO URL / SLUG</label>
                                <input type="text" class="form-control" name="slug" id="slug" value="<?= (isset($post['slug'])) ? $post['slug'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_active" id="is_active" <?= (isset($post['is_active']) && !empty($post['is_active'])) ? 'checked="checked"' : '' ?>/>Active
                                    </label>
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
        $("#forever").change(function() {
            var self = $(this);
            if (self.prop('checked') == true) {
                $("#end_date").attr('disabled',true);
                $("#end_date").val('');
                $(".input-group-addon.end_date").addClass('blocked');
            } else {
                $("#end_date").removeAttr('disabled');
                $(".input-group-addon.end_date").removeClass('blocked');
            }
        });
        $("#forever").trigger('change');
        <?php if (isset($post['id_highlight'])): ?>
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
                    //$("#post-image").remove();
                    self.prev('#post-image').remove();
                    self.remove();
                }
            });
        });
        <?php else: ?>
        $("#category_name").keyup(function() {
            $("#slug").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
