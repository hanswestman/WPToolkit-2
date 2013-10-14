<?php

/**
 * Creates metaboxes with various input types
 * @package  WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */

class MetaBox extends ModuleBase {

	var $name = 'Metabox';
	var $version = '2.0';
	var $author = 'Hans Westman';
	var $description = 'Adds metaboxes with various types of input fields.';

	var $config;

	function __construct($config){
		$this->config = array();
		foreach($config as $posttype => $boxes){
			$this->config[strtolower($posttype)] = $boxes;
		}

		add_action('add_meta_boxes', array(&$this, 'RegisterMetaBoxes'));
		add_action('save_post', array(&$this, 'SaveMetaValues'));
		//add_action('delete_post', array(&$this, 'DeleteMetaValues'));
		//add_action('admin_enqueue_scripts', array(&$this, 'EnqueueScripts'));

		parent::__construct();
	}
	
	/**
	 * Register a meta box
	 */
	function RegisterMetaBoxes(){
		foreach($this->config as $typeName => $type){
			$typeName = strtolower($typeName);
			foreach(array_keys($type) as $section){
				add_meta_box('MetaBox_' . $typeName . '_' . $section, $section, array(&$this, 'ShowMetaBox'), $typeName, 'advanced', 'default', array('type'=>$typeName, 'section'=>$section));
			}
		}
	}
	
	/**
	 * Displays a metabox with all its input types.
	 * @param post-object $post
	 * @param array $args
	 */
	function ShowMetaBox($post, $args){
		$type = $args['args']['type'];
		$section = $args['args']['section'];
		$metaData = self::NormalizeMeta(get_post_meta($post->ID));
		wp_nonce_field(plugin_basename(__FILE__), 'MetaBox_nonce');
		$metaBoxes = $this->config;
		$metas = $metaBoxes[$type][$section];
		foreach($metas as $metaName => $metaField){
			if(isset($metaField['type'])){
				$className = self::GetClassName($metaField['type']);
				$name = $type . '_' . preg_replace('/\s/', '_', $section) . '_' . $metaName;
				$input = new $className($post->ID, $name, $metaName, $metaField, (empty($metaData[$metaName])) ? null : $metaData[$metaName]);
				$input->Render();
			}
		}
	}
	
	
	function SaveMetaValues($post_id){
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return;
		}
		if(empty($_POST['MetaBox_nonce']) || !wp_verify_nonce($_POST['MetaBox_nonce'], plugin_basename(__FILE__))){
			return;
		}
		if(!current_user_can('edit_page', $post_id)){
			return;
		}
		if(function_exists('save_feed')){
			save_feed();
		}
		
		$config = $this->config;
		$metaBox = $config[$_POST['post_type']];
		foreach(array_keys($metaBox) as $section){
			$metas = $config[$_POST['post_type']][$section];
			foreach($metas as $metaName => $metaField){
				if(isset($metaField['type'])){
					$className = self::GetClassName($metaField['type']);
					if(wp_is_post_revision($post_id)){
						$originalPost = get_post($post_id);
						$post_id = $originalPost->post_parent;
					}
					
					$metaData = self::NormalizeMeta(get_post_meta($post_id));
					$inputName = $_POST['post_type'] . '_' . preg_replace('/\s/', '_', $section) . '_' . $metaName;
					$input = new $className($post_id, $inputName, $metaName, $metaField, $metaData[$metaName]);
					$input->Save();
				}
			}
		}
	}
	
	/**
	 * Send in a raw WP metadata array and it returns an array of single values.
	 * @param array $rawMeta
	 * @return array
	 */
	static function NormalizeMeta($rawMeta = array()){
		foreach($rawMeta as $key => $value){
			$rawMeta[$key] = (empty($value[0])) ? $value : $value[0];
		}
		return $rawMeta;
	}
	
	static function GetClassName($inputType){
		return 'MetaBox' . ucfirst($inputType);
	}
}
?>
