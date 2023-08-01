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
                                <label for="movie_voucher">Voucher</label>
                                <input type="text" class="form-control" name="movie_voucher" id="movie_voucher" value="<?= (isset($post['movie_voucher'])) ? $post['movie_voucher'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="is_percentage">Percentage</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_percentage" id="is_percentage" <?= (isset($post['is_percentage']) && !empty($post['is_percentage'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount Nominal</label>
                                <input type="text" class="form-control number-only" name="discount" id="discount" value="<?= (isset($post['discount'])) ? $post['discount'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="start_date" id="start_date" value="<?= (isset($post['start_date'])) ? $post['start_date'] : date('Y-m-d') ?>" readonly="readonly"/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?= (isset($post['end_date'])) ? $post['end_date'] : '' ?>" readonly="readonly"/>
                                    <span class="input-group-addon end_date"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <label>
                                    <input type="checkbox" value="1" name="forever" id="forever" <?= ( (isset($post['forever']) && !empty($post['forever'])) || ( (empty($post['end_date']) || $post['end_date'] == '0000-00-00' || $post['end_date'] == '1970-01-01')) ) ? 'checked="checked"' : '' ?>/> Set as forever
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px;">
                        <div class="col-lg-4 col-lg-offset-6">
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
        <?php if (isset($post['id_news'])): ?>
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
                    $("#post-image").remove();
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
