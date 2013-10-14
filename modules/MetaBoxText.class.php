<?php

class MetaBoxText extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'text',
		'name' => '',
		'label' => '',
		'description' => '',
		'placeholder' => '',
		'classes' => array('wpt-input-text'),
		'style' => '',
		'default' => '',
		'multiple' => 'false',
		'multiple_min' => 1,
		'multiple_max' => -1,
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
			'type' => 'text',
			'name' => $inputName,
			'id' => $inputName,
		);
	}
	
	public function Render(){
		$this->RenderWrapperStart();
		$this->RenderLabel($this->settings['label']);
		
		//TODO: Ge alla multiples en wrapper.
		//TODO: Räkna min antal, loopa ut så många, finns bara en så ska knappen vara dold.
		
		echo('<input' . $this->BuildAttributes($this->attributes) . '>');
		
		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>
