<?php
/*
Element Description: VC Posts Grid Resizable
*/

// Element Class
class vcProjectsMasonry extends WPBakeryShortCode {

    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_projects_masonry_mapping' ) );
        add_shortcode( 'vc_projects_masonry', array( $this, 'vc_projects_masonry_html' ) );
    }

    function get_support_post_types() {
      $post_types = array(
        __('Post (Default)', 'projects-masonry') => 'post',
        __('Image Gallery', 'projects-masonry') => 'image_gallery',
      );

      /* WooCommerce */
      if(class_exists('WooCommerce')) :
        $post_types[__('Products (WooCommerce)', 'projects-masonry')] = 'products';
      endif;

      /* give plugon */
      if (class_exists('Give')) :
        $post_types[__('Give Forms (Give Donations)', 'projects-masonry')] = 'give_forms';
      endif;

      return $post_types;
    }

    // Element Mapping
    public function vc_projects_masonry_mapping() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Map the block with vc_map()
        vc_map(
			array(
				'name' => __('Projects Masonry', 'projects-masonry'),
				'base' => 'vc_projects_masonry',
				'description' => __('', 'projects-masonry'),
				'category' => __('Bears', 'projects-masonry'),
				'icon' => PM_INC_URL . 'visual-composer/images/projects-masonry.png',
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => __('Sort', 'projects-masonry'),
						'param_name' => 'sort',
						'description' => __('Select sort type for data.', 'projects-masonry'),
						'value' => array(
						  __('Recent Post', 'projects-masonry') => 'recent',
						  __('Popular Post', 'projects-masonry') => 'popular',
						  __('Commented', 'projects-masonry') => 'commented',
						),
						'std' => 'recent',
						'group' => 'Source',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Category (ID)', 'projects-masonry'),
						'param_name' => 'cat',
						'value' => '',
						'description' => __('Enter category ID you\'d want to filter (Ex: 9,12,14)', 'projects-masonry'),
						'group' => 'Source',
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Total Items', 'projects-masonry' ),
						'param_name' => 'total_items',
						'description' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'projects-masonry' ),
						'value' => 10,
						'group' => 'Source',
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'projects-masonry' ),
						'param_name' => 'el_class',
						'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'projects-masonry' ),
						'group' => 'Source',
						'admin_label'   => true,
					),
              
					/* Grid Setings */
					array(
						'type' => 'el_id',
						'param_name' => 'grid_id',
						'settings' => array(
							'auto_generate' => true,
						),
						'heading' => __( 'Grid ID (auto generate)', 'projects-masonry' ),
						'description' => __( 'Enter grid ID.', 'projects-masonry' ),
						'group' => 'Grid Settings',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Columns', 'projects-masonry'),
						'param_name' => 'grid_col',
						'description' => __('Enter number items in row', 'projects-masonry'),
						'value' => 3,
						'group' => 'Grid Settings',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Gap', 'projects-masonry'),
						'param_name' => 'grid_gap',
						'description' => __('Enter number space for each item', 'projects-masonry'),
						'value' => 30,
						'group' => 'Grid Settings',
					),
					array(
						'type' => 'textfield',
						'heading' => __('celHeight', 'projects-masonry'),
						'param_name' => 'cel_height',
						'description' => __('Enter number celHeifgt for each item', 'projects-masonry'),
						'value' => 320,
						'group' => 'Grid Settings',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Columns In Tablet (Responsive)', 'projects-masonry'),
						'param_name' => 'col_in_tablet',
						'description' => __('Enter number items in row on table', 'projects-masonry'),
						'value' => 2,
						'group' => 'Grid Settings',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Columns In Mobi (Responsive)', 'projects-masonry'),
						'param_name' => 'col_in_mobi',
						'description' => __('Enter number items in row on mobi', 'projects-masonry'),
						'value' => 1,
						'group' => 'Grid Settings',
					),
					/* css editor */
					array(
						'type' => 'css_editor',
						'heading' => __( 'Css', 'projects-masonry' ),
						'param_name' => 'css',
						'group' => __( 'Design Options general', 'projects-masonry' ),
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

  		$css_class = apply_filters( 'vc_projects_masonry_filter_class', 'projects-masonry-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

  		return array(
  			'css_class' => trim( preg_replace( '/\s+/', ' ', $css_class ) ),
  			'styles' => $styles,
  		);
    }

    public function get_data($atts) {
		$post_type = $atts['post_type'];
		$result = null;
		$offset = isset($atts['offset']) ? $atts['offset'] : 0; 
		$args = array(
			'post_type' => $post_type,
            'sort' => $atts['sort'],
            'items' => $atts['total_items'],
            'date_format' => 'l, j, M',
            'category' => $atts['cat'],
            'offset' => $offset,
		);
		$result = pm_get_posts($args);
		
		return $result;
    }

    public function post_variable($post_id) {

		$variable = array(
			'{pid}' => $post_id,
			'{post_title}' => get_the_title($post_id),
			'{post_link}' => get_permalink($post_id),
			'{post_featured_image}' => PM_DIR_URL . '/assets/images/image-default-2.jpg',
			'{term_list}' => get_the_term_list($post_id, 'category', '<div class="post-term-list">', ',', '</div>'),
		);

		if ( has_post_thumbnail($post_id) ) {
			$variable['{post_featured_image}'] = get_the_post_thumbnail_url($post_id, 'full');
		}

      return $variable;
    }

    public function _template($item_data = array(), $atts) {
		$output = '';
		$variable = $this->post_variable($item_data['post_id']);
		
		$temp_arr = array(
			'<div class="background-image" style="background: url({post_featured_image}) center center / cover, #333;"></div>',
			/*'<div class="entry-content">',
				'{term_list}',
				'<a class="title-link" href="{post_link}" title="{post_title}">',
					'<h4 class="title">{post_title}</h4>',
				'</a>',
			'</div>',*/
			'<a class="readmore" href="{post_link}" title="{post_title}"><span class="ion-ios-arrow-right"></span></a>',
		);

		$output = str_replace(array_keys($variable), array_values($variable), implode('', $temp_arr));
		
		return $output;
    }

    // Element HTML
    public function vc_projects_masonry_html( $atts, $content ) {
		$atts['self'] = $this;
		$atts['content'] = $content;
		
		return pm_render_view(PM_INC_PATH . 'visual-composer/vc-elements/projects-masonry.php', array('atts' => $atts), true);
    }

} // End Element Class


// Element Class Init
new vcProjectsMasonry();
