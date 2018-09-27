<?php


function customCustomizer($wp_customize){
    require_once( dirname( __FILE__ ) . '/alpha-color-picker/alpha-color-picker.php' );
    /*
        Theme Styles
    */
    $wp_customize->add_section('theme_style_section', array(
        'title' => __('Theme Styles', 'Breadcrumbs'),
        'priority' => 20,
    ));
    //Header Links
    $wp_customize->add_setting(
        'header_link_colours_setting',
        array(
            'default' => '#ffffff',
            'transport' => 'refresh'
	    )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_link_colour_control',
            array(
        		'label' => __('Header Link Colours', 'Breadcrumbs'),
        		'section' => 'theme_style_section',
        		'settings' => 'header_link_colours_setting',
	        )
        )
    );
    //Footer Background Colour
	$wp_customize->add_setting(
		'footer_color_setting',
		array(
			'default'     => '#0c4956',
			'type'        => 'theme_mod',
			'capability'  => 'edit_theme_options',
			'transport'   => 'refresh',
		)
	);
	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'footer_colour_control',
			array(
				'label'         => __( 'Footer Background Colour', 'Breadcrumbs' ),
				'section'       => 'theme_style_section',
				'settings'      => 'footer_color_setting',
				'show_opacity'  => true
			)
		)
	);
    //Main Footer Link
    $wp_customize->add_setting(
        'main_footer_link_colours_setting',
        array(
            'default' => '#ffffff',
            'transport' => 'refresh'
	    )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_footer_link_colour_control',
            array(
        		'label' => __('Main Footer Link Colours', 'Breadcrumbs'),
        		'section' => 'theme_style_section',
        		'settings' => 'main_footer_link_colours_setting',
	        )
        )
    );
    //Sub Footer Link
    $wp_customize->add_setting(
        'sub_footer_link_colours_setting',
        array(
            'default' => '#37b6b5',
            'transport' => 'refresh'
	    )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sub_footer_link_colour_control',
            array(
        		'label' => __('Sub Footer Link Colours', 'Breadcrumbs'),
        		'section' => 'theme_style_section',
        		'settings' => 'sub_footer_link_colours_setting',
	        )
        )
    );
    //Background Image
    $wp_customize->add_setting('header_background_image_setting', array(
        'default' => '0',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'header_background_image_control', array(
		'label' => __('Default Background Image', 'Breadcrumbs'),
		'section' => 'theme_style_section',
		'settings' => 'header_background_image_setting',
        'width' => 1920,
        'height' => 1080,
        'flex_height' => true,
        'flex_width' => true
	)));

    //Page Image
    $wp_customize->add_setting('page_background_image_setting', array(
        'default' => '0',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'page_background_image_control',
            array(
        		'label' => __('Background Pattern', 'Breadcrumbs'),
        		'section' => 'theme_style_section',
        		'settings' => 'page_background_image_setting',
                'height' => 1080,
                'width' => 500,
                'flex_height' => true,
                'flex_width' => true
	        )
        )
    );
    /*
        Home Page Content
    */
    $wp_customize->add_panel('Home_Page_Panel', array(
        'title' =>__('Home Page Content', 'Breadcrumbs'),
        'priority' => 30,
        'description' => __( 'Change some of the home page content')
    ));
    //Creating 4 Sections for Icons in the home page
    for ($i=1; $i <= 4 ; $i++) {
        //Create the Section for each Icons
        $wp_customize->add_section('icon_'.$i.'_section', array(
            'title' => __('Icon '.$i, 'Breadcrumbs'),
            'priority' => 30,
            'panel' => 'Home_Page_Panel'
        ));
        //Adding the Setting for the Icons
        $wp_customize->add_setting('icon_'.$i.'_setting', array(
            'default' => '0',
            'sanitize_callback' => 'absint',
            'transport' => 'refresh'
        ));
        //Adding the Image Control for the Icon
        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'icon_'.$i.'_setting_control', array(
    		'label' => __('Icon '.$i, 'Breadcrumbs'),
    		'section' => 'icon_'.$i.'_section',
    		'settings' => 'icon_'.$i.'_setting',
            'width' => 300,
            'height' => 300,
            'flex_height' => true,
            'flex_width' => true,
    	)));
        //Adding the setting for each icons description
        $wp_customize->add_setting('icon_'.$i.'_description_Setting', array(
            'transport' => 'refresh'
        ));
        //Adding the text area for the icons description
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'icon_'.$i.'_Description_Control', array(
            'label' => __('Icon '.$i.' Description', 'Breadcrumbs'),
            'section' => 'icon_'.$i.'_section',
            'settings' => 'icon_'.$i.'_description_Setting',
            'type' => 'text'
        )));
    }

    $wp_customize->add_section('icon_colour_section', array(
        'title' => __('Icon Colour', 'Breadcrumbs'),
        'priority' => 30,
        'panel' => 'Home_Page_Panel'
    ));

    //Header Links
    $wp_customize->add_setting(
        'icon_colour_setting',
        array(
            'default' => '#ffffff',
            'transport' => 'refresh'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_link_colour_control',
            array(
                'label' => __('Icon Colours', 'Breadcrumbs'),
                'section' => 'icon_colour_section',
                'settings' => 'icon_colour_setting',
            )
        )
    );

    //Activites Image Section
    $wp_customize->add_section('activites_background_image', array(
        'title' => __('Activities Background Image', 'Breadcrumbs'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('activities_background_image_setting', array(
        'default' => '0',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'activites_background_image_control', array(
        'label' => __('Main Image', 'Breadcrumbs'),
        'section' => 'activites_background_image',
        'settings' => 'activities_background_image_setting',
        'width' => 1920,
        'height' => 1080,
        'flex_height' => true,
        'flex_width' => true
    )));

    //Promotions Page Panel
    $wp_customize->add_panel('Promotions_Panel', array(
        'title' =>__('Promotions Page', 'Breadcrumbs'),
        'priority' => 30,
        'description' => __( 'Change the styling of the header')
    ));

    $wp_customize->add_section('Promotions_Image', array(
        'title' => __('Promotions Large Image', 'Breadcrumbs'),
        'priority' => 30,
        'panel' => 'Promotions_Panel'
    ));

    $wp_customize->add_setting('promotions_large_image_setting', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'Promotions_large_image_setting_control', array(
        'label' => __('Large Promotions Image', 'Breadcrumbs'),
        'section' => 'Promotions_Image',
        'settings' => 'promotions_large_image_setting',
        'width' => 1140,
        'height' => 800,
        'flex_height' => true,
        'flex_width' => true
    )));

    $wp_customize->add_section('promotions_icon_colour_section', array(
        'title' => __('Icon Text Colour', 'Breadcrumbs'),
        'priority' => 30,
        'panel' => 'Promotions_Panel'
    ));

    //Header Links
    $wp_customize->add_setting(
        'promotions_icon_colour_setting',
        array(
            'default' => '#000000',
            'transport' => 'refresh'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'promotions_icon_colour',
            array(
                'label' => __('Icon Colours', 'Breadcrumbs'),
                'section' => 'promotions_icon_colour_section',
                'settings' => 'promotions_icon_colour_setting',
            )
        )
    );


}
add_action('customize_register', 'customCustomizer');

function breadcrumbs_customize_css(){

    function get_background_image_url($modname) {
        if( get_theme_mod($modname) > 0) {
            return wp_get_attachment_url( get_theme_mod( $modname ) );
        }
    };
?>

    <style>

        #header-nav-collapse ul li a{
            color: <?php echo get_theme_mod('header_link_colours_setting') ?> !important;
        }

        footer{
            background-color: <?php echo get_theme_mod( 'footer_color_setting' ); ?> !important;
        }
        ul.social-media-icons li a i{
            color: <?php echo get_theme_mod( 'footer_color_setting' ); ?> !important;
        }

        .footerNavContainer ul>li>a{
            color: <?php echo get_theme_mod( 'main_footer_link_colours_setting' ); ?> !important;
        }
        ul.sub-menu>li>a{
            color: <?php echo get_theme_mod( 'sub_footer_link_colours_setting' ); ?> !important;
        }
        #bannerImage{
            background-image: url(<?php if (get_theme_mod( 'header_background_image_setting' )) : echo esc_url( get_background_image_url(header_background_image_setting) ); else: echo get_template_directory_uri().'/assets/images/default_banner.jpg'; endif; ?>);
        }
        .activity-container{
            background-image: url(<?php if (get_theme_mod( 'activities_background_image_setting' )) : echo esc_url( get_background_image_url(activities_background_image_setting) ); else: echo get_template_directory_uri().'/assets/images/default_banner.jpg'; endif; ?>);
        }

        .aboutSection{
            background-image: url(<?php if (get_theme_mod( 'page_background_image_setting' )) : echo esc_url( get_background_image_url(page_background_image_setting) ); else: echo get_template_directory_uri().'/assets/images/background.png'; endif; ?>);
        }

        .home-icons p{
            color: <?php echo get_theme_mod('icon_colour_setting'); ?> !important;
        }

        .promotions .card-body p,
        .promotions .card-body h5{
            color: <?php echo get_theme_mod('promotions_icon_colour_setting') ?> !important;
        }
    </style>
<?php
}
add_action('wp_head', 'breadcrumbs_customize_css');
