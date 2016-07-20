<div class="bar_category wpr">

	<span class="block_border"></span>
	<span class="block_border_gap"></span>
	<h3 class="block_title">
		<?php if(is_tag()): ?>
			<strong>Tag: </strong><?php echo single_tag_title('', false); ?>
		<?php elseif(is_search()): ?>
			<strong>Pesquisando... </strong><?php echo get_search_query(); ?>
		<?php endif; ?>
	</h3>
</div>

