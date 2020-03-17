<?php
use \dambrovski\PageAdmin;
use \dambrovski\Page;
use \dambrovski\Model\Category;
use \dambrovski\Model\User;
use \dambrovski\Model\Product;


$app->get("/admin/categories",function(){

	$categories = Category::listAll();
	$page = new PageAdmin();
	$page->setTpl('categories', [
		'categories'=>$categories
	]);
});


$app->get("/admin/categories/create", function(){
	
	User::veririfyLogin();
	
	$page = new PageAdmin();
	$page->setTpl("categories-create");

});

$app->post("/admin/categories/create", function(){
	
	User::veririfyLogin();
	$category = new Category();
	$category->saveCategory($_POST["descategory"]);
	
	header("Location: /admin/categories");
	exit;
});

$app->get("/admin/categories/:idcategory", function($idcategory){
	
	User::veririfyLogin();

	$category = new Category();
	//converter para int o que está chegando ao acionar o método get
	$category->getCategory((int)$idcategory);
	$page = new PageAdmin();

	$page->setTpl("categories-update", array(
		"category"=>$category->getValues()
	));

});

$app->post("/admin/categories/:idcategory", function($idcategory){

	User::veririfyLogin();
	$category = new Category();

	$category->getCategory((int)$idcategory);
	$category->setData($_POST);
	$category->updateCategory();
	
	header("Location: /admin/categories");
	exit;

});

$app->get("/admin/categories/:idcategory/delete", function($idcategory){

	User::veririfyLogin();

	$category = new Category();
	$category->deleteCategory($idcategory);
	header("Location: /admin/categories");
	exit;

});


$app->get("/categories/:idcategory", function($idcategory){
	
	User::veririfyLogin();

	$category = new Category();
	$category->getCategory((int)$idcategory);
	
	$products = new Product();
	$products->getProductsByCategory((int)$idcategory);

	//aqui vai ser a Page normal e não admin pq queremos puxar das pastas raiz de usuario e n adm
	$page = new Page();

	$page->setTpl("category", "products",[
		"product"=>$products->getValues(),
		"category"=>$category->getValues()
	]);

});


?>