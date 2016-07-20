<?php

		define('WP_USE_THEMES', false);
		require_once('../../../../wp-load.php');

	 	$object_id = htmlspecialchars($_GET['catid']);

		$args = array( 
			'posts_per_page' => 5,
			'cat'		 => $object_id
		);
		 // echo $object_id;
	?>

	<?php

		$cat_posts = get_posts( $args );
 		$count_posts = count($cat_posts);
		
		$n = 1;
	?>
		
	<?php if ($cat_posts): ?>

		<?php if($count_posts): ?>

			<?php foreach ( $cat_posts as $post ) : setup_postdata( $post ); ?>	
				<?php //echo '<h1>'.$n.'</h1>'; ?>

				<?php if($n == 1 ): ?>			
					<div class="tab_wpr2">
						<div class="col2-3">

				<?php endif; ?>

				<?php if( $n >= 1 && $n < 5	 ): ?>
						<?php get_template_part('loop', 'indextabs'); ?>
				<?php endif; ?>

				<?php if( $n == 5 ): ?>
							<span class="clear"></span>
							<div class="read_too">
								<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
									<h3 class="title">Leia também: <a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
								</article>
							</div>
					<?php 
						wp_reset_postdata();
					?>

						</div> <!-- .col2-3 -->
						<div class="col1-3">
							<figure class="adv_wpr onibus">
								<?php get_template_part('advertising', 'area3'); ?>
							</figure>
						</div>
						<span class="clear"></span>
					</div> <!-- .tab_wpr -->
				<?php endif; ?>


				<?php $n++; ?>

			<?php endforeach; ?> 	
		
		<?php endif;?>
		

	<?php else: ?>
			<div class="tab_wpr">	
				<article class="noresult">
					<h2 class="title"><strong><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?> @ :(</strong></h2>
				</article>
				<span class="clear"></span>
			</div>
	<?php endif; ?>

				<!-- <div class="buttons">
					<a href="<?php //echo get_category_link( $catid ); ?> " class="btn_more">veja mais</a>	
				</div> -->

	<?php wp_reset_postdata(); ?>
