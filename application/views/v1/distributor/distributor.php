 <style type="text/css">
    .search_form .input-group .input-group-btn {
        text-align: left;
    }
    .search_form .input-group {
        width: 100%;
    }
    .label-gray {
        background-color: #FFFFFF;
        color: #37353a;
        padding: 7px;
        line-height: 25pt;
    }

    .m500{
        min-height: 10px;
    }
    .location-cat-tab{
        margin-left: 14.333333%;
        margin-top: 20px;
    }
</style>
<div class="row search-block m500 distrbutor-listing">
    <h1 class="header" style="margin-bottom:20px">Distributor &amp; Dealer</h1> 
    <div class="col-md-10 col-md-offset-2">
        <form  class="form-inline search_form" action="#" method="POST" onsubmit="return false;">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="form-control search_location" name="search_location" id="search_location" placeholder="Silakan masukkan kota atau provinsi yang dicari">
                        <span class="input-group-btn">
                            <button class="btn btn-beli-primary" id="btn-search-location" type="button" onclick="return false;">GO SEARCH</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>
<div class="row">
    <div class="col-md-12 location-cat-tab">
        <div class="btn-group filter-button-location-group" role="group" aria-label="btnlok">
            <?php
            foreach ($regionals as $key => $value) {
               
            ?>
            <button type="button" class="btn btn-success" data-filter=".data-<?php echo str_replace(array(' ','&'),array('-','-'), strtolower($value['name']))?>"><?=$value['name']?></button>
            <?php
             # code...
            }
            ?>
        </div>
        <br />
        <br />
    </div>
</div>
<div class="distrbutor-listing row grid">
        <?php
        foreach ($offices as $key => $office) {
           if(str_replace(array(' ','&'),array('-','-'), strtolower($office['regional'])) == 'sumatra' && $key < 4){
            $hide = '';

        }else{
            $hide = 'hide';
        }
        ?>
        <div class="col-md-3 <?=$hide?> element-item data-<?=str_replace(array(' ','&'),array('-','-'), strtolower($office['regional']))?>">
            <div class="col-md-2 col-xs-2"></div>
            <div class="col-md-10 col-xs-10" style="padding: 0">
                <h3><?=$office['regional']?></h3>
                <address>
                    <span class="label label-gray"><strong><?=$office['name']?></strong></span><br/>
                    <?=$office['address']?><br/>
                    <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> <?=$office['phone_area'].' '.$office['no_phone']?>
                </address>
            </div>
        </div>
        <?php
         # code...
        }
        ?>
</div>


<script>
// isotope js
    // quick search regex
    var qsRegex;

    // use value of search field to filter
    var $quicksearch = $('.search_location').keyup( debounce( function() {
        qsRegex = new RegExp( $quicksearch.val(), 'gi' );
        $('.element-item').removeClass('hide');
        $('.search-block.distrbutor-listing').removeClass('m500');
        // init Isotope
        $('.grid').isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows',
            filter: function() {
                return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
        });
    }, 200 ) );
    var $quicksearch_button = $('#btn-search-location').click( debounce( function() {
        qsRegex = new RegExp( $('.search_location').val(), 'gi' );
        $('.element-item').removeClass('hide');
        $('.search-block.distrbutor-listing').removeClass('m500');
        // init Isotope
        $('.grid').isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows',
            filter: function() {
                return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
        });
    }, 200 ) );
    $('.filter-button-location-group').on( 'click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        $('.element-item').removeClass('hide');
        $('.grid').isotope({ filter: filterValue });
    });
    // debounce so filtering doesn't happen every millisecond
    function debounce( fn, threshold ) {
        var timeout;
        return function debounced() {
            if ( timeout ) {
                clearTimeout( timeout );
            }
            function delayed() {
                fn();
                timeout = null;
            }
            timeout = setTimeout( delayed, threshold || 100 );
        };
    }
</script>