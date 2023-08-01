<script type="text/javascript">
    function choose_icon(param) {
        var thisclassname = $(param).find('i').attr('class');
        $('#choose-icon').val(thisclassname);
        $('.outer-icon-list').find('.btn').removeAttr('style');
        $(param).attr('style', 'border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd');
    }
</script>
<div class="page-title">
    <div class="title_left">
        <h3><?=$page_title?> Form</h3>
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
<?php echo form_open($form_action,'role="form" class="form-horizontal" data-parsley-validate'); ?>
<input type="hidden" id="choose-icon" name="icon" value="<?=(isset($post['icon'])) ? $post['icon'] : ''?>">
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
                                    <label for="parent_auth_menu" class="control-label">Parent</label>
                                    <select class="form-control" name="parent_auth_menu" id="parent_auth_menu">
                                        <option value="0">ROOT</option>
                                        <?=$auth_menu_html?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="menu">Menu <span class="required">*</span></label>
                                    <input type="text" name="menu" id="menu" value="<?=(isset($post['menu'])) ? $post['menu'] : ''?>" required="required" class="form-control">
                                    
                                </div>

                                <?php if (is_superadmin()) : ?>
                                <div class="form-group">
                                    <label for="is_superadmin">Only Superadmin Can Access</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" name="is_superadmin" id="is_superadmin" class="flat" <?=(isset($post['is_superadmin']) && !empty($post['is_superadmin'])) ? 'checked="checked"' : ''?>/>&nbsp;Yes
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="file">File Path</label>
                                    <input type="text" class="form-control" name="file" id="file" value="<?=(isset($post['file'])) ? $post['file'] : ''?>"/>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="position">Position</label>
                                    <input type="text" class="form-control" name="position" id="position" value="<?=(isset($post['position'])) ? $post['position'] : $max_position?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
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
                <h2>Icon</h2>
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
                            
                            <div class="col-md-12 outer-icon-list">
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-home'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-home"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-edit'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-clone'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-clone"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-windows'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-windows"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-cog'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-cog"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-image'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-image"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-th-list'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-th-list"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-book'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-book"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-newspaper-o'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-newspaper-o"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-list-alt'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-list-alt"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-envelope-o'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-envelope-o"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-institution'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-institution"></i>
                                </a>
                                <a class="btn btn-app" onclick="choose_icon(this)" <?=isset($post['icon']) && !empty($post['icon']) && $post['icon']=='fa fa-graduation-cap'?'style="border:2px solid #31afb4;color:#31afb4;box-shadow:0 4px 5px 0 #cdcdcd"':''?>>
                                    <i class="fa fa-graduation-cap"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>