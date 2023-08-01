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
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data" id="form-pages"'); ?>
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">Content</a></li>
                            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="content">
                                <div class="row">
                                    <div class="col-lg-8">
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
                                        <div class="">
                                            <label class="control-label" style="display: block;">Page Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="page_type" class="required" id="static_page" value="1" <?=(isset($post['page_type']) && $post['page_type'] == 1) ? 'checked="checked"' : ''?> /> Static Page
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="page_type" class="required" id="module" value="2" <?=(isset($post['page_type']) && $post['page_type'] == 2) ? 'checked="checked"' : ''?> /> Module
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="page_type" class="required" id="ext_link" value="3" <?=(isset($post['page_type']) && $post['page_type'] == 3) ? 'checked="checked"' : ''?> > External URL
                                            </label>
                                        </div>
                                        <div class="content-static-page" style="display: none; margin-top: 20px;">
                                            <div class="form-group">
                                                <label for="uri_path">SEO URL / SLUG</label>
                                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
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
                                    </div>
                                    <div class="col-lg-4">
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
                                                    <input type="checkbox" value="1" name="id_status" id="id_status" <?= (isset($post['id_status']) && !empty($post['id_status'])) ? 'checked="checked"' : '' ?>/>Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_featured">Featured</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_footer" id="is_footer" <?= (isset($post['is_footer']) && !empty($post['is_footer'])) ? 'checked="checked"' : '' ?>/>Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_header">Show in Header</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_header" id="is_header" <?= (isset($post['is_header']) && !empty($post['is_header'])) ? 'checked="checked"' : '' ?>/>Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_footer">Show in Footer</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_footer" id="is_footer" <?= (isset($post['is_footer']) && !empty($post['is_footer'])) ? 'checked="checked"' : '' ?>/>Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="thumbnail_image">Thumbnail Image</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">                             
                                                    <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['thumbnail_image']?>" id="post-image-thumbnail" />
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
                                                    <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['primary_image']?>" id="post-image-primary" />
                                                        <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_page'] ?>" data-type="primary">x</span>
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
<style type="text/css">


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
