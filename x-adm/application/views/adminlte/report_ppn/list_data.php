<?php 
$page = $_GET['page'];
foreach ($data as $dt) {
$idx= $dt['bd_number']; 
?>
    <tr id='row<?= $dt['bd_number'] ?>'>
        <td class="center"><?= ( ++$_GET['page']) ?></td>
        <td><?= $dt['no_doc_tax'] ?></td>
        <td><?= $dt['document_tax_date'] ?></td>
        <td><?= $dt['name'] ?></td>
        <td><?= $dt['dpp'] ?></td>
        <td><?= $dt['jumlah_ppn'] ?></td>
        
        
       
    </tr>
<?php } ?>
<tr class="footer">
    <td colspan="6"><?= $paging ?></td>
</tr>
