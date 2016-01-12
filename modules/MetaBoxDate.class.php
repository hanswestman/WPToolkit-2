<?php

class MetaBoxDate extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'date',
		'label' => '',
		'description' => '',
		'placeholder' => '',
		'classes' => array('wpt-datepicker'),
		'style' => '',
		'default' => '',
		'format' => 'yy-mm-dd', //http://api.jqueryui.com/datepicker/#option-dateFormat
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
			'data-format' => $this->settings['format'],
		);
	}
	
	public function Render(){
		$this->RenderWrapperStart();
		$this->RenderLabel($this->settings['label']);

		echo('<input' . $this->BuildAttributes($this->attributes) . '>');
		
		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>
