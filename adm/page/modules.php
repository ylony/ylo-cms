<?php if(isset($_SESSION["ycms_adm_user"]))
{ ?><div class="box">
<p class="title">Gestion des modules</p>
<p class="sub_title">Liste des modules : </p>
<table class="table"><tr><td>Nom</td><td>Path</td><td>Actif</td><td>Action</td></tr>
<?php
adm_get_module();
?>
</table>
</div>
<?php } ?>