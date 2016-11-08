<?php 
/*
@ClassName : 	Logs Manager
@Author    :	Ylony
@Date 	   :	08/11/2016 
*/

class logs 
{
	function __construc($record, $type)
	{
		global $logs; // From config.php TRUE or FALSE
		if($logs)
		{
			$time = $this->GetCurrentTime();
			$color = $this->GetLogColor($type):
			$write = $this->Write($record, $time, $color, $type);
			if(!$write)
			{
				$rst = $this->CheckServer();
				if(!$rst)
				{
					echo "Problème interne du serveur.";
				}
			}	
		}
		else
			return -1;
	}
}


?>