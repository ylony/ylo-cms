<?php
/*

*/
class item {
	function get_price_item(){
		/* 
			SQL intval();
		*/
			$price["division"] = "20.00";
			$price["wins"] = "5.00";
			$price["placements"] = "30.00";
			$price["promote"] = "15.00";
			return $price;
	}
function calcul_price_division($big_division1, $division1, $big_division2, $division2){
		$d1 = $big_division1.$division1;
		$d2 = $big_division2.$division2;
		if ($d1 == "BronzeV") {
			$points = 1;
		}
		if ($d1 == "BronzeIV") {
			$points = 2;
		}
		if ($d1 == "BronzeIII") {
			$points = 3;
		}
		if ($d1 == "BronzeII") {
			$points = 4;
		}
		if ($d1 == "BronzeI") {
			$points = 5;
		}
		if ($d1 == "SilverV") {
			$points = 6;
		}
		if ($d1 == "SilverIV") {
			$points = 7;
		}
		if ($d1 == "SilverIII") {
			$points = 8;
		}
		if ($d1 == "SilverII") {
			$points = 9;
		}
		if ($d1 == "SilverI") {
			$points = 10;
		}
		if ($d1 == "GoldV") {
			$points = 11;
		}
		if ($d1 == "GoldIV") {
			$points = 12;
		}
		if ($d1 == "GoldIII") {
			$points = 13;
		}
		if ($d1 == "GoldII") {
			$points = 14;
		}
		if ($d1 == "GoldI") {
			$points = 15;
		}
		if ($d1 == "PlatineV") {
			$points = 16;
		}
		if ($d1 == "PlatineIV") {
			$points = 17;
		}
		if ($d1 == "PlatineIII") {
			$points = 18;
		}
		if ($d1 == "PlatineII") {
			$points = 19;
		}
		if ($d1 == "PlatineI") {
			$points = 20;
		}
		if ($d2 == "BronzeV") {
			$points2 = 2;
		}
		if ($d2 == "BronzeIV") {
			$points2 = 2;
		}
		if ($d2 == "BronzeIII") {
			$points2 = 3;
		}
		if ($d2 == "BronzeII") {
			$points2 = 4;
		}
		if ($d2 == "BronzeI") {
			$points2 = 5;
		}
		if ($d2 == "SilverV") {
			$points2 = 6;
		}
		if ($d2 == "SilverIV") {
			$points2 = 7;
		}
		if ($d2 == "SilverIII") {
			$points2 = 8;
		}
		if ($d2 == "SilverII") {
			$points2 = 9;
		}
		if ($d2 == "SilverI") {
			$points2 = 10;
		}
		if ($d2 == "GoldV") {
			$points2 = 11;
		}
		if ($d2 == "GoldIV") {
			$points2 = 12;
		}
		if ($d2 == "GoldIII") {
			$points2 = 13;
		}
		if ($d2 == "GoldII") {
			$points2 = 14;
		}
		if ($d2 == "GoldI") {
			$points2 = 15;
		}
		if ($d2 == "PlatineV") {
			$points2 = 16;
		}
		if ($d2 == "PlatineIV") {
			$points2 = 17;
		}
		if ($d2 == "PlatineIII") {
			$points2 = 18;
		}
		if ($d2 == "PlatineII") {
			$points2 = 19;
		}
		if ($d2 == "PlatineI") {
			$points2 = 20;
		}	
		$price = $points2-$points;
		$price = $price*20;
		return $price;
	}
	function calcul_price_wins($wins){
		$price = $this->get_price_item();
		$price = $price["wins"];
		$price = $wins*$price;
		return $price;	
	}
	function calcul_price_promote(){
		$price = $this->get_price_item();
		$price = $price["promote"];
		return $price;	
	}
	function calcul_price_placements(){
		$price = $this->get_price_item();
		$price = $price["placements"];	
		return $price;	
	}
	function get_item_info($item_token){
		global $security, $connexion, $prefix;
		$item_token = $security->protect_string_bdd($item_token);
		$stmt = $connexion->get("SELECT * FROM {$prefix}_items WHERE item_token = {$item_token}");
		$check_item = $stmt;
		if($check_item == NULL){
			return FALSE;
		}
			else {
				return $check_item;
			}
	}
}
$item = new item;