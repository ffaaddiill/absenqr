
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="name">Channel Name</th>
            <th data-name="is_hd" data-searchable="false">Status</th>
           <!--  <th data-name="channel_number" data-searchable="false" data-orderable="false">Channel Number</th> -->
            <th data-name="create_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=site_url('channel/group')?>" class="btn btn-primary">List Channel Group</a>
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger" id="delete-record">Delete</button>

    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>