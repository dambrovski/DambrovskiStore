<?php
use \dambrovski\PageAdmin;
use dambrovski\Model\User;

$app->get("/admin/users", function(){

	User::veririfyLogin();
	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});


$app->get("/admin/users/create", function(){
	
	User::veririfyLogin();
	
	$page = new PageAdmin();
	$page->setTpl("users-create");

});


$app->post("/admin/users/create", function(){

	User::veririfyLogin();
	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;	
	$user->setData($_POST);
	$user->saveUser();
	header("Location: /admin/users");
	exit;

});


$app->get("/admin/users/:iduser", function($iduser){
	
	User::veririfyLogin();

	$user = new User();
	$user->getUser((int)$iduser);
	$page = new PageAdmin();
	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));

});

$app->post("/admin/users/:iduser", function($iduser){

	User::veririfyLogin();
	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->updateUser();
	
	header("Location: /admin/users");
	exit;

});


$app->get("/admin/users/:iduser/delete", function($iduser){

	User::veririfyLogin();

	$user = new User();
	$user->get((int)$iduser);
	$user->deleteUser();
	header("Location: /admin/users");
	exit;

});


?>