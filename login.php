<?php
	session_start();

	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/int/functions.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';

	if($user_id) {
		header('Location: /');
	}
	
	if(isset($_GET['fail-sign-in'])) {
		showAlert('danger', 'E-mail or password incorrect!');
	} elseif(isset($_GET['fail-username'])) {
		showAlert('warning', 'Username already in use :(');
	} elseif(isset($_GET['fail-email'])) {
		showAlert('warning', 'E-mail already in use :(');
	}
	
	if(isset($_POST['sign-in'], $_POST['email'], $_POST['password']) && strlen($_POST['password']) >= 8) {
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

		$user = User::get($email);
		
		if($user && password_verify($password, $user['password'])) {
			$_SESSION['user_id'] = $user['id'];
			
			header('Location: ../?logged');
		} else {
			header('Location: ?fail-sign-in');
		}
	}
	
	if(isset($_POST['sign-up'], $_POST['username'], $_POST['email'], $_POST['password']) && strlen($_POST['username']) >= 3 && strlen($_POST['password']) >= 8) {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$username = str_replace(' ', '_', strtolower($username));
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = password_hash($password, PASSWORD_DEFAULT);

		$userExists = User::userExists($username, $email);

		if($userExists == false) {
			$user_id = User::create($username, $email, $password);

			if($user_id) {
				$_SESSION['user_id'] = $user_id;
				
				header('Location: ../?registered');
			}
		} elseif($userExists == 'username') {
			header('Location: ?fail-username');
		} elseif($userExists == 'email') {
			header('Location: ?fail-email');
		}
	}

	require_once $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<div class="container mt-5">
	<div class="row p-3 text-center justify-content-center flip-card" id="card">
		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-front">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; height: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<a class="btn btn-link me-3 p-0" href="index.php" style="font-size: 1.25rem;">home</a>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">sign up</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Sign in</h1>
			<p class="fs-5 text-muted">Log in to access your <code class="text-primary fw-bold">personalized</code> short links!</p>
			
			<form id="sign-in" class="d-flex w-100 gap-2 mt-5 flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="email" name="email" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="E-mail" required>
				<input type="password" name="password" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Password" minlength="8" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center mt-3 px-4 rounded-pill" name="sign-in" type="submit">Join!</button>
			</form>

			<div id="shorten-code"></div>
		</div>

		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-back">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; height: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<a class="btn btn-link me-3 p-0" href="index.php" style="font-size: 1.25rem;">home</a>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">sign in</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Sign up</h1>
			<p class="fs-5 text-muted">Join now and start creating <code class="text-primary fw-bold">personalized</code> short links!</p>

			<form id="sign-up" class="d-flex w-100 gap-2 mt-5 flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="text" name="username" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Username" minlength="3" required>
				<input type="email" name="email" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="E-mail" required>
				<input type="password" name="password" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Password" minlength="8" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center mt-3 px-4 rounded-pill" type="submit" name="sign-up">Join!</button>
			</form>

			<div id="track-link"></div>
		</div>
	</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php'; ?>