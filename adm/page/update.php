<?php
class update{
	public function check_update()
	{
		$op_file = fopen("http://skintm.free.fr/ycms.txt", "r");
		if ($op_file){
				$get_build = intval(fgets($op_file));
				$Current = $this->get_current();
				$CurrentBuild = intval($Current["build"]);
				if ($get_build > $CurrentBuild){
					return $get_build;
				}
				else {
					return 0;
				}
			}
		else {
			exit ("Can't open the remote build information file.");
		}
	}
	public function get_current(){
		global $YCMSBuild, $CurrentVersion, $date;
		$current = array(
		'build' => intval($YCMSBuild),
		'version' => intval($CurrentVersion),
		'date' => $date);
		return $current;
	}
	public function get_info_update(){
		$op_file = fopen("http://skintm.free.fr/ycms.xml", "r");
		$i = 0;
		$get_info = array();
		if ($op_file){
				while($get = fgets($op_file)){
					if (($i == 0) OR ($i == 1) OR ($i == 7)){
					}
					else {
						$i = $i-2;
						$u = $i;
						if ($i == 0){$i ="name";}
						if ($i == 1){$i ="version";}
						if ($i == 2){$i ="build";}
						if ($i == 3){$i ="date";}
						if ($i == 4){$i ="md5";}
					$get_info[$i] = $get;
					$i = $u;
					$i = $i+2;
					}
					$i++;
				}
					return $get_info;
			}
		else {
			echo ("Can't open the remote build information file.");
			return NULL;
		}		
	}
	public function prepare_update($build){
		if(!file_exists("./tmp/")){
			mkdir("./tmp/");
		}
		$remote_file = "http://skintm.free.fr/update/ylocms_update_".$build.".zip";
		$local_file = "./tmp/tmp_ylocms_update_".$build.".zip";
		if (!copy($remote_file, $local_file)) {
    		echo "Failed to download the remote build archive.\n";
		}
		$process = new ZipArchive;
		if ($process->open($local_file) === TRUE) {
			$process->extractTo("./tmp/tmp_ylocms_update_".$build."/");
			$process->close();
			unlink($local_file);
			return substr($local_file,0,-4);
		}
		else {
			exit ("Can't open the local temporary build archive.");
		}
		return FALSE;
	}
	public function generate_map($dir, $build) { 
	   $result = array(); 
	   $cdir = scandir($dir); 
	   foreach ($cdir as $key => $value) 
	   { 
	      if (!in_array($value,array(".",".."))) 
	      { 
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
	         { 
	            $result[$value] = $this->generate_map($dir . "/" . $value, $build); 
	         } 
	         else 
	         { 
	            $result[] = $value; 
	            $path = $dir."/".$value;
	            $local_update_folder = "./tmp/tmp_ylocms_update_".$build."/";
				$count = strlen($local_update_folder);
	            $path = substr($path, $count);
	            $map_file = fopen('./tmp/map_file.txt', 'a');
	            fputs($map_file, $path."\n"); 
	            fclose($map_file);
	         } 
	      } 
	   } 
	}
	public function do_update($tmp_update_folder, $build){
		if (file_exists($tmp_update_folder)){
				$dest = "../";
				$local_update_folder = "./tmp/tmp_ylocms_update_".$build."/";
				$count = strlen($local_update_folder);
				$map = $this->generate_map($tmp_update_folder, $build);
				if(file_exists("./tmp/map_file.txt")){
					$map = fopen('./tmp/map_file.txt', 'r');
					if ($map){
						while($path = fgets($map)){
							$path = substr($path, 0, -1);
							$pathf = $dest.$path;
							$tmp_path = $local_update_folder.$path;
							if (copy($tmp_path, $pathf)){
								unlink($tmp_path);
								echo '<font color="green">';
								echo $pathf."\n";
								echo '</font>';

							}
							else {
								echo '<font color="red">';
								echo $pathf."\n";
								echo '</font>';
							}
						}
						fclose($map);
					}
					else{
						exit("can't open map file");
					}
					$this->clean_tmp("./tmp/");
					echo "</br>Succesfully Updated !";
				}
				else {
					exit("no map file");
				}
			}
	}
	public function clean_tmp($dir){
		 $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? $this->clean_tmp("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
	}
	 public function sub_update(){
	 	$build = $this->check_update();
	 	$prepare = $this->prepare_update($build);
		$do = $this->do_update($prepare, $build);
	 }
}
$update = new update;
if(isset($_SESSION["ycms_adm_user"]))
{
?>
<div class="box">
<?php 
	if (isset($_POST["sub_update"])){
		$update->sub_update();
	} else {?>
<form action="" method="POST"><center>
<p class="title">Update Center</p></br>
<?php $grab = $update->get_current(); ?>
<p> Current Version :<?php echo $grab["version"]; ?> </p>
<p> Current Build : <?php echo $grab["build"]; ?> </p>
<p> Date : <?php echo $grab["date"]; ?></br></p>
<?php 
	$check = $update->check_update();
	if ($check == 0){echo '</br>No Update Found';}else {?>
<p class="title">New Version Found</p></br>
<?php $get = $update->get_info_update(); ?>
<p> Version : <?php echo $get["version"]; ?></p>
<p> Build : <?php echo $get["build"]; ?> </p>
<p> Date : <?php echo $get["date"]; ?> </p>

<button type="submit" name="sub_update" class="btn_enter"> UPDATE </button></center>
</form>
<?php
}
}
?>
</div>
<?php } ?>
