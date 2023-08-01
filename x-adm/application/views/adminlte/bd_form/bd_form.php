<script src="<?=GLOBAL_JS_URL?>mygrid.js"></script>
<style type="text/css">
.mB20p{
    margin-bottom: 20px;
}
</style>
<section class="well animated fadeInUp">
    <div class="row">
        <div class="col-md-12">
            <div class='text-right'>
                <a class="btn btn-primary" href="<?= $add_url ?>"><i class="icon-plus-sign"></i> Add New</a>
            </div>
        </div>
    </div>  
    <hr>
    <div id='list_data'>
        <div class="form-inline mB20p">
            <div class="form-group">
                <button type="button" class="btn reload" title='Reload Data'><i class="fa fa-refresh"></i></button>
            </div>
            <div class="form-group">
                <select class='form-control input-sm perpage' style='margin-bottom:0;width:125px;'>
                    <optgroup label='Show per page'>
                        <option value='5'>5</option>
                        <option value='10'>10</option>
                        <option value='50'>50</option>
                        <option value='100'>100</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <div class="input-group date mW300" id="datePublish">
                    <input type="text"   value="<?=date('Y-m-d')?>" name="publish_date"  data-date-format="YYYY-MM-DD" class="form-control date-created-start" >
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group date mW300" id="datePublishEnd">
                    <input type="text"   value="<?=date('Y-m-d')?>" name="publish_dates"  data-date-format="YYYY-MM-DD" class="form-control date-created-end" >
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="btn search_date" title='Reload Data'><i class="fa fa-search"></i></button>
            </div>
       </div>
        
        
        <!-- start listing data -->
        <table class="table table-striped table-bordered table-hover">
            <thead> 
                <tr>
                    <th class="center" style='width:1px;'>No</th>
                    <th class="center" style="width:20%;" title="Sort" id="bd_number">No. BD Form <span></span></th>
                    <!-- <th class="center" style="width:20%;" title="Sort" id="vendor">Vendor <span></span></th>
                    <th class="center" style="width:10%;" title="Sort" id="npwp">NPWP <span></span></th> -->
                    <th class="center" style="width:10%;" title="Sort" id="request_date">Request Date <span></span></th>
                    <th class="center" style="width:10%;" title="Sort" id="due_date">Due Date <span></span></th>
                    <th class="center" style="width:20%;">Amount <span></span></th>
                    <th class="center" style="width:10%;" title="Sort" id="type">Type <span></span></th>
                    <th class="center" style="width:10%;" title="Sort" id="status">Status <span></span></th>
                    <th class="center">Action</th> 
                <tr>
                    <th></th>
                    <th class="center"><input type="text" placeholder="Search" class="cari form-control" id="search_bd_number" style="width:100%;"></th>
                    <!-- <th class="center"><input type="text" placeholder="Search" class="cari form-control" id="search_vendor" style="width:100%;"></th>
                    <th class="center"><input type="text" placeholder="Search" class="cari form-control" id="search_npwp" style="width:100%;"></th>
                     -->
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th class="center"><!-- <input type="text" placeholder="Search" class="cari form-control" id="search_amount" style="width:100%;"> --></th>
                    <th class="center"><input type="text" placeholder="Search" class="cari form-control" id="search_type" style="width:100%;"></th>
                    <th class="center"><input type="text" placeholder="Search" class="cari form-control" id="search_status" style="width:100%;"></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        </form>
        <!-- end of listing data -->
        <hr/>
        <div class="row">
            <div class="col-md-12 text-right">
                <a class="btn btn-primary" href="<?= $add_url ?>"><i class="icon-plus-sign"></i> Add New</a>
            </div>
        </div>
    </div>
</section>
<?php /**?>
<!-- <table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="main_tax">BD Number</th>
            <th data-name="name">Vendor Name</th>
            <th data-name="description">Tax Invoice No.</th>
            <th data-name="value">Invoice No</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
    </div>
</div> -->
<?php **/?>
<br/><br/>
<script type="text/javascript">
    the_grid('list_data', '<?= $url_data ?>',1, 10,<?=$page?>,'id_form_bd');
    // list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
