<?php

/* Ylo Cms by Ylony */
$YCMSBuild = 2;
$CurrentVersion = 1.00;
$date = "13/12/2015 13:22";
/***********************/


include("../includes/main.php");
function adm_page()
{
if(!empty($_GET['page']))
  {
	  $page = $_GET['page'];
	  $fichier = "./page/{$page}.php";
	  if(file_exists($fichier) && $page != "index")
      {
		  include "./page/{$page}.php";
	  }
	  else {
	  	//404
		  include "./page/404.php";
	  }
  }
  else
  {
  	  include "./page/home.php";
  }
}
  function adm_style_now()
  {
  	global $sql, $prefix;
	$result = $sql->get("SELECT * FROM {$prefix}_styles WHERE actif = 1 LIMIT 1");
	if ($result) {
		$name = $result["name"];
		echo $result["name"];
		echo '<input type="hidden" name="style_old" value="'.$result["name"].'">';	
	}
	else {
			echo 'Aucun';
			echo '<input type="hidden" name="style_old" value="Aucun">';
		 }
	}
  function adm_style_list()
  {
   	global $sql, $prefix;
   	$i=0;
   	$number = $sql->count("SELECT * FROM {$prefix}_styles ORDER BY id DESC");
	$sth = $sql->getall("SELECT * FROM {$prefix}_styles ORDER BY id DESC");
	if($sth){
		while ($i < $number)
		{
			echo '
			<option ';
			if (intval($sth[$i]["actif"]) == 1) {
				echo 'selected="selected" ';}
				echo 'name ="style_mod" value="'.$sth[$i]["name"].'">'.$sth[$i]["name"].'</option>';
				$i++;
		}
	}
  }
   function adm_style_list_files()
  {
  	global $sql, $prefix;
  	$count = 0;
  	$select = 0;
  	if($dossier = opendir('../styles'))
		{
			while(false !== ($fichier = readdir($dossier)))
			{
				if(is_file($fichier)){
				} 
				else {
					if ($fichier != '.' && $fichier != '..' && $fichier != 'Common')
					{
	$sth = $sql->get("SELECT * FROM {$prefix}_styles WHERE name = '{$fichier}'");
	if (!$sth){
		$select++;
		if ($select == 1) {
			echo '<select name="style_install">';
		}
		$count++;
		echo '<option name="style_add" value="'. $fichier . '">'.$fichier . '</option>';	
	}
					}
				}
			}
			if ($count == 0) {
				echo '</select>Aucun(s) style(s) trouvé(s)';
			}
			else {
				echo '</select>
	</p></br><button type="submit" name="sub_style_add" class="btn_enter">Valider</button>';
			}
		closedir($dossier);
  		}
  		else {
  			echo'<font color="red">Le fichier "styles" est introuvable.</font>';
  		}
  }
  function adm_style_modif($style_mod, $style_old)
   {
   	if ($style_mod == $style_old)
   	{
   		$err = "<font color=red>ERREUR : L'ancien style et le nouveau sont les mêmes.</font>";
   	}
   	else {
   global $sql, $prefix;
   $sth = $sql->query("UPDATE {$prefix}_styles SET actif = 1 WHERE name = '{$style_mod}'");  
	if(!$sth){
		echo "Oops ! Something goes wrong";
	}
   $sth = $sql->query("UPDATE {$prefix}_styles SET actif = 0 WHERE name = '{$style_old}'");  
	if(!$sth){
		echo "Oops ! Something goes wrong";
	}
   $err = "<font color=green>Succès</font>";
  }
  return $err;
}
	function adm_style_install($style)
	{
	global $sql, $prefix;
	$sth = $sql->get("SELECT * FROM {$prefix}_styles WHERE name = '{$style}'");
	if($sth){
		$err = "<font color=red>ERREUR : Ce style est déjà installé</font>";
	}
	else {
	$sth = $sql->query("INSERT INTO {$prefix}_styles (name,actif) VALUES ('{$style}', '0')");
	if(!$sth){
		echo "Oops, Something goes wrong !";
	}
	$err = "<font color=green>Succès</font>";	
	}
	return $err;
	}
	function adm_style_del($style)
	{
		global $sql, $prefix;
		$sth = $sql->get("SELECT * FROM {$prefix}_styles WHERE name = :style");
		if ($sth) {
			$sth = $sql->query("DELETE FROM {$prefix}_styles WHERE name = :style");
			if($sth){
			$err = "<font color=green>Succès</font>";	
			}
			else{
				echo "Oops ! Something goes wrong";
			}
		}
		else {
		$err = "<font color=red>Ce style n'existe pas.</font>";	
		}
		return $err;
	}
	function adm_get_module(){
		global $sql, $prefix;
		$sth = $sql->getall("SELECT * FROM {$prefix}_module ORDER BY id");
		$i = 0;
		$count = $sql->count("SELECT * FROM {$prefix}_module ORDER BY id");
		if($sth){
			while ($i < $count)
			{
				echo '<tr>';
				echo '<td>'.$sth[$i]["name"].'</td>';
				echo '<td>'.$sth[$i]["path"].'</td>';
				echo '<td>'.$sth[$i]["actif"].'</td>';
				echo '<td><a href="?page=module&edit='.$sth[$i]["id"].'">Edit</td>';
				echo '</tr>';
				$i++;
			}
		}
	}
	function adm_login($mail, $password){
		global $account;
		$adm_login_acces = $account->adm_login($mail, $password);
		if ($adm_login_acces == 1){
			$_SESSION["ycms_adm_user"] = $mail;
			return $mail;
		}
		else {
			$err = "Oops, Something goes wrong !";
			return $err;
		}
	}
	function get_register_number(){
		global $sql, $prefix;
		$query = "SELECT * FROM {$prefix}_account";
		$result = $sql->count($query);
		return $result;
	}
	function get_news_number(){
		global $sql, $prefix;
		$query = "SELECT * FROM {$prefix}_news";
		$result = $sql->count($query);
		return $result;
	}
	function get_comments_number(){
		global $sql, $prefix;
		$query = "SELECT * FROM {$prefix}_comment";
		$result = $sql->count($query);
		return $result;
	}
	function get_movie_cat(){
		global $movie;
		$movie->get_movie_cat();
	}
		global $movie;
		return $rst;
	}

?>