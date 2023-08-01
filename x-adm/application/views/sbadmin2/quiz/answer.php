<a title='Export to Excel' href="<?= $export_excel_url; ?>" class="btn btn-success" target="_blank">Export To Excel</a><br/><br/>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="id_pelanggan">Customer ID</th>
            <th data-name="name">Name</th>
            <th data-name="email">Email</th>
            <th data-searchable="false" data-name="socmed">Social Media</th>
            <th data-name="no_hp">Phone</th>
            <th data-name="alamat">Address</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
            <th data-name="answer" data-searchable="false" data-orderable="false">Answer</th>
        </tr>
    </thead>
</table>


<br/><br/>
<script type="text/javascript">
    function excel(){
        $('#export_excel').submit();
    }
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
