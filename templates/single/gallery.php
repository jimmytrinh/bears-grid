<?php get_header(); ?>

	<div class="bg-single-wrap">
		<div class="bg-container">
			<div class="bg-row">
				<?php while ( have_posts() ) : the_post();
					
					$atts = array(
						'id' => get_the_ID(),
						'post_type' => get_post_type(),
					);
					
					?>
					<div class="bg-single">
						<div class="bg-d-col-12 bg-t-col-12 bg-m-col-12 bg-single-content">
							<h3 class="bg-title"><?php echo get_the_title(get_the_ID()); ?></h3>
							<?php
								$categories = get_the_term_list( $id, $post_type . '_category', '', ',  ' );
							?>
							<div class="bg-term"><?php echo $categories; ?></div>
						</div>
						<div class="bg-d-col-12 bg-t-col-12 bg-m-col-12">
							<div class="bg-row">
								<?php do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'gallery' ); ?>
							</div>
						</div>
						<div class="bg-clear"></div>
					</div>
					
					<?php //_render_view(BG_DIR_PATH . 'templates/single/_related.php', array('atts' => $atts, 'title' => __('Gallery Related', 'bears-grid')), false); ?>
				
				<?php endwhile; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>