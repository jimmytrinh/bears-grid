<?php
class BGVC_Projects_Element extends WPBakeryShortCode {
    private $base_name = 'bgvc_projects_element';
    function __construct () {
        $this->settings['base'] = $this->base_name;
        add_action( 'init', array( $this, 'vc_mapping' ) );
        add_shortcode( 'bgvc_projects_element', array( $this, 'vc_output' ) );
    }
    /**
     * @since 1.0.0
     */
    public function vc_mapping () {
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
        vc_map(
        array(
            'name' => __('Projects Element', 'bears-grid'),
            'base' => $this->base_name,
            'description' => __('Projects Element.', 'bears-grid'),
            'category' => __('Bears', 'bears-grid'),
            'icon' => BG_INC_URL . '/vc-elements/projects/icon.png',
            'params' => array(
                array(
                    'type' => 'el_id',
                    'heading' => __( 'Element ID', 'bears-grid' ),
                    'param_name' => 'el_id',
                    'description' => __( 'Enter element ID .', 'bears-grid' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'bears-grid' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'bears-grid' ),
                ),
				
				/* layout */
                array(
                    'type' => 'dropdown',
                    'heading' => __('Layout', 'bears-grid'),
                    'param_name' => 'type',
                    'value' => array(
                        __('Grid (default)', 'bears-grid') => 'grid',
                        __('Masonry', 'bears-grid') => 'masonry',
                        __('Carousel', 'bears-grid') => 'carousel',
                    ),
                    'std' => 'grid',
                    'description' => sprintf(
                        '%1$s', 
                        __('Choose a layout.', 'bears-grid')
                    ),
                    'group' => 'Layout',
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __( 'Height', 'bears-grid' ),
                    'param_name' => 'height',
                    'std' => '200',
                    'description' => __( 'Setting height of item. Ex: 200', 'bears-grid' ),
					'group' => 'Layout'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __( 'Number', 'bears-grid' ),
                    'param_name' => 'number',
					'std' => '9',
                    'description' => __( 'Setting number item appear. Ex: 9', 'bears-grid' ),
					'group' => 'Layout'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __( 'Column', 'bears-grid' ),
                    'param_name' => 'column',
					'std' => '4',
                    'description' => __( 'Setting number item appear in one row. Ex: 4', 'bears-grid' ),
					'group' => 'Layout'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __( 'Space', 'bears-grid' ),
                    'param_name' => 'space',
					'std' => '30',
                    'description' => __( 'Setting space between item. Ex: 30', 'bears-grid' ),
					'group' => 'Layout'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Templates', 'bears-grid'),
                    'param_name' => 'tpl',
                    'value' => array(
                        __('Default', 'bears-grid') => 'default',
                        __('Templates 1', 'bears-grid') => 'tpl1',
                    ),
                    'std' => 'default',
                    'description' => __('Setting template for item.', 'bears-grid'),
                    'group' => 'Layout'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Hover', 'bears-grid'),
                    'param_name' => 'hover',
                    'value' => array(
                        __('Default', 'bears-grid') => 'default',
                        __('Lily', 'bears-grid') => 'lily',
                        __('Layla', 'bears-grid') => 'layla',
                        __('Milo', 'bears-grid') => 'milo',
                        __('Bubba', 'bears-grid') => 'bubba',
                        __('Bears 1', 'bears-grid') => 'bears1',
                    ),
                    'std' => 'default',
                    'description' => __('Setting hover effect for item.', 'bears-grid'),
                    'group' => 'Layout'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Light Box', 'bears-grid'),
                    'param_name' => 'light_box',
                    'value' => array(
                        __('Yes', 'bears-grid') => 'true',
                        __('No (default)', 'bears-grid') => 'false',
                    ),
                    'std' => 'false',
                    'description' => __('Use light box or not?.', 'bears-grid'),
                    'group' => 'Layout'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Load More', 'bears-grid'),
                    'param_name' => 'more',
                    'value' => array(
                        __('Yes (default)', 'bears-grid') => 'true',
                        __('No', 'bears-grid') => 'false',
                    ),
                    'std' => 'true',
                    'description' => __('Display load more or not?.', 'bears-grid'),
                    'group' => 'Layout'
                ),
				/* Filter */
				array(
                    'type' => 'dropdown',
                    'heading' => __('Filter', 'bears-grid'),
                    'param_name' => 'filter',
                    'value' => array(
                        __('Yes (default)', 'bears-grid') => 'true',
                        __('No', 'bears-grid') => 'false',
                    ),
                    'std' => 'true',
                    'description' => __('Display filter or not?.', 'bears-grid'),
                    'group' => 'Filter'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Filter Layout', 'bears-grid'),
                    'param_name' => 'filter_style',
                    'value' => array(
                        __('Default', 'bears-grid') => 'default',
                        __('Style 1', 'bears-grid') => 'style1',
                        __('Style 2', 'bears-grid') => 'style2',
                    ),
                    'std' => 'default',
                    'description' => __('Setting layout for filter.', 'bears-grid'),
                    'group' => 'Filter'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Filter Align', 'bears-grid'),
                    'param_name' => 'filter_align',
                    'value' => array(
                        __('Left', 'bears-grid') => 'left',
                        __('Center (default)', 'bears-grid') => 'center',
                        __('Right', 'bears-grid') => 'right',
                    ),
                    'std' => 'center',
                    'description' => __('Setting align for filter.', 'bears-grid'),
                    'group' => 'Filter'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __( 'Filter Margin', 'bears-grid' ),
                    'param_name' => 'filter_margin', 
					'std' => '0 0 35px 0',
                    'description' => __( 'Setting margin (top, right, bottom, left) for filter. Ex: 10px 10px 10px 10px', 'bears-grid' ),
					'group' => 'Filter'
                ),
				/* Carousel */
				array(
                    'type' => 'dropdown',
                    'heading' => __('Autoplay', 'bears-grid'),
                    'param_name' => 'autoplay',
                    'value' => array(
                        __('Yes', 'bears-grid') => 'true',
                        __('No (default)', 'bears-grid') => 'false',
                    ),
                    'std' => 'false',
					'dependency' => array(
						'element' => 'type',
						'value' => 'carousel',
					),
                    'description' => __('Carousel autoplay.', 'bears-grid'),
                    'group' => 'Carousel'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Dots', 'bears-grid'),
                    'param_name' => 'dots',
                    'value' => array(
                        __('Yes (default)', 'bears-grid') => 'true',
                        __('No', 'bears-grid') => 'false',
                    ),
                    'std' => 'true',
					'dependency' => array(
						'element' => 'type',
						'value' => 'carousel',
					),
                    'description' => __('Show dots.', 'bears-grid'),
                    'group' => 'Carousel'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __('Autoplay Timeout', 'bears-grid'),
                    'param_name' => 'autoplayTimeout',
					'std' => '2000',
					'dependency' => array(
						'element' => 'type',
						'value' => 'carousel',
					),
                    'description' => __('Carousel autoplay interval timeout. Ex: 2000', 'bears-grid'),
                    'group' => 'Carousel'
                ),
				array(
                    'type' => 'textfield',
                    'heading' => __('Autoplay Speed', 'bears-grid'),
                    'param_name' => 'autoplaySpeed',
					'std' => '1000',
					'dependency' => array(
						'element' => 'type',
						'value' => 'carousel',
					),
                    'description' => __('Carousel autoplay speed. Ex: 1000', 'bears-grid'),
                    'group' => 'Carousel'
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => __('Autoplay Hover Pause', 'bears-grid'),
                    'param_name' => 'autoplayHoverPause',
                    'value' => array(
                        __('Yes (default)', 'bears-grid') => 'true',
                        __('No', 'bears-grid') => 'false',
                    ),
                    'std' => 'true',
					'dependency' => array(
						'element' => 'type',
						'value' => 'carousel',
					),
                    'description' => __('Pause on mouse hover.', 'bears-grid'),
                    'group' => 'Carousel'
                ),
                /* css editor */
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'Css', 'bears-grid' ),
                    'param_name' => 'css',
                    'group' => __( 'Design Options general', 'bears-grid' ),
                ),
            ),
        )
        );
    }
    /**
     * Parses google_fonts_data and font_container_data to get needed css styles to markup
     *
     * @param $el_class
     * @param $css
     * @param $atts
     *
     * @since 1.0
     * @return array
     */
    public function getStyles($el_class, $css, $atts) {
        $styles = array();
        /**
         * Filter 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' to change bevc_carousel_container class
         *
         * @param string  - filter_name
         * @param string  - element_class
         * @param string  - shortcode_name
         * @param array   - shortcode_attributes
         *
         * @since 4.3
         */
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        return  trim( preg_replace( '/\s+/', ' ', $css_class ) );
    }
    /**
     * @since 1.0.0
     */
    public function vc_output ( $atts, $content ) {
		$atts = shortcode_atts(array(
			'el_id'     		=> '',
			'el_class'          => '',
			'css'          		=> '',
			'title'             => '',
			'id'             	=> '',
			'post_type'			=> 'bg_projects',
			'type' 				=> 'grid',
			'height' 			=> 200,
			'number' 			=> '9',
			'column' 			=> 4,
			'space'	 			=> 30,
			'tpl'				=> 'default',
			'hover'				=> 'default',
			'filter' 			=> true,
			'filter_style' 		=> 'default', 
			'filter_align' 		=> 'center', 
			'filter_margin' 	=> '0 0 35px 0', 
			'more' 				=> true,
			'light_box' 		=> false,
			'autoplay'			=> false,
			'dots'				=> true,
			'autoplayTimeout'	=> 2000,
			'autoplaySpeed'		=> 1000,
			'autoplayHoverPause' => true,
		), $atts);
		
		$atts['css_class'] = $this->getStyles( $atts['el_class'], $atts['css'], $atts );
		
        $filepath = BG_INC_PATH . 'shortcodes/shortcodes.php';
		$filepath = apply_filters('_bears_grid_projects_element_layout', $filepath);
		
		return _render_view( $filepath, $atts, true );
    }
}
new BGVC_Projects_Element();