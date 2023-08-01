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
                <?= $page_title ?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action, 'role="form" enctype="multipart/form-data"'); ?>
                <!-- /.row (nested) -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="name">Office Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?= (isset($post['name'])) ? $post['name'] : '' ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="8"><?= (isset($post['address'])) ? $post['address'] : '' ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="category_office_id" >Office Category</label>
                            <select class="form-control" name="category_office_id" id="category_office_id">
                                <option value=""></option>
                                <?php foreach ($category_office_list as $row => $cat): ?>
                                    <option value="<?= $cat['id']; ?>" <?=(isset($post['category_office_id']) && $cat['id'] == $post['category_office_id']) ? "selected" : ''; ?>><?php echo $cat['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="regional_id">Regional</label>
                            <select class="form-control" name="regional_id" id="regional_id">
                                <option value=""></option>
                                <?php foreach ($regional_list as $row => $region): ?>
                                    <option value="<?= $region['id']; ?>" <?=(isset($post['regional_id']) && $region['id'] == $post['regional_id']) ? "selected" : ''; ?> ><?= $region['name']; ?></option>
                                <?php endforeach; ?>	
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="phone_area">Phone Area</label>
                                <input type="text" class="form-control" name="phone_area" id="phone_area" value="<?= (isset($post['phone_area'])) ? $post['phone_area'] : '' ?>"/>
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="no_phone">No Phone</label>
                                <input type="number" class="form-control" name="no_phone" id="no_phone" value="<?= (isset($post['no_phone'])) ? $post['no_phone'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_fax">No Fax</label>
                            <input type="number" class="form-control" name="no_fax" id="no_fax" value="<?= (isset($post['no_fax'])) ? $post['no_fax'] : '' ?>"/>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="longitude">Longitude</label>
                                <input type="number" class="form-control" name="longitude" id="longitude" value="<?= (isset($post['longitude'])) ? $post['longitude'] : '' ?>"/>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="latitude">Latitude</label>
                                <input type="number" class="form-control" name="latitude" id="latitude" value="<?= (isset($post['latitude'])) ? $post['latitude'] : '' ?>"/>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-lg-offset-8">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-danger" href="<?= $cancel_url ?>">Cancel</a>
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


