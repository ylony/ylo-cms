<link rel="stylesheet" href="./styles/Common/css/upload.css">
<section id="upload">
		<div class="overlay2">
				<div class="container">
					<div class="row ptop">
						<div class="col-md-1"></div>
						<div class="col-md-10">
						<h1>Upload a picture</h1>
						<?php
						if(isset($_FILES["myfiles"])){
							echo upload($_FILES["myfiles"]);
						}
						else{?>
							<form method="post" enctype="multipart/form-data" action="">
								<div class="custom-file-upload">
	   								 <input type="file" id="file" name="myfiles[]" multiple />
	   								 <input type="submit" class="file-upload-button">
								</div>
							</form>
						<?php
						}
						?>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
				</div>
<script type="text/javascript" src="./styles/Common/js/upload.js"></script>