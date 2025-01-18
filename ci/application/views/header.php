<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Codeigniter 3</title>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li>
					<a href="<?php echo site_url('home/index'); ?>">Index</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/itemslist'); ?>">Get All Items</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/getItemInfo'); ?>">Get Item</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/getItemInfo2'); ?>">Select Item</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/selectImages'); ?>">Upload Image</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/selectMultipleImages'); ?>">Multiple Upload</a>
				</li>
				<li>
					<a href="<?php echo site_url('home/Catalog'); ?>">Catalog</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
