<?php
class html {
	function write_copyr() {
		global $SiteName;
		$y = date("Y");
		echo '© '.$y.' '.$SiteName.'';
	}
	function write_tags() {
			global $SiteName, $keywords, $description;
		echo '<meta name="description" content="'.$description.'"/>';
		echo '<meta name="keywords" content="'.$keywords.'"/>';
		echo '<title>'.$SiteName.'</title>';
	}
}
$html = new html;