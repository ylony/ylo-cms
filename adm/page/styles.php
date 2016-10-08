<?php 
if(isset($_SESSION["ycms_adm_user"]))
{
	?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Styles
        <small>Manage the style of your site</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Général</a></li>
        <li class="active">Styles</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Manage current scripts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		<?php
		if(isset($_POST["sub_style_mod"]))
		{
			if(isset($_POST["style_old"]) OR isset($_POST["style_mod"]))
			{
				$style_mod = $_POST["style_mod"];
				$style_old = $_POST["style_old"]; ?>
				<p class="err"><center><?php
				echo adm_style_modif($style_mod, $style_old);?>
				</center></p>
			<?php }
			else {
				echo '<p class="err">ERREUR : Veuillez réessayer</p>';
			}
			echo '<meta http-equiv="refresh" content="3; URL='.$_SERVER["REQUEST_URI"].'">';
				}
		else { ?>
	<form action="" method="POST"><p class="title">Modification du style par défaut</p></br></br><center></br>
	<p>Style actuel : <?php adm_style_now(); ?></p>
	<p>Choisir un style : <select name="style_mod">
    <?php adm_style_list(); ?>
</select></p></br><button type="submit" name="sub_style_mod" class="btn_enter">Valider</button></center>
</form><?php } ?></div>
<div class="right_content">
<?php
		if(isset($_POST["sub_style_add"]) OR isset($_POST["style_install"]))
		{
			$style_install = $_POST["style_install"]; ?>
			<p class="err"><center><?php
			echo adm_style_install($style_install);?>
			</center></p>
			<?php
			echo '<meta http-equiv="refresh" content="3; URL='.$_SERVER["REQUEST_URI"].'">';
		}
		else { ?>
<p class="title">Ajouter un style</p></br></br><center>
	<p>Le fichier doit être placé dans le dossier "styles" situé à la racine de votre site pour pouvoir être visualisé ci-dessous.</p>
	</br><form action="" method="POST"><p>Installer un style : 
    <?php adm_style_list_files(); //<button> dans ./include/core.php?></center>
</form>
<?php } ?>
</div>
</p></br></br>
<?php
		if(isset($_GET["c"])) {
			if(isset($_POST["sub_style_del_confirm"])) {
					if(intval($_POST["sub_style_del_confirm"]) == 0) {
						header('Location: '.$_SERVER["REQUEST_URI"].'');
					}
					elseif(intval($_POST["sub_style_del_confirm"]) >= 1) {
						$style_del = $_POST["style_del"];?>
						<p class="err"><center><?php
						echo adm_style_del($style_del);?>
						</center></p>
						<?php
					echo '<meta http-equiv="refresh" content="3; URL=?page=styles">';
					}
		}
		else {
		echo '<meta http-equiv="refresh" content="0; URL=?page=styles">';
		}
	}
		else {
		if(isset($_POST["sub_style_del"]))
		{
			if (isset($_POST["style_del"])) {
				?>
				<p class="err">Voulez-vous vraiment désinstaller le style "
				<?php echo htmlspecialchars($_POST["style_del"]); ?>"</p>
				<center><form action="?page=styles&c=1" method="POST"><p><button type="submit" name="sub_style_del_confirm" class="btn_out" value="0">Non</button> 
				<button type="submit" name="sub_style_del_confirm" class="btn_enter" value="1">Oui</button>
				<?php echo '<input type="hidden" name="style_del" value="'.$_POST["style_del"].'">'; ?>
				</form></p></center><?php
				}
				else {
				echo '<p class="err"><font color="red">Veuillez choisir un style</font></p>';
					}
			} else {?>
	<form action="" method="POST"><p class="title">Désinstaller un style</p></br></br><center></br>
		<p>Choisir un style : <select name="style_del">
    <?php adm_style_list(); ?>
</select></p></br></br><button type="submit" name="sub_style_del" class="btn_enter">Valider</button></center>
</form><?php }}}?></div></div></form></center></form></center></div></div></section></div>
