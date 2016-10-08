<?php
	/*
	** By Ylony  14/05/2016**
	** Everything needed to acces sql server
	*/
	class sql{
		public $i=0; //SQL COUNT
		public $totaltime=0;
		public function connect(){
			global $host, $database, $usermysql, $passmysql, $debug;
			$connect = new mysqli($host, $usermysql, $passmysql, $database);
				if ($connect->connect_error) {
					if ($debug == TRUE){
    					die('Erreur : (' . $connect->connect_errno . ')'.$connect->connect_error);
					}
					else{
						echo "Oops, Something goes wrong ! Maybe you should active DEBUG mode ?";
					}
					return FALSE;		
				}
				else {
					return $connect;
				}
		}
		public function query($string){
			global $debug;
				$connect = $this->connect();
				$starttime = microtime(true);	
				$stmt = $connect->query($string);
				$endtime = microtime(true);
				$duration = $endtime - $starttime;
				if(!$stmt){
					if($debug == TRUE){
						printf("Erreur : %s\n", $connect->error);
						return FALSE;
					}
					else{
						echo "Oops something goes wrong !";
						return FALSE;
					}
				}
				else {
					if($debug == TRUE){
						$this->i++;	//Count all sql query done	
						$this->totaltime = $this->totaltime+$duration;			
					}
					return $stmt;
				}
			}
		public function getall($string){
   			global $debug;
   					$stmt = $this->query($string);
   					if($stmt == FALSE){
   						return FALSE;
   					}
   					while($get = $stmt->fetch_all(MYSQLI_ASSOC)){
   						$data = $get;
   					}
   					$stmt->close();
   					if (empty($data)){
   						return FALSE;
   					}
   					else{
    	  				return $data;
    	  			}
			}
		public function get($string){
   			global $debug;
   					$stmt = $this->query($string);
   					if($stmt == FALSE){
   						return FALSE;
   					}
   					while($get = $stmt->fetch_assoc()){
   						$data = $get;
   					}
   					$stmt->close();
   					if (empty($data)){
   						return FALSE;
   					}
   					else{
    	  				return $data;
    	  			}
			}
		public function count($string){
   				$stmt = $this->query($string);
   				if($stmt == FALSE){
   					return FALSE;
   				}
   				$count = $stmt->num_rows;
   				$stmt->close();
    	  		return $count;
			}
	}	
		$sql = new sql;