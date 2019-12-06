<?php

	namespace Persistence\TableDataGateway;

	class Product{

		private $ProductGateway;
		private static $conn;
		private $data;

		public function __construct(){

			$this->ProductGateway = new ProductGateway();
		}

		public static function setConnection(\PDO $conn){

			self::$conn = $conn;
			ProductGateway::setConnection($conn);
		}

		public function __set($prop, $value){

				$this->data[$prop] = $value;		
		}

		public function __get($prop){

			if(isset($this->data[$prop])){

				return $this->data[$prop];
			}
		}

		public static function find($id){

			$productGateway = new ProductGateway();
			return $productGateway->find($id, __NAMESPACE__ . '\Product');
		}

		public static function all($filter = ''){

			$productGateway = new ProductGateway();
			return $productGateway->all($filter, __NAMESPACE__ . '\Product');
		}

		public function delete(){

			return $this->ProductGateway->delete($this->id_product);
		}
		public function save(){

			return $this->ProductGateway->save((object) $this->data);
		}

		public function getprofitMargin(){

			return (($this->sale_price - $this->cost_price) / $this->cost_price) * 100;
		}

		public function purchaseRecord($cost, $amount){

			$this->cost_price = $cost;
			$this->stock+= $amount;
		}

		public function __toString(){

			return json_encode($this->data);
		}
	}