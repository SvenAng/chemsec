<div id="sidebar-navigation">

    <nav id="sidebar-nav">

        <div class="sidebar-menu">

            <?php
            if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'main-menu' ) ) {
		        wp_nav_menu( array(
		            'sort_column' => 'menu_order', 
		            'container' => 'ul', 
		            'menu_id' => '', 
		            'menu_class' => 'main-menu', 
		            'theme_location' => 'main-menu',
		        ) );
		    }
            ?>
            
        </div>

    </nav>

</div>