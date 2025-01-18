<?php
$this->load->view('header');
echo "<div class='col-md-offset-1'>";
echo '<h2>'.$title.'</h2>';
echo '<h3>'.$item[0]['itemname'].'</h3>';
echo '<p>'.$item[0]['pricein'].'</p>';
echo '<p style="color:red;font-size:14pt;font-family:Verdana;">'.
	$item[0]['pricesale'].'</p>';
echo '<p>'.$item[0]['info'].'</p>';
echo "</div>";
$this->load->view('footer');
