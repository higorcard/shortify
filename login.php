<?php require_once 'partials/header.php'; ?>

<div class="container mt-5">
	<div class="row p-3 text-center justify-content-center flip-card" id="card">
		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-front">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<a class="btn btn-link me-3 p-0 flip-button" href="index.php" style="font-size: 1.25rem;">home</a>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">sign up</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Sign in</h1>
			<p class="fs-5 text-muted">Log in to access your <code class="text-primary fw-bold">personalized</code> short links!</p>
			
			<form id="sign-in" class="d-flex w-100 gap-2 mt-5 flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="email" name="email" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="E-mail" required>
				<input type="password" name="password" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Password" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center mt-3 px-4 rounded-pill" name="sign-in" type="submit">Join!</button>
			</form>

			<div id="shorten-code"></div>
		</div>

		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-back">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<a class="btn btn-link me-3 p-0 flip-button" href="index.php" style="font-size: 1.25rem;">home</a>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">sign in</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Sign up</h1>
			<p class="fs-5 text-muted">Join now and start creating <code class="text-primary fw-bold">personalized</code> short links!</p>

			<form id="sign-up" class="d-flex w-100 gap-2 mt-5 flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="text" name="username" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Username" required>
				<input type="email" name="email" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="E-mail" required>
				<input type="password" name="password" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="Password" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center mt-3 px-4 rounded-pill" type="submit" name="sign-up">Join!</button>
			</form>

			<div id="track-link"></div>
		</div>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>