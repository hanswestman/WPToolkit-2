<?php

abstract class MetaBoxBase {

	var $post;
	var $inputName;
	var $metaName;
	var $fieldSettings;
	var $inputValue;
	var $settings;
	
	function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->post_id = $post_id;
		$this->inputName = $inputName;
		$this->metaName = $metaName;
		$this->fieldSettings = $fieldSettings;
		$this->inputValue = $inputValue;
	}
	
	function Render(){
		
	}
	
	function Save(){
		if(isset($_POST[$this->inputName])){
			if(!empty($this->inputValue)){
				if(empty($_POST[$this->inputName])){
					delete_post_meta($this->post_id, $this->metaName);
				}
				else {
					update_post_meta($this->post_id, $this->metaName, $_POST[$this->inputName], $this->inputValue);
				}
			}
			else {
				add_post_meta($this->post_id, $this->metaName, $_POST[$this->inputName]);
			}
		}
	}
	
	function SetDefaults($defaults, $newSettings){
		$settings = array();
		foreach($defaults as $key => $value){
			if(isset($newSettings[$key]) && is_array($value) && is_array($newSettings[$key])){
				$settings[$key] = array_merge($value, $newSettings[$key]);
			}
			else {
				$settings[$key] = (empty($newSettings[$key])) ? $value : $newSettings[$key];
			}
		}
		return $settings;
	}
	
	function BuildAttributes($attributes = array()){
		$attrStrings = array();
		if(!empty($attributes)){
			foreach($attributes as $attr => $value){
				$attrStrings[] = ' ' . $attr . '="' . $value . '"';
			}
		}
		return implode('', $attrStrings);
	}
	
	function RenderWrapperStart(){
		echo('<div>');
		if($this->IsMultiple()){
			echo('<div class="wpt-multiple-input-container" data-min-inputs="' . $this->settings['multiple_min'] . '" data-max-inputs="' . $this->settings['multiple_max'] . '">');
		}
	}
	
	function RenderWrapperEnd(){
		if($this->IsMultiple()){
			echo('</div>');
		}
		echo('</div>');
	}
	
	function RenderDescription($description){
		if(!empty($description)){
			echo('<p class="wpt-input-description"><i>' . $description . '</i></p>');
		}
	}
	
	function RenderLabel($label){
		if(!empty($label)){
			echo('<label for="' . $this->inputName . '"><strong>' . $label . '</strong></label><br>');
		}
	}
	
	function IsMultiple(){
		return (isset($this->settings['multiple']) && $this->settings['multiple'] === true);
	}
	
}

?>
