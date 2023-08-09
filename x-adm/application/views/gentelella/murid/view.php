<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Detail Siswa/Siswi</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-md-6"> 
        <a href="<?=$back_url?>" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <a href="<?=$edit_url?>" class="btn btn-success"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                <a href="<?=$izin_url?>" class="btn btn-success"><i class="fa fa-sign-out"></i>&nbsp;Izin</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 ">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_murid">Nama Murid</label>
                                    <input type="text" class="form-control" id="nama_murid" value="<?= (isset($post['nama_murid'])) ? html_entity_decode($post['nama_murid']) : '' ?>" readonly />
                                </div>
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" value="<?= (isset($post['nis'])) ? html_entity_decode($post['nis']) : '' ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                </div>
            </div><!-- End of x_content -->
        </div>
    </div>

    <div class="col-md-6 col-sm-12 ">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- BEGIN extra option -->
                        <div class="form-group">
                            <label for="nama_kelas">Kelas</label>
                            <input type="text" class="form-control" value="<?= (isset($post['nama_kelas'])) ? html_entity_decode($post['nama_kelas']) : '' ?>" readonly />
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun Ajaran</label>
                            <input type="text" class="form-control" value="<?= (isset($post['tahun'])) ? html_entity_decode($post['tahun']) : '' ?>" readonly />
                        </div>
                        
                        <div class="form-group">
                            <label for="id_status">Status Pelajar : <?= (isset($post['id_status']) && !empty($post['id_status'])) ? 'Aktif' : 'Tidak Aktif' ?></label>
                        </div>
                        <!-- END of extra option -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.display_search_engine{
    display: block;
    width: 100%;
}
.display_search_engine h3{
    color: #1a0dab;
    margin-bottom: 1px;
    margin-top: 5px;
}
.display_search_engine .meta_link{
    display: block;
    color: #006621;
    font-style: normal;
}
.display_search_engine .meta_description{
    display: block;
}
.analisis_seo{

}
.analisis_seo h3{
    color: #1a0dab;
}
.analisis_seo .box{
    padding: 5px;
    margin-bottom: 5px;
    border: 1px #B2BFB2 solid;
}
.analisis_seo .meta_keyword{

}
.meta_keyword .title{

}
.meta_keyword .title span,.meta_title .title span,.meta_description .title span{
    color: #0FC149;
    font-weight: 900;
}
.meta_keyword .details{

}
.analisis_seo .meta_title{

}

.analisis_seo .meta_description{

}
.review_seo{

}
</style>
<!-- Modal -->
<div class="modal fade" id="ModalCekSEO" tabindex="-1" role="dialog" aria-labelledby="ModalCekSEOLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalCekSEOLabel">SEO Check</h4>
      </div>
      <div class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
