<?php get_header(); ?>

	<section class="block_wpr block_category">
		<div class="block_cntt">
			<?php get_template_part('bar', 'category'); ?>
			
			<div class="col2-3">
				<div class="post_list">
					<?php get_template_part('loop', 'default'); ?>
				</div>
				<?php get_template_part('pagination'); ?>
			</div>
			<div class="col1-3">
				<?php get_template_part('sidebar'); ?>
			</div>

			<span class="clear"></span>
		</div><!-- .block_cntt -->
	</section><!-- .block_01 -->


<?php get_footer(); ?>