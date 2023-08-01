
<?php 
$id_item        = 'id_form_'.$type.'_item';
$id_item_pph    = 'id_form_'.$type.'_item_pph';
foreach ($item_pph as $key => $pph_item) : ?>
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
                      <label for="item_pph_ramount0">Real Amount (<?=$pph_item['iso_2']?>)</label><br>
                      <?=$pph_item['real_amount']?>
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group no-margin">
                      <label for="item_pph_famount0">Final Amount (<?=$pph_item['iso_2']?>)</label><br>
                      <?=$pph_item['real_amount'] - ($pph_item['real_amount'] * $pph_item['percentage']/100) ?>
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group no-margin">
                    <a data-id="<?=$pph_item[$id_item_pph]?>" data-id-item="<?=$pph_item[$id_item]?>" class="delete_item_pph btn btn-danger"><i class="fa fa-trash"></i></a>
                    <a data-row="<?=$row?>" data-id-item="<?=$pph_item[$id_item]?>" data-id="<?=$pph_item[$id_item_pph]?>" class="edit_item_pph btn btn-info"><i class="fa fa-pencil"></i></a>
                      <!-- <label style="display:block;">&nbsp;</label> -->
                      <!-- <button type="button" class="btn btn-danger" onclick="removeItemPPH('0');">-</button> -->
                  </div>
              </div>
      </div>
<?php endforeach; ?>