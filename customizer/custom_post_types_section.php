<?php

function locations_taxonomy() {
    register_taxonomy(
    'locations_categories',
        'locations',
        array(
            'hierarchical' => false,
            'label' => 'Locations',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'locations',
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'locations_taxonomy');

function activities_init() {
    $labels = array(
        'name'               => _x( 'Activities', 'Breadcrumbs' ),
        'singular_name'      => _x( 'Activity', 'Breadcrumbs' ),
        'menu_name'          => _x( 'Activities', 'Breadcrumbs' ),
        'name_admin_bar'     => _x( 'Activity', 'Breadcrumbs' ),
        'add_new'            => _x( 'Add a new Activity', 'Breadcrumbs' ),
        'add_new_item'       => __( 'Add a new Activity', 'Breadcrumbs' ),
        'new_item'           => __( 'New Activity', 'Breadcrumbs' ),
        'edit_item'          => __( 'Edit Activity', 'Breadcrumbs' ),
        'view_item'          => __( 'View Activity', 'Breadcrumbs' ),
        'all_items'          => __( 'All Activities', 'Breadcrumbs' ),
        'search_items'       => __( 'Search Activities', 'Breadcrumbs' ),
        'parent_item_colon'  => __( 'Parent Activity:', 'Breadcrumbs' ),
        'not_found'          => __( 'No Activities found.', 'Breadcrumbs' ),
        'not_found_in_trash' => __( 'No Activities found in Trash.', 'Breadcrumbs' )
    );
    $args = array(
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'has_archive' => 'activities',
        'taxonomies' => array('post_tag','locations_categories'),
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array(
            'title',
            'editor',
            'thumbnail')
        );
    register_post_type( 'activities', $args );
}
add_action( 'init', 'activities_init' );

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function companies_init() {
    $labels = array(
        'name'               => _x( 'Companies', 'Breadcrumbs' ),
        'singular_name'      => _x( 'Company', 'Breadcrumbs' ),
        'menu_name'          => _x( 'Companies', 'Breadcrumbs' ),
        'name_admin_bar'     => _x( 'Company', 'Breadcrumbs' ),
        'add_new'            => _x( 'Add a new Company', 'Breadcrumbs' ),
        'add_new_item'       => __( 'Add a new Company', 'Breadcrumbs' ),
        'new_item'           => __( 'New Company', 'Breadcrumbs' ),
        'edit_item'          => __( 'Edit Company', 'Breadcrumbs' ),
        'view_item'          => __( 'View Company', 'Breadcrumbs' ),
        'all_items'          => __( 'All Companies', 'Breadcrumbs' ),
        'search_items'       => __( 'Search Companies', 'Breadcrumbs' ),
        'parent_item_colon'  => __( 'Parent Companies:', 'Breadcrumbs' ),
        'not_found'          => __( 'No Companies found.', 'Breadcrumbs' ),
        'not_found_in_trash' => __( 'No Companies found in Trash.', 'Breadcrumbs' )
    );
    $args = array(
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title',
            'thumbnail')
        );
    register_post_type( 'companies', $args );
}
add_action( 'init', 'companies_init' );

function promotions_init() {
    $labels = array(
        'name'               => _x( 'Promotions', 'Breadcrumbs' ),
        'singular_name'      => _x( 'Promotion', 'Breadcrumbs' ),
        'menu_name'          => _x( 'Promotions', 'Breadcrumbs' ),
        'name_admin_bar'     => _x( 'Promotion', 'Breadcrumbs' ),
        'add_new'            => _x( 'Add a new Promotion', 'Breadcrumbs' ),
        'add_new_item'       => __( 'Add a new Promotion', 'Breadcrumbs' ),
        'new_item'           => __( 'New Promotion', 'Breadcrumbs' ),
        'edit_item'          => __( 'Edit Promotion', 'Breadcrumbs' ),
        'view_item'          => __( 'View Promotion', 'Breadcrumbs' ),
        'all_items'          => __( 'All Promotions', 'Breadcrumbs' ),
        'search_items'       => __( 'Search Promotions', 'Breadcrumbs' ),
        'parent_item_colon'  => __( 'Parent Promotions:', 'Breadcrumbs' ),
        'not_found'          => __( 'No Promotions found.', 'Breadcrumbs' ),
        'not_found_in_trash' => __( 'No Promotions found in Trash.', 'Breadcrumbs' )
    );
    $args = array(
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array(
            'title',
            'thumbnail',
            'editor')
        );
    register_post_type( 'promotions', $args );
}
add_action( 'init', 'promotions_init' );

function promotions_icons_init() {
    $labels = array(
        'name'               => _x( 'Promotions Icons', 'Breadcrumbs' ),
        'singular_name'      => _x( 'Promotion Icon', 'Breadcrumbs' ),
        'menu_name'          => _x( 'Promotions Icons', 'Breadcrumbs' ),
        'name_admin_bar'     => _x( 'Promotions Icons', 'Breadcrumbs' ),
        'add_new'            => _x( 'Add a new Promotion Icon', 'Breadcrumbs' ),
        'add_new_item'       => __( 'Add a new Promotion Icon', 'Breadcrumbs' ),
        'new_item'           => __( 'New Promotion Icon', 'Breadcrumbs' ),
        'edit_item'          => __( 'Edit Promotion Icon', 'Breadcrumbs' ),
        'view_item'          => __( 'View Promotion Icon', 'Breadcrumbs' ),
        'all_items'          => __( 'All Promotions Icons', 'Breadcrumbs' ),
        'search_items'       => __( 'Search Promotions Icons', 'Breadcrumbs' ),
        'parent_item_colon'  => __( 'Parent Promotions Icon:', 'Breadcrumbs' ),
        'not_found'          => __( 'No Promotion Icons found.', 'Breadcrumbs' ),
        'not_found_in_trash' => __( 'No Promotion Icons found in Trash.', 'Breadcrumbs' )
    );
    $args = array(
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array(
            'title',
            'thumbnail',
            'editor')
        );
    register_post_type( 'promotions_icons', $args );
}
add_action( 'init', 'promotions_icons_init' );

function associations_init() {
    $labels = array(
        'name'               => _x( 'Associations', 'Breadcrumbs' ),
        'singular_name'      => _x( 'Association', 'Breadcrumbs' ),
        'menu_name'          => _x( 'Associations', 'Breadcrumbs' ),
        'name_admin_bar'     => _x( 'Association', 'Breadcrumbs' ),
        'add_new'            => _x( 'Add a new Association', 'Breadcrumbs' ),
        'add_new_item'       => __( 'Add a new Association', 'Breadcrumbs' ),
        'new_item'           => __( 'New Association', 'Breadcrumbs' ),
        'edit_item'          => __( 'Edit Association', 'Breadcrumbs' ),
        'view_item'          => __( 'View Association', 'Breadcrumbs' ),
        'all_items'          => __( 'All Associations', 'Breadcrumbs' ),
        'search_items'       => __( 'Search Associations', 'Breadcrumbs' ),
        'parent_item_colon'  => __( 'Parent Associations:', 'Breadcrumbs' ),
        'not_found'          => __( 'No Associations found.', 'Breadcrumbs' ),
        'not_found_in_trash' => __( 'No Associations found in Trash.', 'Breadcrumbs' )
    );
    $args = array(
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array(
            'title',
            'thumbnail')
        );
    register_post_type( 'associations', $args );
}
add_action( 'init', 'associations_init' );
