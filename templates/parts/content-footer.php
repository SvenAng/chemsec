<footer id="site-footer" role="contentinfo">
	
	<div id="footer-info">

		<div class="container">
			
			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-4 col-md-push-4">
			
					<div class="row">

						<div class="col-xs-12"><h4>

							<h4><?php _e('The International Chemical Secretariat'); ?></h4>

							<?php echo get_field('address', 'option'); ?>
							
						</div>
						
					</div>
			
					<div class="row">

						<div class="col-xs-12">

							<?php get_template_part( 'templates/parts/footer', 'contact' ); ?>

						</div>

					</div>

				</div>


				<div class="col-xs-12 col-sm-6 col-md-4 col-md-push-4">

					<h4><?php _e('Latest Tweet'); ?></h4>

					<?php get_template_part( 'templates/parts/footer', 'twitter' ); ?>

					<?php get_template_part( 'templates/parts/footer', 'social-media-buttons' ); ?>

				</div>

				<div class="ol-sm-12 col-md-4 col-md-pull-8">

					<div class="logotype">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php echo get_acf('logotype', array('field_option' => 'option')); ?>
						</a>
					</div>
					
				</div>

			</div>

		</div>

	</div>

</footer>