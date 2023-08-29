<?php
	session_start();

  header('Content-Type: application/json');

	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Redirect.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->link_code) {
		$short_code = filter_var($data->link_code, FILTER_SANITIZE_SPECIAL_CHARS);

		$link = DB::raw("SELECT * FROM links WHERE short_code = :s_c AND (user_id = :u_i OR user_id IS NULL)", [
			's_c' => $short_code,
			'u_i' => $user_id,
		])->fetch(PDO::FETCH_ASSOC);
		
		if($link) {
			$redirects = Redirect::getAll($link['id']);

			$link['redirects_total'] = count($redirects);
			$link['created_at'] = date('M d, Y - H:i', strtotime($link['created_at']));

			foreach($redirects as $redirect) {
				$link['redirects'][] = [date('H:i', strtotime($redirect['redirected_at'])), date('M d, Y', strtotime($redirect['redirected_at']))];
			}

			echo json_encode($link);
		}
	}
