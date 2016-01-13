<?php

class MetaBoxRadio extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'radio',
		'label' => '',
		'description' => '',
		'classes' => array('wpt-input-radio'),
		'default' => '',
		'options' => array(),
		'layout' => 'vertical', //horisontal / vertical
	); 
	
	var $attributes;
	var $prefilledValue;
	
	public function __construct(&$post_id, $inputName, $metaName, $fieldSettings, $inputValue){
		$this->defaults['name'] = $inputName;
		$this->settings = $this->SetDefaults($this->defaults, $fieldSettings);

		parent::__construct($post_id, $inputName, $metaName, $fieldSettings, $inputValue);
		
		$this->attributes = array(
			'class' => implode(' ', $this->settings['classes']),
			'name' => $inputName,
			'type' => 'radio',
		);

		$this->prefilledValue = empty($inputValue) ? $this->settings['default'] : $inputValue;
	}

	public function Render(){
		$this->RenderWrapperStart();
		$this->RenderLabel($this->settings['label']);

		foreach($this->settings['options'] as $option){
			$value = is_array($option) ? $option[0] : $option;
			$label = is_array($option) ? $option[1] : $option;

			$optionAttrs = $this->attributes;
			$optionAttrs['value'] = $value;
			if($this->prefilledValue == $value){
				$optionAttrs['checked'] = 'checked';
			}

			$layout = $this->settings['layout'] == 'vertical' ? 'vertical' : 'horisontal';

			printf('<label class="%s"><input %s>%s</label>', $layout,  $this->BuildAttributes($optionAttrs), $label);
		}



		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>