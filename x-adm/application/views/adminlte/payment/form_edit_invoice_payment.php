<div class="col-lg-12">
	<div class="form-message-invoice-payment"></div>
	<div class="form-group">
		<input type="hidden" class="form-control" name="id_invoice_payment" value="<?=isset($record['id_invoice_payment']) ? $record['id_invoice_payment'] : ''?> ">
		<label>BD Paid Number</label>
		<input type="text" class="form-control" name="bd_paid_number" value="<?=isset($record['bd_paid_number']) ? $record['bd_paid_number'] : ''?> ">
	</div>
	<div class="form-group">
		<label>Date of Paid</label>
		<div class="input-group date">
		    <input type="text" class="form-control" name="date_of_paid" id="date_of_paid" value="<?=isset($record['date_of_paid']) ? $record['date_of_paid']: ''?> " readonly="readonly">
		    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
	</div>
	<div class="form-group">
		<label>Spending Amount</label>
		<input type="number" class="form-control" name="spending_amount" value="<?=isset($record['spending_amount']) ? $record['spending_amount']: ''?>">
	</div>
	<div class="form-group"> 
		<label>Payment By </label>
		<br>
		<label class="radio-inline">								  
			<input type="radio" name="payment_by" id="payment_by" <?= (isset($record['payment_by']) && $record['payment_by'] == 1) ? 'checked' : '' ?> value="1"> Transfer	
		</label>
		<label class="radio-inline">								  
			<input type="radio" name="payment_by" id="payment_by" <?= (isset($record['payment_by']) && $record['payment_by'] == 2) ? 'checked' : '' ?> value="2"> Cheque/Giro		
		</label> 
		<label class="radio-inline">								  
			<input type="radio" name="payment_by" id="payment_by" <?= (isset($record['payment_by']) && $record['payment_by'] == 3) ? 'checked' : '' ?> value="3"> Cash
		</label> 
		<label class="radio-inline">								  
			<input type="radio" name="payment_by" id="payment_by" <?= (isset($record['payment_by']) && $record['payment_by'] == 4) ? 'checked' : '' ?> value="4"> Auto Debit
		</label>
		<input type="text" placeholder="No. Attribute" name="attr_payment" class="form-control" id="attr_payment" value="<?= isset($record['attr_payment']) ? $record['attr_payment'] : '' ?>"> 
	</div>
</div>
<script type="text/javascript">
	$('.datepicker, .input-group.date').datepicker({
        keyboardNavigation: false,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });
</script>