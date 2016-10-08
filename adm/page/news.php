<?php
if(isset($_SESSION["ycms_adm_user"]))
{
	?>
<div class="center_content"><p class="title">Ajouter une news</p></br></br><center>

<?php
include("../includes/config.php");
	if (isset($_POST["sub_news"]))
	{
	if(!empty($_POST["auteur"] & $_POST["core"] & $_POST["title"]))
		{
			$auteur = $_POST["auteur"];
			$core = htmlspecialchars($_POST["core"]);
			$title = $_POST["title"];
			$date = date("m/d/y"); 
			try
            {
            $connexion = new PDO('mysql:host='.$host.';dbname='.$database, $usermysql, $passmysql, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch (Exception $e)
            {
            die('Une erreur est survenu lors de la connection à une base de données : ' . $e->getMessage());
            }
			$stmt = $connexion->prepare("INSERT INTO {$prefix}_news (auteur,core,date,title) VALUES (:auteur, :core, :date, :title)");
			if(
			$stmt->execute(array(':auteur' => $auteur, 
								 ':core' => $core,
								 ':date' => $date,
								 ':title' => $title
			)))
				{
				echo "done";
				}
				else 
				{
				echo "echec";
				}
		}
		else 
		{
			echo "Merci de remplir tout les champs";
		}
	}
	else
	{
	echo '<form action="" method="POST">
<input type="text" name="auteur" placeholder="Auteur"></br>
<input type="text" name="title" placeholder="Titre"></br>
<textarea name="core" placeholder="Votre news ici ..." rows="20" cols="80"></textarea></br>
</br><button type="submit" name="sub_news" class="btn_enter">Valider</button></br>
</form>';	
	}
?></br>
</div>
<?php } ?>