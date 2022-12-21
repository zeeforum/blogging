<?php

	// Application URLs
	define('BASE_URL', 'http://blog.test/');
	define('ADMIN_URL', 'http://blog.test/admin/');
	define('ADMIN_ASSET_URL', 'http://blog.test/admin/assets/');

	// Path of the applications
	define('INCLUDE_PATH', __DIR__);

	// Database configurations
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'test');
	define('DB_PORT', 3306);


	// Create Session Variables
	define('AUTH_SESSION', 'admin');



	// File Names
	define('CURRENT_FILENAME', basename($_SERVER['SCRIPT_FILENAME']));



	// For Debugging Informations
	define('DEBUG_ERRORS', true);
	define('SHOW_PASSWORD', false);

	if (DEBUG_ERRORS) {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}

	session_start();

	mysqli_report(MYSQLI_REPORT_STRICT);

	function showError($msg) {
		echo $msg;
		exit();
	}

	// Format Array/Dump Variables
	function preFormat($data = []) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	// Format Array/Dump Variables & Exist
	function dump($data = []) {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
		exit();
	}

	function load_class($className) {
		static $_class;

		if (isset($_class[$className])) {
			return $_class[$className];
		}

		$filePath = INCLUDE_PATH . '/classes/' . strtolower($className) . '.php';
		if (!file_exists($filePath)) {
			return showError('Class: ' . $className . ' does not exist.');
		}

		require_once($filePath);
		
		$_class[$className] = new $className();

		return $_class[$className];
	}

	function load_model($modelName) {
		static $_model;

		if (isset($_model[$modelName])) {
			return $_model[$modelName];
		}

		$filePath = INCLUDE_PATH . '/models/' . strtolower($modelName) . '.php';
		if (!file_exists($filePath)) {
			return showError('Model: ' . $modelName . ' does not exist.');
		}

		require_once($filePath);
		
		$_model[$modelName] = new $modelName();

		return $_model[$modelName];
	}


	function getGet($name) {
		return filter_input(INPUT_GET, $name);
	}

	function getPost($name) {
		return filter_input(INPUT_POST, $name);
	}

	function getRequest($name) {
		return $_REQUEST[$name] ?? '';
	}


	if (!function_exists('redirect_header')) {
		function redirect_header($url) {
			header('location:' . $url);
			exit();
		}
	}

	if (!function_exists('validateVar')) {
		function validateVar($value, $validation = '') {
			if ($validation === '') {
				return $value !== '';
			}

			return filter_var($value, $validation);
		}
	}

	if (!function_exists('printErrorMsg')) {
		function printErrorMsg($msg) {
			if (isset($msg) && $msg != '')
				return '
					<label class="error text-danger font-weight-normal">' . $msg . '</label>
				';

			return '';
		}
	}