<?php
session_start();
/*
   YLO-CMS par Ylony 
   Version 0.4 ALPHA
*/
  //if (file_exists("./install")){

	//	header('Location: ./install');

	//}
//CORE INIT // login path or adm path
$folder=$_SERVER["REQUEST_URI"];$folder2=preg_match("#/adm/#i", "'.$folder.'");if($folder2 == TRUE){$folder2 ="/adm/";}else{$folder2=preg_match("#/login/#i", "'.$folder.'");if($folder2 == TRUE){$folder2 = "/login/";}else{$folder2="";}}if($folder2 == "/adm/"){$path = "../";}else{if($folder2 == "/login/"){$path = "../";}else{$path = ".";}}$folder=substr($_SERVER["REQUEST_URI"], -10, 10);if($folder == "page=adm"){header('Location: ./?page=404');}

	require_once("{$path}/includes/config.php");
	require_once("{$path}/libs/sql.class.php");
	require_once("{$path}/libs/news.class.php");
	require_once("{$path}/libs/styles.class.php");
	require_once("{$path}/libs/html.class.php");
	require_once("{$path}/libs/security.class.php");
	require_once("{$path}/libs/page.class.php");
	require_once("{$path}/libs/module.class.php");
	require_once("{$path}/libs/account.class.php");
	require_once("{$path}/libs/item.class.php");
	require_once("{$path}/libs/paypal.class.php");
	require_once("{$path}/libs/upload.class.php");
	require_once("{$path}/libs/script.class.php");
	require_once("{$path}/libs/movies.class.php");
	require_once("{$path}/libs/logs.class.php");

//
// PLUGIN GOES HERE
require_once("{$path}/libs/thirdpart/HighLight/plugin.php");
//
function html_meta()
{
	global $html;
	$html->write_tags();
}
function copyr()
{
	global $html;
	$html->write_copyr();		
}
function style () {
	global $styles;
	$inc_style = $styles->get_style();
	$styles->include_style($inc_style);
	return $inc_style;
}
function get_current_style_path(){
	global $styles;
	return $styles->get_current_style_path();
}
$style_path = get_current_style_path(); // Limit queries number
function news(){
  	global $news;
  	$result = $news->shownews();
  }
function viewnews($id){
  	global $news;
  	$result = $news->viewnews($id);	
}
function page(){
	global $page;
	if(!empty($_GET['page'])){
			$page->grab_page($_GET['page']);
 		}
  	else {
  		//show_module(); // scroll
	 	news(); // blog
 	 } 
}
function show_module(){
	global $module;
	$module->include_module_actif();
}
function register($reg_first_name, $reg_last_name, $reg_email, $reg_display_name, $reg_password, $reg_password_confirm){
	global $account;
	$check = $account->reg_check_mail($reg_email);
	$checkdisplay = $account->reg_check_displayname($reg_display_name);
	if(($check == FALSE) && ($checkdisplay == FALSE)){
	$return = $account->register($reg_first_name, $reg_last_name, $reg_email, $reg_display_name, $reg_password, $reg_password_confirm);
	return $return;
	}
	elseif($check == TRUE){
		$return = "Email already used";
		return $return;
	}
	elseif($checkdisplay == TRUE){
		$return = "Pseudo déjà utilisé";
		return $return;
	}
}
function login($log_email, $log_password) {
	global $account;
	$login = $account->login($log_email, $log_password);
	if ($login == "ok") {
		$_SESSION["login"] = TRUE;
		$_SESSION["user"] = $log_email;
		header('Location: ../');
	}
	else{
		return $login;
	}
}
function activate($key1, $key2){
	global $security, $account;
	$key1 = $security->clean($key1);
	$key2 = $security->clean($key2);
	$result = $account->activate($key1, $key2);
	return $result;
}
function activatepost($key){
	global $security, $account;
	if(!empty($key)){
		$key = explode(".", $key);
		$key1 = $key["0"];
		$key2 = $key["1"];
		$key1 = $security->clean($key1);
		$key2 = $security->clean($key2);
		$result = $account->activate($key1, $key2);
		return $result;
	}
	return "Veuillez vérifier votre clé.";
}
function check_ban_ip(){
	global $account;
	$ip = $_SERVER["REMOTE_ADDR"];
	$check_ban_ip = $account->check_ban_ip($ip);
	return $check_ban_ip;
	}
function write_name($email){
	global $account;
	$name = $account->write_name($email);
	return $name;
}
function get_reg_date($email){
	global $account;
	$reg_date = $account->get_reg_date($email);
	return $reg_date;
}
function get_key($email){
	global $account;
	$key = $account->get_key($email);
	return $key;
}
function get_reg_ip($email){
	global $account;
	$reg_ip = $account->get_reg_ip($email);
	return $reg_ip;
}
function get_display_name($email){
	global $account;
	$display_name = $account->get_display_name($email);
	return $display_name;
}
function forgot_password($email){
	global $account;
	$forgot_password = $account->forgot_password($email);
	return $forgot_password;
}
function forgot_password_proceed($string1, $string2){
	global $account;
	$forgot_password_proceed = $account->forgot_password_proceed($string1, $string2);
	return $forgot_password_proceed;
}
function calcul_price_placements(){
	global $item;
	$item = intval($item->calcul_price_placements());
	return $item;
}
function item_check($item_token){
	global $item;
	$item_info = $item->get_item_info($item_token);
	if ($item_info == FALSE){
		header('Location: ./?page=404');
	}
	else {
		return $item_info;
	}
}
function ucp_forgot($login, $old_password, $new_password, $new_password_confirm){
	global $account;
	$ucp_forgot = $account->ucp_forgot($login, $old_password, $new_password, $new_password_confirm);
	return $ucp_forgot;
}
function paypal($price)
{
	global $paypal;
	echo $paypal->write_item_data($price);
}
function upload($file)
{
	global $upload;
	$CurrentUpload = $upload->GetUploadStmt($file);
	return $CurrentUpload;
}
function display($newsid, $is_sub){ //comment
	global $news;
	$dis = $news->display($newsid, $is_sub);
	return $dis;
}
function count_comment($newsid){
	global $news;
	$count = $news->count_all_comments($newsid);
	return $count;
}
function new_comment($author, $core, $is_sub, $sub_id, $nid){
	global $news;
	$result = $news->new_comment($author, $core, $is_sub, $sub_id, $nid);
	return $result;
}
function print_debug(){
	global $sql, $debug;
		if($debug == TRUE){
			$nbquery = $sql->i;
			$querytime = $sql->totaltime;
			echo " | Debug : ".$nbquery." requête(s) exécuté(es) en ".$querytime." ms.";	
		}
		else{
			return 0;
		}
}
function write_name_w_color($name){
	global $account;
	$account->write_name_w_color($name);
}
function get_current_news_user($id){
	global $news;
	$result = $news->get_current_news_user($id);
	return $result;
}
function allow_edit_comments($user, $cid, $nid){
	global $news;
	$result = $news->allow_edit_comments($user, $cid, $nid);
	return $result;
}
function update_edit_comment($user, $cid, $nid, $new_core){
	global $news;
	$result = $news->update_edit_comment($user, $cid, $nid, $new_core);
	return $result;
}
function get_user_rank($email){
	global $account;
	$result = $account->check_user_rank(get_display_name($email));
	$result = $account->get_rank_info($result);
	return $result["name"];
}
function add_script($script_name, $script_cat, $script_description, $script_source, $script_source_file, $script_win, $script_lin, $script_author){
	global $script;
	$result = $script->add_script($script_name, $script_cat, $script_description, $script_source, $script_source_file, $script_win, $script_lin, $script_author);
	return $result;
	}
function list_script(){
	global $script;
	$script->list_script();
}
function get_all_script(){
	global $script;
	$result = $script->get_all_script();
	return $result;
}
function count_all_script(){
	global $script;
	$result = $script->count_all_script();
	return $result;
}
function unpack_script($source_file) {
	global $script;
	$result = $script->un_pack($source_file);
	echo $result;
	$result = $script->generate_map("../tmp/".$result."/" , $result, $source_file);
	return $result;
}
function get_script_data($id){
	global $script;
	$result = $script->get_script_data($id);
	return $result;
}
function convert_map_file($map){
	global $script;
	$rst = $script->convert_map_file($map);
	return $rst;
}
function count_map_file($map){
	global $script;
	$rst = $script->count_map_file($map);
	return $rst;
}
function list_movie(){
	global $movie;
	$list = $movie->list_movie();
	return $list;
}
function get_movie_data($id){
	global $movie;
	$data = $movie->get_movie_data($id);
	return $data;	
}
function get_dl_link($id){
	global $script;
	return $script->get_dl_link($id);
}
?>