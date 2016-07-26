<?php 
	
	$cat_obj = get_category_by_slug( '0_destaque' );
	$cat_id = $cat_obj->term_id;

	$args = array( 
		'posts_per_page' => 20,
		'cat'		 => $cat_id
	);
?>

<ul class="highlight slide_wpr bxslider">

<?php
	$cat_posts = get_posts( $args );
	if ($cat_posts):
		foreach ( $cat_posts as $post ) : setup_postdata( $post );
	?>				
	<li class="slide">
		<article id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
			<figure>
				<a href="<?php the_permalink();?>">
				<?php if ( has_post_thumbnail()) : ?>
					<?php the_post_thumbnail();  ?>
				<?php else: ?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/no-thumb.png"/>
				<?php endif; ?>
				</a>
			</figure>
			<div class="text">
				<?php echo the_category_list(); ?>
				<h3 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
			</div>
		</article>
	</li>

	<?php 	
		endforeach; 
	else:
?>
	<li class="slide">
		<article class="noresult">
			<h2 class="title"><strong><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?> @ :(</strong></h2>
		</article>
	</li>

<?php 
	wp_reset_postdata();
	endif;
?>

</ul>