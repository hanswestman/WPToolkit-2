<?php

/**
 * Abstract class that can be used to extend normal modules with extra automatic functionality.
 * @package WP Toolkit 2
 * @author Hans Westman <hans@thefarm.se>
 */
abstract class ModuleBase {

	var $name = '';
	var $version = '';
	var $author = '';
	var $description = '';
	var $helpfile;

	function __construct(){
		
		WPT2()->RegisterModule($this->name, $this->version, $this->author, $this->description);

	}

}

?>