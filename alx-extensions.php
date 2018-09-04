<?php
/*
Plugin Name: Alx Extensions
Plugin URI: http://wordpress.org/plugins/alx-extensions/
Description: Adds social share links to articles
Version: 1.0.1
Author: Alexander Agnarson
Author URI: http://alxmedia.se
Text Domain: alx-extensions
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'ALX_EXTENSIONS_SLUG', 'alx-extensions' );
define( 'ALX_EXTENSIONS_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'ALX_EXTENSIONS_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'ALX_EXTENSIONS_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

require_once ALX_EXTENSIONS_DIR . '/inc/options.php';
require_once ALX_EXTENSIONS_DIR . '/inc/share.php';
require_once ALX_EXTENSIONS_DIR . '/inc/post-formats.php';

/* load plugin textdomain */
function alx_ext_load_textdomain() {
	load_plugin_textdomain( 'alx-extensions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'alx_ext_load_textdomain' );

/* enqueue scripts */
function alx_ext_enqueue_scripts() {
	if ( is_singular() ) {
		wp_enqueue_script( 'alx-ext-sharrre', ALX_EXTENSIONS_URL . '/js/jquery.sharrre.min.js', array( 'jquery' ), '1.0.1' );
	}
}

add_action( 'wp_enqueue_scripts', 'alx_ext_enqueue_scripts' );

/* enqueue admin scripts */
function alx_ext_enqueue_admin_scripts( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'alx-ext-post-formats', ALX_EXTENSIONS_URL . '/js/post-formats.js', array( 'jquery' ), '1.0.1' );
	}
}

add_action( 'admin_enqueue_scripts', 'alx_ext_enqueue_admin_scripts' );

/*  Upscale cropped thumbnails */
function alx_ext_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
	if ( !$crop ) return null; // let the wordpress default function handle this

	$aspect_ratio = $orig_w / $orig_h;
	$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

	$crop_w = round($new_w / $size_ratio);
	$crop_h = round($new_h / $size_ratio);

	$s_x = floor( ($orig_w - $crop_w) / 2 );
	$s_y = floor( ($orig_h - $crop_h) / 2 );

	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

$enable_image_upscale = get_theme_mod( 'enable_image_upscale', true );
if ( true === $enable_image_upscale ) {
	add_filter( 'image_resize_dimensions', 'alx_ext_thumbnail_upscale', 10, 6 );
}

