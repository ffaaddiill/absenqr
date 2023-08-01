<script type="text/javascript">
<?php if (isset($post['id_page'])): ?>
    function delete_picture(param) {
        confirm('Are you sure ?');
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
            if (data.error)  {
                $(".flash-message").html(data['error']);
            }
            if (data.success) {
                $('.fileinput-upload').html('');
                $(".flash-message").html(data.success);
                $('.fileinput-upload').html('');
            }
        });
    }
    <?php endif; ?>
</script>
<div class="row">
    <div class="col-md-12">
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
        </div>
    </div>
</div>
<?php echo form_open($form_action,'role="form" enctype="multipart/form-data" class="form-horizontal" id="form-page" data-parsley-validate'); ?>
<div class="row">
    <div class="col-md-6 col-sm-12 ">
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
                                    <label for="parent_page">Parent</label>
                                    <select class="form-control" name="parent_page" id="parent_page">
                                        <option value="0">ROOT</option>
                                        <?=$parent_html?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="page_name">Title</label>
                                    <input type="text" class="form-control" required="required" name="page_name" id="page_name" value="<?= (isset($post['page_name'])) ? $post['page_name'] : '' ?>"/>
                                </div>
                                <div class="radio">
                                    <label class="control-label" style="display: block;">Page Type</label>
                                    
                                   
                                    <label class="radio-inline">
                                        <input type="radio" name="page_type" class="flat required" value="1" <?=(isset($post['page_type']) && $post['page_type'] == 1) ? 'checked' : ''?>> Static Page
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="page_type" class="flat required" value="2" <?=(isset($post['page_type']) && $post['page_type'] == 2) ? 'checked' : ''?>> Module
                                    </label>
                                    
                                    <label class="radio-inline">
                                        <input type="radio" name="page_type" class="flat required" value="3" <?=(isset($post['page_type']) && $post['page_type'] == 3) ? 'checked' : ''?>> External Link
                                    </label>
                                </div>
                                <div class="content-static-page" style="display: none; margin-top: 20px;">
                                    <div class="form-group">
                                        <label for="uri_path">SEO URL / SLUG</label>
                                        <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="content-module" style="display: none; margin-top: 20px;">
                                    <div class="form-group">
                                        <label for="module">Module</label>
                                        <input type="text" class="form-control" name="module" id="module" value="<?= (isset($post['module'])) ? $post['module'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="content-ext-link" style="display: none; margin-top: 20px;">
                                    <div class="form-group">
                                        <label for="ext_link">External URL</label>
                                        <input type="text" class="form-control" name="ext_link" id="ext_link" placeholder="with http://" value="<?= (isset($post['ext_link'])) ? $post['ext_link'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="teaser">Teaser</label>
                                        <textarea class="form-control" name="teaser" id="teaser" rows="8"><?= (isset($post['teaser'])) ? $post['teaser'] : '' ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
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

    <div class="col-md-6 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Extra</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- a -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block" for="primary_image">Primary Image</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                                         
                                    <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                        <img class="img-thumbnail" src="<?=FRONTEND_ASSETS_DIR.$post['primary_image']?>" id="post-image" />
                                        <span onclick="delete_picture(this)" class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_page'] ?>" data-type="primary">x</span>
                                    <?php endif; ?>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                <div>
                                    <span class="btn btn-sm btn-light btn-file" style="border:1px solid #ddd">
                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                        <input type="file" name="primary_image">
                                    </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- b -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- BEGIN extra option -->
                        <div class="form-group">
                            <label for="slug">SEO URL / SLUG</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="<?= (isset($post['slug'])) ? $post['slug'] : '' ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="number" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="id_status">Status</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" value="1" name="id_status" id="id_status" <?= (isset($post['id_status']) && !empty($post['id_status'])) ? 'checked="checked"' : '' ?>/>&nbsp;Active
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_featured">Featured</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" value="1" name="is_featured" id="is_featured" <?= (isset($post['is_featured']) && !empty($post['is_featured'])) ? 'checked="checked"' : '' ?>/>&nbsp;Yes
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="is_header">Show in Header</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" value="1" name="is_header" id="is_header" <?= (isset($post['is_header']) && !empty($post['is_header'])) ? 'checked="checked"' : '' ?>/>&nbsp;Yes
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_footer">Show in Footer</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" value="1" name="is_footer" id="is_footer" <?= (isset($post['is_footer']) && !empty($post['is_footer'])) ? 'checked="checked"' : '' ?>/>&nbsp;Yes
                                </label>
                            </div>
                        </div>
                        
                        <!-- END of extra option -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

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

            var post = [{name:"permalink",value:$('#uri_path').val()},
                        {name:"meta_description",value:$('#meta_description').val()},
                        {name:"meta_keyword",value:$('#meta_keyword').val()},
                        {name:"teaser",value:$('#uri_path').val()},
                        {name:"description",value:CKEDITOR.instances.description.getData()},
                        {name:"title",value:$('#page_name').val()}

                        ];
            post.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=site_url("pages/check_seo")?>',
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
            $("#slug").val(convert_to_uri(this.value));
        });
        <?php endif; ?>

        $('input[name=page_type]').change(function() {
                var self = $(this);
                if (self.val() == 1) {// static page
                    $('.content-module, .content-ext-link').slideUp('fast',function() {
                        $(".content-static-page").delay(300).slideDown('slow');
                    });
                } else if (self.val() == 2) {// module page
                    $('.content-static-page, .content-ext-link').slideUp('fast',function() {
                        $(".content-module").delay(300).slideDown('fast');
                    });
                } else if (self.val() == 3) {// external link
                    $('.content-static-page, .content-module').slideUp('fast',function() {
                        $(".content-ext-link").delay(300).slideDown('fast');
                    });
                } else {
                    $('.content-static-page, .content-module, .content-ext-link').hide();
                }
            });
            $('input[name=page_type]:checked').trigger('change');
    });
</script>
