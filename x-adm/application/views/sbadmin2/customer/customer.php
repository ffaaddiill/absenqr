<a title='Export to Excel' href="<?= $export_excel_url; ?>" class="btn btn-success" target="_blank">Export To Excel</a><br/><br/>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="first_name">Name</th>
            <th data-name="kode_pemasangan">Kode Pemasangan</th>
            <th data-name="email">Email</th>
            <th data-name="no_phone">Phone</th>
            <th data-name="no_hp">Mobile</th>
            <th data-name="gender">Gender</th>
            <th data-name="step">Last Step</th>
            <th data-name="created_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>