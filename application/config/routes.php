<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['home.html'] = 'main/home';
$route['addpage.html'] = 'main/addpage';
$route['viewmaindata.html/(:any)'] = 'main/viewMainData/$1';
// $route['reportview.html/(:any)'] = 'main/report_viewMainData/$1';







// Machine zone page
$route['setting.html'] = 'main/machine';

// Setting class
$route['setting_main.html'] = 'main/setting';

// Graph Page
$route['dashboard.html']= 'main/graph/graphPage';
$route['graphRunscreen.html']= 'main/graph/graphRunscreenPage';
