<?php
	class upload{
		private $ExpansionAllowed = array('.jpg', '.gif', '.png', '.bmp', '.tga', '.jpeg', '.zip', '.exe', ' ');
		private $SizeAllowed = 10000000; // 10 Mo Don't forget to check upload_max_filesize and post_max_size in your php.ini if this script don't work
		private $Path = "../uploads/";

		private function check($file, $kind){
			if(!is_uploaded_file($file["tmp_name"])){
				exit ("Upload failed. File is missing !");
			}
			$CurrentExpansion = substr($file["name"], -4);
			if (!in_array($CurrentExpansion, $this->ExpansionAllowed)){
					exit ("This file don't have a correct expansion !");
			}
			$CurrentSize = $file["size"];
			if ($CurrentSize > $this->SizeAllowed){
				exit ("This file is too large ! ");
			}
			if(!file_exists($this->Path)){
				$try = mkdir($this->Path, 0777, true);
				if ($try == 1){
				}
				else {
					exit ("The upload folder don't exist");
				}
			}
			return TRUE;
		}

		private function generate_name($file){
			global $security;
			$CurrentExpansion = substr($file["name"], -4);
			$new_name = $security->clean($security->crypt($file["name"], "MyScRiPT3NcOd3D")); //crypt name
			$random_id = md5(microtime(TRUE)*100000);
			$random_id = substr($random_id, 0, 10);
			$new_name = $new_name.$random_id;
			while(strlen($new_name) > 30){
				$new_name = substr($new_name, -20);
			}
			$new_name = $new_name.$CurrentExpansion;
			return $new_name;
		}

		private function upload_file($file, $kind){
			global $adresse;
			$if_allowed = $this->check($file, $kind);
			if($if_allowed == TRUE){
				$file_final_name = $this->generate_name($file);
				if(!move_uploaded_file($file["tmp_name"], $this->Path . $file_final_name))
				{
   					exit ("Can't move the file !");
				}
				return ('../uploads/'.$file_final_name); //wtf
			}
			return FALSE;
		}

		public function GetUploadStmt($file, $kind){
			$stmt = $this->upload_file($file, $kind);
			if($stmt == TRUE){
				return ($stmt);
			}
			elseif($stmt == FALSE){
				return ("FAILURE");
			}
			else {
				return ("failure");
			}
		}
	}
	$upload = new upload;