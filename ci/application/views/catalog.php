<?php
$this->load->view('header');

$attributes = array('class' => 'form-horizontal', 'method' => 'get');
echo form_open('home/catalog', $attributes);
?>

<div class="col-md-offset-4" style="width: 50%; margin: 0 auto;">
	<div class="form-group">
		<?= form_label('Category', 'category', array('class' => 'control-label')) ?>
		<select name="category" class="form-control">
			<option value="">All</option>
			<?php foreach ($categories as $cat): ?>
				<option value="<?= $cat['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $cat['id'] ? 'selected' : '' ?>>
					<?= $cat['category'] ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group">
		<?= form_label('Price Min', 'price_min', array('class' => 'control-label')) ?>
		<?= form_input(array(
			'name' => 'price_min',
			'id' => 'price_min',
			'type' => 'number',
			'value' => isset($_GET['price_min']) ? $_GET['price_min'] : '',
			'class' => 'form-control'
		)) ?>
	</div>

	<div class="form-group">
		<?= form_label('Price Max', 'price_max', array('class' => 'control-label')) ?>
		<?= form_input(array(
			'name' => 'price_max',
			'id' => 'price_max',
			'type' => 'number',
			'value' => isset($_GET['price_max']) ? $_GET['price_max'] : '',
			'class' => 'form-control'
		)) ?>
	</div>

	<?= form_submit(array('name' => 'filter', 'value' => 'Filter', 'class' => 'btn btn-success')) ?>
</div>

<?= form_close() ?>


<div class="row">
	<?php foreach ($items as $item): ?>
		<div class="col-md-4" style="width: 25%;">
			<div class="card mb-4">
				<div class="card-body">
					<h5 class="card-title"><?= $item['itemname'] ?></h5>
					<p class="card-text">
						<strong>Category:</strong> <?= $item['catid'] ?><br>
						<strong>Price:</strong> <?= $item['pricesale'] ?><br>
						<strong>Info:</strong> <?= $item['info'] ?><br>
					</p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php
$this->load->view('footer');
?>
