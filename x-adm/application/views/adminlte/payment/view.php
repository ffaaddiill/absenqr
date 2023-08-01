<style type="text/css">

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
                Payment Form
            </div>
            <div class="panel-body">
            	<?php echo form_open($form_action,'class="form-horizontal" role="form" enctype="multipart/form-data"'); ?>
            	<div role="tabpanel" id="tabster">
            		<ul class="nav nav-tabs" role="tablist">
            			<li role="presentation" class="active"><a href="#basic_info" aria-controls="basic_info" role="tab" data-toggle="tab">Detail BD</a></li>
            			<li role="presentation" ><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Do Payment</a></li>
            			<!-- <li role="presentation" ><a href="#payment-history" aria-controls="payment-history" role="tab" data-toggle="tab">Payment History</a></li> -->
            			
            		</ul>
            		<div class="tab-content">
                        <!-- /#Basic Info -->
                        <div role="tabpanel" class="tab-pane fade in active" id="basic_info">
                        	<div class="row">
                                <div class="col-lg-12">
                                	<!-- <div class="form-group">
                                		<label>Total Amount</label>
                                		<?=$post['total_amount']['net_amount']?>
                                	</div> -->

                                	<!-- <div class="form-group">
                                        <label for="curs_finance"  class="col-lg-2 control-label text-left">Curs Finance</label>
                                        <div class="col-lg-4">

                                            <input  value="<?= (isset($post['curs_finance'])) ? $post['curs_finance'] : '' ?>" type="text" class="form-control" name="curs_finance" id="curs_finance" placeholder="Input Curs Finance">
                                        </div>
                                    </div> -->
                                	<div class="form-group">
                                        <label for="bd_number"  class="col-lg-2 control-label text-left">BD No.</label>
                                        <div class="col-lg-4">

                                            <input disabled value="<?= (isset($post['bd_number'])) ? $post['bd_number'] : '' ?>" type="text" class="form-control" name="bd_number" id="bd_number" placeholder="BD Number">
                                        </div>
                                    </div>
                                    <?php
                                    if($post['payment_type']==2){                                    
                                    ?>
                                    <div class="form-group">
                                        <label for="soa_number"  class="col-lg-2 control-label text-left">SOA No.</label>
                                        <div class="col-lg-4">

                                            <input  value="<?= (isset($post['soa_number'])) ? $post['soa_number'] : '' ?>" type="text" class="form-control" name="soa_number" id="soa_number" placeholder="SOA Number">
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                	<a class="btn btn-success" id="show_detail">Show Detail Payment</a>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-lg-12" id="detail_payment">
                            		
                            	</div>
                            </div>
                        </div>
                        <!-- End Basic Info -->
                        <!-- Payment -->
                        <div role="tabpanel" class="tab-pane fade" id="payment">
                        	<div class="row warp-detail-payment">
                        		<div class="col-lg-6">
                        			<div class="form-group">
                        				<label class="total_amount">Total :</label>
                        				<span class="total_amount">
                        					<?=$post['item_bds'][0]['iso_2']?> <?=number_format($post['total_amount'],2,",",".");?>
                        					 <?=(isset($post['total_ppn']) && $post['total_ppn'] != 0)  ? '
                        					 <br> <span style="font-size: 27px;color: green;font-weight: 600;">PPn : Rp. '.number_format($post['total_ppn'],2,",",".").'</span> ' : '' ?> 
                        				</span>
                        			</div>
                        			<div class="form-group">
                        				<label>Request Date :</label>
                        				<?=date('d F Y',strtotime($post['request_date']))?>
                        			</div>
                        			<div class="form-group">
                        				<label>Due Date :</label>
                        				<?=date('d F Y',strtotime($post['due_date']))?>
                        			</div>
                        		</div>
                        		<div class="col-lg-6">
                        			<div class="sticky-box">
									    <div class="well panel panel-sticky" id="PanelChosenPackage">
									        <div class="sticky-header">
									            <span class="sticky-heading">Total Payment:</span>
									            <span class="status_bd">
									            	<?php
									            	$total_bayar = total_bayar_invoice($post['history_payment']);
									            	// print_r($total_bayar);
									            	// die();
									            	?>
									            	
									            	<?=number_format($total_bayar['dpp'],2,',','.')?>
									            	<br>
									            	<?php
									            	if($total_bayar['ppn']){
									            		echo '<span style="font-weight: 600;font-size: 17px;"">Total payment PPn: </span><br>';
									            		echo 'Rp. '.number_format($total_bayar['ppn'],2,',','.');
									            	}
									            	?>
										            <?php
										            if($post['id_status']==1){
	                        							$status_bd =  'Paid';
	                        						}elseif ($post['id_status']==2) {
	                        							$status_bd = 'Unpaid';
	                        						}elseif ($post['id_status']==3) {
	                        							$status_bd = 'Partial';
	                        						}elseif ($post['id_status']==4) {
	                        							$status_bd = 'Over';
	                        						}else{
	                        							$status_bd = 'Under';
	                        						}
	                        						
		                        					if($post['total_amount'] > $total_bayar['dpp']){
		                        						$outstanding = $post['total_amount']-$total_bayar['dpp'];
		                        					}elseif($post['total_amount'] < $total_bayar['dpp']){
		                        						$outstanding = $total_bayar['dpp']-$post['total_amount'];
		                        					}else{
		                        						$outstanding = $total_bayar['dpp']-$post['total_amount'];
		                        					}
		                        					if($total_bayar['ppn']){
		                        						if($post['total_ppn'] > $total_bayar['ppn']){
			                        						$outstanding_ppn = $post['total_ppn']-$total_bayar['ppn'];
			                        					}elseif($post['total_ppn'] < $total_bayar['ppn']){
			                        						$outstanding_ppn = $total_bayar['ppn']-$post['total_ppn'];
			                        					}else{
			                        						$outstanding_ppn = $total_bayar['ppn']-$post['total_ppn'];
			                        					}
		                        					}
										            ?>
									        	</span>
									            <hr>
									            <span class="sticky-heading">Status</span> <br>
									            <span class="price-header h2 text-total-harga" id="outputharga_diskon"><?=$status_bd?>  </span><br><hr>
									           <span class="sticky-heading">Outstanding Balance</span> <br>
									            <span class="price-header h2 text-total-harga" id="outputharga_diskon">(<?=$post['item_bds'][0]['iso_2']?> <?=number_format($outstanding,2,',','.')?> )  </span><br>
									            <?php
									            if($post['item_bds'][0]['iso_2']!='IDR'){
									            	if($total_bayar['ppn']){
									            ?>
										            <br>
										            <span class="sticky-heading">Outstanding PPn</span> <br>
										            <span class="price-ppn h2 text-total-harga" id="outputharga_diskon">(Rp. <?=number_format($outstanding_ppn,2,',','.')?> )  </span>
									            <?php
									        		}
									       		 }
									            ?>
									        </div>
									    </div>
									</div>
                        			
                        		</div>
                        	</div>
                        	<div class="row">
                        		<div><a id="add_payment" class="btn btn-success">Add Invoice</a></div>
                        		
                        	</div>
                        	<div class="row group-payment-field">
                        		<div class="form-message-payment"></div>
                        		<?php 
                        			if($post['history_payment']){
                        				
                        		?>
	                        		<div role="tabpanel" id="tab-payment">
	                        			<ul class="nav nav-tabs" id="ul-tab-payment" role="tablist-payment">
	                        				<?php foreach ($post['history_payment'] as $key => $invoice) { ?>
	                        				<li role="presentation" class="<?=($key==0) ? 'active' : ' ' ?>"><a href="#item-payment-<?=$key?>" aria-controls="item-payment-<?=$key?>" role="tab" data-toggle="tab">Invoice <?=$key+1?></a></li>
	                        				<?php } ?>
	                        			</ul>
	                        			<div class="tab-content" id="tab-content-payment" >
	                        				<?php foreach ($post['history_payment'] as $key => $invoice) { ?>
	                        				<div role="tabpanel" class="payment-row tab-pane fade in <?=($key==0) ? 'active' : ' ' ?>" id="item-payment-<?=$key?>">
	                        					<div class="row">
		                        					<div class="col-lg-12">
													    <div class="form-group">
													    	<input type="hidden" class="form-control" value="<?=$invoice['id_invoice']?>" name="payment[<?=$key?>][id_invoice]" >
													        <label for="payment_invoice_number_<?=$key?>" class="col-lg-2 control-label text-left">Invoice Number 
													        </label>
													        <div class="col-lg-4">
																<?=$invoice['invoice_number']?>
													        </div>
													        <label form="payment_tax_number_<?=$key?>" class="col-lg-2 control-label text-left">Tax Document Number </label>
													    	<div class="col-lg-3">
													    		<?=$invoice['tax_number']?>
													    	</div>
													    	<div class="action">
												    			<a data-id="<?=$invoice['id_invoice']?>" class="edit_invoice btn btn-info"><i class="fa fa-pencil"></i></a>
												    		</div>
													    		
													    	
													    </div>
													    <div class="form-group">
													        <label for="payment_invoice_number_<?=$key?>" class="col-lg-2 control-label text-left">Invoice Date 
													        </label>
													        <div class="col-lg-4">
																
																<?=(isset($invoice['invoice_date']) && $invoice['invoice_date'] !='0000-00-00 00:00:00' ) ? date('d F Y',strtotime($invoice['invoice_date'])) : ' '?>
													        </div>
													        <label form="payment_tax_number_<?=$key?>" class="col-lg-2 control-label text-left">Tax Document Date </label>
													    	<div class="col-lg-3">
													    		<?=(isset($invoice['tax_date']) && $invoice['tax_date'] !='0000-00-00 00:00:00') ? date('d F Y',strtotime($invoice['tax_date'])) : ''?>
													    		
													    	</div>
													   
													    		
													    	
													    </div>
													    <div role="tabpanel" id="sub-tabster-<?=$key?>">
													    	<ul class="nav nav-tabs" role="tablist">
										            			<?php /*<li role="presentation" class="active"><a href="#item-invoice-<?=$key?>" aria-controls="item-invoice-<?=$key?>" role="tab" data-toggle="tab">Item Invoice</a></li>
										            			*/?>
										            			<li role="presentation" class="active"><a href="#payment-invoice-<?=$key?>" aria-controls="payment-invoice-<?=$key?>" role="tab" data-toggle="tab">Payment Invoice</a></li>
										            		</ul>
										            		<div class="tab-content">
										                        <!-- /#Basic Info -->
										                        <?php /*<div role="tabpanel" class="tab-pane fade in active" id="item-invoice-<?=$key?>">
										                        	<div class="form-group">
															    		<a class="btn btn-success" onclick="AddItemInvoice(<?=$key?>)"> Add Item Invoice</a>
															    	</div>
																    <!-- end of row tax number -->
																    <div id="wrap-item-payment-<?=$key?>">
																    	<div class="row row-item-invoice"  id="row-item-invoice-<?=$key?>">
																			<div class="form-group">
																		        <label for="payment_id_item_<?=$key?>" class="col-lg-2 control-label text-left">Description Item 1</label>
																		        <div class="col-lg-4">
																		            <select data-row="<?=$key?>" data-nest="<?=$key?>"  id="item_invoice_id_item_<?=$key?>" class="form-control" name="payment[<?=$key?>][item_invoice][<?=$key?>][id_item]">
																		            	<option value="">Pilih item</option>
																		            	<?php foreach ($post['item_bds'] as $key => $value) {
																		            		echo '<option value="'.$value['id_form_bd_item'].'">'.$value['name'].'</option>';
																		            	}?>
																		            	
																		            </select>
																		        </div>
																		        <label for="payment_must_paid_amount_<?=$key?>" class="col-lg-2 control-label text-left">Must Paid Amount</label>
																		        <div class="col-lg-3">
																		            <input type="number" class="form-control" id="item_invoice_must_paid_amount_<?=$key?>" disabled="disabled" />
																		        </div>
																		        <div class="col-lg-1">
																		        	<a class="btn btn-danger" onclick="removeItemInvoice(<?=$key?>,<?=$key?>)">x</a>
																		        </div>
																		    </div>
																		</div>
																    </div>
										                        </div>
										                        */?>
										                        <div role="tabpanel" class="tab-pane fade in active" id="payment-invoice-<?=$key?>">
										                        	<div class="form-group">
										                        		<a class="btn btn-success" onclick="AddItemPaymentInvoice(<?=$key?>);"> Add Payment Invoice</a>
										                        	</div>
										                        	<div id="wrap-part-payment-<?=$key?>">
										                        		<?php 

										                        			if($invoice['invoice_payment']){
										                        				foreach ($invoice['invoice_payment'] as $k => $payment) {
										                        					
										                        		?>
										                        		<div class="row row-payment-invoice" id="row-payment-invoice-<?=$k?>">
										                        			<h3>Payment <?=$k+1?> (Bd Paid Number : <span class="bd_paid_number"><?=$payment['bd_paid_number']?></span>)</h3>
										                        			<div class="col-lg-5">
										                        				<div class="form-group">
											                        				<label>Curs Finance</label>
											                        				<span class="span_payment"><?=$payment['curs_finance']?></span>
											                        				<span>*fill with 1 if spanding amount is IDR</span>
											                        			</div>
											                        			<div class="form-group">
											                        				<label>Real Amount</label>
											                        				<span class="span_payment"><?=number_format($payment['spending_amount']*$payment['curs_finance'],2,',','.')?></span>
											                        			</div>
											                        			<div class="form-group">
																				<label>Payment By </label>
																				<br>
																				<?php
																				if($payment['payment_by']==1){
																					echo '<span class="span_payment">Transfer</span>';
																				}elseif($payment['payment_by']==2){
																					echo '<span class="span_payment">Cheque/Giro</span>';
																				}elseif($payment['payment_by']==3){
																					echo '<span class="span_payment">Cash</span>';
																				}else{
																					echo '<span class="span_payment">Auto Debit</span>';
																				}
																				?>
																				<br>
																				<?php
																				if($payment['attr_payment']){

																				?>
																				<label>Attribute Payment By </label>
																				<span class="span_payment"><?=$payment['attr_payment']?></span>
																				<?php } ?> 
																				</div>
										                        			</div>
										                        			<div class="col-lg-4 col-lg-offset-1">
										                        				<div class="form-group">
											                        				<label>Paid Amount</label>
											                        				<span class="span_payment"><?=number_format($payment['spending_amount'],2,',','.')?></span>
											                        			</div>
											                        			<div class="form-group">
											                        				<label>Date Of Paid Finance</label>
											                        				<span class="span_payment"><?=date('d F Y',strtotime($payment['date_of_paid']))?></span>
											                        				
											                        			</div>

											                        			<!-- <div class="form-group">
											                        				<label>Type</label>
											                        				<span class="span_payment"></span>
											                        				
											                        			</div> -->
										                        			</div>
										                        			<div class="col-lg-1">
										                        				<a style="margin-bottom: 10px;" data-id="<?=$payment['id_invoice_payment']?>" class="delete_payment btn btn-danger"><i class="fa fa-trash"></i></a>
										                        				<br>
										                        				<a data-id="<?=$payment['id_invoice_payment']?>" class="edit_payment btn btn-info"><i class="fa fa-pencil"></i></a>
										                        			</div>
										                        		</div>
										                        		<hr>
										                        		<?php
										                        				} 
										                        			} 

										                        		?>
										                        	</div>
										                        </div>
										                    </div>
														</div>
													</div>
												</div>
	                        				</div>
	                        				<?php } ?>
	                        			</div>

	                        		</div>
                        		<?php
                 
                        			}else{

                        		?>
                    			<div role="tabpanel" id="tab-payment">
	                    			<ul class="nav nav-tabs" id="ul-tab-payment" role="tablist-payment">
	                    				<li role="presentation" class="active"><a href="#item-payment-0" aria-controls="item-payment-0" role="tab" data-toggle="tab">Invoice 1</a></li>
	                    			</ul>
	                    			<div class="tab-content" id="tab-content-payment" >
	                    				<div role="tabpanel" class="payment-row tab-pane fade in active" id="item-payment-0">
	                    					<div class="row">
	                        					<div class="col-lg-12">
												    <div class="form-group">
												        <label for="payment_invoice_number_0" class="col-lg-1 control-label text-left">Invoice No. <i id="label_invoice_number_0" style="display:none;" class="fa fa-refresh fa-spin"></i></label>
												        <div class="col-lg-4">
															<input type="text" data-row="0" class="form-control" name="payment[0][invoice_number]" id="payment_invoice_number_0" placeholder="Invoice Number">
												        </div>
												        <label form="payment_tax_number_0" class="col-lg-1 control-label text-left">Tax No.</label>
												    	<div class="col-lg-4">
												    		<input type="text" id="payment_tax_number_0" class="form-control" name="payment[0][tax_number]" placeholder="Tax Number"/>
												    	</div>
												    </div>
												    <div class="form-group"> 
													    <label for="payment_invoice_date_0" class="col-lg-1 control-label text-left">Invoice Date </label>
													    <div class="col-lg-4">
													        <div class="input-group date"> <input type="text" data-row="0" class="form-control" name="payment[0][invoice_date]" id="payment_invoice_date_0" value="" readonly="readonly"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> </div>
													    </div> 
													    <label for="payment_tax_date_0" class="col-lg-2 control-label text-left">Tax Document Date </label>
													    <div class="col-lg-4">
													        <div class="input-group date"> <input type="text" data-row="0" class="form-control" name="payment[0][tax_date]" id="payment_invoice_tax_0" value="" readonly="readonly"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> </div>
													    </div>
													</div>
												    <div role="tabpanel" id="sub-tabster-0">
												    	<ul class="nav nav-tabs" role="tablist">
									            			<?php /*<li role="presentation" class="active"><a href="#item-invoice-0" aria-controls="item-invoice-0" role="tab" data-toggle="tab">Item Invoice</a></li>
									            			*/?>
									            			<li role="presentation" class="active"><a href="#payment-invoice-0" aria-controls="payment-invoice-0" role="tab" data-toggle="tab">Payment Invoice</a></li>
									            		</ul>
									            		<div class="tab-content">
									                        <!-- /#Basic Info -->
									                        <?php /*<div role="tabpanel" class="tab-pane fade in active" id="item-invoice-0">
									                        	<div class="form-group">
														    		<a class="btn btn-success" onclick="AddItemInvoice(0)"> Add Item Invoice</a>
														    	</div>
															    <!-- end of row tax number -->
															    <div id="wrap-item-payment-0">
															    	<div class="row row-item-invoice"  id="row-item-invoice-0">
																		<div class="form-group">
																	        <label for="payment_id_item_0" class="col-lg-2 control-label text-left">Description Item 1</label>
																	        <div class="col-lg-4">
																	            <select data-row="0" data-nest="0"  id="item_invoice_id_item_0" class="form-control" name="payment[0][item_invoice][0][id_item]">
																	            	<option value="">Pilih item</option>
																	            	<?php foreach ($post['item_bds'] as $key => $value) {
																	            		echo '<option value="'.$value['id_form_bd_item'].'">'.$value['name'].'</option>';
																	            	}?>
																	            	
																	            </select>
																	        </div>
																	        <label for="payment_must_paid_amount_0" class="col-lg-2 control-label text-left">Must Paid Amount</label>
																	        <div class="col-lg-3">
																	            <input type="number" class="form-control" id="item_invoice_must_paid_amount_0" disabled="disabled" />
																	        </div>
																	        <div class="col-lg-1">
																	        	<a class="btn btn-danger" onclick="removeItemInvoice(0,0)">x</a>
																	        </div>
																	    </div>
																	</div>
															    </div>
									                        </div>
									                        */?>
									                        <div role="tabpanel" class="tab-pane fade in active" id="payment-invoice-0">
									                        	<div class="form-group">
									                        		<a class="btn btn-success" onclick="AddItemPaymentInvoice(0);"> Add Payment Invoice</a>
									                        	</div>
									                        	<div id="wrap-part-payment-0">
									                        		<div class="row row-payment-invoice" id="row-payment-invoice-0">
									                        			<h3>Payment 1</h3>
									                        			<div class="col-lg-5">
									                        				<div class="form-group">
										                        				<label>Curs Finance</label>
										                        				<input type="number" step="any" class="form-control" id="payment_invoice_curs_finance_0" name="payment[0][item_payment][0][curs_finance]" value="1" />
										                        				<span>*fill with 1 if spanding amount is IDR</span>
										                        			</div>
										                        			<div class="form-group">
										                        				<label>Real Amount</label>
										                        				<input disabled="disable" type="number" step="any" class="form-control" id="payment_invoice_real_amount_0"  value="" />
										                        			</div>
										                        			<div class="form-group">
																			<label>Payment By </label>
																			<br>
																			<label class="radio-inline">
																				<input type="radio" name="payment[0][item_payment][0][payment_by]" id="payment_invoice_payment_by_0" value="1"> Transfer 
																			</label>
																			<label class="radio-inline">
																				<input type="radio" name="payment[0][item_payment][0][payment_by]" id="payment_invoice_payment_by_0" value="2"> Cheque/Giro 
																			</label>
																			<label class="radio-inline">
																				<input type="radio" name="payment[0][item_payment][0][payment_by]" id="payment_invoice_payment_by_0" value="3"> Cash 
																			</label>
																			<label class="radio-inline">
																				<input type="radio" name="payment[0][item_payment][0][payment_by]" id="payment_invoice_payment_by_0" value="4"> Auto Debit 
																			</label>
																			<input type="text" placeholder="No. Attribute" name="payment[0][item_payment][0][attr_payment]" class="form-control" id="payment_invoice_attr_payment_0" value=""> 
																			</div>
									                        			</div>
									                        			<div class="col-lg-4 col-lg-offset-1">
									                        				<div class="form-group">
										                        				<label>Paid Amount</label>
										                        				<input data-row="0" data-nest="0"  type="number" step="any" class="form-control" id="payment_invoice_spending_amount_0" name="payment[0][item_payment][0][spending_amount]" value="" />
										                        			</div>
										                        			<div class="form-group">
										                        				<label>Date Of Paid Finance</label>
										                        				<div class="input-group date">
																	                <input type="text" class="form-control" name="payment[0][item_payment][0][date_of_paid]" id="payment_invoice_date_of_paid_0" value="<?=date('Y-m-d')?>" readonly="readonly">
																	                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
																	            </div>
										                        			</div>
										                        			<div class="form-group"> <label>Type</label>
																			    <div class="input-group"> <input type="checkbox" id="payment_invoice_type_1" name="payment[0][item_payment][0][type]" value="2"> For PPn </div>
																			</div>
									                        			</div>
									                        			<div class="col-lg-1">
									                        				<a class="btn btn-danger">x</a>
									                        			</div>
									                        		</div>
									                        	</div>
									                        </div>
									                    </div>
													</div>
												</div>
											</div>
	                    				</div>
	                    			</div>

	                    		</div>
                        		<?php
                        		}
                        		?>
                        	</div>
                        </div>
                        <?php /* 
                        <!-- History Payment -->
                        <div role="tabpanel" class="tab-pane fade" id="payment-history">
                        	<div class="row">
                        		<?php 
                        		#if($post['history_payment']){

                     
                        		?>
                        		<div role="tabpanel" id="tab-payment-history">
                        			<ul class="nav nav-tabs" id="ul-tab-payment-history" role="tablist-payment-history">
                        				<li role="presentation" class="active">
                        					<a href="#item-payment-history-0" aria-controls="item-payment-history-0" role="tab" data-toggle="tab" aria-expanded="true">Invoice 1</a>
                        				</li>
                        			</ul>
                        			<div class="tab-content" id="tab-content-payment-history">
                        				<div role="tabpanel" class="tab-pane fade active in" id="item-payment-history-0">
                        					<div class="row">
                        						<div class="col-lg-12">
                        							<div class="form-group">
												        <label for="payment_invoice_number_0" class="col-lg-2 control-label text-left">Invoice No.
												        </label>
												        <div class="col-lg-4">
															
												        </div>
												        <label form="payment_tax_number_0" class="col-lg-2 control-label text-left">
												        	Tax No.
												        </label>
												    	<div class="col-lg-4">
												    		
												    	</div>
												    </div>
                        						</div>
                        					</div>
                        				</div>
                        			</div>
                        		</div>
                        		<?php
                        		#}
                        		?>
                        	</div>
                        	<?php
                        	if($post['history_payment']){
                        		foreach ($post['history_payment'] as $key => $invoice) {
                        			
                        	
                        	?>
                        	<div class="panel panel-success">
                        	  <div class="panel-heading"> 
                        	  	<h3 class="panel-title">No: &nbsp; <?=$key+1?></h3> 
                        	  </div>
							  <div class="panel-body">
							  	<div class="row">
							  		<div class="col-lg-12">
								  		<div class="form-group">
								  			<label>No Invoice</label>
								  			<?=$invoice['invoice_number']?>
								  		</div>
								  		<div class="form-group">
								  			<label>Invoice Date</label>
								  			<?=$invoice['invoice_number']?>
								  		</div>
								  		<div class="form-group">
								  			<label>No Tax</label>
								  			<?=$invoice['tax_number']?>
								  		</div>
								  		<div class="form-group">
								  			<label>Tax faktur Date</label>
								  			<?=$invoice['tax_number']?>
								  		</div>
							  		</div>
							  	</div>
							  	<?php
							  	if($invoice['invoice_payment']){
							  		foreach ($invoice['invoice_payment'] as $k => $payment) {
							  			# code...
							  	?>
									    <div class="row">
									    	<div class="col-lg-4"></div>
									    </div>
							    <?php
							  		}
								}
							    ?>
							  </div>
							</div>
							<?php

                        		} // end foreach invoice

							}
							?>

                        </div>
                        <!-- End Payment -->
                        */?>
                        <div class="row">
	                        <div class="col-lg-4 col-lg-offset-8">
	                            <button type="submit" class="btn btn-primary">Submit</button>
	                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
	                        </div>
	                    </div>
                    </div>
            	</div>
            	<?php echo form_close(); ?>
            </div>
        </div>
	</div>
</div>
<div id="modalEditInvoice" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Invoice</h4>
      </div>
      <div class="modal-body">
        <form id="form-edit-invoice"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_edit_invoice" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalEditInvoicePayment" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Invoice Payment</h4>
      </div>
      <div class="modal-body">
        <form id="form-edit-invoice-payment"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_form_edit_invoice_payment" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$('.edit_invoice').click(function(){
		var id = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var data = [{name:'id_invoice',value:id}];
        ajax_post_form("<?=site_url('payment/edit_invoice')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                $('#form-edit-invoice .row').html(response['html']);
                $('#modalEditInvoice').modal('show');
            });
	});
	$('#save_form_edit_invoice').click(function(){
		//alert();
		var id = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var data =  $('#form-edit-invoice').serializeArray();      
        

            ajax_post_form("<?=site_url('payment/save_invoice')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-message-invoice').html(response['error']);
                    }else{ 
                        window.location.reload(true);
                        
                    }
                
                
            });
	});
	$('.delete_payment').click(function(){
		if(confirm('Are you sure delete this payment ?')){

		
		var data = [
					{name:"id_invoice_payment",value:$(this).attr('data-id')},
					{name:"bd_number",value:$('#bd_number').val()}
				   ];
		ajax_post_form('<?=site_url("payment/delete_payment")?>',data)
            
            .always(function() {
              
            })
            .done(function(response) {
            	if(response['success']){
            		window.location.reload(true);
            	}else{
            		$('.form-message-payment').html(response['error']);
            	}
                //$('#detail_payment').html(response['html']);
                
            });
        }
	});
	$('.edit_payment').click(function (){
		var id = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var data = [{name:'id_invoice_payment',value:id}];
        ajax_post_form("<?=site_url('payment/edit_invoice_payment')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                $('#form-edit-invoice-payment .row').html(response['html']);
                $('#modalEditInvoicePayment').modal('show');
            });
	});
	$('#save_form_edit_invoice_payment').click(function(){
		//alert();
		var self = $(this);
        var self_html = $(this).html();
        var data =  $('#form-edit-invoice-payment').serializeArray();      
        

            ajax_post_form("<?=site_url('payment/save_invoice_payment')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-message-invoice-payment').html(response['error']);
                    }else{ 
                        window.location.reload(true);
                        
                    }
                
                
            });
	});
	$('#show_detail').click(function (){
		
		var data = [
					{name:"bd_number",value:$('#bd_number').val()}
				   ];
		ajax_post_form('<?=site_url("payment/GetDetailPayment")?>',data)
            
            .always(function() {
              
            })
            .done(function(response) {
                $('#detail_payment').html(response['html']);
                
            });

	});

	$('#add_payment').click(function(){
		var row = $(".payment-row").length;
		var number = parseInt(row) + 1;
		<?php
	        $item = '';
	        foreach ($post['item_bds'] as $key => $dt) {
	            
	             $item .= '<option value="'.$dt['id_form_bd_item'].'">'.$dt['name'].'</option>';
	        } 
        ?>
        var item = '<?=$item?>';
		var li = '<li role="presentation" id="li-item-payment-'+row+'" class=""><a href="#item-payment-'+row+'" aria-controls="item-payment-'+row+'" role="tab" data-toggle="tab">Invoice '+number+'</a></li>';
		var row_id_item =0;
		var date = '<?php echo date('Y-m-d'); ?>';
		var tab_content = '<div role="tabpanel" class="payment-row tab-pane fade" id="item-payment-'+row+'">\
								<div class="row">\
                					<div class="col-lg-12 text-right">\
                						<a class="btn btn-danger " onclick="removeItem(\''+row+'\');">-</a>\
                					</div>\
            					</div>\
            					<div class="row">\
									<div class="col-lg-12">\
									    <div class="form-group">\
									        <label for="payment_invoice_number_'+row+'" class="col-lg-1 control-label text-left">Invoice Number <i id="label_invoice_number_'+row+'" style="display:none;" class="fa fa-refresh fa-spin"></i></label>\
									        <div class="col-lg-4">\
												<input type="text" data-row="'+row+'" class="form-control" name="payment['+row+'][invoice_number]" data-row="'+row+'" id="payment_invoice_number_'+row+'" placeholder="Invoice Number">\
									        </div>\
									        <label form="payment_tax_number_'+row+'" class="col-lg-2 control-label text-left">Tax Document Number</label>\
									    	<div class="col-lg-4">\
									    		<input data-row="'+row+'" type="text" id="payment_tax_number_'+row+'" class="form-control" name="payment['+row+'][tax_number]" placeholder="Tax Number"/>\
									    	</div>\
									    </div>\
									    <div class="form-group">\
									        <label for="payment_invoice_date_'+row+'" class="col-lg-1 control-label text-left">Invoice Date </label>\
									        <div class="col-lg-4">\
										        <div class="input-group date">\
												    <input type="text" data-row="'+row+'" class="form-control" name="payment['+row+'][invoice_date]" id="payment_invoice_date_'+row+'" value="" readonly="readonly">\
												    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>\
												</div>\
									        </div>\
									        <label for="payment_tax_date_'+row+'" class="col-lg-2 control-label text-left">Tax Document Date </label>\
									        <div class="col-lg-4">\
										        <div class="input-group date">\
												    <input type="text" data-row="'+row+'" class="form-control" name="payment['+row+'][tax_date]" id="payment_invoice_tax_'+row+'" value="" readonly="readonly">\
												    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>\
												</div>\
									        </div>\
									    </div>\
									    <div role="tabpanel" id="sub-tabster-'+row+'">\
									    	<ul class="nav nav-tabs" role="tablist">\
						            			<li role="presentation" class="active"><a href="#payment-invoice-'+row+'" aria-controls="payment-invoice-'+row+'" role="tab" data-toggle="tab">Payment Invoice</a></li>\
									    	</ul>\
									    	<div class="tab-content">\
									    		<div role="tabpanel" class="tab-pane fade in active" id="payment-invoice-'+row+'">\
									    			<div class="form-group">\
						                        		<a class="btn btn-success" onclick="AddItemPaymentInvoice(\''+row+'\')"> Add Payment Invoice</a>\
						                        	</div>\
						                        	<div id="wrap-part-payment-'+row+'">\
						                        		<div class="row row-payment-invoice" id="row-payment-invoice-'+row_id_item+'">\
						                        			<div class="col-lg-5">\
						                        				<div class="form-group">\
							                        				<label>Curs Finance</label>\
							                        				<input type="number" step="any" class="form-control" id="payment_invoice_curs_finance_0" name="payment['+row+'][item_payment][0][curs_finance]" value="1" />\
							                        				<span>*fill with 1 if spanding amount is IDR</span>\
							                        			</div>\
							                        			<div class="form-group">\
							                        				<label>Real Amount</label>\
							                        				<input disabled="disable" type="number" step="any" class="form-control" id="payment_invoice_real_amount_'+row_id_item+'"  value="" />\
							                        			</div>\
							                        			<div class="form-group">\
							                        				<label>Payment By </label><br>\
							                        				<label class="radio-inline">\
																	  <input type="radio" name="payment['+row+'][item_payment][0][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="1"> Transfer\
																	</label>\
																	<label class="radio-inline">\
																	  <input type="radio" name="payment['+row+'][item_payment][0][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="2"> Cheque/Giro\
																	</label>\
																	<label class="radio-inline">\
																	  <input type="radio" name="payment['+row+'][item_payment][0][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="3"> Cash\
																	</label>\
																	<label class="radio-inline">\
																	  <input type="radio" name="payment['+row+'][item_payment][0][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="4"> Auto Debit\
																	</label>\
																	<input  type="text" placeholder="No. Attribute" name="payment['+row+'][item_payment][0][attr_payment]" class="form-control" id="payment_invoice_attr_payment_'+row_id_item+'"  value="" />\
							                        			</div>\
							                        		</div>\
						                        			<div class="col-lg-4 col-lg-offset-1">\
						                        				<div class="form-group">\
							                        				<label>Paid Amount</label>\
							                        				<input data-row="'+row_id_item+'" data-nest="'+row+'" type="number" step="any" class="form-control" id="payment_invoice_spending_amount_'+row+'" name="payment['+row+'][item_payment][0][spending_amount]" value="" />\
							                        			</div>\
							                        			<div class="form-group">\
							                        				<label>Date Of Paid Finance</label>\
							                        				<div class="input-group date">\
														                <input type="text" class="form-control" name="payment['+row+'][item_payment][0][date_of_paid]" id="payment_invoice_date_of_paid_'+row+'" value="'+date+'" readonly="readonly">\
														                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>\
														            </div>\
							                        			</div>\
							                        			<div class="form-group">\
											        				<label>Type</label>\
											        				<div class="input-group">\
											        					<input type="checkbox" id="payment_invoice_type_'+row+'" name="payment['+row+'][item_payment][0][type]" value="2"> For PPn \
														            </div>\
											        			</div>\
						                        			</div>\
						                        			<div class="col-lg-1">\
						                        				<a class="btn btn-danger" onclick="removeItemInvoicePayment(\''+row+'\',\''+row_id_item+'\');">x</a>\
						                        			</div>\
						                        		</div>\
						                        	</div>\
									    		</div>\
									    	</div>\
									    </div>\
									</div>\
								</div>\
							</div>';

			
			$('#ul-tab-payment').append(li);
			$('#tab-content-payment').append(tab_content);
			$('.datepicker, .input-group.date').datepicker({
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd"
                });
			
	});

	function removeItem(id){
		$("#item-payment-"+id).remove();
		$("#li-item-payment-"+id).remove();
		$("#ul-tab-payment li:first-child").addClass( "active" );
		$("#tab-content-payment div:first-child").addClass("in active");
		//alert($("#ul-tab-payment li:first-child").attr('id'));
	}

	$(document).on('change', 'select[id^="item_invoice_id_item_"]', function (event) {
		var row_id_nest   = $(this).attr('data-nest');
        var row_id   = $(this).attr('data-row');
        var item_id  = $(this).val();
        var data = [
                    {name:"id_form_bd_item",value:item_id}
                   ]; 
        ajax_post_form('<?=site_url("payment/GetNominalItem")?>',data)
        .done(function(response){
        	$('#wrap-item-payment-'+row_id_nest+' #item_invoice_must_paid_amount_'+row_id).val(response['amount']);
        });
    });

    function AddItemInvoice(row_id_nest){
    	row_id_item = $('#wrap-item-payment-'+row_id_nest+' .row-item-invoice').length;
    	
    	<?php
	        $item = '';
	        foreach ($post['item_bds'] as $key => $dt) {
	            
	             $item .= '<option value="'.$dt['id_form_bd_item'].'">'.$dt['name'].'</option>';
	        } 
        ?>
        var item = '<?=$item?>';
        var number = parseInt(row_id_item) + 1;
    	var html = '<div class="row row-item-invoice"  id="row-item-invoice-'+row_id_item+'">\
						<div class="form-group">\
					        <label for="payment_id_item_'+row_id_item+'" class="col-lg-2 control-label text-left">Description Item '+number+'</label>\
					        <div class="col-lg-4">\
					            <select data-row="'+row_id_item+'"  data-nest="'+row_id_nest+'" id="item_invoice_id_item_'+row_id_item+'" class="form-control" name="payment['+row_id_nest+'][item_invoice]['+row_id_item+'][id_item]">\
					            	<option value="">Pilih item</option>\
					            	'+
		                                item  
		                        +'</select>\
					        </div>\
					        <label for="payment_must_paid_amount_'+row_id_item+'" class="col-lg-2 control-label text-left">Must Paid Amount</label>\
					        <div class="col-lg-3">\
					            <input type="number" class="form-control" id="item_invoice_must_paid_amount_'+row_id_item+'" disabled="disabled" />\
					        </div>\
					        <div class="col-lg-1">\
					        	<a class="btn btn-danger" onclick="removeItemInvoice(\''+row_id_nest+'\',\''+row_id_item+'\');">x</a>\
					        </div>\
					    </div>\
					</div>';
		$('#wrap-item-payment-'+row_id_nest).append(html);
    }
    function removeItemInvoice(row_id_nest,row_id){
    	$('#wrap-item-payment-'+row_id_nest+' #row-item-invoice-'+row_id).remove();
    }
    function AddItemPaymentInvoice(row_id_nest){
    	row_id_item = $('#wrap-part-payment-'+row_id_nest+' .row-payment-invoice').length;
    	var date = '<?php echo date('Y-m-d'); ?>';
    	var number = parseInt(row_id_item) + 1; 
    	var html = '<div class="row row-payment-invoice" id="row-payment-invoice-'+row_id_item+'">\
    					<h3>Payment '+number+'</h3>\
            			<div class="col-lg-5">\
            				<div class="form-group">\
                				<label>Curs Finance</label>\
                				<input type="number" step="any" class="form-control" id="payment_invoice_curs_finance_'+row_id_item+'" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][curs_finance]" value="1" />\
                				<span>*fill with 1 if spanding amount is IDR</span>\
                			</div>\
                			<div class="form-group">\
                				<label>Real Amount</label>\
                				<input disabled="disable" type="number" step="any" class="form-control" id="payment_invoice_real_amount_'+row_id_item+'"  value="" />\
                			</div>\
                			<div class="form-group">\
                				<label>Payment By </label><br>\
                				<label class="radio-inline">\
								  <input type="radio" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="1"> Transfer\
								</label>\
								<label class="radio-inline">\
								  <input type="radio" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="2"> Cheque/Giro\
								</label>\
								<label class="radio-inline">\
								  <input type="radio" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][payment_by]" id="payment_invoice_payment_by_'+row_id_item+'" value="3"> Cash\
								</label>\
								<input  type="text" placeholder="No. Attribute" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][attr_payment]" class="form-control" id="payment_invoice_attr_payment_'+row_id_item+'"  value="" />\
                			</div>\
                		</div>\
            			<div class="col-lg-4 col-lg-offset-1">\
            				<div class="form-group">\
                				<label>Paid Amount</label>\
                				<input type="number" data-row="'+row_id_item+'" data-nest="'+row_id_nest+'" step="any" class="form-control" id="payment_invoice_spending_amount_'+row_id_item+'" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][spending_amount]" value="" />\
                			</div>\
                			<div class="form-group">\
                				<label>Date Of Paid Finance</label>\
                				<div class="input-group date">\
					                <input type="text" class="form-control" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][date_of_paid]" id="payment_invoice_date_of_paid_'+row_id_item+'" value="'+date+'" readonly="readonly">\
					                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>\
					            </div>\
                			</div>\
                			<div class="form-group">\
                				<label>Type</label>\
                				<div class="input-group">\
                					<input type="checkbox" id="payment_invoice_type_'+row_id_item+'" name="payment['+row_id_nest+'][item_payment]['+row_id_item+'][type]" value="2"> For PPn \
					            </div>\
                			</div>\
            			</div>\
            			<div class="col-lg-1">\
            				<a class="btn btn-danger" onclick="removeItemInvoicePayment(\''+row_id_nest+'\',\''+row_id_item+'\');">x</a>\
            			</div>\
            		</div><hr>	';
            	$('#wrap-part-payment-'+row_id_nest).append(html);
            	$('.datepicker, .input-group.date').datepicker({
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd"
                });
    }

    function removeItemInvoicePayment(row_id_nest,row_id){
    	$('#wrap-part-payment-'+row_id_nest+' #row-payment-invoice-'+row_id).remove();
    }
    $(document).on('keyup','input:text[id^="payment_invoice_number_"]',function (){
    	var row = $(this).attr('data-row');
    	$('#label_invoice_number_'+row).show();
        var data = [
                    {name:"keyword",value:$(this).val()},
                    {name:"field",value:"invoice_number"}
                   ];        
        
            ajax_post_form('<?=site_url("payment/CheckInvoiceTax")?>',data)
            
            .always(function() {
              if($('#payment_invoice_number_'+row).hasClass('border_red')==false){
                    $('#payment_invoice_number_'+row).addClass('border_red');
                }
            })
            .done(function(response) {
                if(response['error']==1){
                   if($('#payment_invoice_number_'+row).hasClass('border_red')==false){
                        $('#payment_invoice_number_'+row).addClass('border_red');
                    }else if($('#payment_invoice_number_'+row).hasClass('border_green')==true){
                        $('#payment_invoice_number_'+row).removeClass('border_green');
                        $('#payment_invoice_number_'+row).addClass('border_red');
                    }
                }else{
                    if($('#payment_invoice_number_'+row).hasClass('border_green')==false){
                        //alert('belom ada');
                        $('#payment_invoice_number_'+row).addClass('border_green');
                    }else if($('#payment_invoice_number_'+row).hasClass('border_red')==true){
                        $('#payment_invoice_number_'+row).removeClass('border_red');
                        $('#payment_invoice_number_'+row).addClass('border_green');
                    }
                }
                $('#label_invoice_number_'+row).hide();
            });
    });
	$(document).on('keyup','input[id^="payment_invoice_spending_amount_"]',function (){
		var row = $(this).attr('data-row');
		var row_nest = $(this).attr('data-nest');
		var spending_amount = $(this).val();
		var curs_finance = $('#wrap-part-payment-'+row_nest+' #payment_invoice_curs_finance_'+row).val();
		var real_amount = parseFloat(curs_finance) * parseFloat(spending_amount);

		$('#wrap-part-payment-'+row_nest+' #payment_invoice_real_amount_'+row).val(real_amount);
	});
</script>