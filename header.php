<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10" lang=""> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/includes/img/favicon.ico" />
        <script>(function(){document.documentElement.className='js'})();</script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="page" class="hfeed site">

            <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', THEME_DOMAIN ); ?></a>

            <?php get_template_part( 'templates/parts/content', 'header' ); ?>

            <main id="site-main" role="main">
            