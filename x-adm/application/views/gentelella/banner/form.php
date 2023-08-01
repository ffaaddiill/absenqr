<script type="text/javascript">
<?php if (isset($post['id_banner'])): ?>
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
<?php echo form_open($form_action,'role="form" enctype="multipart/form-data" class="form-horizontal" data-parsley-validate'); ?>
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
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? html_entity_decode($post['title']) : '' ?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="teaser">Teaser</label>
                                    <!-- teaser -->
                                    <textarea name="teaser" id="teaser"><?= (isset($post['teaser'])) ? $post['teaser'] : '' ?></textarea>
                                    <br>
                                    <!-- end of teaser -->
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <!-- description -->
                                    <textarea name="description" id="description"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                                    <!-- end of description -->
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
                                        <span onclick="delete_picture(this)" class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_banner'] ?>" data-type="primary">x</span>
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
                            <label for="ext_link">External URL</label>
                            <input type="text" class="form-control" name="ext_link" id="ext_link" placeholder="with http://" value="<?= (isset($post['ext_link'])) ? $post['ext_link'] : '' ?>"/>
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
                            <label for="id_status">Set as</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" value="1" name="is_productheadline" id="is_productheadline" <?= (isset($post['is_productheadline']) && !empty($post['is_productheadline'])) ? 'checked="checked"' : '' ?>/>&nbsp;Headline Product
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="publish_date">Publish Date</label>
                            <div class='input-group date' id='publish_date'>
                               <input type='text' name="publish_date" class="form-control" value="<?= (isset($post['publish_date'])) ? $post['publish_date'] : '' ?>"/>
                               <span style="padding: 8px 12px;cursor: pointer;" class="input-group-addon"><i class="fa fa-calendar" style="font-size: 20px" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>                        
                            <div class='input-group date' id='end_date'>
                               <input type='text' name="end_date" class="form-control" value="<?= (isset($post['end_date'])) ? $post['end_date'] : '' ?>" readonly="readonly"/>
                               <span style="padding: 8px 12px;cursor: pointer;" class="input-group-addon"><i class="fa fa-calendar" style="font-size: 20px" aria-hidden="true"></i></span>
                            </div>

                            <label>
                                <input type="checkbox" class="flat" value="1" name="forever" id="forever" <?= ( (isset($post['forever']) && !empty($post['forever'])) || ( (empty($post['end_date']) || $post['end_date'] == '0000-00-00' || $post['end_date'] == '1970-01-01')) ) ? 'checked="checked"' : '' ?>/>&nbsp;Set as forever
                            </label>
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

            var post = [{name:"permalink",value:$('#slug').val()},
                        {name:"meta_description",value:$('#meta_description').val()},
                        {name:"meta_keyword",value:$('#meta_keyword').val()},
                        {name:"teaser",value:$('#slug').val()},
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

        $("#forever").change(function() {
            var self = $(this);
            if (self.prop('checked') == true) {
                $("#end_date input").prop('disabled',true);
                $("#end_date input").prop('readonly',true);
                console.log('forever true ! ' + 'attr: ' + $('#end_date').attr('disabled'));
                $("#end_date input").val('');
                $(".input-group-addon").addClass('blocked');
            } else {
                $("#end_date input").prop('disabled',false);
                $("#end_date input").prop('readonly',false);
                console.log('forever false ! ' + 'attr: ' + $('#end_date').attr('disabled'));
                $("#end_date input").removeAttr('disabled');
                $(".input-group-addon").removeClass('blocked');
            }
        });
        $("#forever").trigger('change');
        
        /*new TempusDominus(document.getElementById('end_date'), {
          //put your config here
        });*/        
        
        $('#li-video').hide();
        $('#video').hide();
        
        <?php if( isset($post['video_id']) ): ?>
            $('#li-video').removeAttr('style');
            $('#video').removeAttr('style');
        <?php else: ?>
            $('#li-video').attr('style', 'display:none');
            $('#video').attr('style', 'display:none');
        <?php endif; ?>

        $("#title").keyup(function() {
            $("#slug").val(convert_to_uri(this.value));
        });
        
        /*$('#product_type').change(function() {
            if($(this).val() == 'video') {
                $('#li-video').removeAttr('style');
                $('#video').removeAttr('style');
            } else {
                $('#li-video').attr('style', 'display:none');
                $('#video').attr('style', 'display:none');
                <?php if(!isset($post['video_id'])): ?>
                $('#video_url').val('');
                $('#video_id').val('');
                <?php endif; ?>
            }
        });*/
    });
</script>
