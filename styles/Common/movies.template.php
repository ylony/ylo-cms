<?php 
$i = 0;
while($i < $this->max_movie_per_page){
	if(!($rst[$i]["is_private"] == 1))

 ?>
<div class="post-inner">			
		<div class="post-header">							
			    <h2 class="post-title"><a href="#" title="">
			    <?php echo $rst[$i]["titre"]; ?>
			    </a></h2>		    
		    <div class="post-meta">
			    <p class="post-author"><span>de </span><a href="#" title="" rel="author"><?php echo $rst[$i]["author"]; ?></a></p>
				<p class="post-date"><span>On </span><a href="#"><?php echo $rst[$i]["date"]; ?></a></p>
				<p class="post-categories"><span>dans </span><a href="#" rel="category tag"><?php echo $rst[$i]["date"]; ?></a></p>						    
		    </div>		    	    
		</div> <!-- /post-header -->	
			<div class="post-content">
			<?php echo nl2br($rst[$i]["description"]); ?></br>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $rst[$i]["movie"]; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			
			<div class="clear"></div>
		
			
	</div> <!-- /post-inner -->
	
</div> <!-- /post -->			    			        		            
<div id="post-7" class="post post-7 type-post status-publish format-standard hentry category-news tag-developer tag-news tag-website tag-ylony">
<?php } $i++; } ?>