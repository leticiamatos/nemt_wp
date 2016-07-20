<?php get_header(); ?>

	<section class="block_wpr block_01">
		<div class="block_cntt">
			<?php get_template_part('bar'); ?>
			<div class="col2-3">
				<main role="main">
			
			<article id="post-404" class="block_error">

				<h2 class="cat_title"><?php _e( 'Page not found', 'html5blank' ); ?></h2>
				<div class="cntt">
					<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
				</div>

			</article>
			<!-- /article -->

				</main>
			</div>
			<div class="col1-3">					
				<?php get_template_part('sidebar'); ?>
			</div>
			
			<span class="clear"></span>
		</div><!-- .block_cntt -->
	</section><!-- .block_01 -->


<?php get_footer(); ?>
