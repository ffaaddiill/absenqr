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
$route['default_controller'] = 'main';
//$route['default_controller'] = 'comingsoon';
$route['404_override'] = 'Custom_http_page/page404';

//borneotropicalstream
$route['pages/(.+)$'] = "pages/index/$1";
$route['gallery'] = "gallery/index";
$route['gallery-ourfarm'] = "gallery_ourfarm/index";
$route['gallery-hatchery-rnd-room'] = "gallery_hatcherylab/index";
$route['blog'] = 'news/index';
$route['blog/(:any)'] = "news/category/$1";
$route['blog/(:any)/(:any)'] = "news/view_news/$2";
$route['contact/message/success'] = "contact/inbox_success";
$route['subscribe'] = "contact/subscribe";
$route['subscribe/message/success'] = "contact/subscribe_success";

// customize routes

$route['info-pra-bayar'] = 'pages';
$route['panduan'] = 'pages';
$route['info-paket'] = 'pages';
$route['info-channel'] = 'pages';
$route['perangkat'] = 'pages';
$route['faq'] = 'pages';

$route['distributor-dealer'] = 'distributor';

$route['promo-news/detail/(:num)'] = 'promonews/detail/$1';
$route['promo-news'] = 'promonews';

