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
<?php echo form_open($form_action,'role="form" class="form-horizontal" data-parsley-validate'); ?>
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

                <!-- begin tab -->
                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="siteinfo" data-toggle="tab" href="#tab-siteinfo" role="tab" aria-controls="home" aria-selected="true">Site Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="settings" data-toggle="tab" href="#tab-setting" role="tab" aria-controls="profile" aria-selected="false">Site Setting</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-siteinfo" role="tabpanel" aria-labelledby="tab-siteinfo">
                        <!-- site info -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-12">
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
                                            <label for="phone">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="<?=(isset($post['phone'])) ? $post['phone'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?=(isset($post['email'])) ? $post['email'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="slogan">Slogan</label>
                                            <textarea rows="3" class="form-control" name="slogan" id="slogan" maxlength="300"><?=(isset($post['slogan'])) ? $post['slogan'] : ''?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_address">Address</label>
                                            <textarea rows="5" class="form-control" name="site_address" id="site_address"><?=(isset($post['site_address'])) ? $post['site_address'] : ''?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="maps">Maps (you can input iframe from google maps or other source)</label>
                                            <textarea rows="5" class="form-control" name="maps" id="maps"><?=(isset($post['maps'])) ? $post['maps'] : ''?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_default">Default</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" value="1" name="is_default" id="is_default" <?=(isset($post['is_default']) && !empty($post['is_default'])) ? 'checked="checked"' : ''?>/>&nbsp;Default
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                        </div>
                        <!-- end site info -->
                    </div>
                    <div class="tab-pane fade" id="tab-setting" role="tabpanel" aria-labelledby="tab-setting">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="display:flex;align-items: center;">This setting is under maintenance. Coming Soon !</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end tab -->
                
            </div><!-- End of x_content -->
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