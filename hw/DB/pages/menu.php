
<?php $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>

<a class="btn btn-outline-success me-2" href="index.php?page=1">Tours</a></li>
<a class="btn btn-outline-success me-2" href="index.php?page=2">Comments</a></li>
<a class="btn btn-outline-success me-2" href="index.php?page=3">Registration</a></li>
<a class="btn btn-outline-success me-2" href="index.php?page=4">Admin Forms</a></li>

<?php //echo ($page==1)? "class='active'":"" ?>