<div id="main-navigation">

	<div id="main-navigation-content">

		<?php get_template_part( 'templates/parts/menu', 'search-form' ); ?>

		<nav id="header-nav">
			
			<?php
	            if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'main-menu' ) ) {
	                wp_nav_menu( array(
	                    'sort_column' => 'menu_order', 
	                    'container' => 'ul', 
	                    'menu_id' => '', 
	                    'menu_class' => 'main-menu', 
	                    'theme_location' => 'main-menu',
	                    'depth' => 1
	                ) );
	            }
	        ?>

		</nav>

		<a href="#close" id="menu-close" class="icon-cancel">&#xe800;</a>

	</div>

</div>

<header id="site-header" role="banner">

	<div id="header">

		<div class="container">

			<div class="row">

				<div class="col-xs-8">
			        <div class="logotype">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				            <h1 class="site-title">

				                <!-- <img class="img-responsive" srcset="<?php //echo TEMPLATE_IMG_DIRECTORY_URI; ?>/logotype.png, <?php //echo TEMPLATE_IMG_DIRECTORY_URI; ?>/logotype@2x.png 2x" width="278" height="65" alt="<?php bloginfo( 'name' ); ?>"> -->
				                <img class="img-responsive" src="<?php echo TEMPLATE_IMG_DIRECTORY_URI; ?>/logotype.png" width="278" height="65" alt="<?php bloginfo( 'name' ); ?>">
	
				                <span class="site-name"><?php bloginfo( 'name' ); ?></span>

				            </h1>
			                <?php
			                $description = get_bloginfo( 'description', 'display' );
			                if ( $description ) : ?>
			           			<p class="site-description"><?php echo $description; ?></p>
			           		<?php endif; ?>
			           	</a>
			        </div>
			    </div>

				<div class="col-xs-4">
		            <a href="#" id="mobile-nav-trigger" class="pull-right">
		                <span class="line-wrapper">
			                <span class="line"></span>
			                <span class="line"></span>
			                <span class="line"></span>
			                <span class="line"></span>
			            	<span class="title"><?php _e('Menu', THEME_DOMAIN); ?></span>
		            	</span>
		            </a>
				</div>

			</div>
    	</div>
	</div>

    <!-- Header Banner Image -->
	
	<?php if(is_front_page()) {
		get_template_part( 'templates/parts/content-header', 'banner' );
	} ?>

	<!-- END Header Banner Image -->

</header>