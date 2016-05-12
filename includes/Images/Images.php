<?php
	/**
	* Guðni Natan Gunnarsson
	* Virkar mikið eins og Users.php
	*/
	class Images
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

		public function newImage($image_name, $image_path, $image_text, $category_id, $user_id, $visibility, $imageSize, $imageType)
		{
			//Velur random int sem er ekki í notkun.
			$i = 0;
			while (true && $i < 200) {
				$rnd = rand();
				if (empty($this->getImage($rnd))) {
					break;
				}
				$i++;
			}
			$statement = $this->connection->prepare('call NewImage(?,?,?,?,?,?,?,?,?)');
			$statement->bindParam(1,$rnd);
			$statement->bindParam(2,$image_name);
			$statement->bindParam(3,$image_path);
			$statement->bindParam(4,$image_text);
			$statement->bindParam(5,$category_id);
			$statement->bindParam(6,$user_id);
			$statement->bindParam(7,$visibility);
			$statement->bindParam(8,$imageSize);
			$statement->bindParam(9,$imageType);

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
		public function getImage($image_id)
		{
			$statement = $this->connection->prepare('call GetImage(?)');
			$statement->bindParam(1,$image_id);
			
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
		public function imageList($user_id = null)
		{
			$statement = $this->connection->prepare('call ImageList()');

			if ($user_id != null) {
				$statement = $this->connection->prepare('call ImageListByUser(?)');
				$statement->bindParam(1,$user_id);
			}
			
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
		public function updateImage($image_id, $image_name, $image_text, $category_id, $visibility = 0)
		{
			$statement = $this->connection->prepare('call UpdateImage(?,?,?,?,?)');
			$statement->bindParam(1,$image_id);
			$statement->bindParam(2,$image_name);
			$statement->bindParam(3,$image_text);
			$statement->bindParam(4,$category_id);
			$statement->bindParam(5,$visibility);
			
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
		public function deleteImage($image_id)
		{
			$statement = $this->connection->prepare('call DeleteImage(?)');
			$statement->bindParam(1,$image_id);
			
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