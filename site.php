<?php 
use \dambrovski\Page;

$app->get('/', function() {
	$page = new Page();
	$page->setTpl("index");
});

 ?>
