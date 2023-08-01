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
                                <input type="text" class="form-control" name="name" id="title" value="<?= (isset($post['name'])) ? $post['name'] : '' ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="start_date">Start Time</label>
                                <input type="text" class="form-control datetimepicker" id="start_date" value="<?=(isset($schedule['start']) && $schedule['start'] != '') ? custDateFormat($schedule['start'],'Y-m-d H:i') : ''?>" name="start"/>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Time</label>
                                <input type="text" class="form-control datetimepicker" id="end_date" value="<?=(isset($schedule['end']) && $schedule['end'] != '') ? custDateFormat($schedule['end'],'Y-m-d H:i') : ''?>" name="end"/>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="active" id="active" <?= (isset($post['active']) && !empty($post['active'])) ? 'checked="checked"' : '' ?>/>Active
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                
                                    <input type="text" class="form-control" name="slug" id="slug" value="<?= (isset($post['slug'])) ? $post['slug'] : '' ?>"/>
                                
                            </div>
                            <div class="form-group">
                                <label for="discount_percent">Discount Percent</label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="discount_percent" id="discount_percent" value="<?= (isset($post['discount_percent'])) ? $post['discount_percent'] : '' ?>"/>
                                    </div>
                                    <div class="col-md-3">
                                        %
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
        
        <?php if (isset($post['id_harbolnas'])): ?>
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
        $("#title").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
