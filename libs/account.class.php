<?php
/*
	generate_key -> Génère une chaîne de 40 caractères aléatoire
	reg_check_mail -> Vérfie si une email est déjà utilisé (RETURN FALSE/TRUE)
	register -> Inscrit une personne
	activate -> Active le commpte d'une personne
	check_ban_ip -> Regarde si l'ip du visiteur est banni ou non
	check_ban_account -> Regarde si le compte d'utilisateur est banni ou non
	login -> Connecte une personne
	write_name -> Check dans la bdd le nom et le prénom de l'utilisateur et l'écrit
	forgot_password -> permet d'envoyer un email avec un lien permettant de reset le mot de passe de l'utilisateur
	forgot_password_proceed -> permet de reset le mot de passe dans la bdd et envoie le nouveau via email
*/
class account {
	function generate_key(){
		$key = md5(microtime(TRUE)*100000);
		$key = substr($key, 0, 40);
		sleep(1);
		return $key;
	}
	function reg_check_mail($mail){
		global $sql, $security, $prefix;
		$mail = $security->res($security->protect_string_bdd($mail));
		$stmt = $sql->get("SELECT email FROM {$prefix}_account WHERE email = '{$mail}'");
		$check_mail = $stmt;
		if($check_mail['email'] == NULL){
			return FALSE;
		}
			else {
				return TRUE;
			}
	}
	function reg_check_displayname($displayname){
		global $sql, $security, $prefix;
		$displayname = $security->res($security->protect_string_bdd($displayname));
		$stmt = $sql->get("SELECT display_name FROM {$prefix}_account WHERE display_name = '{$displayname}'");
		$check_display_name = $stmt;
		if($check_display_name['display_name'] == NULL){
			return FALSE;
		}
			else {
				return TRUE;
			}
	}
	function regen_keys($string1, $string2){
		global $sql, $prefix;
		$newkey1 = $this->generate_key();
		$newkey2 = $this->generate_key();
		$stmt = $sql->query("UPDATE {$prefix}_account SET key1 = '{$newkey1}', key2 = '{$newkey2}' WHERE key1 = '{$string1}' AND key2 = '{$string2}'");
		if($stmt){
			return 0;
		}
		else{
			return "Impossible de générer une nouvelle clé.";
		}
	}
	function register($reg_first_name, $reg_last_name, $reg_email, $reg_display_name, $reg_password, $reg_password_confirm)
		{
			global $sql, $security, $prefix, $SiteName, $adresse;
			$reg_first_name = $security->clean($reg_first_name);
			$reg_last_name = $security->clean($reg_last_name);
			$reg_display_name = $security->clean($reg_display_name);
			$reg_email = $security->res($security->protect_string_bdd($reg_email));
			if(empty($reg_display_name)){
				return "Vous devez choisir un pseudo !";
				exit;
			}
			if($reg_password == $reg_password_confirm) 
				{
					if(strlen($reg_password) > 3 & strlen($reg_password) < 21)
						{
							$reg_password = $security->crypt($reg_email, $reg_password);
							$reg_date = date("Y-m-d H:i:s");
							$reg_ip = $_SERVER["REMOTE_ADDR"];
							$reg_validate = 0;
							$reg_adm = 0;
							$key1 = $this->generate_key();
							$key2 = $this->generate_key();
							$stmt = $sql->query("INSERT INTO {$prefix}_account (first_name, last_name, email, password, adm, reg_date, ip, validate, key1, key2, display_name) VALUES ('{$reg_first_name}', '{$reg_last_name}', '{$reg_email}', '{$reg_password}', '{$reg_adm}', '{$reg_date}', '{$reg_ip}', '{$reg_validate}', '{$key1}', '{$key2}', '{$reg_display_name}')");
							if($stmt)
							{

								$destinataire = $reg_email;
								$sujet = "Activate your account";
								$entete = "From: noreply@{$adresse}" ;
								$message = "Welcome to {$SiteName},
								To activate your account, please hit the link bellow
								or copy/paste it in your web browser.
								<url>{$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}&k='.urlencode($key1).'&l='.urlencode($key2).'</url>
								---------------
								Remember :
								Email : {$reg_email}
								Mot de passe : {$reg_password}
								Activation code : {$key1}.{$key2}
								---------------
								This is an automatic mail, Please don't reply.";
								$sub_mail = mail($destinataire, $sujet, $message, $entete);
								if($sub_mail){
									$msg = "Welcome, a link has been sent to {$reg_email}, please confirm your account.";
									return 42;
								}
								else {
									$err = "There is a problem with the mail() function, please check your server settings";
									return $err;
								} 	
							}
							else 
							{
								$error = "MYSQL ERROR";
								return $error;
							}
					}
					else
						{
							$error = "Password must contain between 4 and 20 characters";
							return $error;
						}
			}
			else 
				{
					$error = "Les mots de passes ne correspondent pas.";
					return $error;
				}
	}
	function activate($key1, $key2){
		global $sql, $prefix;
		if(empty($key1) && empty($key2)){
			return -1;
		}
	$stmt = $sql->get("SELECT validate, key1, key2 FROM {$prefix}_account WHERE key1 = '$key1' AND key2 = '$key2'");
	$check_activate = $stmt;
	if($check_activate == NULL){
		$err = "Veuillez vérifier votre clé.";
		return $err;
	}
	else {
				if($check_activate["validate"] == 1) {
				$err = "Erreur, ce compte est déjà activé.";
				return $err;
				}
				else{
				    $stmt = $sql->query("UPDATE {$prefix}_account SET validate = 1 WHERE key1 = '$key1' AND key2 = '$key2'");
         			$msg = "Ce compte est maintenant activé, vous pouvez vous connecter.";
         			return $msg;
			}
		}
	}
	function check_ban_ip($ip){
		global $sql, $prefix;
		$stmt = $sql->get("SELECT * FROM {$prefix}_ban WHERE ip = '{$ip}'");
		if($stmt == NULL){
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	function check_ban_account($account){
		global $sql, $prefix;
		$stmt = $sql->get("SELECT * FROM {$prefix}_ban WHERE account = '{$account}'");
		if($stmt == NULL){
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	function login($log_email, $log_password){
		global $sql, $prefix, $security;
		$log_email = $security->res($security->protect_string_bdd($log_email));
		$log_password = $security->crypt_login($log_email, $log_password);
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '$log_email'");
		$check_account = $stmt;
		if($check_account == NULL){
			$err = "This account doesn't exist, please try again.";
			return $err;
		}
		else {
			if($check_account["validate"] == 1){
				if(password_verify($log_password, $check_account['password'])){
					return "ok";
				}
				else {
					$err = "Email or password invalid.";
					return $err;
				}
			}
			else {
				$err = "Please activate your account first.";
				return $err;
			}
		}
	}
	function adm_login($log_email, $log_password){
		global $sql, $prefix, $security;
		$log_email = $security->res($security->protect_string_bdd($log_email));
		$log_password = $security->crypt_login($log_email, $log_password);
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$log_email}'");

		$check_account = $stmt;
		if($check_account == NULL){
			$err = "This account doesn't exist.";
			return $err;
		}
		else {
			if($check_account["adm"] == 1){
				if(password_verify($log_password, $check_account['password'])){
					return TRUE;
				}
				else {
					$err = "Email or password invalid.";
					return $err;
				}
			}
			else {
				$err = "Email or password invalid.";
				return $err;
			}
		}
	}	
	function write_name($email){
		global $sql, $security, $prefix;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$check_name = $stmt;
		$name = $check_name["first_name"]." ".$check_name["last_name"];
		return $name;
	}
	function get_reg_date($email){
		global $sql, $security, $prefix;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$get_reg_date = $stmt;
		$reg_date = $get_reg_date["reg_date"];
		return $reg_date;
	}
	function get_reg_ip($email){
		global $sql, $security, $prefix;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$get_reg_ip = $stmt;
		$ip = $get_reg_ip["ip"];
		return $ip;
	}
	function get_display_name($email){
		global $sql, $security, $prefix;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$get_display_name = $stmt;
		$displayname = $get_display_name["display_name"];
		return $displayname;
	}
	function get_key($email){
		global $sql, $security, $prefix;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$get_key = $stmt;
		$key = $get_key["key1"].".".$get_key["key2"];
		return $key;
	}	
	function forgot_password($email){
		global $sql, $security, $prefix, $adresse, $SiteName;
		$email = $security->res($security->protect_string_bdd($email));
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE email = '{$email}'");
		$check_forgot_password = $stmt;
		if($check_forgot_password == NULL){
			$err = "No account are linked to this email address.";
			return $err;
		}
		else {
				$destinataire = $email;
				$sujet = "Password recovery";
				$entete = "From: noreply@{$adresse}" ;
				$message = "Hello,
				To proceed the password recovery system please hit the link bellow :
				---------------
				<url>{$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}&k={$check_forgot_password["key1"]}&l={$check_forgot_password["key2"]}</url>
				---------------
				If you don't ask for a password recovery please ignore this and contact us on our website.
				---------------
				This is an automatic mail, Please don't reply.";
				$sub_mail = mail($destinataire, $sujet, $message, $entete);
				if($sub_mail){
					$msg = "Well done, a link has been sent to {$email}, please check your emails to proceed.";
					return $msg;
				}
				else {
						$err = "There is a problem with the mail() function, please check your server settings";
						return $err;
					} 	
		}
	}
	function forgot_password_proceed($string1, $string2){
		global $sql, $security, $prefix, $adresse, $nom;
		$string1 = $security->clean($string1);
		$string2 = $security->clean($string2);
		$stmt = $sql->get("SELECT * FROM {$prefix}_account WHERE key1 = '{$string1}' AND key2 = '{$string2}'");
		$grab_info = $stmt;
		if($grab_info == NULL){
			$err = "Oups, something goes wrong";
			return $err;
		}
		else {
		$email = $grab_info["email"];
		$new_password = substr($this->generate_key(), 0, 8);
		$new_password_hash = $security->crypt($email, $new_password);
		$stmt = $sql->query("UPDATE {$prefix}_account SET password = '{$new_password_hash}' WHERE key1 = '{$string1}' AND key2 = '{$string2}'");
        if($stmt) {
				$destinataire = $email;
				$sujet = "New password";
				$entete = "From: noreply@{$adresse}" ;
				$message = "Hello again,
				Your new password :
				---------------
				{$new_password}
				---------------
				This is an automatic mail, Please don't reply.";
				$sub_mail = mail($destinataire, $sujet, $message, $entete);
				echo $this->regen_keys($string1, $string2);
				if($sub_mail){
					$msg = "Your new password has been sent to your email address.";
					return $msg;
				}
				else {
						$err = "There is a problem with the mail() function, please check your server settings";
						return $err;
					} 	
        }
        else {
        	$err = "Oups, something goes wrong !";
        	return $err;
        }
		}
	}
	function ucp_forgot($login, $old_password, $new_password, $new_password_confirm){
		global $sql, $security, $prefix;
		$check_pass_match = $this->login($login, $old_password);
		if($check_pass_match == 1){
			if($new_password == $new_password_confirm){
				$new_password_hash = $security->crypt($login, $new_password_confirm);
				$stmt = $sql->query("UPDATE {$prefix}_account SET password = {$new_password_hash} WHERE email = '{$login}'");
        		$check_update = $stmt;
        		if($check_update) {
        			$err = "Done";
        			return $err;
        		}
        		else {
        			$err = "Something goes wrong !";
        			return $err;
        		}
			}
			else {
				$err = "Passwords don't match";
				return $err;
			}
		}
		else {
			$err = "Wrong old password.";
			return $err;
		} 
	}
	function check_user_rank($name){
		global $sql, $security, $prefix;
		$email = $security->clean($name);
		$query = "SELECT rank_id FROM {$prefix}_account WHERE display_name = '{$name}'";
		$result = $sql->get($query);
		return $result['rank_id'];
	}
	function get_rank_info($rankid){
		global $sql, $security, $prefix;
		$rankid = $security->protect_int($rankid);
		$query = "SELECT * FROM {$prefix}_ranks WHERE id = '{$rankid}'";
		$result = $sql->get($query);
		return $result;
	}
	function write_name_w_color($name){
		$user_rank = $this->check_user_rank($name);
		$rank_data = $this->get_rank_info($user_rank);
		echo "<font color=".$rank_data["color"].">".$name."</font>";
	}
}
$account = new account;