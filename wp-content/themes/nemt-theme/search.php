<?php
	$search_query = get_search_query();

	// Only from cat
	// $catid = 9;

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	global $wp_query;

	query_posts(array_merge(
		array(
			'post_type' => 'post',
			//'cat'		 => $catid,
	  		'paged'          => $paged
  		),
		$wp_query->query
	));
?>

<?php get_header(); ?>

	<section class="block_wpr block_category">
		<div class="block_cntt">
			<?php get_template_part('bar'); ?>
			
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