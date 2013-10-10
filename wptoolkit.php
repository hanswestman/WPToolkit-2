<?php
/**
 * Plugin Name: WP Toolkit 2
 * Plugin URI: https://github.com/hanswestman/WPToolkit-2
 * Description: A collection of tools to ease the development of plugins and themes.
 * Author: Hans Westman
 * Author URI: http://hanswestman.se
 * Version: 0.1
 * License: MIT
 */

define('WPT_VERSION', '0.1');
define('WPT_TEXTDOMAIN', 'wpt2');
define('WPT_PATH_ROOT', dirname(__FILE__));
define('WPT_PATH_LANGUAGES', WPT_PATH_ROOT . '/languages/');
define('WPT_PATH_MODULES', WPT_PATH_ROOT . '/modules/');

load_plugin_textdomain(WPT_TEXTDOMAIN, false, WPT_PATH_LANGUAGES);

function wpt2_autoload($class){
	$file = WPT_PATH_MODULES . $class . '/' . $class . '.class.php';
	if(file_exists($file)){
		include_once($file);
	}
}

spl_autoload_register('wpt2_autoload');

?>
