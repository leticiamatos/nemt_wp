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
    $args_cat = array(
    'hide_empty'		 => 1,
	'title_li'           => '',
	'child_of'           => $object_id,
	'taxonomy'           => 'category',
	'hierarchical'		 => 1,
	'depth'				 => 1
    );

	$cats = get_categories( $args_cat); 
?> 

	<div class="submenu_wpr">
		<div class="block_cntt">
			<div class="col1-6">
				<ul class="subcat_list">
					<li><a href="<?php echo get_category_link( $object_id ); ?>" class="all">Todos</a></li> 
				<?php 
					foreach ($cats as $cat):
						$subcat_id = $cat->cat_ID;
						echo '<li><a href="'. get_category_link( $subcat_id ) .'" class="link '. $cat->cat_slug . '">' .$cat->cat_name . '</a></li>';
					
					endforeach;	
				?>
				</ul>
			</div>
			<?php

				$cat_posts = get_posts( $args );
				if ($cat_posts):
					foreach ( $cat_posts as $post ) : setup_postdata( $post );
				?>				
					<div class="col1-6">
						<?php get_template_part('loop', 'submenu'); ?>
					</div>
				<?php 	
					endforeach; 
				else:
			?>
				<article class="noresult">
					<h2 class="title"><strong><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?> @ :(</strong></h2>
				</article>

			<?php 
				endif;
			?>
			<span class="clear"></span>
			<!-- <div class="buttons">
				<a href="<?php //echo get_category_link( $catid ); ?> " class="btn_more">veja mais</a>	
			</div> -->
		</div> <!-- .block_cntt -->
	</div> <!-- .submenu_wpr -->

<?php wp_reset_postdata(); ?>