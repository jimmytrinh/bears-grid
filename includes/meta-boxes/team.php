<?php
/**************************************************************************
 * Create Team Meta boxes
 **************************************************************************/

if (!class_exists('BG_Team_Metaboxes')):
	class BG_Team_Metaboxes {
		
		/**
		 * Constructor
		 *
		 * @since 1.0
		 *
		*/
		public function __construct() {
			
			add_action( 'add_meta_boxes', array( $this, '_build_meta_boxes' ) );
		
			add_action( 'save_post',  array( $this, '_save_meta_boxes' ) );
			
		}
		
		/**
		 * Register meta boxes
		 */
		function _build_meta_boxes(){
			add_meta_box('bg_team_meta_boxes', esc_html__('Team Meta', 'bears-grid'), array($this, '_build_meta_boxes_func'), 'bg_team', 'normal', 'high');
		}
		
		function _build_meta_boxes_func() {
			global $post;
			wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
			
			$tabs = array(
				'team_layout' => esc_html__('Layout Settings', 'bears-grid'),
				'team_meta' => esc_html__('Meta Fields', 'bears-grid'),
				'team_skills' => esc_html__('Skills', 'bears-grid'),
				'team_gallery' => esc_html__('Gallery', 'bears-grid'),
				'team_attachments' => esc_html__('Attachments', 'bears-grid'),
				'team_social' => esc_html__('Social', 'bears-grid'),
			);
			
			$atts = array('post_type' => 'bg_team', 'post_id' => $post->ID, 'tabs' => $tabs);
			
			$this->_build_html($atts);
			
		}
		
		function _save_meta_boxes( $post_id ) {
			// Bail if we're doing an auto save
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			// if our nonce isn't there, or we can't verify it, bail
			if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce'))
				return;
			
			// if our current user can't edit this post, bail
			if (!current_user_can('edit_post', $post_id))
				return;

			
			if (isset($_POST['bg_team_single_layout'])) {
				update_post_meta($post_id, 'bg_team_single_layout', $_POST['bg_team_single_layout']);
			}
			
			if (isset($_POST['bg_team_skills'])) {
				update_post_meta($post_id, 'bg_team_skills', $_POST['bg_team_skills']);
			}
			
			if (isset($_POST['bg_team_gallery'])) {
				update_post_meta($post_id, 'bg_team_gallery', $_POST['bg_team_gallery']);
			}
			
			if (isset($_POST['bg_team_attachments'])) {
				update_post_meta($post_id, 'bg_team_attachments', $_POST['bg_team_attachments']);
			}
			
			if (isset($_POST['bg_team_social'])) {
				update_post_meta($post_id, 'bg_team_social', $_POST['bg_team_social']);
			}
			
			if (isset($_POST['bg_team_meta'])) {
				update_post_meta($post_id, 'bg_team_meta', $_POST['bg_team_meta']);
			}
		}
		
		function _build_html($atts) {
			extract($atts);
			
			$single_layout = get_post_meta($post_id, 'bg_team_single_layout', true);
			$attachments = get_post_meta($post_id, 'bg_team_attachments', true);
			$social = get_post_meta($post_id, 'bg_team_social', true);
			$meta = get_post_meta($post_id, 'bg_team_meta', true);
			$skills = get_post_meta($post_id, 'bg_team_skills', true);
			$gallery = get_post_meta($post_id, 'bg_team_gallery', true);

			ob_start();
			?>
			<div class="bg-meta-boxes-inner">
				<div class="bg-meta-boxes-tabs">
					<ul class="bg-tab-list">
						<?php
						$count = 1;
						foreach($tabs as $key => $tab) {
							?>
								<li class="bg-tab-item <?php echo ($count == 1) ? 'active' : ''; ?>">
									<a href="javascript:void(0);" data-tab="#<?php echo $key; ?>"><?php echo $tab; ?></a>
								</li>
							<?php
							$count++;
						}
						?>
						<div class="bg-clear"></div>
					</ul>
				</div>
				
				<div class="bg-meta-boxes-pane">	
					<?php 
					$count = 1;
					foreach($tabs as $key => $tab) {
						?>
						<div class="bg-tab-pane <?php echo ($count == 1) ? 'active' : ''; ?>" id="<?php echo $key;  ?>">
							<?php
							switch($key) {
								case 'team_layout' :
									?>
									<div class="bg-field-wrap">
										<label for="bg_team_single_layout" class="bg-label bg-col-2">Layout</label>
										<div class="bg-col-5">
											<select id="bg_team_single_layout" class="bg-field bg-select" name="bg_team_single_layout">
												<option value="image_left" <?php echo ($single_layout == 'image_left') ? 'selected' : ''; ?>>Image Left( Default )</option>
												<option value="image_top" <?php echo ($single_layout == 'image_top') ? 'selected' : ''; ?>>Image Top</option>
												<option value="image_right" <?php echo ($single_layout == 'image_right') ? 'selected' : ''; ?>>Image Right</option>
											</select>
											<p class="bg-desc">Select a layout of team</p>
										</div>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'team_meta' :
									$atts = array(
										'id' => 'bg_team_meta', 
										'field' => 'meta', 
										'items' => $meta,
										'desc' => 'Please configs meta field of member'
									);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/addmore.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
								
								case 'team_skills' :
									$atts = array(
										'id' => 'bg_team_skills', 
										'field' => 'skills', 
										'items' => $skills,
										'desc' => 'Please configs skills field of member'
									);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/addmore.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'team_gallery' :
									$atts = array('id' => 'bg_team_gallery', 'files' => $gallery);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/gallery.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'team_attachments' :
									$atts = array('id' => 'bg_team_attachments', 'files' => $attachments);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/attachments.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'team_social' :
									$atts = array(
										'id' => 'bg_team_social', 
										'field' => 'social', 
										'items' => $social,
										'desc' => 'Please configs social of member'
									);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/addmore.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								default:
									echo $tab;
							}
							?>
						</div>
						<?php
						$count++;
					}
					?>
				</div>
			</div>
			<?php
			$html = ob_get_contents();
			ob_clean();
			ob_end_flush();
			
			echo $html;
		}
		
		
	}
	
	$bg_team_metaboxes = new BG_Team_Metaboxes();
endif;


