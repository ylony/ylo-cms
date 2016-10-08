<?php 
if(isset($_SESSION["user"]) OR isset($_SESSION["login"])){
echo '<meta http-equiv="refresh" content="0; URL=?page=404">';
exit;
}
else {
if(isset($_POST["reg_sub"])){
$reg_first_name = $_POST["reg_first_name"];
$reg_last_name = $_POST["reg_last_name"];
$reg_email = $_POST["reg_email"];
$reg_password = $_POST["reg_password"];
$reg_password_confirm = $_POST["reg_password_confirm"];
echo register($reg_first_name, $reg_last_name, $reg_email, $reg_password, $reg_password_confirm);
//echo '<meta http-equiv="refresh" content="5; URL=./">';
}
elseif(isset($_POST["log_sub"])){
$log_email = $_POST["log_email"];
$log_password = $_POST["log_password"];
echo login($log_email, $log_password);
//echo '<meta http-equiv="refresh" content="5; URL=./">';
}
elseif(isset($_GET["k"]) && (isset($_GET["l"]))) {
  echo activate($_GET["k"], $_GET["l"]);
 //echo '<meta http-equiv="refresh" content="5; URL=./">';
}
else {
?>
<link rel="stylesheet" type="text/css" href="./css/login.css">
<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Register</a></li>
        <li class="tab"><a href="#login">Login</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Register for free</h1>
          
          <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" name="reg_first_name" maxlength="20" required autocomplete="off" />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text" name="reg_last_name" maxlength="20" required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" name="reg_email" maxlength="45" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password (4-20 characters)<span class="req">*</span>
            </label>
            <input type="password" name="reg_password" maxlength="20" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Confirm Password (4-20 characters)<span class="req">*</span>
            </label>
            <input type="password" name="reg_password_confirm" maxlength="20" required autocomplete="off"/>
          </div>

          <input type="submit" name="reg_sub">
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
          
            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" name="log_email" maxlength="45" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="log_password" maxlength="20" required autocomplete="off"/>
          </div>
          
          <p class="forgot"><a href="?page=forgot">Forgot Password?</a></p>
          
          <input type="submit" name="log_sub">
          
          </form>

        </div>
        
      </div>   
</div> 
<?php } }?>
<script>$('.form').find('input, textarea').on('keyup blur focus', function (e) {  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }
});
$('.tab a').on('click', function (e) {
  e.preventDefault();
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  target = $(this).attr('href');
  $('.tab-content > div').not(target).hide(); 
  $(target).fadeIn(600);
});</script>