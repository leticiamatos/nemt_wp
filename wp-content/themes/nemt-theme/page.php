<?php get_header(); ?>

	<section class="block_wpr block_01">
		<div class="block_cntt">
			<?php get_template_part('bar'); ?>
			<div class="col2-3">
				<main role="main">
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="post_wpr">
							<h2 class="post_title"><?php the_title(); ?></h2>

							<div class="text">
								<?php the_content(); ?>
							</div>	
							<div class="tags">
								<span>Tags: </span><?php the_tags( "", " ", "" ); ?>
							</div>
							<span class="clear"></span>		
						</div>				
					</article>

				<?php endwhile; ?>

				<?php else: ?>

					<!-- article -->
					<article>

						<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

					</article>
					<!-- /article -->

				<?php endif; ?>
				</main>
			</div>
			<div class="col1-3">					
				<?php get_template_part('sidebar'); ?>
			</div>
			
			<span class="clear"></span>
		</div><!-- .block_cntt -->
	</section><!-- .block_01 -->


<?php get_footer(); ?>
