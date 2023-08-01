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
                    <!-- /#transactiontabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>
                            <li role="presentation"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Payment</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#info -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Trans ID</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['transid']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">INVOICE</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['invoice']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">VOUCHER CODE</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['voucher_code']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">TOTAL PRICE</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    <?php if ($post['total_discount'] != '' && $post['total_discount'] > 0) {
                                                        echo 'Rp <span class="text-muted"><s>'.number_format(($post['total_price']+$post['total_discount']),0).'</s></span> 
                                                            <span class="text-success"><strong>'.number_format($post['total_price'],0).'</strong></span>';
                                                    } else {
                                                        echo 'Rp <span class="text-success"><strong>'.number_format($post['total_price'],0).'</strong></span>';
                                                    } ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Payment Method</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=(($post['payment_method'] == '01') ? 'CREDIT CARD' : ($post['payment_method'] == '04') ? 'DOKU WALLET' : 'CIMB CLICKS')?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Status</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?php if($post['status'] == '1'){echo 'PAID';}elseif($post['status'] == '3'){echo 'FAILED';}else{echo 'REQUESTED';}?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Movie & Showtime</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['movie_title']?> (<?=custDateFormat($post['start_time'],'d M Y H:i')?>)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">CUSTOMER ID</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['customer_id']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Name</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['name']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Email</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['email']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left">Handphone</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static"><?=$post['handphone']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /#info -->
                            <!-- /#address -->
                            <div role="tabpanel" class="tab-pane fade" id="payment">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if (isset($post['payment_info_doku'])): $payment_info_doku = $post['payment_info_doku']; ?>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">WORDS</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['words']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">RESPONSE CODE</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['words']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">AMOUNT</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static">Rp <?=number_format($payment_info_doku['totalamount'],0)?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">STATUS</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['trxstatus']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">PAYMENT CHANNEL</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['payment_channel']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">SESSION ID</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['session_id']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">BANK ISSUER</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_doku['bank_issuer']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">TIME</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=custDateFormat($payment_info_doku['payment_date_time'],'d-m-Y H:i:s')?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($post['payment_info_cimb'])): $payment_info_cimb = $post['payment_info_cimb']; ?>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">SIGNATURE</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_cimb['signature']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">AMOUNT</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static">Rp <?=number_format($payment_info_cimb['amount'],0)?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">REMARK</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_cimb['remark']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">TRANS ID (CIMB)</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=$payment_info_cimb['transid']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">STATUS</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=($payment_info_cimb['status']) ? 'SUCCESS' : $payment_info_cimb['errdesc']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">TIME</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"><?=custDateFormat($payment_info_cimb['transdate'],'d-m-Y H:i:s')?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
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
