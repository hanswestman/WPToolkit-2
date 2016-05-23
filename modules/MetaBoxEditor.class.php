<?php 

class MetaBoxEditor extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'editor',
		'label' => '',
		'description' => '',
		'placeholder' => '',
		'classes' => array('wpt-input-tinymce'),
		'style' => '',
		'default' => '',
	); 
	
	var $previousValue;
	var $attributes;
	
	public function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->defaults['name'] = $inputName;
		$this->settings = $this->SetDefaults($this->defaults, $fieldSettings);
		$this->previousValue = $inputValue;
		parent::__construct($post_id, $inputName, $metaName, $fieldSettings, $inputValue);
		
		$this->attributes = array(
			'class' => implode(' ', $this->settings['classes']),
			'style' => $this->settings['style'],
			'placeholder' => $this->settings['placeholder'],
			'name' => $inputName,
			'id' => $inputName,
		);
	}
	
	public function Render(){
		$this->RenderWrapperStart();
		$this->RenderLabel($this->settings['label']);
		wp_editor(empty($this->previousValue) ? $this->settings['default'] : $this->previousValue, $this->defaults['name'] );

		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

 ?>