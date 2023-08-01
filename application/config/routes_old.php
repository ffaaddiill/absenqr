<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

require_once( BASEPATH .'database/DB.php' );

$route['default_controller'] = 'main';
$route['404_override'] = '';

// customize routes
$uri1 = $this->uri->segment(1,0);
$uri2 = $this->uri->segment(2,0);

$db =& DB();

$cat = $db->select('slug')
			->where('is_active', 1)
			->where('is_delete', 0)
			->get('news_category')->result_array();

$product_cat = $db->select('slug')
				->where('is_active', 1)
				->where('is_delete', 0)
				->get('product_category')->result_array();

$page_not_equal = array(
					'all-items',
					'form-sewa-mobil',
					'hubungi-kami',
					'tentang-kami'
				);
			
$categories = $product_categories = [];

foreach($cat as $key=>$val) {
	array_push($categories, $val['slug']);
}

foreach($product_cat as $key=>$val) {
	array_push($product_categories, $val['slug']);
}

if(isset($_GET['debug']) && $_GET['debug'] == 'catlist') {
	echo '<pre';
	print_r($categories);
	die(); 
}

// echo '<pre>';
// print_r($categories);
// die();

if(in_array($uri1,$categories) && empty($uri2)){
	$route['(:any)'] = "categories/index/$1";
	
} elseif(!in_array($uri1,$categories) && empty($uri2) && !in_array($uri1,$product_categories) && !in_array($uri1,$page_not_equal)) {
	//die('pages');
	$route['(:any)'] = 'pages/index/$1';
} elseif($uri1 == 'all-items') {
	//die('url : ' . $uri1);
	$route['all-items'] = 'main/allitems';
} elseif($uri1 == 'mobil-rental') {
	$route['mobil-rental'] = 'main/allcars';
} elseif($uri1 == 'form-sewa-mobil') {
	$route['form-sewa-mobil'] = 'customer_product/form_sewa';
} elseif($uri1=='hubungi-kami') {
	$route['hubungi-kami'] = 'contact/index';
} elseif($uri1=='tentang-kami') {
	$route['tentang-kami'] = 'about/index';
}
/*elseif($uri1 == 'food') {
	$route['food'] = 'main/index/food';
} elseif('all-items') {
	die();
	$route['all-items'] = 'main/allitems';
} */

if(in_array($uri1,$product_categories) && empty($uri2)){
	//die('product category');
	$route['(:any)'] = "main/index/$1";
}



if(isset($uri2) && !empty($uri2)) {
	if(in_array($uri1,$categories) && strtolower($uri2) == 'index-berita'){		
		$route["(:any)/index-berita/(:num)"] = 'categories/index_news/$2';
		$route["(:any)/index-berita"] = 'categories/index_news';
	} elseif($uri1 == 'form-sewa-mobil') {
		$route['form-sewa-mobil/(:num)'] = 'customer_product/form_sewa/$1';
		$route['form-sewa-mobil/success'] = 'customer_product/success';
	} elseif($uri1 == 'sewa-mobil') {
		$route['sewa-mobil/(:num)/(:any)'] = 'customer_product/index/$1/$2';
	} else {
		$route["(:any)/(:num)/(:any)"] = "landing/index/$1/$2/$3";
	}
}


//$route['(:any)'] = 'pages/$1';



