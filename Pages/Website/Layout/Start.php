<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$pageTitle?> - Medoc.one</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/jquery.tocify.css" rel="stylesheet">
		<link href="/favicon.png" rel="shortcut icon">
		<link href="/css/prettify.css" rel="stylesheet">
		<link href="/css/style.css" rel="stylesheet">
		<style>
			.navbar-brand img {
				display:inline
			}
			
			.logo {
				color:#fff;
				display:inline
			}
			
			@media (max-width:1200px) {
				.logo {
					display:none
				}
			}
			
			.center {
				text-align:center
			}
			
			footer {
				margin-top:100px
			}
			
			img {
				max-width:100%
			}
		</style>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
if (!$dev) {
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LZN8E6R2XP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LZN8E6R2XP');
</script>
<?php
}
?>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header col-md-3">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">
						<img src="/favicon.svg" alt="logo" width="120" height="40">
						<span class="logo">Medoc.one</span>
					</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav pull-right">
						<li><a href="/">Accueil</a></li>
						<li><a href="/list/page-1">Liste complète des médicaments</a></li>
						<li><a href="/recents">Médicaments récents</a></li>
						<li><a href="/photos">Photos de boîtes</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
