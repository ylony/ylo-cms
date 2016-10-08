<?php
if(isset($_SESSION["ycms_adm_user"]))
{ 
if(isset($_POST["sub"]) OR isset($_POST["crypt"])){
 echo crypt($_POST["crypt"]);
}
else {

?>
<div class="box">
<form action="" method="POST">
<p class="title">Gestion de la boutique</p>
<input type="text" name="crypt">
<input type="submit" name="sub">
</form>
</div>
<?php } }?>