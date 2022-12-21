<?php
	include('../includes/config.php');

	$obj_db = load_class('Database');
	$obj_admin = load_model('Admin');
	$obj_auth = load_class('Auth');



	$authenticationPages = [
		'login.php',
		'forgot-password.php',
		'reset-password.php',
	];


	$user = $obj_auth->get_loggedin_user();

	// For authenticated users
	if ($user && in_array(CURRENT_FILENAME, $authenticationPages)) {
		redirect_header(ADMIN_URL . 'index.php');
	}

	// For non authenticated users
	if (!$user && !in_array(CURRENT_FILENAME, $authenticationPages)) {
		redirect_header(ADMIN_URL . 'login.php');
	}