<?php 
$terms = get_the_term_list( $_data['id'] , 'bg_team_position' , '' , ' . ' , '' );
$socials = get_post_meta( $_data['id'], 'bg_team_social', true );

?>
<div class="<?php echo $class; ?>" style="<?php echo $_data['style']; ?>">
	<div class="bg-item-inner" style="height: <?php echo $_height; ?>;">
		<div class="thumb" style="background-image: url(<?php echo $_data['img']; ?>);"></div>
		<div class="info">
			<h3 class="heading"><a href="<?php echo $_data['permalink']; ?>"><?php echo $_data['title']; ?></a></h3>
			<div class="description"><?php echo $terms; ?></div>
			<?php do_action( '_single_meta_box_action', $_data['id'], $post_type, 'skills', true ); ?>
			<div class="member-social">
				<?php
					foreach($socials as $social) {
						$icon = '';
						if ( strpos($social['bg_social_icon'], 'facebook') !== false ) {
							$icon = 'facebook';
						} else if ( strpos($social['bg_social_icon'], 'twitter') !== false ) {
							$icon = 'twitter';
						} else if ( strpos($social['bg_social_icon'], 'google') !== false ) {
							$icon = 'google';
						} else if ( strpos($social['bg_social_icon'], 'linkedin') !== false ) {
							$icon = 'linkedin';
						} else if ( strpos($social['bg_social_icon'], 'instagramm') !== false ) {
							$icon = 'instagramm';
						} else if ( strpos($social['bg_social_icon'], 'youtube') !== false ) {
							$icon = 'youtube';
						}
						?>
						<a href="<?php echo $social['bg_social_link']; ?>" class="<?php echo $icon; ?>" target="_blank"><i class="<?php echo $social['bg_social_icon']; ?>"></i></a>
						<?php
					}
				?>
			</div>
		</div>
		<div class="bg-overlay"></div>
	</div>
</div>