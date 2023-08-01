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
        $total_all_item       = $total_amount-$total_pph_amounts;//$post['total_amount'];
        $total_amount_bd      = $post['total_amount'];
        // echo $total_all_item;
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
              <td class="text-right"><?= $item['iso_2'] ?> <?= number_format($advance_amount,2,",","."); ?> </td>
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