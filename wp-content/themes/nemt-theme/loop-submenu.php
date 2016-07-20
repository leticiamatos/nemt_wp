<?php if ($post):  ?>

	<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>

		<figure>
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail();  ?>
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/img/no-thumb.png"/>
			<?php endif; ?>
		</figure>
		<h2 class="title"><?php the_title(); ?></h2>
		<a class="link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>

	</article>

<?php else: ?>

	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>

<?php endif; ?>
