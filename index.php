<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Shortify</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js" defer></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous" defer></script>
		<script src="assets/js/script.js" defer></script>
		<style>
			input:focus {
				box-shadow: 0 0 0 0.18rem rgba(13,110,253,.25) !important;
			}
		</style>
	</head>
	<body>
		<div class="container mt-5">
			<div class="row p-3 text-center justify-content-center">
				<div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 position-relative bg-body-tertiary rounded-4 p-5">
					<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
						<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
						<h4 class="text-primary m-0 ms-2">Shortify</h4>
					</div>
					<button class="btn btn-link position-absolute top-0 end-0 mt-4 me-4 p-0" style="font-size: 1.25rem;">track</button>

					<h1 class="text-body-emphasis fw-bolder" style="margin-top: 5rem;">Shorten link</h1>
					<p class="fs-5 text-muted">Track link stats with ease using <code class="text-primary fw-bold">Shortify</code>!</p>
					
					<form id="shorten-form" class="d-flex w-100 gap-2 mt-5 flex-md-row flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
						<input type="text" class="form-control px-4 rounded-pill" style="font-size: 1.25rem;" placeholder="your-link.com" required>
						<button class="btn btn-primary btn-lg text-white text-center align-items-center px-4 rounded-pill" type="submit">Shorten!</button>
					</form>
				</div>
			</div>
		</div>

		<div class="container mt-5">
			<div class="row p-3 text-center justify-content-center">
				<div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 position-relative bg-body-tertiary rounded-4 p-5">
					<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
						<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
						<h4 class="text-primary m-0 ms-2">Shortify</h4>
					</div>
					<button class="btn btn-link position-absolute top-0 end-0 mt-4 me-4 p-0" style="font-size: 1.25rem;">shorten</button>

					<h1 class="text-body-emphasis fw-bolder" style="margin-top: 5rem;">Track link</h1>
					<p class="fs-5 text-muted">Track link stats with ease using <code class="text-primary fw-bold">Shortify</code>!</p>

					<form id="track-form" class="d-flex w-100 gap-2 mt-5 flex-md-row flex-column" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
						<input type="text" class="form-control px-4 rounded-pill" style="font-size: 1.25rem;" placeholder="short-code" minlength="6" maxlength="6" required>
						<button class="btn btn-primary btn-lg text-white text-center align-items-center px-4 rounded-pill" type="submit">Track!</button>
					</form>

					<div id="track-link"></div>
				</div>
			</div>
		</div>
	</body>
</html>