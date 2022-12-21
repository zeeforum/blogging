<?php
	class Admin extends Database {

		public function getUserByUsername($username) {
			$row = null;
			$query = 'SELECT * FROM admin WHERE email=?';
			if ($this->select($query, [$username])) {
				$row = $this->fetch_row();
			}

			return $row;
		}

		public function getUserById($id) {
			return $this->row('admin', $id);
		}
		
	}