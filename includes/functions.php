<?php 


if ( ! function_exists( '_render_view' ) ):
	
	function _render_view( $file_path, $view_variables = array(), $return = true ) {
		extract( $view_variables, EXTR_REFS );
		unset( $view_variables );

		if ( $return ) {
			ob_start();
			require $file_path;

			return ob_get_clean();
		} else {
			require $file_path;
		}
	}
	
endif;

if ( ! function_exists( '_get_time_diff' ) ):
	
	function _get_time_diff( $created_time ) {
        //date_default_timezone_set('Asia/Calcutta');
        //$str = strtotime($created_time);
        $str = strtotime($created_time);
        $today = strtotime(date('Y-m-d H:i:s'));

        // It returns the time difference in Seconds...
        $time_differnce = $today - $created_time;

        // To Calculate the time difference in Years...
        $years = 60*60*24*365;

        // To Calculate the time difference in Months...
        $months = 60*60*24*30;

        // To Calculate the time difference in Days...
        $days = 60*60*24;

        // To Calculate the time difference in Hours...
        $hours = 60*60;

        // To Calculate the time difference in Minutes...
        $minutes = 60;

        if(intval($time_differnce/$years) > 1)
        {
            return intval($time_differnce/$years)." years ago";
        }else if(intval($time_differnce/$years) > 0)
        {
            return intval($time_differnce/$years)." year ago";
        }else if(intval($time_differnce/$months) > 1)
        {
            return intval($time_differnce/$months)." months ago";
        }else if(intval(($time_differnce/$months)) > 0)
        {
            return intval(($time_differnce/$months))." month ago";
        }else if(intval(($time_differnce/$days)) > 1)
        {
            return intval(($time_differnce/$days))." days ago";
        }else if (intval(($time_differnce/$days)) > 0) 
        {
            return intval(($time_differnce/$days))." day ago";
        }else if (intval(($time_differnce/$hours)) > 1) 
        {
            return intval(($time_differnce/$hours))." hours ago";
        }else if (intval(($time_differnce/$hours)) > 0) 
        {
            return intval(($time_differnce/$hours))." hour ago";
        }else if (intval(($time_differnce/$minutes)) > 1) 
        {
            return intval(($time_differnce/$minutes))." minutes ago";
        }else if (intval(($time_differnce/$minutes)) > 0) 
        {
            return intval(($time_differnce/$minutes))." minute ago";
        }else if (intval(($time_differnce)) > 1) 
        {
            return intval(($time_differnce))." seconds ago";
        }else
        {
            return "few seconds ago";
        }
	}
	
endif;

if ( ! function_exists( '_custom_styles' ) ):
	
	function _custom_styles() {
		$portfolio_bg_color = (!empty(get_option( 'bg_portfolio_background_color_option'))) ? get_option( 'bg_portfolio_background_color_option') : 'rgba(0,0,0,0)';
		$portfolio_bg = (!empty(get_option( 'bg_portfolio_background_option'))) ? get_option( 'bg_portfolio_background_option') : $portfolio_bg_color;
		$portfolio_bg_hover_color = (!empty(get_option( 'bg_portfolio_background_hover_color_option'))) ? get_option( 'bg_portfolio_background_hover_color_option') : 'rgba(251, 43, 105, 0.6)';
		$portfolio_bg_hover = (!empty(get_option( 'bg_portfolio_background_hover_option'))) ? get_option( 'bg_portfolio_background_hover_option') : $portfolio_bg_hover_color;
		$portfolio_title_color = (!empty(get_option( 'bg_portfolio_title_color_option'))) ? get_option( 'bg_portfolio_title_color_option') : 'rgba(255, 255, 255, 1)';
		$portfolio_category_color = (!empty(get_option( 'bg_portfolio_category_color_option'))) ? get_option( 'bg_portfolio_category_color_option') : 'rgba(252, 244, 0, 1)';
		
		$projects_bg_color = (!empty(get_option( 'bg_projects_background_color_option'))) ? get_option( 'bg_projects_background_color_option') : 'rgba(0,0,0,0)';
		$projects_bg = (!empty(get_option( 'bg_projects_background_option'))) ? get_option( 'bg_projects_background_option') : $projects_bg_color;
		$projects_bg_hover_color = (!empty(get_option( 'bg_projects_background_hover_color_option'))) ? get_option( 'bg_projects_background_hover_color_option') : 'rgba(251, 43, 105, 0.6)';
		$projects_bg_hover = (!empty(get_option( 'bg_projects_background_hover_option'))) ? get_option( 'bg_projects_background_hover_option') : $projects_bg_hover_color;
		$projects_title_color = (!empty(get_option( 'bg_projects_title_color_option'))) ? get_option( 'bg_projects_title_color_option') : 'rgba(255, 255, 255, 1)';
		$projects_category_color = (!empty(get_option( 'bg_projects_category_color_option'))) ? get_option( 'bg_projects_category_color_option') : 'rgba(252, 244, 0, 1)';
		
		$gallery_bg_color = (!empty(get_option( 'bg_gallery_background_color_option'))) ? get_option( 'bg_gallery_background_color_option') : 'rgba(0,0,0,0)';
		$gallery_bg = (!empty(get_option( 'bg_gallery_background_option'))) ? get_option( 'bg_gallery_background_option') : $gallery_bg_color;
		$gallery_bg_hover_color = (!empty(get_option( 'bg_gallery_background_hover_color_option'))) ? get_option( 'bg_gallery_background_hover_color_option') : 'rgba(251, 43, 105, 0.6)';
		$gallery_bg_hover = (!empty(get_option( 'bg_gallery_background_hover_option'))) ? get_option( 'bg_gallery_background_hover_option') : $gallery_bg_hover_color;
		$gallery_icon_color = (!empty(get_option( 'bg_gallery_icon_color_option'))) ? get_option( 'bg_gallery_icon_color_option') : '#ffffff';
		
		$team_bg_color = (!empty(get_option( 'bg_team_background_color_option'))) ? get_option( 'bg_team_background_color_option') : 'rgba(0,0,0,0)';
		$team_bg = (!empty(get_option( 'bg_team_background_option'))) ? get_option( 'bg_team_background_option') : $team_bg_color;
		$team_bg_hover_color = (!empty(get_option( 'bg_team_background_hover_color_option'))) ? get_option( 'bg_team_background_hover_color_option') : 'rgba(251, 43, 105, 0.6)';
		$team_bg_hover = (!empty(get_option( 'bg_team_background_hover_option'))) ? get_option( 'bg_team_background_hover_option') : $team_bg_hover_color;
		$team_name_color = (!empty(get_option( 'bg_team_name_color_option'))) ? get_option( 'bg_team_name_color_option') : '#2b2b2b';
		$team_position_color = (!empty(get_option( 'bg_team_position_color_option'))) ? get_option( 'bg_team_position_color_option') : '#96122c';
		
		$instagram_bg_color = (!empty(get_option( 'bg_instagram_background_color_option'))) ? get_option( 'bg_instagram_background_color_option') : 'rgba(0,0,0,0)';
		$instagram_bg = (!empty(get_option( 'bg_instagram_background_option'))) ? get_option( 'bg_instagram_background_option') : $instagram_bg_color;
		$instagram_bg_hover_color = (!empty(get_option( 'bg_instagram_background_hover_color_option'))) ? get_option( 'bg_instagram_background_hover_color_option') : 'rgba(251, 43, 105, 0.6)';
		$instagram_bg_hover = (!empty(get_option( 'bg_instagram_background_hover_option'))) ? get_option( 'bg_instagram_background_hover_option') : $instagram_bg_hover_color;
		ob_start()
		?>
		/* general */
		.bg--wrapper .bg--item .info .zoom > * {
			fill: <?php echo $gallery_icon_color; ?>;
			color: <?php echo $gallery_icon_color; ?>;
			font-size: 25px;
		}
		
		/* portfolio */
		.bg--wrapper.bg-portfolio-wrapper .bg--item .bg-item-inner:before {
			background: <?php echo $portfolio_bg; ?>;
		}
		.bg--wrapper.bg-portfolio-wrapper .bg--item:hover .bg-item-inner:before {
			background: <?php echo $portfolio_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-portfolio-wrapper.bears1 .bg--item .info {
			background: <?php echo $portfolio_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-portfolio-wrapper.bears1 .bg--item:hover .bg-item-inner:before {
			background: transparent !important;
		}
		.bg--wrapper.bg-portfolio-wrapper .info .heading a {
			color: <?php echo $portfolio_title_color; ?>;
		}
		.bg--wrapper.bg-portfolio-wrapper .bg--item .description,
		.bg-wrapper.bg-portfolio-wrapper .bg--item .info .description a {
			color: <?php echo $portfolio_category_color; ?>;
		}
		
		/* projects */
		.bg--wrapper.bg-projects-wrapper .bg--item .bg-item-inner:before {
			background: <?php echo $projects_bg; ?>;
		}
		.bg--wrapper.bg-projects-wrapper .bg--item:hover .bg-item-inner:before {
			background: <?php echo $projects_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-projects-wrapper.bears1 .bg--item .info {
			background: <?php echo $projects_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-projects-wrapper.bears1 .bg--item:hover .bg-item-inner:before {
			background: transparent !important;
		}
		.bg--wrapper.bg-projects-wrapper .info .heading a {
			color: <?php echo $projects_title_color; ?>;
		}
		.bg--wrapper.bg-projects-wrapper .bg--item .description,
		.bg-wrapper.bg-projects-wrapper .bg--item .info .description a {
			color: <?php echo $projects_category_color; ?>;
		}
		
		/* gallery */
		.bg--wrapper.bg-gallery-wrapper .bg--item .bg-item-inner:before {
			background: <?php echo $gallery_bg; ?>;
		}
		.bg--wrapper.bg-gallery-wrapper .bg--item:hover .bg-item-inner:before {
			background: <?php echo $gallery_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-gallery-wrapper.bears1 .bg--item .info {
			background: <?php echo $gallery_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-gallery-wrapper.bears1 .bg--item:hover .bg-item-inner:before {
			background: transparent !important;
		}
		
		/* team */
		.bg--wrapper.bg-team-wrapper .bg--item .bg-item-inner:before {
			background: <?php echo $team_bg; ?>;
		}
		.bg--wrapper.bg-team-wrapper .bg--item:hover .bg-item-inner:before {
			background: <?php echo $team_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-team-wrapper.bears1 .bg--item .info {
			background: <?php echo $team_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-team-wrapper.bears1 .bg--item:hover .bg-item-inner:before {
			background: transparent !important;
		}
		.bg--wrapper.bg-team-wrapper .info .heading a {
			color: <?php echo $team_name_color; ?>;
		}
		.bg--wrapper.bg-team-wrapper .bg--item .description,
		.bg--wrapper.bg-team-wrapper .bg--item .info .description a {
			color: <?php echo $team_position_color; ?>;
		}
		
		/* instagram */
		.bg--wrapper.bg-instagram-wrapper .bg--item .bg-item-inner:before {
			background: <?php echo $instagram_bg; ?>;
		}
		.bg--wrapper.bg-instagram-wrapper .bg--item:hover .bg-item-inner:before {
			background: <?php echo $instagram_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-instagram-wrapper.bears1 .bg--item .info {
			background: <?php echo $instagram_bg_hover; ?> !important;
		}
		.bg--wrapper.bg-instagram-wrapper.bears1 .bg--item:hover .bg-item-inner:before {
			background: transparent !important;
		}
		
		<?php 
		$css = ob_get_contents();
		ob_clean();
		ob_end_flush();
		
		return $css;
	}
	
endif;

if ( ! function_exists( '_get_posts' ) ):
	
	function _get_posts( $args = null ) {
		$defaults = array(
			'sort'                => 'recent',
			'items'               => 5,
			'post_by_id'		  => array(),
			'image_post'          => true,
			'return_image_tag'    => true,
			'return_for_alone_image' => false,
			'image_size'		  => 'large',
			'image_width'         => 54,
			'image_height'        => 54,
			'image_class'         => 'thumbnail',
			'date_post'           => true,
			'date_format'         => 'F jS, Y',
			'date_query'          => array(),
			'post_type'           => 'post',
			'category'            => '',
			'excerpt_length'      => 40,
			'offset'			  => 0,
		);

		extract( wp_parse_args( $args, $defaults ) );
		global $post;
		$fw_cat_ID = ( ! empty( $category ) ) ? $category : '';
		
		if ( $sort == 'recent' ) {
			$query = new WP_Query( array(
				'post_type'      => $post_type,
				'orderby'        => 'post_date',
				'order '         => 'DESC',
				'cat'            => $fw_cat_ID,
				'posts_per_page' => $items,
				'date_query'     => $date_query,
				'offset'		 => $offset,
			) );
			$posts = $query->get_posts();
		} elseif ( $sort == 'popular' ) {
			$query = new WP_Query( array(
				'post_type'      => $post_type,
				'orderby'        => 'meta_value',
				'meta_key'       => 'fw_post_views',
				'order '         => 'DESC',
				'cat'            => $fw_cat_ID,
				'posts_per_page' => $items,
				'date_query'     => $date_query,
				'offset'				 => $offset,
			) );
			$posts = $query->get_posts();
		} elseif ( $sort == 'commented' ) {
			$query = new WP_Query( array(
				'post_type'      => $post_type,
				'orderby'        => 'comment_count',
				'order '         => 'DESC',
				'cat'            => $fw_cat_ID,
				'posts_per_page' => $items,
				'date_query'     => $date_query,
				'offset'				 => $offset,
			) );
			$posts = $query->get_posts();
		} elseif ( $sort == 'by_id' ) {
			$query = new WP_Query( array(
				'post_type'      => $post_type,
				'orderby'        => 'post_date',
				'order '         => 'DESC',
				'cat'            => $fw_cat_ID,
				'posts_per_page' => $items,
				'date_query'     => $date_query,
				'offset'				 => $offset,
				'post__in'       => $post_by_id,
			) );
			$posts = $query->get_posts();
		} else {
			return false;
		}
		// echo '<pre>'; print_r($query); echo '</pre>';
		$fw_post_option = array();
		$alone_count          = 0;
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post_elm ) {
				setup_postdata( $post_elm );
				$img = '';

				if ( $image_post == true ) {
					$post_thumbnail_id 	= get_post_thumbnail_id( $post_elm->ID );
					$post_thumbnail    	= wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
					$image 							= $post_thumbnail[0];

					if ( ! empty( $post_thumbnail ) ) {
						$img = function_exists('fw_resize') ? fw_resize( $post_thumbnail[0], $image_width, $image_height, true ) : $post_thumbnail[0];
						if ( $return_for_alone_image ) {
							$img = array(
								'attachment_id' => $post_thumbnail_id,
								'url'           => $post_thumbnail[0],
							);
						} elseif ( $return_image_tag ) {
							$img = '<img src="' . $image . '" class="' . $image_class . '" alt="' . get_the_title( $post_thumbnail_id ) . '" width="' . $image_width . '" height="' . $image_height . '" />';
						}
					}
				}

				if ( ! empty( $img ) ) {
					$fw_post_option[ $alone_count ]['post_img'] = $img;
				} else {
					$fw_post_option[ $alone_count ]['post_img'] = '';
				}

				if ( $date_post ) {
					$time_format                                = apply_filters( '_filter_widget_time_format', $date_format );
					$fw_post_option[ $alone_count ]['post_date_post'] = get_the_time( $time_format, $post_elm->ID );
				} else {
					$fw_post_option[ $alone_count ]['post_date_post'] = '';
				}

				$fw_post_option[ $alone_count ]['post_id']        		= $post_elm->ID;
				$fw_post_option[ $alone_count ]['post_class']        = ( is_singular() && $post->ID == $post_elm->ID ) ? 'current-menu-item post_' . $sort : 'post_' . $sort;
				$fw_post_option[ $alone_count ]['post_title']        = get_the_title( $post_elm->ID );
				$fw_post_option[ $alone_count ]['post_link']         = get_permalink( $post_elm->ID );
				$fw_post_option[ $alone_count ]['post_author_link']  = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$fw_post_option[ $alone_count ]['post_author_name']  = get_the_author();
				$fw_post_option[ $alone_count ]['post_comment_numb'] = get_comments_number( $post_elm->ID );
				$fw_post_option[ $alone_count ]['post_excerpt']      = ( isset( $post ) ) ? get_the_excerpt() : '';
				$alone_count ++;
			}
			wp_reset_postdata();
			wp_reset_query();
		}

		return $fw_post_option;
	}
endif;

if(! function_exists('_get_uploaded_images')) :
	function _get_uploaded_images($images) {
		
		ob_start();	
		foreach ( $images as $k => $image ) {
			$image_url = wp_get_attachment_image_src($image, 'bg-image-square-medium', true);
			?>
			<li class="bg-item bg-image-item" data-id="<?php echo $image; ?>">
			  <div class="bg-image-thumb">
				  <div class="bg-image-content">
					<div class="centered">
						<img src="<?php echo $image_url[0]; ?>">
					</div>
				  </div>
			  </div>
			  <div class="bg-overlay"></div>
			  <div class="bg-image-action-bar">
				  <a class="bg-image-action bg-delete-file" href="#" data-attachment_id="<?php echo $image; ?>"><span class="dashicons dashicons-no-alt"></span></a>
			  </div>
		   </li>
			<?php
		}
		$html = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $html;
	}
endif;

if(! function_exists('_get_uploaded_files')) :
	function _get_uploaded_files($files) {
		
		ob_start();	
		foreach ( $files as $k => $file ) {
			$mime_type   = get_post_mime_type( $file );
			$file_icon = _get_icon_mime_type( $mime_type);
			$file_link = wp_get_attachment_url( $file );
			$file_title = get_the_title( $file );
			?>
			<li class="bg-item bg-file-item" data-id="<?php echo $file; ?>">
				<div class="bg-file-icon">
						<div class="bg-file-content">
					  <div class="centered">
						<img src="<?php echo $file_icon; ?>">
					  </div>
					</div>
				</div>
				<div class="bg-file-info">
						<h6><a href="<?php echo $file_link; ?>" target="_blank"><?php echo $file_title; ?></a></h6>
						<p><?php echo $mime_type; ?></p>
						<a class="bg-file-action bg-delete-file" href="#" data-attachment_id="<?php echo $file; ?>"><span class="dashicons dashicons-no-alt"></span><?php echo __( 'Remove', 'bears-grid' ); ?></a>
				</div>
			</li>
			<?php
		}
		$html = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $html;
	}
endif;

if(! function_exists('_get_icon_mime_type')) :
	function _get_icon_mime_type($file) {
		$extention = explode('/', $file);
		$url = 'assets/images/icon/'.$extention[1].'.png';

		if(file_exists(BG_DIR_PATH . $url)) {
			$icon = BG_DIR_URL . $url;
		} else {
			$icon = BG_DIR_URL . 'assets/images/file.png';
		}

		return $icon;
	}
endif;

if(! function_exists('_render_social_item')) :
	function _render_social_item($id = '', $number = 0, $value = array()) {
		$icon_id = ($number == 0) ? $id . '_icon' : $id . '_icon_' . $number;
		$icon_name = $id . '[' . $number . ']' . '[bg_social_icon]';
		
		$link_id = ($number == 0) ? $id . '_link' : $id . '_link_' . $number;
		$link_name = $id . '[' . $number . ']' . '[bg_social_link]';
		
		$icon_val = '';
		$link_val = '';
		
		if($value){
			$icon_val = $value['bg_social_icon'];
			$link_val = $value['bg_social_link'];
		}
		
		ob_start();	
		?>
		<div class="bg-addmore-item">
			<a href="#" class="bg-addmore-drag"><span class="dashicons dashicons-leftright"></span></a>
			<div class="bg-addmore-content">
				<div class="bg-addmore-field bg-col-3">
					<label for="<?php echo $icon_id; ?>" class="bg-label"><?php echo __( 'Icon', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input id="<?php echo $icon_id; ?>" class="bg-field bg-input" name="<?php echo $icon_name; ?>" value="<?php echo $icon_val; ?>">
					</div>
				</div>
				<div class="bg-addmore-field bg-col-9">
					<label for="<?php echo $link_id; ?>" class="bg-label"><?php echo __( 'Link', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input id="<?php echo $link_id; ?>" class="bg-field bg-input" name="<?php echo $link_name; ?>" value="<?php echo $link_val; ?>">
					</div>
				</div>
			</div>
			<a href="#" class="bg-addmore-remove"><span class="dashicons dashicons-trash"></span></a>
		</div>
		<?php
		$html = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $html;
	}
endif;

if(! function_exists('_render_meta_item')) :
	function _render_meta_item($id = '', $number = 0, $value = array()) {
		$title_id = ($number == 0) ? $id . '_title' : $id . '_title_' . $number;
		$title_name = $id . '[' . $number . ']' . '[bg_meta_title]';
		
		$meta_value_id = ($number == 0) ? $id . '_value' : $id . '_value_' . $number;
		$meta_value_name = $id . '[' . $number . ']' . '[bg_meta_value]';
		
		$title_val = '';
		$meta_value_val = '';
		
		if($value){
			$title_val = $value['bg_meta_title'];
			$meta_value_val = $value['bg_meta_value'];
		}
		
		ob_start();	
		?>
		<div class="bg-addmore-item">
			<a href="#" class="bg-addmore-drag"><span class="dashicons dashicons-leftright"></span></a>
			<div class="bg-addmore-content">
				<div class="bg-addmore-field bg-col-4">
					<label for="<?php echo $title_id; ?>" class="bg-label"><?php echo __( 'Title', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input id="<?php echo $title_id; ?>" class="bg-field bg-input" name="<?php echo $title_name; ?>" value="<?php echo $title_val; ?>">
					</div>
				</div>
				<div class="bg-addmore-field bg-col-8">
					<label for="<?php echo $meta_value_id; ?>" class="bg-label"><?php echo __( 'Value', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input id="<?php echo $meta_value_id; ?>" class="bg-field bg-input" name="<?php echo $meta_value_name; ?>" value="<?php echo $meta_value_val; ?>">
					</div>
				</div>
			</div>
			<a href="#" class="bg-addmore-remove"><span class="dashicons dashicons-trash"></span></a>
		</div>
		<?php
		$html = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $html;
	}
endif;

if(! function_exists('_render_skills_item')) :
	function _render_skills_item($id = '', $number = 0, $value = array()) {
		$skill_id = ($number == 0) ? $id . '_name' : $id . '_name_' . $number;
		$skill_name = $id . '[' . $number . ']' . '[bg_skill_name]';
		
		$skill_level_id = ($number == 0) ? $id . '_level' : $id . '_level_' . $number;
		$skill_level = $id . '[' . $number . ']' . '[bg_skill_level]';
		
		$skill_color = $id . '[' . $number . ']' . '[bg_skill_color]';
		
		$skill_name_val = '';
		$skill_level_val = '';
		$skill_color_val = '';
		
		if($value){
			$skill_name_val = $value['bg_skill_name'];
			$skill_level_val = $value['bg_skill_level'];
			$skill_color_val = $value['bg_skill_color'];
		}
		
		ob_start();	
		?>
		<div class="bg-addmore-item">
			<a href="#" class="bg-addmore-drag"><span class="dashicons dashicons-leftright"></span></a>
			<div class="bg-addmore-content">
				<div class="bg-addmore-field bg-col-4">
					<label for="<?php echo $skill_id; ?>" class="bg-label"><?php echo __( 'Skill', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input id="<?php echo $skill_id; ?>" class="bg-field bg-input" name="<?php echo $skill_name; ?>" value="<?php echo $skill_name_val; ?>">
					</div>
				</div>
				<div class="bg-addmore-field bg-col-3">
					<label for="<?php echo $skill_level_id; ?>" class="bg-label"><?php echo __( 'Level', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<input type="number" id="<?php echo $skill_level_id; ?>" class="bg-field bg-input" name="<?php echo $skill_level; ?>" value="<?php echo $skill_level_val; ?>" step="0.5" min="0.5" max="10">
					</div>
				</div>
				<div class="bg-addmore-field bg-col-5">
					<label class="bg-label"><?php echo __( 'Color', 'bears-grid' ); ?></label>
					<div class="bg-col-12">
						<div class="bg-color-views">
							<input class="bg-field bg-color" name="<?php echo $skill_color; ?>" value="<?php esc_attr_e($skill_color_val); ?>">
						</div>
					</div>
				</div>
			</div>
			<a href="#" class="bg-addmore-remove"><span class="dashicons dashicons-trash"></span></a>
		</div>
		<?php
		$html = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $html;
	}
endif;

if(!function_exists('_filter_nav_render')) :
	/**
 	 * extend
 	 */
	function _filter_nav_render($atts) {
		$cats = get_terms( $atts['cat'], array(
			'hide_empty' => false,
			'orderby' => 'name',
            'order' => 'DESC',
		) );

		$nav_item = array();
		$nav_item[] = "<li><a href='javascript:void(0);' class='filter-item is-active' data-cat='*'>". __( 'All', 'bears-grid' ) ."</a></li>";
		foreach($cats as $cat) :
			$nav_item[] = "<li><a href='javascript:void(0);' class='filter-item' data-cat='". $cat->term_id ."'>". $cat->name ."</a></li>";
		endforeach;
 
		$filter_nav_html = array('<ul class="bg--filter '. $atts['filter_style'] .'" style="text-align: '. $atts['filter_align'] .'; margin: '. $atts['filter_margin'] .'" >');
		$filter_nav_html[] = implode('', $nav_item);
		$filter_nav_html[] = '</ul>';

		return implode('', $filter_nav_html); 
	}
endif;

if(!function_exists('_get_file_path_by_post_type')) :
	/**
 	 * extend
 	 */
	function _get_file_path_by_post_type($post_type) {
		if( file_exists( get_stylesheet_directory() . '/single-' . $post_type ) ) {
			$filepath = get_stylesheet_directory() . '/single-' . $post_type;
		} else {
			$file_name = str_replace('bg_', '', $post_type);
			$filepath = BG_DIR_PATH . 'templates/single/' . $file_name . '.php';
		}
		
		return $filepath;
	}
endif;