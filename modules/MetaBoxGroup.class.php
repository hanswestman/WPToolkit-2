<?php

class MetaBoxGroup extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'group',
		'fields' => array(),
		'description' => '',
		'label' => '',
		'classes' => array('wpt-input-text'),
		'style' => '',
		'multiple' => 'false',
		'multiple_min' => 1,
		'multiple_max' => -1,
	); 
	
	var $settings;
	var $attributes;
	var $fields = array();
	
	public function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->defaults['name'] = $inputName;
		$this->settings = $this->SetDefaults($this->defaults, $fieldSettings);

		$inputValue = unserialize($inputValue);
		
		parent::__construct($post_id, $inputName, $metaName, $fieldSettings, $inputValue);
		
		$this->attributes = array(
			'class' => implode(' ', $this->settings['classes']),
			'style' => $this->settings['style'],
		);
		
		if(!empty($this->settings['fields'])){
			foreach($this->settings['fields'] as $fieldName => $field){
				$className = MetaBox::GetClassName($field['type']);
				$name = $this->inputName . $fieldName;
				$input = new $className($post_id, $name, $fieldName, $field, (empty($inputValue[$fieldName])) ? null : $inputValue[$fieldName]);
				$this->fields[] = $input;
			}
		}
	}
	
	public function Render(){
		$this->RenderWrapperStart();
		
		
		echo('<fieldset' . $this->BuildAttributes($this->attributes) . '>');
			if(!empty($this->settings['label'])){
				echo('<legend>' . $this->settings['label'] . '</legend>');
			}
		
			if(!empty($this->fields)){
				foreach($this->fields as $field){
					$field->Render();
				}
			}
		
		echo('</fieldset>');
		if(!empty($this->settings['description'])){
			$this->RenderDescription($this->settings['description']);
		}
		$this->RenderWrapperEnd();
	}

	function Save(){
		$saveThisGroup = false;
		$saveValue = array();
		if(!empty($this->fields)){
			foreach($this->fields as $field){
				if(!empty($_POST[$field->inputName])){
					$saveThisGroup = true;
				}
				$saveValue[$field->metaName] = $_POST[$field->inputName];
			}
		}
		
		if($saveThisGroup === true){
			if(empty($this->inputValue)){
				add_post_meta($this->post_id, $this->metaName, $saveValue);
			}
			else {
				update_post_meta($this->post_id, $this->metaName, $saveValue);
			}
		}
		else {
			if(!empty($this->inputValue)){
				delete_post_meta($this->post_id, $this->metaName);
			}
		}
		
	}
	
}

?>
