<?php

class MetaBoxSelect extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'select',
		'label' => '',
		'description' => '',
		'placeholder' => '',
		'classes' => array('wpt-input-select'),
		'style' => '',
		'default' => '',
		'options' => array(),
	); 
	
	var $attributes;
	
	public function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->defaults['name'] = $inputName;
		$this->settings = $this->SetDefaults($this->defaults, $fieldSettings);

		parent::__construct($post_id, $inputName, $metaName, $fieldSettings, $inputValue);
		
		$this->attributes = array(
			'class' => implode(' ', $this->settings['classes']),
			'style' => $this->settings['style'],
			'value' => empty($inputValue) ? $this->settings['default'] : $inputValue,
			'placeholder' => $this->settings['placeholder'],
			'name' => $inputName,
			'id' => $inputName,
		);
	}

	public function Render(){
		$this->RenderWrapperStart();
		$this->RenderLabel($this->settings['label']);

		echo('<select' . $this->BuildAttributes($this->attributes) . '>');
		foreach($this->settings['options'] as $option){
			$value = is_array($option) ? $option[0] : $option;
			$label = is_array($option) ? $option[1] : $option;
			printf('<option value="%s">%s</option>', $value, $label);
		}
		echo('</select>');

		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>
