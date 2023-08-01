<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="nama">Nama</th>
            <th data-name="email">Email</th>
            <th data-name="alamat">Alamat</th>
            <th data-name="telepon">Telepon</th>
            <th data-name="pesan">Pesan</th>
            <th data-name="created" data-searchable="false">Created Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
