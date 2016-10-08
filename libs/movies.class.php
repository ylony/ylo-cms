<?php 

class movie{
	private $max_movie_per_page = 3;
	function new_movie($movie, $author, $titre, $description, $is_private, $allow_comments, $categorie, $keywords){
		global $security, $sql, $prefix;
		if(!empty($movie) && !empty($author) && !empty($titre) && !empty($categorie)){
			//clean
			$movie = $security->protect_string_bdd($movie);
			$author = $security->clean($author);
			$titre = $security->protect_string_bdd($titre);
			$description = $protect_string_bdd($description);
			$is_private = $security->protect_int($is_private);
			$allow_comments = $security->protect_int($allow_comments);
			$categorie = $security->clean($categorie);
			$keywords = $security->protect_string_bdd($keywords);
			$date = date("Y-m-d");
			$ip = $_SERVER["REMOTE_ADDR"];
			//
			//insert
			$rst = $sql->query("INSERT INTO {$prefix}_movies 
				(movie,author,titre,description,is_private,allow_comments,categorie,keywords,date,ip)
			 	VALUES ('{$movie}'), '{$author}'), '{$titre}'), '{$description}'), '{$is_private}'), '{$allow_comments}', '{$categorie}'), '{$keywords}', '{$date}', '{$ip}')");
			if($rst){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return false;
		}
	}
	function list_movie(){
		global $security, $sql, $prefix;
		$rst = $sql->getall("SELECT * FROM {$prefix}_movies ORDER BY id DESC LIMIT {$this->max_movie_per_page}");
		if($rst){
			include("./styles/Common/movies.template.php");
			return $rst;
		}
		else{
			echo "Il n'y a aucune vidéo pour le moment !";
			return false;
		}
	}
	function get_movie_data($mid){
		global $security, $sql, $prefix;
		$mid = $security->protect_int($mid);
		$rst = $sql->get("SELECT * FROM {$prefix}_movies where id = '{$mid}'");
		if($rst){
			$this->max_movie_per_page = 1;
			include("./Common/movies.template.php");
			return $rst;
		}
		else{
			return false;
		}
	}
	function get_movie_cat(){
		global $sql, $prefix;
		$query = "SELECT * FROM {$prefix}_moviecate";
		$result = $sql->getall($query);
		if (!empty($result)){
			$count = $sql->count($query);
			$i = 0;
			while($i < $count){
				echo "<option value={$result[$i]["name"]}>{$result[$i]["name"]}</option>";
				$i++;
			}
		}
		else{
			echo "<option value=>Something goes wrong</option>";
		}
	}
}
$movie = new movie;