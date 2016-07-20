<?php get_header(); ?>

	<main role="main">

		<section class="block_wpr ticker_rss">
			<div class="block_cntt">
				<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-rss')); ?>

				
				<span class="icon"></span>
				<span class="text">Últimas Notícias:</span>
			</div>
		</section> <!-- .ticker_rss -->

		<section class="block_wpr highlight">
			<div class="block_cntt">
				<div class="col2-3">
					<?php get_template_part('loop', 'highlight'); ?>
					<?php get_template_part('newsletter'); ?>
				</div>
				<div class="col1-3">
					<?php get_template_part('loop', 'lastposts'); ?>
					<div class="space"></div>
				</div>
				<span class="clear"></span>
				<div class="bg_red col1-3"></div>
				
			</div>
		</section>

		<section class="block_wpr modal block_tab">
			<div class="block_cntt">
				<span class="block_border"></span>
				<span class="block_border_gap"></span>
				<?php get_template_part('index', 'modal'); ?>
				
			</div>			
		</section> <!-- .modal -->


		<section class="block_wpr onibus block_tab">
			<div class="block_cntt">
				<span class="block_border"></span>
				<span class="block_border_gap"></span>
				<?php get_template_part('index', 'onibus'); ?>
				
			</div>			
		</section> <!-- .onibus -->

		<section class="block_wpr adv content">
			<div class="block_cntt">
				<figure class="adv_wpr">
					<?php get_template_part('advertising', 'area4'); ?>
				</figure>
			</div>
		</section> <!-- .adv.content -->

		<section class="block_wpr logistica block_tab">
			<div class="block_cntt">
				<span class="block_border"></span>
				<span class="block_border_gap"></span>
				<?php get_template_part('index', 'logistica'); ?>
				
			</div>			
		</section> <!-- .logistica -->

		<section class="block_wpr posvenda block_carousel">
			<div class="block_cntt">
				<span class="block_border"></span>
				<?php get_template_part('index', 'posvenda'); ?>
			</div>			
		</section> <!-- .posvenda -->

		<section class="block_wpr blogsecolunas">
			<div class="block_cntt">

				<div class="col2-3">
					<div class="col_cntt">
						<span class="block_border"></span>
						<span class="block_border_gap"></span>
						<?php get_template_part('index', 'blogsecolunas'); ?>
						<div class="adv blog">
							<figure class="adv_wpr">
								<?php get_template_part('advertising', 'area6'); ?>
							</figure>
						</div>
						<span class="clear"></span>
					</div> <!-- .col_cntt -->
				</div> <!-- .col2-3 -->
				<div class="col1-3">	
					<div class="col_cntt most_popular">
						<span class="block_border"></span>
						<?php if( function_exists('wpp_get_mostpopular')){ wpp_get_mostpopular( 'header="mais lidas"&limit=5' );} ?>
					</div> <!-- .col_cntt -->
				</div> <!-- .col1-3 -->

				<span class="clear"></span>

			</div>			
		</section> <!-- .blogsecolunas -->

		<section class="block_wpr panorama">
			<div class="block_cntt">
				<div class="col2-3">
					<span class="block_border"></span>
					<span class="block_border_gap"></span>
					<?php get_template_part('index', 'panorama'); ?>
				</div>
				<div class="col1-3">
					<?php get_template_part('newsletter', 'footer'); ?>
				</div>
				<span class="clear"></span>
				
			</div>			
		</section> <!-- .panorama -->


		
		
	</main>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
