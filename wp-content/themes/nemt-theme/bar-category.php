<div class="bar_category wpr">
<?php
?>

<?php 
	$postid = 0;
	$count_currentpost_cats = 1;

	if (is_single()){
		// Verify if in subcategory
		$postid = get_the_id();
		$currentpost_cats = get_the_category();
		$count_currentpost_cats = count($currentpost_cats);
		$cat_id_parent = $currentpost_cats[0]->parent;

		//$cat_id = $cat_id_parent;

		$cat_id = $currentpost_cats[0]->cat_ID;

	}else if( is_category()){
		$cat_id = get_query_var('cat');
	}


	// Get Subcategories
    $args_cat = array(
    'hide_empty'		 => 0,
	'title_li'           => '',
	'parent'             => $cat_id,
	'taxonomy'           => 'category'
    );
	$cats = get_categories( $args_cat); 


?> 
	<span class="block_border"></span>
	<span class="block_border_gap"></span>
	
	<?php if ($cats): ?>
		<div class="responsive_menu_subcat_wpr">
			<a href="javascript:void(0);" class="responsive_menu_subcat_link"></a>
			<ul class="subcat_list">

				<?php 
					$activeclass = '';
					if( $count_currentpost_cats == 1){
						$activeclass = 'active';
					} 
				?>
				<?php 
					foreach ($cats as $cat):
						$activeclass = '';
						if (!is_category() && in_category($cat->cat_ID, $postid)){
							$activeclass = 'active';
						}
						echo '<li class="cat_item ' . $activeclass . '"><a href="'. get_category_link($cat->cat_ID) . '" class="link '. $cat->cat_slug . '">' .$cat->cat_name . '</a></li>';
					
					endforeach;	
				?>
			</ul>
		</div>
	<?php endif; ?>
	
	<h3 class="block_title"><a href="<?php echo  get_category_link( $cat_id ); ?>" class="link"><?php echo get_cat_name( $cat_id ); ?></a></h3>

	<span class="clear"></span>
</div>

<?php wp_reset_postdata(); ?>
