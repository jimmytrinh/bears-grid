<?php
/**************************************************************************
 * Settings
 **************************************************************************/
if (!class_exists('BG_Gallery')):
	class BG_Settings {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		 */
		public function __construct() {
			
			add_action('admin_menu', array( $this,'_settings_admin_menu'));
			
		}
		
		function _settings_admin_menu() {
			add_options_page( 'Bears Grid Settings', 'Bears Grid', 'manage_options', 'bg-settings', array($this, '_settings_admin_menu_func') );
		}

		function _settings_admin_menu_func() {
			// check user capabilities
			if (!current_user_can('manage_options')) {
				return;
			}

			// check if the user have submitted the settings
			// wordpress will add the "settings-updated" $_GET parameter to the url
			if (isset($_GET['settings-updated'])) {
				// add settings saved message with the class of "updated"
				add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'wporg'), 'updated');
			}

			// show error/update messages
			settings_errors('wporg_messages');
			
			?>
			<div class="wrap">
				<?php settings_fields( 'bears-grid-settings-group' ); ?>
				<?php do_settings_sections( 'bears-grid-settings-group' ); ?>
				<h1 style="display: none;"><?= esc_html(get_admin_page_title()); ?></h1>
				<div class="bg-settings-wrapper">
					<!--top menu -->
					<div class="bg-settings-header">
						<ul class="bg-tab-list">
							<li class="bg-tab-item <?php echo ( !isset($_GET['tab']) || $_GET['tab'] == 'general_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=general_tabs">
									<span class="dashicons dashicons-list-view"></span>General
								</a>
							</li>
							<li class="bg-tab-item <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'portfolio_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=portfolio_tabs">
									<span class="dashicons dashicons-portfolio"></span>Portfolio
								</a>
							</li>
							<li class="bg-tab-item <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'projects_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=projects_tabs">
									<span class="dashicons dashicons-index-card"></span>Projects
								</a>
							</li>
							<li class="bg-tab-item <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'team_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=team_tabs">
									<span class="dashicons dashicons-groups"></span>Team
								</a>
							</li>
							<li class="bg-tab-item <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'gallery_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=gallery_tabs">
									<span class="dashicons dashicons-format-gallery"></span>Gallery
								</a>
							</li>
							<li class="bg-tab-item <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'instagram_tabs' ) ? 'active' : ''; ?>">
								<a href="options-general.php?page=bg-settings&tab=instagram_tabs">
									<i class="fab fa-instagram"></i>Instagram
								</a>
							</li>
							<h1 class="bg-page-settings-title"><?= esc_html(get_admin_page_title()); ?></h1>
							
							<div class="bg-clear"></div>
						</ul>
					</div>
					<!-- /top menu-->
					<div class="bg-settings-container">
						<?php 
						if( !isset($_GET['tab']) || $_GET['tab'] == 'general_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/general.php', array(), true );
							
						} 
						
						if( isset($_GET['tab']) && $_GET['tab'] == 'portfolio_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/portfolio.php', array(), true );
							
						} 
						
						if( isset($_GET['tab']) && $_GET['tab'] == 'projects_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/projects.php', array(), true );
							
						} 
						
						if( isset($_GET['tab']) && $_GET['tab'] == 'team_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/team.php', array(), true );
							
						} 
						
						if( isset($_GET['tab']) && $_GET['tab'] == 'gallery_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/gallery.php', array(), true );
							
						} 
						
						if( isset($_GET['tab']) && $_GET['tab'] == 'instagram_tabs' ) { 
							
							echo _render_view( BG_INC_PATH . 'settings/instagram.php', array(), true );
							
						}
						
						?>
					</div>
				</div>
			</div>
			<?php
		}
	}

	$bg_settings = new BG_Settings();
endif;