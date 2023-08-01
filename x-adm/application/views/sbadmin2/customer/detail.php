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
                <?=$page_title?>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <!-- /#customertabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>
                            <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Address</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#info -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Name</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['first_name']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Email</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['email']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Kode Pemasangan</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['kode_pemasangan']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Phone</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['no_phone']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Mobile</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['no_hp']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Gender</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['gender']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Birthday</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['birthday']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Referal</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['referal']?> <?=($post['referal_id'] != '') ? '('.$post['referal_id'].')' : ''?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Identity</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['type_identity']?> <?=($post['no_identity'] != '') ? '('.$post['no_identity'].')' : ''?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Last Step</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['step']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Package</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['package_name']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Promo</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=($post['promo_name'] != '') ? $post['promo_name'] : 'Reguler'?></p>
                                            </div>
                                        </div>
                                        <?php if (isset($post['addons']) && count($post['addons'])>0): ?>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">Add-on</label>
                                                <div class="col-md-8">
                                                    <?php foreach ($post['addons'] as $addon): ?>
                                                    <p class="form-control-static"><?=$addon['name']?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($post['decoders']) && count($post['decoders'])>0): ?>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">Decoder</label>
                                                <div class="col-md-8">
                                                    <?php foreach ($post['decoders'] as $decoder): ?>
                                                    <p class="form-control-static"><?=$decoder['name']?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Media Billing</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['media_billing']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Recarring</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['recarring']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Period</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=($post['periode'] != '') ? $post['periode'].' Month' : ''?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Identity File</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    <?=($post['file_identity'] != '') ? '<a class="btn btn-primary" href="'.$download_url.'">Download</a>' : '--'?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /#info -->
                            <!-- /#address -->
                            <div role="tabpanel" class="tab-pane fade" id="address">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>Billing Address</h4>
                                        <address>
                                            <?=$post['address']?><br/>
                                            <?=$post['province']?><br/>
                                            <?=$post['city']?>, <?=$post['zip_code']?>
                                        </address>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4>Installation Address</h4>
                                        <address>
                                            <?=$post['address_shipping']?><br/>
                                            <?=$post['province_shipping']?><br/>
                                            <?=$post['city_shipping']?>, <?=$post['zip_code_shipping']?>
                                        </address>
                                    </div>
                                </div>
                            </div><!-- /#address -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-8">
                            <a class="btn btn-warning" href="<?=$cancel_url?>">Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
