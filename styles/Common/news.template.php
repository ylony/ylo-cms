<?php
	if(isset($thisnews_data)){ //une news?>
<div class="post-inner">			
		<div class="post-header">					
			    <h2 class="post-title"><a href="?page=news&nid=<?php echo $thisnews_data["id"]; ?>" title="<?php echo $thisnews_data["title"]; ?>">
			    <?php echo $thisnews_data["title"]; ?></a></h2>	    
		    <div class="post-meta">    
			    <p class="post-author"><span>de </span><a href="#" title="Articles par Ylony" rel="author"><?php echo $thisnews_data["auteur"]; ?></a></p>
				<p class="post-date"><span>On </span><a href="#"><?php echo $thisnews_data["date"]; ?></a></p>
									<p class="post-categories"><span>dans </span><a href="#" rel="category tag">Non classé</a></p>									    
		    </div>  	    
		</div> <!-- /post-header -->			
			<div class="post-content">	
				<?php
				echo nl2br($thisnews_data["core"]);
				?>	
			</div>	
			<div class="clear"></div>
			</div>	
			<div class="post-navigation">
						
						<div class="post-navigation-inner">
					
														
								<div class="post-nav-prev">
								</div>
														
														
							<div class="clear"></div>
						
						</div> <!-- /post-navigation-inner -->
					
					</div> <!-- /post-navigation -->
<!-- Comment start -->
<div class="comments-container">
	
		<div class="comments-inner">
		
			<a name="comments"></a>
			
			<div class="comments-title-container">
			
				<h2 class="comments-title">
					<?php $c = count_comment($thisnews_data["id"]); 
					if ($c > 1){
						echo $c." Commentaires";
					}
					else{
						echo $c." Commentaire";
					}
					?>		
				</h2>
				
								
					<p class="comments-title-link">
						
						<a href="#respond">Ajouter un commentaire &rarr;</a>
						
					</p>
				
								
				<div class="clear"></div>
			</div>
			<div class="comments">		
				<ol class="commentlist">
				    	<li class="comment byuser comment-author-ylony bypostauthor even thread-even depth-1" id="li-comment-1">
							<?php display($thisnews_data["id"], 0) //display comments?>	
			</div>			
						</li>
				</ol>
			</div>
	</div>
<div class="respond-container">				
	<div id="respond" class="comment-respond">
			<h3 id="reply-title" class="comment-reply-title">

			<?php if(!empty($_GET["edit_id"])){
				if(!empty($_SESSION["user"])){
					echo "Editer un commentaire";
				}
				else
				{
					?>
					<script>
						document.location.href="./?page=404"
					</script>
					<?php	
				}
			}
			else{
				echo "Laisser un commentaire";
			}
			?>
			</h3>
			<form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" id="commentform" class="comment-form">
					<p class="logged-in-as">
					<?php if(isset($_SESSION["user"])){
						if(isset($_POST["submit"])){
							if(new_comment(get_display_name($_SESSION["user"]), $_POST["comment"], 0, $_POST["get_cid"], $_POST["comment_post_ID"])){
								echo '<meta http-equiv="refresh" content="0; URL=?page=news&nid='.$_POST["comment_post_ID"].'">';
							}else{
								?>
								<script>
										document.location.href="#respond"
								</script>
								<?php
							}
						} ?> 

						<a href="#">
							Connecté(e) en tant que <?php echo get_display_name($_SESSION["user"]); ?>	
						</a>. 
						<a href="?page=logout">
						Déconnexion&nbsp;?
						</a>
						</p>
						<p class="comment-form-comment">
				<label for="comment">Commentaire
					<span class="required">*</span>
				</label>
				<?php
					if(!empty($_GET["edit_id"])){
						if(isset($_POST["new_comment"])){
							$result = update_edit_comment(get_display_name($_SESSION["user"]), $_GET["edit_id"], $_GET["nid"], $_POST["new_comment"]);
							if($result){
								echo "Commentaire édité avec succès.";
								echo '<meta http-equiv="refresh" content="0; URL=?page=news&nid='.$_GET["nid"].'">';
							}
							else{
								echo "Oops ! Something went wrong !";
							}
						}
						$result = allow_edit_comments(get_display_name($_SESSION["user"]), $_GET["edit_id"], $_GET["nid"]);
						if($result){
							echo '<textarea id="comment" name="new_comment" cols="45" rows="6" required>'.$result.'</textarea>';
						}
						else{?>
								<script>
										document.location.href="./?page=404"
								</script>
								<?php							
						}
					}
					else{
						?>
							<textarea id="comment" name="comment" cols="45" rows="6" required></textarea>
					<?php
						}
					?>
				
			</p>
			<p class="form-submit">
			<?php if(!empty($_GET["edit_id"])){
				echo '<input name="update" type="submit" id="submit" class="submit" value="Editer un commentaire" /> ';
			}
			else{?>
			<input name="submit" type="submit" id="submit" class="submit" value="Laisser un commentaire" /> 
			<?php } ?>
			<input type='hidden' name='comment_post_ID' value='<?php echo intval($_GET["nid"]);?>' id='comment_post_ID' />
			<?php if(!empty($_GET["cid"])){?>
			<input type='hidden' name='get_cid' value='<?php echo intval($_GET["cid"]);?>' id='comment_post_ID' />
			<?php }else{?>
				<input type='hidden' name='get_cid' value='0' id='comment_post_ID' /><?php
			}?>
			<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
			<?php } else{
				echo "Vous devez <a href='./login/'>être connecté(e)</a> pour rédiger un commentaire.";
			}
			?>

</p>				</form>
					</div><!-- #respond -->
		</div> <!-- /respond-container -->						    			        		            	        			    	
		<?php
	}else {
 	if(!empty($news_data)){//everynews
 		$init = 0; 
 		$i = 3;//default news number
 		while ($init<$i){
 			if(!empty($news_data[$init])){
 			?>
		
	<div class="post-inner">
				
		<div class="post-header">

							
			    <h2 class="post-title"><a href="?page=news&nid=<?php echo $news_data[$init]["id"]; ?>" title="<?php echo $news_data[$init]["title"]; ?>">
			    <?php echo $news_data[$init]["title"]; ?></a></h2>
			    
					    
		    		    
		    <div class="post-meta">
			    
			    <p class="post-author"><span>de </span><a href="#" title="Articles par Ylony" rel="author"><?php echo $news_data[$init]["auteur"]; ?></a></p>
				<p class="post-date"><span>On </span><a href="#"><?php echo $news_data[$init]["date"]; ?></a></p>
									<p class="post-categories"><span>dans </span><a href="#" rel="category tag">Non classé</a></p>
											    
		    </div>
		    	    
		</div> <!-- /post-header -->
		
				
			<div class="post-content">
			
				<?php
				echo nl2br($news_data[$init]["core"]);
				?>
			
			</div>
			
			<div class="clear"></div>
		
			
	</div> <!-- /post-inner -->
	
</div> <!-- /post -->			    			        		            
			        			    	
			    		<div id="post-7" class="post post-7 type-post status-publish format-standard hentry category-news tag-developer tag-news tag-website tag-ylony">

	<?php	
 			}
 		$init++; 
 		}	//w.end
 	}
 	else{
 		echo "</br>Nothing to display";
 	}
}

?>