<!doctype html>

<html lang="en">

    <head>

        <!-- Required meta tags -->

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="<?=base_url().ASSETS_URL?>slick/slick.css"/>

        <link rel="stylesheet" type="text/css" href="<?=base_url().ASSETS_URL?>slick/slick-theme.css"/>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">

        <link href="<?=ASSETS_URL?>fontawesome/css/all.min.css" rel="stylesheet"> <!--load all styles -->

        <link rel="stylesheet" type="text/css" href="<?=base_url().CSS_URL?>global.css"/>

        <link rel="stylesheet" type="text/css" href="<?=base_url().CSS_URL?>style.css"/>

        <link rel="stylesheet" type="text/css" href="<?=base_url().CSS_URL?>breakpoint.css"/>

        

        <?php if(isset($_GET['dev']) && $_GET['dev'] == '123'): ?>

        <link rel="stylesheet" href="<?=base_url().ASSETS_URL?>multiplecarousel/css/animate.css">

        <link rel="stylesheet" href="<?=base_url().ASSETS_URL?>multiplecarousel/css/style.css">

        <link rel="stylesheet" href="<?=base_url().ASSETS_URL?>multiplecarousel/css/media-queries.css">

        <link rel="stylesheet" href="<?=base_url().ASSETS_URL?>multiplecarousel/css/carousel.css">

		 <?php endif; ?>

        
        <?php if(isset($article)): ?>

        <!-- meta artikel -->

        <link rel="image_src" href="<?=base_url().NEWS_IMG_URL.$article['primary_image']?>" />

        <meta property="og:title" content="<?=$article['title']?>" />

		<meta property="og:type" content="website" />

		<meta property="og:description" content="<?=$article['teaser']?>" />

		<meta property="og:image" content="<?=base_url().NEWS_IMG_URL.$article['primary_image']?>"/>

		<meta property="og:site_name" content="Makna News" />

		<meta property="og:locale" content="id_ID" />

		<meta property="og:url" content="<?=base_url().$article['slug'].'/'.$article['id_news'].'/'.$article['uri_path']?>" />

		<meta property="article:author" content="https://www.facebook.com/maknaberita" />

		<meta property="article:section" content="<?= $article['slug'] ?>" />

		<meta property="fb:app_id" content=""/>

		<meta itemprop="datePublished" content="<?= $article['publish_date'] ?>" />

		<meta property="article:published_time" content="<?= $article['publish_date'] ?>" />

		<meta name="twitter:card" content="summary_large_image" />

		<meta name="twitter:site" content="@maknanews" />

		<meta name="twitter:creator" content="@maknanews">

		<meta name="twitter:title" content="<?=$article['title']?>" />

		<meta name="twitter:description" content="<?=$article['teaser']?>" />

		<meta name="twitter:image" content="<?=base_url().NEWS_IMG_URL.$article['primary_image']?>" />

		<meta name="twitter:domain" content="makna.news">

        <!-- end of meta artikel -->

        <?php endif; ?>

        

        <!-- favicon -->

        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?=base_url()?>apple-touch-icon-57x57.png" />

		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=base_url()?>apple-touch-icon-114x114.png" />

		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url()?>apple-touch-icon-72x72.png" />

		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url()?>apple-touch-icon-144x144.png" />

		<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?=base_url()?>apple-touch-icon-60x60.png" />

		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?=base_url()?>apple-touch-icon-120x120.png" />

		<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?=base_url()?>apple-touch-icon-76x76.png" />

		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?=base_url()?>apple-touch-icon-152x152.png" />

		<link rel="icon" type="image/png" href="<?=base_url()?>favicon-196x196.png" sizes="196x196" />

		<link rel="icon" type="image/png" href="<?=base_url()?>favicon-96x96.png" sizes="96x96" />

		<link rel="icon" type="image/png" href="<?=base_url()?>favicon-32x32.png" sizes="32x32" />

		<link rel="icon" type="image/png" href="<?=base_url()?>favicon-16x16.png" sizes="16x16" /> 

		<link rel="icon" type="image/png" href="<?=base_url()?>favicon-128.png" sizes="128x128" />

		<link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">

		<meta name="application-name" content="&nbsp;"/>

		<meta name="msapplication-TileColor" content="#" />

		<meta name="msapplication-TileImage" content="<?=base_url()?>mstile-144x144.png" /> 

		<meta name="msapplication-square70x70logo" content="<?=base_url()?>mstile-70x70.png" />

		<meta name="msapplication-square150x150logo" content="<?=base_url()?>mstile-150x150.png" />

		<meta name="msapplication-wide310x150logo" content="<?=base_url()?>mstile-310x150.png" />

		<meta name="msapplication-square310x310logo" content="<?=base_url()?>mstile-310x310.png" />


		<title>
			<?php if(isset($article) && !empty($article)): ?>
				<?= $article['title'] . ' - Makna' ?>
			<?php elseif( empty($this->uri->segment(1)) && empty($this->uri->segment(2)) ): ?>
				<?= 'Makna' ?>
			<?php elseif( !empty($this->uri->segment(1)) && empty($this->uri->segment(2)) ): ?>
				<?= getCategoryBySlug($this->uri->segment(1))['category_name'] . ' - Makna' ?>
			<?php endif; ?>
		</title>
        

        <script src="<?= base_url().JS_URL ?>bigtv.js"></script>

        <script type="text/javascript">

            var base_url = '<?= base_url() ?>';

            var current_ctrl = '<?= current_controller() ?>';

            var current_url = '<?= current_url() ?>';

            var assets_url = '<?= ASSETS_URL ?>';

            var token_name = '<?=$this->security->get_csrf_token_name()?>';

            var token_key = '<?=$this->security->get_csrf_hash()?>';

            var objToken = {};

            objToken[token_name] = token_key;

            console.log('5');

        </script>

        

        <script type="text/javascript">

        	var pcat='home';

        </script>

        

        <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-152621701-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		
		  gtag('config', 'UA-152621701-1');
		</script>


		<meta name="google-site-verification" content="zIXEtpmfmxdD9pFxQAevfv6cETP9IiLZ_ZOCA-4k8G0" />

    </head>

    <body>

        <header>

        	<?php /*

            <div>

                <div class="container">

                    <div class="row flex-nowrap justify-content-between align-items-center">

                        <div class="col-md-1 pt-1">

                            <a class="text-muted" href="<?=base_url()?>">

                                <img class="img-fluid logo" src="<?=base_url().IMG_URL?>logo.png">

                            </a>

                        </div>

                        <div class="col-md-4 mt10 d-flex justify-content-end align-items-center">

                            <input class="form-control" type="text" name="search">

                            <a class="text-muted" href="#">

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3 search-btn" focusable="false" role="img">

                                    <title>Search</title>

                                    <circle cx="10.5" cy="10.5" r="7.5"></circle>

                                    <line x1="21" y1="21" x2="15.8" y2="15.8"></line>

                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

			*/ ?>

            

            <nav class="navbar navbar-expand-md navbar-dark desktop-topnav bg-topnav fixed-top prl20">
            	
            	
				<div class="container">
					    	

		                <a class="navbar-brand" href="<?=base_url()?>">
		
		                    <img class="img-fluid logo" src="<?=IMG_URL?>logo.png">
		
		                </a>
		
		                <button class="navbar-toggler cursor-pointer" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		
		                    <i class="fas fa-bars makna-navbar-icon"></i>
		
		                    <?php /*<span class="navbar-toggler-icon makna-navbar-icon"></span>*/ ?>
		
		                </button>
		
		                <div class="collapse navbar-collapse" id="navbarCollapse">
		
		                    <ul class="navbar-nav mr-auto top-navbar">
		
		                        <?php foreach($top_menu as $key=>$val): ?>
		
		                            <li class="nav-item">
		
		                                <a class="nav-link" href="<?=base_url().$val['slug']?>"><span class="span-topmenu"><?=$val['title']?></span></a>
		
		                            </li>
		
		                        <?php endforeach; ?>
		
		                    </ul>
		
		                    
		
		                    <div class="d-table sosmed-top follow-us text-center">
		
		                        <?php /*<div class="fs14 d-inline pr5 d-table-cell align-middle">Follow </div> */ ?>
		
		                        <div class="fs25 d-inline pr5 mr5"><a href="https://www.facebook.com/Maknanews-109712490471755/"><i class="fab fa-facebook-f custom-facebook"></i></a></div>
		
		                        <div class="fs25 d-inline pr5 mr5 "><a href="https://twitter.com/maknanews"><i class="fab fa-twitter custom-twitter"></i></a></div>
		
		                        <div class="fs25 d-inline pr5 mr5"><a href="https://www.instagram.com/maknanews/"><i class="fab fa-instagram custom-instagram"></i></a></div>
		
		                        <div class="fs25 d-inline pr5"><a href="https://www.youtube.com/channel/UCEEbOHluYcAxCeItW7fbsmA"><i class="fab fa-youtube custom-youtube"></i></a></div>
		
		                    </div>
		
		                    <div class="col-md-2 col-xs-12 col-sm-12 d-flex justify-content-end align-items-center">
		
		                        <?= form_open(base_url().'search/index', ['id'=>'search_form', 'name'=>'search_form']) ?>
		
		                            <input class="form-control" id="search_keyword" type="text" name="keyword">
		
		                            <button class="text-muted top-btn-search btn btn-transparent" type="submit">
		
		                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3 search-btn" focusable="false" role="img">
		
		                                    <title>Search</title>
		
		                                    <circle cx="10.5" cy="10.5" r="7.5"></circle>
		
		                                    <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
		
		                                </svg>
		
		                            </button>
		
		                        <?= form_close(); ?>
		
		                        
		
		                    </div>
		
	                		</div>
		        		
		   		
		   		</div>

            </nav>

            <?php /* nav for mobile */ ?>
            <nav class="d-block d-sm-none navbar navbar-expand-md navbar-dark bg-topnav fixed-top prl20">
                <div class="row">
                    <div class="col-3">
                        <a class="navbar-brand" href="<?=base_url()?>">

                            <img class="img-fluid logo" src="<?=IMG_URL?>logo.png">

                        </a>
                    </div>
                    <div class="col-7 text-right">
                        <div class="d-inline-block mb0 mt5 sosmed-top follow-us text-center">

                            <div class="fs25 d-inline pr5"><a href="https://www.facebook.com/Maknanews-109712490471755/"><i class="fab fa-facebook-f custom-facebook"></i></a></div>

                            <div class="fs25 d-inline pr5"><a href="https://twitter.com/maknanews"><i class="fab fa-twitter custom-twitter"></i></a></div>

                            <div class="fs25 d-inline pr5"><a href="https://www.instagram.com/maknanews/"><i class="fab fa-instagram custom-instagram"></i></a></div>

                            <div class="fs25 d-inline pr5"><a href="https://www.youtube.com/channel/UCEEbOHluYcAxCeItW7fbsmA"><i class="fab fa-youtube custom-youtube"></i></a></div>

                        </div>
                    </div>

                    <div class="col-2">
                        <button class="navbar-toggler cursor-pointer prl0 float-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">

                            <i class="fas fa-bars makna-navbar-icon"></i>

                            <?php /*<span class="navbar-toggler-icon makna-navbar-icon"></span>*/ ?>

                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarCollapse">

                        <ul class="navbar-nav mr-auto top-navbar">

                            <?php foreach($top_menu as $key=>$val): ?>

                                <li class="nav-item">

                                    <a class="nav-link" href="<?=base_url().$val['slug']?>"><span class="span-topmenu"><?=$val['title']?></span></a>

                                </li>

                            <?php endforeach; ?>

                        </ul>

                        <div class="col-md-2 col-xs-12 col-sm-12 d-flex justify-content-end align-items-center">

                            <?= form_open(base_url().'search/index', ['id'=>'search_form', 'name'=>'search_form']) ?>

                                <input class="form-control" id="search_keyword" type="text" name="keyword">

                                <button class="text-muted top-btn-search btn btn-transparent" type="submit">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3 search-btn" focusable="false" role="img">

                                        <title>Search</title>

                                        <circle cx="10.5" cy="10.5" r="7.5"></circle>

                                        <line x1="21" y1="21" x2="15.8" y2="15.8"></line>

                                    </svg>

                                </button>

                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </nav>
        </header>



        <main role="main" style="padding-top: 50px">

			<?= $content ?>

            <!-- FOOTER -->

            <div class="bg-light-gray mt25">

                <footer class="container py-3">

                    <div class="row">

                        <div class="col-md-2 col-xs-12 col-sm-12 footer-logo">

                            <img class="img-fluid footer-logo" src="<?=base_url().IMG_URL?>logo.png">

                        </div>

                        

                        <div class="col-md-6" style="padding-top:23px;padding-bottom:23px;">

                        	<ul class="nav pl0 text-center d-block">

                        		<?php foreach(getFooterMenus() as $key=>$val): ?>

                        		<li class="nav-item">

                        			<a href="<?=base_url().$val['slug']?>" class="news-link pl10 pr10"><?=$val['title']?></a>

                        		</li>

                        		<?php endforeach; ?>

                        	</ul>

                        </div>

                        

                        <div class="col-md-4 text-right follow-us">

                        	<div style="display: inline-block; padding: 23px 0;">Follow makna.news | </div>

                        	<div class="fs20 d-inline pr5"><a href="https://www.facebook.com/Maknanews-109712490471755/"><i class="fab fa-facebook-square"></i></a></div>

	                    	<div class="fs20 d-inline pr5"><a href="https://twitter.com/maknanews"><i class="fab fa-twitter-square"></i></a></div>

	                    	<div class="fs20 d-inline pr5"><a href="https://www.instagram.com/maknanews/"><i class="fab fa-instagram"></i></a></div>

	                    	<div class="fs20 d-inline pr5"><a href="https://www.youtube.com/channel/UCEEbOHluYcAxCeItW7fbsmA"><i class="fab fa-youtube-square"></i></a></div>

                        </div>

                    </div>

                    <div class="row">

                    	<div class="col-md-12 text-center mt10 pt10" style="border-top: 1px solid #c5c5c5">

                        	&copy;2019 makna.news All Right Reserved

                        </div>

                    </div>

                </footer>

            </div>

        </main>



        <!-- Optional JavaScript -->

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->

        <script src="<?=base_url().JS_URL?>jquery.min.js"></script> 

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>



        <script type="text/javascript" src="<?=base_url().ASSETS_URL?>slick/slick.min.js"></script>

        <script type="text/javascript">

            $('.video-slider').slick({

                slidesToShow: 4,

                slidesToScroll: 4,

                autoplay: true,

                autoplaySpeed: 2000,

                responsive: [

				    {

				      breakpoint: 1024,

				      settings: {

				        slidesToShow: 3,

				        slidesToScroll: 3,

				        infinite: false,

				        dots: true

				      }

				    },

				    {

				      breakpoint: 600,

				      settings: {

				        slidesToShow: 2,

				        slidesToScroll: 2

				      }

				    },

				    {

				      breakpoint: 480,

				      settings: {

				        slidesToShow: 1,

				        slidesToScroll: 1

				      }

				    }

				    // You can unslick at a given breakpoint now by adding:

				    // settings: "unslick"

				    // instead of a settings object

				  ]

            });

        </script>

        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d974750ff46cfa8"></script>

        

		<!-- Large modal -->

		<div class="modal fade video_modal" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

			<div class="modal-dialog modal-lg custom-modal-lg">

			    <div class="modal-content custom-modal-content">

			    	

			    </div>

	  		</div>

		</div>

	<script>

		function getModalVideo(param) {
			var idnews = $(param).data('idnews');
			var data = [{ name:'id_news',value:idnews }];
			ajax_post("<?=base_url()?>news/ajax_news_video", data).done(function(response) {
				//$('#video_modal .modal-content').html(response.view);
				
				$('#video_modal').on('shown.bs.modal', function () {

					$('#video_modal .modal-content').html(response.view);

				});

				

				$('#video_modal').on('hide.bs.modal', function () {

					$('#video_modal .modal-content').empty();

				});

			});

			

			<?php /*

			$.post( "<?=base_url()?>ajax_news_video", { id_news:idnews,name:token_name,value:token_key }) 

  			.done(function( data ) {

		    	console.log('log: ' + idnews); 

	  		});

			 */ ?>

		}

	</script>
    </body>

</html>