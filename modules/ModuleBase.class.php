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

	function __construct(){
		
		WPT2()->RegisterModule($this->name, $this->version, $this->author, $this->description);

		if($this->helpfile){
			WPT2()->LoadHelp($this->name);
		}

	}

}

?>