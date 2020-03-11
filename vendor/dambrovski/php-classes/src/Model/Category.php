<?php

namespace dambrovski\Model;


use dambrovski\Model;
use dambrovski\DB\Sql;
use dambrovski\Mailer;

class Category extends Model{

    public static function listAll(){

            
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
        return $results;
    
    }

    public function saveCategory($descategory){

        $sql = new Sql();
        $idcategory = 0;
        $results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", 
        array(
            ":idcategory"=>$idcategory,
            ":descategory"=>$descategory
        ));
        
        //INSERT INTO NOME_DA_TABELA (CAMPOS_QUE_DESEJA_INSERIR_DADOS) VALUES (VALORES_DOS_CAMPOS)
    }
    
    public function getCategory ($idcategory){

        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", array(
            ":idcategory"=>$idcategory
        ));
        $this->setData($results[0]);
        }

        public function updateCategory(){

        $sql = new Sql();
                
        $results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", 
        array(
            ":idcategory"=>$this->getidcategory(),
            ":descategory"=>$this->getdescategory(),
        ));
    }

    public function deleteCategory($idcategory){

        $sql = new Sql();

        //DELETE FROM tb_users WHERE iduser = piduser;
        $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",array(
            ":idcategory"=>$idcategory
        ));
    }
}

?>