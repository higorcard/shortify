<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Link.php';

	if(!empty($user_id)) {
		$result = Link::getAll($user_id);

		echo json_encode($result);
	}
