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
define('WPT_PATH_LANGUAGES', basename(WPT_PATH_ROOT) . '/languages/');
define('WPT_PATH_MODULES', WPT_PATH_ROOT . '/modules/');
define('WPT_PATH_TEMPLATES', WPT_PATH_ROOT . '/templates/');
define('WPT_ASSETS_URL', plugins_url('assets/' , __FILE__ ));

/**
 * Callback function to load class files which are missing.
 * @param string $class
 */
function wpt2_autoload($class){
	$file = WPT_PATH_MODULES . $class . '.class.php';
	if(file_exists($file)){
		include_once($file);
	}
}

spl_autoload_register('wpt2_autoload');
load_plugin_textdomain(WPT_TEXTDOMAIN, false, WPT_PATH_LANGUAGES);

/**
 * Base class for WP Toolkit 2
 * @package WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */
class WPT2Class {

	var $loadedModules = array();
	
	public function __construct(){
		add_action('admin_menu', array(&$this, 'RegisterMenuPages'));
	}
	
	/**
	 * WP Callback function that registers a new menu page in the admin panel.
	 */
	function RegisterMenuPages(){
		add_menu_page('WPToolkit', 'WPToolkit 2', 'add_users', 'wptoolkit2', array(&$this, 'PrintBasePage'), WPT_ASSETS_URL . 'img/admin-icon.png'); 
	}
	
	/**
	 * WP Callback function that renders the base admin page.
	 */
	function PrintBasePage(){
		extract(array(
			'modules' => $this->loadedModules,
		));
		include_once(WPT_PATH_TEMPLATES . 'admin-base.php');
	}
	
	/**
	 * Module Registration Module. Modules call this when initiating. Not critical but it's nice to se which modules are running.
	 * @param string $name
	 * @param string $version
	 * @param string $author
	 * @param string $description
	 */
	function RegisterModule($name, $version, $author = '', $description = ''){
		if(empty($this->loadedModules[$name])){
			$this->loadedModules[$name] = array(
				'version' => $version,
				'author' => $author,
				'description' => $description,
			);
		}
	}
}

/**
 * Simple function that returns the base class instance. It can also be used in if-statements to check if the plugin is loaded or not.
 * @global WPT2Class $WPT2ClassInstance
 * @return \WPT2Class
 */
function WPT2(){
	global $WPT2ClassInstance;
	if(empty($WPT2ClassInstance)){
		$WPT2ClassInstance = new WPT2Class();
	}
	return $WPT2ClassInstance;
}

global $WPT2ClassInstance;
$WPT2ClassInstance = new WPT2Class();

?>
