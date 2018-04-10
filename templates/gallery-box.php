<div class="bg-single-gallery bg-light-gallery">
	<?php 
		if( $post_type == 'bg_gallery' ) {
			$galleries_id = get_post_meta( get_the_ID() , 'bg_gallery_data', true );
			$galleries_col = get_post_meta( get_the_ID() , 'bg_gallery_columns', true );
			$galleries_space = get_post_meta( get_the_ID() , 'bg_gallery_space', true );
		} else if( $post_type == 'bg_team' ) {
			$galleries_id = get_post_meta( $id , $post_type . '_gallery', true );
			$galleries_col = 'bg-col-6';
			$galleries_space = 20;
		} else {
			$galleries_id = get_post_meta( $id , $post_type . '_gallery', true );
			$galleries_col = get_post_meta( $id , $post_type . '_gallery_columns', true );
			$galleries_space = get_post_meta( $id , $post_type . '_gallery_space', true );
		}
		
		$galleries = explode(",",$galleries_id); 
		
		$space = ((int)$galleries_space/2);

		$column = '';
		switch($galleries_col) {
			case 'bg-col-2':
				$column = 'bg-d-col-2 bg-t-col-6 bg-m-col-12';
				break;
				
			case 'bg-col-3':
				$column = 'bg-d-col-3 bg-t-col-6 bg-m-col-12';
				break;
				
			case 'bg-col-4':
				$column = 'bg-d-col-4 bg-t-col-6 bg-m-col-12';
				break;
				
			case 'bg-col-6':
				$column = 'bg-d-col-6 bg-t-col-6 bg-m-col-12';
				break;
					
			default:
				$column = 'bg-d-col-12 bg-t-col-12 bg-m-col-12';
				break;
		}
		foreach ($galleries as $gallery) {
			$src = wp_get_attachment_image_src( $gallery, 'bg-image-large');
			?>
			<div class="bg-gallery-item <?php echo $column; ?>" style="padding:<?php echo $space; ?>px;" data-src="<?php echo $src[0]; ?>" data-sub-html=""> 
				<div class="bg-gallery-item-inner">
					<a href=""><?php echo wp_get_attachment_image( $gallery, 'bg-image-medium' ) ;?></a>
				</div>
			</div>
			
			<?php
		}
	?>
</div>