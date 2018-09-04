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

/* load plugin textdomain */
function alx_ext_load_textdomain() {
	load_plugin_textdomain( 'alx-extensions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'alx_ext_load_textdomain' );

/* enqueue scripts */
function alx_ext_enqueue_scripts() {
	if ( is_singular() ) { wp_enqueue_script( 'alx-ext-sharrre', plugin_dir_url( __FILE__ ) . 'js/jquery.sharrre.min.js', array( 'jquery' ),'', true ); }
}
add_action( 'wp_enqueue_scripts', 'alx_ext_enqueue_scripts' );

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

add_filter( 'image_resize_dimensions', 'alx_ext_thumbnail_upscale', 10, 6 );

/* load template */
function alx_ext_sharrre_actions() {
	add_action( 'alx_ext_sharrre', 'alx_ext_sharrre_template' );
}
add_action( 'plugins_loaded', 'alx_ext_sharrre_actions' );

/* template */
function alx_ext_sharrre_template() { ?>

	<div class="sharrre-container group">
		<span><?php esc_html_e('Share','alx-extensions'); ?></span>
		<div id="twitter" data-url="<?php echo the_permalink(); ?>" data-text="<?php echo the_title(); ?>" data-title="<?php esc_html_e('Tweet', 'alx-extensions'); ?>"></div>
		<div id="facebook" data-url="<?php echo the_permalink(); ?>" data-text="<?php echo the_title(); ?>" data-title="<?php esc_html_e('Like', 'alx-extensions'); ?>"></div>
		<div id="pinterest" data-url="<?php echo the_permalink(); ?>" data-text="<?php echo the_title(); ?>" data-title="<?php esc_html_e('Pin It', 'alx-extensions'); ?>"></div>
		<div id="linkedin" data-url="<?php echo the_permalink(); ?>" data-text="<?php echo the_title(); ?>" data-title="<?php esc_html_e('Share on LinkedIn', 'alx-extensions'); ?>"></div>
	</div><!--/.sharrre-container-->

	<script type="text/javascript">
		// Sharrre
		jQuery(document).ready(function(){
			jQuery('#twitter').sharrre({
				share: {
					twitter: true
				},
				template: '<a class="box group" href="#"><div class="count" href="#"><i class="fa fa-plus"></i></div><div class="share"><i class="fa fa-twitter"></i></div></a>',
				enableHover: false,
				enableTracking: true,
				buttons: { twitter: {via: '<?php echo esc_attr( get_theme_mod('twitter-username') ); ?>'}},
				click: function(api, options){
					api.simulateClick();
					api.openPopup('twitter');
				}
			});
			jQuery('#facebook').sharrre({
				share: {
					facebook: true
				},
				template: '<a class="box group" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-facebook-square"></i></div></a>',
				enableHover: false,
				enableTracking: true,
				buttons:{layout: 'box_count'},
				click: function(api, options){
					api.simulateClick();
					api.openPopup('facebook');
				}
			});
			jQuery('#pinterest').sharrre({
				share: {
					pinterest: true
				},
				template: '<a class="box group" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-pinterest"></i></div></a>',
				enableHover: false,
				enableTracking: true,
				buttons: {
				pinterest: {
					description: '<?php echo the_title(); ?>'<?php if( has_post_thumbnail() ){ ?>,media: '<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>'<?php } ?>
					}
				},
				click: function(api, options){
					api.simulateClick();
					api.openPopup('pinterest');
				}
			});
			jQuery('#linkedin').sharrre({
				share: {
					linkedin: true
				},
				template: '<a class="box group" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-linkedin-square"></i></div></a>',
				enableHover: false,
				enableTracking: true,
				buttons: {
				linkedin: {
					description: '<?php echo the_title(); ?>'<?php if( has_post_thumbnail() ){ ?>,media: '<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>'<?php } ?>
					}
				},
				click: function(api, options){
					api.simulateClick();
					api.openPopup('linkedin');
				}
			});

		});
	</script>
	<?php
}
