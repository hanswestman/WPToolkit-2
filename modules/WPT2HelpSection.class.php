<?php

/**
 * Help File
 * @package  WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */

class WPT2HelpSection extends ModuleBase {

	var $name = 'Help Section';
	var $version = '1.0';
	var $author = '<a href="http://hanswestman.se" target="_blank">Hans Westman</a>';
	var $description = 'Adds a help section to the admin panel.';

	var $sections = array();

	function __construct($settings = array()){
		add_action('admin_menu', array(&$this, 'addMenuPage'));

		if(is_admin()){
			//$ajaxAPI = new AjaxAPI();
		}

		//Only admin
		//TODO: Enqueue script for frontend.
		//TODO: Activate AjaxAPI to supply frontend with html content.
		parent::__construct();
	}

	public function add($name){
		$this->sections[] = $name;
	}

	public function addMenuPage(){
		add_submenu_page(
			WPT_MENU_SLUG, 
			__('Help Section', WPT_TEXTDOMAIN),
			__('Help Section', WPT_TEXTDOMAIN),
			'add_users', 
			'help-section', 
			array(&$this, 'renderMenuPage')
		);
	}

	public function renderMenuPage(){
		$sections = $this->sections;
		

		include_once(WPT_PATH_TEMPLATES . 'help-section-base.php');
	}
}

?>