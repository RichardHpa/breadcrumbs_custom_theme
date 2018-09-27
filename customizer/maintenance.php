<?php

function clinto_register_fields() {
    //delete_option( "clinto_under_maintenance" );
    register_setting( 'general', 'clinto_under_maintenance', 'esc_attr' );
    add_settings_field('mk_clinto_under_maintenance', '<label for="clinto_under_maintenance">'. 'Under Maintenance' . '</label>' , 'clinto_fields_html' , 'general' );
}

function clinto_fields_html() {
    $value = get_option( 'clinto_under_maintenance');
    $checked = ($value=='yes') ? 'checked="checked"' : '';
    echo '<input type="hidden" name="clinto_under_maintenance" value="no" /><input id="clinto_under_maintenance" type="checkbox" '.$checked.' name="clinto_under_maintenance" value="yes" />';
}

add_filter( 'admin_init' , 'clinto_register_fields' );

$maintenanceMode = get_option( 'clinto_under_maintenance');
if($maintenanceMode == 'yes'){
    add_action('wp_loaded', 'maintenance_mode');
    add_action('admin_bar_menu', 'add_toolbar_items', 100);
    add_action('admin_head', 'admin_style');
    add_action('wp_head', 'admin_style');
}

function admin_style() {
  echo '<style>
  #wpadminbar{
      background: #16a085;
  }
  </style>';
}

function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'maintenance_mode',
        'title' => 'In Maintenance Mode',
        'href'  => '#',
        'meta'  => array(
            'title' => __('In Maintenance Mode'),
        ),
    ));
}

function maintenance_mode() {
    global $pagenow;
    if ( $pagenow !== 'wp-login.php' && ! current_user_can( 'manage_options' ) && ! is_admin() ) {
        header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
        header( 'Content-Type: text/html; charset=utf-8' );
        if ( file_exists( get_parent_theme_file_path() . '/maintenance.php' ) ) {
            require_once(get_parent_theme_file_path() . '/maintenance.php');
        }
        die();
    }
}
