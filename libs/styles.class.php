<?php
class styles {
	public $get_style = array();
	public function get_style(){
		global $sql, $prefix;
		$style = $sql->get("SELECT name FROM {$prefix}_styles WHERE actif = 1");
		if (isset($style["name"])) {
			return $style["name"];
			}
		else {
			echo '<p><font color="red">ERROR : No style selected.</font></p>';
			exit;
			}
		}
	public function include_style($style){
			if(file_exists("./styles/{$style}/main.php"))
	{
		include "./styles/{$style}/main.php";
	}
	else {
		echo "<p><font color=red>ERROR : Can't load {$style}, the file {$_SERVER["HTTP_HOST"]}/styles/{$style}/main.php is missing.</font></p>";
		exit;
	}
	return $style;
	}
	public function get_current_style_path(){
		$current_style = $this->get_style();
		$current_style_path = "./styles/{$current_style}";
		return $current_style_path;
	}
}
$styles = new styles;