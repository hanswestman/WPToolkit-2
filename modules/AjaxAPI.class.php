<?php

/**
 * Ajax API
 * @package  WP Toolkit 2
 * @author Hans Westman <hanswestman@gmail.com>
 */

class AjaxAPI extends ModuleBase {

	var $name = 'AjaxAPI';
	var $version = '1.5';
	var $author = '<a href="http://hanswestman.se" target="_blank">Hans Westman</a>';
	var $description = 'Centralizes AJAX calls. Makes PHP functions callable from frontend by AJAX.';
	var $helpfile = true;

	var $settings = array(
		'allowJSONP' => false,
		'callbackPrefix' => 'ajax',
	);

	function __construct($settings = array()){
		if(!empty($settings) && is_array($settings)){
			foreach($settings as $setting => $value){
				if(isset($this->settings[$setting])){
					$this->settings[$setting] = $value;
				}
			}
		}

		add_action('wp_ajax_AjaxAPI', array(&$this, 'Run'));
		add_action('wp_ajax_nopriv_AjaxAPI', array(&$this, 'Run'));
		add_action('wp_head', array(&$this, 'PrintAjaxUrl'));
		add_action('admin_head', array(&$this, 'PrintAjaxUrl')); 

		parent::__construct();
	}

	/**
	 * Parses Ajax-calls made with action=AjaxAPI and calls a callback function
	 * Requires GET/POST-argument "command" or "command_class" and "command".
	 */
	function Run(){
		if(empty($_REQUEST['command'])){
			AjaxAPI::ReturnError(__('Missing argument "command"'));
		} else if (strpos($_REQUEST['command'], $this->settings['callbackPrefix']) === false) {
			AjaxAPI::ReturnError(__('The command is not matching with the required prefix'));
		} else{
			if(function_exists($_REQUEST['command'])){
				call_user_func_array($_REQUEST['command'], array());
			}
			elseif(!empty($_REQUEST['command_class'])){
				if(class_exists($_REQUEST['command_class']) && method_exists($_REQUEST['command_class'], $_REQUEST['command'])){
					call_user_func_array(array($_REQUEST['command_class'], $_REQUEST['command']), array());
				} else{
					AjaxAPI::ReturnError(__('The command does not exist as a method', WPT_TEXTDOMAIN));
				}
			} else{
				AjaxAPI::ReturnError(__('The command does not exist', WPT_TEXTDOMAIN));
			}
		}
	}


	/**
	 * Public function to return JSON formatted data. Returns status (true/false), data and maybe message.
	 * @param boolean $status
	 * @param array/string $data
	 * @param string $message
	 */
	public function ReturnJSON($status = true, $data = array(), $message = ''){
		header('content-type: application/json; charset=utf-8');

		if($this->settings['allowJSONP'] === true && !empty($_REQUEST['callback'])){
			echo($_REQUEST['callback'] . '(');
		}

		if(empty($message)){
			echo(json_encode(array('status'=>$status, 'data'=>$data)));
		} else{
			echo(json_encode(array('status'=>$status, 'data'=>$data, 'message' => $message)));
		}

		if($this->settings['allowJSONP'] === true && !empty($_REQUEST['callback'])){
			echo(')');	
		}

		die();
	}

	/**
	 * Returns a JSON formatted error message, It's a shortcut to AjaxAPI::ReturnJSON()
	 * @param string $message Error message.
	 */
	public function ReturnError($message){
		AjaxAPI::ReturnJSON(false, false, $message);
	}

	/**
	 * Helpful function that prints the Ajax URL in <HEAD> for later use.
	 */
	public function PrintAjaxUrl(){
		echo("\n\n<script type=\"text/javascript\">\n\n\nwindow.wptoolkit = {ajaxUrl: '" . get_site_url() . "/wp-admin/admin-ajax.php'};\n\n</script>");
	}

}
?>