

<?php
	if ($post):  
?>


	<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
		<figure>
			<a href="<?php the_permalink();?>">
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail();  ?>
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/img/no-thumb.png"/>
			<?php endif; ?>
			</a>
		</figure>
		<?php echo the_category_list(); ?>
		<h3 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
		<div class="text">
			<?php html5wp_excerpt('html5wp_index'); ?>
		</div>
		<span class="clear"></span>
	</article>

<?php else: ?>
	
	<article class="noresult">
		<h2 class="title"><strong><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?> @ :(</strong></h2>
	</article>

<?php 
	endif;
	wp_reset_postdata();
?>
