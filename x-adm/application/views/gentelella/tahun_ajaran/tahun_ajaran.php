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
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>List data</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
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
                                        <th data-name="tahun">Tahun Ajaran</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="pl15 mt15">
                            <a href="<?=$add_url?>" class="btn btn-success">Add</a>
                            <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
                        </div>
                    </div>
                </div>
            </div><!-- End of x_content -->
        </div>
    </div>
</div>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>