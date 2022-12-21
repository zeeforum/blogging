<?php
	class Auth {

		function authenticate($row, $password) {
			if (password_verify($password, $row['password'])) {
				$this->create_session($row);
				return true;
			}

			return false;
		}

		function create_session($row) {
			$_SESSION[AUTH_SESSION] = $row['id'];
		}

		function get_loggedin_user() {
			if (isset($_SESSION[AUTH_SESSION])) {
				$admin_model = load_model('Admin');
				$userRow = $admin_model->getUserById($_SESSION[AUTH_SESSION]);
				return $userRow;
			}

			return false;
		}

	}