<?php
namespace Collection\Model;

class Collection{

  protected $uid;
  protected $name;
  protected $description;
  protected $imageUrl;


  public function __construct($uid, $name, $description="", $imageUrl=""){
    $this->uid = $uid;
    $this->name = $name;
    $this->description = $description;
    $this->imageUrl = $imageUrl;
  }



public function getUid(){
  return $this ->uid;
}
public function getName(){
  return $this ->name;
}
public function getDescription(){
  return $this ->description;
}
public function getImageUrl(){
  return $this ->imageUrl;
}

}
