<?php
/*
Plugin Name: Bears Grid
Plugin URI:
Description: Bears Grid
Version: 1.0.1
Author: BearsThemes
Author URI:
*/

class BG_Functionality {
		/**
     * Constructor
     *
     * @since 1.0
     *
    */
    public function __construct() {
		$this->constants();
	    $this->inc();

		/* load text domain */
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		/* Enqueue backend scripts */
		add_action( 'admin_enqueue_scripts', array( $this,'admin_enqueue' ) );

		/* Enqueue frontend scripts */
		add_action( 'wp_enqueue_scripts', array( $this,'enqueue' ) );
		
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_links' ) );
		
		/* Activation plugin */
		register_activation_hook( __FILE__ , array($this, 'plugin_install'));
		register_deactivation_hook( __FILE__, array($this, 'plugin_remove'));

    }

	/**
     * Define constants
     *
     * @since 1.0
     *
  	*/
    protected function constants() {
			define('BG_DIR_PATH', plugin_dir_path(__FILE__));
			define('BG_DIR_URL', plugin_dir_url(__FILE__));

			define('BG_LIB_PATH', plugin_dir_path(__FILE__).'lib/');
			define('BG_LIB_URL', plugin_dir_url(__FILE__).'lib/');
			
			define('BG_INC_PATH', plugin_dir_path(__FILE__).'includes/');
			define('BG_INC_URL', plugin_dir_url(__FILE__).'includes/');

			define('BG_UNIT', 'px');
			
			define('BG_PROTOCOL', $this->site_protocol());
    }

	function site_protocol() {
		if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
			return 'https://';
		}
		return 'http://';
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'bears-grid', false, BG_DIR_PATH . '/languages/' );
	}
	
	function plugin_links ( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'options-general.php?page=bg-settings' ) . '">' . __( 'Settings', 'bears-grid' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}
	
	function inc() {
		/* Instagram API */
		require_once BG_INC_PATH . 'class/instagram-api.class.php';
		
		/* Functions */
		require_once( BG_INC_PATH . 'functions.php' );
		
		/* Helper */
		require_once( BG_INC_PATH . 'helpers.php' );

		/* Hook */
		require_once( BG_INC_PATH . 'hooks.php' );
		
		/* Include */
		if (!class_exists('BG_Include')) {
			require_once BG_INC_PATH . 'inc.php';
			new BG_Include();
		}
	}

	function admin_enqueue() {
		wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker-alpha', BG_DIR_URL . 'assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '', true );
		
		wp_enqueue_style ( 'bg-admin-nice-select-styles', BG_LIB_URL . 'nice-select/nice-select.css' ); 
		
		// font-awesome
		wp_enqueue_style ( 'bg-font-awesome', BG_LIB_URL . 'font-awesome/css/fontawesome.min.css' ); 
		wp_enqueue_style ( 'bg-font-awesome-all', BG_LIB_URL . 'font-awesome/css/fontawesome-all.min.css' );
		
		// admin styles
		wp_enqueue_style ( 'bg-admin-styles', BG_DIR_URL . 'assets/css/admin-styles.css' ); 
		
		wp_enqueue_script ( 'bg-admin-nice-select-scripts', BG_LIB_URL . 'nice-select/jquery.nice-select.min.js', array('jquery'), true );
		
		// admin scripts
		wp_enqueue_script ( 'bg-admin-scripts', BG_DIR_URL . 'assets/js/admin-scripts.js', array('jquery'), true );
		
		wp_localize_script('bg-admin-scripts', 'admin_ajax_call', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'fail_form_error' => esc_html__('Sorry you are an error in ajax, please contact the administrator of the website', 'bears-grid'),
		));
	}

	function enqueue() {
		//light-gallery
		wp_enqueue_style ( 'bg-light-gallery-style', BG_LIB_URL . 'light-gallery/css/lightgallery.min.css' );
		wp_enqueue_script ( 'bg-light-gallery-script', BG_LIB_URL . 'light-gallery/js/lightgallery-all.min.js', array('jquery'), true );
		
		// font-awesome
		wp_enqueue_style ( 'bg-font-awesome', BG_LIB_URL . 'font-awesome/css/fontawesome.min.css' ); 
		wp_enqueue_style ( 'bg-font-awesome-all', BG_LIB_URL . 'font-awesome/css/fontawesome-all.min.css' ); 
		
		// owl-carousel
		wp_enqueue_style ( 'bg-owl-carousel-style', BG_LIB_URL . 'owl-carousel/assets/owl.carousel.min.css' ); 
		wp_enqueue_script ( 'bg-owl-carousel-script', BG_LIB_URL . 'owl-carousel/owl.carousel.min.js', array('jquery'), true );
		
		// bg grid
		wp_enqueue_style ( 'bg-grids', BG_DIR_URL . 'assets/css/grids.css' ); 
		
		// styles
		wp_enqueue_style ( 'bg-styles', BG_DIR_URL . 'assets/css/styles.css' ); 
		wp_enqueue_style ( 'bg-styles-vu', BG_DIR_URL . 'assets/css/styles-vu.css' ); 
		
		// custom styles
		$custom_css = _custom_styles();
        wp_add_inline_style( 'bg-styles', $custom_css );
		
		// responsive
		wp_enqueue_style ( 'bg-responsive', BG_DIR_URL . 'assets/css/responsive.css' ); 
		
		// scripts
		wp_enqueue_script ( 'bg-isotope', BG_DIR_URL . 'assets/js/isotope.min.js', array('jquery'), true );
		
		wp_enqueue_script ( 'bg-scripts', BG_DIR_URL . 'assets/js/scripts.js', array('jquery', 'bg-isotope'), true );
		
		wp_localize_script('bg-scripts', 'ajax_call', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'fail_form_error' => esc_html__('Sorry you are an error in ajax, please contact the administrator of the website', 'bears-grid'),
		));
	}
	
	function plugin_install() {}
	
	function plugin_remove() {}

}

/**
 * Instantiate the Class
 *
 * @since     1.0
 * @global    object
 */
$bg_functionality = new BG_Functionality();
