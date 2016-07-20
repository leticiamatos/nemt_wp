
		<section class="block_wpr prefooter sitemap">
			<div class="block_cntt">
			<?php 
			    wp_nav_menu(
			    array(
			        'menu'            => 'sitemap',
			        'container'       => 'div',
			        'container_class' => 'menu-{menu slug}-container',
			        'menu_class'      => 'menu',
			        'echo'            => true,
			        'items_wrap'      => '<ul>%3$s</ul>',
			        'depth'           => 3
			        )
			    );
			?>
				<span class="clear"></span>
			</div>
		</section> <!-- .prefooter.sitemap -->