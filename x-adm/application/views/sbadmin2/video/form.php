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
                <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">Content</a></li>
                            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
                        </ul><!-- Nav tabs -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="content">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? $post['title'] : '' ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="embed">Youtube embed code </label>
                                            <input type="text" class="form-control" name="embed" id="embed" value="<?= (isset($post['embed'])) ? $post['embed'] : '' ?>"/>
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
                                            <label for="ext_link">External URL</label>
                                            <input type="text" class="form-control" name="ext_link" id="ext_link" placeholder="with http://" value="<?= (isset($post['ext_link'])) ? $post['ext_link'] : '' ?>"/>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="id_category">Category</label>
                                            <select id="id_category" name="id_category" class="form-control">
                                                <option value="0">Choose category</option>
                                                <?php foreach ($categorys as $category): ?>
                                                <option <?= (isset($post['id_category']) && $post['id_category']==$category['id_category']) ? 'selected="selected"' : ' ' ?>value="<?=$category['id_category']?>"><?=$category['name']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="id_status">Status</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="id_status" id="id_status" <?= (isset($post['id_status']) && !empty($post['id_status'])) ? 'checked="checked"' : '' ?>/>Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_site">Site</label>
                                            <?php
                                        if(!isset($list_site)){


                                            foreach ($sites as $key => $value) {
                                            

                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                                </label>
                                            </div>
                                            <?php
                                             }
                                         }else{
                                            foreach ($sites as $key => $value) {
                                                $checked_p="";
                                                if(in_array($value['id_site'], $list_site)){
                                                    $checked_p = 'checked="checked"';
                                                }
                                            ?>

                                            <div class="checkbox">
                                                <label>
                                                    <input <?=$checked_p?> type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                                </label>
                                            </div>
                                            <?php
                                            }
                                         }
                                            ?>
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
                                                <input type="text" class="form-control" name="end_date" id="end_date" value="<?= (isset($post['end_date'])) ? $post['end_date'] : '' ?>" readonly="readonly"/>
                                                <span class="input-group-addon end_date"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                            <label>
                                                <input type="checkbox" value="1" name="forever" id="forever" <?= ( (isset($post['forever']) && !empty($post['forever'])) || ( (empty($post['end_date']) || $post['end_date'] == '0000-00-00' || $post['end_date'] == '1970-01-01')) ) ? 'checked="checked"' : '' ?>/> Set as forever
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="thumbnail_image">Thumbnail Image</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php /* if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR . 'news/' . $post['thumbnail_image'])): ?>
                                                        <img src="<?= RELATIVE_UPLOAD_DIR . 'news/' . $post['thumbnail_image'] ?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="thumbnail">x</span>
                                                    <?php endif; */ ?>                                 
                                                    <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['thumbnail_image']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="thumbnail">x</span>
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
                                                    <?php /* if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR . 'news/' . $post['primary_image'])): ?>
                                                        <img src="<?= RELATIVE_UPLOAD_DIR . 'news/' . $post['primary_image'] ?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="primary">x</span>
                                                    <?php endif; */ ?>                                        
                                                    <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['primary_image']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="primary">x</span>
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
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="seo">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_keyword">Meta Keyword <span style="font-size: smaller;color: red;">* pisahkan kata dengan ( , ) koma</span></label>
                                            <textarea class="form-control" name="meta_keyword" id="meta_keyword"><?= (isset($post['meta_keyword'])) ? $post['meta_keyword'] : '' ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea id="meta_description" class="form-control" name="meta_description"><?= (isset($post['meta_description'])) ? $post['meta_description'] : '' ?></textarea>
                                            <div id="counter"></div>
                                        </div>
                                        <script type="text/javascript">
                                            var characters= 65;
                                            $("#counter").append("You have  <strong>"+ characters+"</strong> characters remaining");
                                                                                    

                                            $("#meta_description").keyup(function() {
                                                
                                                if($(this).val().length > characters){
                                                 $(this).val($(this).val().substr(0, characters));
                                                        }
                                                var remaining = characters -  $(this).val().length;
                                                $("#counter").html("You have <strong>"+  remaining+"</strong> characters remaining");
                                                if(remaining <= 10)
                                                {
                                                    $("#counter").css("color","red");
                                                }
                                                else
                                                {
                                                    $("#counter").css("color","black");
                                                }
                                            });
                                        </script>
                                        <div class="form-group">
                                            <a class="btn btn-success" id="cek_seo"> Check SEO</a>
                                        </div>
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
<!-- Modal -->
<div class="modal fade" id="ModalCekSEO" tabindex="-1" role="dialog" aria-labelledby="ModalCekSEOLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalCekSEOLabel">SEO Check</h4>
      </div>
      <div class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#cek_seo').click(function (){
            var self = $(this);

            var post = [{name:"permalink",value:$('#uri_path').val()},
                        {name:"meta_description",value:$('#meta_description').val()},
                        {name:"meta_keyword",value:$('#meta_keyword').val()},
                        {name:"teaser",value:$('#uri_path').val()},
                        {name:"description",value:CKEDITOR.instances.description.getData()},
                        {name:"title",value:$('#title').val()}

                        ];
            post.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=site_url("video/check_seo")?>',
                type:'post',
                data:post,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                $('#ModalCekSEO .modal-body').html(data['html']);
                $('#ModalCekSEO').modal('show');
            });
            
        });
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
