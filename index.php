<?php

// Kickstart the framework
$f3=require('lib/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');
$f3->route('GET /', 'UserController->index');
$f3->route('GET /items', 'UserController->items');
$f3->route('GET|POST /item/update/@itemid', 'UserController->update');
$f3->route('GET /item/delete/@itemid', 'UserController->delete');
$f3->route('POST /item/add', 'UserController->add');

//Custom Error Page
$f3->set('ONERROR',function($f3){
	$f3->set('content', 'error.htm');
  echo \Template::instance()->render('layout.htm');
});
$f3->run();
