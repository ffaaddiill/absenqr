
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="transid">Trans ID</th>
            <th data-name="invoice">INVOIVE</th>
            <th data-name="movie_title">Movie</th>
            <th data-name="start_time">Showtime</th>
            <th data-name="customer_id">Cust ID</th>
            <th data-name="name">Name</th>
            <th data-name="email">Email</th>
            <th data-name="status" data-searchable="false">Status</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
