<?php

add_action( 'after_setup_theme', 'alx_ext_custom_options', 11 );

function alx_ext_custom_options() {
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}

	Kirki::add_config( 'alx_extensions', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	Kirki::add_panel( 'alx_extensions_panel', array(
		'priority'    => 11,
		'title'       => esc_html__( 'Theme Extensions', 'alx-extensions' ),
	) );

	Kirki::add_section( 'alx_extensions_social', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Social Share', 'alx-extensions' ),
		'panel'       => 'alx_extensions_panel',
	) );

	Kirki::add_field( 'enable_social_share', array(
		'type'			=> 'switch',
		'settings'		=> 'enable-social-share',
		'label'			=> esc_html__( 'Enable Social Share', 'alx-extensions' ),
		'section'		=> 'alx_extensions_social',
		'default'		=> 'on',
	) );
	
	Kirki::add_field( 'twitter_username', array(
		'type'			=> 'text',
		'settings'		=> 'twitter-username',
		'label'			=> esc_html__( 'Twitter Username', 'alx-extensions' ),
		'description'	=> esc_html__( 'Your @username will be added to share-tweets of your posts (optional)', 'alx-extensions' ),
		'section'		=> 'alx_extensions_social',
		'default'		=> '',
	) ); 

	Kirki::add_section( 'alx_extensions_upscale', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Image Upscale', 'alx-extensions' ),
		'panel'       => 'alx_extensions_panel',
	) );

	Kirki::add_field( 'enable_image_upscale', array(
		'type'			=> 'switch',
		'settings'		=> 'enable-image-upscale',
		'label'			=> esc_html__( 'Enable Image Upscale', 'alx-extensions' ),
		'section'		=> 'alx_extensions_upscale',
		'default'		=> 'on',
	) );

	Kirki::add_section( 'alx_extensions_custom_sidebars', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Custom Sidebars', 'alx-extensions' ),
		'panel'       => 'alx_extensions_panel',
	) );

	// Sidebars: Create Sidebars
	Kirki::add_field( 'alx_sidebar', array(
		'type'			=> 'repeater',
		'label'			=> esc_html__( 'Create Sidebars', 'alx-extensions' ),
		'description'	=> esc_html__( 'You must save and refresh the page to see your new sidebars.', 'alx-extensions' ),
		'tooltip'		=> esc_html__( 'Make sure that you save and refresh the page if you can not see the sidebars you have created.', 'alx-extensions' ),
		'section'		=> 'alx_extensions_custom_sidebars',
		'row_label'		=> array(
			'type'	=> 'text',
			'value'	=> esc_html__('sidebar', 'alx-extensions' ),
		),
		'settings'		=> 'sidebar-areas',
		'default'		=> '',
		'fields'		=> array(
			'title'	=> array(
				'type'        => 'text',
				'label'       => esc_html__( 'Sidebar Title', 'alx-extensions' ),
				'description' => esc_html__( 'The widget box title', 'alx-extensions' ),
				'default'     => '',
			),
			'id'	=> array(
				'type'        => 'text',
				'label'       => esc_html__( 'Sidebar ID', 'alx-extensions' ),
				'description' => esc_html__( 'This ID must be unique', 'alx-extensions' ),
				'default'     => 'sidebar-',
			),
		)
	) );
}
