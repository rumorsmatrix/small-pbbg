<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="icon" type="image/png" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="vendor/bootstrap-4.4.1.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Oxanium&display=swap');

		body {
			/*background: #ddd linear-gradient(to bottom, #ccc, #888) fixed;*/
			margin-top: 6rem;
		}

		h2, .card-title, .card-subtitle, .card-header, .fancy, .navbar-brand, .btn {
			font-family: 'Oxanium', sans-serif;
		}

		.nav-link {
			cursor: pointer;
		}
	</style>
	<title>smallPBBG</title>
</head>
<body class="bg-secondary">

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark shadow-lg">
	<a class="navbar-brand" href="#">smallPBBG</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

<?php if (!is_null($this->user)) { ?>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="dashboard" data-target="main">
					<i class="fa fa-fw fa-fab fa-home"></i>
					Duty Roster
				</a>

			</li>

			<?php if ($this->user->id === 1) {  ?>
				<li class="nav-item">
					<a class="nav-link" href="test" data-target="main">
						<i class="fa fa-fw fa-fab fa-file"></i>
						Test
					</a>
				</li>
			<?php } ?>

				<li class="nav-item">
					<a class="nav-link" href="https://twitter.com/rumorsmatrix">
						<i class="fa fa-fw fa-fab fa-twitter"></i>
						Twitter
					</a>
				</li>

		</ul>
	</div>
<?php } ?>

</nav>

<main role="main">

	<div class="container" id="main">

