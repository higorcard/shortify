<?php
	session_start();

  header('Content-Type: application/json');

	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Link.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->link_id && $data->short_code) {
		$link_id = filter_var($data->link_id, FILTER_SANITIZE_NUMBER_INT);
		$short_code = urlencode(filter_var($data->short_code, FILTER_SANITIZE_SPECIAL_CHARS));
		
		$result = Link::edit($user_id, $link_id, $short_code);
		
		echo json_encode($result);
	}
