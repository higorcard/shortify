<?php
  header('Content-Type: application/json');

	require_once 'config.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->link_code) {
		$short_code = filter_var($data->link_code, FILTER_SANITIZE_SPECIAL_CHARS);

		$sql = $pdo->prepare("SELECT * FROM links WHERE short_code = :s_c");
		$sql->bindValue(':s_c', $short_code);
		$sql->execute();

		$link = $sql->fetch(PDO::FETCH_ASSOC);
		
		if($sql->rowCount() > 0) {
			$sql = $pdo->prepare("SELECT * FROM redirects WHERE link_id = :l_i ORDER BY redirects.redirected_at DESC");
			$sql->bindValue(':l_i', $link['id']);
			$sql->execute();

			$redirects = $sql->fetchAll(PDO::FETCH_ASSOC);

			$link['redirectsTotal'] = count($redirects);
			$link['created_at'] = date('M d, Y - H:i', strtotime($link['created_at']));

			foreach($redirects as $redirect) {
				$link['redirects'][] = [date('H:i', strtotime($redirect['redirected_at'])), date('M d, Y', strtotime($redirect['redirected_at']))];
			}

			echo json_encode($link);
		}
	}