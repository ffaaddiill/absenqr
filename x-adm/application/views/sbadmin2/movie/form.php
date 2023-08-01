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
            <div class="panel-body" style="padding-left: 11px !important; padding-right: 11px !important;">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <!-- /#movietabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#movie" aria-controls="movie" role="tab" data-toggle="tab">Movie Info</a></li>
                            <li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Schedule</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#movie -->
                            <div role="tabpanel" class="tab-pane fade in active" id="movie">
                                <!-- /.row (nested) -->
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? $post['title'] : '' ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="teaser">Teaser</label>
                                            <textarea class="form-control" name="teaser" id="teaser" rows="8"><?= (isset($post['teaser'])) ? $post['teaser'] : '' ?></textarea>
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
                                            <label for="price">Price (IDR)</label>
                                            <input type="number" class="form-control" name="price" id="price" value="<?= (isset($post['price'])) ? $post['price'] : '' ?>"/>
                                        </div>
                                            <div class="form-group">
                                                <label for="plan_code">Plan Code</label>
                                                <input type="text" class="form-control" name="plan_code" id="plan_code" value="<?= (isset($post['plan_code'])) ? $post['plan_code'] : '' ?>"/>
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
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /#movie -->
                            <!-- /#schedule -->
                            <div role="tabpanel" class="tab-pane fade" id="schedule">
                                <div class="row group-form-field">
                                    <?php if (isset($post['schedules'])) : ?>
                                    <?php foreach ($post['schedules'] as $row => $schedule): ?>
                                        <div class="row-schedule" id="row-schedule-<?=$row?>">
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="channel_number_<?=$row?>" <?=($row>0) ? 'style="display:none;"' : ''?>>Channel</label>
                                                    <input type="text" class="form-control" id="channel_number_<?=$row?>" value="<?=(isset($schedule['channel_number'])) ? $schedule['channel_number'] : ''?>" name="schedules[<?=$row?>][channel_number]"/>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <label for="start_time_<?=$row?>" <?=($row>0) ? 'style="display:none;"' : ''?>>Start Time</label>
                                                    <input type="text" class="form-control datetimepicker" id="start_time_<?=$row?>" value="<?=(isset($schedule['start_time']) && $schedule['start_time'] != '') ? custDateFormat($schedule['start_time'],'Y-m-d H:i') : ''?>" name="schedules[<?=$row?>][start_time]"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="end_time_<?=$row?>" <?=($row>0) ? 'style="display:none;"' : ''?>>End Time</label>
                                                    <input type="text" class="form-control datetimepicker" id="end_time_<?=$row?>" value="<?=(isset($schedule['end_time']) && $schedule['end_time'] != '') ? custDateFormat($schedule['end_time'],'Y-m-d H:i') : ''?>" name="schedules[<?=$row?>][end_time]"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="price_override_<?=$row?>" <?=($row>0) ? 'style="display:none;"' : ''?>>Price</label>
                                                    <input type="text" class="form-control" id="price_override_<?=$row?>" value="<?=(isset($schedule['price_override'])) ? $schedule['price_override'] : ''?>" name="schedules[<?=$row?>][price_override]"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 text-right">
                                                <div class="form-group">
                                                    <label style="display:<?=($row==0) ? 'block' : 'none'?>;">&nbsp;</label>
                                                    <button type="button" class="btn btn-danger" onclick="removeSchedule('<?=$row?>');"><i class="glyphicon glyphicon-minus-sign"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="row group-form-button">
                                    <div class="col-lg-2 col-lg-offset-10 text-right">
                                        <button type="button" class="btn btn-success" onclick="addSchedule();"><i class="glyphicon glyphicon-plus-sign"></i></button>
                                    </div>
                                </div>
                            </div><!-- /#schedule -->
                        </div><!-- /.tab content -->
                    </div><!-- /#movietabs -->
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
    var html;
    function removeSchedule(id) {
        $("#row-schedule-"+id).remove();
    }
    function addSchedule() {
        var row = $(".row-schedule").length;
        var not_show = 'style="display:block;"';
        if (row > 0) {
            not_show = 'style="display:none;"';
        }
        html = '\
            <div class="row-schedule" id="row-schedule-'+row+'">\
                <div class="col-lg-2">\
                    <div class="form-group">\
                        <label for="channel_number_'+row+'" '+not_show+'>Channel</label>\
                        <input type="text" class="form-control" id="channel_number_'+row+'" value="" name="schedules['+row+'][channel_number]"/>\
                    </div>\
                </div>\
                <div class="col-lg-3">\
                    <div class="form-group">\
                        <label for="start_time_'+row+'" '+not_show+'>Start Time</label>\
                        <input type="text" class="form-control datetimepicker" id="start_time_'+row+'" value="" name="schedules['+row+'][start_time]"/>\
                    </div>\
                </div>\
                <div class="col-lg-3">\
                    <div class="form-group">\
                        <label for="end_time_'+row+'" '+not_show+'>End Time</label>\
                        <input type="text" class="form-control datetimepicker" id="end_time_'+row+'" value="" name="schedules['+row+'][end_time]"/>\
                    </div>\
                </div>\
                <div class="col-lg-2">\
                    <div class="form-group">\
                        <label for="price_override_'+row+'" '+not_show+'>Price</label>\
                        <input type="text" class="form-control" id="price_override_'+row+'" value="" name="schedules['+row+'][price_override]"/>\
                    </div>\
                </div>\
                <div class="col-lg-2 text-right">\
                    <div class="form-group">\
                        <label '+not_show+'>&nbsp;</label>\
                        <button type="button" class="btn btn-danger" onclick="removeSchedule(\''+row+'\');"><i class="glyphicon glyphicon-minus-sign"></i></button>\
                    </div>\
                </div>\
            </div>';
        $(".group-form-field").append(html);
        //row++;
    }
    $(function() {
        <?php if (isset($post['id_movie'])): ?>
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
