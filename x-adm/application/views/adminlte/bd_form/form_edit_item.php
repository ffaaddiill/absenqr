<?php
$id_item = 'id_form_'.$type.'_item';
?>
<div class="col-lg-12">
    <div class="form-edit-item-bd-message"></div>
    <input type="hidden" name="<?=$id_item?>" value="<?=$record[$id_item]?>"/>
    <input type="hidden" name="bd_number" value="<?=$record['bd_number']?>"/>
    <div class="form-group ">
        <label for="bd_desc">Description</label>
        <textarea class="form-control promo_type" id="desc" name="name" ><?=$record['name']?></textarea>
    </div>
    <?php if(isset($record['id_form_bd_item'])) : ?>   
    <div class="form-group ">
        <label for="id_vendor0">Vendor <a  data-row="edit_item" class="add_vendor btn btn-success"><i class="fa fa-plus"></i></a></label>
        <select class="form-control" name="id_vendor" id="id_vendor" >
            <?php
                foreach($list_vendors as $vendor) {
                    //echo $vendor['id_category_vendor';
                    
                    if($vendor['id_category_vendor']==3){
                        $prefix = '';
                    }else{
                        $prefix = $vendor['category_name'];
                    }
                    if (isset($record['id_vendor']) && $vendor['id_vendor'] == $record['id_vendor']) {
                        echo '<option value="'.$vendor['id_vendor'].'" selected="selected">'.$prefix.' '.$vendor['name'].'</option>';
                    } else {
                        echo '<option value="'.$vendor['id_vendor'].'">'.$prefix.' '.$vendor['name'].'</option>';
                    }
                }
            ?>
            
        </select>
    </div>
    <?php endif; ?>
    <div class="form-group ">
        <label for="bd_ramount">Real Amount</label>
        <input  type="number" class="form-control" value="<?=$record['real_amount']?>" name="real_amount" id="real_amount" placeholder="Real"> 
    </div>
    <div class="form-group ">
        <label for="bd_currency0">Currency</label>
        <select class="form-control" id="currency" name="id_currency" >
            <?php foreach ($currency as $key => $cur) {
               
            ?>
            <option <?= (isset($record['id_currency']) && $record['id_currency']==$cur['id_currency']) ? 'selected="selected"' : '' ?> value="<?=$cur['id_currency']?>"><?=$cur['iso_1']?></option>
            <?php } ?>
        </select>
    </div>
    <?php if(isset($record['id_form_bd_item'])) : ?> 
    <div id="wrap_account_number">
        <?php
        if($record['account_id']){
        ?>
            <label for="account_number">Account Number S</label>
            <select class="form-control" name="id_vendor_banking" id="id_vendor_banking_edit_item">
                <?php
                foreach ($record['account_id'] as $k => $account) {
                    
                ?>
                <option value="<?=$account['id_vendor_banking']?>"><?=$account['account_number']?></option>
                <?php
                # code...
                }
                ?>
            </select>
        <?php    
        }
        ?> 
        
    </div>
    <div class="form-group ">
        <label for="bank_number">Bank Name</label>
        <input readonly="readonly"  type="text" class="form-control" id="bank_number" placeholder=""> 
    </div>
    <div class="form-group ">
        <label for="account_name0">Account Name</label>
        <input readonly="readonly"  type="text" class="form-control" id="account_name" placeholder=""> 
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="bd_ppn0">PPN</label>
        <br>
        <input type="checkbox" <?= (isset($record['id_status_pajak']) && $record['id_status_pajak']==1 ) ? 'checked="checked"' : ''   ?> id="ppn" name="id_status_pajak" value="1"> Y 
    </div>
    <div id="wrap_curs_ppn" style="<?= (isset($record['id_status_pajak']) && $record['id_status_pajak']==1 ) ? 'display="block"' : 'display="none"'   ?>" class="form-group ">
        <label for="curs_ppn0">Curs PPn</label>
        <input type="number" class="form-control" value="<?= (isset($record['curs_ppn']))? $record['curs_ppn'] : 1   ?>" name="curs_ppn" id="curs_ppn" placeholder="Curs PPn"> </div>
    <div id="wrap_account_name"> </div>
    





    <div class="form-group ">
        <label style="display:block;">&nbsp;</label>
        <!-- <button type="button" class="btn btn-danger" onclick="removeItem('0');">-</button> -->
    </div>
</div>
<script type="text/javascript">
    $('#modalEditItemBD #id_vendor').select2();
    $(document).on('change','#modalEditItemBD #id_vendor',function(){
        var id_vendor       = $(this).val();
        var data_row        = 'edit_item';
        var data = [{name:'id_vendor',value:id_vendor},
                    {name:'row',value:data_row}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByVendor')?>",data)
            
            .done(function(response) {
                if(response['html']){
                    $('#wrap_account_number').html(response['html']);
                    $('#id_vendor_banking').focus();
                }
            });
    });
    $(document).on('blur', 'select[id^="id_vendor_banking"]', function (event) {
        var id_vendor_banking = $(this).val();
        //var data_row        = $(this).attr('data-row');
        var data = [{name:'id_vendor_banking',value:id_vendor_banking}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByIdNumber')?>",data)
            
            .done(function(response) {
                $('#bank_number').val(response['bank_name']).attr('readonly', true);
                $('#account_name').val(response['account_name']).attr('readonly', true);
            });
    });
    $(document).on('change', 'select[id^="id_vendor_banking"]', function (event) {
        var id_vendor_banking = $(this).val();
        //var data_row        = $(this).attr('data-row');
        var data = [{name:'id_vendor_banking',value:id_vendor_banking}
                    ];
        ajax_post_form("<?=site_url('bd_form/getAccountBankingByIdNumber')?>",data)
            
            .done(function(response) {
                $('#bank_number').val(response['bank_name']).attr('readonly', true);
                $('#account_name').val(response['account_name']).attr('readonly', true);
            });
    });
</script>