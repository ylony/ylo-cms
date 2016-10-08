<?php 
class page {
	function grab_page($string){
		global $security;
		$page = $security->clean($string);
		$fichier = "./modules/{$page}.php";
	  		if(file_exists($fichier) && $page != "index")
      		{
		 		 include "./modules/{$page}.php";	
				}
			else
			{
		  		if(file_exists("./modules/404.php"))
				{
		 			 include "./modules/404.php";
		 		}
		 		else 
		 		{
		 			echo '<p><font color="red">ERREUR : Impossible de charger le template 404 , le fichier ./modules/404.php est introuvable.</font></p>';
		 		}
		}		
	}
}
$page = new page;