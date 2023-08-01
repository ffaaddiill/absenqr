<?php 
$page = $_GET['page'];
foreach ($data as $dt) {
$idx= $dt['id_form_bd']; 
?>
    <tr id='row<?= $dt['id_form_bd'] ?>'>
        <td class="center"><?= ( ++$_GET['page']) ?></td>
        <td><?= $dt['bd_number'] ?></td>
        
        <!-- <td><?= $dt['vendor'] ?></td>
        <td><?= $dt['npwp'] ?></td> -->
        <td class="center"><?= date('Y-m-d',strtotime($dt['request_date'])) ?></td>
        <td class="center"><?= (isset($dt['due_date']) && $dt['due_date'] != '0000-00-00 00:00:00') ? date('Y-m-d',strtotime($dt['due_date'])) : '' ?></td>
        <td><?= $dt['total_amount'] ?><?=(isset($dt['total_ppn']) && $dt['total_ppn'] != 0)  ? '
                                            <br>( <span style="font-size: 12px;color: green;font-weight: 600;">PPn : Rp. '.number_format($dt['total_ppn'],2,",",".").'</span> )' : '' ?></td>
        <td><?= $dt['type'] ?></td>
        <td><?= $dt['status'] ?></td>
        <td class="center">
            <a title="Edit Record" href="<?=site_url('bd_form/edit/'.$idx)?>" class="fa fa-pencil tangan  icon-large editAccess"></a>
            <a title="Do Payment" href="<?=site_url('payment/view/'.$dt['bd_number'])?>" class="fa fa-money tangan  icon-large editAccess"></a>
            <?php if($dt['payment_type']==2): ?>
            <a title="Input SOA" href="<?=site_url('bd_form/SOA/'.$idx)?>" class="fa fa-newspaper-o tangan  icon-large editAccess"></a>
            <?php endif; ?>
            <a title="Delete Record" class="fa fa-trash tangan hapus icon-large delAccess"  data-url-rm="delete" data-id="<?=$dt['id_form_bd']?>"></a>
        </td>
       
    </tr>
<?php } ?>
<tr class="footer">
    <td colspan="8"><?= $paging ?></td>
</tr>
