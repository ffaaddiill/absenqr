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
                    <!-- /#quiztabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Shipping Main Info</a></li>
                            <li role="presentation"><a href="#price" aria-controls="price" role="tab" data-toggle="tab">Price</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#quiz -->
                            <div role="tabpanel" class="tab-pane fade in active" id="main">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="shipping_code">Shipping Code</label>
                                            <input type="text" class="form-control" name="shipping_code" id="shipping_code" value="<?=(isset($post['shipping_code'])) ? $post['shipping_code'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="province">Province</label>
                                            <input type="text" class="form-control" name="province" id="province" value="<?=(isset($post['province'])) ? $post['province'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" value="<?=(isset($post['city'])) ? $post['city'] : ''?>"/>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-4">
                                        
                                        <div class="form-group">
                                            <label for="is_java">Is Java</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_java" id="is_java" <?=(isset($post['is_java']) && !empty($post['is_java'])) ? 'checked="checked"' : ''?>/>Yes
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div><!-- /#quiz -->
                            <!-- /#answer -->
                            <div role="tabpanel" class="tab-pane fade" id="price">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="reguler_price">Reguler Price</label>
                                            <input type="text" class="form-control" name="reguler_price" id="reguler_price" value="<?=(isset($post['reguler_price'])) ? $post['reguler_price'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="reguler_etd">Reguler Etd</label>
                                            <input type="text" class="form-control" name="reguler_etd" id="reguler_etd" value="<?=(isset($post['reguler_etd'])) ? $post['reguler_etd'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="oke_price">Oke Price</label>
                                            <input type="text" class="form-control" name="oke_price" id="oke_price" value="<?=(isset($post['oke_price'])) ? $post['oke_price'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="oke_etd">Reguler Etd</label>
                                            <input type="text" class="form-control" name="oke_etd" id="oke_etd" value="<?=(isset($post['oke_etd'])) ? $post['oke_etd'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="yes_price">Yes Price</label>
                                            <input type="text" class="form-control" name="yes_price" id="yes_price" value="<?=(isset($post['yes_price'])) ? $post['yes_price'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="yes_etd">Yes Etd</label>
                                            <input type="text" class="form-control" name="yes_etd" id="yes_etd" value="<?=(isset($post['yes_etd'])) ? $post['yes_etd'] : ''?>"/>
                                        </div>
                                    </div>
                                </div>
                                
                            </div><!-- /#answer -->
                        </div><!-- /.tab content -->
                    </div><!-- /#quiztabs -->
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
    
   
</script>
