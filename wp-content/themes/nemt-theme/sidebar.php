<!-- sidebar -->
<aside class="sidebar" role="complementary">
	<div class="adv_wpr">
		<?php get_template_part('advertising', 'area9' ); ?>
	</div>
	<div class="col_cntt most_popular">
		<span class="block_border"></span>
		<?php if( function_exists('wpp_get_mostpopular')){ wpp_get_mostpopular( 'header="mais lidas"&limit=5' );} ?>
	</div> <!-- .col_cntt -->
	<span class="clear"></span>
	<?php get_template_part('newsletter', 'footer'); ?>
</aside>
