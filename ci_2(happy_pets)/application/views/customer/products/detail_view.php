<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("customer/layouts/_head"); ?>

<body>

	<!-- Navigation -->
	<?php $this->load->view("customer/layouts/_navbar"); ?>
	<!-- Page Content -->
	<div class="container py-5">

		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url("product") ?>">product</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?= $product["name"] ?></li>
			</ol>
		</nav>

		<hr>

		<div class="row">
			<div class="col-sm-5">
				<figure class="figure">
					<img src="<?= base_url("assets/uploads/items/" . $product["images"]) ?>" class="figure-img shadow-sm img-fluid rounded-lg" alt="...">
				</figure>
			</div>
			<div class="col-sm-5">
				<a href="" class="text-dark text-decoration-none">
					<h5 class="font-weight-bold"><?= $product["name"] ?></h5>
				</a>
				<p class="lead text-muted"><span class="text-warning font-weight-bold">UAH <?= number_format($product["price"]) ?></span></p>
				<p class="text-muted">Stok : <?= $product["stock"] ?> Unit</p>
				<hr>
				<form action="<?= base_url("happy-pets/" . $product["item_id"]) ?>" method="POST">
					<div class="row">
						<div class="col-sm-3">
							<input type="number" class="form-control" name="qty" value="1" min="1" max="<?= $product["stock"] ?>">
						</div>
						<div class="col-sm-9">
							<button type="submit" class="btn btn-primary btn-block text-white"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg> Add to Cart</button>
						</div>
					</div>
				</form>
				<a href="<?= base_url() ?>" class="btn btn-light btn-block text-muted mt-3">Back</a>
				<div><br>
					<h5 class="font-weight-bold">Description product</h5>
					<p class="text-muted"><?= $product["description"] ?></p>
				</div>
			</div>
		</div>
		<!-- <div class="row py-3 ml-0"> -->
		<!-- </div> -->
	</div> <!-- /.container -->

	<div class="mt-5">
		<h4 class="font-weight-bold">Comments</h4>

		<!-- Список комментариев -->
		<div class="comments-section">
			<?php if (!empty($comments)): ?>
				<?php foreach ($comments as $comment): ?>
					<div class="comment mb-3 p-3 border rounded">
						<p class="font-weight-bold mb-1"><?= htmlspecialchars($comment['user_name']) ?></p>
						<p class="text-muted mb-0"><?= htmlspecialchars($comment['comment']) ?></p>
						<small class="text-secondary"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></small>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p class="text-muted">No comments yet. Be the first to comment!</p>
			<?php endif; ?>
		</div>
	</div>

	<!-- Форма для добавления комментария -->
	<div class="mt-4">
		<h5 class="font-weight-bold">Add a Comment</h5>
		<form action="<?= base_url("product/detail/" . $product["slug"]) ?>" method="POST">
			<div class="form-group">
				<label for="user_name">Your Name</label>
				<input type="text" id="user_name" name="user_name" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="comment">Your Comment</label>
				<textarea id="comment" name="comment" rows="4" class="form-control" required></textarea>
			</div>
			<button type="submit" name="submit_comment" class="btn btn-primary">Submit Comment</button>
		</form>
	</div>

	<section class="categories-section bg-light py-5">
		<div class="section-title">
		<div class="container">
			<h3 class="font-weight-bold">product lain</h3>
			<p class="text-muted">Beberapa product lain yang mungkin your cari</p>
			<hr>
			<div class="row">
				<?php foreach ($products as $product) : ?>
					<div class="col-sm-3">
						<a href="<?= base_url("product/" . $product["slug"]) ?>">
							<figure class="figure">
								<img src="<?= base_url("assets/uploads/items/" . $product["images"]) ?>" class="figure-img img-fluid rounded" style="width: 100%; height: 180px; object-fit: cover; object-position: center;">
								<figcaption class="figure-caption text-center font-weight-bold"><?= $product["name"] ?></figcaption>
							</figure>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="text-center">
				<a href="<?= base_url("product") ?>">View all products</a>
			</div>
		</div>				
		</div>
	</section>

	<!-- Footer -->
	<?php $this->load->view("customer/layouts/_footer"); ?>

	<?php $this->load->view("customer/layouts/_scripts"); ?>
	<?php if ($this->session->flashdata('message')): ?>
	<script>
		const flashData = $('.flash-data').data('flashdata');
		if (flashData) {
			Swal.fire({
				title: 'Success!!!',
				text: 'Item successful ' + flashData,
				icon: 'success'
			});

		}
	</script>
<?php endif; ?>

</body>

</html>
