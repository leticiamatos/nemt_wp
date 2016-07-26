<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700,800' rel='stylesheet' type='text/css'>
		
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' - '; } ?><?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<?php 
	if(is_home()):
		$home_class = "home";
	else:
		$home_class = false;
	endif;
	?>

	<body <?php body_class($home_class); ?>>


		<h5 style="display:none;">
			<?php echo bloginfo('rdf_url'); ?>
		</h5>
		<?php
			$cat_parent = '';

			// Check if isn't Home Page
			if (!is_home()){	
				// Check if is Category or archive page
				if (is_category() || is_archive()){
					$this_category = get_category(get_query_var('cat'),false);			
					$this_category_ID = $this_category->cat_ID;
					
				// Check if is Single
				}elseif (is_single( )) {
					$first_cat = get_the_category($post);
					$this_category_ID = $first_cat[0]->cat_ID;	
					// echo 'first cat!'.$first_cat[0]->name ;
				}else{
					$this_category_ID = 1;	
				}
				// Check if the main category is Parent Cat.
				// echo 'ID Categoria 01: '.$this_category_ID;
				$possible_parent_id = is_parent_category($this_category_ID);
				if($possible_parent_id){
					$parent_id = $possible_parent_id;
					// echo '<br />ID Categoria 02: '.$parent_id;
					$possible_parent_id = is_parent_category($parent_id); 
					if($possible_parent_id){
						$parent_id = $possible_parent_id;
						// echo '<br />ID Categoria 03: '.$parent_id;
						$possible_parent_id = is_parent_category($parent_id);
						if($parent_id){
							// echo '<br />ID Categoria 04: '.$parent_id;
							$parent_id = $possible_parent_id;
						}						
					}
				}else{
					$parent_id = $this_category_ID;
				}

				// echo $parent_id;
				$parent = get_category($parent_id);
				$parent_slug = $parent->slug;
				// echo $parent_slug;
				
				// Checking the name of the cat
				switch ($parent_slug) {
				    case "modal":
				        $cat_parent = 'parent-cat-modal';
				        break;
				    case "onibus":
				       	$cat_parent = 'parent-cat-onibus';
				        break;
				    case "logistica":
				        $cat_parent = 'parent-cat-logistica';
				        break;
				    case "posvenda":
				        $cat_parent = 'parent-cat-posvenda';
				        break;
				    case "blogs-e-colunas":
				        $cat_parent = 'parent-cat-blogs-e-colunas';
				        break;
				    case "panorama":
				        $cat_parent = 'parent-cat-panorama';
				        break;
				    case "noticias":
				        $cat_parent = 'parent-cat-noticias';
				        break;
				    case "revista":
				        $cat_parent = 'parent-cat-revista';
				        break;
			        default:
						$cat_parent = 'parent-default';
				}

			}
		?>

		<section class="general <?php echo $cat_parent; ?>">


			<div class="relative">
				<div class="fixed">
					<section class="block_wpr header_secondary_social">
						<div class="block_cntt">

						  	<div class="menu left col1-3">
							  	<div class="menu_wpr">
								  	<a class="menu_link secondary menu_grupo_link"></a>
								  	<nav class="menu_cntt menu_grupo">
										<?php 
											wp_nav_menu( $args = array('menu' => 'grupott') );
										?>
								  	</nav>
							  	</div>
							  	<?php get_template_part('searchform'); ?>
							  	<span class="clear"></span>
						  	</div>

						  	<div class="col1-3">
						  		<h1 class="logo">
									<a href="<?php echo home_url(); ?>" title="Negócios em Transporte" alt="Negócios em Transporte">
								  		<?php get_template_part('svg', 'logo'); ?>
									</a>
								</h1>
							</div>

							<div class="right menu col1-3">
								<?php 
									wp_nav_menu( $args = array('menu' => 'social') );
								?>

								<div class="revista">

								<?php
									$cat_obj = get_category_by_slug( 'revista' );
									$cat_id = $cat_obj->term_id;
									$args=array(
										'cat' => $cat_id,
										'post_type' => 'post',
										'post_status' => 'publish',
										'posts_per_page' => 1,
										'caller_get_posts'=> 1
									);
									$my_query = null;
									$my_query = new WP_Query($args);
									if( $my_query->have_posts() ) {
									  	while ($my_query->have_posts()) : $my_query->the_post(); ?>
									   		<?php 
											$link = get_post_meta(get_the_ID(), 'link_revista', true); 
											if(!$link){ $link = "#"; }
											?>
											<figure>
												<a href="<?php echo $link;?>" title="<?php the_title(); ?>" target="_blank">
												<?php if ( has_post_thumbnail()) : ?>
													<?php the_post_thumbnail();  ?>
												<?php endif; ?>
												</a>
											</figure>
								   		 <?php 
								   		 endwhile;
									}
									wp_reset_query();  // Restore global post data stomped by the_post().
								?>

								</div>


						  	</div>

						  	<span class="clear"></span>

					  	</div>
					</section><!-- .header_secondary_social -->

					<section class="block_wpr block_menu">
						<div class="menu responsive wpr">
							<a class="menu_link"></a>
							<div class="menu responsive cntt">
								<nav class="menu responsive_primary">
									<?php 
										wp_nav_menu( $args = array('menu' => 'primary') );
									?>
								</nav>
								<nav class="menu responsive_secondary">
									<?php 
										wp_nav_menu( $args = array('menu' => 'grupott') );
									?>
								</nav>
							</div>
						</div>

						<div id="tabs-ajax">
							<ul class="primary menu block_cntt">
								<?php 
									//wp_nav_menu( $args = array('menu' => 'primary') );
									$menu_items = wp_get_nav_menu_items ('primary');
									foreach ($menu_items as $menu_item) {
										$title = $menu_item->title;
        								$url = $menu_item->url;
										$object_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
										$object    = get_post_meta( $menu_item->ID, '_menu_item_object',    true );
										$type      = get_post_meta( $menu_item->ID, '_menu_item_type',      true );

										echo '<li><a href="'. get_template_directory_uri(). '/ajax/submenu.php?catid='. $object_id . '" class="link '. $object . '">' . $title . '</a></li>';
									}	
								?>
							</ul>

						</div>  <!-- #tabs-ajax -->
						<div class="loading_wpr submenu_loading">
							<span class="loading"></span>
						</div>

					</section> <!-- .block_menu -->				
				</div>
			</div> <!-- .relative -->
			<section class="block_wpr adv header">
				<div class="block_cntt">
					<figure class="adv_wpr">
						<?php get_template_part('advertising', 'area1'); ?>
					</figure>
				</div>
			</section>
		  	<?php get_template_part('searchform', 'mobile'); ?>

