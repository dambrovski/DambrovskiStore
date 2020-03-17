<?php
use \dambrovski\PageAdmin;
use \dambrovski\Model\Product;
use \dambrovski\Model\User;


$app->get("/admin/products",function(){

    User::veririfyLogin();
	$products = Product::listAll();
	$page = new PageAdmin();
	$page->setTpl('products', [
		'products'=>$products
	]);
});

$app->get("/admin/products/create", function(){
	
	User::veririfyLogin();
	
	$page = new PageAdmin();
	$page->setTpl("products-create");

});

$app->post("/admin/products/create", function(){
	
	User::veririfyLogin();
	$product = new Product();

	
	$desurl = $_POST['desproduct'];
	$desurl = $desurl = preg_replace('/[ -]+/' , '-' , $desurl);
	$_POST['desurl'] = $desurl;
	$product->setData($_POST);
	$product->saveProduct();
	
	header("Location: /admin/products");
	exit;
});


$app->get("/admin/products/:idproduct", function($idproduct){
	
	User::veririfyLogin();

	$product = new Product();
	$product->getProduct((int)$idproduct);
	$page = new PageAdmin();

	$page->setTpl("products-update", array(
		"product"=>$product->getValues()
	));

});

$app->post("/admin/products/:idproduct", function($idproduct){

	User::veririfyLogin();
	$product = new Product();

	$product->getProduct((int)$idproduct);
	$product->setData($_POST);
	//criar função de update
	$product->updateProduct();
	
	header("Location: /admin/products");
	exit;

});

$app->get("/admin/products/:idproduct/delete", function($idproduct){

	User::veririfyLogin();

	$product = new Product();
	//criar funcao de deletar prod
	$product->deleteProduct($idproduct);
	header("Location: /admin/products");
	exit;

});


?>