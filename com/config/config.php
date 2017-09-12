<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Paths
define('FNY_APP_PATH', realpath(dirname(__FILE__).'/../').'/');
define('FNY_CONFIG_PATH', FNY_APP_PATH.'config/');
define('FNY_CORE_PATH', FNY_APP_PATH.'core/');

define('FNY_SHAREBUTTON_TABLE_NAME', 'fny_sharebuttons');
define('FNY_DEFAULT_BUTTONS_POSITION', 'fny-upleft');
