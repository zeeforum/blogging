<?php
	class Database {

		private static $conn = null;
		private $mysqli_result;
		private $mysqli_stmt;

		function __construct()
		{
			if (self::$conn) {
				return self::$conn;
			}

			try {
				self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
			} catch (Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}

		function query($query) {
			$this->mysqli_result = self::$conn->query($query);

			return $this->mysqli_result;
		}

		function select($query, $params = []) {
			try {
				$this->mysqli_stmt = self::$conn->prepare($query);
				if ($this->mysqli_stmt->param_count !== count($params)) {
					throw new Exception('Number of variables doesn\'t match number of parameters in prepared statement.');
				}

				$this->mysqli_stmt->bind_param(str_repeat('s', count($params)), ...$params);
				$this->mysqli_stmt->execute();

				$this->mysqli_result = $this->mysqli_stmt->get_result();
			} catch (Exception $e) {
				print_r($e->getMessage());
				exit();
			}

			return $this->mysqli_result;
		}

		function fetch_row() {
			return $this->mysqli_result->fetch_assoc();
		}

		function fetch_all() {
			return $this->mysqli_result->fetch_all(MYSQLI_ASSOC);
		}

		function fetch_assoc() {
			return $this->mysqli_result->fetch_all(MYSQLI_ASSOC);
		}

		function fetch_array() {
			return $this->mysqli_result->fetch_all(MYSQLI_NUM);
		}

		function row($tableName, $id) {
			$this->select('SELECT * FROM ' . $tableName . ' WHERE id=?', [$id]);
			return $this->fetch_row();
		}

	}