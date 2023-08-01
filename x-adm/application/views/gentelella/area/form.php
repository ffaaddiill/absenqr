<script type="text/javascript">
<?php if (isset($post['id_product'])): ?>
    function delete_picture(param) {
        var self = $(param);
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
                $(self).prev().remove();
                self.remove();
            }
        });
    }
    <?php endif; ?>
</script>
<div class="page-title">
    <div class="title_left">
        <h3><?=$page_title?> Form</h3>
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>
<?php echo form_open($form_action,'role="form" class="form-horizontal" data-parsley-validate'); ?>
<div class="row">
    <div class="col-md-6 col-xs-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>List data</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="area_name">Area</label>
                                    <input type="text" class="form-control" name="area_name" id="area_name" value="<?= (isset($post['area_name'])) ? $post['area_name'] : '' ?>" placeholder="Area Name" />
                                </div>
                                <div class="form-group">
                                    <label for="slug">SEO URL / SLUG</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?= (isset($post['slug'])) ? $post['slug'] : '' ?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="flat" value="1" name="is_active" id="is_active" <?= (isset($post['is_active']) && !empty($post['is_active'])) ? 'checked="checked"' : '' ?>/>&nbsp;Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-8">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                </div>
            </div><!-- End of x_content -->
        </div>
    </div>
</div>
<?php echo form_close(); ?>

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
        $("#area_name").keyup(function() {
            $("#slug").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>