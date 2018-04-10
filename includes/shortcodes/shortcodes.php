<?php 
$sc = str_replace('bg_', '', $post_type);

$class = 'bg--item bg-gallery-item ';

$unit = BG_UNIT;

$_space = ($space) . $unit;
$width = 'calc((100% - '.(($column-1)*$_space).$unit.') / '.$column.')';

$datas = array();
$next_max_id = '';
$next_url = '';

$tpl_class = ( $sc == 'projects' || $sc == 'portfolio' ) ? ' bg-pp-wrapper' : ' bg-' . $sc . '-wrapper';

$wrap_class = 'bg--wrapper';
$wrap_class .= ' bg-' . $sc . '-wrapper';
$wrap_class .= ' bg-' . $type . '-wrapper';
$wrap_class .= $tpl_class; 
$wrap_class .= ' ' . $tpl ;
$wrap_class .= ' ' . $hover ;
$wrap_class .= ' ' . $css_class ;

//set boolean value
$light_box = ($light_box && $light_box !== 'false') ? true : false;
$filter = ($filter === 'false') ? false : true;
$more = ($more === 'false') ? false : true;
$dots = ($dots === 'false') ? false : true;
$autoplay = ($autoplay && $autoplay !== 'false') ? true : false;
$autoplayHoverPause = ($autoplayHoverPause === 'false') ? false : true;

$atts = array(
	'post_type' => $post_type,
	'cat'   	=> ($sc == 'team') ? $post_type . '_position' : $post_type . '_category',
	'number'	=> $number,
	'type'		=> $type,
	'height'	=> $height,
	'width'		=> $width,
	'class'		=> $class,
	'light_box'	=> $light_box,
	'unit'		=> $unit,
	'space'		=> $_space,
	'column'	=> $column,
	'tpl'		=> $tpl,
	'filter_style'		=> $filter_style,
	'filter_align'		=> $filter_align,
	'filter_margin'		=> $filter_margin,
	'sc'		=> $sc,
	'autoplay'	=> $autoplay,
	'dots'		=> $dots,
	'autoplayTimeout'	=> $autoplayTimeout,
	'autoplaySpeed'		=> $autoplaySpeed,
	'autoplayHoverPause'  => $autoplayHoverPause,
);

?>
<div id="<?php echo $el_id; ?>" class="<?php echo $wrap_class; ?>" data-atts='<?php echo json_encode($atts); ?>'>
	<?php
	if( ! empty($title) ){
		?>
		<h2 class="title"><?php echo $title; ?></h2>
		<?php
	}
	
	if( $id != '' ) {
		if( $post_type != 'bg_gallery' ) {
			$galleries_id = get_post_meta( $id , $post_type . '_gallery', true );
		} else {
			$galleries_id = get_post_meta( $id , 'bg_gallery_data', true );
		}
		
		$galleries = explode(",",$galleries_id); 

		$query = get_post( $id, ARRAY_A );

		foreach ($galleries as $gallery) {
			$data = array();
			
			$img = wp_get_attachment_image_src( $gallery, 'bg-image-large');
			
			$data['id'] = $query['ID'];
			$data['title'] = $query['post_title'];
			$data['img'] = $img[0];
			$data['class'] = $class;
			$data['style'] = 'padding-bottom: ' . $_space . '; width: ' . $width;
			$data['content'] = '';
			$data['permalink'] = get_post_permalink($query['ID']);
					
			$datas[] = $data;
		}
		
	} else {
		if( $post_type == 'bg_instagram' ) {
			$instagram = new InstagramAPI();
			
			$token = get_option( 'bg_instagram_access_token_option');
			
			$medias = $instagram->getUserMedia($token, $number);
			
			if( isset($medias->pagination->next_max_id) ){
				$next_max_id = $medias->pagination->next_max_id;
				$next_url = $medias->pagination->next_url;
			} else {
				$more = false;
			}
			
			foreach( $medias->data as $media ) {
				$data = array();
					
				$ista_id = $media->id;
				
				$img = $media->images->standard_resolution->url;
				$link = $media->link;
				$like = $media->likes->count;
				$comment = $media->comments->count;
				$created_time = $media->created_time;
				
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
					'created_time' => _get_time_diff($created_time),
				);
				
				$datas[] = $data;
			}
			
		} else {
			$args = array(
				'post_type' 		=> $post_type,
				'posts_per_page' 	=> $number,
			);
			
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
					$data['style'] = 'padding-bottom: ' . $_space . '; width: ' . $width;
					$data['content'] = get_the_excerpt();
					$data['permalink'] = get_post_permalink();
					
					$datas[] = $data;
					
				endwhile;
				wp_reset_postdata();
				wp_reset_query();

			endif;
		}
	}
	
	/* filter */
	if( $id == '' && $filter &&  $post_type != 'bg_instagram' ){
		echo _filter_nav_render($atts);
	}
	
	$_class = ( $light_box || $post_type == 'bg_gallery' ) ? 'bg-light-gallery' : '';
	$_class .= ( $type == 'masonry' || $type == 'grid' ) ? ' bg-masonry-items' : '';
	$_class .= ( $type == 'carousel' ) ? ' bg-owl-carousel' : '';
	
	?>
	<div class="bg--items <?php echo $_class; ?>">
		<?php 
			if($type != 'carousel'){
				?>
				<div class="grid-sizer" style="width: <?php echo $width; ?>;"></div> 
				<div class="gutter-sizer" style="width: <?php echo $_space; ?>;"></div>
				<?php
			}
		
			include BG_INC_PATH . 'shortcodes/layout/' . $type . '.php'; 
		?>
	</div>
	<div class="bg--actions">
		<div class="loading"></div>
		<?php 
			if($number != '-1' && $id == '' && $type != 'carousel' && $more){
				$more_class = ($post_type == 'bg_instagram') ? 'load-more-instagram' : 'load-more-post';
				?>
				<div class="load-more <?php echo $more_class; ?>" data-offset="<?php echo $number; ?>" data-nextid='<?php echo $next_max_id; ?>' data-nexturl='<?php echo $next_url; ?>'><?php echo __( 'Load more', 'bears-grid' ); ?></div>
				<?php
			}
		?>
	</div>
	<div class="bg-popup-wrapper">
		<a href="#" class="bg-popup-close">
			<svg viewBox="0 0 64 64">
				<path d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"/>
			</svg>
		</a>
		<div clas="bg-popup-inner">
			<div class="bg-popup-media" style="background-image: url(<?php echo BG_DIR_URL ?>assets/images/16x9.png)"></div>
			<div class="bg-popup-info">
				<div class="bg-popup-info-head">
					<div class="bg-popup-info-user">
						<div class="bg-popup-info-user-image">
							<a href="" title="" target="_blank" rel="nofollow">
								<img src="" alt="">
							</a>
						</div>
						<div class="bg-popup-info-user-name">
							<a href="" title="" target="_blank" rel="nofollow"></a>
						</div>
					</div>
					<div class="bg-popup-info-user-actions">
						<a class="bg-instagram-follow" href="" target="_blank">Follow</a>
					</div>
					<div class="bg-popup-info-feed"> 
						<a class="bg-instagram-likes" href="" target="_blank">
							<svg viewBox="0 0 24 24">
								<path d="M17.7,1.5c-2,0-3.3,0.5-4.9,2.1c0,0-0.4,0.4-0.7,0.7c-0.3-0.3-0.7-0.7-0.7-0.7c-1.6-1.6-3-2.1-5-2.1C2.6,1.5,0,4.6,0,8.3
								c0,4.2,3.4,7.1,8.6,11.5c0.9,0.8,1.9,1.6,2.9,2.5c0.1,0.1,0.3,0.2,0.5,0.2s0.3-0.1,0.5-0.2c1.1-1,2.1-1.8,3.1-2.7
								c4.8-4.1,8.5-7.1,8.5-11.4C24,4.6,21.4,1.5,17.7,1.5z M14.6,18.6c-0.8,0.7-1.7,1.5-2.6,2.3c-0.9-0.7-1.7-1.4-2.5-2.1
								c-5-4.2-8.1-6.9-8.1-10.5c0-3.1,2.1-5.5,4.9-5.5c1.5,0,2.6,0.3,3.8,1.5c1,1,1.2,1.2,1.2,1.2C11.6,5.9,11.7,6,12,6.1
								c0.3,0,0.5-0.2,0.7-0.4c0,0,0.2-0.2,1.2-1.3c1.3-1.3,2.1-1.5,3.8-1.5c2.8,0,4.9,2.4,4.9,5.5C22.6,11.9,19.4,14.6,14.6,18.6z"></path>
							</svg>
							<span></span>
						</a>
						<a class="bg-instagram-comments" href="" target="_blank">
							<svg viewBox="0 0 24 24">
								<path d="M1,11.9C1,17.9,5.8,23,12,23c1.9,0,3.7-1,5.3-1.8l5,1.3l0,0c0.1,0,0.1,0,0.2,0c0.4,0,0.6-0.3,0.6-0.6c0-0.1,0-0.1,0-0.2
								l-1.3-4.9c0.9-1.6,1.4-2.9,1.4-4.8C23,5.8,18,1,12,1C5.9,1,1,5.9,1,11.9z M2.4,11.9c0-5.2,4.3-9.5,9.5-9.5c5.3,0,9.6,4.2,9.6,9.5
								c0,1.7-0.5,3-1.3,4.4l0,0c-0.1,0.1-0.1,0.2-0.1,0.3c0,0.1,0,0.1,0,0.1l0,0l1.1,4.1l-4.1-1.1l0,0c-0.1,0-0.1,0-0.2,0
								c-0.1,0-0.2,0-0.3,0.1l0,0c-1.4,0.8-3.1,1.8-4.8,1.8C6.7,21.6,2.4,17.2,2.4,11.9z"></path>
							</svg>
							<span></span>
						</a>
						<a class="bg-instagram-created-time" href="" target="_blank"></a>
					</div>
				</div>
				<div class="bg-popup-info-comments"></div>
			</div>
		</div>
	</div>
	<div class="bg-popup-overlay"></div>
</div>