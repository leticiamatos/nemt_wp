
<div class="search wpr hover_effect">
	<a class="search link"></a>
	<div class="search cntt ">
		<div class="search relative">
			<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="form_div">
					<input type="text" class="txt" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="digite sua busca" />
					<input type="submit" class="btn" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
				</div>
			</form>
		</div>
	</div>
</div>	