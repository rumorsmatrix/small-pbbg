<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="vendor/bootstrap-4.4.1.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Oxanium&display=swap');

		body {
			background-color: #ddd;
			background: linear-gradient(to bottom, #ccc, #888) fixed;

			margin-top: 6rem;
		}

		h2, .fancy, .navbar-brand, .btn {
			font-family: 'Oxanium';
		}
	</style>
	<title>smallPBBG</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="#">smallPBBG</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

<?php if (!is_null($this->user)) { ?>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="fa fa-fw fa-fab fa-home"></i>
					Home
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="fa fa-fw fa-fab fa-file"></i>
					Link
				</a>
			</li>
		</ul>
	</div>
<?php } ?>


</nav>

<main role="main">
	<div class="container mb-4">
		<h2>
			<?=$this->page_title?>
			<small class="text-muted"><?=$this->page_subtitle?></small>
		</h2>
	</div>

 	<div class="container">

