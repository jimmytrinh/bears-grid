<?php
// check Visual Composer plugin active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	// Before VC Init
	add_action( 'vc_before_init', 'BG_Helpers::vc_before_init_actions_func' );
}

// Add image size support
add_action( 'init', 'BG_Helpers::bg_add_image_size_func' );

// Change column width
add_action( 'admin_head', 'BG_Helpers::bg_change_column_width_func' );

// Change excerpt length
add_filter( 'excerpt_length', 'BG_Helpers::bg_change_excerpt_length_func', 999 );

// Single template hook
add_filter( 'single_template', 'BG_Helpers::bg_single_load_template_func' );

add_action( '_single_meta_box_action', 'BG_Helpers::_single_meta_box_action_func', 10, 4 );

// Gallery field ajax
add_action( 'wp_ajax_bg_ajax_get_uploaded_data', 'BG_Helpers::bg_ajax_get_uploaded_data' );
add_action( 'wp_ajax_nopriv_bg_ajax_get_uploaded_data', 'BG_Helpers::bg_ajax_get_uploaded_data' );

// Addmore field ajax
add_action( 'wp_ajax_bg_ajax_render_addmore_item', 'BG_Helpers::bg_ajax_render_addmore_item' );
add_action( 'wp_ajax_nopriv_bg_ajax_render_addmore_item', 'BG_Helpers::bg_ajax_render_addmore_item' );

// Filter ajax
add_action( 'wp_ajax_bg_ajax_get_data', 'BG_Helpers::bg_ajax_get_data' );
add_action( 'wp_ajax_nopriv_bg_ajax_get_data', 'BG_Helpers::bg_ajax_get_data' );

?>