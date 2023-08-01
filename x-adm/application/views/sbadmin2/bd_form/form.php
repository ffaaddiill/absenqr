<style type="text/css">
.no-margin{
    margin : 0 0 10px 0 !important;
}
.select2-container{
    display: block !important;
        width: 90% !important;
}
.row_num{
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
}
.row-item{
    padding-bottom: 20px;
}
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}



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
                <?php echo form_open($form_action,'class="form-horizontal" role="form" enctype="multipart/form-data"'); ?>
                <div role="tabpanel" id="tabster">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#basic_info" aria-controls="basic_info" role="tab" data-toggle="tab">BD Basic Info</a></li>
                        <li role="presentation"><a href="#item" aria-controls="item" role="tab" data-toggle="tab">Item BD</a></li>
                    <?php if (isset($post['id_form_bd'])) :?>
                        <li role="presentation"><a href="#pph" aria-controls="pph" role="tab" data-toggle="tab">PPH</a></li>
                    <?php endif; ?>
                    </ul>
                    <!-- Nav tabs -->
                    <div class="tab-content">
                        <!-- /#Basic Info -->
                        <div role="tabpanel" class="tab-pane fade in active" id="basic_info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="divisi" class="col-lg-1 control-label text-left">Divisi</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="id_divisi" id="id_divisi">
                                                <option>Pilih Divisi</option>
                                                <?php
                                                foreach ($divisi as $key => $dv) :
                                                ?>
                                                <option <?= (isset($post['id_divisi']) && $post['id_divisi']==$dv['id_divisi']) ? 'selected="selected"' : '' ?> value="<?=$dv['id_divisi']?>"><?=$dv['name']?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                        <script type="text/javascript">
                                            $('#id_divisi').change(function(){
                                                var data = [
                                                        {name:"id_divisi",value:$(this).val()},
                                                        
                                                       ];        
                                            
                                                ajax_post_form("<?=site_url('bd_form/getCostcenterAndRequestorByDivisi')?>",data)
                                                
                                                .done(function(response) {
                                                    if(response['html']){
                                                        $('#id_cost_center').html(response['html']);
                                                        
                                                    }else{
                                                        $('#id_cost_center').html('<option>Pilih Cost Center</option>');
                                                    }
                                                    if(response['html_req']){
                                                        $('#id_requestor').html(response['html_req']);
                                                        $('#id_requestor').select2();
                                                    }else{
                                                        $('#id_requestor').html('<option>Pilih Requestor</option>');
                                                        $('#id_requestor').select2();
                                                    }
                                                    $('#code_cost_center').html('');
                                                });
                                            });
                                        </script>
                                        <label for="cost_center" class="col-lg-2 control-label text-left">Cost Center</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="id_cost_center" id="id_cost_center">
                                                <option>Pilih Cost Center</option>
                                                <?php
                                                if($post['id_form_bd']){
                                                    foreach ($cost_center as $key => $cs) :
                                                    ?>
                                                    <option <?= (isset($post['id_cost_center']) && $post['id_cost_center']==$cs['id_divisi']) ? 'selected="selected"' : '' ?> value="<?=$cs['id_divisi']?>"><?=$cs['name']?></option>
                                                    <?php
                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <span id="code_cost_center"></span>
                                        </div>
                                        <script type="text/javascript">
                                            // $('#id_cost_center').change(function(){
                                            //     var data = [
                                            //             {name:"id_cost_center",value:$(this).val()},
                                                        
                                            //            ];        
                                            
                                            //     ajax_post_form("<?=site_url('bd_form/getCodeByCostCenter')?>",data)
                                            //     .done(function(response) {
                                            //         if(response['code']){
                                            //             $('#code_cost_center').html(response['code']);
                                                        
                                            //         }else{
                                            //             $('#code_cost_center').html(response['error']);
                                            //         }
                                                    
                                            //     });
                                            // });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="requestor" class="col-lg-2 control-label text-left">Requestor&nbsp;<a id="add_requestor" class="btn btn-success"><i class="fa fa-plus"></i></a></label>
                                        <div class="col-lg-4">
                                            <select id="id_requestor" name="id_requestor" class="form-control">
                                                <option>Pilih Requestor</option>
                                                <?php
                                                foreach ($requestor as $key => $req) {
                                                ?>
                                                <option <?= (isset($post['id_requestor']) && $post['id_requestor']==$req['id_requestor']) ? 'selected="selected"' : '' ?> value="<?=$req['id_requestor']?>"><?=$req['name']?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="bd_number"  class="col-lg-2 control-label text-left">BD No. <i id ="label_bd_number" style="display:none;" class="fa fa-refresh fa-spin"></i></label>
                                        <div class="col-lg-4">

                                            <input value="<?= (isset($post['bd_number'])) ? $post['bd_number'] : '' ?>" type="text" class="form-control" name="bd_number" id="bd_number" placeholder="BD Number">
                                        </div>
                                        <label for="request_date" class="col-lg-2 control-label text-left">Request Date</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="request_date" id="request_date" value="<?= (isset($post['request_date'])) ? $post['request_date'] : date('Y-m-d') ?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <?php
                                    /*
                                    <!-- <div class="form-group">
                                        <label for="id_vendor" class="col-lg-2 control-label text-left">Pay To</label>
                                        <div class="col-lg-5">
                                            <select class="form-control" name="id_vendor" id="id_vendor" >
                                                <option>Pilih</option>
                                                <?php
                                                    foreach($vendors as $vendor) {
                                                        //echo $vendor['id_category_vendor'];
                                                        
                                                        if($vendor['id_category_vendor']==3){
                                                            $prefix = '';
                                                        }else{
                                                            $prefix = $vendor['category_name'];
                                                        }
                                                        if (isset($post['id_vendor']) && $vendor['id_vendor'] == $post['id_vendor']) {
                                                            echo '<option value="'.$vendor['id_vendor'].'" selected="selected">'.$prefix.' '.$vendor['name'].'</option>';
                                                        } else {
                                                            echo '<option value="'.$vendor['id_vendor'].'">'.$prefix.' '.$vendor['name'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn btn-success" id="add_vendor"><i class="fa fa-plus"></i>Add New Vendor</a>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label for="account_number" class="col-lg-2 control-label text-left">Account No.</label>
                                        <div class="col-lg-4">
                                            <input value="<?= (isset($post['account_number'])) ? $post['account_number'] : '' ?>" type="text" class="form-control" name="account_number" id="account_number" placeholder="Account Number">
                                        </div>
                                        <label for="bank_name" class="col-lg-2 control-label text-left">Bank Name</label>
                                        <div class="col-lg-4">
                                            <input value="<?= (isset($post['bank_name'])) ? $post['bank_name'] : '' ?>" type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name">
                                        </div>
                                    </div> -->
                                    */ ?>
                                    <div class="form-group">
                                        <label for="payment_type" class="col-lg-2 control-label text-left">Type Of Payment</label>
                                        <div class="col-lg-4">
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_type']) && $post['payment_type'] == 1) ? 'checked' : '' ?> type="radio" name="payment_type" id="payment_type1" value="1"> Full Payment
                                            </label>
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_type']) && $post['payment_type'] == 2) ? 'checked' : '' ?> type="radio" name="payment_type" id="payment_type2" value="2"> Advance
                                            </label>
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_type']) && $post['payment_type'] == 3) ? 'checked' : '' ?> type="radio" name="payment_type" id="payment_type3" value="3"> Partial
                                            </label>
                                        </div>
                                        <label for="due_date" class="col-lg-2 control-label text-left">Due Date</label>
                                        <div class="col-lg-4">

                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="due_date" id="due_date" value="<?= (isset($post['due_date'])) ? $post['due_date'] : date('Y-m-d') ?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:<?= (isset($post['payment_type']) && $post['payment_type'] == 2) ? 'block' : 'none' ?>;"  id="wrap_attribute_payment_type">
                                        <div class=" col-lg-4">
                                            <i id ="label_soa_number" style="display:none;" class="fa fa-refresh fa-spin"></i>
                                            <input value="" type="text" class="form-control" name="soa_number" id="soa_number" placeholder="No. SOA">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php /* 
                                        <label for="payment_by" class="col-lg-2 control-label text-left">Payment By</label>
                                        <div class="col-lg-4">
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_by']) && $post['payment_by'] == 1) ? 'checked' : '' ?> type="radio" name="payment_by" id="payment_by1" value="1"> Transfer
                                            </label>
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_by']) && $post['payment_by'] == 2) ? 'checked' : '' ?> type="radio" name="payment_by" id="payment_by2" value="2"> Cheque/Giro
                                            </label>
                                            <label class="radio-inline">
                                              <input <?= (isset($post['payment_by']) && $post['payment_by'] == 3) ? 'checked' : '' ?> type="radio" name="payment_by" id="payment_by3" value="3"> Cash
                                            </label>
                                        </div>
                                        <div style="display:<?= (isset($post['payment_by'])) ? 'block' : 'none' ?>;" id="wrap_attribute_payment_by" class="col-lg-4">
                                            <input value="<?= (isset($post['attribute_payment_by'])) ? $post['attribute_payment_by'] : '' ?>" type="text" class="form-control" name="attribute_payment_by" id="attribute_payment_by" placeholder="No. Attribute">
                                        </div>
                                        <script type="text/javascript">
                                            $(document).on('click','input:radio[id^="payment_by"]',function(){
                                                $('#wrap_attribute_payment_by').show();
                                            });
                                            $(document).on('click','input:radio[id^="payment_type"]',function(){
                                                var id_payment_type = $(this).val();
                                                if(id_payment_type==2){
                                                    $('#wrap_attribute_payment_type').show();
                                                }else{
                                                    $('#wrap_attribute_payment_type').hide();
                                                }
                                                
                                            });
                                        </script>
                                        */?>
                                    </div>
                                    <div class="form-group">
                                        <label for="submit_to_finance" class="col-lg-2 control-label text-left">Submit To Finance</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="submit_to_finance" id="submit_to_finance" value="<?= (isset($post['submit_to_finance'])) ? $post['submit_to_finance'] : date('Y-m-d') ?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                            
                                        </div>
                                        <label for="verify_by_finance" class="col-lg-2 control-label text-left">Verify By Finance</label>  
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="verify_by_finance" id="verify_by_finance" value="<?= (isset($post['verify_by_finance'])) ? $post['verify_by_finance'] : date('Y-m-d') ?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_of_promise" class="col-lg-2 control-label text-left">Date of Promise</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="date_of_promise" id="date_of_promise" value="<?= (isset($post['date_of_promise'])) ? $post['date_of_promise'] : date('Y-m-d') ?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                        <!-- /#End Basic Info -->
                        <!-- /#Item Info -->
                        <div role="tabpanel" class="form tab-pane fade" id="item">
                            <?php if (empty($post['id_form_bd'])) :?>
                                <div class="row group-form-field">
                                    <?php if (isset($post['item_bd'])) { ?>
                                        <?php foreach ($post['item_bd'] as $row => $item_bd) :?>
                                            <?php  
                                            if($row == 0) {
                                                $not_show = 'style="display:block;"';
                                            }else{
                                                $not_show = 'style="display:none;"';
                                            }

                                            ?>
                                            <div class="row-item row" id="row-item-<?= $row ?>">
                                                <div class="col-lg-1">
                                                    <div class="form-group no-margin">
                                                        <label for="item_<?= $row ?>" '+not_show+'>Rule</label> <span class="row_num"><?=$row+1?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group description-item no-margin">
                                                        <label for="item_bd_desc<?= $row ?>" <?= $not_show ?>>Description</label>
                                                        <textarea class="form-control promo_type" id="item_desc_<?= $row ?>" name="item_bd[<?= $row ?>][name]" data-row="<?= $row ?>"><?=(isset($item_bd['name'])) ? $item_bd['name'] : ''?></textarea>
                                                        
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_id_vendor<?= $row ?>">Vendor </label>
                                                        <select data-row="<?=$row?>" class="form-control" name="item_bd[<?= $row ?>][id_vendor]" id="item_id_vendor_<?= $row ?>" >
                                                            <?php
                                                                foreach($vendors as $vendor) {
                                                                    //echo $vendor['id_category_vendor'];
                                                                    
                                                                    if($vendor['id_category_vendor']==3){
                                                                        $prefix = '';
                                                                    }else{
                                                                        $prefix = $vendor['category_name'];
                                                                    }
                                                                    if (isset($item_bd['id_vendor']) && $vendor['id_vendor'] == $item_bd['id_vendor']) {
                                                                        echo '<option value="'.$vendor['id_vendor'].'" selected="selected">'.$prefix.' '.$vendor['name'].'</option>';
                                                                    } else {
                                                                        echo '<option value="'.$vendor['id_vendor'].'">'.$prefix.' '.$vendor['name'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                            
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_ramount<?= $row ?>" <?= $not_show ?>>Real Amount</label>
                                                        <input type="number" class="form-control" name="item_bd[<?= $row ?>][real_amount]" id="item_real_amount_<?= $row ?>" placeholder="Real" value="<?=(isset($item_bd['real_amount'])) ? $item_bd['real_amount'] : ''?>">
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_bank_number<?= $row ?>">Bank Name</label>
                                                        <input data-row="<?= $row ?>" type="text" class="form-control" name="item_bd[<?= $row ?>][bank_number]" id="item_bank_number_<?= $row ?>" placeholder=""> 
                                                    </div>
                                                    <!-- <div class="form-group no-margin">
                                                        <label for="item_account_number<?= $row ?>">Account Number</label>
                                                        <input data-row="<?= $row ?>" type="text" class="form-control" name="item_bd[<?= $row ?>][account_number]" id="item_account_number_<?= $row ?>" placeholder=""> 
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_currency<?= $row ?>" <?= $not_show ?>>Currency</label>
                                                        <select class="form-control promo_type" id="item_currency_<?= $row ?>" name="item_bd[<?= $row ?>][id_currency]" data-row="<?= $row ?>">
                                                            <option <?=(isset($item_bd['id_currency']) && $item_bd['id_currency'] == 1) ? 'selected="selected"' : ''?> value="1">IDR</option>
                                                            <option <?=(isset($item_bd['id_currency']) && $item_bd['id_currency'] == 2) ? 'selected="selected"' : ''?> value="2">USD</option>
                                                        </select>
                                                    </div>
                                                    <div id="wrap_account_number_<?=$row?>">                        </div>
                                                    
                                                </div>
                                                <div class="col-lg-2">
                                                    <div id="wrap_curs_ppn_<?= $row ?>" style="display: block;" class="form-group no-margin">
                                                        <label for="item_curs_ppn<?= $row ?>" style="display:block;">Curs PPn</label>
                                                        <input type="number" class="form-control" name="item_bd[<?= $row ?>][curs_ppn]" id="item_curs_ppn_<?= $row ?>" placeholder="Curs PPn" value="<?=(isset($item_bd['curs_ppn'])) ? $item_bd['curs_ppn'] : ''?>"> 
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_account_name<?= $row ?>" style="display:<?= $row ?>;">Account Name</label>
                                                        <input type="text" class="form-control" name="item_bd[<?= $row ?>][account_name]" id="item_account_name_<?= $row ?>" placeholder="Account Name">
                                                    </div>
                                                    <!-- <div class="form-group no-margin">
                                                        <label for="item_bd_date_promise_settelment<?= $row ?>" style="display:block;">Date Promise Settelment</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control" name="item_bd[<?= $row ?>][date_promise_settelment]" id="item_date_promise_settelment<?= $row ?>" value="" readonly="readonly"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> </div>
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label for="item_bd_ppn<?= $row ?>" <?= $not_show ?>>PPN</label><br>
                                                        <input type="checkbox" data-row="<?= $row ?>" id="item_ppn_<?= $row ?>" name="item_bd[<?= $row ?>][id_status_pajak]" <?=(isset($item_bd['id_status_pajak']) && $item_bd['id_status_pajak'] == 1) ? 'checked' : ''?> value="1"> Y 
                                                    </div>

                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group no-margin">
                                                        <label style="display:block;">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger" onclick="removeItem('<?= $row ?>');">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </div>
                            <?php else :  ?>
                                <div id="detail_payment" class="bd_form">
                                    <?php
                                if($post['item_bds']){    
                                    ?>
                                    <table class="table">
                                      <tr>
                                        <th>Description</th>
                                        <th>Real Amount</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                      </tr>
                                      <?php
                                      $total_amount = 0;
                                      $total_ppn = 0;
                                      $total_pph_amounts = 0;
                                      $USD = 0;
                                        foreach ($post['item_bds'] as $row => $item) :

                                      ?>
                                      <tr class="wrap-action">

                                        <td ><?=$item['name']?>
                                            <span class="action">
                                                <a data-id="<?=$item['id_form_bd_item']?>" class="edit_item_bd btn btn-info"><i class="fa fa-pencil"></i></a>
                                                <a data-id="<?=$item['id_form_bd_item']?>" class="delete_item_bd btn btn-danger"><i class="fa fa-trash"></i></a>
                                            </span>
                                        </td>
                                        <td><?=number_format($item['real_amount'],2,",",".");?></td>
                                        <td><?=$item['iso_1'] ?></td>
                                        <td class="text-right"><?= $item['iso_2'] ?> <?=number_format($item['real_amount'] ,2,",",".");?></td>
                                      </tr>
                                      
                                            <?php if($item['id_status_pajak']==1){
                                                     
                                                     if($item['id_currency'] != 1){
                                                        $amount_ppn = 0.1 * $item['real_amount']  * $item['curs_ppn'];
                                                        $total_ppn = $total_ppn + $amount_ppn;
                                                        $total_amount = $total_amount + ($item['real_amount'] );
                                                        $USD++; 
                                                     }else{
                                                        $amount_ppn = 0.1 * $item['real_amount'];
                                                        $total_amount = $total_amount + ($item['real_amount'] ) + $amount_ppn;
                                                     }
                                                     #$total_amount = $amount_ppn + $item['real_amount'];
                                            ?>

                                            <tr class="ppn">
                                                <td class="text-right">PPN 10%</td>
                                                <td></td>
                                                <td>IDR</td>
                                                <td class="text-right"><?=number_format($amount_ppn,2,",",".");?></td>
                                            </tr>
                                            <?php
                                            #$total_amount = $total_amount + ($item['real_amount'] ) + $amount_ppn; 
                                            
                                            }else{ ?>
                                      <?php
                                            $total_amount = $total_amount + ($item['real_amount'] );
                                            }

                                            if($item['pph_item']){
                                                $total_pph_amount = 0;
                                                foreach ($item['pph_item'] as $key => $pph) {
                                                    $pph_amount = ($item['real_amount']  * ($pph['percentage']/100));
                                                    $total_pph_amount = $total_pph_amount + $pph_amount;
                                                    //echo $total_pph_amount;
                                      ?>
                                            <tr class="pph">
                                                <td class="text-right"><?=$pph['tax_name'] . ' ' .$pph['percentage'].' %'?></td>
                                                <td></td>
                                                <td><?=$item['iso_1']?></td>
                                                <td class="text-right"><?=number_format($pph_amount,2,",",".");?></td>
                                            </tr>
                                      <?php  
                                                }        
                                            }else{
                                                $total_pph_amount =0 ;
                                            }
                                      ?>
                                        <tr class="pph">
                                            <td class="text-right">Total PPH</td>
                                            <td></td>
                                            <td><?=$item['iso_1']?></td>
                                            <td class="text-right"><?=number_format($total_pph_amount,2,".",",");?></td>
                                        </tr>
                                      <?php
                                        $total_pph_amounts= $total_pph_amounts + $total_pph_amount;
                                        endforeach;
                                      ?>
                                      <tr>
                                            <td></td>
                                            
                                            <td colspan="2">Total ex PPh</td>
                                            <td class="text-right"><?= $item['iso_2'] ?> <?=number_format($total_amount,2,",",".");?></td>
                                      </tr>
                                      <tr>
                                            <td>Verified By Tax Dept :</td>
                                            <td colspan="2">Tax Due</td>
                                            <td class="text-right"><?= number_format($total_pph_amounts,2,",","."); ?></td>
                                      </tr>
                                      <tr>
                                            <td></td>
                                            <td colspan="2">Total Paid</td>
                                            <td class="text-right"><?= $item['iso_2'] ?> 
                                              <?= ($USD >= 1) ? number_format($total_amount-$total_pph_amounts,2,",",".").' + (Rp. '.number_format($total_ppn,2,",",".").' )' :   number_format($total_amount-$total_pph_amounts,2,",",".") ?>
                                            </td>
                                      </tr>
                                    </table>
                                    <?php
                                }
                                    ?>
                                </div>
                                <br>
                                <div class="row group-form-field">
                                    <?php if (isset($post['item_bd'])) { ?>
                                        <?php foreach ($post['item_bd'] as $row => $item_bd) :?>
                                            <?php  
                                            if($row == 0) {
                                                $not_show = 'style="display:block;"';
                                            }else{
                                                $not_show = 'style="display:none;"';
                                            }

                                            ?>
                                            <div class="row-item row" id="row-item-<?= $row ?>">
                                                <div class="col-lg-1">
                                                    <div class="form-group no-margin">
                                                        <label for="item_<?= $row ?>" '+not_show+'>Rule</label> <span class="row_num"><?=$row+1?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_desc<?= $row ?>">Description</label>
                                                        <textarea class="form-control promo_type" id="item_desc_<?= $row ?>" name="item_bd[<?= $row ?>][name]" data-row="<?= $row ?>"><?=(isset($item_bd['name'])) ? $item_bd['name'] : ''?></textarea>
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_id_vendor<?= $row ?>">Vendor </label>
                                                        <select data-row="<?=$row?>" class="form-control" name="item_bd[<?= $row ?>][id_vendor]" id="item_id_vendor_<?= $row ?>" >
                                                            <option>Pilih Vendor</option>
                                                            <?php
                                                                foreach($vendors as $vendor) {
                                                                    //echo $vendor['id_category_vendor'];
                                                                    
                                                                    if($vendor['id_category_vendor']==3){
                                                                        $prefix = '';
                                                                    }else{
                                                                        $prefix = $vendor['category_name'];
                                                                    }
                                                                    if (isset($item_bd['id_vendor']) && $vendor['id_vendor'] == $item_bd['id_vendor']) {
                                                                        echo '<option value="'.$vendor['id_vendor'].'" selected="selected">'.$prefix.' '.$vendor['name'].'</option>';
                                                                    } else {
                                                                        echo '<option value="'.$vendor['id_vendor'].'">'.$prefix.' '.$vendor['name'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                            
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_ramount<?= $row ?>">Real Amount</label>
                                                        <input type="text" class="form-control number_format" name="item_bd[<?= $row ?>][real_amount]" id="item_real_amount_<?= $row ?>" placeholder="Real" value="<?=(isset($item_bd['real_amount'])) ? $item_bd['real_amount'] : ''?>">
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_bank_number<?= $row ?>">Bank Name</label>
                                                        <input data-row="<?= $row ?>" type="text" class="form-control" name="item_bd[<?= $row ?>][bank_number]" readonly="readonly" id="item_bank_number_<?= $row ?>" placeholder=""> 
                                                    </div>
                                                    <!-- <div class="form-group no-margin">
                                                        <label for="item_account_number<?= $row ?>">Account Number</label>
                                                        <input data-row="<?= $row ?>" type="text" class="form-control" name="item_bd[<?= $row ?>][account_number]" id="item_account_number_<?= $row ?>" placeholder=""> 
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_currency<?= $row ?>" >Currency</label>
                                                        <select class="form-control promo_type" id="item_currency_<?= $row ?>" name="item_bd[<?= $row ?>][id_currency]" data-row="<?= $row ?>">
                                                            <option <?=(isset($item_bd['id_currency']) && $item_bd['id_currency'] == 1) ? 'selected="selected"' : ''?> value="1">IDR</option>
                                                            <option <?=(isset($item_bd['id_currency']) && $item_bd['id_currency'] == 2) ? 'selected="selected"' : ''?> value="2">USD</option>
                                                        </select>
                                                    </div>
                                                    <div id="wrap_account_number_<?=$row?>"> 
                                                        <?php
                                                        if(isset($item_bd['id_vendor_banking'])){
                                                            $get_account_bank = get_account_bank($item_bd['id_vendor']);
                                                                if($get_account_bank){


                                                        ?>                       
                                                        <div class="form-group no-margin">
                                                          <label for="item_account_number<?= $row ?>">Account Number</label>
                                                            <select class="form-control" data-row="<?= $row ?>" name="item_bd[<?= $row ?>][id_vendor_banking]" id="id_vendor_banking_<?= $row ?>">
                                                                <?php
                                                                foreach ($get_account_bank as $s => $account) {
                                                                    # code...
                                                                
                                                                ?>
                                                                    <option <?= (isset($item_bd['id_vendor_banking']) && $item_bd['id_vendor_banking'] == $account['id_vendor_banking']) ? 'selected="selected"' : '' ?> value="<?=$account['id_vendor_banking']?>"><?=$account['account_number']?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                             </select>
                                                        </div>
                                                        <?php
                                                                }
                                                        }else{
                                                        ?>
                                                            <div class="form-group no-margin">
                                                                <label style="color:red" for="item_account_number<?=$row?>">Belum ada akun banking</label>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-2">
                                                    <div id="wrap_curs_ppn_<?= $row ?>" <?= (isset($item_bd['id_status_pajak']) && $item_bd['id_status_pajak'] == 1) ? 'style="display:block"' : 'style="display:none"' ?> class="form-group no-margin">
                                                        <label for="item_curs_ppn<?= $row ?>" >Nominal PPn</label>
                                                        <input type="number" class="form-control" name="item_bd[<?= $row ?>][curs_ppn]" id="item_curs_ppn_<?= $row ?>" placeholder="Nominal PPn" value="<?=(isset($item_bd['curs_ppn'])) ? $item_bd['curs_ppn'] : ''?>"> 
                                                    </div>
                                                    <div class="form-group no-margin">
                                                        <label for="item_bd_account_name<?= $row ?>" style="display:<?= $row ?>;">Account Name</label>
                                                        <input readonly="readonly" type="text" class="form-control" name="item_bd[<?= $row ?>][account_name]" id="item_account_name_<?= $row ?>" placeholder="Account Name">
                                                    </div>
                                                    <!-- <div class="form-group no-margin">
                                                        <label for="item_bd_date_promise_settelment<?= $row ?>" style="display:block;">Date Promise Settelement</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control" name="item_bd[<?= $row ?>][date_promise_settelment]" id="item_date_promise_settelment<?= $row ?>" value="" readonly="readonly"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> </div>
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label for="item_bd_ppn<?= $row ?>" <?= $not_show ?>>PPN</label><br>
                                                        <input type="checkbox" data-row="<?= $row ?>" id="item_ppn_<?= $row ?>" name="item_bd[<?= $row ?>][id_status_pajak]" <?=(isset($item_bd['id_status_pajak']) && $item_bd['id_status_pajak'] == 1) ? 'checked' : ''?> value="1"> Y 
                                                    </div>

                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group no-margin">
                                                        <label style="display:block;">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger" onclick="removeItem('<?= $row ?>');">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>
                            <div class="row group-form-button">
                                <div class="text-left">
                                    <button type="button" class="btn btn-success" onclick="addItemBd();">+ Add Item</button>
                                </div>
                            </div>
                        </div>
                        <!-- /#End Item Info -->

                        <?php if (isset($post['id_form_bd'])) :?>
                            <div role="tabpanel" class="form tab-pane fade" id="pph">

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Verify by Tax</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="verify_by_tax" id="verify_by_tax" value="<?= (isset($post['verify_by_tax'])) ? $post['verify_by_tax'] : date('Y-m-d') ?>" readonly="readonly"/>
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $total_amount = 0;
                                foreach ($post['item_bds'] as $row => $item_pph) :
                                ?>
                                <div id="wrap-item-pph-<?=$row?>" class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?=$item_pph['name']?></h3>
                                        
                                    </div>
                                    <div id="form-message-pph-result-<?=$row?>"></div>
                                    <div id="row-group-item-pph-<?=$row?>" class="panel-body">

                                        <?php foreach ($item_pph['pph_item'] as $key => $pph_item) : ?>
                                              <div class="row-item-pph row" id="row-item-pph-<?=$key?>">
                                                      <div class="col-lg-1">
                                                          <div class="form-group no-margin">
                                                              <label for="pph_label_0">PPH</label> <span class="row_num"><?=$key+1?></span> 
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-3">
                                                          <label for="pph_label_<?=$key?>">PPH</label>
                                                          <br>
                                                          <?=$pph_item['tax_name']?>
                                                      </div>
                                                      <div class="col-lg-2">
                                                          <div class="form-group no-margin">
                                                              <label for="item_pph_percentage0">Percentage (%)</label><br>
                                                              <?=$pph_item['percentage']?>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-2">
                                                          <div class="form-group no-margin">
                                                              <label for="item_pph_ramount0">Real Amount (<?=$item_pph['iso_2']?>)</label><br>
                                                              <?=$item_pph['real_amount']?>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-2">
                                                          <div class="form-group no-margin">
                                                              <label for="item_pph_famount0">Final Amount (<?=$item_pph['iso_2']?>)</label><br>
                                                              <?=$item_pph['real_amount'] - ($item_pph['real_amount'] * $pph_item['percentage']/100) ?>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-2">
                                                          <div class="form-group no-margin">
                                                            <a data-row="<?=$row?>" data-id="<?=$pph_item['id_form_bd_item_pph']?>" data-id-item="<?=$pph_item['id_form_bd_item']?>" class="delete_item_pph btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <a data-row="<?=$row?>" data-id-item="<?=$pph_item['id_form_bd_item']?>" data-id="<?=$pph_item['id_form_bd_item_pph']?>" class="edit_item_pph btn btn-info"><i class="fa fa-pencil"></i></a>
                                                              <!-- <label style="display:block;">&nbsp;</label> -->
                                                              <!-- <button type="button" class="btn btn-danger" onclick="removeItemPPH('0');">-</button> -->
                                                          </div>
                                                      </div>
                                              </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="panel-footer">
                                        <a  onclick="addItem(<?=$row?>,<?=$item_pph['real_amount']?>,<?=$item_pph['id_form_bd_item']?>,<?=$item_pph['factor_curs']?>);" data-row="<?=$row?>" class="btn btn-success pull-right"><i class="fa fa-plus "></i>PPh</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <?php
                                    endforeach;
                                ?>
                                
                            </div>
                        <?php endif; ?>
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
<div id="modalAddVendor" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Vendor</h4>
      </div>
      <div class="modal-body">
        <form id="form-add-vendor"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-vendor-message"></div>
                    <div class="form-group">
                        <label for="id_category_vendor">Category</label>
                        <select class="form-control" name="id_category_vendor" id="id_category_vendor">
                        <?php foreach ($category_vendor as $key => $vendor) : ?>
                            <option value="<?=$vendor['id_vendor_category']?>"><?=$vendor['category_name']?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" class="form-control" name="npwp" id="npwp" value="">
                    </div>
                    <div class="form-group">
                        <label for="address">Address NPWP</label>
                        <textarea class="form-control" rows="3" id="address_npwp" name="address_npwp"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" rows="3" id="address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">Phone</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="">
                    </div>
                    <div id="wrap_account_vendor">
                        <div class="row">
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>No.</label>
                                    1.
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="account[0][bank_name]" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account[0][account_number]" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="account[0][account_name]" >
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>No.</label>
                                    2.
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="account[1][bank_name]" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account[1][account_number]" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="account[1][account_name]" >
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_vendor" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modalAddRequestor" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Requestor</h4>
      </div>
      <div class="modal-body">
        <form id="form-add-requestor"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-requestor-message"></div>
                    <div class="form-group">
                        <label for="modal_id_divisi">Divisi</label>
                        <select class="form-control" name="id_divisi" id="id_divisi">
                            <option value="0">Pilih Divisi</option>
                            <?php
                            foreach ($divisi as $key => $dv) :
                            ?>
                            <option <?= (isset($post['id_divisi']) && $post['id_divisi']==$dv['id_divisi']) ? 'selected="selected"' : '' ?> value="<?=$dv['id_divisi']?>"><?=$dv['name']?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <script type="text/javascript">
                        $('#form-add-requestor #id_divisi').change(function (){
                            var data = [
                                    {name:"id_divisi",value:$(this).val()},
                                    
                                   ];        
                        
                            ajax_post_form("<?=site_url('bd_form/getCostcenterByDivisi')?>",data)
                            
                            .done(function(response) {
                                if(response['html']){
                                    $('#form-add-requestor #id_cost_center').html(response['html']);
                                    
                                }else{
                                    $('#form-add-requestor #id_cost_center').html('<option>Pilih Cost Center</option>');
                                }
                                
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label for="modal_id_cost_center">Cost Center</label>
                        <select class="form-control" name="id_cost_center" id="id_cost_center">
                            <option value="0">Pilih Cost Center</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="">
                    </div>
                    
                </div>
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_requestors" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modalEditPPH" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Item PPH</h4>
      </div>
      <div class="modal-body">
        <form id="form-edit-pph"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_edit_pph" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modalEditItemBD" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Item BD</h4>
      </div>
      <div class="modal-body">
        <form id="form-edit-item-bd"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_edit_item_bd" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $('.number_format').number(true,2,',','.');
    $('#add_requestor').click(function(){
        $('#modalAddRequestor').modal('show');
    });
    $('#save_form_requestors').click(function (){
        var data = $('#form-add-requestor').serializeArray();      
       
        ajax_post_form("<?=site_url('bd_form/saveRequestor')?>",data)
        
        .done(function(response) {
            if(response['success']){
                $('#form-add-requestor #form-requestor-message').html(response['success']);
                $('#id_requestor').html(response['html']);
                $('#id_requestor').select2();
                $('#modalAddRequestor').modal('hide');
                $( '#form-add-requestor' ).each(function(){
                    this.reset();
                });
            }else{
                $('#form-add-requestor #form-requestor-message').html(response['error']);
            }
            
        });
    });
    $('select[id^="item_id_vendor_"]').select2();
    $('#id_divisi').select2();
    $('#bd_number').keyup(function(){

        $('#label_bd_number').show();
        var data = [
                    {name:"bd_number",value:$(this).val()}
                   ];        
        
            ajax_post_form('<?=site_url("bd_form/CheckBdNumber")?>',data)
            
            .always(function() {
              if($('#bd_number').hasClass('border_red')==false){
                    $('#bd_number').addClass('border_red');
                }
            })
            .done(function(response) {
                if(response['error']==1){
                   if($('#bd_number').hasClass('border_red')==false){
                        $('#bd_number').addClass('border_red');
                    }else if($('#bd_number').hasClass('border_green')==true){
                        $('#bd_number').removeClass('border_green');
                        $('#bd_number').addClass('border_red');
                    }
                }else{
                    if($('#bd_number').hasClass('border_green')==false){
                        //alert('belom ada');
                        $('#bd_number').addClass('border_green');
                    }else if($('#bd_number').hasClass('border_red')==true){
                        $('#bd_number').removeClass('border_red');
                        $('#bd_number').addClass('border_green');
                    }
                }
                $('#label_bd_number').hide();
            });
    });
    $('#soa_number').keyup(function(){

        $('#label_soa_number').show();
        var data = [
                    {name:"soa_number",value:$(this).val()}
                   ];        
        
            ajax_post_form('<?=site_url("bd_form/CheckSOANumber")?>',data)
            
            .always(function() {
              if($('#soa_number').hasClass('border_red')==false){
                    $('#soa_number').addClass('border_red');
                }
            })
            .done(function(response) {
                if(response['error']==1){
                   if($('#soa_number').hasClass('border_red')==false){
                        $('#soa_number').addClass('border_red');
                    }else if($('#soa_number').hasClass('border_green')==true){
                        $('#soa_number').removeClass('border_green');
                        $('#soa_number').addClass('border_red');
                    }
                }else{
                    if($('#soa_number').hasClass('border_green')==false){
                        //alert('belom ada');
                        $('#soa_number').addClass('border_green');
                    }else if($('#soa_number').hasClass('border_red')==true){
                        $('#soa_number').removeClass('border_red');
                        $('#soa_number').addClass('border_green');
                    }
                }
                $('#label_soa_number').hide();
            });
    });
    function getVendor(){
        var vendor = '';
        
        var data = [
                    {name:"a",value:'a'}
                   ];  
        return ajax_post_form('<?=site_url("bd_form/getVendor")?>',data);
            
            // .always(function() {
              
            // })
            // .done(function(data) {
            //     //console.log(data.html);
                
            // });


            
    }
    function addItemBd(){
            var row = $(".row-item").length;
            var not_show = '';
            var label_first='';

            if (row > 0) {
                not_show = 'style="display:block;"';
                
            }
            if(row == 0){
                label_first = '<label style="display:block;">&nbsp;</label>';
            }
            

            var data_vendor = '';
            var vendor = getVendor().done(function(data) {
                var date = "<?php echo date('Y-m-d'); ?>";
                var data_vendor   = data.html_vendor;
                var data_currency = data.html_currency;
                var number = parseInt(row) + 1;
            html = '\
                <div class="row-item row" id="row-item-'+row+'">\
                    <div class="col-lg-1">\
                        <div class="form-group no-margin">\
                            <label for="rule_'+row+'" '+not_show+'>Rule</label>\
                            <span class="row_num">'+number+'</span>\
                        </div>\
                    </div>\
                    <div class="col-lg-3">\
                        <div class="form-group no-margin">\
                            <label for="item_bd_desc'+row+'" '+not_show+'>Description</label>\
                            <textarea class="form-control promo_type" id="item_desc_'+row+'" name="item_bd['+row+'][name]" data-row="'+row+'"></textarea>\
                        </div>\
                        <div class="form-group no-margin">\
                            <label for="item_id_vendor'+row+'">Vendor <a data-row="'+row+'"  class="add_vendor btn btn-success"><i class="fa fa-plus"></i></a></label>\
                            <select class="form-control" data-row="'+row+'" name="item_bd['+row+'][id_vendor]" id="item_id_vendor_'+row+'">\
                                '+
                                data_vendor  
                        +'</select>\
                        </div>\
                    </div>\
                    <div class="col-lg-2">\
                        <div class="form-group no-margin">\
                            <label for="item_bd_ramount'+row+'" '+not_show+'>Real Amount</label>\
                            <input data-row="'+row+'" type="text" class="form-control number_format" name="item_bd['+row+'][real_amount]" id="item_real_amount_'+row+'" placeholder="Real">\
                        </div>\
                        <div id="wrap_bank_name_'+row+'">\
                        </div>\
                        <div class="form-group no-margin">\
                            <label for="item_bank_number'+row+'">Bank Name</label>\
                            <input readonly="readonly" data-row="'+row+'" type="text" class="form-control" name="item_bd['+row+'][bank_number]" id="item_bank_number_'+row+'" placeholder="">\
                        </div>\
                    </div>\
                    <div class="col-lg-2">\
                        <div class="form-group no-margin">\
                            <label for="item_bd_currency'+row+'" '+not_show+'>Currency</label>\
                            <select class="form-control promo_type" id="item_currency_'+row+'" name="item_bd['+row+'][id_currency]" data-row="'+row+'">\
                                '+
                                data_currency
                            +'</select>\
                        </div>\
                        <div id="wrap_account_number_'+row+'">\
                        </div>\
                    </div>\
                    <div class="col-lg-2">\
                        <div id="wrap_curs_ppn_'+row+'" style="display:none" class="form-group no-margin">\
                            <label for="item_curs_ppn'+row+'" '+not_show+'>Nominal PPn</label>\
                            <input type="number" class="form-control" name="item_bd['+row+'][curs_ppn]" id="item_curs_ppn_'+row+'" placeholder="Nominal PPn">\
                        </div>\
                        <div id="wrap_account_name_'+row+'">\
                        </div>\
                        <div class="form-group no-margin">\
                            <label for="item_account_name'+row+'">Account Name</label>\
                            <input readonly="readonly" data-row="'+row+'" type="text" class="form-control" name="item_bd['+row+'][account_name]" id="item_account_name_'+row+'" placeholder="">\
                        </div>\
                    </div>\
                    <div class="col-lg-1">\
                        <div class="form-group">\
                            <label for="item_bd_ppn'+row+'" '+not_show+'>PPN</label><br>\
                            <input type="checkbox" data-row="'+row+'" id="item_ppn_'+row+'" name="item_bd['+row+'][id_status_pajak]" value="1"> Y \
                        </div>\
                    </div>\
                    <div class="col-lg-1">\
                        <div class="form-group no-margin">\
                            <label style="display:block;">&nbsp;</label>\
                            <button type="button" class="btn btn-danger" onclick="removeItem(\''+row+'\');">-</button>\
                        </div>\
                    </div>\
                </div>';
            $(".group-form-field").append(html);
            $('.number_format').number(true,2,',','.');
            var datePickerOptions = {
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd"
                    // ...
                }
            $('.datepicker, .input-group.date').datepicker({
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd"
                });
            $('select[id^="item_id_vendor_"]').select2();

            });
            
           
        }
        $(".datepicker").datepicker();
    function removeItem(id) {
        //alert(id);
        $("#row-item-"+id).remove();
    }
    <?php /* ?>
    $(document).on('change', 'select[id^="item_currency_"]', function (event) {

        var row_id   = $(this).attr('data-row');
        var id_current = $(this).val();
        var real_number = $('#item_real_amount_'+row_id).val();
        if(id_current==2){
            if(real_number != ''){
                var final_amount = real_number * 13000; 
            }else{
                final_amount = 0;
            }

            $('#item_final_amount_'+row_id).val(final_amount);
        }else{
            $('#item_final_amount_'+row_id).val(real_number);
        }
    }); 
    <?php */ ?>
        
    
    
    $(document).on('blur', 'input[id^="item_real_amount_"]', function (event) {
        var row_id   = $(this).attr('data-row');
        //alert(row_id);
        $('#item_final_amount_'+row_id).val($(this).val());
    });
</script>
<?php if (isset($post['id_form_bd'])) :?>
<script type="text/javascript">
    $(document).on('click','.edit_item_bd',function(){
        var id = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var data = [{name:'id_form_bd_item',value:id}];
        ajax_post_form("<?=site_url('bd_form/edit_item_bd')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                $('#form-edit-item-bd .row').html(response['html']);
                $('#modalEditItemBD').modal('show');
            });
    });
    $(document).on('change', '#modalEditItemBD #ppn', function (event) {

        
        $('#wrap_curs_ppn').toggle(this.checked);
        $('#modalEditItemBD #curs_ppn').val(1);
    });
    function getDetailPayment(bd_number){
        var data = [{name:'bd_number',value:bd_number}];
        ajax_post_form("<?=site_url('payment/GetDetailPayment')?>",data)
            .done(function(response) {
                    if(response['error']){
                        $('.form-edit-item-bd-message').html(response['error']);
                    }else{ 
                       
                        $('#detail_payment').html(response['html']);
                        
                    }
                
                
            });
    }
    $('#modalEditItemBD #save_form_edit_item_bd').click(function (){
        var self = $(this);
        var self_html = $(this).html();
        var bd_number = "<?=$post['bd_number']?>";
            
         
        var data =  $('#form-edit-item-bd').serializeArray();      
        

            ajax_post_form("<?=site_url('bd_form/save_item_bd')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-edit-item-bd-message').html(response['error']);
                    }else{ 
                        getDetailPayment(bd_number);
                        $('#modalEditItemBD').modal('hide');
                        
                    }
                
                
            });
    });
    $(document).on('click','.delete_item_bd',function(){
        if (confirm('Are You sure want to delete this record?')) {
            var self = $(this);
            var self_html = $(this).html();
            var bd_number = "<?=$post['bd_number']?>";
            var id_form_bd_item = $(this).attr('data-id');   
             
            var data =  [{name:'id_form_bd_item',value:id_form_bd_item}];      
            

                ajax_post_form("<?=site_url('bd_form/delete_item_bd')?>",data)
                
                .always(function() {
                    self.html(self_html);
                    self.removeAttr('disabled');
                })
                .done(function(response) {
                        $('.form-message').html(response['message']);
                        getDetailPayment(bd_number);
    
                    
                    
                });
        }
    });
    function addItem(id,price,id_item,factor_curs){
        var row = $("#row-group-item-pph-"+id+" .row-item-pph").length;
        var number = parseInt(row) + 1;
        var not_show = '';
        var label_first='';
        var type='';
        var sub_type ='';
        var final_amount = parseFloat(price) * parseFloat(factor_curs);
        <?php 
        $type='';
        foreach ($pph_type as $key => $pph) {
            $type .= '<option value="'.$pph['id_sub_tax'].'">'.$pph['name'].'</option>';
        }

        
        ?>

        type =' <?=$type?>';
        var html = '\
        <div class="row-item-pph row" id="row-item-pph-'+row+'">\
            <div class="col-lg-1">\
                <div class="form-group no-margin">\
                    <label for="pph_label_'+row+'">PPH</label> <span class="row_num">'+number+'</span> </div>\
            </div>\
            <div class="col-lg-3">\
                <div class="form-group no-margin">\
                    <label for="item_pph_type'+row+'">PPh Type</label>\
                    <select data-curs="'+factor_curs+'" data-row-wrap="'+id+'" data-price="'+price+'" class="form-control pph_type" id="pph_type_'+row+'" name="pph['+id_item+'][item_pph]['+row+'][id_sub_tax]" data-row="'+row+'">\
                       '+
                         type  
                        +'</select>\
                </div>\
            </div>\
            <div class="col-lg-2">\
                <div class="form-group no-margin">\
                    <label for="item_pph_percentage'+row+'">Percentages (%)</label>\
                    <input data-curs="'+factor_curs+'" data-row-wrap="'+id+'" type="number" step="any" data-price="'+price+'" data-row="'+row+'" class="form-control" name="pph['+id_item+'][item_pph]['+row+'][percentage]" min="0" id="item_pph_percentage_'+row+'" placeholder="Percentage">\
                </div>\
            </div>\
            <div class="col-lg-2">\
                <div class="form-group no-margin">\
                    <label for="item_pph_amount'+row+'">Real Amount</label>\
                    <input type="number" step="any" data-curs="'+factor_curs+'" value="'+price+'" disabled class="form-control" id="item_pph_amount_'+row+'" placeholder="Real"> </div>\
            </div>\
            <div class="col-lg-3">\
                <div class="form-group no-margin">\
                    <label for="item_pph_famount'+row+'">Final Amount</label>\
                    <input type="number" step="any" value="" disabled class="form-control" id="item_pph_famount_'+row+'" placeholder="Final"> </div>\
            </div>\
            <div class="col-lg-1">\
                <div class="form-group no-margin">\
                    <label style="display:block;">&nbsp;</label>\
                    <button type="button" class="btn btn-danger" onclick="removeItemPPH(\''+row+'\',\''+id+'\');">-</button>\
                </div>\
            </div>\
        </div>\
        <br>';
        $("#row-group-item-pph-"+id).append(html);
        $('.pph_type').select2();
    }
    function removeItemPPH(id,id_nest) {
        //alert(id_nest);
        $("#row-group-item-pph-"+id_nest+" #row-item-pph-"+id).remove();
    }

    $(document).on('change', 'select[id^="pph_type_"]', function (event) {
            var row_id_nest = $(this).attr('data-row-wrap');
            var row_id   = $(this).attr('data-row');
            var factor_curs = parseFloat($(this).attr('data-curs'));
            var id_sub_tax = $(this).val();
            //var real_amount = $('#wrap-item-pph-'+row_id_nest+' #item_pph_amount_'+row_id).val();
            var real_amount = parseFloat($(this).attr('data-price'));
            var data = [
                    {name:"id_sub_tax",value:id_sub_tax}
                   ];        
        
            ajax_post_form('<?=site_url("bd_form/getTax")?>',data)
            
            .always(function() {
                
            })
            .done(function(response) {
                if(response['error']){
                    alert('Pilih lagi');
                }else{
                    $('#wrap-item-pph-'+row_id_nest+' #item_pph_percentage_'+row_id).val(response.percentage);
                    var percentage = parseFloat(response.percentage);
                    var amount = parseFloat(real_amount);
                    var final_amount =  amount - ((percentage/100) * amount);
                    $('#wrap-item-pph-'+row_id_nest+' #item_pph_amount_'+row_id).val(final_amount);

                    var final_amount_x_curs = final_amount * factor_curs;
                    $('#wrap-item-pph-'+row_id_nest+' #item_pph_famount_'+row_id).val(final_amount_x_curs);
                    //alert(final_amount_x_curs);
                }
                
            });
            
        });
    $(document).on('keyup', 'input[id^="item_pph_percentage_"]', function (event) {
            var row_id_nest = $(this).attr('data-row-wrap');
            var row_id   = $(this).attr('data-row');
            var percentage = parseFloat($(this).val());
            var real_amount = parseFloat($(this).attr('data-price'));
            var factor_curs = parseFloat($(this).attr('data-curs'));
            var final_amount = real_amount-((percentage/100) * real_amount)  ;
           // alert(row_id);
            $('#wrap-item-pph-'+row_id_nest+' #item_pph_amount_'+row_id).val(real_amount);
            var final_amount_x_curs = final_amount;
            $('#wrap-item-pph-'+row_id_nest+' #item_pph_famount_'+row_id).val(final_amount_x_curs);
        });
    $(document).on('click','.delete_item_pph',function (event){
       
        var id_item_pph = $(this).attr('data-id');
        var id_item     = $(this).attr('data-id-item');
        var self = $(this);
        var self_html = $(this).html();
        var row = $(this).attr('data-row');
        var data = [{name:'id_form_bd_item_pph',value:id_item_pph},
                    {name:'row',value:row},
                    {name:'id_form_bd_item',value:id_item}];
        ajax_post_form("<?=site_url('bd_form/delete_item_pph')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                if(response['error']){
                    $('#form-message-pph-result-'+response['row']).html(response['error']);
                }else{
                    $('#form-message-pph-result-'+response['row']).html(response['success']);
                    $('#row-group-item-pph-'+response['row']).html(response['html']);
                       
                }
                
                //$('#modalEditPPH').modal('show');
            });
    });
    $(document).on('click','.edit_item_pph',function (event){
       
        var id_item_pph = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var row = $(this).attr('data-row');
        var data = [{name:'id_form_bd_item',value:id_item_pph},
                    {name:'row',value:row}];
        ajax_post_form("<?=site_url('bd_form/edit_item_pph')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                $('#form-edit-pph .row').html(response['html']);
                $('#modalEditPPH').modal('show');
            });
    });
    $('#modalEditPPH').on('hidden.bs.modal', function () {
        $('#form-edit-pph .row').html('<i class="fa fa-spin fa-spinner"></i>Loading....');
    });
    $('#modalEditPPH #save_form_edit_pph').click(function(){
        var self = $(this);
        var self_html = $(this).html();
        
       
         
        var data =  $('#form-edit-pph').serializeArray();      
        

            ajax_post_form("<?=site_url('bd_form/save_item_pph')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-edit-pph-message').html(response['error']);
                    }else{ 
                        $('#row-group-item-pph-'+response['row']).html(response['html']);
                        // $('#item_id_vendor_'+data_row).html(response['html']);
                        // $('#item_id_vendor_'+data_row).val(response['id_vendor']).change();
                        // //$("#id_vendor").select2("val", "20");
                        // $('#wrap_account_number_'+data_row).html(response['html_list_account']);
                        $('#modalEditPPH').modal('hide');
                        // $('#form-add-vendor').find("input[type=text], textarea").val("");
                    }
                
                
            });
    });
</script>
<?php endif; ?>

<script type="text/javascript">
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    $(document).on('click', '.add_vendor', function (event) {
            //alert($(this).attr('data-row'));
            $('#form-add-vendor').attr('data-row',$(this).attr('data-row'));
            $('#modalAddVendor').modal('show');

    });
    $(document).on('click', '#save_form_vendor', function (event) {
        var self = $(this);
        var self_html = $(this).html();
        
        var data_row        = $('#form-add-vendor').attr('data-row');
         
        var data =  $('#form-add-vendor').serializeArray();      
        data.push({name:'row',value:data_row});

            ajax_post_form("<?=site_url('bd_form/add_vendor')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-vendor-message').html(response['error']);
                    }else{
                        if(data_row=='edit_item'){
                            $('#modalEditItemBD #id_vendor').html(response['html']);
                            $('#modalEditItemBD #id_vendor').val(response['id_vendor']).change();
                            //$("#id_vendor").select2("val", "20");
                            $('#modalEditItemBD #wrap_account_number').html(response['html_list_account']);
                            
                        }else{
                            $('#item_id_vendor_'+data_row).html(response['html']);
                            $('#item_id_vendor_'+data_row).val(response['id_vendor']).change();
                            //$("#id_vendor").select2("val", "20");
                            $('#wrap_account_number_'+data_row).html(response['html_list_account']);
                                
                        } 
                        $('#modalAddVendor').modal('hide');
                        $('#form-add-vendor').find("input[type=text], textarea").val("");
                    }
                
                
            });
    });
    $(document).on('change', 'select[id^="item_id_vendor_"]', function (event) {
        var id_vendor       = $(this).val();
        var data_row        = $(this).attr('data-row');
        var data = [{name:'id_vendor',value:id_vendor},
                    {name:'row',value:data_row}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByVendor')?>",data)
            
            .done(function(response) {
                if(response['html']){
                    $('#wrap_account_number_'+data_row).html(response['html']);
                    $('#id_vendor_banking_'+data_row).focus();
                }
            });
    });
    $(document).on('change', 'input[id^="item_ppn_"]', function (event) {

        var data_row        = $(this).attr('data-row');
        $('#wrap_curs_ppn_'+data_row).toggle(this.checked);
    });
    $(document).on('blur', 'select[id^="id_vendor_banking_"]', function (event) {
        var id_vendor_banking = $(this).val();
        var data_row        = $(this).attr('data-row');
        var data = [{name:'id_vendor_banking',value:id_vendor_banking}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByIdNumber')?>",data)
            
            .done(function(response) {
                $('#item_bank_number_'+data_row).val(response['bank_name']).attr('readonly', true);
                $('#item_account_name_'+data_row).val(response['account_name']).attr('readonly', true);
            });
    });
    $(document).on('change', 'select[id^="id_vendor_banking_"]', function (event) {
        var id_vendor_banking = $(this).val();
        var data_row        = $(this).attr('data-row');
        var data = [{name:'id_vendor_banking',value:id_vendor_banking}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByIdNumber')?>",data)
            
            .done(function(response) {
                $('#item_bank_number_'+data_row).val(response['bank_name']).attr('readonly', true);
                $('#item_account_name_'+data_row).val(response['account_name']).attr('readonly', true);
            });
    });
    $(document).on('keypress', 'input[type="number"]', function (event) {
        if ( event.which == 45 || event.which == 189 ) {
              event.preventDefault();
           }
    });
</script>