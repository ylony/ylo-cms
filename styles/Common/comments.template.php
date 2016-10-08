<?php 
	$i=0;
	while ($i < $count){
		?>
		<div id="comment-<?php echo intval($comments[$i]["id"]);?>" class="comment">
			<img alt='' src='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=160&#038;d=mm&#038;r=g' srcset='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=320&amp;d=mm&amp;r=g 2x' class='avatar avatar-160 photo' height='160' width='160' />										
				<?php
				if(get_current_news_user($comments[$i]["idnews"]) == $comments[$i]["author"]){?>
				<a class="comment-author-icon" title="Auteur de l&rsquo;article">
				<?php } ?>
					<div class="genericon genericon-user"></div>		
				</a>				
			<div class="comment-inner">	
				<div class="comment-header">									
					<h5><?php write_name_w_color($comments[$i]["author"]);?></h5>	
				</div> <!-- /comment-header -->		
				<div class="comment-content post-content">
					<p><?php echo nl2br($comments[$i]["core"]);?></p>	
				</div><!-- /comment-content -->		
				<div class="comment-meta">			
					<div class="fleft">
						<div class="genericon genericon-day"></div><?php echo $comments[$i]["date"];?>
						<?php 
						if(!empty($_SESSION["user"])){
						if(get_display_name($_SESSION["user"]) == $comments[$i]["author"]){?>
						<div class="genericon genericon-edit"></div>
						<a href='<?php echo '?page=news&nid='.intval($comments[$i]["idnews"]).'&edit_id='.intval($comments[$i]["id"]).'#respond'; ?>'>Modifier</a>
							<?php }} ?>	</div>					
						<div class="fright"><div class="genericon genericon-reply"></div><a rel='nofollow' class='comment-reply-link' href='<?php echo '?page=news&nid='.intval($comments[$i]["idnews"]).'&cid='.intval($comments[$i]["id"]);?>#respond' aria-label='Répondre à <?php echo $comments[$i]["author"];?>'>Répondre</a></div>									
					<div class="clear"></div>
				</div> <!-- /comment-meta -->					
			</div> <!-- /comment-inner -->							
		</div>
		<?php
			$got_sub = $this->count_comments_subs(intval($comments[$i]["id"]));
			if($got_sub > 0){
				$this->display($comments[$i]["id"], 1);
	}
?>
		<!-- /comment-## -->
<?php $i++;}		?>