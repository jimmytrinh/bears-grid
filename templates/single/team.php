<?php get_header(); ?>

	<div class="bg-single-wrap bg-single-team">
		<div class="bg-container">
			<div class="bg-row">
				<?php while ( have_posts() ) : the_post();
					$layout = get_post_meta(get_the_ID(), 'bg_team_single_layout', true);
					$layout = str_replace('_', '-', $layout);
					
					$atts = array(
						'id' => get_the_ID(),
						'post_type' => get_post_type(),
					);
					
					?>
					<div class="bg-single bg-single-<?php echo $layout; ?>">
						<?php _render_view(BG_DIR_PATH . 'templates/layout/'.$layout.'.php', array('atts' => $atts), false); ?>
						<div class="bg-clear"></div>
					</div>
				
				<?php endwhile; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>