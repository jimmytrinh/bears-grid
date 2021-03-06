<?php
/**************************************************************************
 * Create Portfolio Meta boxes
 **************************************************************************/

if (!class_exists('BG_Portfolio_Metaboxes')):
	class BG_Portfolio_Metaboxes {
		
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
			add_meta_box('bg_portfolio_meta_boxes', esc_html__('Portfolio Meta', 'bears-grid'), array($this, '_build_meta_boxes_func'), 'bg_portfolio', 'normal', 'high');
		}
		
		function _build_meta_boxes_func() {
			global $post;
			wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
			
			$tabs = array(
				'portfolio_layout' => esc_html__('Layout Settings', 'bears-grid'),
				'portfolio_meta' => esc_html__('Meta Fields', 'bears-grid'),
				'portfolio_gallery' => esc_html__('Gallery', 'bears-grid'),
				'portfolio_social' => esc_html__('Social', 'bears-grid'),
			);
			
			$atts = array('post_type' => 'portfolio', 'post_id' => $post->ID, 'tabs' => $tabs);
			
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

			
			if (isset($_POST['bg_portfolio_single_layout'])) {
				update_post_meta($post_id, 'bg_portfolio_single_layout', $_POST['bg_portfolio_single_layout']);
			}
			
			if (isset($_POST['bg_portfolio_gallery_columns'])) {
				update_post_meta($post_id, 'bg_portfolio_gallery_columns', $_POST['bg_portfolio_gallery_columns']);
			}
			
			if (isset($_POST['bg_portfolio_gallery_space'])) {
				update_post_meta($post_id, 'bg_portfolio_gallery_space', $_POST['bg_portfolio_gallery_space']);
			}
			
			if (isset($_POST['bg_portfolio_gallery'])) {
				update_post_meta($post_id, 'bg_portfolio_gallery', $_POST['bg_portfolio_gallery']);
			}
			
			if (isset($_POST['bg_portfolio_social'])) {
				update_post_meta($post_id, 'bg_portfolio_social', $_POST['bg_portfolio_social']);
			}
			
			if (isset($_POST['bg_portfolio_meta'])) {
				update_post_meta($post_id, 'bg_portfolio_meta', $_POST['bg_portfolio_meta']);
			}
			
			if (isset($_POST['bg_portfolio_external_link'])) {
				update_post_meta($post_id, 'bg_portfolio_external_link', $_POST['bg_portfolio_external_link']);
			}
		}
		
		function _build_html($atts) {
			extract($atts);
			
			$single_layout = get_post_meta($post_id, 'bg_portfolio_single_layout', true);
			$gallery_columns = get_post_meta($post_id, 'bg_portfolio_gallery_columns', true);
			$gallery_space = get_post_meta($post_id, 'bg_portfolio_gallery_space', true);
			$gallery = get_post_meta($post_id, 'bg_portfolio_gallery', true);
			$social = get_post_meta($post_id, 'bg_portfolio_social', true);
			$meta = get_post_meta($post_id, 'bg_portfolio_meta', true);
			$external_link = get_post_meta($post_id, 'bg_portfolio_external_link', true);

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
								case 'portfolio_layout' :
									?>
									<div class="bg-field-wrap">
										<label for="bg_portfolio_single_layout" class="bg-label bg-col-2">Layout</label>
										<div class="bg-col-5">
											<select id="bg_portfolio_single_layout" class="bg-field bg-select" name="bg_portfolio_single_layout">
												<option value="image_left" <?php echo ($single_layout == 'image_left') ? 'selected' : ''; ?>>Image Left( Default )</option>
												<option value="image_top" <?php echo ($single_layout == 'image_top') ? 'selected' : ''; ?>>Image Top</option>
												<option value="image_right" <?php echo ($single_layout == 'image_right') ? 'selected' : ''; ?>>Image Right</option>
												<option value="image_bottom" <?php echo ($single_layout == 'image_bottom') ? 'selected' : ''; ?>>Image Bottom</option>
											</select>
											<p class="bg-desc">Select a layout of portfolio</p>
										</div>
									</div>
									<div class="bg-field-wrap">
										<label for="bg_portfolio_gallery_columns" class="bg-label bg-col-2">Select Gallery Columns</label>
										<div class="bg-col-5">
											<select id="bg_portfolio_gallery_columns" class="bg-field bg-select" name="bg_portfolio_gallery_columns">
												<option value="bg-col-12" <?php echo ($gallery_columns == 'bg-col-12') ? 'selected' : ''; ?>>1 Column</option>
												<option value="bg-col-6" <?php echo ($gallery_columns == 'bg-col-6') ? 'selected' : ''; ?>>2 Column</option>
												<option value="bg-col-4" <?php echo ($gallery_columns == 'bg-col-4') ? 'selected' : ''; ?>>3 Column</option>
												<option value="bg-col-3" <?php echo ($gallery_columns == 'bg-col-3') ? 'selected' : ''; ?>>4 Column</option>
											</select>
											<p class="bg-desc">Select gallery columns of portfolio</p> 
										</div>
									</div>
									<div class="bg-field-wrap">
										<label for="bg_portfolio_gallery_space" class="bg-label bg-col-2">Gallery Space</label>
										<div class="bg-col-5">
											<input id="bg_portfolio_gallery_space" class="bg-field bg-input" name="bg_portfolio_gallery_space" value="<?php echo (isset($gallery_space) && $gallery_space != '') ? $gallery_space : '30'; ?>" />
											<p class="bg-desc">Please, enter gallery space of project.</p> 
										</div>
									</div>
									<div class="bg-field-wrap">
										<label for="bg_portfolio_external_link" class="bg-label bg-col-2">External Link</label>
										<div class="bg-col-5">
											<input id="bg_portfolio_external_link" class="bg-field bg-input" name="bg_portfolio_external_link" value="<?php echo (isset($external_link) && $external_link != '') ? $external_link : ''; ?>" />
											<p class="bg-desc">Enter external link.</p> 
										</div>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'portfolio_meta' :
									$atts = array(
										'id' => 'bg_portfolio_meta', 
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
										
								case 'portfolio_gallery' :
									$atts = array('id' => 'bg_portfolio_gallery', 'files' => $gallery);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/gallery.php', array('atts' => $atts), true);
										?>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
									
								case 'portfolio_social' :
									$atts = array(
										'id' => 'bg_portfolio_social', 
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
	
	$bg_portfolio_metaboxes = new BG_Portfolio_Metaboxes();
endif;


