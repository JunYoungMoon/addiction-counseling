<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Board::boardListView/1');
$routes->get('/(:num)', 'Board::boardListView/$1');

$routes->get('login', 'User::loginView');
$routes->get('logout', 'User::logout');
$routes->get('signUp', 'User::signUpView');
$routes->get('find', 'User::findView');
$routes->get('myInfo', 'User::myInfoView');
$routes->match(['post'],'changeInformation', 'User::changeInformation');
$routes->get('myBoardList/(:num)', 'User::myBoardListView/$1');

$routes->get('throttle', 'Board::throttle');
$routes->get('boardWriteView', 'Board::boardWriteView');
$routes->match(['post'],'boardWriteView/(:num)', 'Board::boardWriteView/$1');
$routes->get('boardView/(:num)', 'Board::boardView/$1');
$routes->get('boardDelete/(:num)', 'Board::boardDelete/$1');
$routes->match(['post'],'boardWrite', 'Board::boardWrite');
$routes->match(['post'],'replyWriteContent', 'Board::replyWriteContent');
$routes->match(['post'],'replyModifyContent', 'Board::replyModifyContent');
$routes->match(['post'],'replyDeleteContent', 'Board::replyDeleteContent');

//임시 저장 
$routes->match(['post'],'setTempContent', 'BoardTemp::setTempContent');
$routes->match(['post'],'getTempList', 'BoardTemp::getTempList');
$routes->match(['post'],'getTempListContent', 'BoardTemp::getTempListContent');
$routes->match(['post'],'getTempDelete', 'BoardTemp::getTempDelete');
$routes->match(['post'],'getTempAllDelete', 'BoardTemp::getTempAllDelete');

$routes->match(['post'],'identityVerification', 'User::identityVerification');
$routes->match(['post'],'idpwSendMail', 'User::idpwSendMail');
$routes->match(['get', 'post'], 'save', 'User::save');
$routes->match(['get', 'post'], 'loginCheck', 'User::loginCheck');
$routes->match(['get'],'overLapCheck', 'User::overLapCheck');

/*$routes->match(['get', 'post'], 'news/create', 'News::create');
$routes->get('news/(:segment)', 'News::view/$1');
$routes->get('list', 'News::index');
$routes->get('(:any)', 'Pages::view/$1');*/
/*$routes->get('save', 'User::Save');*/
/*$routes->get('idCheck', 'User::idCheck/$1');*/

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
