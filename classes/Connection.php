<?php
	abstract class Connection
	{
		private $dbname;
		private $host;
		private $username;
		private $password;
		protected $connection;

		protected function __construct()
		{
			$this->dbname = 'shortify';
			$this->host = 'mysql';
			$this->username = 'root';
			$this->password = 'shortify_db_pass';

			$this->connection = new PDO("mysql:dbname=$this->dbname;host=$this->host", $this->username, $this->password);
		}
	}
