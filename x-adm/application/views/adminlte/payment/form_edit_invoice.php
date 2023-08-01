<div class="col-lg-12">
	<div class="form-message-invoice"></div>
	<div class="form-group">
		<input type="hidden" class="form-control" name="id_invoice" value="<?=isset($record['id_invoice']) ? $record['id_invoice'] : ''?> ">
		<label>Invoice Number</label>
		<input type="text" class="form-control" name="invoice_number" value="<?=isset($record['invoice_number']) ? $record['invoice_number'] : ''?> ">
	</div>
	<div class="form-group">
		<label>Invoice Date</label>
		<div class="input-group date">
		    <input type="text" class="form-control" name="invoice_date" id="invoice_date" value="<?=isset($record['invoice_date']) ? $record['invoice_date']: ''?> " readonly="readonly">
		    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
	</div>
	<div class="form-group">
		<label>Tax Document Number</label>
		<input type="text" class="form-control" name="tax_number" value="<?=isset($record['tax_number']) ? $record['tax_number']: ''?>">
	</div>
	<div class="form-group">
		<label>Tax Document Date</label>
		<div class="input-group date">
		    <input type="text" class="form-control" name="tax_date" id="tax_date" value="<?=isset($record['tax_date']) ? $record['tax_date']: ''?>" readonly="readonly">
		    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
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