<?php 
if(isset($_GET["mid"])){
	get_movie_data($_GET["mid"]);
}else{
	list_movie();
}