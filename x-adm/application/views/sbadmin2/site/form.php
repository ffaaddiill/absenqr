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
                <?=$page_title?> 
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Site Info</a></li>
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Site Settings</a></li>
                            <li role="presentation"><a href="#logo" aria-controls="logo" role="tab" data-toggle="tab">Logo Image</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /*tab content/ -->
                        <div class="tab-content">
                            <!-- /* info -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" id="site_name" value="<?=(isset($post['site_name'])) ? $post['site_name'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_url">Site URL</label>
                                            <input type="text" class="form-control" name="site_url" id="site_url" value="<?=(isset($post['site_url'])) ? $post['site_url'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_path">Site Path</label>
                                            <input type="text" class="form-control" name="site_path" id="site_path" value="<?=(isset($post['site_path'])) ? $post['site_path'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_address">Address</label>
                                            <textarea class="form-control" name="site_address" id="site_address"><?=(isset($post['site_address'])) ? $post['site_address'] : ''?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-2">
                                        <div class="form-group">
                                            <label for="is_default">Default</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_default" id="is_default" <?=(isset($post['is_default']) && !empty($post['is_default'])) ? 'checked="checked"' : ''?>/>Default
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Logo</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['site_logo']) && $post['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$post['site_logo'])): ?>
                                                        <img src="<?=RELATIVE_UPLOAD_DIR.'site/'.$post['site_logo']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?=$post['id_site']?>">x</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="site_logo">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /* info -->
                            <!-- /#settings -->
                            <div role="tabpanel" class="tab-pane fade" id="settings">
                                <div class="row">
                                    <?php  foreach ($post['setting'] as $row => $setting): 
                                        if($row){
                                    ?>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="<?=$row?>">
                                                    <?=ucwords(str_replace('_',' ',$row))?>
                                                    <?php if($row == 'web_keywords'): ?>
                                                        &nbsp;<span style="font-size: smaller;color: red;">* pisahkan kata dengan ( , ) koma</span></label>
                                                    <?php endif; ?>
                                                </label>

                                                <?php if($row == 'web_description'): ?>
                                                    <textarea class="form-control" name="setting[<?=$row?>]" id="<?=$row?>" rows="3"><?=$setting?></textarea>
                                                    <div id="counter"></div>
                                                <?php else : ?>
                                                    <textarea class="form-control" name="setting[<?=$row?>]" id="<?=$row?>" rows="1"><?=$setting?></textarea>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php 
                                        }
                                    endforeach; ?>
                                </div>
                                <script type="text/javascript">
                                    var characters= 65;
                                    $("#counter").append("You have  <strong>"+ characters+"</strong> characters remaining");                               

                                    $("#web_description").keyup(function() {
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
                            </div><!-- /#settings -->

                            <div role="tabpanel" class="tab-pane fade" id="logo">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="popup_banner">Popup Banner Home</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['popup_banner']) && $post['setting']['popup_banner'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['popup_banner']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="popup_banner">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Channel</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_channel']) && $post['setting']['image_home_channel'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_channel']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_channel">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Kualitas</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_kualitas']) && $post['setting']['image_home_kualitas'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_kualitas']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_kualitas">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Terjangkau</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_terjangkau']) && $post['setting']['image_home_terjangkau'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_terjangkau']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_terjangkau">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Layanan</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_layanan']) && $post['setting']['image_home_layanan'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_layanan']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_layanan">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /*for mobile image -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Channel Mobile</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_channel_mobile']) && $post['setting']['image_home_channel_mobile'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_channel_mobile']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_channel_mobile">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Kualitas Mobile</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_kualitas_mobile']) && $post['setting']['image_home_kualitas_mobile'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_kualitas_mobile']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_kualitas_mobile">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Terjangkau Mobile</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_terjangkau_mobile']) && $post['setting']['image_home_terjangkau_mobile'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_terjangkau_mobile']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_terjangkau_mobile">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="popup_banner">Image Home Layanan Mobile</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['setting']['image_home_layanan_mobile']) && $post['setting']['image_home_layanan_mobile'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.'site/'.$post['setting']['image_home_layanan_mobile']?>" id="post-image" />
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image_home_layanan_mobile">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.for mobile image -->
                                </div>
                            </div>
                        </div><!-- /*tab content/ -->

                        <div class="row">
                            <div class="col-lg-3">
                                <a class="btn btn-success" id="cek_seo"> Check SEO</a>
                            </div>
                            <div class="col-lg-4 col-lg-offset-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<style type="text/css">
.display_search_engine{
    display: block;
    width: 100%;
}
.display_search_engine h3{
    color: #1a0dab;
    margin-bottom: 1px;
    margin-top: 5px;
}
.display_search_engine .meta_link{
    display: block;
    color: #006621;
    font-style: normal;
}
.display_search_engine .meta_description{
    display: block;
}
.analisis_seo{

}
.analisis_seo h3{
    color: #1a0dab;
}
.analisis_seo .box{
    padding: 5px;
    margin-bottom: 5px;
    border: 1px #B2BFB2 solid;
}
.analisis_seo .meta_keyword{

}
.meta_keyword .title{

}
.meta_keyword .title span,.meta_title .title span,.meta_description .title span{
    color: #0FC149;
    font-weight: 900;
}
.meta_keyword .details{

}
.analisis_seo .meta_title{

}

.analisis_seo .meta_description{

}
.review_seo{

}
</style>

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

            var post = [//{name:"permalink",value:$('#uri_path').val()},
                        {name:"meta_description",value:$('#web_description').val()},
                        {name:"meta_keyword",value:$('#web_keywords').val()}
                        //{name:"teaser",value:$('#uri_path').val()},
                        //{name:"description",value:CKEDITOR.instances.description.getData()},
                        //{name:"title",value:$('#page_name').val()}
                        ];
            post.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=site_url("site/check_seo_site")?>',
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

        <?php if (isset($post['id_site'])): ?>
        $("#delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var post_delete = [{name:"id",value:id}];
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
                    $('.flash-message').html(data['error']);
                }
                if (data['success']) {
                    $('.flash-message').html(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });
        <?php endif; ?>
    });
</script>