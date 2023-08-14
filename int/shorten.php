<?php
	session_start();

  header('Content-Type: application/json');

	require_once 'config.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->url) {
		$user_id = $_SESSION['user_id'];
		$url = filter_var($data->url, FILTER_SANITIZE_SPECIAL_CHARS);
		$short_code = substr(uniqid(), -6, 6);	

		$sql = $pdo->prepare("SELECT * FROM links WHERE short_code = :s_c");
		$sql->bindValue(':s_c', $short_code);
		$sql->execute();

		if($sql->rowCount() == 0) {
			$sql = $pdo->prepare("INSERT INTO links (user_id, original_url, short_code) VALUES (:u_i, :o_r, :s_c)");
			$sql->bindValue(':u_i', $user_id);
			$sql->bindValue(':o_r', $url);
			$sql->bindValue(':s_c', $short_code);
			$sql->execute();

			if($sql->rowCount() > 0) {
				echo json_encode($short_code);
			}
		}
	}
