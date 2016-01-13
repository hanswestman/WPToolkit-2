<?php

/**
 * Abstract class that can be used to extend normal modules with extra automatic functionality.
 * @package WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */
abstract class ModuleBase {

	var $name = '';
	var $version = '';
	var $author = '';
	var $description = '';
	var $helpfile = false;
	var $error = false;
	/**
	 * You can set $this->error = true before parent::__construct();
	 * is run in any child module's constructor to display that the 
	 * module has an error of some kind. You can for example check for
	 * compatibility in your constructor and use this to display an error.
	 */

	function __construct(){
		
		WPT2()->RegisterModule($this->name, $this->version, $this->author, $this->description, $this->error);

		if($this->helpfile){
			WPT2()->LoadHelp(get_class($this));
		}

	}

}

?>