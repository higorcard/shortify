<?php
  $database = (object) [
		'dbname' => 'DB_NAME',
		'host' => 'HOSTNAME',
		'username' => 'USERNAME',
		'password' => 'PASSWORD',
	];

	try {
		$pdo = new PDO("mysql:dbname=$database->dbname;host=$database->host", $database->username, $database->password);
	} catch(Exception $error) {
		echo $error->getMessage();
	}
