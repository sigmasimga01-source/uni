<?php
class Dbhelper {
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = new mysqli($hostname, $username, $password, $database);
    }

    public function addProduct(Products $product) {
        $statement = $this->connection->prepare("insert into products(name, size, barcode) values(?,?,?)");
        $name = $product->getName();
        $size = $product->getSize();
        $barcode = $product->getBarcode();
        $statement->bind_param("sss", $name, $size, $barcode);
        $statement->execute();
       
    }


    public function getAllProducts(): array {
        $products = [];
        $statemtn = $this->connection->prepare("select * from products");
        $statemtn->execute();

        $result = $statemtn->get_result(); 
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }   
       
        return $products;
    }

    public function deleteProduct(int $id){
        $st = $this->connection->prepare('
        DELETE FROM products  WHERE prod_id = ? 
        ');
        $prodid=$id;
       
        $st->bind_param("i",$prodid);
        $st->execute();
        
    }

    public function updateProduct(int $id,$name,$size,$barcode){
                $st = $this->connection->prepare('
        UPDATE products set name=?,size=?,barcode=?  WHERE prod_id = ? 
        ');
        $Name=$name;
        $Size=$size;
        $Barcode=$barcode;
        
        $prodid=$id;
      
        $st->bind_param("sssi",$Name,$Size,$Barcode, $prodid);
         
        $st->execute();
        
    }

//  public function updateProduct(Products $product){
//                 $st = $this->connection->prepare('
//         UPDATE products set name=?,size=?,barcode=?  WHERE prod_id = ? 
//         ');
//         $Name=$product->getName();
//         $Size=$product->getSize();
//         $Barcode= $product->getBarcode();
//         $prodid=$product->getId();
        
       
//         $st->bind_param("sssi",$prodid,$Name,$Size,$Barcode);
//         $st->execute();
//     }


}
