<?php 
/*
@ClassName : 	Logs Manager
@Author    :	Ylony
@Date 	   :	08/11/2016 
*/

class logs 
{
	public function __construct($record, $type)
	{
		global $logs; // From config.php TRUE or FALSE
		if($logs)
		{
			$time = $this->GetCurrentTime();
			$color = $this->GetLogColor($type);
			$write = $this->write($record, $time, $color, $type);
			if($write == -1)
			{
				$rst = $this->CheckServer();
				if($rst == -1)
				{
					echo "Problème interne du serveur can't record logs.";
				}
			}	
		}
		else
			return -1;
	}
	private function GetCurrentTime()
	{
		$day = "[".date("d.m.y")."]";
		$min = "[".date("H:i:s")."]";
		return $day.$min;
	}
	private function GetLogColor($type)
	{
		$color = array('SQL' => '#F6DC12',
					   'ok' => '#008000',
					   'fail' => '#D10000');
		return $color[$type];
	}
	private function write($record, $time, $color, $type)
	{
		global $logs_folder; // From config.php recommended ./logs
		if(!file_exists($logs_folder))
		{
			$rst = mkdir($logs_folder);
			if(!$rst)
				return -1;
		}

		if($type == "SQL")
			$file = "sql.html";
		else
			$file = "site.html";

		$log_file = fopen($logs_folder.$file, "a+");
		fputs($log_file, $time." <font color=".$color.">".$record."</font></br>\n");
		return 0; 
	}
	private function CheckServer()
	{
		$disk = disk_free_space("./");
		if ($disk<10000000)
		{
			echo "Le disque dur est plein.";
			return 0;
		}
		return -1;
	}
}


?>