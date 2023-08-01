<tr>
  <th>Description</th>
  <th>Real Amount</th>
  <th>Currency</th>
  <th>Amount</th>
</tr>
<?php

//echo $curs_today;
$total_amount = 0;
$total_pph_amounts = 0;
  foreach ($item_bds as $row => $item) :
    $curs_today = get_current_curs($item['id_currency']);
  
?>
<tr>
  <td><?=$item['name']?> <span class="action"><a data-id="<?=$item['id_form_bd_item']?>" class="edit-item fa fa-pencil"></a><a style="color:red;" data-id="<?=$item['id_form_bd_item']?>" class="delete-item fa fa-trash"></a></span></td>
  <td><?=number_format($item['real_amount'],2,",",".");?></td>
  <td><?=$item['iso_1'] ?></td>
  <td class="text-right">Rp. <?=number_format($item['real_amount'] * $curs_today,2,",",".");?></td>
</tr>

      <?php if($item['id_status_pajak']==1){ 
               $amount_ppn = 0.1 * $item['real_amount'] * $curs_today;
               #$total_amount = $amount_ppn + $item['real_amount'];
      ?>

      <tr class="ppn">
          <td class="text-right">PPN 10%</td>
          <td></td>
          <td><?=$item['iso_1']?></td>
          <td class="text-right"><?=number_format($amount_ppn,2,",",".");?></td>
      </tr>
      <?php
      $total_amount = $total_amount + ($item['real_amount'] * $curs_today) + $amount_ppn; 
      }else{ ?>
<?php
      $total_amount = $total_amount + ($item['real_amount'] * $curs_today);
      }

      if($item['pph_item']){
          $total_pph_amount = 0;
          foreach ($item['pph_item'] as $key => $pph) {
              $pph_amount = ($item['real_amount'] * $curs_today * ($pph['percentage']/100));
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
      <td class="text-right">Rp. <?=number_format($total_amount,2,",",".");?></td>
</tr>
<tr>
      <td>Verified By Tax Dept :</td>
      <td colspan="2">Tax Due</td>
      <td class="text-right"><?= number_format($total_pph_amounts,2,",","."); ?></td>
</tr>
<tr>
      <td></td>
      <td colspan="2">Total Paid</td>
      <td class="text-right">Rp. <?=number_format($total_amount-$total_pph_amounts,2,",",".");?></td>
</tr>