<?php 
extract( $atts );
unset( $atts );

$cates = wp_get_post_terms( $id, $post_type . '_category', array( 'fields' => 'ids' ) );


$args = array(
	'post_type' => $post_type,
	'posts_per_page' => $posts_per_page,
	'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => $post_type . '_category',   
			'field'    => 'term_id',
			'terms'    => $cates,
			'operator' => 'IN',
		),
	),
	'post__not_in' => array($id),
);

$query = new WP_Query($args);
?>
<div class="bg-single-related">
	<?php
	if( $title ) {
		?>
		<h3 class="bg-title"><?php echo $title; ?></h3>
		<?php
	}
	?>
	<div class="bg-row">
		<?php
		if ( $query->have_posts() ) :
			
			while ( $query->have_posts() ) : $query->the_post(); 
				$img = get_the_post_thumbnail_url( get_the_ID(), 'bg-image-medium' );
				$categories = get_the_term_list( get_the_ID(),  $post_type . '_category', '', ', ' );
				?>
				<div class="bg-d-col-4 bg-t-col-6 bg-m-col-12">
					<div class="bg-related-item">
						<div class="bg-thumb" style="background: url(<?php echo $img; ?>) no-repeat center center / cover, #333;"></div>
						<div class="bg-overlay">
							<div class="bg-content">
								<h3 class="bg-title">
									<a href="<?php echo get_post_permalink( get_the_ID() ); ?>">
										<?php echo  get_the_title(); ?>
									</a>
								</h3>
								<div class="bg-term"><?php echo $categories; ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php 
			endwhile; 
			
			wp_reset_postdata(); 
			
		endif;

		?>
		<div class="bg-clear"></div>
	</div>
</div>