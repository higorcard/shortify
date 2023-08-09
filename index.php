<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Shortify</title>
		<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
		<link rel="manifest" href="assets/favicon/site.webmanifest">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js" defer></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous" defer></script>
		<script src="assets/js/script.js" defer></script>
		<style>
			input:focus {
				box-shadow: 0 0 0 0.18rem rgb(65 136 242 / 37%) !important;
			}

			input::placeholder {
				color: #a7acb1 !important;
			}

			#shorten-code button:active {
				border-color: #0d6efd !important;
			}
			
			#track-link ul::-webkit-scrollbar {
				width: 8px;
			}
			
			#track-link ul::-webkit-scrollbar-thumb {
				border-radius: 8px;
				background-color: #888;
			}
			
			#track-link ul::-webkit-scrollbar-track {
				border-radius: 8px;
				background-color: #ececec;
			}

			#track-link ul li:last-child {
				border-bottom: none !important;
				padding-bottom: 0 !important;
			}

			.flip-card {
				position: relative;
				margin: 0 auto !important;
				transition: transform 1.5s;
				transform-style: preserve-3d;
			}

			.card-front, .card-back {
				width: 100%;
				height: auto;
				position: absolute;
				backface-visibility: hidden;
				background: #ccc;
			}

			.card-back {
				transform: rotateY(180deg);
			}

			.flipped.flip-card {
				transform: rotateY(180deg);
			}

			@media (max-width: 576px) {
				.container {
					margin: 0 !important;
					padding: 0 !important;
					width: 100vw !important;
					height: 100vh !important;
					overflow-x: hidden !important;
					background: rgb(248,249,250) !important;
				}
				.row {
					padding: 0 !important;
					width: 100% !important;
					max-height: 100% !important;
				}
				.shortify-container {
					width: 100% !important;
					height: 100% !important;
					padding: 1.75rem !important;
					border-radius: 0 !important;
					background: none !important;
				}
				.shortify-container form {
					margin-top: 1.75rem !important;
				}
			}
			@media (min-width: 768px) {
				.flip-card {
					width: 100% !important;
				}
			}
			@media (min-width: 992px) {
				.flip-card {
					width: 66.66666667% !important;
				}
			}
			@media (min-width: 1200px) {
				.flip-card {
					width: 50% !important;
				}
			}

			@keyframes shake {
				0% { margin: 1rem -12px; }
				20% { margin: 1rem 12px; }
				40% { margin: 1rem -12px; }
				60% { margin: 1rem 12px; }
				80% { margin: 1rem -12px; }
				100% { margin: 1rem 12px; }
			}
		</style>
	</head>
	<body>
		<div class="container mt-5">
			<div class="row p-3 text-center justify-content-center flip-card" id="card">
				<div class="shortify-container bg-body-tertiary rounded-4 p-5 card-front">
					<div class="d-flex align-items-center position-absolute top-0 start-0 mt-4 ms-4">
						<img src="assets/img/repository-logo.png" style="width: 28px; heigth: 28px;">
						<h4 class="text-primary m-0 ms-2">Shortify</h4>
					</div>
					<button class="btn btn-link position-absolute top-0 end-0 mt-4 me-4 p-0" id="track-flip" style="font-size: 1.25rem;">track</button>

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
					<button class="btn btn-link position-absolute top-0 end-0 mt-4 me-4 p-0" id="shorten-flip" style="font-size: 1.25rem;">shorten</button>

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
	</body>
</html>