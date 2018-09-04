<?php

function alx_ext_post_formats_meta_box( $meta_boxes ) {

	/* do not show */
	$prefix = '_';

	/*  Format: audio
	/* ------------------------------------ */
	$meta_boxes[] = array(
		'id' => 'format-audio',
		'title' => esc_html__( 'Format: Audio', 'alx-extensions' ),
		'post_types' => array( 'post' ),
		'context' => 'advanced',
		'priority' => 'high',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => $prefix . 'audio_url',
				'type' => 'text',
				'name' => esc_html__( 'Audio URL', 'alx-extensions' ),
			),
		),
	);

	/*  Format: video
	/* ------------------------------------ */
	$meta_boxes[] = array(
		'id' => 'format-video',
		'title' => esc_html__( 'Format: Video', 'alx-extensions' ),
		'post_types' => array( 'post' ),
		'context' => 'advanced',
		'priority' => 'high',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => $prefix . 'video_url',
				'type' => 'text',
				'name' => esc_html__( 'Video URL', 'alx-extensions' ),
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'alx_ext_post_formats_meta_box', 11 );
