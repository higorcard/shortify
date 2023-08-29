<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Link.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Redirect.php';

	if($_GET['link_code']) {
		$short_code = urlencode(filter_input(INPUT_GET, 'link_code', FILTER_SANITIZE_SPECIAL_CHARS));
		$owner = filter_input(INPUT_GET, 'owner', FILTER_SANITIZE_SPECIAL_CHARS);
		
		if($owner) {
			$link = DB::table('links')->where('owner', '=', $owner)->where('short_code', '=', $short_code)->get()[0];
		} else {
			$link = DB::raw("SELECT * FROM links WHERE owner IS NULL AND short_code = :short_code", ['short_code' => $short_code])->fetch(PDO::FETCH_ASSOC);
		}

		if($link) {
			Redirect::add($link['id']);

			header('Location: ' . $link['original_url']);
		} else {
			header('Location: ../');
		}
	}
