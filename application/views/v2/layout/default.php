<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>SMK MUHAMMADIYAH 9 CIPULIR</title>
    <link href="
            <?= CSS_URL ?>style.css" rel="stylesheet" type="text/css" />
    <link href="
                <?= CSS_URL ?>highslide.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="
                    <?= IMG_URL ?>icon.png" />
    <script type="text/javascript" src="
                        <?= JS_URL ?>dropdown.js">
    </script>
    <script type="text/javascript" src="
                        <?= JS_URL ?>highslide-with-html.js">
    </script>
    <script type="text/javascript" src="
                        <?= JS_URL ?>slideshow.js">
    </script>
    <script type="text/javascript" src="
                        <?= JS_URL ?>utilities.js">
    </script>
    <script type="text/javascript">
        hs.graphicsDir = ' <?= IMG_URL ?> ';
        hs.outlineType = 'rounded-white';
        hs.wrapperClassName = 'draggable-header';
    </script>
</head>

<body onLoad="goforit()">
    <div id="luar">
        <div id="head">
            <div id="head-kiri">
                <img src="
                                    <?= IMG_URL ?>bg-head.jpg" />
            </div>
            <div id="head-kanan">
                <h6>KOLOM PENCARIAN</h6>
                <form method="post" action="">
                    <span>
                                            <input type="text" name="cari" size="20" class="input"/>
                                            <select name="jenis" class="dropdown">
                                                <option>Pengumuman</option>
                                                <option>Berita</option>
                                                <option>Agenda</option>
                                            </select>
                                            <input type="submit" value="Cari" class="submitButton"/>
                                        </span>
                </form>
                <span>
                                        <h5>
                                            <a href="
                                                <?php echo base_url() ?>">BERANDA
                                            </a>
                                            <?php
$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
if($session!=""){
$pecah=explode("|",$session);
$nama = $pecah[1];
$status = $pecah[2];
if($status=='admin'){
?>
                                            <a href="
                                                <?php echo base_url() ?>index.php/web/logout">LOG OUT
                                            </a> | 
                                            <a href="
                                                <?php echo base_url(); ?>index.php/adminweb">C-PANEL
                                            </a>
                                            <?php
}
else{
?>
                                            <a href="
                                                <?php echo base_url() ?>index.php/web/logout">LOG OUT
                                            </a> | 
                                            <a href="
                                                <?php echo base_url(); ?>index.php/guru">C-PANEL
                                            </a>
                                            <?php
}
}
else{
?>
                                            <a href="
                                                <?php echo base_url() ?>index.php/web/login">LOG IN
                                            </a>
                                            <?php
}
?>

| 
                                            <a href="
                                                <?php echo base_url() ?>index.php/web/contact">HUBUNGI KAMI
                                            </a>
                                        </h5>
                                    </span>
                <?php if($session!="" ){ echo "Selamat Datang 
                                    <b>".$nama. "</b>"; } else{ } ?>
            </div>
        </div>
        <div id="menu">
            <div id='parent_1' class='sample_attach'><a href='#'>Profil Sekolah</a></div><div id='child_1'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/1.1'>Sambutan Kepala Sekolah</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/1.2'>Visi dan Misi</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/1.3'>Sasaran Mutu</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/1.4'>Tujuan</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/1.5'>Motto</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><script type="text/javascript">
                at_attach("parent_1", "child_1", "hover", "y", "pointer");
                </script><div id='parent_2' class='sample_attach'><a href='#'>Fasilitas Sekolah</a></div><div id='child_2'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/2.1'>Sarana dan Prasarana</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/2.2'>Peta Lokasi Sekolah</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><script type="text/javascript">
                at_attach("parent_2", "child_2", "hover", "y", "pointer");
                </script><div id='parent_3' class='sample_attach'><a href='#'>Pendidik & Tenaga Pendidik</a></div><div id='child_3'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/3.1'>Struktur Organisasi Sekolah</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/3.2'>Kepala Sekolah</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/3.3'>Komite Sekolah</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/3.4'>Data Guru</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/3.5'>Data Pegawai</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><script type="text/javascript">
                at_attach("parent_3", "child_3", "hover", "y", "pointer");
                </script><div id='parent_4' class='sample_attach'><a href='#'>Kesiswaan</a></div><div id='child_4'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/4.1'>Data Siswa</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/4.2'>Data Prestasi Siswa</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><script type="text/javascript">
                at_attach("parent_4", "child_4", "hover", "y", "pointer");
                </script><div id='parent_5' class='sample_attach'><a href='#'>Akademik Sekolah</a></div><div id='child_5'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/5.1'>Absensi Harian Siswa</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/5.2'>Info Penerimaan Siswa Baru</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><script type="text/javascript">
                at_attach("parent_5", "child_5", "hover", "y", "pointer");
                </script><div id='parent_6' class='sample_attach'><a href='#'>Ekstra Kurikuler</a></div><div id='child_6'><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.1'>Sepak Bola</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.2'>Bola Volly</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.3'>Musik</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.4'>Pencinta Alam (PA)</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.5'>PMR</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.6'>Bola Basket</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.7'>Pramuka</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.8'>English Club</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.9'>Pencak Silat</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.10'>Teater</a><a class='sample_attach' href='http://smkmuhammadiyah9.sch.id/index.php/web/data/6.11'>Tekwondo</a></div><script type="text/javascript">
                at_attach("parent_6", "child_6", "hover", "y", "pointer");
                </script>
        </div>
        <div>
            <div id="imgSShow" align="center">
                <img src="<?= IMG_URL ?>head.jpg" alt="large image" name="SLIDESIMG" id="SLIDESIMG" style="opacity: 1;">
                <script type="text/javascript">
                    SLIDES = new slideshow("SLIDES");
                    SLIDES.timeout = 5000;
                    SLIDES.prefetch = 1;
                    s = new slide();
                    s.src = " <?= IMG_URL ?>head.jpg ";
                    SLIDES.add_slide(s);

                    s = new slide();
                    s.src = "<?= IMG_URL ?>head1.jpg ";
                    SLIDES.add_slide(s);

                    s = new slide();
                    s.src = "<?= IMG_URL ?>head2.jpg ";
                    SLIDES.add_slide(s);

                    s = new slide();
                    s.src = "<?= IMG_URL ?>head3.jpg ";
                    SLIDES.add_slide(s);


                    <!--s = new slide();-->
                    <!--s.src = "<?= IMG_URL ?>head4.jpg";-->
                    <!--SLIDES.add_slide(s);-->

                    SLIDES.image = document.images.SLIDESIMG;

                    // SLIDEanimpre = new YAHOO.util.Anim('SLIDESIMG', { opacity: { to: 0.1, from:1 } }, 2, YAHOO.util.Easing.easeOut);

                    // SLIDES.pre_update_hook = function() { SLIDEanimpre.animate(); alert("pre"); return; }
                    SLIDES.pre_update_hook = function() {
                        YAHOO.util.Dom.setStyle('SLIDESIMG', 'opacity', '0.4');
                        return;
                    }

                    SLIDEanim = new YAHOO.util.Anim('SLIDESIMG', {
                        opacity: {
                            to: 1,
                            from: 0.4
                        }
                    }, 1, YAHOO.util.Easing.easeOut);

                    SLIDES.post_update_hook = function() {
                        SLIDEanim.animate();
                        return;
                    }

                    SLIDES.update();

                    YAHOO.util.Event.addListener("body", "onload", SLIDES.play());
                </script>
            </div>
        </div>
        <div id="menu">
            <div class='sample_attach'><a href='http://smkmuhammadiyah9.sch.id/index.php/web/data/7'>Indexs Berita</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><div class='sample_attach'><a href='http://smkmuhammadiyah9.sch.id/index.php/web/data/8'>Galeri Kegiatan</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><div class='sample_attach'><a href='http://smkmuhammadiyah9.sch.id/index.php/web/data/9'>Pengumuman</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><div class='sample_attach'><a href='http://smkmuhammadiyah9.sch.id/index.php/web/data/10'>Agenda Sekolah</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><div class='sample_attach'><a href='http://smkmuhammadiyah9.sch.id/index.php/web/data/11'>List Download</a></div><div id="batas-menu"><img src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/images/batas.jpg" /></div><div id="s-menu"><script language="javascript" src="http://smkmuhammadiyah9.sch.id/system/application/views/main-web/js/clock.js" type="text/javascript"></script><span id="clock"></span></div>
        </div>

        <div id="content">
            <div id="content-kiri">

                <div id="bg-judul">KEPALA SEKOLAH SMKM 9</div>
                <div id="isi-side-kepsek">
                    <img src="<?= IMG_URL ?>kepala-sekolah.jpg" />
                    <br /> Nachrowi Iman Santoso, SE. MM
                    <br />NBM. 106 66 13
                </div>
                <div id="bg-bawah-judul"></div>

                <div id="bg-judul">KRITIK DAN SARAN</div>
                <div id="isi-side">
                    <div id="cboxdiv" style="text-align: center; line-height: 0">
                        <div>
                            <iframe frameborder="0" width="215" height="245" src="http://my.cbox.ws/smkm9" marginheight="2" marginwidth="2" scrolling="auto" allowtransparency="yes" name="cboxmain" style="border: 0px solid;" id="cboxmain"></iframe>
                        </div>
                        <!--<div><iframe frameborder="0" width="215" height="75" src="http://www2.cbox.ws/box/?boxid=2175405&amp;boxtag=r8m5q2&amp;sec=form" marginheight="2" marginwidth="2" scrolling="no" allowtransparency="yes" name="cboxform" style="border: 0px solid;border-top:0px" id="cboxform"></iframe></div>-->
                    </div>
                </div>
                <div id="bg-bawah-judul"></div>

                <div id="bg-judul">ALUMNI SMKM 9</div>
                <div id="isi-side">
                    <ul>
                        <li class="li-class">Register Alumni</li>
                        <li class="li-class">Daftar Alumni</li>
                    </ul>
                </div>
                <div id="bg-bawah-judul"></div>

                <div id="bg-judul">LINK TERKAIT</div>
                <div id="isi-side">
                    <ul>
                        <li class="li-class">Jardiknas</li>
                        <li class="li-class">Depdiknas</li>
                        <li class="li-class">BSNP Indonesia</li>
                        <li class="li-class">Pemda DKI Jakarta</li>
                    </ul>
                </div>
                <div id="bg-bawah-judul"></div>

            </div>

            <div id="content-kanan">

                <div id="bg-judul">JAJAK PENDAPAT</div>
                    <div id="isi-side">
                        <form method="post" action="http://smkmuhammadiyah9.sch.id/index.php/web/hasilpolling">
                            <input type='hidden' name='id_soal' value='1'><h4><b>Bagaimana menurut pendapat anda tentang website SMK Muhammadiyah 9 Cipulir ini?</b></h4>
                            <span><input type='radio' name='polling' value='1' class='radio-class'> Kurang</span><br><span><input type='radio' name='polling' value='2' class='radio-class'> Cukup</span><br><span><input type='radio' name='polling' value='3' class='radio-class'> Sangat Bagus</span><br><span><input type='radio' name='polling' value='4' class='radio-class'> Tidak Tahu</span><br><br /><span style="padding-left:25px;"><input type="submit" value="Pilih" class="poll" /></span>
                            <a href="http://smkmuhammadiyah9.sch.id/index.php/web/lihathasil"><span class="poll">Lihat Hasil Polling</span></a></span><br />
                        </form>
                    </div>
                <div id="bg-bawah-judul"></div> 

                <div id="bg-judul">PENGUMUMAN TERBARU</div>
                    <div id="isi-side">
                    <ul>
                        <li class='li-class'><a href=http://smkmuhammadiyah9.sch.id/index.php/web/detailpengumuman/11 onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">Pengumuman Akhir Semester</a></li><li class='li-class'><a href=http://smkmuhammadiyah9.sch.id/index.php/web/detailpengumuman/10 onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">Pengumuman Tes Penerimaan Siswa Baru 2016/2017</a></li>
                    </ul><br />
                    <div class="submitButton">Lihat Semua Pengumuman</div>
                    </div>
                <div id="bg-bawah-judul"></div> 

                <div id="bg-judul">AGENDA SEKOLAH TERBARU</div>
                    <div id="isi-side">
                        <ul>
                            <li class='li-class'><a href=http://smkmuhammadiyah9.sch.id/index.php/web/detailagenda/5 onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">Meet and Greet Bedah Buku ke Film Bersama Artis dan Penulis Jilbab Traveler</a></li><li class='li-class'><a href=http://smkmuhammadiyah9.sch.id/index.php/web/detailagenda/1 onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">Penerimaan Raport Semester Genap Tahun Ajaran 2015-2016</a></li>
                        </ul><br />
                    <div class="submitButton">Lihat Semua Agenda</div>
                </div>
                <div id="bg-bawah-judul"></div> 

                <div id="bg-judul">STATISTIK PENGUNJUNG</div>
                <div id="isi-side">
                    <ul>
                        <li class="li-class">
                        Dikunjungi oleh : <b>12803</b> user</li>
                        <li class="li-class">IP address :  <b>125.160.96.157</b></li>
                        <li class="li-class">OS : <b>Unknown Windows OS</b></li>
                        <li class="li-class">Browser : <b>Safari 537.36</b></li>
                    </ul>
                </div>
                <div id="bg-bawah-judul"></div> 

                <div id="bg-judul">Live Streaming Radio Doskici</div>
                <div id="isi-side">
                    <object type="application/x-shockwave-flash" data="http://klikhost.com/sonicplayer/klikhost.swf" width="200" height="60" id="WHMSonicPlayer1" style="visibility: visible;">
                        <param name="menu" value="false">
                        <param name="id" value="WHMSonicPlayer1">
                        <param name="allowFullscreen" value="true">
                        <param name="allowScriptAccess" value="always">
                        <param name="bgcolor" value="#FFFFFF">
                        <param name="wmode" value="transparent">
                        <param name="flashvars" value="logo=http://klikhost.com/radio-streaming&amp;path=http://klikhost.com/sonicplayer/klikhost.swf&amp;source=http://103.28.148.18:9106/&amp;volume=70&amp;autoplay=true&amp;width=280&amp;height=60&amp;twitter=https://twitter.com/doskici&amp;facebook=http://www.facebook.com/doskici&amp;embedCallback=null&amp;bgcolor=#FFFFFF&amp;wmode=transparent&amp;containerId=WHMSonicPlayer1">
                    </object>
                    <param name="menu" value="false">
                    <param name="id" value="WHMSonicPlayer1">
                    <param name="allowFullscreen" value="true">
                    <param name="allowScriptAccess" value="always">
                    <param name="bgcolor" value="#FFFFFF">
                    <param name="wmode" value="transparent">
                    <param name="flashvars" value="logo=http://klikhost.com/radio-streaming&amp;path=http://klikhost.com/sonicplayer/klikhost.swf&amp;source=http://103.28.148.18:9106/&amp;volume=70&amp;autoplay=true&amp;width=280&amp;height=60&amp;twitter=https://twitter.com/doskici&amp;facebook=http://www.facebook.com/doskici&amp;embedCallback=null&amp;bgcolor=#FFFFFF&amp;wmode=transparent&amp;containerId=WHMSonicPlayer1">
                    </object>
                </div>
                <div id="bg-bawah-judul"></div>
            </div>

        </div>

        <div style="clear: both; width:100%; height: 10px;"></div>
        <div id="list-bawah">
            <div id="sub-list-bawah">
                <div id="title-list-bawah">GALERI KEGIATAN TERBARU</div>
                <div id="isi-list-bawah">
                    <?php foreach($cuplikan_galeri->result_array() as $b) { echo "
                    <a href='".base_url()."system/application/views/main-web/galeri/".$b[' foto_besar ']."' "; ?>

        onclick="return hs.expand(this, {wrapperClassName: 'borderless floating-caption', dimmingOpacity: 0.75, align: 'center'}) "
        <?php
                    
                    echo">
                        <div id='album-besar2'>
                            <div id='sub-album2'><img src='".base_url()."system/application/views/main-web/galeri/thumb/".$b[' foto_kecil ']."' border='0' width='90' title='".$b[' nama_album ']."'>
                            </div>
                        </div>
                    </a>"; } ?>
                    <ul>
                        <li class="li-class">Lihat koleksi foto-foto kegiatan yang lainnya. <a href="<?php echo base_url(); ?>index.php/web/data/8"><span class="submitButton2">Lihat Galeri Kegiatan</span></a>
                        </li>
                    </ul>
                </div>
                <div id="tutup-list-bawah"></div>
            </div>
            <div id="sub-list-bawah">
                <div id="title-list-bawah">ON AIR RADIO STATIONS DOSKICI</div>
                <div id="isi-list-bawah">

                    <iframe width="450" height="200" src="https://www.youtube.com/embed/a4VhKyKz2_Q" frameborder="0" allowfullscreen></iframe>
                    <div id="cstrpdiv"></div>
                </div>
                <div id="tutup-list-bawah"></div>
            </div>
        </div>
        <div id="footer">

            <?php $ip=$_SERVER[ 'REMOTE_ADDR']; ?> Copyright &copy; 2016 SMK MUHAMMADIYAH 9 CIPULIR. All Rights Reserved.
            <br />Design & Program by Perguruan Muhammadiyah Cipulir | Anda berkunjung dengan IP Address
            <?php echo $ip; ?>
        </div>
    </div>
</body>

</html>