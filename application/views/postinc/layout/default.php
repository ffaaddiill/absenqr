<html lang="en">
    <head>
        <!-- tes -->  
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?=CSS_URL?>global.css" rel="stylesheet">
        <link href="<?=CSS_URL?>blog.css" rel="stylesheet">
        <link href="<?=CSS_URL?>font-face.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
        <link href="<?=CSS_URL?>style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <title>Hello, world!</title>
    </head>
    <body>
        <div class="container">
            <header class="blog-header pt-2 pb-2">
                <div class="row flex-nowrap justify-content-between align-items-end">
                    <div class="col-4">
                        <a class="blog-header-logo text-dark" href="#">
                            <img class="d-inline-block float-left" src="<?=IMG_URL?>logo.png" width="80">
                            <!-- <div class="pinc-logo-text ff-hvb fs12 d-table-cell pl-1">Break the Post, <br>Connecting Generations</div> -->
                        </a>
                    </div>

                    <div class="col-md-5 col-xs-6 text-right">
                        <a class="a-sosmed-top" href="https://www.facebook.com/Maknanews-109712490471755/">
                            <span class="sosmed-top sosmed-top-fb">
                                <i class="fab fa-facebook-square position-relative fs22 pinc-yellow"></i>
                            </span>
                        </a>
                        <a class="a-sosmed-top ml-2" href="https://twitter.com/maknanews">
                            <span class="sosmed-top sosmed-top-twitter">
                                <i class="fab fa-twitter-square position-relative fs22 pinc-yellow"></i>
                            </span>
                        </a>
                        <a class="a-sosmed-top ml-2" href="https://twitter.com/maknanews">
                            <span class="sosmed-top sosmed-top-instagram">
                                <i class="fab fa-instagram position-relative fs22 pinc-yellow"></i>
                            </span>
                        </a>
                        <a class="a-sosmed-top ml-2" href="https://twitter.com/maknanews">
                            <span class="sosmed-top sosmed-top-youtube">
                                <i class="fab fa-youtube position-relative fs22 pinc-yellow"></i>
                            </span>
                        </a>
                        <a class="a-search-top ml-2 d-xs-flex d-md-none" href="#">
                            <span class="search-top">
                                <i class="fa fa-search position-relative fs22"></i>
                            </span>
                        </a>
                    </div>
                    
                    <div class="col-3 d-none d-md-flex justify-content-end align-items-center">
                        <div class="outer-search">
                            <input type="text" class="top-search ml-2" name="keyword">
                        </div>
                        <a class="text-muted top-search-btn" href="#" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mr-3 ml-1" role="img" viewBox="0 0 24 24" focusable="false">
                                <title>Search</title>
                                <circle cx="10.5" cy="10.5" r="7.5"/>
                                <path d="M21 21l-5.2-5.2"/>
                            </svg>
                        </a>
                        
                    </div>
                </div>
            </header>

            <div id="top-search" class="row">
                <div class="col-xs-12 d-none d-md-none">
                    <input type="text" name="keyword">
                </div>
            </div>

            <div class="nav-scroller d-none d-md-block py-1 mb-2">
                <nav class="nav d-flex justify-content-around ff-osw">
                    <a class="p-2 text-muted" href="#">NASIONAL</a>
                    <a class="p-2 text-muted" href="#">INTERNASIONAL</a>
                    <a class="p-2 text-muted" href="#">EKONOMI</a>
                    <a class="p-2 text-muted" href="#">SPORTS</a>
                    <a class="p-2 text-muted" href="#">LIFESTYLE</a>
                    <a class="p-2 text-muted" href="#">URBAN</a>
                </nav>
            </div>
            <div class="nav-scroller d-block d-md-none py-1 mb-2">
                <nav class="nav d-flex justify-content-between ff-osw">
                    <a class="p-2 text-muted" href="#">NASIONAL</a>
                    <a class="p-2 text-muted" href="#">INTERNASIONAL</a>
                    <a class="p-2 text-muted" href="#">EKONOMI</a>
                    <a class="p-2 text-muted" href="#">SPORTS</a>
                    <a class="p-2 text-muted" href="#">LIFESTYLE</a>
                    <a class="p-2 text-muted" href="#">URBAN</a>
                </nav>
            </div>

        </div>

        <?= $content ?>
        
        <footer class="container pt15 pl15 pr15 pb0">
            <div class="d-block bg-footer p30">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="d-inline-block float-left" src="<?=IMG_URL?>logo2.png" width="120">
                            </div>
                            <div class="col-md-12 position-absolute bottom0">
                                <div class="d-block fs12 white ff-hvl copy-text">
                                    <p class="mb0">&copy;2018 Postinc.</p>
                                    <p>All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <div class="row d-flex justify-content-end">
                            <div class="col-3">
                                <div class="ff-hvb fs14 pinc-yellow mb10">KATEGORI</div>
                                <ul class="list-unstyled text-small ul-footer ff-hvl">
                                    <li><a class="text-muted" href="#">Nasional</a></li>
                                    <li><a class="text-muted" href="#">Ekonomi</a></li>
                                    <li><a class="text-muted" href="#">Sports</a></li>
                                    <li><a class="text-muted" href="#">Lifestyle</a></li>
                                    <li><a class="text-muted" href="#">Urban</a></li>
                                </ul>
                            </div>
                            <div class="col-3">
                                <div class="ff-hvb fs14 pinc-yellow mb10">TIM KAMI</div>
                                <ul class="list-unstyled text-small ul-footer ff-hvl">
                                    <li><a class="text-muted" href="#">Tentang Kami</a></li>
                                    <li><a class="text-muted" href="#">Kontak</a></li>
                                </ul>
                            </div>
                            <div class="col-3">
                                <div class="ff-hvb fs14 pinc-yellow mb10">LAINNYA</div>
                                <ul class="list-unstyled text-small ul-footer ff-hvl">
                                    <li><a class="text-muted" href="#">Pedoman Media Siber</a></li>
                                    <li><a class="text-muted" href="#">Ketentuan Penggunaan</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script type="text/javascript">
            $('.a-search-top').click(function() {
                $('#top-search').fadeIn();
            });
        </script>
    </body>
</html>
