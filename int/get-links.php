<?php
	session_start();
	
	require_once 'config.php';

	$user_id = $_SESSION['user_id'];

	if(!empty($user_id)) {
		$sql = $pdo->prepare("SELECT * FROM links WHERE user_id = :u_i ORDER BY links.created_at DESC");
		$sql->bindValue(':u_i', $user_id);
		$sql->execute();

		$links = $sql->fetchAll(PDO::FETCH_ASSOC);

		if($sql->rowCount() > 0) {
			foreach($links as $link) {
				$sql = $pdo->prepare("SELECT count(id) count FROM redirects WHERE link_id = :l_i");
				$sql->bindValue(':l_i', $link['id']);
				$sql->execute();

				$link['redirects'] = $sql->fetch(PDO::FETCH_ASSOC)['count'];
				$new_links[] = $link;
			}

			echo json_encode($new_links);
		} else {
			echo json_encode('empty');
		}
	}
