<?php 
$page = $_GET['page'];
foreach ($data as $dt) {
$idx= $dt['id_form_bd_item']; 
?>
    <tr id='row<?= $dt['id_form_bd'] ?>'>
        <td class="center"><?= ( ++$_GET['page']) ?></td>
        <td><?= $dt['bd_number'] ?></td>
        
        <td><?= $dt['vendor_name'] ?></td>
        <td><?= $dt['percent_merge'] ?></td>
        <td><?= $dt['original_amount'] ?></td>
        <td><?= $dt['idr_amount'] ?></td>
        <td><?= $dt['wht_code'] ?></td>
        <td class="center">
            <a title="Edit Record" href="<?=site_url('bd_form/edit/'.$idx)?>" class="fa fa-seacrh tangan  icon-large editAccess"></a>
        </td>
       
    </tr>
<?php } ?>
<tr class="footer">
    <td colspan="8"><?= $paging ?></td>
</tr>
