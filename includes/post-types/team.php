<?php
/**************************************************************************
 * Create Team Custom Post Type
 **************************************************************************/

if (!class_exists('BG_Team')):
	class BG_Team {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		*/
		public function __construct() {
			
			add_action( 'init', array( $this , '_build_post_type' ));
			
			add_action( 'init', array( $this , '_build_taxonomies') , 0 );
			
			add_filter( 'postbox_classes_bg_team_bg_team_meta_boxes', array( $this,'_add_metabox_classes' ) );
			
			add_action('do_meta_boxes', array( $this , '_change_meta_boxes' ));

			add_filter('manage_bg_team_posts_columns' , array( $this , '_add_post_type_column' ));
			
			add_action( 'manage_bg_team_posts_custom_column' , array( $this , '_manage_post_type_column' ), 10, 2 );
			
		}

		function _build_post_type() {
			$custom_name = get_option('bg_team_name_option');
			$name = (!empty($custom_name)) ? $custom_name : _x( 'Bears Team', 'Post type name', 'bears-grid' );
			
			$custom_slug = get_option('bg_team_slug_option');
			$slug = (!empty($custom_slug)) ? $custom_slug : 'bg-team';
			
			/** post type name filters **/
			$post_names = apply_filters( 'bg_team_post_type_name_filters',
				array(
					'singular' => _x( 'Team', 'Post type general name', 'bears-grid' ),
					'plural'   => _x( 'Teams', 'Post type plural name', 'bears-grid' ),
					'name'   => $name,
				)
			);

			/** icon filters **/
			$menu_icon = apply_filters( 'bg_team_menu_icon_filters','dashicons-groups');

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

			register_post_type( 'bg_team', $args );
		}
		
		function _build_taxonomies() {
			register_taxonomy('bg_team_position', 'bg_team', 
				array(
					'labels' => array(
						'name'              => __('Position','bears-grid'),
						'add_new_item'      => __('Add Position','bears-grid'),
						'new_item_name'     => __('New Position','bears-grid'),
						'search_items'      => __( 'Search Position', 'bears-grid' )
					),
					'hierarchical'  => true,
					'query_var'     => true,
					'rewrite'       => array( 'slug' => 'team-position' )
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
			remove_meta_box( 'postimagediv', 'bg_team', 'side' );
			
			add_meta_box( 'postimagediv', __( 'Avatar', 'bears-grid' ), 'post_thumbnail_meta_box', 'bg_team', 'side' );
		}
		
		/*
		 * Add custom column to manage page
		 */
		function _add_post_type_column( $columns ) {
			unset( $columns['date'] );
			unset( $columns['title'] );

			$columns['image'] = __( 'Avatar', 'bears-grid' );
			$columns['title'] = __( 'Title', 'bears-grid' );
			$columns['position'] = __( 'Position', 'bears-grid' );
			$columns['date'] = __( 'Date', 'bears-grid' );

			return $columns;
		}

		static function _manage_post_type_column( $column, $post_id  ) {

			switch ( $column ) {
				case 'image' :
					echo get_the_post_thumbnail( $post_id, array(100, 100) );
					break;
				
				case 'position' :
					 $terms = get_the_term_list( $post_id , 'bg_team_position' , '' , ', ' , '' );
						_e(( is_string( $terms ) ) ? $terms : '-' );
						
					break;

			}
		}
	}
	
	$bg_team = new BG_Team();
endif;
