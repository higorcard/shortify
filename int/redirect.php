<?php
	require_once 'config.php';

	if($_GET['link_code']) {
		$short_code = urlencode(filter_input(INPUT_GET, 'link_code', FILTER_SANITIZE_SPECIAL_CHARS));
		$owner = filter_input(INPUT_GET, 'owner', FILTER_SANITIZE_SPECIAL_CHARS);
		
		if($owner) {	
			$sql = $pdo->prepare("SELECT * FROM links WHERE owner = :o AND short_code = :s_c");
			$sql->bindValue(':o', $owner);
		} else {
			$sql = $pdo->prepare("SELECT * FROM links WHERE owner IS NULL AND short_code = :s_c");
		}
		$sql->bindValue(':s_c', $short_code);
		$sql->execute();

		$link = $sql->fetch(PDO::FETCH_ASSOC);

		if($sql->rowCount() > 0) {
			$sql = $pdo->prepare("INSERT INTO redirects (link_id) VALUES (:l_i)");
			$sql->bindValue(':l_i', $link['id']);
			$sql->execute();

			header('Location: ' . $link['original_url']);
		} else {
			header('Location: ../');
		}
	}
