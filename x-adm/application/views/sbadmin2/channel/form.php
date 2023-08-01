<style type="text/css">
.wrapper-addon{
	display: block;
  overflow-y: auto;
  height : 300px;
}
</style>
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
                <!-- /#channelisttabs -->
                    <div role="tabpanel" id="tabster">
                    	<!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#channel" aria-controls="channel" role="tab" data-toggle="tab">Channel</a></li>
                            <li role="presentation"><a href="#package" aria-controls="package" role="tab" data-toggle="tab">Package</a></li>
                            <li role="presentation"><a href="#package_addon" aria-controls="package_addon" role="tab" data-toggle="tab">Package Add On</a></li>
                            <li role="presentation"><a href="#tab_channel_number" aria-controls="tab_channel_number" role="tab" data-toggle="tab">Channel Number</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                        	<!-- /#quiz -->
                            <div role="tabpanel" class="tab-pane fade in active" id="channel">
			                    <!-- /.row (nested) -->
			                    <div class="row">
			                        <div class="col-lg-8">
			                        	<div class="form-group">
			                                <label for="title">Category Channel</label>
			                                <select id="id_channel_category" name="id_channel_category" class="form-control">
			                                	<option value="0">Add On Only</option>
			                                	<?php foreach ($category_channel as $category): ?>
			                                	<option <?= (isset($post['id_channel_category']) && $post['id_channel_category']==$category->id_channel_category) ? 'selected="selected"' : ' ' ?>value="<?=$category->id_channel_category?>"><?=$category->category_name?></option>
			                                	<?php endforeach; ?>
			                                </select>
			                            </div>
			                            <div class="form-group">
			                                <a id="add_group" class="btn btn-success">Add New Group</a>
			                            </div>
			                            <div class="form-group">
			                                <label for="title">Channel Name</label>
			                                <input type="text" class="form-control" name="name" id="name" value="<?= (isset($post['name'])) ? $post['name'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="genre">Genre</label>
			                                <input type="text" class="form-control" name="genre" id="genre" value="<?= (isset($post['genre'])) ? $post['genre'] : '' ?>"/>
			                            	<span style="color:red;">* Pisahkan dengan koma ( <strong>,</strong> ) jika lebih dari satu</span>
			                            </div>
			                            <div class="form-group">
			                                <label for="position">Position Global</label>
			                                <input type="text" class="form-control" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="position">Position On SD</label>
			                                <input type="text" class="form-control" name="position_sd" id="position_sd" value="<?= (isset($post['position_sd'])) ? $post['position_sd'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="position">Position On HD</label>
			                                <input type="text" class="form-control" name="position_hd" id="position_hd" value="<?= (isset($post['position_hd'])) ? $post['position_hd'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="position">Position On Ekslusif</label>
			                                <input type="text" class="form-control" name="position_ekslusif" id="position_ekslusif" value="<?= (isset($post['position_ekslusif'])) ? $post['position_ekslusif'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="position_in_type">Position in Group</label>
			                                <input type="text" class="form-control" name="position_in_type" id="position_in_type" value="<?= (isset($post['position_in_type'])) ? $post['position_in_type'] : '' ?>"/>
			                            </div>
			                            
			                            
			                        </div>
			                        <div class="col-lg-4">
			                            <div class="form-group">
			                                <label for="uri_path">SEO URL / SLUG</label>
			                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
			                            </div>
			                            <div class="form-group">
			                                <label for="id_status">HD</label>
			                                <div class="checkbox">
			                                    <label>
			                                        <input type="checkbox" value="1" name="is_hd" id="is_hd" <?= (isset($post['is_hd']) && !empty($post['is_hd'])) ? 'checked="checked"' : '' ?>/>Yes
			                                    </label>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="is_exclusive">Exclusive</label>
			                                <div class="checkbox">
			                                    <label>
			                                        <input type="checkbox" value="1" name="is_exclusive" id="is_exclusive" <?= (isset($post['is_exclusive']) && !empty($post['is_exclusive'])) ? 'checked="checked"' : '' ?>/>Yes
			                                    </label>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="is_featured">Free</label>
			                                <div class="checkbox">
			                                    <label>
			                                        <input type="checkbox" value="1" name="is_free" id="is_free" <?= (isset($post['is_free']) && !empty($post['is_free'])) ? 'checked="checked"' : '' ?>/>Yes
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
			                                        <?php if (isset($post['logo_file_name']) && $post['logo_file_name'] != ''): ?>
			                                            <img src="<?= AZURE_BLOB_URLPREFIX . AZURE_FOLDER_CHANNEL . '/' . $post['logo_file_name'] ?>" id="post-image" />
			                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_channel'] ?>" data-type="thumbnail">x</span>
			                                        <?php endif; ?>
			                                    </div>
			                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
			                                    <div>
			                                        <span class="btn btn-default btn-file">
			                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
			                                            <input type="file" name="logo_file_name">
			                                        </span>
			                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			                                    </div>
			                                </div>
			                            </div>
			                            <!-- <div class="form-group">
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
			                            </div> -->
			                        </div>
			                    </div>
	                		</div>
	                		<div role="tabpanel" class="tab-pane fade" id="package">
								<div class="row">
									<div class="col-lg-8">
										<div class="wrapper-addon">
											<?php
											if(!isset($list_package_byid)){

											
											?>
											<?php foreach ($list_package as $key => $package): ?>
		                                	<div class="checkbox">
												<label>
												<input name="package[<?=$key?>]" value="<?=$package->id_package?>" type="checkbox"> <?=$package->package_name?>
												</label>
											</div>

		                                	<?php endforeach; ?>
											<?php
											}else{
												foreach ($list_package as $key => $package) {
													$checked_p="";
														if(in_array($package->id_package, $list_package_byid)){
															$checked_p = 'checked="checked"';
														}

											
											?>
											<div class="checkbox">
												<label>
												<input <?=$checked_p?> name="package[<?=$key?>]" value="<?=$package->id_package?>" type="checkbox"> <?=$package->package_name?>
												</label>
											</div>

											<?php
												}
											}
											?>
										</div>
									</div>
								</div>
	                		</div>
	                		<div role="tabpanel" class="tab-pane fade" id="package_addon">
								<div class="row">
									<div class="col-lg-8">
										<div class="wrapper-addon">
											<?php
											if(!isset($list_package_addonbyid)){

											
											?>
											<?php foreach ($list_package_addon as $key => $addon): ?>
		                                	<div class="checkbox">
												<label>
												<input name="addon[<?=$key?>]" value="<?=$addon->id_package_addon?>" type="checkbox"> <?=$addon->addon_name?>
												</label>
											</div>

		                                	<?php endforeach; ?>
											<?php
											}else{
												foreach ($list_package_addon as $key => $addon) {
													$checked_p="";
														if(in_array($addon->id_package_addon, $list_package_addonbyid)){
															$checked_p = 'checked="checked"';
														}
											?>
											<div class="checkbox">
												<label>
												<input <?=$checked_p?> name="addon[<?=$key?>]" value="<?=$addon->id_package_addon?>" type="checkbox"> <?=$addon->addon_name?>
												</label>
											</div>
											<?php
												}
											}
											?>
										</div>
									</div>
								</div>
	                		</div>
	                		<div role="tabpanel" class="tab-pane fade" id="tab_channel_number">
	                			<div class="row group-form-field">
                                     <?php if (isset($post['channel_number'])) : ?>
                                     	<?php foreach ($post['channel_number'] as $row => $channel_number): ?>
                                     		<?php if (isset($post['id_channel'])) : ?>
                                     			<div class="row-channel-number" id="row-channel-number-<?=$row?>">
	                                     			<div class="col-lg-10">
		                                     			<div class="form-group">
		                                     				<label>Channel Number</label>
		                                     				<input class="form-control" id="channel_number_<?=$row?>" type="type" value="<?=$channel_number['channel_number']?>" name="channel_number[<?=$row?>]"/>
		                                     			</div>
	                                     			</div>
	                                     			<div class="col-lg-1">
	                                                    <div class="form-group">
	                                                        <label style="display:block;">&nbsp;</label>
	                                                        <button type="button" class="btn btn-danger" onclick="removeChannelNumber('<?=$row?>');">-</button>
	                                                    </div>
	                                                </div>
	                                            </div>
                                     		<?php else: ?>
                                     		<div class="row-channel-number" id="row-channel-number-<?=$row?>">
                                     			<div class="col-lg-10">
	                                     			<div class="form-group">
	                                     				<label>Channel Number</label>
	                                     				<input class="form-control" id="channel_number_<?=$row?>" type="type" value="<?=$channel_number?>" name="channel_number[<?=$row?>]"/>
	                                     			</div>
                                     			</div>
                                     			<div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label style="display:block;">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger" onclick="removeChannelNumber('<?=$row?>');">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                     		<?php endif; ?>
                                     	<?php endforeach; ?>
                                     <?php endif; ?>
                                </div>
                                <div class="row group-form-button">
                                    <div class="col-lg-2 col-lg-offset-10 text-right">
                                        <button type="button" class="btn btn-success" onclick="addChannelNumber();">+</button>
                                    </div>
                                </div>
	                		</div>
	                	</div>
                    </div>
                <!-- /channelisttabs -->
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
<!-- Modal -->
<div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addGroupModalLabel">Add Category</h4>
      </div>
      <div class="modal-body">
      	
      	<div class="form-group">
      		<label>Category Name</label>
      		<input type="text" class="form-control" id="name_category" name="category_name" />
      	</div>
      	<div class="form-group">
      		<label>Color</label>
      		<input type="text" class="form-control" id="colour" name="colour" />
      	</div>
      	<div class="form-group">
      		<label>Position</label>
      		<input type="text" class="form-control" id="position_category" name="position_category" />
      	</div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="save_category" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $("#name").keyup(function() {
        $("#uri_path").val(convert_to_uri(this.value));
        
    });
    $('#add_group').click(function (){
    	$('#addGroupModal').modal('show');
    });
    $('#save_category').click(function (){
    	$('#addGroupModal').modal('show');
    	 var self = $(this);
    	 var name = $('#name_category').val();
    	 var color = $('#colour').val();
    	 var position = $('#position_category').val();
    	 var post_data = [{name:"category_name",value:name},{name:"color",value:color},{name:"position",value:position}];
    	 post_data.push({name:token_name,value:token_key});
    	 $.ajax({
            url:'<?=$form_action_add_group?>',
            type:'post',
            data:post_data,
            dataType:'json',
            beforeSend: function() {
                self.attr('disabled',true);
            }
        }).always(function() {
            self.removeAttr('disabled');
        }).done(function(data) {
            if (data['error'])  {
                $(".flash-message").html(data['error']);
                $('#addGroupModal').modal('hide');
                 
            }
            if (data['success']) {
                $(".flash-message").html(data['success']);
                $("#id_channel_category").html(data['html']);
                $('#addGroupModal').modal('hide');
                $('#name_category').val('');
		    	 $('#colour').val('');
		    	 $('#position_category').val('');
                //self.remove();
            }
        });
    	 //alert(post_data);
    	 
    });
	var html;
    function addChannelNumber() {
        var row = $(".row-channel-number").length;
        var not_show = '';
        if (row > 0) {
            not_show = 'style="display:none;"';
        }
        html = '\
            <div class="row-channel-number" id="row-channel-number-'+row+'">\
                <div class="col-lg-10">\
                    <div class="form-group">\
                        <label for="question_'+row+'" '+not_show+'>Channel Number</label>\
                        <input class="form-control" id="channel_number_'+row+'" type="type" name="channel_number['+row+']"/>\
                    </div>\
                </div>\
                <div class="col-lg-1">\
                    <div class="form-group">\
                        <label style="display:block;">&nbsp;</label>\
                        <button type="button" class="btn btn-danger" onclick="removeChannelNumber(\''+row+'\');">-</button>\
                    </div>\
                </div>\
            </div>';
        $(".group-form-field").append(html);
        //row++;
    }
    
    function removeChannelNumber(id) {
        $("#row-channel-number-"+id).remove();
    }
    $(function() {
        <?php if (isset($post['id_channel'])): ?>
        $(".delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var type = self.attr('data-type');
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
                    $(".flash-message").html(data['error']);
                }
                if (data['success']) {
                    $(".flash-message").html(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });
        <?php endif; ?>
        
    });
</script>

