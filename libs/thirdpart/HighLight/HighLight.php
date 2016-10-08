<?php
/**
 * @package HighLightPHP for Ylo - CMS
 * @copyright Copyright 2016, Ylony & highlightjs.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 */
class HighLight{
	public function init($style){
		echo '<link rel="stylesheet" href="./styles/Common/css/default.css">
			  <script src="./styles/Common/js/highlight.pack.js"></script>
			  <script>hljs.initHighlightingOnLoad();</script>';
		if(!empty($style)){
			if(file_exists('./styles/Common/css/'.$style.'.css')){
				echo '<link rel="stylesheet" href="./styles/Common/css/'.$style.'.css">';
			}
			else{
				echo "Warning the selected highlight theme is not found.";
			}
		}
	}
	public function file_handle($file){
		if(file_exists($file)){
			$file = fopen($file, "r");
			if($file){
				while($lign = fgets($file)){
					echo htmlentities($lign);
				}
			}
			else{
				return "Can't open this file";
			}
		}
		else{
			return "File not found";
		}
	}
	public function write($style, $file){
		$this->init($style);
		echo "<pre><code>";
		$this->file_handle($file);
		echo "</pre></code>";
	} 
}
$highlight = new HighLight;