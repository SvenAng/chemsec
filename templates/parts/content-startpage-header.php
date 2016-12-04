<header id="site-header" role="banner">
	
	<div class="container">

		<!-- Logotype -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logotype">

	        <?php if ( function_exists( 'get_field' ) && $logotype = get_field( 'logotype', 'option' ) ) : ?>

	        	<img id="logotype" src="<?php echo $logotype; ?>">
			
			<?php else: ?>
				
				<img src="<?php echo TEMPLATE_IMG_DIRECTORY_URI . '/franssons-rum-logotype.png'; ?>" alt="">

	        <?php endif; ?>

	    </a>
	    <!-- End Logotype -->

	    <!-- Nav Header -->
		
		<nav id="header-nav">
			
			<?php
	            if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'nav-header' ) ) {
	                wp_nav_menu( array(
	                    'depth' => 1, 
	                    'sort_column' => 
	                    'menu_order', 
	                    'container' => 'ul', 
	                    'menu_id' => '', 
	                    'menu_class' => 'header-menu', 
	                    'theme_location' => 'nav-header',
	                    'link_before' => '',
	                    'link_after' => '<span></span>',
	                    'after' => '<li class="header-nav-separator">/</li>'
	                ) );
	            }
	        ?>

		</nav>
	    <!-- End Nav Header -->

    	

    </div>

    <!-- Header Banner Image -->
		
	<div id="header-banner" style="background-image: url( <?php echo TEMPLATE_IMG_DIRECTORY_URI . '/sample-banner.jpg'?> ); "></div>

	<!-- END Header Banner Image -->

</header>