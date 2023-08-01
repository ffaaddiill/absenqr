<table id="adminDataTables" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
          <th>Rendering engine</th>
          <th>Browser</th>
          <th>Platform(s)</th>
          <th>Engine version</th>
          <th>CSS grade</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td>Other browsers</td>
          <td>All others</td>
          <td>-</td>
          <td>-</td>
          <td>U</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
          <th>Rendering engine</th>
          <th>Browser</th>
          <th>Platform(s)</th>
          <th>Engine version</th>
          <th>CSS grade</th>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
  alert(list_dataTables('#adminDataTables','<?= $url_data ?>'));
</script>
