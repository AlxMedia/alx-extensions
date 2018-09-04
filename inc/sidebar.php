<?php

add_action( 'after_setup_theme', 'alx_ext_custom_sidebars', 11 );

function alx_ext_custom_sidebars() {
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}

	// Sidebars: Create Sidebars
	Kirki::add_field( 'alx_theme', array(
		'type'			=> 'repeater',
		'label'			=> esc_html__( 'Create Sidebars', 'alx-extensions' ),
		'description'	=> esc_html__( 'You must save and refresh the page to see your new sidebars.', 'alx-extensions' ),
		'tooltip'		=> esc_html__( 'Make sure that you save and refresh the page if you can not see the sidebars you have created.', 'alx-extensions' ),
		'section'		=> 'sidebars',
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
