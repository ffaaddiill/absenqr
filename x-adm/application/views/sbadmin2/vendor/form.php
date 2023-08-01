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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="id_category_vendor">Category</label>
                                <select class="form-control" name="id_category_vendor" id="id_category_vendor">
                                    <?php
                                        foreach($categorys as $category) {
                                            if (isset($post['id_category_vendor']) && $category['id_vendor_category'] == $post['id_category_vendor']) {
                                                echo '<option value="'.$category['id_vendor_category'].'" selected="selected">'.$category['category_name'].'</option>';
                                            } else {
                                                echo '<option value="'.$category['id_vendor_category'].'">'.$category['category_name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?=(isset($post['name'])) ? $post['name'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="npwp">NPWP</label>
                                <input type="text" class="form-control" name="npwp" id="npwp" value="<?=(isset($post['npwp'])) ? $post['npwp'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" rows="3" id="address" name="address"><?=(isset($post['address'])) ? $post['address'] : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Phone</label>
                                <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?=(isset($post['no_telp'])) ? $post['no_telp'] : ''?>"/>
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