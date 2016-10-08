<?php
	$script = get_all_script();
	if(!empty($script)){
		$count = count_all_script();
		$i = 0;
		while ($i < $count){ ?>

			<div class="post-inner">			
					<div class="post-header">							
						    <h2 class="post-title"><a href="#" title="">
						    <?php echo $security->clean($script[$i]["name"]); ?>
						    </a></h2>		    
					    <div class="post-meta">
						    <p class="post-author"><span>de </span><a href="#" title="" rel="author"><?php echo $script[$i]["author"]; ?></a></p>
							<p class="post-date"><span>On </span><a href="#"><?php echo $script[$i]["date"]; ?></a></p>
							<p class="post-categories"><span>dans </span><a href="#" rel="category tag"><?php echo $script[$i]["cat"]; ?></a></p>						    
					    </div>		    	    
					</div> <!-- /post-header -->	
						<div class="post-content">
						<?php echo nl2br($script[$i]["description"]);?> </br>
						<?php if(!empty($script[$i]["source_file"])){ ?>
						Sources : <a href="?page=source&id=<?php echo intval($script[$i]["tmp_id"]) ?>"><?php echo $script[$i]["name"] ?></a></br>
						<?php } ?>
						<?php if(!empty($script[$i]["win"])){ ?>
						Build Windows : <a href="<?php echo $script[$i]["win"] ?>">Download</a></br>
						<?php } ?>
						<?php if(!empty($script[$i]["lin"])){ ?>
						Build Linux : <a href="<?php echo $script[$i]["lin"] ?>">Download</a></br>
						<?php } ?>						
						</div>
						
						<div class="clear"></div>
					
						
				</div> <!-- /post-inner -->
				
			</div> <!-- /post -->			    			        		            
			<div id="post-7" class="post post-7 type-post status-publish format-standard hentry category-news tag-developer tag-news tag-website tag-ylony">
	<?php $i++; } 
	}
	else{
		echo "Oops, something goes wrong, there is nothing to display here !";
	}
	?>
