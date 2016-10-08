<?php
include './includes/core.php';
if(isset($_POST["login"])){
adm_login($_POST["username"], $_POST["password"]);
header('Location: ./');
}
else {
  if(isset($_SESSION["ycms_adm_user"]))
{
header('Location: ./');
}
else {

?>
<html lang="fr"> 
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="../src/assets/ionicons-2.0.1/css/ionicons.min.css">
    <link href="./src/css/login.css" rel="stylesheet"> 
    <link href="./src/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="./src/css/bootstrap-theme.css" rel="stylesheet"> 
    <title>Ylo-CMS Admin</title> 
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  </head> 
  <body> 
<div class="container">
          <div class="login_panel">
            <div class="login_header">
              <div class="login_logo"><img src="./src/img/logo.png"></div>
              <div class="text_header">
              <p>Ylo - CMS</p>
              <p>Panneau d’admin</p>
          </div>
        </div>
          <div class="login_content">
            <p><strong>Connection requise</strong></p>
            <form action="" method="post">
            <input type="text" name="username" placeholder="Email" class="text_input"></br>
            <input type="password" name="password" placeholder="Mot de passe" class="pass_input"></br>
            <div class="error">
            <p>Nom d'utilisateur ou mot de passe incorrect !</p>
            </div>
            <a href="../"><button type="button" class="btn_return">Revenir au site</button></a>
            <button type="submit" class="btn_enter" name="login">Entrer</button>
          </form>
          </div>
          <footer>
            <div class="copyr"><p>&copy; 2016 YloFanClub | Powered by Ylo - CMS</p></div>
          </footer>
        </div>
    </div>
</div>

 
	<script src="./src/js/jquery-2.1.4.js"></script> 
    <script src="./src/js/bootstrap.min.js"></script> 
  </body>
</html>
<?php
}
}
?>