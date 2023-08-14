<?php
	session_start();

  header('Content-Type: application/json');

	require_once 'config.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->link_id && $data->short_code) {
		$user_id = $_SESSION['user_id'];
		$link_id = filter_var($data->link_id, FILTER_SANITIZE_NUMBER_INT);
		$short_code = urlencode(filter_var($data->short_code, FILTER_SANITIZE_SPECIAL_CHARS));

		$sql = $pdo->prepare("SELECT username FROM users WHERE id = :u_i");
		$sql->bindValue(':u_i', $user_id);
		$sql->execute();

		$username = $sql->fetch(PDO::FETCH_ASSOC)['username'];

		$sql = $pdo->prepare("SELECT * FROM links WHERE short_code = :s_c AND user_id = :u_i");
		$sql->bindValue(':s_c', $short_code);
		$sql->bindValue(':u_i', $user_id);
		$sql->execute();
		
		if($sql->rowCount() == 0) {
			$sql = $pdo->prepare("UPDATE links SET owner = :o, short_code = :s_c WHERE id = :l_i AND user_id = :u_i");
			$sql->bindValue(':o', $username);
			$sql->bindValue(':s_c', $short_code);
			$sql->bindValue(':l_i', $link_id);
			$sql->bindValue(':u_i', $user_id);
			$sql->execute();

			if($sql->rowCount() > 0) {
				echo json_encode('success');
			}
		}
	}
