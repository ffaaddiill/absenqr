function the_grid(grid_id, url_grid,lang, per_page, page, order_id, order_direction,date_start,date_end) {
    grid_id = (grid_id) ? '#' + grid_id : '#myGrid';
    per_page = (per_page) ? per_page : 10;
    page = (page) ? page : 0;
    order_id = (order_id) ? order_id : 'id';
    order_direction = (order_direction) ? order_direction : 'desc';
    default_perpage = per_page;
    lang = (lang) ? lang : 1;
    date_start = (date_start) ? date_start : false;
    date_end = (date_end) ? date_end : false;
    //date = false;
    //alert(lang);

    function my_grid(id,type) { // id = id field yg di sort
        var s_val;
        var s_field;
        var s_url = '';
        var kelas = $('#' + id + ' span').attr('class');
        var sort_type = (kelas == 'ui-icon ui-icon-carat-1-s' && type) ? 'asc' : 'desc';
        if (!kelas) {
            sort_type = order_direction;
        }
        if(date_start != false){
        	var get_date = '&search_create_date_start='+date_start;
        	
        }else{
        	var get_date = '';
        }
        if(date_end != false){
        	var get_date_end = '&search_create_date_end='+date_end;
        	
        }else{
        	var get_date_end = '';
        }
        //alert(get_date);
        var new_class = (kelas == 'ui-icon ui-icon-carat-1-s') ? 'ui-icon ui-icon-carat-1-n' : 'ui-icon ui-icon-carat-1-s';
        $(grid_id + ' thead tr').find('span').removeClass('sort ui-icon-carat-1-s ui-icon ui-icon-carat-1-n');
        $('#' + id + ' span').addClass(new_class);
        $(grid_id).find('.cari').each(function() {
            s_val = $(this).val();
            s_field = $(this).attr('id');
            s_url += '&' + s_field + '=' + s_val;
        })
        s_url += '&lang=' + lang + '&perpage=' + per_page + '&sort_field=' + id + '&sort_type=' + sort_type+get_date+get_date_end ;
        load_data(url_grid + '/' + page + '?page=' + page + s_url);
    }

    //header table di klik
    $(grid_id + ' thead tr th').click(function() {
        var id = $(this).attr('id');
        var is_sort = $(this).attr('title');
        if (is_sort != 'Sort')
            return false;
        my_grid(id,order_direction);

    })

    //tambahin class sort utk kolom yg mau di sort
    $(grid_id + ' thead tr').find('th').each(function() {
        if ($(this).attr('title') == 'Sort') {
            $(this).addClass('sort');
        }
    })

    //reset value pencarian on refresh
    $(grid_id).find('.cari').val('');

    //pencarian
    $('.cari').keypress(function(e) {
        if (e.which == 13) {
            var val;
            var key;
            var kelas;
            var id;
            var url = '';
            $(grid_id).find('.cari').each(function() {
                val = $(this).val();
                key = $(this).attr('id');
                url += '&' + key + '=' + val;
            })

            sort_field = kolom_sort();
            sort_type = kolom_type();
            url += '&lang=' + lang + '&perpage=' + per_page + '&sort_field=' + sort_field + '&sort_type=' + sort_type;
            load_data(url_grid + '?&page=0' + url);
        }
    });

    function kolom_sort() {
        var ret = '';
        var kelas = '';
        var hasil = '';
        $(grid_id + ' thead tr th').each(function() {
            if ($(this).attr('title') == 'Sort') {
                ret = ($(this).attr('id'));
                $(this).find('span').each(function() {
                    kelas = $(this).attr('class');
                    if (kelas == 'ui-icon ui-icon-carat-1-s' || kelas == 'ui-icon ui-icon-carat-1-n') {
                        hasil = ret;
                    }
                })
            }
        })
        return (hasil) ? hasil : order_id;
    }
    function kolom_type() {
        var ret = '';
        var kelas = '';
        var hasil = '';
        $(grid_id + ' thead tr th').each(function() {
            if ($(this).attr('title') == 'Sort') {
                ret = ($(this).attr('id'));
                $(this).find('span').each(function() {
                    kelas = $(this).attr('class');
                    if (kelas == 'ui-icon ui-icon-carat-1-s') {
                        hasil = 'desc';
                    }
                    else if (kelas == 'ui-icon ui-icon-carat-1-n') {
                        hasil = 'asc';
                    }
                })
            }
        })
        return (hasil) ? hasil : order_direction;
    }

    function paging() {
        $('ul.pagination li a').click(function() {
            var url = $(this).attr('href');
            var s_url = '';
            if (url) {
                $(grid_id).find('.cari').each(function() {
                    s_val = $(this).val();
                    s_field = $(this).attr('id');
                    s_url += '&' + s_field + '=' + s_val;
                })
				 if(date_start != false){
		        	var get_date = '&search_create_date_start='+date_start;
		        	
		        }else{
		        	var get_date = '';
		        }
		        if(date_end != false){
		        	var get_date_end = '&search_create_date_end='+date_end;
		        	
		        }else{
		        	var get_date_end = '';
		        }
                var urls = $(this).attr('href').split('/');
                var page = urls.pop();
                page = (page) ? page : 0;
                sort_field = kolom_sort();
                sort_type = kolom_type();
                var next = url + '?page=' + page +'&lang=' + lang + '&perpage=' + per_page + '&sort_field=' + sort_field + '&sort_type=' + sort_type + s_url+get_date+get_date_end;
                load_data(next);
            }
            return false;
        })
    }
    function load_data(url) {
        $(grid_id + ' tbody').html('<tr><td colspan="100" class="center"><br>' + loadingBtn + '</br></br></td></tr>');
        $.ajax({
            url: url + '&' + Math.random(),
            success: function(msg) {
                $(grid_id + ' tbody').html(msg);
                paging(grid_id, per_page);
                

                $('.hapus').click(function() {
                    var idx = $(this).attr('data-id');
                    var link = $(this).attr('data-url-rm');
                    var data_recirect = $(this).attr('data-redirect');
                    if (confirm('Are You sure want to delete this records?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'id=' + idx+'&'+token_name+'='+token_key,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id,'desc');
                                //alert(msg);
                                
                            }
                        })
                    }
                });
                 $('.status_change_answer').click(function(){
                    var idx = $(this).attr('data-id');
                    var idx_p = $(this).attr('data-id-parent');
                    var link = $(this).attr('data-url-rm');
                    //alert(link);
                    if (confirm('Apa Anda yakin untuk mengubah jawaban ini?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'iddel=' + idx+'&id_parent='+idx_p,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id);
                                
                                //alert('Delete Success');
                            }
                        })
                    }
                });
                $('.status_change_publish_question').click(function(){
                    var idx = $(this).attr('data-id');
                    var idx_p = $(this).attr('data-id-status');
                    var link = $(this).attr('data-url-rm');
                    //alert(link);
                    if (confirm('Apa Anda yakin untuk mengubah status pertanyaan ini?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'id_question=' + idx+'&id_status='+idx_p,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id);
                                
                                //alert('Delete Success');
                            }
                        })
                    }
                });
                $('.status_change_tags').click(function(){
                    var id_article = $(this).attr('data-id');
                    var id_tag = $(this).attr('data-id-tag');
                    var link = $(this).attr('data-url-rm');
                     var status = $(this).attr('data-status');
                    //alert(link);
                    if (confirm('Apa Anda yakin untuk menjadikan tag ini popular?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'id_article=' + id_article+'&id_tag='+id_tag+'&id_status='+status,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id);
                                
                                //alert('Delete Success');
                            }
                        })
                    }
                });
                $('.hapus_lang').click(function() {
                    
                    var idx = $(this).attr('data-id');
                    var link = $(this).attr('data-url-rm');
                    var langs = $(this).attr('data-lang');
                    var data_recirect = $(this).attr('data-redirect');
                   // alert(langs);
                    if (confirm('Are You sure want to delete this record?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'iddel=' + idx+'&lang='+langs,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id);
                                //alert(msg);
                                
                            }
                        })
                    }
                });
                $('.change_status').click(function(){
                    var idx = $(this).attr('data-id');
                    var link = $(this).attr('data-url-rm');
                    //alert(link);
                    if (confirm('Are You sure want to change status this member?')) {
                        $.ajax({
                            url: current_ctrl + link,
                            data: 'iddel=' + idx,
                            type: 'POST',
                            success: function(msg) {
                                my_grid(order_id);
                                //alert('Delete Success');
                            }
                        })
                    }
                });
                
            }
        });
    }
    $(grid_id + ' .reload').click(function() {
        per_page = default_perpage;
        $(grid_id + ' .perpage').val(default_perpage);
        $(grid_id).find('.cari').val('');
        date = false;
        my_grid(order_id);
    })
    $(grid_id + ' .perpage').change(function() {
        per_page = $(this).val();
        my_grid(order_id);
    })
	$(grid_id + ' .search_date').click(function() {
        date_start = $('.date-created-start').val();
        date_end = $('.date-created-end').val();
        //alert(date);
        my_grid(order_id);
    })    
    $(grid_id + ' .language').change(function() {
        lang = $(this).val();
        //alert(lang);
        my_grid(order_id);
    })

    my_grid(order_id);
    $(grid_id + ' .perpage').val(default_perpage);


}
