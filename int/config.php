<?php
  $database = (object) [
		'dbname' => 'shortify',
		'host' => 'mysql',
		'username' => 'root',
		'password' => 'shortify_db_pass',
	];

	try {
		$pdo = new PDO("mysql:dbname=$database->dbname;host=$database->host", $database->username, $database->password);
	} catch(Exception $error) {
		echo $error->getMessage();
	}
