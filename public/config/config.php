<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Paths
define('FNY_PUBLIC_PATH', realpath(dirname(__FILE__).'/../').'/');
define('FNY_PAGES_PATH', FNY_PUBLIC_PATH.'pages/');
define('FNY_IMAGES_PATH', FNY_PUBLIC_PATH.'images/');
define('FNY_AJAX_PATH', FNY_PUBLIC_PATH.'ajax/');

define('FNY_CSS_PATH', FNY_PUBLIC_PATH.'css/');
define('FNY_JS_PATH', FNY_PUBLIC_PATH.'js/');

// URLs
define('FNY_PUBLIC_URL', plugins_url('', dirname(__FILE__)).'/');
define('FNY_IMAGES_URL', FNY_PUBLIC_URL.'images/');
