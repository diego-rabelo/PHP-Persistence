<?php
	
	namespace Persistence\ActiveRecord;

	class Product{

		private static $conn;
		private $data;

		public function __set($prop, $value){

			$this->data[$prop] = $value;
		}

		public function __get($prop){

			if(isset($this->data[$prop])){

				return $this->data[$prop];
			}
		}

		public static  function setConnection(\PDO $conn){

			self::$conn = $conn;
		}

		public static function find($id){

			$sql = "SELECT * FROM product WHERE id_product = '$id'";
			$result = self::$conn->query($sql);
			return $result->fetchObject($class);
		}

		public function all($filter = '', $class = 'stdClass'){

			$sql = !$filter ? "SELECT * FROM product"
							: "SELECT * FROM product WHERE " . $filter;
							
			$result = self::$conn->query($sql);

			return $result->fetchAll(\PDO::FETCH_CLASS, $class);

		}

		public function delete($id) :int {

			$sql = "DELETE FROM product WHERE id_product = '$id'";

			return self::$conn->query($sql)->rowCount();
		}

		public function save(){

			$data = (array) $this->data;

			if(empty($data['id_product'])){

				$sql = "INSERT INTO product (id_product , {$this->getInsertFields($data)})";
				$sql.= " VALUES ({$this->nextId()}, {$this->getInsertValues($data)})";

				
			} else{

				$sql = "UPDATE product SET {$this->getUpdateFields($data)} WHERE id_product = {$data['id_product']}";
			}
			
			return self::$conn->exec($sql);
		}

		private function getInsertFields($data){

			$fields = implode(', ', array_keys($data));

			return rtrim($fields);
		}

		private function getInsertValues($data){

			$values = array_map(function($value){ return "'{$value}'"; }, $data);

			return rtrim(implode(', ', $values));
		}

		private function getUpdateFields($data){

			$updateFields = array_reduce(array_keys($data), function($acc, $field) use ($data){

				if($field != 'id_product'){

					$acc.= "{$field} = '{$data[$field]}', ";
				}

				return $acc;
			});

			return trim($updateFields, ', ');
		}
		

		private function nextId(){

			$sql = "SELECT max(id_product) as max FROM product";
			$result = self::$conn->query($sql);
			$data = $result->fetchObject();

			return (int)$data->max + 1;
		}
	}