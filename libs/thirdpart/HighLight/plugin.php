<?php
/**
 * @package HighLightPHP
 * @copyright Copyright 2016, Ylony & highlightjs.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 */
/** Config area **/
$style = 'arta';
/**/
require_once("HighLight.php");
function write($file){
	global $style, $highlight;
	$result = $highlight->write($style, $file);
	return $result;
}


