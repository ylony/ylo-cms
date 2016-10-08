<?php
			if(isset($_GET["nid"]))
			{
				$nid = $security->protect_int($_GET["nid"]);
				viewnews($nid);
			}
			else
			{
				news();
			}
			?>