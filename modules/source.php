<?php
	if(isset($_GET["id"])){
		if(intval($_GET["id"]) == 0){

							?>
			<script>
				document.location.href="./?page=404"
			</script>
			<?php
			exit;
			} 
		$data = get_script_data($security->protect_int($_GET["id"]));
		if(!$data){
				?>
		<script>
			document.location.href="./?page=404"
		</script>
		<?php
			exit;
		}
		?>
<div class="post-inner">			
		<div class="post-header">							
			    <h2 class="post-title"><a href="#" title="">
			    <?php echo $data["name"]; ?>
			    </a></h2>		    
		    <div class="post-meta">
			    <p class="post-author"><span>de </span><a href="#" title="" rel="author"><?php echo $data["author"]; ?></a></p>
				<p class="post-date"><span>On </span><a href="#"><?php echo $data["date"]; ?></a></p>
				<p class="post-categories"><span>dans </span><a href="#" rel="category tag"><?php echo $data["cat"]; ?></a></p>						    
		    </div>		    	    
		</div> <!-- /post-header -->	
			<div class="post-content">
			<?php echo convert_map_file("./tmp/map/".intval($_GET["id"])."/map_file.txt"); ?>
				<a href="<?php echo get_dl_link($_GET["id"]); ?>"><?php echo $data["name"];?>.zip</a></br>
				<a href="?page=script"><- Revenir</a>
			</br>	
			</div>
			
			<div class="clear"></div>
		
			
	</div> <!-- /post-inner -->
	
</div> <!-- /post -->			    			        		            
<div id="post-7" class="post post-7 type-post status-publish format-standard hentry category-news tag-developer tag-news tag-website tag-ylony">
<?php }else{
	?>
		<script>
			document.location.href="./?page=404"
		</script>
	<?php
	exit;
}
?>
