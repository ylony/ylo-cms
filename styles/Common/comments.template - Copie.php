<?php 
	$i=0;
	while ($i < $count){
		?>
		<div id="comment-<?php echo intval($comments[$i]["id"]);?>" class="comment">
			<img alt='' src='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=160&#038;d=mm&#038;r=g' srcset='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=320&amp;d=mm&amp;r=g 2x' class='avatar avatar-160 photo' height='160' width='160' />										
				<a class="comment-author-icon" href="http://127.0.0.1/blog/index.php/2016/04/14/construction-en-cours/#comment-1" title="Auteur de l&rsquo;article">	
					<div class="genericon genericon-user"></div>		
				</a>				
			<div class="comment-inner">	
				<div class="comment-header">									
					<h4><?php echo $comments[$i]["author"];?></h4>		
				</div> <!-- /comment-header -->		
				<div class="comment-content post-content">
					<p><?php echo nl2br($comments[$i]["core"]);?></p>			
				</div><!-- /comment-content -->		
				<div class="comment-meta">			
					<div class="fleft">
						<div class="genericon genericon-day"></div><a class="comment-date-link" href="http://127.0.0.1/blog/index.php/2016/04/14/construction-en-cours/#comment-1" title="5 mai 2016 at 10 h 57 min"><?php echo $comments[$i]["date"];?></a>
						<div class="genericon genericon-edit"></div><a class="comment-edit-link" href="http://127.0.0.1/blog/wp-admin/comment.php?action=editcomment&#038;c=1">Modifier</a>					</div>							
						<div class="fright"><div class="genericon genericon-reply"></div><a rel='nofollow' class='comment-reply-link' href='http://127.0.0.1/blog/index.php/2016/04/14/construction-en-cours/?replytocom=1#respond' onclick='return addComment.moveForm( "comment-1", "1", "respond", "19" )' aria-label='Répondre à <?php echo $comments[$i]["author"];?>'>Réponse</a></div>									
					<div class="clear"></div>
				</div> <!-- /comment-meta -->					
			</div> <!-- /comment-inner -->							
		</div>
		<?php
			$got_sub = $this->count_comments_subs(intval($comments[$i]["id"]));
			if($got_sub > 0){
				$u = 0;
				$sub_comments = $this->display_comments_subs(intval($comments[$i]["id"]));
				while($u < $got_sub){
				?>
				<ul class="children">
				<li class="comment byuser comment-author-ylony bypostauthor even depth-3" id="li-comment-3">
						<div id="comment-<?php echo intval($sub_comments[$u]["id"]);?>" class="comment">
			<img alt='' src='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=160&#038;d=mm&#038;r=g' srcset='http://1.gravatar.com/avatar/18885e99621c2b262f5025fa8bc23776?s=320&amp;d=mm&amp;r=g 2x' class='avatar avatar-160 photo' height='160' width='160' />										
				<a class="comment-author-icon" href="http://127.0.0.1/blog/index.php/2016/04/14/construction-en-cours/#comment-1" title="Auteur de l&rsquo;article">	
					<div class="genericon genericon-user"></div>		
				</a>				
			<div class="comment-inner">	
				<div class="comment-header">									
					<h4><?php echo $sub_comments[$u]["author"];?></h4>		
				</div> <!-- /comment-header -->		
				<div class="comment-content post-content">
					<p><?php echo nl2br($sub_comments[$u]["core"]);?></p>			
				</div><!-- /comment-content -->		
				<div class="comment-meta">			
					<div class="fleft">
						<div class="genericon genericon-day"></div><a class="comment-date-link" href="http://127.0.0.1/blog/index.php/2016/04/14/construction-en-cours/#comment-1" title="5 mai 2016 at 10 h 57 min"><?php echo $sub_comments[$u]["date"];?></a>
						<div class="genericon genericon-edit"></div><a class="comment-edit-link" href="http://127.0.0.1/blog/wp-admin/comment.php?action=editcomment&#038;c=1">Modifier</a>					</div>							
														
					<div class="clear"></div>
				</div> <!-- /comment-meta -->					
			</div> <!-- /comment-inner -->							
		</div>
		</li></ul>
				<?php
$u++;
}
			}
?>
	




		<!-- /comment-## -->
<?php $i++;}		?>