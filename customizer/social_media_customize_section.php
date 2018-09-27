<?php
function ct_breadcrumbs_social_array() {
	$social_sites = array(
        'email'         => 'breadcrumbs_email_form_profile',
		'twitter'       => 'breadcrumbs_twitter_profile',
		'facebook'      => 'breadcrumbs_facebook_profile',
		'google-plus'   => 'breadcrumbs_googleplus_profile',
		'linkedin'      => 'breadcrumbs_linkedin_profile',
		'youtube'       => 'breadcrumbs_youtube_profile',
		'vimeo'         => 'breadcrumbs_vimeo_profile',
		'instagram'     => 'breadcrumbs_instagram_profile',
		'rss'           => 'breadcrumbs_rss_profile',
		'skype'         => 'breadcrumbs_skype_profile',
		'paypal'        => 'breadcrumbs_paypal_profile'
	);

	return apply_filters( 'ct_breadcrumbs_social_array_filter', $social_sites );
}

function my_add_customizer_sections( $wp_customize ) {

	$social_sites = ct_breadcrumbs_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_breadcrumbs_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'breadcrumbs' ),
		'priority'    => 25,
		'description' => __( 'Add the URL for each of your social profiles.', 'breadcrumbs' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {

		$label = ucfirst( $social_site );

		if ( $social_site == 'google-plus' ) {
			$label = 'Google Plus';
		} elseif ( $social_site == 'rss' ) {
			$label = 'RSS';
		} elseif ( $social_site == 'email-form' ) {
			$label = 'Contact Form';
		}
		// setting
		$wp_customize->add_setting( $social_site, array(
			'sanitize_callback' => 'esc_url_raw'
		) );
		// control
		$wp_customize->add_control( $social_site, array(
			'type'     => 'url',
			'label'    => $label,
			'section'  => 'ct_breadcrumbs_social_media_icons',
			'priority' => $priority
		) );
		// increment the priority for next site
		$priority = $priority + 5;
	}
}
add_action( 'customize_register', 'my_add_customizer_sections' );

function my_social_icons_output() {

	$social_sites = ct_breadcrumbs_social_array();

	foreach ( $social_sites as $social_site => $profile ) {

		if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
			$active_sites[ $social_site ] = $social_site;
		}
	}

	if ( ! empty( $active_sites ) ) {

		echo '<ul class="social-media-icons">';
		foreach ( $active_sites as $key => $active_site ) {
            if($key == 'email'){
                $class = 'fa fa-envelope';
                $email = str_replace('http://', '', get_theme_mod( $key ) );
                ?>
                <li>
    				<a class="<?php echo esc_attr( $active_site ); ?>"  href="mailto:<?php echo  $email ; ?>">
    					<i class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $active_site ); ?>"></i>
    				</a>
    			</li>
                <?php
            } else{
                $class = 'fa fa-' . $active_site;
                ?>
                <li>
    				<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank" href="<?php echo esc_url( get_theme_mod( $key ) ); ?>">
    					<i class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $active_site ); ?>"></i>
    				</a>
    			</li>
                <?php
            }
    }
		echo "</ul>";
	}
}
