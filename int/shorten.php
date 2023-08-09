<?php
  header('Content-Type: application/json');

	require_once 'config.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->url) {
		$short_code = substr(uniqid(), -6, 6);	

		$sql = $pdo->prepare("SELECT count(id) count FROM links WHERE short_code = :s_c");
		$sql->bindValue(':s_c', $short_code);
		$sql->execute();

		$links_total = $sql->fetch(PDO::FETCH_ASSOC)['count'];

		if($links_total == 0) {
			$sql = $pdo->prepare("INSERT INTO links (original_url, short_code) VALUES (:o_r, :s_c)");
			$sql->bindValue(':o_r', $data->url);
			$sql->bindValue(':s_c', $short_code);
			$sql->execute();

			if($sql->rowCount() > 0) {
				echo json_encode($short_code);
			}
		}
	}
