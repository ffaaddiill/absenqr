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
                                <label for="id_tax">Main Tax</label>
                                <select class="form-control" name="id_tax" id="id_tax">
                                    <?php
                                        foreach($categorys as $category) {
                                            if (isset($post['id_tax']) && $category['id_tax'] == $post['id_tax']) {
                                                echo '<option value="'.$category['id_tax'].'" selected="selected">'.$category['name'].'</option>';
                                            } else {
                                                echo '<option value="'.$category['id_tax'].'">'.$category['name'].'</option>';
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
                                <label for="value">Percentace</label>
                                <input type="text" class="form-control" name="value" id="value" value="<?=(isset($post['value'])) ? $post['value'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" id="description" name="description"><?=(isset($post['description'])) ? $post['description'] : ''?></textarea>
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