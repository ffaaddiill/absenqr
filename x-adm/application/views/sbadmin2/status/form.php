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
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data" id="form-pages" class="form-horizontal"'); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="division_code" class="col-sm-2 control-label">Label Status</label>
                                <div class="col-sm-10">
                                    <input name="status" value="<?= (isset($post['status'])) ? $post['status']:'' ?>" class="form-control" id="division_code" placeholder="Label Status">
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
        <?php if (isset($post['id_page'])): ?>
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
                    $("#post-image-"+type).remove();
                    self.remove();
                }
            });
        });
        <?php else: ?>
        $("#page_name").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
        $(function() {
            $('#form-pages').on('change','input[name=page_type]',function() {
                var self = $(this);
                // static page
                if (self.val() == 1) {
                    $('.content-module, .content-ext-link').slideUp('fast',function() {
                        $(".content-static-page").delay(500).slideDown('slow');
                    });
                } else if (self.val() == 2) {
                    $('.content-static-page, .content-ext-link').slideUp('fast',function() {
                        $(".content-module").delay(500).slideDown('slow');
                    });
                } else if (self.val() == 3) {
                    $('.content-static-page, .content-module').slideUp('fast',function() {
                        $(".content-ext-link").delay(500).slideDown('slow');
                    });
                } else {
                    $('.content-static-page, .content-module, .content-ext-link').hide();
                }
            });
            $('input[name=page_type]:checked').trigger('change');
        });
    });
</script>
