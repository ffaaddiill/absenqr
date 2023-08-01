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
                                    <label for="customFile">Pilih File</label>
                                    <input style="border: 2px solid #E6E9ED" name="file" type="file" class="form-control-file p-3" id="customFile">
                              </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary">Upload</button>
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
