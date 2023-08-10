<!doctype html>
<html lang="en" data-bs-theme="auto">
    <head>
        <script src="<?=JS_URL?>color-modes.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.115.4">
        <title>QR-Code Scanner</title>
        <script type="text/javascript">
            var token_name = '<?=$this->security->get_csrf_token_name()?>';
            var token_key = '<?=$this->security->get_csrf_hash()?>';
        </script>
        <script type="text/javascript" src="<?=JS_URL?>jquery.min.js"></script>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/offcanvas-navbar/">
        <link rel="stylesheet" href="<?=CSS_URL?>docsearch_css3.css">
        <link href="<?=ASSETS_URL?>bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=ASSETS_URL?>bootstrap-icons/font/bootstrap-icons.min.css">
        
        <!-- Custom styles for this template -->
        <link href="<?=CSS_URL?>offcanvas-navbar.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=CSS_URL?>style.css">
    </head>
    <body class="bg-body-tertiary">
        <main class="container">
            <div class="d-flex align-items-center p-3 my-3 text-white bg-greendosqi rounded shadow-sm">
                <img class="me-3" src="<?=IMG_URL?>logo-smasmuh11.png" alt="" width="100" height="auto">
                <div class="lh-1">
                    <h4 class="mb-0 text-white lh-1">SELAMAT DATANG, JANGAN LUPA ABSEN MASUK & PULANG</h4>
                    <small>Last reloaded: <?=date("d-m-Y H:i:s")?></small>
                </div>
                <div class="qrdivform">
                    <form id="qrbulkform">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                        <textarea id="qr" name="qr" rows="3" cols="14" <?=($disable_input)?'disabled="disabled"':''?> autofocus></textarea>
                    </form>
                </div>
            </div>
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
                <div class="row">
                    <div class="col-md-12 append-domlist"></div>
                </div>
                <!-- <small class="d-block text-end mt-3">
                <a href="#">All updates</a>
                </small> -->
            </div>
        </main>
        <script src="<?=ASSETS_URL?>bootstrap-5.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="<?=JS_URL?>offcanvas-navbar.js"></script>
        <script type="text/javascript">
            var count = 1;
            document.querySelector('#qr').addEventListener('keypress', (evt) => {
                if(evt.key === 'Enter' || evt.code === 13) {
                    let qrdata = new FormData(document.getElementById('qrbulkform'));
                    const urlpost = '<?=base_url()?>qrs/submit';
                    let xhttp = new XMLHttpRequest();

                    xhttp.open('POST', urlpost, true);
                    xhttp.onload = function() {
                        if (this.status >= 200 && this.status < 400) {
                            const resp = JSON.parse(xhttp.responseText);
                            if(resp.status === true) {
                                const domlist = "<div class=\"d-flex text-body-secondary pt-3 border-bottom\">\
                                                <i class=\"bi bi-person-square flex-shrink-0 me-2 rounded d-flex\" style=\"font-size:3em\"></i>\
                                                <p class=\"pb-3 mb-0 fs-5 lh-sm\">\
                                                    <strong class=\"d-block text-gray-dark\">"+resp.nama_murid+" ("+resp.kelas+")"+"</strong>\
                                                    "+resp.nis+"\
                                                </p>\
                                            </div>";
                            
                                $('.append-domlist').prepend(domlist).hide().fadeIn();
                            }
                        } else {
                             //nothing to do
                        }
                    };
                    xhttp.send(qrdata);
                } else {
                    //console.log('key event: ' + evt.key);
                }
            });
        </script>
    </body>
</html>