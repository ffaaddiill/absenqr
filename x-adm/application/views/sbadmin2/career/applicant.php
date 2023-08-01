
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="name">Name</th>
            <th data-name="email">Email</th>
            <th data-name="resume" data-searchable="false" data-orderable="false">Resume</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
        </tr>
    </thead>
</table>

<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
