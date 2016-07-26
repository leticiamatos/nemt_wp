	<?php if (!is_home()): ?>
		<section class="block_wpr adv content">
			<div class="block_cntt">
				<figure class="adv_wpr">
					<?php get_template_part('advertising', 'area10'); ?>
				</figure>
			</div>
		</section> <!-- .adv.content -->
	<?php endif; ?>

		<section class="block_wpr adv content">
			<div class="block_cntt">
				<figure class="adv_wpr">
					<?php get_template_part('advertising', 'area7'); ?>
				</figure>
			</div>
		</section> <!-- .adv.content -->

		<section class="block_wpr revista block_carousel">
			<div class="block_cntt">
				<span class="block_border"></span>
				<?php get_template_part('index', 'revista'); ?>
			</div>			
		</section> <!-- .revista -->


		<?php get_template_part('footer', 'contato'); ?>

		<?php get_template_part('footer', 'sitemap'); ?>

			<footer class="block_wpr footer">
				<div class="block_cntt">
					<div class="col1-4">
						<h1 class="footer-logo">
							<a href="<?php echo home_url(); ?>" title="Negócios em Transporte" alt="Negócios em Transporte">
						  		<?php get_template_part('svg', 'logo'); ?>
							</a>
						</h1>
					</div>
					<div class="col2-4">
						<figure class="adv_wpr adv footer">
							<?php get_template_part('advertising', 'area8'); ?>
						</figure>
					</div>
					<div class="col1-4">
						<?php 
							wp_nav_menu( $args = array('menu' => 'social') );
						?>
					</div>
					<span class="clear"></span>
				</div><!-- .block_cntt -->
			</footer><!-- .footer -->			

			<section class="block_wpr copyright">
				<div class="block_cntt">
						<div class="copyright_txt">
						&copy; 2003 - <?php echo date('Y'); ?> - <?php bloginfo('name'); ?><span> Marca registrada da Tudo em Transporte Editora Ltda. Todos os direitos reservados.</span></div>
						<p class="layerup-logo">
							<a href="http://www.layerup.com.br/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/layerup-logo.png" alt="Layer Up" title="Layer Up" />&nbsp;</a>
						</p>
				</div><!-- .block_cntt -->
			</section><!-- .copyright -->

		</section>

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-81327684-1', 'auto');
		ga('send', 'pageview');

		</script>
		
	</body>
	
</html>
