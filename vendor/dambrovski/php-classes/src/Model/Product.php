<?php

namespace dambrovski\Model;


use dambrovski\Model;
use dambrovski\DB\Sql;
use dambrovski\Mailer;

class Product extends Model{

    public static function listAll(){

        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products ORDER BY idproduct");
        return $results;
    
    }

    public function saveProduct(){

        $idproduct = 0;

        $sql = new Sql();
        $results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", 
        array(
            ":idproduct"=>$idproduct,
            ":desproduct"=>$this->getdesproduct(),
            ":vlprice"=>$this->getvlprice(),
            ":vlwidth"=>$this->getvlwidth(),
            ":vlheight"=>$this->getvlheight(),
            ":vllength"=>$this->getvllength(),
            ":vlweight"=>$this->getvlweight(),
            ":desurl"=>$this->getdesurl(),
        ));

        $this->setData($results[0]);
    }

    public function getProduct($idproduct){

        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct"=>$idproduct
        ));
        $this->setData($results[0]);
        }

    public function checkPhoto()
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . 
        DIRECTORY_SEPARATOR . 
        'res' . 
        DIRECTORY_SEPARATOR . 
        'site' . 
        DIRECTORY_SEPARATOR . 
        'img' . 
        DIRECTORY_SEPARATOR . 
        'products' . $this->getidproduct() . '.jpg')){
            $url = "/res/site/img/products/" . $this->getidproduct() . '.jpg';
        } else{
            return "/res/site/img/products/product.jpg";
        }

        return $this->setdesphoto($url);

    }

    public function getValues()
    {

        $this->checkPhoto();

        $values = parent::getValues();

        return $values;
    }

}

?>