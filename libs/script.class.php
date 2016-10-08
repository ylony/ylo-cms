<?php
/* Add name check ? */
	class script{
		private $script_ext = array('cpp', 'c', 'php', 'cs', 'html', 'js', 'css', 'h');
		public function add_script($script_name, $script_cat, $script_description, $script_source, $script_source_file, $script_win, $script_lin, $script_author){
			if(!empty($script_name) && !empty($script_cat) && !empty($script_description)){
				// Clean
				global $security;
				$script_name = $security->clean($script_name);
				$script_cat =  $security->res($security->protect_string_bdd($script_cat));
				$script_description =  $security->res($script_description);
				$script_author = $security->clean($script_author);
				$script_date = date("Y-m-d H:i:s");
				//
				if(!$script_source_file["error"] == 4){
					global $upload;
					$source_up = $upload->GetUploadStmt($script_source_file, "script");
				}
				if(!$script_win["error"] == 4){
					global $upload;
					$source_win_up = $upload->GetUploadStmt($script_win, "script");
				}
				if(!$script_lin["error"] == 4){
					global $upload;
					$source_lin_up = $upload->GetUploadStmt($script_lin, "script");
				}
				//Insert DB
				global $sql, $prefix;
				// Warning fix
				if(empty($source_win_up)){
					$source_win_up = NULL;
				}
				if(empty($source_lin_up)){
					$source_lin_up = NULL;
				}
				if(empty($source_up)){
					$source_up = NULL;
				}
				//Query
				$query = "INSERT INTO {$prefix}_scripts (name, cat, description, source_file, win, lin, author, date, opensource) VALUES ('{$script_name}', '{$script_cat}', '{$script_description}', '{$source_up}', '{$source_win_up}', '{$source_lin_up}', '{$script_author}', '{$script_date}', '{$script_source}')";
				$result = $sql->query($query);
				if(!$result){
					return "SQL ERROR.";
				}
				else{
					if(!empty($source_up)){
						unpack_script($source_up);
					}
					return 42;
				}
			}
			else{
				return "Un des champs obligatoire (*) est vide.";
			}
		}
		public function list_script(){
			global $sql, $prefix;
			$count = $sql->count("SELECT * FROM {$prefix}_scripts");
			$result = $sql->getall("SELECT * FROM {$prefix}_scripts");
			$i=0;
			while($i < $count){
				echo '<tr><td>'.$result[$i]["id"].'</td><td>'.$result[$i]["name"].
				'</td><td>'.$result[$i]["author"].
				'</td><td>'.$result[$i]["cat"].
				'</td><td>'.$result[$i]["description"].
				'</td><td>'.$result[$i]["source_file"].
				'</td><td>'.$result[$i]["date"].
				'</td><td>'.$result[$i]["win"].
				'</td><td>'.$result[$i]["lin"].'</td></tr>';
				$i++;
			}
		}
		public function get_all_script(){
			global $sql, $prefix;
			$result = $sql->getall("SELECT * FROM {$prefix}_scripts ORDER BY id DESC");
			return $result;			
		}
		public function count_all_script(){
			global $sql, $prefix;
			$count = $sql->count("SELECT * FROM {$prefix}_scripts");
			return $count;
		}
		public function un_pack($source_file){
			$tmp_id = $this->get_tmp_id($source_file);
				if(!file_exists("../tmp/".$tmp_id."/")){
					$process = new ZipArchive;
					$folder = rand();
					if ($process->open($source_file) === TRUE) {
							$process->extractTo("../tmp/".$folder."/");
							$process->close();
						if(file_exists("../tmp/map/".$folder."/")){
							unlink("../tmp/map/".$folder."/map_file.txt");
						}				
							return $folder;
						}
						else{
							return FALSE;
						}
				}
				else{
				if(file_exists("../tmp/map/".$tmp_id."/")){
					unlink("../tmp/map/".$tmp_id."/map_file.txt");
					}
					return $tmp_id;
				}
		}
	public function generate_map($dir, $id, $source_file) {
		   $result = array(); 
		   $cdir = scandir($dir); 
		   foreach ($cdir as $key => $value) 
		   { 
		      if (!in_array($value,array(".",".."))) 
		      { 
		         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
		         { 
		            $result[$value] = $this->generate_map($dir . "/" . $value, $id, $source_file); 
		         } 
		         else 
		         { 
		            $result[] = $value; 
		            $path = $dir."/".$value;
		            $local_update_folder = "../tmp/".$id."/";
					$count = strlen($local_update_folder);
		            $path = substr($path, $count);
		            if(!file_exists("../tmp/map")){
		            	mkdir("../tmp/map");
		            }
		            if(!file_exists("../tmp/map/".$id."/")){
		            	mkdir("../tmp/map/".$id."/");
		            }
		            $map_file = fopen('../tmp/map/'.$id.'/map_file.txt', 'a');
		            fputs($map_file, "./tmp/".$id.$path."\n"); 
		            fclose($map_file);
		          	global $sql, $prefix;
		            $sql->query("UPDATE {$prefix}_scripts set tmp_id = '{$id}' WHERE source_file = '{$source_file}'");
		         } 
		      } 
		   }
	}
	public function get_tmp_id($source_file){
		global $sql, $prefix;
		$result = $sql->get("SELECT tmp_id FROM {$prefix}_scripts WHERE source_file = '{$source_file}'");
		return $result["tmp_id"];
	}
	public function get_script_data($id){
		global $sql, $prefix, $security;
		$id = $security->protect_int($id);
		$result = $sql->get("SELECT * FROM {$prefix}_scripts WHERE tmp_id = '{$id}'");
		return $result;
	}
	public function get_dl_link($id){
		global $security;
		$id = $security->protect_int($id);
		$result = $this->get_script_data($id);
		$result = explode("/", $result["source_file"]);
		$result = end($result);
		return "./uploads/".$result;
	}
	public function convert_map_file($map){
		if(file_exists($map)){
			$map_file = fopen($map, 'r');
			if($map_file){
				while($lign = fgets($map_file)){
					// one step
					$extension = explode(".", $lign);
					$name = explode("/", $lign);
					// two step
					$name = trim(end($name));
					$ext = trim(end($extension));
					//third one
					if(in_array($ext, $this->script_ext)){
						echo '<a>'.$name.'</a></br>';
						write(trim($lign));
					}
				}
			}
			else{
				return "Can't open the map file";
			}
		}
		else{
			return "Map file not found";
		}
	}
	public function is_opensource($id){
		global $sql, $prefix, $security;
		$id = $security->protect_int($id);
		$result = $sql->get("SELECT * FROM {$prefix}_scripts WHERE tmp_id = '{$id}'");
		return trim($result["opensource"]);
	}
}
	$script = new script;