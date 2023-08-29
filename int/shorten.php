<?php
	session_start();

  header('Content-Type: application/json');

	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Link.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->url) {
		$url = filter_var($data->url, FILTER_SANITIZE_SPECIAL_CHARS);
		$short_code = substr(uniqid(), -6, 6);

		if(Link::shorten($user_id, $url, $short_code)) {
			echo json_encode($short_code);
		}
	}
