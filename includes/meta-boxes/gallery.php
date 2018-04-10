<?php
/**************************************************************************
 * Create Gallery Meta boxes
 **************************************************************************/

if (!class_exists('BG_Gallery_Metaboxes')):
	class BG_Gallery_Metaboxes {
		
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
			add_meta_box('bg_gallery_meta_boxes', esc_html__('Gallery Meta', 'bears-grid'), array($this, '_build_meta_boxes_func'), 'bg_gallery', 'normal', 'high');
		}
		
		function _build_meta_boxes_func() {
			global $post;
			wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
			
			$tabs = array(
				'gallery_layout' => esc_html__('Layout Settings', 'bears-grid'),
				'gallery' => esc_html__('Gallery', 'bears-grid'),
			);
			
			$atts = array('post_type' => 'bg_gallery', 'post_id' => $post->ID, 'tabs' => $tabs);
			
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
			
			if (isset($_POST['bg_gallery_columns'])) {
				update_post_meta($post_id, 'bg_gallery_columns', $_POST['bg_gallery_columns']);
			}
			
			if (isset($_POST['bg_gallery_space'])) {
				update_post_meta($post_id, 'bg_gallery_space', $_POST['bg_gallery_space']);
			}
			
			if (isset($_POST['bg_gallery_data'])) {
				update_post_meta($post_id, 'bg_gallery_data', $_POST['bg_gallery_data']);
			}
			
		}
		
		function _build_html($atts) {
			extract($atts);
			
			$gallery_columns = get_post_meta($post_id, 'bg_gallery_columns', true);
			$gallery_space = get_post_meta($post_id, 'bg_gallery_space', true);
			$gallery = get_post_meta($post_id, 'bg_gallery_data', true);

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
								case 'gallery_layout' :
									?>
									<div class="bg-field-wrap">
										<label for="bg_gallery_columns" class="bg-label bg-col-2">Select Gallery Columns</label>
										<div class="bg-col-5">
											<select id="bg_gallery_columns" class="bg-field bg-select" name="bg_gallery_columns">
												<option value="bg-col-6" <?php echo ($gallery_columns == 'bg-col-6') ? 'selected' : ''; ?>>2 Column</option>
												<option value="bg-col-4" <?php echo ($gallery_columns == 'bg-col-4') ? 'selected' : ''; ?>>3 Column</option>
												<option value="bg-col-3" <?php echo ($gallery_columns == 'bg-col-3') ? 'selected' : ''; ?>>4 Column</option>
												<option value="bg-col-2" <?php echo ($gallery_columns == 'bg-col-2') ? 'selected' : ''; ?>>6 Column</option>
											</select>
											<p class="bg-desc">Select columns of gallery</p> 
										</div>
									</div>
									<div class="bg-field-wrap">
										<label for="bg_gallery_space" class="bg-label bg-col-2">Gallery Space</label>
										<div class="bg-col-5">
											<input id="bg_gallery_space" class="bg-field bg-input" name="bg_gallery_space" value="<?php echo (isset($gallery_space) && $gallery_space != '') ? $gallery_space : '30'; ?>" />
											<p class="bg-desc">Please, enter space of gallery.</p> 
										</div>
									</div>
									<div class="bg-clear"></div>
									<?php
									break;
										
								case 'gallery' :
									$atts = array('id' => 'bg_gallery_data', 'files' => $gallery);
									?>
									<div class="bg-field-wrap">
										<?php
										echo _render_view(BG_INC_PATH . 'fields/gallery.php', array('atts' => $atts), true);
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
	
	$bg_gallery_metaboxes = new BG_Gallery_Metaboxes();
endif;