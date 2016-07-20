<?php $pagination_args = array(
	'prev_text'          => __('&nbsp;'),
	'next_text'          => __('&nbsp;')
); ?>

<section class="block_wpr pagination">
	<div class="block_cntt">
		<div class="pagination cntt">
				<?php echo paginate_links( $pagination_args ); ?>
		</div>
	</div><!-- .block_cntt -->
</section><!-- .pagination -->