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
                SOA Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'class="form" role="form" enctype="multipart/form-data"'); ?>
                <div role="tabpanel" id="tabster">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#basic_info" aria-controls="basic_info" role="tab" data-toggle="tab">SOA Info</a></li>
                    <?php if (isset($post['id_form_soa'])) :?>
                        <li role="presentation"><a href="#pph" aria-controls="pph" role="tab" data-toggle="tab">PPH</a></li>
                    <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="basic_info">
                            <div class="row">
                                <div class="col-lg-12">

                                    <label for="soa_number"  class="col-lg-2 control-label text-left">SOA Number. <i id ="label_soa_number" style="display:none;" class="fa fa-refresh fa-spin"></i></label>
                                    <div class="col-lg-4">
                                        <?php
                                        if($post){

                                        ?>
                                        <input value="<?= (isset($post['id_form_soa'])) ? $post['id_form_soa'] : '0' ?>" type="hidden" class="form-control" name="id_form_soa" id="id_form_soa" placeholder="SOA Number">                                        
                                        <?php
                                        }
                                        ?>
                                        <input value="<?= (isset($post['soa_number'])) ? $post['soa_number'] : '' ?>" type="text" class="form-control" name="soa_number" id="soa_number" placeholder="SOA Number">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <?php if (empty($post['id_form_soa'])) :?>
                                <div class="row group-form-field">
                                    <?php if (isset($post['item_soa'])) { ?>
                                        <?php foreach ($post['item_soa'] as $row => $item_soa) :?>
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
                                                        <label for="item_<?= $row ?>" '+not_show+'>Item</label> <span class="row_num"><?=$row+1?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group description-item no-margin">
                                                        <label for="item_soa_desc<?= $row ?>" <?= $not_show ?>>Description</label>
                                                        <textarea class="form-control promo_type" id="item_desc_<?= $row ?>" name="item_soa[<?= $row ?>][name]" data-row="<?= $row ?>"><?=(isset($item_soa['name'])) ? $item_soa['name'] : ''?></textarea>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_soa_ramount<?= $row ?>" <?= $not_show ?>>Real Amount</label>
                                                        <input type="text" class="number_format form-control" name="item_soa[<?= $row ?>][real_amount]" id="item_real_amount_<?= $row ?>" placeholder="Real" value="<?=(isset($item_soa['real_amount'])) ? $item_soa['real_amount'] : ''?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group no-margin">
                                                        <label for="item_soa_currency<?= $row ?>" <?= $not_show ?>>Currency</label>
                                                        <select class="form-control promo_type" id="item_currency_<?= $row ?>" name="item_soa[<?= $row ?>][id_currency]" data-row="<?= $row ?>">
                                                            <option <?=(isset($item_soa['id_currency']) && $item_soa['id_currency'] == 1) ? 'selected="selected"' : ''?> value="1">IDR</option>
                                                            <option <?=(isset($item_soa['id_currency']) && $item_soa['id_currency'] == 2) ? 'selected="selected"' : ''?> value="2">USD</option>
                                                        </select>
                                                    </div>
                                                   
                                                    
                                                </div>
                                                <div class="col-lg-2">
                                                    <div id="wrap_curs_ppn_<?= $row ?>" style="display: block;" class="form-group no-margin">
                                                        <label for="item_curs_ppn<?= $row ?>" style="display:block;">Curs PPn</label>
                                                        <input type="number" class="form-control" name="item_soa[<?= $row ?>][curs_ppn]" id="item_curs_ppn_<?= $row ?>" placeholder="Curs PPn" value="<?=(isset($item_soa['curs_ppn'])) ? $item_soa['curs_ppn'] : ''?>"> 
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label for="item_soa_ppn<?= $row ?>" <?= $not_show ?>>PPN</label><br>
                                                        <input type="checkbox" data-row="<?= $row ?>" id="item_ppn_<?= $row ?>" name="item_soa[<?= $row ?>][id_status_pajak]" <?=(isset($item_soa['id_status_pajak']) && $item_soa['id_status_pajak'] == 1) ? 'checked' : ''?> value="1"> Y 
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
                            <?php else : ?>
                            <div id="detail_payment" class="soa_form">
                                    <?php
                                if($post['item_soas']){    
                                    ?>
                                    <table class="table">
                                      <tr>
                                        <th>Description</th>
                                        <th>Real Amount</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                      </tr>
                                      <tr>

                                        <td ><b>Bd Number : <?=$post['bd_number']?></b></td>
                                        <td><b><?=number_format($post['total_amount'],2,",",".");?></b></td>
                                        <td><b>IDR</b></td>
                                        <td class="text-right"><b>Rp. <?=number_format($post['total_amount'] ,2,",",".");?></b></td>
                                      </tr>
                                      <?php
                                      $total_amount = 0;
                                      $total_ppn = 0;
                                      $total_pph_amounts = 0;
                                      $USD = 0;
                                        foreach ($post['item_soas'] as $row => $item) :

                                      ?>
                                      
                                      <tr class="wrap-action">

                                        <td ><?=$item['name']?>
                                            <span class="action">
                                                <a data-id="<?=$item['id_form_soa_item']?>" class="edit_item_bd btn btn-info"><i class="fa fa-pencil"></i></a>
                                                <a data-id="<?=$item['id_form_soa_item']?>" class="delete_item_bd btn btn-danger"><i class="fa fa-trash"></i></a>
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
                                                <td><?=$item['iso_1']?></td>
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
                                      <?php
                                      $total_all_item       = $total_amount-$total_pph_amounts;//+$post['spending_amount_soa'];
                                      $total_amount_bd      = $post['total_amount'];
                                     # echo '<h2>'.$total_pph_amounts.'</h2>';
                                      // echo $total_amount_bd;
                                      // die();

                                      if($total_amount_bd < $total_all_item){
                                        $status_advance = 'Under';
                                        $advance_amount = $total_all_item - $total_amount_bd;
                                      }elseif($total_amount_bd > $total_all_item){
                                        $status_advance = 'Over';
                                        $advance_amount = $total_amount_bd - $total_all_item;
                                      }else{
                                        $status_advance = 'Balance';
                                        $advance_amount = $total_amount_bd - $total_all_item;
                                      }
                                      if($post['spending_amount_soa']){
                                        if($advance_amount==$post['spending_amount_soa']){
                                            $status_advance = 'Balance';
                                            $advance_amount = 0;
                                        }
                                      }
                                      ?>
                                      <tr>
                                            <td>
                                                Advance ( <b><?=$status_advance?></b> ) : 
                                                <?php if($status_advance!='Balance') { ?>
                                                <span class="action_soa"><a class="btn btn-success">AP</a></span>
                                                <?php } ?>
                                            </td>
                                            <td colspan="2"></td>
                                            <td class="text-right" id="amount_soa"><?= $item['iso_2'] ?> <?= number_format($advance_amount,2,",","."); ?> </td>
                                      </tr>

                                      <tr>
                                            <td>Verified By Tax Dept :</td>
                                            <td colspan="2">Tax Due</td>
                                            <td class="text-right"><?= $item['iso_2'] ?> <?= number_format($total_pph_amounts,2,",","."); ?></td>
                                      </tr>

                                      <tr>
                                            <td></td>
                                            <td colspan="2" class="total_paid">Total Paid</td>
                                            <td class="text-right amount_total_paid" ><?= $item['iso_2'] ?> 
                                              <?= ($USD >= 1) ? number_format($total_amount-$total_pph_amounts,2,",",".").' + (Rp. '.number_format($total_ppn,2,",",".").' )' :   number_format($total_amount-$total_pph_amounts,2,",",".") ?>
                                            </td>
                                      </tr>
                                      <?php 
                                      if($status_advance == 'Balance'){
                                      ?>
                                          <tr>
                                            <td colspan="4">
                                                <h2 class="text-center">ACCOUNTING VERIFICATION</h2>
                                            </td>
                                          </tr>
                                          <tr class="accounting_verif">
                                                <td>Account Name</td>
                                                <td>Debit</td>
                                                <td>Credit</td>
                                                <td></td>
                                          </tr>
                                          <tr class="accounting_verif">
                                                <td>
                                                   Advance 
                                                </td>
                                                
                                                <td class="text-left"><?= $item['iso_2'] ?> <?= number_format($post['total_amount'],2,",","."); ?> </td>
                                                <td></td>
                                                <td></td>
                                          </tr class="accounting_verif">
                                          <tr class="accounting_verif">
                                                <td >
                                                   Bank 
                                                </td>
                                                <td></td>
                                                <td class="text-left"><?= $item['iso_2'] ?> <?= number_format($post['spending_amount_soa'],2,",","."); ?> </td>
                                                <td></td>
                                          </tr>
                                      <?php
                                        } 
                                      ?>
                                    </table>
                                    <?php
                                }
                                    ?>
                                </div>
                            <div class="row group-form-field">
                                <?php if (isset($post['item_soa'])) { ?>
                                    <?php foreach ($post['item_soa'] as $row => $item_soa) :?>
                                        <?php  
                                        if($row == 0) {
                                            $not_show = 'style="display:block;"';
                                        }else{
                                            $not_show = 'style="display:none;"';
                                        }

                                        ?>
                                        <div class="row-item row" id="row-item-<?=$row?>">
                                            <div class="col-lg-1">
                                                <div class="form-group no-margin"> 
                                                    <label for="rule_<?=$row?>">Item</label> <span class="row_num">1</span> 
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group no-margin"> 
                                                    <label for="item_soa_desc<?=$row?>">Description</label> 
                                                    <textarea class="form-control promo_type" id="item_desc_<?=$row?>" name="item_soa[<?=$row?>][name]" data-row="<?=$row?>"><?=(isset($item_soa['name'])) ? $item_soa['name'] : ''?></textarea> 
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group no-margin"> 
                                                    <label for="item_soa_ramount<?=$row?>">Real Amount</label> 
                                                    <input data-row="<?=$row?>" type="text" class="form-control number_format" name="item_soa[<?=$row?>][real_amount]" value="<?=(isset($item_soa['real_amount'])) ? $item_soa['real_amount'] : ''?>" id="item_real_amount_<?=$row?>" placeholder="Real"> 
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group no-margin">
                                                    <label for="item_soa_currency<?=$row?>">Currency</label> 
                                                    <select class="form-control promo_type" id="item_currency_<?=$row?>" name="item_soa[<?=$row?>][id_currency]" data-row="<?=$row?>">                            
                                                        <option <?=(isset($item_soa['id_currency']) && $item_soa['id_currency'] == 1) ? 'selected="selected"' : ''?> value="1">IDR</option>
                                                        <option <?=(isset($item_soa['id_currency']) && $item_soa['id_currency'] == 2) ? 'selected="selected"' : ''?> value="2">USD</option>                        
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div id="wrap_curs_ppn_<?=$row?>" style="<?=(isset($item_soa['id_status_pajak']) && $item_soa['id_status_pajak'] == 1) ? 'display:block' : 'display:none'?>" class="form-group no-margin"> 
                                                    <label for="item_curs_ppn<?=$row?>">Curs PPn</label> 
                                                    <input type="number" class="form-control" name="item_soa[<?=$row?>][curs_ppn]" id="item_curs_ppn_<?=$row?>" value="<?=(isset($item_soa['curs_ppn'])) ? $item_soa['curs_ppn'] : ''?>" placeholder="Curs PPn"> 
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group"> 
                                                    <label for="item_soa_ppn<?=$row?>">PPN</label>
                                                    <br> 
                                                    <input type="checkbox" data-row="<?=$row?>" id="item_ppn_<?=$row?>" name="item_soa[<?=$row?>][id_status_pajak]" <?=(isset($item_soa['id_status_pajak']) && $item_soa['id_status_pajak'] == 1) ? 'checked' : ''?> value="1"> Y
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group no-margin"> 
                                                    <label style="display:block;">&nbsp;</label> 
                                                    <button type="button" class="btn btn-danger" onclick="removeItem('<?=$row?>');">-</button> 
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </div>
                            <?php endif ;  ?>
                            <div class="row group-form-button">
                                <div class="text-left">
                                    <button type="button" class="btn btn-success" onclick="addItemSOA();">+ Add Item</button>
                                </div>
                            </div>

                        </div>
                        <?php if (isset($post['id_form_soa'])) :?>
                        <div role="tabpanel" class="form tab-pane fade" id="pph">
                            <?php
                            $total_amount = 0;
                            foreach ($post['item_soas'] as $row => $item_pph) :
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
                                                        <a data-row="<?=$row?>" data-id="<?=$pph_item['id_form_soa_item_pph']?>" data-id-item="<?=$pph_item['id_form_soa_item']?>" class="delete_item_pph btn btn-danger"><i class="fa fa-trash"></i></a>
                                                        <a data-row="<?=$row?>" data-id-item="<?=$pph_item['id_form_soa_item']?>" data-id="<?=$pph_item['id_form_soa_item_pph']?>" class="edit_item_pph btn btn-info"><i class="fa fa-pencil"></i></a>
                                                          <!-- <label style="display:block;">&nbsp;</label> -->
                                                          <!-- <button type="button" class="btn btn-danger" onclick="removeItemPPH('0');">-</button> -->
                                                      </div>
                                                  </div>
                                          </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="panel-footer">
                                    <a  onclick="addItem(<?=$row?>,<?=$item_pph['real_amount']?>,<?=$item_pph['id_form_soa_item']?>);" data-row="<?=$row?>" class="btn btn-success pull-right"><i class="fa fa-plus "></i>PPh</a>
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
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
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
        <h4 class="modal-title">Edit Item SOA</h4>
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
<div id="modalPaymentSOA" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Payment SOA</h4>
      </div>
      <div class="modal-body">
        <form id="form-payment-soa"  role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-payment-soa-message"></div>
                    <input type="hidden" name="id_form_soa" value="<?=$post['id_form_soa']?>">
                    <input type="hidden" name="amount_balance" value="<?=$advance_amount?>">
                    <div class="form-group ">
                        <label for="bd_desc">Outstanding Amount</label><br>
                        <span class="outstanding_amount" style="font-size: 37px;
"> </span>
                    </div>
                    <div class="form-group ">
                        <label for="bd_ramount">Spending Amount</label>
                        <input type="text"  class="form-control number_format"  name="amount"  placeholder="Spending Amount">
                    </div>
                    <div class="form-group ">
                        <label for="bd_currency">Date Of Paid</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" name="date_of_paid" id="date_of_paid" value="<?=date('Y-m-d')?>" readonly="readonly">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (nested) -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  id="save_payment_soa" class="btn btn-primary">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $('.number_format').number(true,2,',','.');
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
    function addItemSOA(){
        var row = $(".row-item").length;
        var not_show = '';
        var label_first='';

        if (row > 0) {
            not_show = 'style="display:none;"';
            
        }
        if(row == 0){
            label_first = '<label style="display:block;">&nbsp;</label>';
        }
        
        var number = parseInt(row) + 1;
        
        html = '\
            <div class="row-item row" id="row-item-'+row+'">\
                <div class="col-lg-1">\
                    <div class="form-group no-margin">\
                        <label for="rule_'+row+'" '+not_show+'>Item</label>\
                        <span class="row_num">'+number+'</span>\
                    </div>\
                </div>\
                <div class="col-lg-3">\
                    <div class="form-group no-margin">\
                        <label for="item_soa_desc'+row+'" '+not_show+'>Description</label>\
                        <textarea class="form-control promo_type" id="item_desc_'+row+'" name="item_soa['+row+'][name]" data-row="'+row+'"></textarea>\
                    </div>\
                </div>\
                <div class="col-lg-2">\
                    <div class="form-group no-margin">\
                        <label for="item_soa_ramount'+row+'" '+not_show+'>Real Amount</label>\
                        <input data-row="'+row+'" type="text" class="form-control number_format" name="item_soa['+row+'][real_amount]" id="item_real_amount_'+row+'" placeholder="Real">\
                    </div>\
                </div>\
                <div class="col-lg-2">\
                    <div class="form-group no-margin">\
                        <label for="item_soa_currency'+row+'" '+not_show+'>Currency</label>\
                        <select class="form-control promo_type" id="item_currency_'+row+'" name="item_soa['+row+'][id_currency]" data-row="'+row+'">\
                            <option value="1">IDR</option>\
                            <option value="2">USD</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="col-lg-2">\
                    <div id="wrap_curs_ppn_'+row+'" style="display:none" class="form-group no-margin">\
                        <label for="item_curs_ppn'+row+'" '+not_show+'>Curs PPn</label>\
                        <input type="number" class="form-control" name="item_soa['+row+'][curs_ppn]" id="item_curs_ppn_'+row+'" placeholder="Curs PPn">\
                    </div>\
                </div>\
                <div class="col-lg-1">\
                    <div class="form-group">\
                        <label for="item_soa_ppn'+row+'" '+not_show+'>PPN</label><br>\
                        <input type="checkbox" data-row="'+row+'" id="item_ppn_'+row+'" name="item_soa['+row+'][id_status_pajak]" value="1"> Y \
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
 
    }
    $(document).on('change', 'input[id^="item_ppn_"]', function (event) {

        var data_row        = $(this).attr('data-row');
        $('#wrap_curs_ppn_'+data_row).toggle(this.checked);
    });
    function removeItem(id) {
        //alert(id);
        $("#row-item-"+id).remove();
    }
    function addItem(id,price,id_item,factor_curs){
        var row = $("#row-group-item-pph-"+id+" .row-item-pph").length;
        var number = parseInt(row) + 1;
        var not_show = '';
        var label_first='';
        var type='';
        var sub_type ='';
        
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
        var data = [{name:'id_form_soa_item_pph',value:id_item_pph},
                    {name:'row',value:row},
                    {name:'id_form_soa_item',value:id_item}];
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
        var data = [{name:'id_form_soa_item',value:id_item_pph},
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

    $(document).on('click','.edit_item_bd',function(){
        var id = $(this).attr('data-id');
        var self = $(this);
        var self_html = $(this).html();
        var data = [{name:'id_form_soa_item',value:id}];
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
    $('#modalEditItemBD #save_form_edit_item_bd').click(function (){
        var self = $(this);
        var self_html = $(this).html();
        var id_form_bd = "<?=$post['id_form_bd']?>";
            
         
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
                        getDetailSOA(id_form_bd);
                        $('#modalEditItemBD').modal('hide');
                        
                    }
                
                
            });
    });
    function getDetailSOA(id_form_bd){
        var data = [{name:'id_form_bd',value:id_form_bd}];
        ajax_post_form("<?=site_url('bd_form/GetDetailSOA')?>",data)
            .done(function(response) {
                    if(response['error']){
                        $('.form-edit-item-bd-message').html(response['error']);
                    }else{ 
                       
                        $('#detail_payment').html(response['html']);
                        
                    }
                
                
            });
    }

    $(document).on('click','.action_soa a',function(){
        var outstanding_amount = $('#amount_soa').text();
        $('#form-payment-soa .outstanding_amount').text(outstanding_amount);
        $('#modalPaymentSOA').modal('show');
        //console.log(outstanding_amount);
    });
    $(document).on('click','#save_payment_soa',function(){
        var self = $(this);
        var self_html = $(this).html();
        
        var id_form_bd =  "<?=isset($post['id_form_bd']) ? $post['id_form_bd'] : '' ?>";   
         
        var data =  $('#form-payment-soa').serializeArray();      
        

            ajax_post_form("<?=site_url('bd_form/payment_soa')?>",data)
            
            .always(function() {
                self.html(self_html);
                self.removeAttr('disabled');
            })
            .done(function(response) {
                    if(response['error']){
                        $('.form-payment-soa-message').html(response['error']);
                    }else{ 
                        getDetailSOA(id_form_bd);
                        $('#modalPaymentSOA').modal('hide');
                        
                    }
                
                
            });
        //console.log(outstanding_amount);
    });
    $('.datepicker, .input-group.date').datepicker({
                keyboardNavigation: false,
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd"
    });
</script>
