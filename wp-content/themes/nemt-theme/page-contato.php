<?php 

/* Template Name: Contato */

?>

<?php get_header(); ?>

	<?php get_template_part('sidebar', 'breadcrumbs'); ?>

	<section class="block_wpr block_page">
		<div class="block_cntt">
			<div class="col2-3">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page_wpr">
						<h2 class="title">Sugestões? Dúvidas? Vou adorar seu contato!</h2>

						<div class="text">
							<?php echo do_shortcode('[contact-form-7 id="118" title="Contato"]'); ?>
						
							<!-- <form>
								<div class="form line">
									<input type="text" class="txt" placeholder="Nome:" />
								</div>
								<div class="form line">
									<input type="mail" class="txt" placeholder="E-mail:" />
								</div>
								<div class="form line">
									<textarea class="txt" placeholder="Mensagem:"></textarea>
								</div>
								<div class="form buttons">
									<input type="submit" class="btn" value="enviar" />
								</div>
							</form> -->


						</div>	

						<span class="clear"></span>		
					</div>				
				</article>
			<?php endwhile; ?>

			<?php else: ?>

				<!-- article -->
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

				</article>
				<!-- /article -->

			<?php endif; ?>
			</div>
			<div class="col1-3">
				<figure class="form image">
					<img src="<?php echo get_template_directory_uri(); ?>/img/contato_img.jpg" />
				</figure>
			</div>

			<span class="clear"></span>
		</div><!-- .block_cntt -->
	</section><!-- .block_01 -->


<?php get_footer(); ?>
