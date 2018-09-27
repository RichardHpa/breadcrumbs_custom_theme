<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>
            <?php if(is_front_page() || is_home()){
                echo get_bloginfo('name');
            } else{
                echo wp_title('');
            }?>
        </title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <?php wp_head(); ?>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>
    <!-- Opening Body Tag -->
    <?php echo '<body class="'.join(' ', get_body_class()).'">'.PHP_EOL; ?>
    <?php
        $id = get_the_id();
        if ( is_home() ) {
            $id = get_option( 'page_for_posts' );
        }
    ?>
    <?php
        $headerImageID = get_post_meta( $id , 'header_background', true);
        if($headerImageID){
            $backgroundImage = wp_get_attachment_image_src($headerImageID, 'large');
            $style = 'background-image: url('.$backgroundImage[0].');';
        }
    ?>
    <div id="bannerImage" class="d-flex w-100 h-90 mx-auto flex-column" style="<?= $style ?>">
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
        <div class="container mt-auto h-100">
            <?php
                if(is_page()){
                    $imageID =  get_post_meta( $id , 'header_image', true);
                }

                if(is_post_type_archive()){
                    $title = str_replace("Archives: ", "", get_the_archive_title());
                } else {
                    $title = get_post_meta( $id , 'header_text', true);
                    if(!$title){
                        $title = get_the_title($id);
                    }
                }
             ?>
    
                 <div class="headerRow row h-100">
                     <div class="col-12 col-md-6 headerText align-self-center">
                         <div class="headerTitle mb-5 mb-sm-0">
                             <h1><?php echo $title?></h1>
                         </div>
                         <?php if(get_post_meta( $id , 'header_description', true)): ?>
                             <div class="headerDesc mb-5 mb-sm-0 d-none d-md-block">
                                 <h3><?php echo get_post_meta( $id , 'header_description', true); ?></h3>
                             </div>
                         <?php endif; ?>
                         <?php if(get_post_meta( $id , 'store_link', true) == "yes"): ?>
                             <div class="headerIcon mb-5 d-none d-md-block">
                                 <a class="app_store_btton" href="https://goo.gl/KB1c3K" target="_blank">
                                     <img width="200" src="<?php echo get_template_directory_uri().'/assets/images/app_store_button.png' ?>" alt="Download Breadcrumbs app from the apple store">
                                 </a>
                             </div>
                         <?php endif; ?>
                     </div>
                     <?php
                        $headerImage = wp_get_attachment_image_src($imageID, 'large', false);
                        $imageStyle = 'background-image: url('.$headerImage[0].');';
                      ?>
                     <div class="col-12 col-md-6 align-self-end imgCont" style="<?= $imageStyle ?>"></div>
                 </div>

        </div>
    </div>
    <?php if($imageID): ?>
        <?php if(get_post_meta( $id , 'store_link', true) == "yes"): ?>
            <div class="container d-block d-md-none">
                <div class="row mt-5">
                    <div class="col text-center">
                        <a class="app_store_btton" href="https://goo.gl/KB1c3K" target="_blank">
                            <img width="200" src="<?php echo get_template_directory_uri().'/assets/images/app_store_button.png' ?>" alt="Download Breadcrumbs app from the apple store">
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
