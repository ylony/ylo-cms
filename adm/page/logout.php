<?php
if(isset($_SESSION["ycms_adm_user"]))
{   
session_destroy();
header('Location: ./');
exit();
}?>