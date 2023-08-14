<?php
	session_start();

	if(isset($_GET['logged'])) {
		echo "<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-primary shake-animation' role='alert'>Log in!</div>";
	} elseif(isset($_GET['registered'])) {
		echo "<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-success shake-animation' role='alert'>Welcome!</div>";
	} elseif(isset($_GET['logout'])) {
		echo "<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-dark shake-animation' role='alert'>Log out!</div>";
	}

	require_once 'partials/header.php';
?>

<div class="container mt-5">
	<div class="row p-3 text-center justify-content-center flip-card" id="card">
		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-front">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<?php if($_SESSION['user_id']) : ?>
					<a class="btn btn-link me-3 p-0" href="int/logout.php" style="font-size: 1.25rem;">log out</a>
				<?php else : ?>
					<a class="btn btn-link me-3 p-0" href="login.php" style="font-size: 1.25rem;">log in</a>
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
			<div id="links-container"></div>
		</div>

		<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-back">
			<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
				<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
				<h4 class="text-primary m-0 ms-2">Shortify</h4>
			</div>

			<div class="d-flex align-items-center position-absolute top-0 end-0 mt-4 me-4">
				<?php if($_SESSION['user_id']) : ?>
					<a class="btn btn-link me-3 p-0" href="int/logout.php" style="font-size: 1.25rem;">log out</a>
				<?php else : ?>
					<a class="btn btn-link me-3 p-0" href="login.php" style="font-size: 1.25rem;">log in</a>
				<?php endif; ?>
				<button class="btn btn-link p-0 flip-button" style="font-size: 1.25rem;">shorten</button>
			</div>

			<h1 class="text-body-emphasis fw-bolder" style="margin-top: 4rem;">Track link</h1>
			<p class="fs-5 text-muted">Track link stats with ease using <code class="text-primary fw-bold">Shortify</code>!</p>

			<form id="track-form" class="d-flex w-100 gap-2 mt-5 flex-md-row flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
				<input type="text" class="form-control px-4 rounded-pill" style="font-size: 1.25rem;" placeholder="short-code" required>
				<button class="btn btn-primary btn-lg text-white text-center align-items-center px-4 rounded-pill" type="submit">Track!</button>
			</form>

			<div id="track-link"></div>
		</div>
	</div>
</div>

<form class="modal fade" id="edit-modal" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-4" id="exampleModalLabel">Edit shortened link</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<input type="hidden" name="link_id">
				<label for="short_code" class="form-label">Short code</label>
				<input type="text" name="short_code" id="short_code" class="form-control" placeholder="Personalized short link" value="" require>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="delete_link" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</form>

<form class="modal fade" id="delete-modal" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-4" id="exampleModalLabel">Delete shortened link</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<input type="hidden" name="link_id">
				<p class="fs-5">Are you sure you want to delete this shortened link?<br> This action <span class="text-decoration-underline">cannot be undone</span>.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="delete_link" class="btn btn-danger">Confirm</button>
      </div>
    </div>
  </div>
</form>

<?php require_once 'partials/footer.php'; ?>