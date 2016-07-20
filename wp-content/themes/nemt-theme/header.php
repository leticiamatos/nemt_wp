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
	<body <?php body_class(); ?>>
		<h5 style="display:none;">
			<?php echo bloginfo('rdf_url'); ?>
		</h5>

		<?php
			$cat_parent = '';

			if (!is_home()){
				if ( is_category('modal') || in_category('modal') ):
				$cat_parent = 'parent-cat-modal';
				
				elseif ( is_category('onibus') || in_category('onibus') ):
				$cat_parent = 'parent-cat-onibus';
				
				elseif ( is_category('logistica') || in_category('logistica') ):
				$cat_parent = 'parent-cat-logistica';
			 	
			 	elseif ( is_category('posvenda') || in_category('posvenda') ): 
				$cat_parent = 'parent-cat-posvenda';
				
			 	elseif ( is_category('blogs-e-colunas') || in_category('blogs-e-colunas') ): 
				$cat_parent = 'parent-cat-blogs-e-colunas';
			 	
				elseif ( is_category('panorama') || in_category('panorama') ):
				$cat_parent = 'parent-cat-panorama';
			 	
			 	elseif ( is_category('noticias') || in_category('noticias') ): 
				$cat_parent = 'parent-cat-noticias';
			 	
			 	elseif ( is_category('revista') || in_category('revista') ): 
				$cat_parent = 'parent-cat-revista';
			 	
			 	else:
				$cat_parent = 'parent-default';
				
				endif; 
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
									<a href="#" target="_blank">
										<img src="<?php echo get_template_directory_uri(); ?>/img/z_lixo/revista.jpg" />
									</a>
								</div>
						  	</div>

						  	<span class="clear"></span>

					  	</div>
					</section><!-- .header_secondary_social -->

					<section class="block_wpr block_menu">
						<div class="menu responsive wpr">
							<a class="menu_link"></a>
							<div class="menu responsive cntt">
							  	<?php get_template_part('searchform'); ?>
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

