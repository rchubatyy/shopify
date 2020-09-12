<?php

declare(strict_types=1);

namespace Collection\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Http\Client;
use Laminas\Json\Json;
use Collection\Model\Collection;
use Collection\Model\Product;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

define ('ENDPOINT', 'https://0eddee5ba1241b1966146cf570b9f991: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@magneticone-testshop.myshopify.com/admin/api/2020-07/');

class CollectionController extends AbstractActionController{

	private $adapter;

	public function __construct(){
		$this->adapter = new Adapter(['driver' => 'Mysqli',
		'hostname' => "127.0.0.1",
		'port' => '3306',
		'database'    => 'shopify',
		'username' => 'root',
		'password' => '']);
	}

    public function indexAction(){
			$fillData = $this->fillData();
			if(!$fillData[0]){
			$view = new ViewModel(['error' => $fillData[1]]);
			$view->setTemplate("error/any");
			return $view;
		}
      $collections = $this->fetchCollections();
      $view = new ViewModel(['collections' => $collections]);
      return $view;
    }



		public function viewAction(){
			$id = (int) $this->params()->fromRoute('id', 0);
			$collection = $this->adapter->query("SELECT name FROM collection WHERE uid = ".$id, Adapter::QUERY_MODE_EXECUTE)->current();
			$products = array();
			if ($id === 0){
				$name = "All products";
				$results = $this->adapter->query("SELECT * FROM product ORDER BY name",Adapter::QUERY_MODE_EXECUTE);
			}
			else{
				$name = $collection["name"];
				$results = $this->adapter->query("SELECT * FROM `product`, `product_has_collection` AS `link`
				 WHERE `product`.`uid` = `link`.`product_uid` AND `link`.`collection_uid` = ".$id, Adapter::QUERY_MODE_EXECUTE);
			}
			foreach ($results->toArray() as $a){
				$product = new Product($a['uid'], $a['name'],$a['description'],$a['imageURL']);
				$product->setPrice($a["price"]);
				$product->setStock($a["stock"]);
				$otherCollections = array();
				$cols = $this->adapter->query("SELECT `uid`, `name` FROM `collection`, `product_has_collection`
					 WHERE `collection`.`uid` = `product_has_collection`.`collection_uid`
					 AND `product_has_collection`.`product_uid` = ". $a['uid']. " AND `collection`.`uid` !=". $id, Adapter::QUERY_MODE_EXECUTE);
					 foreach ($cols->toArray() as $col){
						 $colData = new Collection($col['uid'],$col['name']);
						 $otherCollections[] = $colData;
						 $product->setCollections($otherCollections);
					 }
				$products[] = $product;
			}

			$view = new ViewModel(['id' => $id, 'name' => $name, 'products' => $products]);
      return $view;
		}

    private function fillData(){
			// Clearing all tables in SQL
			$sql    = new Sql($this->adapter);
			$tables = array('product_has_collection','collection','product');
			foreach($tables as $table){
			$delete = $sql->delete()->from($table);
			$statement = $sql->prepareStatementForSqlObject($delete);
			$results = $statement->execute();
		}
			// Adding all collections from API to SQL
      $collections = array();
      $args = array ("smart_collections", "custom_collections");
      foreach($args as $arg){
      $client = new Client(ENDPOINT. $arg . '.json');
      $response = $client->send();
			if (!$response->isSuccess()){
			var_dump("failed");
			return array(false, "Cannot connect to Internet");
		}
      if ($response->isClientError())
        return array(false, "Client error ".$response->getStatusCode().": ".$response->getReasonPhrase());

      if ($response->isServerError())
				return array(false, "Server error ".$response->getStatusCode().": ".$response->getReasonPhrase());

      if ($response ->isOK()){
      $jsonArray = Json::decode($response -> getBody(), Json::TYPE_ARRAY);
      $data = $jsonArray[$arg];
      foreach ($data as $a){
        $collection = new Collection($a['id'], $a['title'],
				array_key_exists('body_html', $a) ? ($a['body_html'] ?: "") : "", array_key_exists('image', $a)? ($a['image']['src'] ?: ""): "");
        $collections[] = $collection;
				$this->adapter->query("INSERT INTO collection(uid, name, description, imageURL) VALUES (?,?,?,?)",
				 ["".$collection->getUid(), $collection->getName(),$collection->getDescription(), $collection->getImageURL()]);
      }
    }

      }
			// Adding all products from API to SQL
			$client = new Client(ENDPOINT. 'products.json');
      $response = $client->send();
			if ($response ->isOK()){
      $jsonArray = Json::decode($response -> getBody(), Json::TYPE_ARRAY);
			$data = $jsonArray['products'];
			$products = array();
      foreach ($data as $a){
				$product = new Product($a['id'], $a['title'],
				array_key_exists('body_html', $a) ? ($a['body_html'] ?: "") : "", array_key_exists('images', $a)? ($a['images'][0]['src'] ?: ""): "");
				$product->setPrice((int)$a['variants'][0]['price']);
				$product->setStock((int)$a['variants'][0]['inventory_quantity']);
				$products[] = $product;

				$this->adapter->query("INSERT INTO product(uid, name, description, imageURL, price, stock) VALUES (?,?,?,?,?,?)",
				 ["".$product->getUid(), $product->getName(),$product->getDescription(), $product->getImageURL(),
			 $product->getPrice(),$product->getStock()]);
			}
		}

		//Adding relations of products to collections from API to SQL.
		foreach($collections as $collection){
			$client = new Client(ENDPOINT. 'collections/'. $collection->getUid(). '/products.json');
      $response = $client->send();
			if ($response ->isOK()){
      $jsonArray = Json::decode($response -> getBody(), Json::TYPE_ARRAY);
			$data = $jsonArray['products'];
			foreach ($data as $a)
			$this->adapter->query("INSERT IGNORE INTO product_has_collection(product_uid, collection_uid) VALUES (?,?)",
			 [$a['id'],$collection->getUid()]);
		}
		}
		return array (true,"");
	}
	private function fetchCollections(){
		$results = $this->adapter->query("SELECT * FROM collection ORDER BY name",Adapter::QUERY_MODE_EXECUTE);
		$collections = array();
		foreach ($results->toArray() as $a){
			$collection = new Collection($a['uid'], $a['name'],$a['description'],$a['imageURL']);
			$collections[] = $collection;
		}



      return $collections;
    }

}
