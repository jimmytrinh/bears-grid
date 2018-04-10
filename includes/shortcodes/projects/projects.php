<?php
/**************************************************************************
 * Create Projects Shortcode
 **************************************************************************/

if (!class_exists('BG_Projects_Shortcode')) {
	class BG_Projects_Shortcode {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		*/
		public function __construct() {
			   add_shortcode( 'bg-projects', array($this, '_build_shortcode_func') );
		}

		public static function _build_shortcode_func($atts) {
			$atts = shortcode_atts( array(
				'el_id' 	=> '',
				'el_class' 	=> '',
				'css' 		=> '',
				'css_class'	=> '',
				'title' 	=> '',
				'id' 		=> '',
				'post_type'	=> 'bg_projects',
				'type' 		=> 'grid',
				'height' 		=> 200,
				'number' 	=> '9',
				'column' 	=> 4,
				'space'	 	=> 30,
				'tpl'		=> 'default',
				'hover'		=> 'default',
				'filter' 	=> true,
				'filter_style' 	=> 'default', 
				'filter_align' 	=> 'center', 
				'filter_margin' => '0 0 35px 0', 
				'more' 		=> true,
				'light_box' => false,
				'autoplay'	=> false,
				'dots'		=> true,
				'autoplayTimeout'	=> 2000,
				'autoplaySpeed'		=> 1000,
				'autoplayHoverPause' => true,
			), $atts );
			
			$filepath = BG_INC_PATH . 'shortcodes/shortcodes.php';
			$filepath = apply_filters('_bears_grid_projects_sc_layout', $filepath);
			
			return _render_view( $filepath, $atts, true );
		}
		
	}
	$bg_projects_shortcode = new BG_Projects_Shortcode();
}