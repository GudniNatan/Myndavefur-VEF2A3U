<?php  
	/**
	* Guðni Natan Gunnarsson
	* Virkar mikið eins og Users.php
	*/
	class Categories
	{
		private $connection; // for PDO connection inside the class

		function __construct($connection_name)
		{
			if(!empty($connection_name)){

				$this->connection = $connection_name;
			}
			else{
				throw new Exception("cant connect to database");
			}
		}

		public function newCategory($category_name)
		{
			$statement = $this->connection->prepare('call NewCategory(?,?,?,?)');
			$statement->bindParam(1,$category_name);
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
		public function getCategory($category_id)
		{
			$statement = $this->connection->prepare('call GetCategory(?)');
			$statement->bindParam(1,$category_id);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}

		}
		public function categoryList()
		{
			$statement = $this->connection->prepare('call CategoryList()');
			
			try 
			{
				$arr = array();
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_NUM)) 
				{
					array_push($arr,$row);
				}
				return $arr;
			}
			catch(PDOException $e)
			{
				return array();
			}

		}
		public function updateCategory($category_name, $category_id)
		{
			$statement = $this->connection->prepare('call UpdateCategory(?,?)');
			$statement->bindParam(1,$category_name);
			$statement->bindParam(2,$category_id);			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
		public function deleteCategory($category_id)
		{
			$statement = $this->connection->prepare('call DeleteCategory(?)');
			$statement->bindParam(1,$category_id);
			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
	}