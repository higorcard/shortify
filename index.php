<?php require_once 'partials/header.php'; ?>

<div class="container mt-5">
	<div class="row p-3 text-center justify-content-center flip-card" id="card">
		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-front">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<?php if(!$_SESSION['user_id']) : ?>
					<a class="btn btn-link me-3 p-0 flip-button" href="login.php" style="font-size: 1.25rem;">log in</a>
				<?php endif; ?>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">track</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Shorten link</h1>
			<p class="fs-5 text-muted">Minimize long URLs and maximize convenience with <code class="text-primary fw-bold">Shortify</code>!</p>
			
			<form id="shorten-form" class="d-flex w-100 gap-2 mt-5 flex-md-row flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="url" class="form-control rounded-pill px-4" style="font-size: 1.25rem;" placeholder="your-link.com" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center px-4 rounded-pill" type="submit">Shorten!</button>
			</form>

			<div id="shorten-code"></div>
		</div>

		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-back">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<?php if(!$_SESSION['user_id']) : ?>
					<a class="btn btn-link me-3 p-0 flip-button" href="login.php" style="font-size: 1.25rem;">log in</a>
				<?php endif; ?>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">shorten</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Track link</h1>
			<p class="fs-5 text-muted">Track link stats with ease using <code class="text-primary fw-bold">Shortify</code>!</p>

			<form id="track-form" class="d-flex w-100 gap-2 mt-5 flex-md-row flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="text" class="form-control px-4 rounded-pill" style="font-size: 1.25rem;" placeholder="short-code" minlength="6" maxlength="6" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center px-4 rounded-pill" type="submit">Track!</button>
			</form>

			<div id="track-link"></div>
		</div>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>