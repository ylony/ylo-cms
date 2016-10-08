<?php
class module{
	public function count_module_actif(){
		global $sql, $prefix;
		$sth = $sql->count("SELECT * FROM {$prefix}_module WHERE actif = 1 ORDER BY id");
		return $sth;
	}

	public function get_module_actif(){
		global $sql, $prefix;
		$sth = $sql->get("SELECT * FROM {$prefix}_module WHERE actif = 1 ORDER BY id");
		return $sth;
		}

	public function include_module_actif(){
		$count = $this->count_module_actif();
		$files = $this->get_module_actif();
		$i = 0;
		while ($i < $count){
			require_once("./modules/{$files[$i]["path"]}");
			$i++;
			}
	} 
}
$module = new module;