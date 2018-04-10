<?php
/**************************************************************************
 * Create Portfolio Shortcode
 **************************************************************************/

if (!class_exists('BG_Portfolio_Shortcode')) {
	class BG_Portfolio_Shortcode {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		*/
		public function __construct() {
			   add_shortcode( 'bg-portfolio', array($this, '_build_shortcode_func') );
		}

		public static function _build_shortcode_func($atts) {
			$atts = shortcode_atts( array(
				'el_id' 	=> '',
				'el_class' 	=> '',
				'css' 		=> '',
				'css_class'	=> '',
				'title' 	=> '',
				'id' 		=> '',
				'post_type'	=> 'bg_portfolio',
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
			$filepath = apply_filters('_bears_grid_portfolio_sc_layout', $filepath);
			
			return _render_view( $filepath, $atts, true );
		}
		
	}
	$bg_portfolio_shortcode = new BG_Portfolio_Shortcode();
}
