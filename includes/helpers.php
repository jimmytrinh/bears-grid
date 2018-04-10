<?php

if(! class_exists('BG_Helpers')) :
	class BG_Helpers {
		
		static function vc_before_init_actions_func() {
			$path = BG_INC_PATH . 'vc-elements/';

			$elements = array(
				'portfolio',
				'team',
				'projects',
				'gallery',
			);

			foreach($elements as $element) :
			
				$dir = $path . $element . '/' . $element . '.php';
				
				if(file_exists($dir)) require $dir;
				
			endforeach;
		}
		
		static function bg_add_image_size_func() {
			add_image_size('bg-image-large', 1200, 900, true);
			add_image_size('bg-image-medium', 800, 600, true);
			add_image_size('bg-image-small', 300, 200, true);
			
			add_image_size('bg-image-square-medium', 300, 300, true); // 1:1
			add_image_size('bg-image-square-small', 150, 150, true); // 1:1
		}
		
		static function bg_ajax_get_uploaded_data() {
			$files = $_POST['files_select'];
			$type = $_POST['type'];
			
			$html = "";
			
			if($files != ""){
				$files = explode(',',  $files);
				$count_files = count($files);
				$html = call_user_func('_get_uploaded_'.$type, $files);
			}
			
			echo $html;
			die();
		}
		
		static function bg_ajax_render_addmore_item() {
			extract($_POST['params']);
			
			$html = call_user_func('_render_'.$field.'_item', $id, $number);
			
			echo $html;
			die();
		}
		
		static function bg_ajax_get_data() {
			extract($_POST['atts']);
			$light_box = ($light_box == 'true') ? true : false;
			
			$offset = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
			
			$datas = array();
			
			ob_start();
				if( $post_type == 'bg_instagram' ) {
					$instagram = new InstagramAPI();
					$token = get_option( 'bg_instagram_access_token_option');
					
					$obj = new stdClass();
					$obj->pagination = new stdClass();
					$obj->pagination->next_max_id = $_POST['nextid'];
					$obj->pagination->next_url = $_POST['nexturl'];
					
					$medias = $instagram->pagination($token, $obj, $number);
					
					foreach( $medias->data as $media ) {
						$data = array();
							
						$ista_id = $media->id;
				
						$img = $media->images->standard_resolution->url;
						$link = $media->link;
						$like = $media->likes->count;
						$comment = $media->comments->count;
						
						$comments = $instagram->getMediaComments($token, $ista_id);
						
						$data_comments = array();
						$k  = 0;
						if( $media->caption != '' ){
							$data_comments[$k]['username'] = $media->caption->from->username;
							$data_comments[$k]['text'] = $media->caption->text;
							$k++;
						}
						foreach( $comments as $_comment ) {
							$data_comments[$k]['username'] = $_comment->from->username;
							$data_comments[$k]['text'] = $_comment->text;
							$k++;
						}
						
						$data['id'] = $ista_id;
						$data['title'] = '';
						$data['img'] = $img;
						$data['class'] = $class;
						$data['style'] = 'padding-bottom: ' . $_space . '; width: ' . $width;
						$data['content'] = '';
						$data['permalink'] = $link;
						$data['like'] = $like;
						$data['comment'] = $comment;
						$data['data_popup'] = array(
							'username' => $media->user->username,
							'avatar' => $media->user->profile_picture,
							'link' => $link,
							'like' => $like,
							'comment' => $comment,
							'img' => $img,
							'comments' => $data_comments,
						);
						
						$datas[] = $data;
					}
					if( isset($medias->pagination->next_max_id) ){
						$_more['nextid'] = $medias->pagination->next_max_id;
						$_more['nexturl'] = $medias->pagination->next_url;
						$_more = json_encode($_more);
					} else {
						$_more = 0;
					}
					
					include BG_INC_PATH . 'shortcodes/layout/' . $type . '.php'; 
					
				} else {
					$args = array(
						'post_type' 		=> $post_type,
						'posts_per_page' 	=> $number,
						'offset' 	=> $offset,
					);
					
					if(isset($_POST['cat_id']) && $_POST['cat_id'] != '*') {
						$args['tax_query'] = array(
							array(
								'taxonomy' => $cat,
								'field'    => 'term_id',
								'terms'    => $_POST['cat_id'],
							),
						);
					}
					
					$query = new WP_Query($args);
					
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : 
							$query->the_post();
							$data = array();
							
							$img = get_the_post_thumbnail_url(get_the_ID(), 'bg-image-large');
							
							
							$data['id'] = get_the_ID();
							$data['title'] = get_the_title();
							$data['img'] = $img;
							$data['class'] = $class;
							$data['style'] = 'padding-bottom: ' . $space . '; width: ' . $width;
							$data['content'] = get_the_excerpt();
							$data['permalink'] = get_post_permalink();
							
							$datas[] = $data;
							
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						
						$_more = ($query->post_count < $number) ? 0 : 1;
						
						include BG_INC_PATH . 'shortcodes/layout/' . $type . '.php'; 

					endif;
				}

			$html = ob_get_contents();
			ob_clean();
			ob_end_flush();
			
			$data = array(
				'html' => $html,
				'more' => $_more
			);
			echo json_encode($data);
			die();
		}
		
		/*
		 * Change column width
		 */
		static function bg_change_column_width_func() {
			
			ob_start();
			?>
			<style type="text/css">
				.column-image { 
					width:150px !important; 
					overflow:hidden;
				}
			</style>
			<?php
			$style = ob_get_contents();
			ob_clean();
			ob_end_flush();
			
			echo $style;
			
		}
		
		/*
		 * Change excerpt length
		 */
		static function bg_change_excerpt_length_func( $length ) {
			return 20;
		}
		
		static function bg_single_load_template_func($single_template) {
			global $post;
			
			$filepath = _get_file_path_by_post_type($post->post_type);
			if( file_exists( $filepath ) ) {
				return $filepath;
			}
			
			return $single_template;
		}
		
		static function _single_meta_box_action_func( $post_id, $post_type, $action, $tab = false ) {
			
			$filepath = BG_DIR_PATH . 'templates/' . $action . '-box.php'; 
			$filepath = apply_filters('_single_' . $action . '_box_layout_filter', $filepath);
			
			$data = array(
				'id' => $post_id,
				'post_type' => $post_type,
				'tab' => $tab
			);
			
			echo _render_view( $filepath, $data);
		}
		
	}
endif;