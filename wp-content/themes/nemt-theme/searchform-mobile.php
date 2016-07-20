<section class="block_wpr search">
	<div class="block_cntt">

		<div class="search wpr mobile">
			<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="form_div">
					<input type="text" class="txt" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="digite sua busca" />
					<input type="submit" class="btn" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
				</div>
			</form>
		</div>	

	</div>
</section>