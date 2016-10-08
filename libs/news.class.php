<?php
class news {
	function shownews(){
	global $sql, $prefix;
	$news_data = $sql->getall("SELECT * FROM {$prefix}_news ORDER BY id DESC LIMIT 3");
	if(empty($news_data)){
		echo "There is no news yet !";
	}
	elseif(file_exists("./styles/Common/news.template.php"))
	{
		include "./styles/Common/news.template.php";
	}
	else {
		echo "<p><font color=red>ERROR : Can't load the template, the file {$_SERVER["HTTP_HOST"]}/styles/Common/news.template.php is missing.</font></p>";
		exit;
		}
	}
	function viewnews($nid){
		global $sql, $prefix, $security;
		$nid = $security->protect_int($nid);
		$thisnews_data = $sql->get("SELECT * FROM {$prefix}_news WHERE id = '{$nid}'");
		if(!$thisnews_data){
			include("./modules/404.php");
		}
		else{
			if(file_exists("./styles/Common/news.template.php"))
			{
				include "./styles/Common/news.template.php";
			}
			else {
				echo "<p><font color=red>ERROR : Can't load the template, the file {$_SERVER["HTTP_HOST"]}/styles/Common/news.template.php is missing.</font></p>";
				exit;
			}
		}
	}
	function count_comment($newsid){
		global $sql, $prefix, $security;
		$newsid = $security->protect_int($newsid);
		$count = $sql->count("SELECT * FROM {$prefix}_comment WHERE idnews = '{$newsid}' AND is_sub = '0'");
		return $count;
	}
	function getcomment($newsid, $cid){
		global $sql, $prefix, $security;
		$cid = $security->protect_int($cid);
		$newsid = $security->protect_int($newsid);
		if($cid == 0)
		{
			$thiscomment = $sql->getall("SELECT * FROM {$prefix}_comment WHERE idnews = '{$newsid}' AND cid = '{$cid}'");
			return $thiscomment;
		}
		else
	 	{
			$thiscomment = $sql->getall("SELECT * FROM {$prefix}_comment WHERE idnews = '{$newsid}'");
			return $thiscomment;
		}
	}
	function get_all_comments($newsid){
		global $sql, $prefix, $security;
		$newsid = $security->protect_int($newsid);
		$comments = $sql->getall("SELECT * FROM {$prefix}_comment WHERE idnews = '{$newsid}' AND is_sub = '0' ORDER BY id DESC");
		return $comments;		
	}
	function display($newsid, $is_sub){
		global $security;
		$template = "./styles/Common/comments.template.php";
		$newsid = $security->protect_int($newsid);
		if($is_sub == 1){
			//newsid become sub_id
			$comments = $this->display_comments_subs($newsid);
			$count = $this->count_comments_subs($newsid);
			echo '<ul class="children">
				<li class="comment byuser comment-author-ylony bypostauthor even depth-3" id="li-comment-3">';
		}
		else {
		$comments = $this->get_all_comments($newsid);
		$count = $this->count_comment($newsid);
		}
		if(empty($comments)){
			echo "nothing to display";
			return false;
		}
		if(!file_exists($template)){
			echo "ERROR : cant open comment template";
			return false;
		}
		include($template);
		if($is_sub == 1){
			echo '</li></ul>';
		}		
		return true;
	}
	// not finished
	function displaycomment($comments, $newsid){
		$maxcomment = $this->count_comment($newsid);
		$i = 0;
		if(!$comments){
			echo '<meta http-equiv="refresh" content="0; URL=./?page=404">;';
		}
		if(file_exists("./styles/Common/comments.template.php"))
		{
			while ($i < $maxcomment){
				//generate_html($comments);
			}
		}
		else {
			echo "<p><font color=red>ERROR : Can't load the template, the file {$_SERVER["HTTP_HOST"]}/styles/Common/comments.template.php is missing.</font></p>";
			exit;
			}
	}
	function check_cid_nid_match($nid, $cid){
		global $sql, $prefix, $security;
		//Clean
		$nid = $security->protect_int($nid);
		$cid = $security->protect_int($cid);
		//
		$query = "SELECT * FROM {$prefix}_comment WHERE idnews = '{$nid}' AND id = '{$cid}'";
		$result = $sql->get($query);
		if(!$result){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	function new_comment($author, $core, $is_sub, $sub_id, $nid){
		global $sql, $prefix, $security;
		// On teste les composantes
		if(!empty($author) && !empty($core) && !empty($nid)){
			// Nettoyage et Attribution des variables
			$author = $security->clean($author);
			$core = $security->res($security->protect_string_bdd($core));
			$is_sub = $security->protect_int($is_sub);
			$sub_id = $security->protect_int($sub_id);
			$nid = $security->protect_int($nid);
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = date("d.m.y");
			//Check si c'est un sub
			if($sub_id == 0){
				$check = TRUE;
			}
			else{
				$check = $this->check_cid_nid_match($nid, $sub_id);
				$is_sub = 1;
			}
			if($check){
			// Insertion
				$query = "INSERT INTO {$prefix}_comment (idnews, is_sub, subid, author, core, ip, date) 
				VALUES ('{$nid}', '{$is_sub}', '{$sub_id}', '{$author}', '{$core}', '{$ip}', '$date')";
				$stmt = $sql->query($query);
				if($stmt){
					echo "TRUE";
					return TRUE;
				}
				else{
					echo "Oops, something went wrong";
					return FALSE;
				}
			}
			else{
				echo "Oops, something went wrong";
				return FALSE;
			}
		}
		echo "Merci de remplir tout les champs";
		return FALSE;
	}
	function count_comments_subs($commentid){
		global $sql, $prefix, $security;
		$commentid = $security->protect_int($commentid);
		$query = "SELECT * FROM {$prefix}_comment WHERE subid = '{$commentid}'";
		$nb_sub = $sql->count($query);
		return $nb_sub;
	}
	function display_comments_subs($commentid){
		global $sql, $prefix, $security;
		$commentid = $security->protect_int($commentid);
		$nb_sub = $this->count_comments_subs($commentid);
		 if($nb_sub > 0){
		 	$query = "SELECT * FROM {$prefix}_comment WHERE subid = '{$commentid}'";
		 	$sub_comments = $sql->getall($query);
		 	return $sub_comments;
		 }
		 else{
		 	return false;
		 }
	}
	function count_all_comments($newsid){
		global $sql, $prefix, $security;
		$newsid = $security->protect_int($newsid);
		$query = "SELECT * FROM {$prefix}_comment WHERE idnews = '{$newsid}'";
		$return = $sql->count($query);
		return $return;
	}
	function get_current_news_user($id){
		global $sql, $prefix, $security;
		$id = $security->protect_int($id);
		$query = "SELECT auteur FROM {$prefix}_news WHERE id = '{$id}'";
		$return = $sql->get($query);
		return $return["auteur"];		
	}
	function allow_edit_comments($user, $cid, $nid){
		global $sql, $prefix, $security;
		$user = $security->clean($user);
		$cid = $security->protect_int($cid);
		$nid = $security->protect_int($nid);
		$query = "SELECT core FROM {$prefix}_comment WHERE author = '{$user}' AND id = '{$cid}' AND idnews = '{$nid}'";
		$result = $sql->get($query);
		if($result){
			if(empty($result["core"])){
				return FALSE;
			}
			else{
				return $result["core"];
			}
		}
		else{
			return FALSE;
		}
	}
	function update_edit_comment($user, $cid, $nid, $new_core){
		global $sql, $prefix, $security;
		if(!empty($user) && !empty($cid) && !empty($nid) && !empty($new_core))
		{
			$user = $security->clean($user);
			$cid = $security->protect_int($cid);
			$nid = $security->protect_int($nid);
			$new_core = $security->res($security->protect_string_bdd($new_core));	
			$query = "UPDATE {$prefix}_comment SET core = '{$new_core}' WHERE author = '{$user}' AND id = '{$cid}' AND idnews = '{$nid}'";
			$result = $sql->query($query);
			if($result){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}	
	}
}	
$news = new news;