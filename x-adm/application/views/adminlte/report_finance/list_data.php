<?php 
$page = $_GET['page'];
foreach ($data as $dt) {
$idx= $dt['no_form_bd']; 
?>
    <tr id='row<?= $dt['no_form_bd'] ?>'>
        <td class="center"><?= ( ++$_GET['page']) ?></td>
        <td><?= $dt['no_bd'] ?></td>
        <td><?= $dt['bd_date'] ?></td>
        <td><?= $dt['bd_paid_number'] ?></td>
        <td><?= $dt['date_of_paid'] ?></td>
        <td><?= number_format($dt['dpp'],2,',','.') ?></td>
        <td>Rp. <?= number_format($dt['VAT'],2,',','.') ?></td>
        <td><?= number_format($dt['spending_amount'],2,',','.')?></td>
        
        
       
    </tr>
<?php } ?>
<tr class="footer">
    <td colspan="8"><?= $paging ?></td>
</tr>
