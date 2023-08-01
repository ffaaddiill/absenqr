<a title='Export to Excel' href="<?= $export_excel_url; ?>" class="btn btn-success" target="_blank">Export To Excel</a><br/><br/>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="name">Name</th>
            <th data-name="no_customer">Customer ID</th>
            <th data-name="phone">Phone</th>
            <th data-name="email">Email</th>
            <th data-name="saya_ingin">Request</th>
            <th data-name="created_at" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
