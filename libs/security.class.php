<?php
/*
	protect_int -> Force une variable à être un nombre
	protect_string -> Empêche l'insertion de slash et de balise html dans la bdd
	clean -> Enleve les espaces et quotes d'une chaîne de caractère
	crypt -> Encrypte deux chaînes de caractères pour en former qu'une seule
	crypt_login -> Encrypte deux chaînes de caractères pour en former qu'une seule sans password_hash(); pour pouvoir utiliser password_verify();
*/
class security {
	function protect_int($string){
		$string = intval($string);
		return $string;
	}
	function protect_string_bdd($string){
 		$string = stripslashes(htmlentities($string));
 	   	return $string;
	}
	function clean($string){
		$clean = preg_replace("/[^A-Za-z0-9_]/", "", $string);
		return $clean;
	}
	function crypt($string1, $string2){
		$string_sha1 = SHA1(strtoupper($string1) . ":" . strtoupper($string2));
		$string_final = password_hash($string_sha1, PASSWORD_DEFAULT);
		return $string_final;
	}
	function crypt_login($string1, $string2){
	$string_sha1 = SHA1(strtoupper($string1) . ":" . strtoupper($string2));
	$string_final = $string_sha1;
	return $string_final;
	}
	function url($str){
		$str = urlencode($str);
		return $str;
	}
	function res($str){
		global $sql;
		$sqlc = $sql->connect();
		$str = $sqlc->real_escape_string($str);
		$sqlc->close();
		return $str;
	}
}
$security = new security;