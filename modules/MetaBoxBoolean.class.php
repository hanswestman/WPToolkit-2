<?php

class MetaBoxBoolean extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'boolean',
		'label' => '',
		'description' => '',
		'classes' => array('wpt-input-boolean'),
		'default' => 'false',
	); 
	
	var $attributes;
	
	public function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->defaults['name'] = $inputName;
		$this->settings = $this->SetDefaults($this->defaults, $fieldSettings);

		parent::__construct($post_id, $inputName, $metaName, $fieldSettings, $inputValue);
		
		$prefilledValue = empty($inputValue) ? $this->settings['default'] : $inputValue;
		$this->attributes = array(
			'class' => implode(' ', $this->settings['classes']),
			'type' => 'checkbox',
			'name' => $inputName,
			'id' => $inputName,
			'value' => 'true',
		);

		if($prefilledValue == 'true'){
			$this->attributes['checked'] = 'checked';
		}
	}
	
	public function Render(){
		$this->RenderWrapperStart();
		echo('<input type="hidden" name="' . $this->attributes['name'] . '" value="false">');
		echo('<label><input' . $this->BuildAttributes($this->attributes) . '> ' . $this->settings['label'] . '</label>');

		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>
