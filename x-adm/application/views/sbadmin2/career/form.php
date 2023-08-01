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
                <?php echo form_open($form_action,'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="division">Division</label>
                                <input type="text" class="form-control" name="division" id="division" value="<?= (isset($post['division'])) ? $post['division'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? $post['title'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="requirement">Requirement</label>
                                <textarea class="form-control ckeditor" name="requirement" id="requirement" rows="8"><?= (isset($post['requirement'])) ? $post['requirement'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
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
                                <label for="publish_date">Publish Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="publish_date" id="publish_date" value="<?= (isset($post['publish_date'])) ? $post['publish_date'] : date('Y-m-d') ?>" readonly="readonly"/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?= (isset($post['end_date'])) ? $post['end_date'].'adsasd' : '' ?>" readonly="readonly"/>
                                    <span class="input-group-addon end_date"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <label>
                                    <input type="checkbox" value="1" name="forever" id="forever" <?= ( (isset($post['forever']) && !empty($post['forever'])) || ( (empty($post['end_date']) || $post['end_date'] == '0000-00-00' || $post['end_date'] == '1970-01-01')) ) ? 'checked="checked"' : '' ?>/> Set as forever
                                </label>
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
        <?php if (!isset($post['id_career'])): ?>
        $("#title").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
