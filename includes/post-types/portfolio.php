<?php
/**************************************************************************
 * Create Portfolio Custom Post Type
 **************************************************************************/

if (!class_exists('BG_Portfolio')):
	class BG_Portfolio {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		*/
		public function __construct() {
			
			add_action( 'init', array( $this , '_build_post_type' ) );
			
			add_action( 'init', array( $this , '_build_taxonomies') , 0 );

			add_filter( 'postbox_classes_bg_portfolio_bg_portfolio_meta_boxes', array( $this,'_add_metabox_classes' ) );
			
			add_action( 'do_meta_boxes', array( $this , '_change_meta_boxes' ) );

			add_filter( 'manage_bg_portfolio_posts_columns' , array( $this , '_add_post_type_column' ));
			
			add_action( 'manage_bg_portfolio_posts_custom_column' , array( $this , '_manage_post_type_column' ), 10, 2 );
			
		}

		function _build_post_type() {
			$custom_name = get_option('bg_portfolio_name_option');
			$name = (!empty($custom_name)) ? $custom_name : _x( 'Bears Portfolios', 'Post type name', 'bears-grid' );
			
			$custom_slug = get_option('bg_portfolio_slug_option');
			$slug = (!empty($custom_slug)) ? $custom_slug : 'bg-portfolio';
			
			/** post type name filters **/
			$post_names = apply_filters( 'bg_portfolio_post_type_name_filters',
				array(
					'singular' => _x( 'Portfolio', 'Post type general name', 'bears-grid' ),
					'plural'   => _x( 'Portfolios', 'Post type plural name', 'bears-grid' ),
					'name'   => $name,
				)
			);

			/** icon filters **/
			$menu_icon = apply_filters( 'bg_portfolio_menu_icon_filters','dashicons-portfolio');

			$labels = array(
				'name'                  => $post_names['plural'],
				'singular_name'         => $post_names['singular'],
				'menu_name'             => $post_names['name'],
				'name_admin_bar'        => $post_names['singular'],
				'add_new'               => __( 'Add New', 'bears-grid' ),
				'add_new_item'          => sprintf( __( 'Add New %s', 'bears-grid' ), $post_names['singular'] ),
				'new_item'              => sprintf( __( 'New %s', 'bears-grid' ), $post_names['singular'] ),
				'edit_item'             => sprintf( __( 'Edit %s', 'bears-grid' ), $post_names['singular'] ),
				'view_item'             => sprintf( __( 'View %s', 'bears-grid' ), $post_names['singular'] ),
				'all_items'             => sprintf( __( 'All %s', 'bears-grid' ), $post_names['plural'] ),
				'search_items'          => sprintf( __( 'Search %s', 'bears-grid' ), $post_names['plural'] ),
				'parent_item_colon'     => sprintf( __( 'Parent %s:', 'bears-grid' ), $post_names['plural'] ),
				'not_found'             => sprintf( __( 'No %s found.', 'bears-grid' ), $post_names['singular'] ),
				'not_found_in_trash'    => sprintf( __( 'No %s found in Trash.', 'bears-grid' ), $post_names['singular'] ),
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'has_archive'        => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $slug ),
				'menu_position'      => 13,
				'menu_icon'          => $menu_icon,
				'capability_type'    => 'post',
				'hierarchical'       => true,
				'can_export' 		 => true,
				'supports'			 => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt'),
			);

			register_post_type( 'bg_portfolio', $args );
		}
		
		function _build_taxonomies() {
			register_taxonomy('bg_portfolio_category', 'bg_portfolio', 
				array(
					'labels' => array(
						'name'              => __('Categories','bears-grid'),
						'add_new_item'      => __('Add Category','bears-grid'),
						'new_item_name'     => __('New Category','bears-grid'),
						'search_items'      => __( 'Search Category', 'bears-grid' )
					),
					'hierarchical'  => true,
					'query_var'     => true,
					'rewrite'       => array( 'slug' => 'portfolio-category' )
				)
			);
		}
		
		function _add_metabox_classes( $classes = array() ) {
			
			array_push( $classes,  sanitize_html_class( 'bg-meta-boxes-wrapper' ) );
			
			return $classes;
		}
		
		/*
		 * Change metabox
		 */
		function _change_meta_boxes() {
			remove_meta_box( 'postimagediv', 'bg_portfolio', 'side' );
			
			add_meta_box( 'postimagediv', __( 'Cover Image', 'bears-grid' ), 'post_thumbnail_meta_box', 'bg_portfolio', 'side' );
		}
		
		/*
		 * Add custom column to manage page
		 */
		function _add_post_type_column( $columns ) {
			unset( $columns['date'] );
			unset( $columns['title'] );

			$columns['image'] = __( 'Cover Image', 'bears-grid' );
			$columns['title'] = __( 'Title', 'bears-grid' );
			$columns['category'] = __( 'Portfolio Categories', 'bears-grid' );
			$columns['date'] = __( 'Date', 'bears-grid' );

			return $columns;
		}

		function _manage_post_type_column( $column, $post_id  ) {

			switch ( $column ) {
				case 'image' :
					echo get_the_post_thumbnail( $post_id, array(100, 100) );
					break;
					
				case 'category' :
					 $terms = get_the_term_list( $post_id , 'bg_portfolio_category' , '' , ', ' , '' );
						_e(( is_string( $terms ) ) ? $terms : '-' );
						
					break;

			}
		}
	}
	
	$bg_portfolio = new BG_Portfolio();
endif;
