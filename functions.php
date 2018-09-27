<?php

/*
    Adding Style and Script files into the theme
*/
flush_rewrite_rules( false );



function customThemeEnqueues(){

    wp_enqueue_script('jquery');
    // Bootstrap
    wp_enqueue_style('bootstrapStyle', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.1.0', 'all');
    wp_enqueue_script('bootstrapScript', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '4.1.0', true);
    // Owl Carousel
    wp_enqueue_style('owlStyle', get_template_directory_uri() . '/assets/owl/owl.carousel.min.css', array(), '2.3.4', 'all');
    // wp_enqueue_style('owlThemeStyle', get_template_directory_uri() . '/assets/owl/owl.theme.default.min.css', array(), '2.3.4', 'all');
    wp_enqueue_script('owlScript', get_template_directory_uri() . '/assets/owl/owl.carousel.min.js', array(), '2.3.4', true);
    // styles
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0', 'all' );
    wp_enqueue_style('glyph-font', get_template_directory_uri() . '/assets/glyphter-font/css/Glyphter.css', array(), '4.7.0', 'all' );
    wp_enqueue_style('customStyle', get_template_directory_uri() . '/assets/css/sass.css', array(), '1.0.0', 'all');
    // scripts
    wp_enqueue_script('customScript', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0', true);

}
add_action('wp_enqueue_scripts', 'customThemeEnqueues');

/*
    Adding style and script files into the admin for the theme
*/
function admin_my_enqueue() {
    wp_enqueue_style('adminStyle', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0', 'all');
    wp_enqueue_script('adminScript', get_template_directory_uri() . '/assets/js/admin.js', array(), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'admin_my_enqueue');

/*
    Adding new Images sizes which get cropped on image uploads
*/
add_image_size('header_image', 9999, 600, false);
add_image_size('activity_image', 300, 200, false);
add_image_size( 'companies_thumb', 120, 120, false);

/*
    Adding theme support for the theme
*/
function customThemeSupport(){
    //Declares the menus which are present in the theme
    add_theme_support('menus');
    register_nav_menu('header_Navigation', 'This is the main navigation at the top of the page');
    register_nav_menu('footer_Navigation', 'This is the menu for the footer section of the page');

    //Allows posts to include thumbnail images
    add_theme_support('post-thumbnails');

    //Adds the ability to include a custom logo for the website
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'flex-width'  => true,
        'flex-height'  => true,
    ));
    //Adds the ability to include a tag line for the website
    add_theme_support( 'title-tag' );
}
add_action('init', 'customThemeSupport');

/*
    Extra files which are required for the theme
*/
require get_parent_theme_file_path('/customizer/walkers/class-wp-bootstrap-navwalker.php');
require get_parent_theme_file_path('/customizer/custom_customize_sections.php');
require get_parent_theme_file_path('/customizer/custom_fields.php');
require get_parent_theme_file_path('/customizer/social_media_customize_section.php');
require get_parent_theme_file_path('/customizer/custom_post_types_section.php');
