<?php
	session_start();

  header('Content-Type: application/json');

	require_once 'config.php';

	$data = json_decode(file_get_contents('php://input'));

	if($data->link_id) {
		$user_id = $_SESSION['user_id'];
		$link_id = filter_var($data->link_id, FILTER_SANITIZE_NUMBER_INT);

		$sql = $pdo->prepare("DELETE FROM links WHERE id = :l_i AND user_id = :u_i");
		$sql->bindValue(':l_i', $link_id);
		$sql->bindValue(':u_i', $user_id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			echo json_encode('success');
		}
	}
