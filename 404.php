<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?= wp_title(''); ?></title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <?php wp_head(); ?>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>
    <?php echo '<body class="'.join(' ', get_body_class()).'">'.PHP_EOL; ?>
        <div id="bannerImage" class="d-flex w-100 h-90" style="<?= $style ?>">
            <header id="bannerHeader" class="mb-auto">
                <nav class="navbar navbar-expand-md justify-content-center navbar-dark bg-dark container">
                    <?php
                        $url = home_url();
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        if ( has_custom_logo() ) {
                                echo '<a class="navbar-brand" href="'.esc_url( $url ).'"><img src="'. esc_url( $logo[0] ) .'"height="50" class="d-inline-block align-top"></a>';
                        } else {
                                echo '<a class="navbar-brand" href="'.esc_url( $url ).'">'. get_bloginfo( 'name' ) .'</a>';
                        }
                     ?>
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav-collapse" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php
                        wp_nav_menu( array(
                            'theme_location'    => 'header_Navigation',
                            'depth'             => 2,
                            'container'         => 'div',
                            'container_class'   => 'collapse navbar-collapse',
                            'container_id'      => 'header-nav-collapse',
                            'menu_class'        => 'nav navbar-nav ml-auto w-100 justify-content-end',
                            'menu_id'           => 'header-nav',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker(),
                        ) );
                    ?>
                </nav>
            </header>
            <div class="errorPage container align-self-center text-center">
                <div class="col">
                    <h1>4<span><i class="icon-bicon"></i></span>4</h1>
                    <h2>The page you are looking<br>for does not exsist.</h2>
                </div>
            </div>
        </div>

    <?php get_footer(); ?>
