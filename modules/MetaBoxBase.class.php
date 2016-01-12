<?php

/**
 * Abstract class that should be extended when adding more input types.
 * @package WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */
abstract class MetaBoxBase {

	var $post;
	var $inputName;
	var $metaName;
	var $fieldSettings;
	var $inputValue;
	var $settings;
	
	/**
	 * The constructor should be called from the child constructor
	 * @param integer $post_id Post ID.
	 * @param string $inputName The name of the form field.
	 * @param string $metaName The name of the meta field.
	 * @param array $fieldSettings Array of settings.
	 * @param string $inputValue Previously saved value.
	 */
	function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->post_id = $post_id;
		$this->inputName = $inputName;
		$this->metaName = $metaName;
		$this->fieldSettings = $fieldSettings;
		$this->inputValue = $inputValue;
	}
	
	function Render(){
		
	}
	
	/**
	 * Basic save callback, saves a single value. Should be used when you're not saving multiples or groups of values.
	 */
	function Save(){
		if(isset($_POST[$this->inputName])){
			$newValue = $_POST[$this->inputName];

			if(is_array($newValue)){
				die('is array');
				$values = array();
				foreach($newValue as $postField){
					if(!Metabox::isEmpty($postField)){
						$values[] = $postField;
					}
				}
				
				$newValue = $values;
			}
			
			if(!Metabox::isEmpty($this->inputValue)){
				if(Metabox::isEmpty($newValue)){
					delete_post_meta($this->post_id, $this->metaName);
				} else {
					update_post_meta($this->post_id, $this->metaName, $newValue);
				}
			} else if(!Metabox::isEmpty($newValue)) {
				add_post_meta($this->post_id, $this->metaName, $newValue);
			}
		}
	}
	
	/**
	 * Extends the default settings with the new settings.
	 * @param array $defaults
	 * @param array $newSettings
	 * @return array
	 */
	function SetDefaults($defaults, $newSettings){
		$settings = array();
		foreach($defaults as $key => $value){
			if(isset($newSettings[$key]) && is_array($value) && is_array($newSettings[$key])){
				$settings[$key] = array_merge($value, $newSettings[$key]);
			} else {
				$settings[$key] = (empty($newSettings[$key])) ? $value : $newSettings[$key];
			}
		}
		return $settings;
	}
	
	/**
	 * Builds array into string of attributes and values in HTML format.
	 * @param array $attributes Associative array of attributes.
	 * @return string
	 */
	function BuildAttributes($attributes = array()){
		$attrStrings = array();
		if(!empty($attributes)){
			foreach($attributes as $attr => $value){
				$attrStrings[] = ' ' . $attr . '="' . $value . '"';
			}
		}
		return implode('', $attrStrings);
	}
	
	/**
	 * Simple function that renders the start of a input field.
	 */
	function RenderWrapperStart(){
		echo('<div>');
	}
	
	/**
	 * Simple function that renders the end of a input field.
	 */
	function RenderWrapperEnd(){
		echo('</div>');
	}
	
	/**
	 * Renders the field description if it exists.
	 * @param string $description
	 */
	function RenderDescription($description){
		if(!empty($description)){
			echo('<p class="wpt-input-description"><i>' . $description . '</i></p>');
		}
	}
	
	/**
	 * Renders the label if it exists.
	 * @param string $label
	 */
	function RenderLabel($label){
		if(!empty($label)){
			echo('<label for="' . $this->inputName . '"><strong>' . $label . '</strong></label><br>');
		}
	}
}

?>
