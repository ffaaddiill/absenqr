<div class="col-lg-12">
    <div class="form-edit-pph-message"></div>
    <input type="hidden" value="<?=$record['id_item_pph']?>" step="any" class="form-control" name="id_form_<?=$type?>_item_pph">
    <input type="hidden" value="<?=$record['id_item']?>" step="any" class="form-control" name="id_form_<?=$type?>_item">
    <input type="hidden" value="<?=$row?>"  name="row">
    <div class="form-group">
        <label for="modal_pph_type">PPH Type</label>
        <select data-price="<?=$record['real_amount']?>" class="form-control" name="id_sub_tax" id="id_sub_tax">
            <option value="0">Pilih PPH</option>
            <?php
            foreach ($pph_type as $key => $dv) :
            ?>
            <option <?= (isset($record['id_sub_tax']) && $record['id_sub_tax']==$dv['id_sub_tax']) ? 'selected="selected"' : '' ?> value="<?=$dv['id_sub_tax']?>"><?=$dv['name']?></option>
            <?php
            endforeach;
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="modal_percentage">Percentage (%) </label>
        <input type="number" data-price="<?=$record['real_amount']?>" value="<?=$record['percentage']?>" step="any" class="form-control" name="percentage" min="0" id="percentage" placeholder="Percentage">
        
    </div>
    <div class="form-group">
        <label for="modal_real_amount">Real Amount </label>
        <input type="number" disabled  step="any" class="form-control"  min="0" id="real_amount" placeholder="Real amount">
        
    </div>
    <div class="form-group">
        <label for="modal_final_amount">Final Amount </label>
        <input type="number" disabled step="any" class="form-control"  min="0" id="final_amount" placeholder="Final Amount">
        
    </div>
    
</div>
<script type="text/javascript">
    $('#modalEditPPH #id_sub_tax').select2();
    $('#modalEditPPH #id_sub_tax').change(function(){
        var id_sub_tax = $(this).val();
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
                $('#modalEditPPH #percentage').val(response.percentage);
                var percentage = parseFloat(response.percentage);
                
                var amount = parseFloat(real_amount);
                var final_amount =  amount - ((percentage/100) * amount);
                $('#modalEditPPH #final_amount').val(final_amount);
                $('#modalEditPPH #real_amount').val(real_amount);
                
            }
            
        });

    });
    $('#modalEditPPH #percentage').keyup(function (){
        //alert();
        var percentage = parseFloat($(this).val());
        var real_amount = parseFloat($(this).attr('data-price'));
        var final_amount = real_amount-((percentage/100) * real_amount)  ;
       // alert(row_id);
        $('#modalEditPPH #real_amount').val(real_amount);
        var final_amount_x_curs = final_amount;
        $('#modalEditPPH #final_amount').val(final_amount_x_curs);
    });
    
</script>