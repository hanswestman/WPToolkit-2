<?php

class MetaBoxText extends MetaBoxBase {
	
	var $defaults = array(
		'type' => 'text',
		'label' => '',
		'description' => '',
		'placeholder' => '',
		'classes' => array('wpt-input-text'),
		'style' => '',
		'default' => '',
		'multiple' => false,
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
		/*if($this->IsMultiple()){
			$values = unserialize($this->inputValue);
			
			$numberOfBoxes = (count($values) > $this->settings['multiple_min']) ? count($values) : $this->settings['multiple_min'];
			
			for($i = 0; $i < $numberOfBoxes; $i++){
				echo('<div class="wpt-muliple-input">');
				$newAttributes = $this->attributes;
				$newAttributes['name'] .= '[]';
				$newAttributes['value'] = (empty($values[$i])) ? '' : $values[$i];
				echo('<input' . $this->BuildAttributes($newAttributes) . '>');
				echo('<a href="#" class="wpt-multiple-input-remove">&times;</a>');
				echo('</div>');
			}
			
			echo('<a href="#" class="wpt-muliple-input-add-more">Add more</a>');
		}*/
		//else {
			echo('<input' . $this->BuildAttributes($this->attributes) . '>');
		//}
		//TODO: Ge alla multiples en wrapper.
		//TODO: Räkna min antal, loopa ut så många, finns bara en så ska knappen vara dold.

		
		$this->RenderDescription($this->settings['description']);
		$this->RenderWrapperEnd();
	}
	
}

?>
