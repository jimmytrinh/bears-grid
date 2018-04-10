<?php

/**
 * Load plugin's files with check for installing it as a standalone plugin or
 * a module of a theme / plugin. If standalone plugin is already installed, it
 * will take higher priority.
 * @package Meta Box
 */

/**
 * Plugin include class.
 * @package
 */
class BG_Include {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->_autoload();
	}
	
	/**
	 * Autoload fields' classes.
	 * @param string $class Class name
	 */
	public function _autoload() {
		$files = array(
			'settings/settings',
		);
		
		if ( get_option('bg_portfolio_disable_option') != '1' ) {
			$files[] = 'post-types/portfolio';
			$files[] = 'meta-boxes/portfolio';
			$files[] = 'shortcodes/portfolio/portfolio';
		}
		
		if (get_option('bg_gallery_disable_option') != '1') {
			$files[] = 'post-types/gallery';
			$files[] = 'meta-boxes/gallery';
			$files[] = 'shortcodes/gallery/gallery';
		}
		
		if (get_option('bg_team_disable_option') != '1') {
			$files[] = 'post-types/team';
			$files[] = 'meta-boxes/team';
			$files[] = 'shortcodes/team/team';
		}
		
		if (get_option('bg_projects_disable_option') != '1') {
			$files[] = 'post-types/projects';
			$files[] = 'meta-boxes/projects';
			$files[] = 'shortcodes/projects/projects';
		}
		
		if (!empty(get_option( 'bg_instagram_access_token_option'))) {
			$files[] = 'shortcodes/instagram/instagram';
		}
		
		foreach ( $files as $file ) {
			require_once BG_INC_PATH . $file . '.php';
		}
	}

}
