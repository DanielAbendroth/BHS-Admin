<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "admin/admin";
$route['404_override'] = '';
$route['dashboard'] = 'admin';
$route['files'] = 'admin/files';
$route['employees'] = 'admin/employees';
$route['etts'] = 'admin/etts';
$route['etts/'] = 'admin/etts';
$route['etts/phase/(:num)'] = 'admin/etts/phase';
$route['etts/phase/(:num)/(:num)'] = 'admin/etts/phase';
$route['etts/phase/structure/(:num)'] = 'admin/etts/structure';
$route['etts/phase/rundown/(:num)'] = 'admin/etts/rundown';
$route['etts/create/section/(:num)'] = 'admin/etts/create_section';
$route['etts/add/field/(:num)/(:num)'] = 'admin/etts/add_field';
$route['etts/delete/section/(:num)'] = 'admin/etts/delete_section';
$route['etts/delete/section/(:num)/confirm'] = 'admin/etts/delete_section';
$route['etts/edit/field/(:num)/(:num)/(:num)'] = 'admin/etts/edit_field';
$route['etts/add/task/(:num)/(:num)'] = 'admin/etts/add_task';
$route['etts/approval/(:num)'] = 'admin/etts/approval';
$route['etts/rejection/(:num)'] = 'admin/etts/rejection';
$route['etts/phase_approval/(:num)/(:any)'] = 'admin/etts/phase_approval';
$route['etts/phase_rejection/(:num)/(:any)'] = 'admin/etts/phase_rejection';
$route['login'] = 'admin/session/login';
$route['logout'] = 'admin/session/logout';

/* End of file routes.php */
/* Location: ./application/config/routes.php */