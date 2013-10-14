<?php

/**
 * Creates metaboxes with various input types
 * @package  WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */

class MetaBox extends ModuleBase {

	var $name = 'Metabox';
	var $version = '2.1';
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
		//TODO: add_action('delete_post', array(&$this, 'DeleteMetaValues'));
		add_action('admin_enqueue_scripts', array(&$this, 'EnqueueScripts'));

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
					$input = new $className($post_id, $inputName, $metaName, $metaField, empty($metaData[$metaName]) ? null : $metaData[$metaName]);
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
	
	function EnqueueScripts(){
		wp_enqueue_script('wpt-admin', WPT_ASSETS_URL . 'js/src/admin-addmore.js', array('jquery'), '1.0', true);
		//wp_enqueue_style('WPToolkitMetabox-css', WPT_ASSETS_URL . 'css/WPToolkitMetaBox.css', false, '1.0');

		$screen = get_current_screen();
		if(!empty($screen->post_type)){
			$activePostType = $screen->post_type;
			if(!empty($this->config[$activePostType])){
				foreach($this->config[$activePostType] as $metabox){
					if(!empty($metabox)){
						foreach($metabox as $fields){
							switch($fields['type']){
								case 'colorpicker':
									wp_enqueue_script('wp-color-picker');
									wp_enqueue_style('wp-color-picker');
									break;
								case 'date':
									wp_enqueue_script('jquery-ui-datepicker');	
									wp_enqueue_style('jquery-ui-lightness', WPT_ASSETS_URL . 'css/ui-lightness/jquery-ui-1.10.3.custom.min.css', array(), '1.10.3');
									break;
							}
						}
					}
				}
			}
		}
	}
}
?>
