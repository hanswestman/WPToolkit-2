<?php

/**
 * Class used to register post types with a oneline-command in config.
 * @package WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */
class PostType extends ModuleBase {

	var $name = 'Post Type';
	var $version = '1.1';
	var $author = '<a href="http://hanswestman.se" target="_blank">Hans Westman</a>';
	var $description = 'Makes it easy to add a new custom post type, just one command easy is needed.';

	var $post_type;
	var $name_singular;
	var $name_plural;
	var $options;

	function __construct($post_type, $name_singular, $name_plural, $options = array()){

		$this->name_singular = $name_singular;
		$this->name_plural = $name_plural;
		$this->post_type = $post_type;
		$this->options = array_merge(array(
			'labels' => array(
				'name' => '',
				'singular_name' => ucfirst($name_singular),
				'add_new' => __('Add new', WPT_TEXTDOMAIN),
				'add_new_item' => sprintf(__('Add new %s', WPT_TEXTDOMAIN), $name_singular),
				'edit_item' => sprintf(__('Edit %s', WPT_TEXTDOMAIN), $name_singular),
				'new_item' => sprintf(__('New %s' , WPT_TEXTDOMAIN), $name_singular),
				'all_items' => sprintf(__('All %s', WPT_TEXTDOMAIN), $name_plural),
				'view_item' => sprintf(__('View %s', WPT_TEXTDOMAIN), $name_singular),
				'search_items' => sprintf(__('Search %s', WPT_TEXTDOMAIN), $name_plural),
				'not_found' => sprintf(__('No %s found', WPT_TEXTDOMAIN), $name_plural),
				'not_found_in_trash' => sprintf(__('No %s found in trash', WPT_TEXTDOMAIN), $name_plural),
				'parent_item_colon' => '',
				'menu_name' => ucfirst($name_plural),
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug'=>strtolower($name_singular)
			),
			'capability_type' => 'post',
			'has_archive' => $name_plural,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','excerpt'), //title, editor, author, thumbnail, excerpt, comments
			'taxonomies' => array(),
		), $options);

		add_action('init', array(&$this, 'RegisterPostType'));
		
		parent::__construct();
	}

	/**
	 * Callback function that registers the custom post type.
	 */
	function RegisterPostType(){
		register_post_type(strtolower($this->post_type), $this->options);
	}

}

?>