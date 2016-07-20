
<?php if (is_page ()): ?>

<section class="block_wpr block_breadcrumbs">
	<div class="block_cntt">

		<nav class="menu category">
			<h3>Você está em: <strong><?php the_title(); ?></strong></h3>
			<span class="separator bar">&nbsp;</span>
			<span class="clear"></span>
		</nav>

	</div><!-- .block_cntt -->
</section><!-- .block_breadcrumbs -->

<?php elseif (is_page ('contato')): ?>

<section class="block_wpr block_breadcrumbs">
	<div class="block_cntt">

		<nav class="menu category">
			<h3>Você está em: Contato</h3>
			<span class="separator bar">&nbsp;</span>
			<span class="contact mail">Para mais informações, envie e-mail para <a mailto="blogdascabeludas@gmail.com">blogdascabeludas@gmail.com</a></span>
			<span class="clear"></span>
		</nav>

	</div><!-- .block_cntt -->
</section><!-- .block_breadcrumbs -->

<?php elseif (is_search()): ?>

<section class="block_wpr block_breadcrumbs">
	<div class="block_cntt">

		<nav class="menu category">
			<h3>Pesquisando... </h3>
			<span class="separator bar">&nbsp;</span>
			<span class="contact mail"><?php echo get_search_query(); ?></span>
			<span class="clear"></span>
		</nav>

	</div><!-- .block_cntt -->
</section><!-- .block_breadcrumbs -->

<?php elseif (is_category('blog')): ?>

<section class="block_wpr block_breadcrumbs">
	<div class="block_cntt"> 
		<nav class="menu category">
			<h3>Você está em: BLOG</h3>
			<span class="clear"></span>
		</nav>

	</div><!-- .block_cntt -->
</section><!-- .block_breadcrumbs -->

<?php else: ?>


<section class="block_wpr block_breadcrumbs">
	<div class="block_cntt"> 
		<nav class="menu category">
			<h3>Você está em:</h3>
			<span class="separator bar">&nbsp;</span>
			<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

<!-- 			<a href="#" class="subcategory link">Cabelos</a>
			<span class="breadcrumbs separator">&nbsp;</span>
			<a href="#" class="subcategory link">Dicas</a>
			<span class="breadcrumbs separator">&nbsp;</span>
			<a href="#" class="subcategory link">Eventos</a> -->
			<span class="clear"></span>
		</nav>

	</div><!-- .block_cntt -->
</section><!-- .block_breadcrumbs -->
	
<?php endif; ?>