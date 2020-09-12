<?php
namespace Collection\Model;

class Product extends Collection{
  private $price;
  private $stock;
  private array $otherCollections;


  public function getPrice(){
    return $this->price;
  }

  public function getStock(){
    return $this->stock;
  }

  public function getCollections(){
    return $this->otherCollections;
  }


  public function setPrice($price){
    $this->price = $price;
  }

  public function setStock($stock){
    $this->stock = $stock;
  }

  public function setCollections($cols){
    $this->otherCollections = $cols;
  }
}
