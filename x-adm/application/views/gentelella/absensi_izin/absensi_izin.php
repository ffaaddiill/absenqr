<div class="page-title"> 
    <div class="title_left">
        <h3><?=$page_title?></h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>List data</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="dataTables-list" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center" width="10px"><span class="glyphicon glyphicon-cog"></span></th>
                                        <th data-name="nama_murid" data-searchable="true">Nama</th>
                                        <th data-name="nis" data-searchable="true">Nomor Induk</th>
                                        <th data-name="kategori_izin" data-searchable="true">Kategori</th>
                                        <th data-name="nama_kelas" data-searchable="true">Kelas</th>
                                        <th data-name="created_date" data-searchable="false">Created Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- End of x_content -->
        </div>
    </div>
</div>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>'/*,btn_property*/);
</script>