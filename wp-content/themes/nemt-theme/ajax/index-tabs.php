<?php 

		define('WP_USE_THEMES', false);
		require_once('../../../../wp-load.php');

	 	$object_id = htmlspecialchars($_GET['catid']);
	 	$section_name = htmlspecialchars($_GET['section']);

		$args = array( 
			'posts_per_page' => 7,
			'cat'		 => $object_id
		);
		 // echo $object_id;
		
		$adv_template = 'area2';
		if ($section_name == 'modal'):
			$adv_template = 'area2';
		elseif ($section_name == 'logistica'):
			$adv_template = 'area5';
		endif;
	?>
	<?php

		$cat_posts = get_posts( $args );
 		$count_posts = count($cat_posts);
		
		$n = 1;
	?>
		
	<?php if ($cat_posts): ?>

		<?php if($count_posts < 7 ): ?>
			<div class="tab_wpr">
				<div class="col2-3">
			<?php foreach ( $cat_posts as $post ) : setup_postdata( $post ); ?>	
				<?php if ($n < 5 ): ?>
					<?php //echo '<h1>'.$n.'</h1>'; ?>
					<?php get_template_part('loop', 'indextabs'); ?>
					<?php $n ++; ?>
				<?php endif; ?>
			<?php endforeach; ?> 	
					<span class="clear"></span>
				</div> <!-- .col2-3 -->
				<div class="col1-3">
					<figure class="adv_wpr modal">
						<?php get_template_part('advertising', $adv_template); ?>
					</figure>
				</div>
				<span class="clear"></span>
			</div> <!-- .tab_wpr -->
		
		<?php else: ?>
			<?php foreach ( $cat_posts as $post ) : setup_postdata( $post ); ?>	
				<?php //echo '<h1>'.$n.'</h1>'; ?>

				<?php if($n == 1 ): ?>			
					<div class="tab_wpr">
						<div class="col2-3">

				<?php endif; ?>

				<?php if( $n >= 1 && $n < 5	 ): ?>
						<?php get_template_part('loop', 'indextabs'); ?>
				<?php endif; ?>

				<?php if( $n == 5 ): ?>
						<span class="clear"></span>
					</div> <!-- .col2-3 -->
					<div class="col1-3">
						<figure class="adv_wpr modal">
							<?php get_template_part('advertising', $adv_template); ?>
						</figure>
						<div class="recent_posts">
							<h4>Leia também:</h4>
				<?php endif; ?>

				<?php if( $n > 4 ): ?>
							<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				<?php endif; ?>

				<?php $n++; ?>

				<?php if( $n > 7 ): ?>
							</div>
						</div>
						<span class="clear"></span>
					</div> <!-- .tab_wpr -->
				<?php endif; ?>

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
