<?php include("../includes/main.php");
if(!empty($_SESSION["login"])){
header('Location: ../?page=404');
exit;
}
 ?>
<!DOCTYPE html>
<htlm xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="./assets/src/css/bootstrap.css">
		<link rel="stylesheet" href="./assets/src/css/bootstrap-theme.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="./assets/src/css/main.css">
		<?php html_meta(); ?>
	</head>
		<script type="text/javascript" src="./assets/src/js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="./assets/src/js/bootstrap.min.js"></script>
	<body>
		<div class="container">
          <div class="login_panel">
            <div class="login_header">
              <div class="text_header"><img src="./assets/src/img/logo.png" height="68" width="455">
              </div>
        </div>
          <div class="login_content">
            <p><strong>Espace Membre</strong></p>
            <div class="error">
            	<p>
		            <?php
		        if(isset($_GET["forgot"])){
		        	if($_GET["forgot"] == 1){
		        		?>
		        		</p></div>
		        		<form action="?forgot=1" method="POST">
		        		<input type="email" name="forgot_mail" placeholder="Votre adresse email" class="pass_input" autocomplete="off">
		        		<button type="submit" name="forgot_send" class="btn_validate">Envoyer</button>
		        		<?php 
		        		if(isset($_GET["k"]) && (isset($_GET["l"]))) {
  							echo forgot_password_proceed($_GET["k"], $_GET["l"]);
 							echo '<meta http-equiv="refresh" content="5; URL=./">';
						}
		        		if(isset($_POST["forgot_send"])){
		        			if(!empty($_POST["forgot_mail"])){
		        				echo forgot_password($_POST["forgot_mail"]);
		        			}
		        			else{
		        				echo "Ce champs est obligatoire.";
		        			}
		        		}
		        		?>
		        		</form>
		        		<?php
		        	}
		        	else{
		        		header("Location: ../?page=404");
		        	}
		        }
		        elseif(isset($_GET["activate"])){ 
		        	if($_GET["activate"] == 1){
		        		?></p></div><?php
		        		if(isset($_GET["fromreg"])){
			        		if($_GET["fromreg"] == 1){
			        			?>
			        			<div class="activate">
			        			Votre compte a été créé avec succès, un email vient de vous être envoyé pour activer votre compte.</br>
			        			Si vous n'arrivez pas à valider votre compte via le lien automatique de l'email veuillez recopier la clé dans le champs çi-dessous.</div></br>
			        			<?php 		        		} 
			        		}
		        			if(isset($_GET["k"]) && (isset($_GET["l"]))) {
  								echo activate($_GET["k"], $_GET["l"]);
  								echo '<meta http-equiv="refresh" content="5; URL=./">';
							}
		        			?>
		        			<form action="" method="post">
		        			<input type="text" name="validate" placeholder="Code d'activation" class="pass_input" autocomplete="off">
		        			<button type="submit" class="btn_validate" name="sub_validate">Activer mon compte</button>
		        			</form>
		        			<?php
		        			if(isset($_POST["sub_validate"])){
		        				echo activatepost($_POST["validate"]);
		        				echo '<meta http-equiv="refresh" content="5; URL=./">';
		        			}
		        	}
		        	else{
		        		header("Location: ../?page=404");
		        	}
		        }
		        else{
		            if(isset($_POST["register"])){
		            	?>
		            	</p></div>Etape : 2/3
		            	<form action="" method="POST">
	            		<input type="text" name="reg_first_name" placeholder="  Nom" class="text_input" autocomplete="off">
	           		 	<input type="text" name="reg_last_name" placeholder="  Prénom" class="pass_input" autocomplete="off">
	           		 	<input type="text" name="reg_display_name" placeholder="  Pseudo" class="pass_input" autocomplete="off">
	           		 	<input type="password" name="reg_password_confirm" placeholder="  Confirmation du mot de passe" class="pass_input" autocomplete="off"><a href="">
	           		 	<?php 		            	if(isset($_POST["register2"])){
		           			$reg = register($_POST["reg_first_name"], $_POST["reg_last_name"], $_POST["email"], $_POST["reg_display_name"], $_POST["password"], $_POST["reg_password_confirm"]);
		           			if($reg == 42){
		           				header("Location: ./?activate=1&fromreg=1");
		           			}
		           			else{
		     					echo '<p class="error2">'.$reg.'</p>';
		     				}
		    		        }?>
						<button type="button" class="btn_return">Revenir</button></a>
						<button type="submit" class="btn_enter" name="register2">S'inscrire</button>
						<input type="hidden" name="email" value="<?php echo $_POST["email"];?>"> 
						<input type="hidden" name="password" value="<?php echo $_POST["password"];?>">
						<input type="hidden" name="register" value="<?php echo $_POST["register"];?>">
						</form>               		 	
	           		 	<?php	            	
		            }
		            else{
						if(isset($_POST["login"])){
			            	$err = login($_POST["email"], $_POST["password"]);
			            }		            	
			            if(!empty($err)){
			            	echo $err;
			            }		            	
		            ?>            		
            	</p>
            </div>
            <form action="" method="post">
	            <input type="email" name="email" placeholder="  Email@email.fr" class="text_input" autocomplete="off"></br>
	            <input type="password" name="password" placeholder="  Mot de passe" class="pass_input" autocomplete="off"></br>
	            <button type="submit" class="btn_return" name="login">Connexion</button>
	            <button type="submit" class="btn_enter" name="register">S'inscrire</button>
         	</form>
         	<div class="sub">
	         	<a href="?forgot=1"><p class="subtext">J'ai oublié mon mot de passe.</p></a>
	         	<a href="../"><p class="subtext">Revenir à l'accueil.</p></a>
         	</div>
         	<?php }
         	} ?>
          </div>
        </div>
    </div>
</div>
<footer>
  	<div class="footere">
  			<div class="container">
  				<div class="row">
  					<div class="col-md-5">
  						<p> © 2016 YloFanClub | Powered by <a href="#">Ylo - CMS</a></p>
  					</div>
  				</div>
  			</div>
  	</div>
</footer>
	</body>
	</htlm>